<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $layout = 'back';
    private $userModel;
    private $playerModel;

    public function __construct()
    {
        $this->userModel = model('UserModel');
        $this->playerModel = model('PlayerModel');

    }
    public function index()
    {
        helper(['form']);
        $this->title = "Liste des utilisateurs Kaosmik";
        $users = $this->userModel->findAll();
        return $this->render('admin/user/index', ['users' => $users]);
    }
    public function edit($id = null)
    {
        helper(['form']);
        $user = $this->userModel->find($id);
        return $this->render('admin/user/form', ['user' => $user]);
    }
    public function update(){
        $data = $this->request->getPost();
        //On vérifie qu'on a bien une donné
        if(!isset($data['id'])) {
            $this->error('Identifiant inconnu');
            return $this->redirect('admin/user');
        }
        $user_id = $data['id'];
        unset($data['id']);

        //Récupération des object (entité)
        $user = $this->userModel->find($user_id);
        if($user === null) {
            $this->error('Utilisateur introuvable dans la base de données.');
        }
        $player = $user->getPlayer();
        if($player === null) {
            $this->error('Aucun profils de joueur associé à cet utilisateur.');
        }

        //On Vérifie si on à le champ active sinon on le met à 0
        if(isset($data['active']) && $data['active'] == 'on'){
            $data['active'] = 1;
        }else{
            $data['active'] = 0;
        }
        //On rempli nos object
        $user->fill($data);
        $player->fill($data);
        //On rempli la BDD
        $saveUserOK = $this->userModel->save($user);
        $savePlayerOK = $this->playerModel->save($player);
        if($savePlayerOK == false || $saveUserOK == false ) {
            return $this->redirect('admin/user/edit/'. $user_id);
        }
        //On Affiche un message de réussite
        $this->success($user->username . " à bien été modiffié.");
        //On redirige
        return $this->redirect('admin/user/');

        }
}
