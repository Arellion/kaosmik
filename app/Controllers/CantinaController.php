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
        $cantina = service('Cantina');
        $cantinaHeroes = $cantina->getOnGeneratedOffers(auth()->user()->getPlayer()->id);
        return $this->render('front/cantina/index', ['cantinaHeroes' => $cantinaHeroes]);
    }
}
