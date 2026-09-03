<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LevelThresholdModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class ThresholdController extends BaseController
{
    protected $layout = 'back';
    private $LevelThresholdModel;
    public function __construct()
    {
        $this->LevelThresholdModel = model('LevelThresholdModel');

    }
    public function index()
    {
        helper(['form']);
        $thM = $this->LevelThresholdModel->orderBy('level', 'ASC')->findAll();
        return $this->render('/admin/level-threshold/index', ['level_thresholds' => $thM]);
    }
    public function create()
    {
        $data = $this->request->getPost();
        if (!isset($data)){
            $this->error('Erreur d\'envoie des donnée');
            return $this->redirect('admin/threshold');
        }
        $verif = $this->LevelThresholdModel->where('level', $data['level'])->countAllResults();
        if($verif != 0){
            $this->error('Le level existe déjà');
            return $this->redirect('admin/threshold');
        }
        //Création de treshhold
        //Vérification que tout à était créer
        if ($this->LevelThresholdModel->save($data)) {
            $this->success('L\'utilisateur à bien était créer');
        }else{
            $this->error('Une erreur est survenue');
        }
        return $this->redirect('admin/threshold');
    }
    public function delete(){
        $id = $this->request->getVar('id');
        if (!isset($id)){
            $this->error('L\identifiant est manquant');
            return $this->redirect('admin/threshold');
        }
        if($this->LevelThresholdModel->delete($id)){
            $this->success('Le level à bien été supprimer');
        }else{
            $this->error('Une erreur est survenue');
        }

        return $this->redirect('admin/threshold');
    }
    public function update(){
        $data = $this->request->getPost();
        if(!isset($data['id'])){
            $this->error('L\identifiant est manquant');
            return $this->redirect('admin/threshold');
        }
        $id = $data['id'];
        unset($data['id']);
        if($this->LevelThresholdModel->update($id, $data)):
                $this->success('Niveau modifié');
            else:
                $this->error('Une erreur est survenue');
            endif;

        return $this->redirect('admin/threshold');
    }
}
