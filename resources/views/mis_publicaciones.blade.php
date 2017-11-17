@extends('layouts.app')

@guest
//Redireccionado al index
@else
@endguest
@section('content')

  <head>
    <title>Mis Publicaciones</title>
  </head>
  <body>
    <div class="container" >
      <div class="uk-container uk-align-center">
        <a href="{{URL('home')}}"><button value="Volver" class="btn">Volver</button></a></p>
        <hr class='uk-grid-divider'>
          <h1 class="uk-h1 uk-text-center">Bienvenido {{Auth::user()->name}}</h1>
            <div class="uk-grid-divider uk-grid-margin uk-text-center">
          </div><hr class='uk-grid-divider'>
            <!--a href="crear_publicacion.php">Publicar</a><br>
            <a href="../index.php">Cerrar sesión</a-->
            <div class="uk-overflow-auto">

              @if(session('info'))
              <div class="alert alert-success">{{session('info')}}</div>
              @endif

              <table class="table">
                @if(count($MisPubs) > 0)
                <thead>
                  <tr>
                    <th>Id Publicacion</th>
                    <th>Descripción</th>
                    <th>Link</th>
                    <th>Votos</th>
                    <th>Comentarios</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                   @foreach($MisPubs->all() as $publicacion)
                  <tr>
                    <td>{{ $publicacion->id_publicacion  }}</td>
                    <td>{{ $publicacion->descripcion  }}</td>
                    <td><a href=http:\\{{$publicacion->link}} target='_blank'> {{ $publicacion->link  }}</a></td>
                    <td><a class='glyphicon glyphicon-thumbs-up' /> {{$publicacion->votos}}</td>
                    <td><a class='glyphicon glyphicon-comment' href='{{url("/Comentarios/{$publicacion->id_publicacion}")}}'/> {{$publicacion->comentarios}}</td>
                    <td><a href='{{url("/CambiarEstado/{$publicacion->estado}/{$publicacion->id_publicacion}")}}'>{{ $publicacion->estado  }}</a></td>
                    <td><a href='{{url("/EliminarPublicacion/{$publicacion->id_publicacion}")}}' class='label label-danger'>Eliminar</a></td>
                  </tr>
                  @endforeach
                  @else
                    @guest
                    <h2>Esta muy solo por aquí, <a href="{{url('register')}}">registrese</a> para contribuir con el contenido.</h2>
                    @else
                    <h2>Usted no ha creado publicaciones. :'( </h2>
                    @endguest
                  @endif
                </tbody>

              </table>




            </div>
            <br>
<!--?php
//trae el código para editar los usuarios según el r01
require_once '../controlador/links.php';
$vinculos = new links();
$vinculos->MostrarLinks();
?-->
      </div>
    </div>
  </body>
@endsection
