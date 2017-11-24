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

class PublicationController extends Controller
{
    public function PublicacionUsuario($id){

        $PublicacionxUsuario = new publicacionesxusuario;
        $PublicacionxUsuario->id_user = $id;
        $PublicacionxUsuario->save();

        return $id;
    }

    /**
    * La función "CrearPublicacion" recibe los valores de la página 'CrearPublicación' en un 'Request' enviados por medio de un form
    *validando la información del formulario
    *
    *La función crea un registro en la tabla 'PublicacionxUsuario' (id del usuario)
    *al igual que en la tabla 'publicaciones' (link, descripción)
    *
    *La función regresa a la página principal con un mensaje de información
    */
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

    /*
    *La función "ConsutarMisPublicaciones" utiliza el id del usuario para
    *filtrar la información de la base de datos referente a las publicaciones de cada usuario
    *
    *la función regresa a la vista 'Mis Publicaciones' con una variable 'MisPubs' que contiene los datos extraídos de la base de datos
    */
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

    /**
    *La función "CambiarEstado" recibe el id de la Publicación y el Estado de esta para validar en la base de datos si la publicacion
    * está activa o no.
    *
    *Dependiendo del valor encontrado realizará una actualización por medio de UPDATE para cambiar el estado de la publicación
    *
    *La función redirige a la página 'Mis Publicaciónes' con la información pertinente.
    **/
    public function CambiarEstado($estado, $id_publicacion){
      if ($estado=="activo") {
          $query = DB::update('update publicaciones set estado="inactivo" where id_publicacion='.$id_publicacion);
          return redirect('/mis_publicaciones')->with('info','La publicación # '.$id_publicacion.' está Inactiva');
        }else{
          $query = DB::update('update publicaciones set estado="activo" where id_publicacion='.$id_publicacion);
          return redirect('/mis_publicaciones')->with('info','La publicación # '.$id_publicacion.' está Activa');
      }
    }


    /**
    *La función "EliminarPublicacion" recibe el id de la Publicación para
    *eliminar el registro de las diferentes tablas en la base de datos que contengan la información
    *vinculada con está publicación
    *
    *La función redirige a la página 'Mis Publicaciónes' con la información pertinente.
    */
    public function EliminarPublicacion($id_publicacion){
      $query = DB::update('delete from publicaciones where id_publicacion='.$id_publicacion);
      $query = DB::update('delete from votos where id_publicacion='.$id_publicacion);
      $query = DB::update('delete from publicacionesxusuarios where id_publicacion='.$id_publicacion);
      $query = DB::update('delete from comentarios where id_publicacion='.$id_publicacion);
      return redirect('/mis_publicaciones')->with('info','La publicación # '.$id_publicacion.' se eliminó correctamente.');
    }

}
