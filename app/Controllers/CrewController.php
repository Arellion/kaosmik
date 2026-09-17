<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CrewController extends BaseController
{
    protected $current_menu = 'crew';
    public function index()
    {
        helper(['form']);
        $this->title = "Mon Equipage";
        return $this->render('front/crew/index');
    }
    public function sell($id_heroes = null)
    {
        if (!empty($id_heroes)) {
            $heroModel = model('HeroModel');
            $hero = $heroModel->find($id_heroes);
            $player = auth()->user()->getplayer();
            if($hero->player_id == $player->id) {
                $argent = (int) ($hero->cost_credit / 2);
                if($heroModel->delete($id_heroes)) {
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
}
