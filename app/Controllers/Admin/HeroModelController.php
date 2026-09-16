<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\HeroModel;
use App\Models\HeroModelModel;

class HeroModelController extends BaseController
{
    protected $layout = 'back';
    protected $current_menu = 'hero_model';

    private $heroModel = null;
    private $Specialization = null;
    public function __construct(){
        $this->heroModel = model('HeroModelModel');
        $this->Specialization = model('SpecializationModel');
    }

    public function index()
    {
        helper(['form']);
        $heromodels = $this->heroModel->findAll();
        return $this->render('admin/hero_model/index', ['hero_models' => $heromodels]);
    }
    public function new(){
        helper('form');
        $specializations = $this->Specialization->findAll();
        return $this->render('admin/hero_model/form',['specializations' => $specializations]);
    }
    public function edit($id = null){
        helper('form');
        if($id != null){
            $specializations = $this->Specialization->findAll();
            $heromodel = $this->heroModel->find($id);
            if($heromodel){
                return $this->render('/admin/hero_model/form',['hm'=>$heromodel,'specializations' => $specializations]);
            }
        }
        $this->error('Aucun modèle trouvé');
        return $this->redirect('/admin/hero-model');
    }
    public function createUpdate()
    {
        $heromodeldata = $this->request->getPost();
        $heromodel = new HeroModel();
        $heromodel->fill($heromodeldata);
        $saveOk = $this->heroModel->save($heromodel);
        if($saveOk){
            if(isset($heromodeldata['id'])) {
                $img = $this->request->getFile('image');
                if($img->isValid() && !$img->hasMoved()){
                    helper('media');
                    $result = upload_single_image($img, 'hero_models', $heromodeldata['name'], [
                        'entity_type' => 'hero_models',
                        'entity_id' => $heromodeldata['id'],
                    ]);
                    if($result->status == 'error'){
                        $this->error($result['message']);
                    }else{
                        $this->success('Image téléversé');
                    }
                }
                $this->success('Le modèle : ' . $heromodel->name . ' à bien était modifier');
                $id = $heromodeldata['id'];
            }else{
                $this->success('Le modèle : ' . $heromodel->name . ' à bien était créer');
                $id = $this->heroModel->getInsertId();
            }
            return $this->redirect('/admin/hero-model/edit/'.$id);
        }
        $this->error('Une erreur est survenue');
        return $this->redirect('/admin/hero-model');
    }
    public function delete($id = null){
        if(isset($id)){
            if($id != 1){
                if ((!$deleteOk = $this->heroModel->delete($id))!= 1){
                    $this->success('Le modéle à bien été supprimer');
                }else{
                    $this->error('Une erreur est survenue');
                }
            }else{
                $this->error('Vous ne pouvez pas supprimer la Recrue');
            }
        }else{
            $this->error('Aucun id n\'a été reçus');
        }
        return $this->redirect('/admin/hero-model');
    }
}