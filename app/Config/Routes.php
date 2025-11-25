<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('Sekjur', ['namespace' => 'App\\Controllers\\Sekjur'], function ($routes) {
    $routes->get('/', 'BasePanel::index');
    $routes->get('users', 'UsersController::index');
    $routes->get('users/(:num)', 'UsersController::show/$1');
    $routes->post('users', 'UsersController::create');
    $routes->put('users/(:num)', 'UsersController::update/$1');
    $routes->patch('users/(:num)', 'UsersController::update/$1');
    $routes->delete('users/(:num)', 'UsersController::delete/$1');
});

$routes->group('Kaprodi', ['namespace' => 'App\\Controllers\\Kaprodi'], function ($routes) {
    $routes->get('/', 'BasePanel::index');
});

$routes->group('DosenPembimbing', ['namespace' => 'App\\Controllers\\DosenPembimbing'], function ($routes) {
    $routes->get('/', 'BasePanel::index');
});

$routes->group('Mahasiswa', ['namespace' => 'App\\Controllers\\Mahasiswa'], function ($routes) {
    $routes->get('/', 'BasePanel::index');
});
