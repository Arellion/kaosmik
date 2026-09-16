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
        helper(['form']);
        $cantina = service('Cantina');
        $cantinaHeroes = $cantina->getOnGeneratedOffers(auth()->user()->getPlayer()->id);
        return $this->render('front/cantina/index', ['cantinaHeroes' => $cantinaHeroes]);
    }
    public function refresh()
    {
        $cantina = service('Cantina');
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
