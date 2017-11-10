<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\publicaciones;

class Control extends Controller
{
    //DARWIN FONSECA

    public function home(){
        $publicado = publicaciones::all();

        return view('home', ['publicado'  => $publicado]);

    }
}
