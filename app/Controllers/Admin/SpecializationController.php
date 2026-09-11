<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SpecializationModel;

class SpecializationController extends BaseController
{
    protected $layout = 'back';

    private $specialization = null;
    public function __construct()
    {
        $this->specialization = model('SpecializationModel');
    }
    public function index()
    {
        helper(['form']);
        $specializations = $this->specialization->findAll();
        return $this->render('admin/specialization/index', ['specializations' => $specializations]);
    }
    public function create(){
        $data = $this->request->getPost();
        if(isset($data)){
            if($createOK = $this->specialization->save($data) == 1){
                $this->success('La spécialisation ' . $data['name'] . ' à bien été créer');
            }else{
                $this->error('Une erreur est survenue');
            }
        }else{
            $this->error('Il n\'y a aucune donné envoyé');
        }
        return $this->redirect('/admin/specialization');
    }
    public function delete(){
        $id = $this->request->getVar('id');
        if(isset($id) && $id != 1){
            if($deleteOK = $this->specialization->delete($id) == 1){
                $this->success('La spécialisation à bien était supprimer');
            }else{
                $this->error('Une erreur est survenue');
            }
        }else{
            $this->error('Aucun id envoyé');
        }
        return $this->redirect('/admin/specialization');
    }
    public function update(){
        $data = $this->request->getPost();
        if(isset($data['id'])){
            $id = $data['id'];
            unset($data['id']);
            if($updateOK = $this->specialization->update($id, $data) == 1){
                $this->success('La spécialisation ' . $data['name'] . ' à bien été modifier');
            }else{
                $this->error('Une erreur est survenue');
            }
        }else{
            $this->error('Aucun id envoyé');
        }
        return $this->redirect('/admin/specialization');
    }
}
