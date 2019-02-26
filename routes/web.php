<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Router Login Auth
$router->post('/v1/register', 'PenggunaController@register');
$router->post('/v1/login', 'PenggunaController@login');

$router->post('/v1/artikel/gambar', 'ArtikelController@postGambar');

$router->get('/v1/tentang', 'TentangController@get');
$router->post('/v1/tentang', 'TentangController@create');
$router->put('/v1/tentang/{id}', 'TentangController@update');

$router->get('/v1/kategori', 'KategoriController@get');
$router->get('/v1/kategori/{id}', 'KategoriController@getById');
$router->get('/v1/produkkategori/{id}', 'KategoriController@getByProduk');
$router->post('/v1/kategori', 'KategoriController@create');
$router->put('/v1/kategori/{id}', 'KategoriController@update');
$router->delete('/v1/kategori/{id}', 'KategoriController@delete');

$router->get('/v1/artikel', 'ArtikelController@get');
$router->get('/v1/artikel/{id}', 'ArtikelController@getById');
$router->post('/v1/artikel', 'ArtikelController@create');
$router->put('/v1/artikel/{id}', 'ArtikelController@update');
$router->delete('/v1/artikel/{id}', 'ArtikelController@delete');

$router->get('/v1/produk', 'ProdukController@get');
$router->get('/v1/produk/{id}', 'ProdukController@getById');
$router->post('/v1/produk', 'ProdukController@create');
$router->put('/v1/produk/{id}', 'ProdukController@update');
$router->delete('/v1/produk/{id}', 'ProdukController@delete');
