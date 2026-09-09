<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

//Authentification
$routes->get('login', [AuthController::Class, 'loginView']);
$routes->post('login', [AuthController::class, 'loginAction']);
$routes->get('register', [AuthController::Class, 'registerView']);
$routes->post('register', [AuthController::Class, 'registerAction']);
$routes->get('logout', [AuthController::class, 'logoutAction']);

//Route pour Administration
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'group:admin'], function ($routes) {
    $routes->get('/', 'AdminController::index');
    $routes->group('user', function ($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->post('update', 'UserController::update');
        $routes->post('create', 'UserController::create');
        $routes->get('new', 'UserController::new');
    });
    $routes->group('threshold', function ($routes) {
        $routes->get('/', 'ThresholdController::index');
        $routes->post('create', 'ThresholdController::create');
        $routes->post('delete', 'ThresholdController::delete');
        $routes->post('update', 'ThresholdController::update');
    });
    $routes->group('rarity', function ($routes) {
        $routes->get('/', 'RarityLevelController::index');
        $routes->post('create', 'RarityLevelController::create');
        $routes->post('delete', 'RarityLevelController::delete');
        $routes->post('update', 'RarityLevelController::update');

    });
    $routes->group('hero-model', function ($routes) {
        $routes->get('/', 'HeroModelController::index');
        $routes->get('new', 'HeroModelController::new');
        $routes->get('edit/(:num)', 'HeroModelController::edit/$1');
        $routes->post('create-update', 'HeroModelController::createUpdate');
        $routes->get('delete/(:num)', 'HeroModelController::delete/$1');
    });
});
