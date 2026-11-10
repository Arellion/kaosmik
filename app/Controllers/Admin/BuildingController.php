<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HeroModelModel;
use CodeIgniter\HTTP\ResponseInterface;

class BuildingController extends BaseController
{
    protected $buildingModel;
    public function __construct()
    {
        $this->buildingModel = model('BuildingModel');
    }
    public function index()
    {
        //
    }
}
