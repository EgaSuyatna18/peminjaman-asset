<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::postRegister');
$routes->post('/login', 'Auth::postLogin');
$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/supplier', 'Supplier::index');
$routes->post('/supplier', 'Supplier::store');
$routes->put('/supplier/(:num)', 'Supplier::update/$1');
$routes->delete('/supplier/(:num)', 'Supplier::destroy/$1');

$routes->get('/tim', 'Tim::index');
$routes->post('/tim', 'Tim::store');
$routes->put('/tim/(:num)', 'Tim::update/$1');
$routes->delete('/tim/(:num)', 'Tim::destroy/$1');

$routes->get('/penambahan_barang_baru', 'PenambahanBarangBaru::index');
$routes->post('/penambahan_barang_baru', 'PenambahanBarangBaru::store');
$routes->put('/penambahan_barang_baru/(:num)', 'PenambahanBarangBaru::update/$1');
$routes->delete('/penambahan_barang_baru/(:num)', 'PenambahanBarangBaru::destroy/$1');