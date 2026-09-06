<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RarityLevelsModel;

class RarityLevelController extends BaseController
{
    protected $layout = 'back';
    private $RarityLevelsModel;
    public function __construct()
    {
        $this->RarityLevelsModel = model('RarityLevelsModel');
    }
    public function index()
    {
        helper(['form']);
        $RlM = $this->RarityLevelsModel->findAll();
        return $this->render('admin/rarity-level/index', ['RarityLevels' => $RlM]);
    }
    public function create(){
        $data = request()->getPost();
        if(!isset($data)){
            $this->error('Erreur aucune donnée envoyé');
            return $this->redirect('admin/rarity/create');
        }
        if($this->RarityLevelsModel->save($data)){
            $this->success('Le niveau à était créer avec succéss');
        }else{
            $this->error('Une erreur est survenue');
        }
        return $this->redirect('admin/rarity');
    }
    public function delete(){
        $id = $this->request->getVar('id');
        if(!isset($id)){
            $this->error('Aucun identifiant envoyé');
            $this->redirect('admin/rarity');
        }
        if($this->RarityLevelsModel->delete($id)){
            $this->success('Le niveaux à bien été supprimer');
        }else{
            $this->error('Une erreur est survenue');
        }
        return $this->redirect('admin/rarity');
    }
    public function update(){
        $data = $this->request->getPost();
        if(!isset($data)){
            $this->error('Aucune donnée envoyé');
            $this->redirect('admin/rarity');
        }
        if($this->RarityLevelsModel->save($data)){
            $this->success('Le niveau à bien été modifié');
        }
        return $this->redirect('admin/rarity');
    }
}
