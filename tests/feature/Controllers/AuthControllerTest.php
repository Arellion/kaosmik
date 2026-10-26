<?php

namespace Tests\Feature\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Shield\Test\AuthenticationTesting;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\Traits\CreatesPlayers;

final class AuthControllerTest extends CIUnitTestCase
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

        //Repartir d'une seddion vide : sinon l'utilisateur d'un test précédent reste connecté
        $this->resetServices();
        $this->mockSession();
    }
    //Inserer vos tests ici

    public function testHomePageLoads()
    {
        $result = $this->get('/');
        $result->assertStatus(200);
    }

    public function testLoginPageIsAccessible()
    {
        $result = $this->get('/login');

        $result->assertStatus(200);
        $result->assertSee('Connexion');
    }

    public function testLoginWithValidCredentials()
    {
        $this->createPlayer('joueur1');

        $result = $this->post('/login', [
            'email' => 'joueur1@kaosmik.test',
            'password' => 'Kaosmik2026!',
        ]);

        $result->assertRedirectTo(rtrim(site_url(), '/'));
        $this->assertTrue(auth()->loggedIn());
    }

    public function testLoginWithUnknownEmail()
    {
        $result = $this->post('/login', [
            'email' => 'inconnue@kaosmik.test',
            'password' => 'Kaosmik2026!',
        ]);

        $result->assertRedirect();
        $result->assertSessionHas('error', 'Unable to log you in. Please check your credentials.');
    }

    public function testLoginWithWrongPassword()
    {
        $this->createPlayer('joueur1');

        $result = $this->post('/login', [
            'email' => 'joueur1@kaosmik.test',
            'password' => 'MauvaisMotDePasse1!',
        ]);

        $result->assertRedirect();
        $result->assertSessionHas('error', 'Unable to log you in. Please check your password.');
        $this->assertFalse(auth()->loggedIn());
    }

    public function testLoginWithEmptyCredentials()
    {
        $result = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $result->assertRedirect();
        $result->assertSessionHas('errors', [
            'email'    => 'The Email Address field is required.',
            'password' => 'The Password field is required.',
        ]);
    }

    public function testRegisterCreateUserAndPlayer()
    {
        $result = $this->post('/register', [
            'username' => 'nouveau',
            'email' =>'nouveau@kaosmik.test',
            'password' => 'Kaosmik2026!',
            'password_confirm' => 'Kaosmik2026!',
        ]);

        $result->assertRedirectTo(rtrim(site_url(), '/'));
        $this->seeInDatabase('users', ['username' => 'nouveau']);

        $user = model('UserModel')->findByCredentials(['email' => 'nouveau@kaosmik.test']);
        $this->seeInDatabase('players', ['user_id' => $user->id]);
    }

    public function testLogoutWorks()
    {
        $player = $this->createPlayer('joueur1');
        $this->actingAs($this->getUserOf($player));

        $result = $this->get('/logout');

        $result->assertRedirectTo(site_url('/login'));
        $this->assertFalse(auth()->loggedIn());
    }

    public function testCantinaRequiresAuthentification()
    {
        $result = $this->get('/cantina');

        $result->assertRedirectTo(site_url('/login'));
    }

    public function testAdminPageRequiresAdminGroup()
    {
        $player = $this->createPlayer('joueur1');
        $user = $this->getUserOf($player);
        $user->addGroup('admin');
        $this->actingAs($user);

        $result = $this->get('/admin');

        $result->assertStatus(200);
    }

    #[DataProvider('invalidLoginProvider')]
    public function testLoginWithInvalidCredentials(string $email, string $password, string $sessionKey, string|array $expected)
    {
        $this->createPlayer('joueur1');

        $result = $this->post('/login', ['email' => $email, 'password' => $password]);

        $result->assertSessionHas($sessionKey, $expected);
    }

    /**
     * Fournit différents cas de connexion invalides
     */
    public static function invalidLoginProvider(): array
    {
        return [
            'email_inconnu'   => ['inconnu@kaosmik.test', 'Kaosmik2026!', 'error', 'Unable to log you in. Please check your credentials.'],
            'password_errone' => ['joueur1@kaosmik.test', 'MauvaisMotDePasse1!', 'error', 'Unable to log you in. Please check your password.'],
            'champs_vides'    => ['', '', 'errors', [
                'email'    => 'The Email Address field is required.',
                'password' => 'The Password field is required.',
            ]],
            'email_malforme'  => ['pasunemail', 'Kaosmik2026!', 'errors', [
                'email' => 'The Email Address field must contain a valid email address.',
            ]],
        ];
    }

}