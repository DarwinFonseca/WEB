<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Auth;
use App\votos;
use App\comentarios;
use App\publicaciones;
use App\publicacionesxusuario;


class Control extends Controller
{
    //DARWIN FONSECA

    /**
     * La funcion redirige hacia la página principal
     *
     *La función regresa a la pagina 'home' una variable '$publicado' que contiene el resultado de la busqueda
     *en la base de datos de las publicaciones que se han realizado y estan activas
     *ordenadolas descendientemente por sus votos
     *
     **/
    public function home(){

      $publicado=DB::table('publicaciones')
      ->select('publicaciones.*', 'publicacionesxusuarios.*', 'users.*')
      ->leftJoin('publicacionesxusuarios', 'publicaciones.id_publicacion', '=', 'publicacionesxusuarios.id_publicacion')
      ->leftJoin('users', 'publicacionesxusuarios.id_user', '=', 'users.id')
      ->where('estado', 'like', 'activo')
      ->orderByRaw('votos DESC')
      ->get();
      return view('home', ['publicado'  => $publicado]);
    }







}
