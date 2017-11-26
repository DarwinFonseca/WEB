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

class CommentsController extends Controller
{
  /**
   * La función "PublicacionAComentar" recibe el ID de la publicación en la cuál se va a comentar
   * Extrae los valores correpondientes de la base de datos para luego
   *  mostrar los datos básicos de la publicacion que va a comentar y  los comentarios ya realizados
   *
   *La función regresa los datos extraídos en los variables 'Mostrar' y 'MisPubs' hacia la página 'comentarios'
   */
    public function PublicacionAComentar($id_publicacion){

      $Mostrar=DB::table('publicaciones')
      ->select('publicaciones.*','publicacionesxusuarios.*', 'users.*')
      ->leftJoin('publicacionesxusuarios', 'publicaciones.id_publicacion', '=', 'publicacionesxusuarios.id_publicacion')
      ->leftJoin('users', 'publicacionesxusuarios.id_user', '=','users.id')
      ->where('publicaciones.id_publicacion', 'like', $id_publicacion)
      ->get();

      $MisPubs=DB::table('comentarios')
      ->select('comentarios.*', 'users.*')
      ->leftJoin('users', 'comentarios.id_user', '=', 'users.id')
      ->where('comentarios.id_publicacion', 'like', $id_publicacion)
      ->get();

      //return response()->json($MisPubs);
      //echo DD(json_decode($MisPubs));
      return view('comentarios', ['Mostrar'  => $Mostrar], ['MisPubs' => $MisPubs]);
    }

    /**
     * La función "SubirComentario" recibe los valores de la página comentarios en un 'Request' enviados por medio de un form
     *Luego de crear el registro en la base de datos del comentarios, se ejecuta la función "SumarComentario"
     *
     *La función se redirige a la página comentarios junto con el ID de la publicación
     *en la que está para que actualice la página correctamente ya que la página de Comentarios ejecuta la función
     *"PublicaciónAComentar".
     */
      public function SubirComentario(Request $request){

      $id_p=$request->id_publicacion;

      $SubirComm = new comentarios;
      $SubirComm->id_user=Auth::user()->id;
      $SubirComm->id_publicacion=$request->id_publicacion;
      $SubirComm->comentario=$request->comentario;
      $SubirComm->save();

      $this->SumarComentario($id_p);
      return redirect('/Comentarios/'.$id_p)->with('info','Comentario agregado.');
    }

    /**
    *La función "SumarComentario" recibe el id de la Publicación para buscar el número de comentarios en la publicacion
    *Este valor lo extrae y le suma una unidad para luego actualizar por medio de un UPDATE el registro de la publicacion
    *
    **/
    public function SumarComentario($id_publicacion){
      //Extraer de la DB el # de votos de la Publicación
      $Valor=DB::table('publicaciones')
      ->select('comentarios')
      ->where('id_publicacion', 'like', $id_publicacion)
      ->first();//first para extraer el valor exacto (único)
      //return "el numero de comentarios en la publicacion # ".$id_publicacion." es de: ".;
      $SumarValor=$Valor->comentarios+1;
      //return "el numero de votos en la publicacion # ".$id_publicacion." es de: ".$valor->comentarios. " El valor total es: ".$Sumarvalor;
      $query = DB::update('update publicaciones set comentarios='.$SumarValor.' where id_publicacion='.$id_publicacion);
    }
}
