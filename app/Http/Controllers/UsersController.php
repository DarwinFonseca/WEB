<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{

  /**
   * La funcion regresa un JSON con los valores de todos los usuarios encontrados en un ARRAY
   *
   **/
    public function index(){
      $users = User::all()->toArray();

      return response()->json($users);
    }

    /**
     * La funcion 'store' recibe los datos eviados en '$request' como un 'Request' para almacenarlos
     * en la base de datos.
     *
     * La funcion regresa un JSON que contiene un ARRAY con el estado y el codigo del mismo
     *
     **/
    public function store(Request $request){
      try{
        $user = new User([
          'name'=>$request->input('name'),
          'email'=>$request->input('email'),
          'password'=>bcrypt($request->input('password')),
        ]);
        Log::info('Usuario almacenado');
        $user->save();
        return response()->json(['status'=>true, 'Exito al almacenar'], 200);
      }catch (\Exception $e){
        Log::critical("No se pudo almacenar el usuario: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()} ");
        return response('Error al almacenar', 500);
      }
    }

    /**
     * La funcion 'show' recibe los datos la variable '$id_user' para filtrar
     * en la base de datos.
     *
     * La funcion regresa un JSON que con los datos del Usuario encontrado o en su defecto el error y el codigo del estado
     *
     **/
    public function show($id_user){
      try {
        $user = User::find($id_user);
        if (!$user) {
          # code...
          return response()->json(['No existe un usuario con ese ID'], 404);
        }
        return response()->json($user,200);
      } catch (\Exception $e) {
          Log::critical("No se encontro el usuario: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()} ");
          return response('Error al buscar, intente de nuevo',500);
      }
    }

    /**
     * La funcion 'destroy' recibe los datos la variable '$id_user' para filtrar
     * en la base de datos.
     *
     * La funcion regresa un JSON que con el reporte y el codigo del estado
     *
     **/    public function destroy($id_user){
      try {
        $user = User::find($id_user);
        if (!$user) {
          # code...
          return response()->json(['No existe un usuario con ese ID'], 404);
        }
        $user->delete();
        return response()->json("Usuario eliminado",200);
      } catch (\Exception $e) {
          Log::critical("No se encontro el usuario: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()} ");
          return response('Error al eliminar, intente de nuevo',500);
      }
    }

    /**
     * La funcion ActualizarUser sobre-escribe los datos de un usuario recibiendo los parametros en un 'Request'
     *
     *La función regresa a la pagina 'ActualizarUser' luego de haber realizado
     *los cambios en la base de datos con la informacion de exito o en su defecto fracaso
     **/
    public function ActualizarUser(Request $request){

      if ($request->password==$request->password_confirmation) {
        $validatedData = $request->validate([
        'password' => 'required|min:6',
        'password_confirmation' => 'required',
      ]);
              DB::table('users')
              ->where('id', Auth::user()->id)
              ->update(['name' => $request->name, 'email' => $request->email, 'password' => bcrypt($request->password)]);
            return redirect('/ActualizarUser')->with('info','Datos de usuario actualizados.');
          }else{
            return redirect('/ActualizarUser')->with('infoRed','Diligencie bien el formato.');
          }
    }


}
