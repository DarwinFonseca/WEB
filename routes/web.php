<?php
/*
| Web Routes
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
Route::get('/EliminarPublicacion/{id_publicacion}', 'Control@EliminarPublicacion');
Route::get('/ValidarVoto/{id_publicacion}', 'Control@ValidarVoto');
Route::get('/AgregarVotos/{id_publicacion}', 'Control@AgregarVotos');
Route::get('/EliminarVotos/{id_publicacion}', 'Control@EliminarVotos');
