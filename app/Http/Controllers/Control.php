<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\publicaciones;
use App\publicacionesxusuario;
use Auth;

class Control extends Controller
{
    //DARWIN FONSECA

/*    public function home(){
        $publicado = publicaciones::all();
        return view('home', ['publicado'  => $publicado]);
      }
  */

    public function PublicacionUsuario($id){

        $PublicacionxUsuario = new publicacionesxusuario;
        $PublicacionxUsuario->id_user = $id;
        $PublicacionxUsuario->save();

        return $id;
    }

    public function CrearPublicacion(Request $request){

      $PubxUser = new publicacionesxusuario;
      $PubxUser->id_user=Auth::user()->id;
      $PubxUser->save();

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

    public function ConsutarMisPublicaciones(){
      $MisPubs=DB::table('publicaciones')
      ->select('publicaciones.*', 'users.*', 'publicacionesxusuarios.*')
      ->leftJoin('publicacionesxusuarios', 'publicaciones.id_publicacion', '=', 'publicacionesxusuarios.id_publicacion')
      ->leftJoin('users', 'publicacionesxusuarios.id_user', '=','users.id')
      ->where('publicacionesxusuarios.id_user', 'like', Auth::user()->id)
      ->orderByRaw('votos DESC')
      ->get();

      return view('mis_publicaciones', ['MisPubs' => $MisPubs]);
    }

    public function CambiarEstado($estado, $id_publicacion){
      return 'cambiando estado';
      /*
      if ($estado=="activo") {
        $query=" `publicaciones` SET `estado` = 'inactivo' WHERE `publicaciones`.`id_publicacion` = $id_publicacion";
        mysql_query($query);
      }else{
        $query="UPDATE `publicaciones` SET `estado` = 'activo' WHERE `publicaciones`.`id_publicacion` = $id_publicacion";
        mysql_query($query);
      }*/

    }
}
