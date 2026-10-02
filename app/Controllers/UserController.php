<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
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
        $data = $this->request->getPost();
        $image = $this->request->getFile('image');
        $user = auth()->user();


        if(isset($id)){
            $this->error('Aucune id envoyé');
            return $this->redirect('mon-profil');
        }
        if( $user->id != $data['id']) {
            $this->error('Cette id ne vous a pas été attribué' );
            return $this->redirect('mon-profil');
        }

        $id = $data['id'];
        unset($data['id']);

        if($data['username'] == $user->username) {
            unset($data['username']);
        }
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $hasNewImage = ($image !== null && $image->isValid() && !$image->hasMoved());
        if (!$hasNewImage && empty($data['password']) && empty($data['username'])) {
            $this->warning('Aucune modification envoyé');
            return $this->redirect('mon-profil');
        }

        if ($hasNewImage) {
            helper('media');
            $result = upload_single_image($image, 'users', $data['username'], [
                'entity_type' => 'users',
                'entity_id' => $id,
            ]);
            if ($result->status == 'error') {
                $this->error($result['message']);
            }else{
                $this->success('Image téléversé');
            }
        }
        $user = model('UserModel')->find($id);


        $user->fill($data);

        $username = (isset($data['username'])) ? $data['username'] : $user->username;
        $this->success('Votre profil ' . $username . ' à été enregistré avec success');
        return $this->redirect('mon-profil');

    }
}
