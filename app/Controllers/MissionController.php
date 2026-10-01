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
    public function sendCrew()
    {
        helper(['form']);
        $id = $this->request->getVar('mission_id');
        $mission = $this->missionModel->find($id);

        return $this->render('front/mission/send-crew', ['mission' => $mission]);
    }
    public function validateMission()
    {
        $data = $this->request->getPost();
        $player = auth()->user()->getPlayer();
        $heroes = $data['heroes_ids'];
        $mission = $data['mission_id'];
        try{
            $missionService = service("mission");
            $reward = $missionService->processMission($player, $mission, $heroes);
        }catch (\Exception $e){
            $this->error($e->getMessage());
            return $this->redirect('mission');
        }

        return $this->redirect('mission/resultats', $reward);
    }
    public function results()
    {
        return $this->render('front/mission/results');
    }
}
