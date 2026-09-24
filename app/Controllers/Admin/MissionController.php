<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MissionController extends BaseController
{
    protected $layout = 'back';
    protected $missionModel;
    protected $MissionSpecializationModel;
    protected $SpecializationModel;

    public function __construct()
    {
        $this->missionModel = model("MissionModel");
        $this->MissionSpecializationModel = model("MissionSpecializationModel");
        $this->SpecializationModel = model("SpecializationModel");
    }
    public function index()
    {
        $mission = $this->missionModel->findAll();
        $MissionSpe = $this->MissionSpecializationModel->findAll();
        $Spe = $this->SpecializationModel->findAll();
        return $this->render('admin/mission/index', ['missions' => $mission, 'MissionSpes' => $MissionSpe, 'Spes' => $Spe] );
    }
    public function new()
    {
        $Spe = $this->SpecializationModel->findAll();

        return $this->render('admin/mission/form', ['Spes' => $Spe] );
    }
}
