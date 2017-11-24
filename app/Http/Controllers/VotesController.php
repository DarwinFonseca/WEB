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

class VotesController extends Controller
{

  /**
   * La función 'ValidarVoto' recibe el id de la publicación para verificar en la base de datos
   * si existe o no registro del usuario (por medio de su Id) en la tabla 'votos'
   *
   *Si existe el id del usuario NO está vinculado con el id de la publicación entonces
   *ejecuta las funciones "AgregarVotante" y "AgregarVotos"
   *
   *Si por el contrario los datos ya están vinculados en la tabla 'votos'
   *la funcion "ValidarVoto" ejecuta las funciones 'EliminarVotante' y 'EliminarVotos'
   *
   *Dependiendo de la decición tomada regresará a la página 'home' con un mensaje correspondiente
   **/
  public function ValidarVoto($id_publicacion) {
    if (isset(Auth::user()->id)) {
      $id_user=Auth::user()->id;
      $MisPubs=DB::table('votos')
        ->select('votos.*')
        ->where('votos.id_publicacion', 'like', $id_publicacion)
        ->where('votos.id_user', 'like', $id_user)
        ->first();

      if ($MisPubs==null) {
        $this->AgregarVotante($id_publicacion);
        $this->AgregarVotos($id_publicacion);
        return redirect('/home')->with('info','Voto agregado.');
      }else {
        $this->EliminarVotante($id_publicacion);
        $this->EliminarVotos($id_publicacion);
        return redirect('/home')->with('infoRed','Voto eliminado.');
      }
    }else{
      return redirect('/home')->with('infoRed','Recuerde iniciar sesion para interactuar con el contenido.');
    }
  }


  /**
  *La función "AgregarVotos" recibe el id de la Publicación para buscar el número de votos en la publicacion
  *Este valor lo extrae y le suma una unidad para luego actualizar por medio de un UPDATE el registro de la publicacion
  *
  **/
  public function AgregarVotos($id_publicacion){
    //Extraer de la DB el # de votos de la Publicación
          $Votos=DB::table('publicaciones')
          ->select('votos')
          ->where('id_publicacion', 'like', $id_publicacion)
          ->first();//first para extraer el valor exacto (único)
          //return "el numero de votos en la publicacion # ".$id_publicacion." es de: ".$Votos->votos;
          $SumarVoto=$Votos->votos+1;
          //return "el numero de votos en la publicacion # ".$id_publicacion." es de: ".$Votos->votos. " El valor total es: ".$SumarVoto;
          $query = DB::update('update publicaciones set votos='.$SumarVoto.' where id_publicacion='.$id_publicacion);
  }

  /**
  *La función "EliminarVotos" recibe el id de la Publicación para buscar el número de votos en la publicacion
  *Este valor lo extrae y le resta una unidad para luego actualizar por medio de un UPDATE el registro de la publicacion
  *
  **/
  public function EliminarVotos($id_publicacion){
    //Extraer de la DB el # de votos de la Publicación
    $Votos=DB::table('publicaciones')
    ->select('votos')
    ->where('id_publicacion', 'like', $id_publicacion)
    ->first();//first para extraer el valor exacto (único)
    //return "el numero de votos en la publicacion # ".$id_publicacion." es de: ".$Votos->votos;
    $RestarVoto=$Votos->votos-1;
    //return "el numero de votos en la publicacion # ".$id_publicacion." es de: ".$Votos->votos. " El valor total es: ".$RestarVoto;
    $query = DB::update('update publicaciones set votos='.$RestarVoto.' where id_publicacion='.$id_publicacion);
  }

  /**
  *La función "AgregarVotante" recibe el id de la Publicación para con el Id del usuario que ha iniciado sesion
  *registrarlos en la base de datos
  *
  **/
  public function AgregarVotante($id_publicacion) {
    $Votante = new votos;
    $Votante->id_user=Auth::user()->id;
    $Votante->id_publicacion=$id_publicacion;
    $Votante->save();
  }

  /**
  *La función "EliminarVotante" recibe el id de la Publicación para con el Id del usuario que ha iniciado sesion
  *eliminar el registro de la tabla 'votos' en la base de datos
  *
  **/
  public function EliminarVotante($id_publicacion) {
    $query = DB::update('DELETE FROM votos WHERE id_publicacion='.$id_publicacion.' AND id_user='.Auth::user()->id);
  }

}
