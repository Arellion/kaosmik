<?php

namespace Tests\Feature\Controllers;

use CodeIgniter\Shield\Test\AuthenticationTesting;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Traits\CreatesPlayers;

final class CrewControllerTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use AuthenticationTesting;
    use CreatesPlayers;

    protected $migrate = true;
    protected $refresh = true;
    protected $DBGroup = 'tests';
    protected $namespace = null;
    protected $seed = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetServices();
        $this->mockSession();
    }

    //Inserer vos tests ici
    public function testCrewPageListsHeroes()
    {
        $player = $this->createPlayer('joueur1');
        $this->createHero($player, ['name' => 'Capitaine Test']);
        $this->actingAs($this->getUserOf($player));

        $result = $this->get('/equipage');

        $result->assertStatus(200);
        $result->assertSee('Capitaine Test');
    }
    public function testSellHeroGivesBackHalfOfItsCost()
    {
        $player = $this->createPlayer('joueur1');
        $hero = $this->createHero($player, ['cost_credits' => 100]);
        $this->actingAs($this->getUserOf($player));

        $result = $this->post('/equipage/sell/' . $hero->id);

        $result->assertRedirectTo(site_url('equipage'));
        $this->dontSeeInDatabase('heroes', ['id' => $hero->id]);
        //1000 crédits de départ + la moitié de 100
        $this->seeInDatabase('players', ['id' => $player->id, 'credits' => 1050]);
    }

    public function testSellHeroOfAnotherPlayerIsRefused()
    {
        $owner = $this->createPlayer('proprietaire');
        $intruder = $this->createPlayer('intrus');
        $hero = $this->createHero($owner);
        $this->actingAs($this->getUserOf($intruder));

        $result = $this->post('/equipage/sell/' . $hero->id);

        // Le héro est toujour là et on est renvoyé vers la page de l'equipage
        $this->seeInDatabase('heroes', ['id' => $hero->id]);
        $result->assertRedirectTo(site_url('/equipage'));
    }
    public function testSellBulkSellsOnlyMyHeroes()
    {
        $me    = $this->createPlayer('joueur1');
        $other = $this->createPlayer('joueur2');
        $mine1 = $this->createHero($me, ['cost_credit' => 100]);
        $mine2 = $this->createHero($me, ['cost_credit' => 60]);
        $theirs = $this->createHero($other);
        $this->actingAs($this->getUserOf($me));

        $result = $this->post('/equipage/sell-bulk', ['ids' => [$mine1->id, $mine2->id, $theirs->id]]);

        $result->assertRedirectTo(site_url('/equipage'));
        $this->dontSeeInDatabase('heroes', ['id' => $mine1->id]);
        $this->dontSeeInDatabase('heroes', ['id' => $mine2->id]);
        $this->seeInDatabase('heroes', ['id' => $theirs->id]);
        // 1000 + 50 + 30
        $this->seeInDatabase('players', ['id' => $me->id, 'credits' => 1080]);
    }
}