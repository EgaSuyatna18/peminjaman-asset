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
$routes->get('/penambahan_barang_baru/(:num)/diterima', 'PenambahanBarangBaru::diterima/$1');
$routes->get('/penambahan_barang_baru/(:num)/ditolak', 'PenambahanBarangBaru::ditolak/$1');

$routes->get('/peminjaman_barang', 'PeminjamanBarang::index');
$routes->post('/peminjaman_barang', 'PeminjamanBarang::store');
$routes->put('/peminjaman_barang/(:num)', 'PeminjamanBarang::update/$1');
$routes->delete('/peminjaman_barang/(:num)', 'PeminjamanBarang::destroy/$1');

$routes->get('/pengembalian_barang', 'PengembalianBarang::index');
$routes->post('/pengembalian_barang', 'PengembalianBarang::store');
$routes->put('/pengembalian_barang/(:num)', 'PengembalianBarang::update/$1');
$routes->delete('/pengembalian_barang/(:num)', 'PengembalianBarang::destroy/$1');

$routes->get('/barang', 'Barang::index');
$routes->post('/barang', 'Barang::store');
$routes->put('/barang/(:num)', 'Barang::update/$1');
$routes->delete('/barang/(:num)', 'Barang::destroy/$1');