@extends('layouts.app')

@section('content')
  <head>
    <title>Bienvenido</title>
  </head>
  <body>
    <div class="container" >
      <div class="uk-container uk-align-center">
        <br>
          <h1 class="uk-h1 uk-text-center">Bienvenido
            @guest
              Invitado <br>@include('links')
              <?php
              $id=0;
              ?>
            @else
              {{ Auth::user()->name }}
              <?php
              $id=Auth::user()->id;
              ?>
              <br>@include('links')<br><br>
              <pre>Su ID es {{ Auth::user()->id }}, Su Correo es {{ Auth::user()->email }}</pre>
            @endguest
          </h1>

@if(session('info'))
<div class="alert alert-success">{{session('info')}}</div>
@endif
            <hr class='uk-grid-divider'>
            <div class="uk-grid-divider uk-grid-margin uk-text-center">
           </div>
            <hr class='uk-grid-divider'>
            <!--a href="crear_publicacion.php">Publicar</a><br>
            <a href="../index.php">Cerrar sesión</a-->
            <div class="uk-overflow-auto">
              <table class="table">
                @if(count($publicado) > 0)
                <thead>
                  <tr>
                    <th>Publicación</th><th>Usuario</th><th>Votos</th><th>Comentarios</th>
                  </tr>
                </thead>
                <tbody>
                   @foreach($publicado->all() as $publicacion)
                  <tr>
                    <td><a href=http:\\{{$publicacion->link}} target='_blank'> {{ $publicacion->descripcion  }} </a></td>
                    <td>{{$publicacion->name}}</td>
                    <td><a class='uk-icon-hover uk-icon-thumbs-o-up' href=''/>{{$publicacion->votos}}</td>
                    <td><a class='uk-icon-hover uk-icon-comments-o' href=''/>{{$publicacion->comentarios}}</td></tr>
                  </tr>
                  @endforeach
                  @else
                    @guest
                    <h2>Esta muy solo por aquí, <a href="{{url('register')}}">registrese</a> para contribuir con el contenido.</h2>
                    @else
                    <h2>Aún no existen publicaciones. :'( </h2>
                    @endguest
                  @endif
                </tbody>

              </table>
            </div>
            <br>
      </div>
    </div>
  </body>
@endsection
