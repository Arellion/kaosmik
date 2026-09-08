<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HeroModelModel;

class HeroModelController extends BaseController
{
    protected $layout = 'back';
    protected $current_menu = 'hero_model';

    private $HeroModel = null;
    private $Specialization = null;
    public function __construct(){
        $this->HeroModel = model('HeroModelModel');
        $this->Specialization = model('SpecializationModel');
    }

    public function index()
    {
        $heromodels = $this->HeroModel->findAll();
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
            $heromodel = $this->HeroModel->find($id);
            if(!$heromodel){
                return $this->render('/admin/hero_model/form',['hm'=>$heromodel,'specializations' => $specializations]);
            }
        }
        $this->error('Aucun modèle trouvé');
        return $this->redirect('/admin/hero-model');
    }
}
