<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CantinaModel;
use CodeIgniter\HTTP\ResponseInterface;

class CantinaController extends BaseController
{
    protected $cantinaModel;

    public function __construct()
    {
        $this->cantinaModel = model('CantinaModel');
    }

    public function index()
    {
        $this->title = "La Cantina";
        helper(['form']);
        $cantina = service('Cantina');
        $data = $cantina->getOnGeneratedOffers(auth()->user()->getPlayer()->id);
        return $this->render('front/cantina/index', $data);
    }

    public function refresh()
    {
        $cantina = service('Cantina');
        $id_player = auth()->user()->getPlayer()->id;

        //Récupération de la date de creation de la cantina en cours
        $created_at = $this->cantinaModel->where('player_id', $id_player)->first()->created_at;
        //Calcule du nombre d'heure et du coup
        $remainingSeconds = $cantina->getRemainingSeconds($created_at);
        $hours = (int)floor($remainingSeconds / 3600);
        $refreshCost = ($hours + 1) * 10;
        if (auth()->user()->getPlayer()->credits < $refreshCost) {
            $this->error('Pas assez de crédits');
        return $this->redirect('/cantina');
    }
        //Sauvegarder le nouveau solde
        auth()->user()->getPlayer()->credits -= $refreshCost;
        $playerModel = model('PlayerModel');
        $playerModel->save(auth()->user()->getPlayer());
        $cantina->generateOffers(auth()->user()->getPlayer()->id);
        return $this->redirect('/cantina');
    }

    public function recruit($id_cantina_hero = null)
    {
        $cantina = service('cantina');
        $cantina->recruit(auth()->user()->getPlayer()->id, $id_cantina_hero);
        return $this->redirect('/cantina');
    }
}
