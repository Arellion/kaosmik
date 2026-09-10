<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RarityLevelModel;

class RarityLevelController extends BaseController
{
    protected $layout = 'back';
    private $RarityLevelsModel;

    public function __construct()
    {
        $this->RarityLevelsModel = model('RarityLevelModel');
    }

    public function index()
    {
        helper(['form']);
        $RlM = $this->RarityLevelsModel->findAll();
        return $this->render('admin/rarity-level/index', ['rarityLevels' => $RlM]);
    }

    public function create()
    {
        $data = request()->getPost();
        if (!isset($data)) {
            $this->error('Erreur aucune donnée envoyé');
            return $this->redirect('admin/rarity/create');
        }
        if ($this->RarityLevelsModel->save($data)) {
            $this->success('Le niveau de rareté à était créer avec succé');
        } else {
            $this->error('Une erreur est survenue');
        }
        return $this->redirect('admin/rarity');
    }

    public function delete()
    {
        try {
            $id = $this->request->getVar('id');
            if ($id == 1) {
                $this->error('Impossible de supprimer le niveaux commun');
                $this->redirect('admin/rarity');
            }

            if ($this->RarityLevelsModel->delete($id)) {
                $this->success('Le niveaux à bien été supprimer');
            } else {
                $this->error('Une erreur est survenue');
            }
            return $this->redirect('admin/rarity');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function update()
    {
        try {
            $data = $this->request->getPost();
            if ($data['id'] == 1) {
                $this->error('Impossible de modifié le niveaux commun');
                $this->redirect('admin/rarity');
            }
            if ($this->RarityLevelsModel->save($data)) {
                $this->success('Le niveau à bien été modifié');
            }
            return $this->redirect('admin/rarity');
        }catch (\Exception $e){
        $this->error($e->getMessage());
        }
        return $this->redirect('admin/rarity');
    }

}
