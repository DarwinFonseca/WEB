@extends('layouts.app')

@section('content')
  <head>
    <title>Bienvenido</title>
  </head>
  <body>
    <div class="container" >
      <div class="uk-container uk-align-center">
          <h1 class="uk-h1 uk-text-center">Bienvenido
            @guest
              Invitado <br>@include('links')
              <hr class='uk-grid-divider'>
            @else
              {{ Auth::user()->name }}
              <hr class='uk-grid-divider'>
              @include('links')<br><!--br>
              <pre>Su ID es {{ Auth::user()->id }}, Su Correo es {{ Auth::user()->email }}</pre-->
            @endguest
          </h1>

          <hr class='uk-grid-divider'>
          @if(session('info'))
          <div class="alert alert-success">{{session('info')}}</div>
          @endif
          @if(session('infoRed'))
          <div class="alert alert-danger">{{session('infoRed')}}</div>
          @endif
            <div class="uk-grid-divider uk-grid-margin uk-text-center">
           </div>
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
                    <td><a class="glyphicon glyphicon-thumbs-up" href='{{url("/ValidarVoto/{$publicacion->id_publicacion}")}}'/> {{$publicacion->votos}}</td>
                      <!--td><a class='glyphicon glyphicon-comment' href='{{url("/Comentarios/{$publicacion->id_publicacion}")}}'/> {{$publicacion->comentarios}}</td  DISQUS-->
                      <td><a class='glyphicon glyphicon-comment' href='{{url("/Comentarios/{$publicacion->id_publicacion}")}}'/> Comentar</td>
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
