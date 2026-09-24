<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MissionController extends BaseController
{
    protected $current_menu = "mission";
    protected $title = "Mission";
    protected $missionModel;

    public function __construct()
    {
        $this->missionModel = model("MissionModel");
    }
    public function index()
    {
        helper(['form']);
        $this->title = "Choix de la mission";
        $missions = $this->missionModel->findAll();
        return $this->render('front/mission/index', ['missions' => $missions]);
    }
    public function details($id = null)
    {
        if($id == null) return $this->response->setStatusCode(400)->setBody('ID Manquant');

        return view_cell('MissionCell', ['mission' => $this->missionModel->find($id)]);
    }
}
