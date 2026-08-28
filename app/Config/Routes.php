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
});