<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('home');
});

Route::get('/crear_publicacion', function () {
    return view('crear_publicacion');
});

Route::get('/mis_publicaciones', function () {
    return view('mis_publicaciones');
});

Route::get('/editar_perfil', function () {
    return view('editar_perfil');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'Control@home')->name('home');
Route::get('/', 'Control@home')->name('home');

Route::post('/CrearPublicacion', 'Control@CrearPublicacion');
Route::get('/mis_publicaciones', 'Control@ConsutarMisPublicaciones');
Route::get('/CambiarEstado/{estado}/{id_publicacion}', 'Control@CambiarEstado');
