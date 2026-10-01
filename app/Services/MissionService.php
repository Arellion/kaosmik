<?php
namespace App\Services;

use App\Entities\MissionHero;
use App\Entities\MissionResolution;
use App\Models\MissionHeroModel;
use Exception;

class MissionService
{
    protected $missionModel;
    protected $playerModel;
    protected $heroModel;

    public function __construct()
    {
        $this->missionModel = model("MissionModel");
        $this->playerModel = model("PlayerModel");
        $this->heroModel = model("HeroModel");
    }

    public function processMission($player, int $missionId, array $heroesIds)
    {
        $mission = $this->missionModel->find($missionId);
        if(!$mission) {
            throw new Exception("Mission introuvable");
        }
        if(empty($heroesIds)) {
            throw new Exception("Aucune héro sélectionné");
        }
        $heroes = $this->heroModel->where('player_id', $player->id)->whereIn('id', $heroesIds)->findAll();

        if(count($heroes) !== count($heroesIds)) {
            throw new Exception('Un ou plusieurs héro ne sont pas à vous.');
        }

        $this->validateSquad($mission, $heroes);

        $reward = $this->calculateReward($mission);

        $reward['heroes'] = $this->applyEffect($player, $heroes, $mission, $reward);

        return $reward;
    }

    private function validateSquad($mission, array $heroes)
    {
        $totalPower = 0;
        $squadSpecIds = array();
        $staminaRequired = (int) $mission->getStaminaRequired();
        foreach ($heroes as $hero) {
            if((int) $hero->stamina_current < $staminaRequired ) {
                throw new Exception("Le héro {$hero->name} n'a pas suffisamment d'endurance");
            }

            $totalPower += (int) $hero->power;

            $spec = $hero->getHeroModel()->getSpecialization();
            if($spec) {
                $squadSpecIds[] = (int) $spec['id'];
            }
        }

        if($totalPower < (int) $mission->getPowerRequired()) {
            throw new Exception('La puissance de votre escouade est bien trop faible.');
        }

        $requiredSpec = $mission->getSpecializations();
        if(!empty($requiredSpec)) {
            foreach ($requiredSpec as $spec) {
                $SpecId = (int) $spec['id'];
                if(!in_array($SpecId, $squadSpecIds)) {
                    throw new Exception("L'escouade ne possede pas les bonne spécialisations");
                }
            }
        }
    }

    private function calculateReward($mission)
    {
        $creditGain = (int) mt_rand((int) $mission->credits_reward_min, (int) $mission->credits_reward_max);
        $energieGain = (int) mt_rand((int) $mission->energy_reward_min, (int) $mission->energy_reward_max);
        $xpGain = (int) mt_rand((int) $mission->experience_reward_min, (int) $mission->experience_reward_max);

        return [
            'credits' => $creditGain,
            'energy' => $energieGain,
            'xp' => $xpGain,
        ];
    }

    private function applyEffect($player, array $heroes, $mission, $reward)
    {
        $staminaRequired = (int) $mission->getStaminaRequired();

        //Historique Global de la mission
        $missionResolutionModel = model("MissionResolutionModel");
        $missionHeroModel = model("MissionHeroModel");
        $mr = new MissionResolution();
        $mr->credits_gained = $reward['credits'];
        $mr->energy_gained = $reward['energy'];
        $mr->experience_gained = $reward['xp'];
        $mr->mission_id = $mission->id;
        $mr->player_id = $player->id;
        $mr->success = true;
        $id_mr = $missionResolutionModel->insert($mr);

        foreach ($heroes as $hero) {
            $newStamina = max(0, $hero->stamina_current - $staminaRequired);
            $hero->stamina_current = $newStamina;
            //Sauvegarde de la modification du héro (stamina)
            $this->heroModel->update($hero->id, ['stamina_current' => $newStamina, 'last_stamina_update' => date('Y-m-d H:i:s')]);

        }

        //Sauvegarde des modifications du joueur (récompense)
        $player->credits += $reward['credits'];
        $player->fusion_energy += $reward['energy'];
        $player->experience += $reward['xp'];
        $this->playerModel->save($player);

        return $heroes;

    }
}