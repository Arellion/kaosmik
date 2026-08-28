<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('admin', ['filter' => 'group:admin'], function ($routes) {

});

$routes->get('login', [AuthController::Class, 'loginView']);
$routes->post('login', [AuthController::class, 'loginAction']);
$routes->get('register', [AuthController::Class, 'registerView']);
$routes->post('register', [AuthController::Class, 'registerAction']);
$routes->get('loggout', [AuthController::class, 'logoutAction']);
