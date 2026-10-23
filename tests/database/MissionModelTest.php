<?php

namespace Tests\Database;

use App\Models\HeroModelModel;
use App\Models\MissionModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

final class MissionModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate   = true;
    protected $refresh   = true;
    protected $DBGroup   = 'tests';
    protected $namespace = null;
    protected $seed      = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    public function testSeederCreatesTenMissions()
    {
        $this->assertCount(10, (new MissionModel())->findAll());
    }

    public function testSoftDeleteHidesMission()
    {
        $model = new MissionModel();

        $model->delete(1);

        $this->assertNull($model->find(1));

        $deleted = $model->withDeleted()->find(1);
        $this->assertNotNull($deleted);
        $this->assertNotNull($deleted->deleted_at);
        $this->assertCount(9, $model->findAll());
    }

    public function testMissionWithoutSpecializationHasEmptyList()
    {
        $mission = (new MissionModel())->find(1);

        $this->assertEmpty($mission->getSpecializations());
    }

    public function testRandomHeroModelRespectsPlayerLevel()
    {
        // Au niveau 1, un seul modèle de héros est disponible
        $heroModel = (new HeroModelModel())->getRandom(1);

        $this->assertSame('Cadet de la Flotte', $heroModel->name);
    }

    public function testRandomHeroModelIgnoresSoftDeletedModels()
    {
        $model = new HeroModelModel();
        $model->delete(1);

        $this->assertNull($model->getRandom(1));
    }

}
