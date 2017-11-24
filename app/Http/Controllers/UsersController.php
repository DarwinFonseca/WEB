<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    //

    public function index(){
      $users = User::all()->toArray();

      return response()->json($users);
    }

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

    public function destroy($id_user){
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



}
