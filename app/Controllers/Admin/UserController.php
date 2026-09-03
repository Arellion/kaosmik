<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use CodeIgniter\Shield\Entities\User;

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

    public function update()
    {
        $data = $this->request->getPost();
        //On vérifie qu'on a bien une donné
        if (!isset($data['id'])) {
            $this->error('Identifiant inconnu');
            return $this->redirect('admin/user');
        }
        $user_id = $data['id'];
        unset($data['id']);

        //Récupération des object (entité)
        $user = $this->userModel->find($user_id);
        if ($user === null) {
            $this->error('Utilisateur introuvable dans la base de données.');
        }
        $player = $user->getPlayer();
        if ($player === null) {
            $this->error('Aucun profils de joueur associé à cet utilisateur.');
        }

        //On Vérifie si on à le champ active sinon on le met à 0
        if (isset($data['active']) && $data['active'] == 'on') {
            $data['active'] = 1;
        } else {
            $data['active'] = 0;
        }
        //On rempli nos object
        $user->fill($data);
        $player->fill($data);
        //On rempli la BDD
        $saveUserOK = $this->userModel->save($user);
        $savePlayerOK = $this->playerModel->save($player);
        if ($savePlayerOK == false || $saveUserOK == false) {
            return $this->redirect('admin/user/edit/' . $user_id);
        }
        //gestion des persimission ne marche pas
        $users = model('UserModel');
        $user_obj = $users->findById($user_id);
        if (isset($data['admin']) == 1) {
            $user_obj->addgroup('admin');
        }else{
            $user_obj->removeGroup('admin');
        }

        //On Affiche un message de réussite
        $this->success($user->username . " à bien été modifié.");
        //On redirige
        return $this->redirect('admin/user/');

    }

    public function new()
    {
        helper(['form']);
        return $this->render('admin/user/form');
    }

    public function create()
    {
        //Récupération des donnée
        $data = $this->request->getPost();
        if (!isset($data)) {
            $this->error('Aucune donnée envoyé');
            return $this->redirect('admin/user');
        }
        //Création de User
        $user = new User([
            'username' => $data['username'],
            'email' => $data['secret'],
            'password' => $data['secret2'],
        ]);
        $saveUserOK = $this->userModel->save($user);
        //Récupération de la dernière id ajouter
        $user_id = $this->userModel->getInsertID();
        //Lien entre la table User et player
        $data['user_id'] = $user_id;

        //Ajout du groupe par défaut

        $users = model('UserModel');
        $user_obj = $users->findById($users->getInsertID());
        $users->addToDefaultGroup($user_obj);

        if (isset($data['admin']) == 1) {
            $user_obj->addgroup('admin');
        }
        //Mise par défaut si aucun parametre n'as été remplis
        if ($data['credits'] == NULL) {
            unset($data['credits']);
        }
        if ($data['experience'] == NULL) {
            unset($data['experience']);
        }
        if ($data['fusion_energy'] == NULL) {
            unset($data['fusion_energy']);
        }
        //Création de player
        $savePlayerOK = $this->playerModel->save($data);
        //Vérification que tout à était créer
        if ($saveUserOK == false || $savePlayerOK == false) {
            $this->error('Une erreur est survenue');
            return $this->redirect('admin/user/new');
        }
        $this->success('L\'utilisateur à bien était créer');
        return $this->redirect('admin/user');
    }
}
