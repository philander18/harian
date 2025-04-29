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
$routes->get('/home/get_kategori', 'Home::get_kategori');
$routes->get('/home/get_subkategori', 'Home::get_subkategori');

$routes->post('home/portal', 'Home::portal');
$routes->post('home/generate', 'Home::generate');
$routes->post('home/tambah_task', 'Home::tambah_task');
$routes->post('/home/get_subkategori', 'Home::get_subkategori');
$routes->post('/home/get_log', 'Home::get_log');
$routes->post('/home/update_data', 'Home::update_data');
