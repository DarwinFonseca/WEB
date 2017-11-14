@extends('layouts.app')

@guest
//Redireccionado al index
@else
@endguest
<pre>Su ID es {{ Auth::user()->id }}, Su Correo es {{ Auth::user()->email }}</pre>
@section('content')
<head>
  <title>Crear Bien</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <div class="container">
    <div class="uk-container uk-container-center uk-text-center">
      <br>
      <h1>Crear publicación</h1>
      <div class="uk-vertical-align-middle" style="width: 600px;">
        <form class="uk-form uk-panel uk-panel-box" action="{{ url('/CrearPublicacion') }}" method="POST"> {{csrf_field()}}
          <br><label class="uk-form-label uk-h3 uk-align-left">Link:</label> <br />
          <br><input required class="uk-width-1-1 uk-form-large" type="text" name="link" id="link" placeholder="www.example.com" />
          <br><br><label class="uk-form-label uk-h3 uk-align-left">Descripción:</label> <br />
          <br><textarea required class="uk-width-1-1 uk-form-large" type="text" name="descripcion" id="descripcion" placeholder="Ejemplo: Introducción a la ingeniería social"  rows="4" cols="49"></textarea>
          <br><br><input class="uk-width-1-1 uk-button uk-button-primary uk-button-large" type="submit" value="Crear Publicacion"  id="btnCrearPublicacion" name="btnCrearPublicacion" />
        </form>
      </div>
    <br><br><a href="{{URL('home')}}"><button value="Volver" class="uk-grid-width-1-2 uk-button uk-button-danger uk-button-large">Volver</button></a></p>
    </div>
  </body>
  @endsection
