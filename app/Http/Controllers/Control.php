<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Auth;
use App\votos;
use App\comentarios;
use App\publicaciones;
use App\publicacionesxusuario;

class Control extends Controller
{
    //DARWIN FONSECA

/*    public function home(){
        $publicado = publicaciones::all();
        return view('home', ['publicado'  => $publicado]);
      }
  */

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
      if ($estado=="activo") {
          $query = DB::update('update publicaciones set estado="inactivo" where id_publicacion='.$id_publicacion);
          return redirect('/mis_publicaciones')->with('info','La publicación # '.$id_publicacion.' está Inactiva');
        }else{
          $query = DB::update('update publicaciones set estado="activo" where id_publicacion='.$id_publicacion);
          return redirect('/mis_publicaciones')->with('info','La publicación # '.$id_publicacion.' está Activa');
      }
    }

    public function EliminarPublicacion($id_publicacion){
      $query = DB::update('delete from publicaciones where id_publicacion='.$id_publicacion);
      $query = DB::update('delete from votos where id_publicacion='.$id_publicacion);
      $query = DB::update('delete from publicacionesxusuarios where id_publicacion='.$id_publicacion);
      $query = DB::update('delete from comentarios where id_publicacion='.$id_publicacion);
      return redirect('/mis_publicaciones')->with('info','La publicación # '.$id_publicacion.' se eliminó correctamente.');
    }

    public function ValidarVoto($id_publicacion) {
      //$res_user=null; $res_publicacion=null;
      if (isset(Auth::user()->id)) {
        $id_user=Auth::user()->id;
        $MisPubs=DB::table('votos')
        /*->select('votos.*', 'publicaciones.id_publicacion', 'users.id')
        ->leftJoin('publicaciones', 'publicaciones.id_publicacion', '=', 'votos.id_publicacion')
        ->leftJoin('users', 'votos.id_user', '=','users.id')
        ->where('publicaciones.id_publicacion', 'like', $id_publicacion, 'AND', 'users.id', 'like', $id_user )
        */
        ->select('votos.*')
        ->where('votos.id_publicacion', 'like', $id_publicacion)
        ->where('votos.id_user', 'like', $id_user)
        ->first();

        //echo DD($MisPubs);

        //$res_user=$MisPubs->id_user;
        //$res_publicacion=$MisPubs->id_publicacion;

        //if ($res_user==$id_user && $res_publicacion==$id_publicacion) {
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
      /*
        $query = "SELECT `votos`.`id_user`, `votos`.`id_publicacion` FROM votos
        LEFT JOIN `publicaciones` ON `publicaciones`.`id_publicacion` = `votos`.`id_publicacion`
        LEFT JOIN `usuarios` ON `usuarios`.`id_user` = `votos`.`id_user`
        WHERE `publicaciones`.`id_publicacion` = '$id_publicacion' AND `usuarios`.`id_user` = '$id_user'";
        $result = mysql_query($query);

      while ($row = mysql_fetch_array($result)) {
        $res_id_user=$row['id_user'];
        $res_id_publicacion=$row['id_publicacion'];
      }
      #echo "$query<br>";
      if ($res_id_user==null&&$res_id_publicacion==null) {
        $this->AgregarVotante($id_user, $id_publicacion);
        $this->AgregarVotos($id_publicacion);

        }else {
          #echo "<p>Usted ya votó en esta publicación</p>";
          $this->EliminarVotos($id_publicacion);
          $this->EliminarVotante($id_user, $id_publicacion);
          #echo "<p>Usuario encontrado: $res_id_user";
          #echo "<p>Publicación encontrada: $res_id_publicacion";
        }
      }
      #echo "<p>Usuario dado: $id_user";
      #echo "<p>Publicación dada: $id_publicacion";
      */
    }

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

    public function AgregarVotante($id_publicacion) {
            $Votante = new votos;
            $Votante->id_user=Auth::user()->id;
            $Votante->id_publicacion=$id_publicacion;
            $Votante->save();
      }

    public function EliminarVotante($id_publicacion) {
      $query = DB::update('DELETE FROM votos WHERE id_publicacion='.$id_publicacion.' AND id_user='.Auth::user()->id);
    }





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

      return view('comentarios', ['Mostrar'  => $Mostrar], ['MisPubs' => $MisPubs]);
    }

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

    public function MostrarComentarios($id_publicacion){


      $result = mysql_query($query);

        
    }



}
