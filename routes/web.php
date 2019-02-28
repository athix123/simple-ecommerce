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

// TENTANG
$router->get('/v1/tentang', 'TentangController@get');
$router->group(['prefix' => 'v1/tentang',  'middleware' => 'auth'], function () use ($router) {
	$router->post('/', 'TentangController@create');
	$router->put('/{id}', 'TentangController@update');
	// $router->delete('/delete/{id}', 'MajorController@delete');
});

// KATEGORI
$router->get('/v1/kategori', 'KategoriController@get');
$router->get('/v1/kategori/{id}', 'KategoriController@getById');
$router->get('/v1/produkkategori/{id}', 'KategoriController@getByProduk');
$router->group(['prefix' => '/v1/kategori',  'middleware' => 'auth'], function () use ($router) {
	$router->post('/', 'KategoriController@create');
	$router->put('/{id}', 'KategoriController@update');
	$router->delete('/{id}', 'KategoriController@delete');
});

// ARTIKEL
$router->get('/v1/artikel', 'ArtikelController@get');
$router->get('/v1/artikel/{id}', 'ArtikelController@getById');
$router->group(['prefix' => 'v1/artikel',  'middleware' => 'auth'], function () use ($router) {
	$router->post('/', 'ArtikelController@create');
	$router->put('/{id}', 'ArtikelController@update');
	$router->delete('/{id}', 'ArtikelController@delete');
});

// PRODUK
$router->get('/v1/produk', 'ProdukController@get');
$router->get('/v1/produk/{id}', 'ProdukController@getById');
$router->group(['prefix' => 'v1/produk',  'middleware' => 'auth'], function () use ($router) {
	$router->post('/', 'ProdukController@create');
	$router->put('/{id}', 'ProdukController@update');
	$router->delete('/{id}', 'ProdukController@delete');
});

