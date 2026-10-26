<?php

namespace Tests\Database;

use App\Entities\Hero;
use App\Entities\Player;
use App\Entities\RarityLevel;
use App\Models\HeroModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Traits\CreatesPlayers;
use PHPUnit\Framework\Attributes\Group;

#[Group('database')]
#[Group('slow')]

final class HeroModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use CreatesPlayers;

    protected $migrate = true;
    protected $refresh = true;
    protected $DBGroup = 'tests';
    protected $namespace = null;
    protected $seed = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    private HeroModel $heroModel;
    private Player $player;

    protected function setUp(): void
    {
        parent::setUp();

        $this->heroModel = new HeroModel();
        $this->player = $this->createPlayer('joueur1');
    }

    public function testCanCreateHero()
    {
        $id = $this->heroModel->insert([
            'player_id' => $this->player->id,
            'hero_model_id' => 1,
            'rarity_id' => 1,
            'name' => 'Alpha Test',
            'power' => 20,
            'cost_credit' => 100,
        ]);

        $this->assertIsInt($id);
        $this->seeInDatabase('heroes', ['name' => 'Alpha Test', 'power' => 20]);
    }

    public function testCanReadHero()
    {
        $hero = $this->createHero($this->player, ['name' => 'Beta Test']);

        $found = $this->heroModel->find($hero->id);

        $this->assertInstanceOf(Hero::class, $found);
        $this->assertSame('Beta Test', $found->name);
        $this->assertSame($this->player->id, $found->player->id);
    }

    public function testCanUpdateHero()
    {
        $hero = $this->createHero($this->player);

        $this->heroModel->update($hero->id, ['name' => 'Nouveau Nom', 'power' => 35]);

        $found = $this->heroModel->find($hero->id);
        $this->assertSame('Nouveau Nom', $found->name);
        $this->assertSame(35, $found->power);
    }

    public function testCanDeleteHero()
    {
        $hero = $this->createHero($this->player);

        $this->heroModel->delete($hero->id);

        // HeroModel n'utilise pas le soft delete : la ligne disparaît vraiment
        $this->assertNull($this->heroModel->find($hero->id));
        $this->dontSeeInDatabase('heroes', ['id' => $hero->id]);
    }

    public function testCannotCreateHeroForUnknownPlayer()
    {
        $this->expectException(DatabaseException::class);

        $this->heroModel->insert([
            'player_id' => 999999,
            'hero_model_id' => 1,
            'rarity_id' => 1,
            'name' => 'Orphelin',
            'power' => 10,
            'cost_credit' => 50,
        ]);
    }

    public function testDatabaseRejectsNegativeCostEvenWithoutValidation()
    {
        $this->expectException(DatabaseException::class);

        //skipValidation(true) coupe les règles du model : seule la colonne UNSIGNED peut encore refuser
        $this->heroModel->skipValidation(true)->insert([
            'player_id' => $this->player->id,
            'hero_model_id' => 1,
            'rarity_id' => 1,
            'name' => 'Cout Negatif',
            'power' => 20,
            'cost_credit' => -5,
        ]);
    }

    public function testFieldsOutsideAllowedFieldsAreIgnored()
    {
        $hero = $this->createHero($this->player);

        //'id' n'est pas dans $allowedFields : il ne doit pas être modifié
        $this->heroModel->update($hero->id, ['id' => 5000, 'power' => 99]);

        $this->seeInDatabase('heroes', ['id' => $hero->id, 'power' => 99]);
        $this->dontSeeInDatabase('heroes', ['id' => 5000]);
    }

    public function testValidationRequiresName()
    {
        $result = $this->heroModel->insert([
            'player_id' => $this->player->id,
            'hero_model_id' => 1,
            'rarity_id' => 1,
            'power' => 20,
            'cost_credit' => 100,
        ]);

        $this->assertFalse($result);
        $this->assertArrayHasKey('name', $this->heroModel->errors());
    }

    public function testValidationNameMustHaveAtLeastThreeCharacters()
    {
        $result = $this->heroModel->insert([
            'player_id'     => $this->player->id,
            'hero_model_id' => 1,
            'rarity_id'     => 1,
            'name'          => 'Al',
            'power'         => 20,
            'cost_credit'   => 100,
        ]);

        $this->assertFalse($result);
        $this->assertArrayHasKey('name', $this->heroModel->errors());
    }

    public function testValidationPowerMustBePositive()
    {
        $result = $this->heroModel->insert([
            'player_id'     => $this->player->id,
            'hero_model_id' => 1,
            'rarity_id'     => 1,
            'name'          => 'Sans Puissance',
            'power'         => 0,
            'cost_credit'   => 100,
        ]);

        $this->assertFalse($result);
        $this->assertArrayHasKey('power', $this->heroModel->errors());
    }

    public function testValidationCostCannotBeNegative()
    {
        $result = $this->heroModel->insert([
            'player_id'     => $this->player->id,
            'hero_model_id' => 1,
            'rarity_id'     => 1,
            'name'          => 'Cout Negatif',
            'power'         => 20,
            'cost_credit'   => -5,
        ]);

        $this->assertFalse($result);
        $this->assertArrayHasKey('cost_credit', $this->heroModel->errors());
    }

    public function testValidDataPassesValidation()
    {
        $id = $this->heroModel->insert([
            'player_id' => $this->player->id,
            'hero_model_id' => 1,
            'rarity_id' => 1,
            'name' => 'Valide',
            'power' => 20,
            'cost_credit' => 100,
        ]);

        $this->assertIsInt($id);
        $this->seeInDatabase('heroes', ['id' => $id]);
    }

    public function testHeroKnowsItsPlayerModelAndRarity()
    {
        $hero = $this->createHero($this->player, ['hero_model_id' => 1, 'rarity_id' => 2]);

        $this->assertSame($this->player->id, $hero->getPlayer()->id);
        $this->assertSame('Cadet de la Flotte', $hero->getHeroModel()->name);
        $this->assertInstanceOf(RarityLevel::class, $hero->getRarity());
        $this->assertSame('Peu Commun', $hero->getRarity()->name);
    }

    public function testTimesstampsAreSetOnInsert()
    {
        $hero = $this->createHero($this->player);

        $this->assertNotNull($hero->created_at);
        $this->assertNotNull($hero->updated_at);
    }

    public function testUpdatedAtIsModifiedOnUpdate()
    {
        $hero     = $this->createHero($this->player);
        $original = $hero->updated_at->toDateTimeString();

        sleep(1);
        $this->heroModel->update($hero->id, ['power' => 50]);

        $updated = $this->heroModel->find($hero->id)->updated_at->toDateTimeString();
        $this->assertNotEquals($original, $updated);
    }

    public function testFindRegeneratesStaminaAndSavesIt()
    {
        $hero = $this->createHero($this->player, [
            'stamina_current'     => 50,
            'stamina_max'         => 100,
            'last_stamina_update' => Time::now()->subMinutes(10)->subSeconds(5)->toDateTimeString(),
        ]);

        // Le simple fait de lire le héros déclenche la régénération
        $found = $this->heroModel->find($hero->id);

        $this->assertSame(55, $found->stamina_current);
        $this->seeInDatabase('heroes', ['id' => $hero->id, 'stamina_current' => 55]);
    }

    public function testFindDoesNotTouchStaminaOfFullHero()
    {
        $hero = $this->createHero($this->player, ['stamina_current' => 100, 'stamina_max' => 100]);

        $found = $this->heroModel->find($hero->id);

        $this->assertSame(100, $found->stamina_current);
    }

}