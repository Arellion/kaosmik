<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ShipClassModel;
use CodeIgniter\HTTP\ResponseInterface;

class ShipClassController extends BaseController
{
    protected $layout = 'back';
    protected $shipClassModel;

    public function __construct()
    {
        $this->shipClassModel = model('ShipClassModel');
    }
    public function index()
    {
        helper(['form']);
        $SCM = $this->shipClassModel->findAll();
        return $this->render('admin/ship_class/index' ,['shipClass' => $SCM]);
    }
}
