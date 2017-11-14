<?php
$CrearPublicacion;
$MisPublicaciones;
$MiPerfil;
$CerrarSesion;
$IniciarSesion;


$this->CrearPublicacion="<a href='crear_publicacion' class='label label-primary'>Crear Publicación</a>";
$this->MisPublicaciones="<a href='mis_publicaciones' class='label label-success'>Mis Publicaciones</a>";
$this->MiPerfil="<a href='editar_perfil' class='label label-danger'>Mi Perfil</a>";
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
