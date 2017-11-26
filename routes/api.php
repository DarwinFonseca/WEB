<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

  Route::resource('users', 'UsersController', ['only' => [
    'index', 'store', 'show', 'update', 'destroy'
  ]]);

  Route::resource('publications', 'PublicationsController', ['only' => [
    'index', 'store', 'show', 'update', 'destroy'
  ]]);

  Route::get('/users/{id_user}/publications', 'PublicationsController@ConsutarPublicacion')->name('Mis Publicaciones');
  Route::get('/users/{id_user}/publications/{id_publicacion}', 'PublicationsController@ConsutarPublicacion')->name('Mis Publicaciones');

  Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
  });
