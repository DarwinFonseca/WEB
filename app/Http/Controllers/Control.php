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
        //echo "<pre>";
        //print_r($publicado);
        //echo "</pre>";
    }

    public function PublicacionUsuario($id){
        $PublicacionxUsuario = new publicacionesxusuario;
        $PublicacionxUsuario->id_user = $id;
        $PublicacionxUsuario->save();
    }

    public function CrearPublicacion(Request $request){
      $this->validate($request, [
        'link' => 'required',
        'descripcion' => 'required'
      ]);

      $publicado = new publicaciones;
      $publicado->link = $request->input('link');
      $publicado->descripcion = $request->input('descripcion');
      $publicado->votos = 0;
      $publicado->comentarios = 0;
      $publicado->estado = 'activo';
      $publicado->save();

      return redirect('/')->with('info','Publicación exitosa!');
    }
}
