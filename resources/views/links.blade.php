<?php
$CrearPublicacion;
$MisPublicaciones;
$MiPerfil;
$CerrarSesion;
$IniciarSesion;


$this->CrearPublicacion="<a href='crear_publicacion' class='btn btn-primary'>Crear Publicación</a>";
$this->MisPublicaciones="<a href='mis_publicaciones' class='btn btn-success'>Mis Publicaciones</a>";
$this->MiPerfil="<a href='ActualizarUser' class='btn btn-danger'>Mi Perfil</a>";
//$this->CerrarSesion="<a href='logout' class='uk-button uk-button-danger uk-button-large'>Cerrar Sesión</a>";
$this->IniciarSesion="<a href='login'>Iniciar Sesión</a>";
?>

    @guest
<?php
echo "Para interactuar con el contenido debe $this->IniciarSesion.<br>";
?>
    @else
    <?php
    echo $this->CrearPublicacion ." ";
    echo $this->MisPublicaciones ." ";
    echo $this->MiPerfil ." ";
    //echo $this->CerrarSesion;
    ?>
    @endguest
