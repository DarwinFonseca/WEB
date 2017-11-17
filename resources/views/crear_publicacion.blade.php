@extends('layouts.app')

@guest
//Redireccionado al index
@else
@endguest
@section('content')
<head>
  <title>Crear Bien</title>
</head>
<div class="container">
  <a href="{{URL('home')}}"><button value="Volver" class="btn">Volver</button></a>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Crear Publicación</div>
      <div class="panel-body" >
        <form class="form-horizontal" action="{{ url('/CrearPublicacion') }}" method="POST"> {{csrf_field()}}
          <br><label class="uk-form-label uk-h3 uk-align-left">Link:</label> <br />
          <br><input required class="form-control" type="text" name="link" id="link" placeholder="www.example.com" />
          <br><br><label class="uk-form-label uk-h3 uk-align-left">Descripción:</label> <br />
          <br><textarea required class="form-control" type="text" name="descripcion" id="descripcion" placeholder="Ejemplo: Introducción a la ingeniería social"  rows="4" cols="49"></textarea>
          <br><br>
          <button type="submit" class="btn btn-primary"value="Crear Publicacion"  id="btnCrearPublicacion" name="btnCrearPublicacion" >Crear Publicacion</button>
        </form>
      </div>
    <br><br>
    </div>


  @endsection
