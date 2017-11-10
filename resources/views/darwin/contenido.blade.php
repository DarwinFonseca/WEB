@extends('layouts.app')

@section('content')


    <div class="container" >
      <div class="uk-container uk-align-center">
        <br>
          <h1 class="uk-h1 uk-text-center">Bienvenido <?=$_SESSION['username'];?> </h1>
            <!--p>
              Su ID es <?=$_SESSION['id_user'];?>, Su Correo es <?=$_SESSION['correo'];?>, Su Password es <?=$_SESSION['password'];?>
            </p-->
            <hr class='uk-grid-divider'>
            <div class="uk-grid-divider uk-grid-margin uk-text-center">
            <?php
              require_once '../controlador/links.php';
              $mostrar = new links();
              $mostrar->MostrarLinks();
             ?>
           </div>
            <hr class='uk-grid-divider'>
            <!--a href="crear_publicacion.php">Publicar</a><br>
            <a href="../index.php">Cerrar sesión</a-->
            <div class="uk-overflow-auto">
              <?php
                require_once '../modelo/publicar.php';
                $mostrar = new publicar();
                $mostrar->ConsutarPublicaciones();
               ?>
               <!-- /.table-responsive -->
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
@endsection
