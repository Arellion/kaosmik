<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userModel;

    public function index()
    {
        helper(['form']);
        return $this->render('front/profil/index');
    }

    public function oldMissions()
    {
        return $this->render('front/profil/old-mission');
    }

    public function update()
    {
        //Récupération des données
        $data = $this->request->getPost();
        $image = $this->request->getFile('image');
        $user_logged = auth()->user();

        //Vérification des données envoyées
        if (isset($id)) {
            $this->error('Aucune id envoyé');
            return $this->redirect('mon-profil');
        }
        if ($user_logged->id != $data['id']) {
            $this->error('Cette id ne vous a pas été attribué');
            return $this->redirect('mon-profil');
        }

        //nettoyage des données

        if ($data['username'] == $user_logged->username) {
            unset($data['username']);
        }
        if (empty($data['password'])) {
            unset($data['password']);
        }

        //Si aucune nouvelle donnée on renvoie
        $hasNewImage = ($image !== null && $image->isValid() && !$image->hasMoved());
        if (!$hasNewImage && empty($data['password']) && empty($data['username'])) {
            $this->warning('Aucune modification envoyé');
            return $this->redirect('mon-profil');
        }

        //gestion de l'image
        if ($hasNewImage) {
            helper('media');
            $result = upload_single_image($image, 'users', $data['username'], [
                'entity_type' => 'users',
                'entity_id' => $id,
            ]);
            if ($result->status == 'error') {
                $this->error($result['message']);
            } else {
                $this->success('Image téléversé');
            }
        }

        //Récupération de l'entité
        $this->userModel = model("UserModel");
        $user_change = $this->userModel->find($data['id']);

        if ($user_change == null) {
            $this->error('utilisateur introuvable');
            return $this->redirect('mon-profil');
        }

        $user_change = new user();

        $user_change->fill($data);

        $userUpdateOk = $this->userModel->save($user_change);
        $username = (isset($data['username'])) ? $data['username'] : $user_change->username;

        if ($userUpdateOk) {
            $this->success('Votre profil ' . $username . ' à été enregistré avec success');
            return $this->redirect('mon-profil');
        }else{
            $this->error('Votre profil à rencontré un problème contacté un administrateur');
            return $this->redirect('mon-profil');
        }
    }
}
