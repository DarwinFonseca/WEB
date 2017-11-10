@extends('layouts.app')

@section('content')
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido</title>
    <link href="/favicon.ico" rel="shortcut icon">
    <!-- link all the styles -->
    <link rel="stylesheet" href="../css/uikit.min.css" />
    <!-- link all the scripts -->
    <script src="../js/jquery.js"></script>
    <script src="../js/uikit.min.js"></script>
  </head>
  <body>
    <div class="container" >
      <div class="uk-container uk-align-center">
        <br>
          <h1 class="uk-h1 uk-text-center">Bienvenido
            @guest
                Invitado
            @else
            {{ Auth::user()->name }}
            <p>
            Su ID es {{ Auth::user()->id }}, Su Correo es {{ Auth::user()->email }}
            </p>
            @endguest
          </h1>
          <?php
          $this->CrearPublicacion="<a href='../vista/crear_publicacion.php' class='uk-button uk-button-primary uk-button-large'>Crear Publicación</a>";
          $this->MisPublicaciones="<a href='../vista/mis_publicaciones.php' class='uk-button uk-button-success uk-button-large'>Mis Publicaciones</a>";
          $this->MiPerfil="<a href='../vista/editar_perfil.php' class='uk-button uk-button uk-button-large'>Mi Perfil</a>";
          ?>
            <hr class='uk-grid-divider'>
            <div class="uk-grid-divider uk-grid-margin uk-text-center">
              <?php
              echo $this->CrearPublicacion ." ";
              echo $this->MisPublicaciones ." ";
              echo $this->MiPerfil ." ";
              ?>
           </div>
            <hr class='uk-grid-divider'>
            <!--a href="crear_publicacion.php">Publicar</a><br>
            <a href="../index.php">Cerrar sesión</a-->
            <div class="uk-overflow-auto">
              <table class="table">
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
                  @if(count($publicado) > 0 )
                   @foreach($publicado->all() as $publicacion)
                  <tr>
                    <td>{{ $publicacion->id_publicacion  }}</td>
                    <td>{{ $publicacion->descripcion  }}</td>
                    <td>{{ $publicacion->link  }}</td>
                    <td>{{ $publicacion->votos  }}</td>
                    <td>{{ $publicacion->comentarios }}</td>
                    <td>{{ $publicacion->estado  }}</td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>

              </table>
            </div>
            <br>
      </div>
    </div>
  </body>
@endsection
