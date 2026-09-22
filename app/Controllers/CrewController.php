<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CrewController extends BaseController
{
    protected $current_menu = 'crew';
    protected $heroModel = null;

    public function __construct()
    {
        $this->heroModel = model('HeroModel');
    }
    public function index()
    {
        helper(['form']);
        $this->title = "Mon Equipage";
        return $this->render('front/crew/index');
    }
    public function sell($id_heroes = null)
    {
        if (!empty($id_heroes)) {
            $hero = $this->heroModel->find($id_heroes);
            $player = auth()->user()->getplayer();
            if($hero->player_id == $player->id) {
                $argent = (int) ($hero->cost_credit / 2);
                if($this->heroModel->delete($id_heroes)) {
                    $player->credits += $argent;
                    if(model('PlayerModel')->save($player)){
                        $this->success($hero->name. "à été licencié. Vous récupérez <i class='fa-solid fa-cent-sign'></i>". $argent . "." );
                        return $this->redirect('equipage');
                    }
                }
            }
        }
        $this->error('Une erreur est survenue. Veuillez contacter un administrateur');
        return $this->redirect('/equipage');
    }

    public function sellBulk()
    {
        $ids = $this->request->getPost('ids');
        if(!empty($ids) && is_array($ids)) {
            $player = auth()->user()->getplayer();
            $heroes = $this->heroModel->whereIn('id', $ids)->where('player_id', $player->id)->findAll();

            $totalGain = 0;
            $deletedIds = array();
            foreach ($heroes as $hero) {
                $totalGain += (int) ($hero->cost_credit / 2);
                $deletedIds[] = $hero->id;
            }
            if(!empty($deletedIds)) {
                $this->heroModel->delete($deletedIds);
                $player->credits += $totalGain;
                model('PlayerModel')->save($player);
                $this->success(count($deletedIds) . "mercenaires ont été licenciés. Vous avez récupéré <i class='fa-solid fa-cent-sign'></i>" . $totalGain . "." );
                return $this->redirect('equipage');
            }
        }
        $this->error('Une erreur est survenue. Veuillez contacter un administrateur');
        return $this->redirect('/equipage');
    }
}
