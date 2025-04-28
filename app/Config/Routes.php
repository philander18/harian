<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/home/portal', 'Home::portal');
$routes->get('/home/keluar', 'Home::keluar');
$routes->get('/home/get_log', 'Home::get_log');

$routes->post('home/portal', 'Home::portal');
