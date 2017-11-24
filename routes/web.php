<?php
/*
| Web Routes
*/
Route::get('/', function () {
    return view('home');
});
Route::get('/index', function () {
    return view('home');
});

Route::get('/crear_publicacion', function () {
    return view('crear_publicacion');
});

Route::get('/mis_publicaciones', function () {
    return view('mis_publicaciones');
});

Route::get('/Comentarios', function () {
    return view('comentarios');
});

Route::get('/ActualizarUser', function () {
    return view('/auth/edit');
});

Auth::routes();

Route::get('/', 'Control@home')->name('home');
Route::get('/index', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/index', 'Control@home')->name('home');
Route::get('/home', 'Control@home')->name('home');

Route::post('/ActualizarUser', 'UsersController@ActualizarUser')->name('Actualizar Usuario');
Route::post('/CrearPublicacion', 'PublicationController@CrearPublicacion')->name('Crear Publicacion');
Route::get('/mis_publicaciones', 'PublicationController@ConsutarMisPublicaciones')->name('Mis Publicaciones');
Route::get('/CambiarEstado/{estado}/{id_publicacion}', 'PublicationController@CambiarEstado')->name('Mis Publicaciones');
Route::get('/EliminarPublicacion/{id_publicacion}', 'PublicationController@EliminarPublicacion')->name('Mis Publicaciones');
Route::get('/ValidarVoto/{id_publicacion}', 'VotesController@ValidarVoto')->name('Votos');
Route::get('/Comentarios/{id_publicacion}', 'CommentController@PublicacionAComentar')->name('Comentarios');
Route::post('/SubirComentario', 'CommentController@SubirComentario')->name('Comentarios');
