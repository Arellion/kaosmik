<?php

namespace Tests\Database;

use App\Entities\RarityLevel;
use App\Models\RarityLevelModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

final class RarityLevelModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate   = true;
    protected $refresh   = true;
    protected $DBGroup   = 'tests';
    protected $namespace = null;
    protected $seed      = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    private RarityLevelModel $rarityModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rarityModel = new RarityLevelModel();
    }

    private function newRarity(array $overrides = []): array
    {
        return array_merge([
            'name'             => 'Test',
            'color'            => '#123456',
            'power_multiplier' => '1.2',
            'cost_multiplier'  => '1.2',
            'appearance_rate'  => '5',
        ], $overrides);
    }

    public function testSeededRaritiesAreAvailable()
    {
        // 1 rareté par défaut (migration) + 5 raretés (seeder)
        $this->assertCount(6, $this->rarityModel->findAll());
    }

    public function testCommonRateIsTheRemainderOfTheOthers()
    {
        // Seeder : 12 + 8 + 4 + 2 + 1 = 27, donc Commun = 73
        $common = $this->rarityModel->find(1);

        $this->assertEqualsWithDelta(73.0, $common->appearance_rate, 0.001);
    }

    public function testConvertAppearanceRateAcceptsComma()
    {
        $id = $this->rarityModel->insert($this->newRarity(['appearance_rate' => '3,5']));

        $this->assertEqualsWithDelta(3.5, $this->rarityModel->find($id)->appearance_rate, 0.001);
    }

    public function testCommonRateIsRecalculatedAfterInsert()
    {
        $this->rarityModel->insert($this->newRarity(['appearance_rate' => '10']));

        // 73 - 10 = 63
        $this->assertEqualsWithDelta(63.0, $this->rarityModel->find(1)->appearance_rate, 0.001);
    }

    public function testCommonRateIsRecalculatedAfterDelete()
    {
        // La rareté 3 ("Rare") pèse 8 % : sa suppression rend 8 % à Commun
        $this->rarityModel->delete(3);

        $this->assertEqualsWithDelta(81.0, $this->rarityModel->find(1)->appearance_rate, 0.001);
    }

    public function testCommonRateNeverGoesBelowZero()
    {
        $this->rarityModel->insert($this->newRarity(['appearance_rate' => '90']));

        $this->assertEqualsWithDelta(0.0, $this->rarityModel->find(1)->appearance_rate, 0.001);
    }

    public function testCannotDeleteDefaultRarity()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Interdiction de modifier ou supprimer la rareté par défaut (commun)');

        $this->rarityModel->delete(1);
    }

    public function testGetRandomRarityReturnsARarity()
    {
        $rarity = $this->rarityModel->getRandomRarity();

        $this->assertInstanceOf(RarityLevel::class, $rarity);
    }

}
