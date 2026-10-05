<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Mission;
use App\Models\MissionModel;
use App\Models\MissionSpecializationModel;
use App\Models\SpecializationModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Administration des missions (CRUD).
 *
 * Une mission peut être associée à plusieurs spécialisations
 * via la table de liaison `mission_specializations`.
 */
class MissionController extends BaseController
{
    protected $layout = 'back';

    protected $current_menu = 'mission';

    private $missionModel = null;

    private $specializationModel = null;

    private $missionSpecializationModel = null;

    public function __construct()
    {
        $this->missionModel = model('MissionModel');
        $this->specializationModel = model('SpecializationModel');
        $this->missionSpecializationModel = model('MissionSpecializationModel');
    }

    public function index()
    {
        helper(['form']);
        $missions = $this->missionModel->findAll();
        return $this->render('admin/mission/index', ['missions' => $missions]);
    }

    public function new()
    {
        helper('form');
        $specializations = $this->specializationModel->findAll();
        return $this->render('admin/mission/form', [
            'specializations' => $specializations,
            'selectedSpecializations' => [],
        ]);
    }

    public function edit($id = null)
    {
        if ($id != null) {
            $mission = $this->missionModel->find($id);
            helper('form');
            $specializations = $this->specializationModel->findAll();
            $specSelected = $mission->getSpecializations();

            return $this->render('admin/mission/form', [
                'mission' => $mission,
                'specializations' => $specializations,
                'specSelected' => $specSelected,
            ]);
        }
        $this->error('Aucune mission trouvée');
        return $this->redirect('/admin/mission');
    }

    public function createUpdate()
    {
        $data = $this->request->getPost();
        $image = $this->request->getFile('image');

        $specializationIds = $data['specialization'] ?? [];
        unset($data['specialization']);

        $mission = new Mission();
        $mission->fill($data);
        $saveOk = $this->missionModel->save($mission);

        if($image->isValid() && !$image->hasMoved()){
            helper('media');
            $result = upload_single_image($image, 'mission', $data['title'], [
                'entity_type' => 'mission',
                'entity_id' => $data['id'],
            ]);
            if($result->status == 'error'){
                $this->error($result['message']);
            }else{
                $this->success('Image téléversé');
            }
        }
        if ($saveOk) {
            if (isset($data['id'])) {
                $this->success('La mission : ' . $mission->title . '. A bien été modifiée.');
                $id = $data['id'];
            } else {
                $this->success('La mission : ' . $mission->title . '. A bien été créée.');
                $id = $this->missionModel->getInsertID();
            }
            $this->missionSpecializationModel->where('mission_id', $id)->delete();


                foreach ($specializationIds as $speId) {$batchData[] = [
                    'mission_id'        => $id,
                    'specialization_id' => $speId,
                ];
                }
                $this->missionSpecializationModel->insertBatch($batchData);

            return $this->redirect('admin/mission/edit/' . $id);
        }
        $this->error('Une erreur est survenue');
        return $this->redirect('/admin/mission');
    }

    public function delete($id = null)
    {
        if ($id != null) {
            $this->missionModel->delete($id);
            $this->success('La mission à été supprimée');
        } else {
            $this->error('Une erreur est survenue');
        }
        return $this->redirect('/admin/mission');
    }
}