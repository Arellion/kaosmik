<?php

namespace App\Entities;

use App\Models\LevelThresholdModel;
use CodeIgniter\Entity\Entity;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;


class Player extends Entity
{
//    protected $datamap = []; pas besoin  c'est pour renommer comme le AS

    protected $attributes= [
        'id' => null,
        'user_id' => null,
        'level' => 1,
        'experience' => 0,
        'credits' => 1000,
        'fusion_energy' => 0,
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id' => 'integer',
        'user_id' => 'integer',
        'level' => 'integer',
        'experience' => 'integer',
        'credits' => 'integer',
        'fusion_energy' => 'integer',
    ];
    protected ?User $user = null;

    public function getUser(): ?User
    {
        if ($this->user === null && !empty($this->attributes['user_id'])) {
            $userModel = model(UserModel::class);
            $this->user = $userModel->find($this->attributes['user_id']);
        }
        return $this->user;
    }
    public function setUser(User $user): self
    {
        $this->user = $user;
        $this->attributes['user_id'] = $user->id;

        return $this;
    }
    public function setExperience($exp): self {
        //Met à jours l'expérience
        $this->attributes['experience'] = $exp;

        //Vérifier le niveau
        $newlevel = $this->checkLevel((int)$exp);
        $this->attributes['level'] = $newlevel;
        return $this;
    }

    /**
     * Calcule le niveau correspondant à un montant d'experience
     * @param int $exp experience à essayer
     * @return int Niveau correspondant ou par défaut 1
     */
    public function checkLevel(int $exp) : int{
        $LevelThresholdModel = model(LevelThresholdModel::class);

        //cherche le niveau le plus élevé débloqué par cette expérience
        $threshold = $LevelThresholdModel->where('experience_required <=', $exp)->orderBy('level', 'DESC')->first();
        //on retourne le niveau trouvé sinon 1
        return $threshold ? (int) $threshold['level'] : 1;
    }
}
