<?php
session_start();
if (!isset($_SESSION['login'])) {
    if (isset($_POST['login']) && $_POST['login'] == "si") {
        $_SESSION["login"] = "ok";
        $_SESSION["usu"] = $_REQUEST['usernamedesdeprocesar'];
    } else {
        header('Location: index.php');
    }
}
    echo '<div id="info">';
    echo("Bienvenid@ ".$_SESSION["usu"]);
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.respuestaphpbuena').fadeOut(2000);
                $('.respuestaphpmala').fadeOut(2000);
                $('input[type=checkbox]').on('click', function () {
                    var parent = $('.checkboxes').attr('class');
                    $('.' + parent + ' input[type=checkbox]').removeAttr('checked');
                    //$(this).attr('checked', 'checked');
                    this.checked = 'checked';
                });
            });
        </script>
        <script>
            function muestra(valor) {
                /* document.getElementById('addpersonaform').style.display="inherit";*/
                document.getElementById(valor).className = "mostrar";
            }
            function ocultar(valor) {
                // document.getElementById('addpersonaform').style.display="none";
                document.getElementById(valor).className = "ocultos";
            }
        </script>
        <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
    </head>
    <body>
        <?php
        include_once 'Persona.php';
        include_once 'Pelicula.php';
        include_once 'Usuario.php';
        $respuestas = new Respuestas();
        $usuario = new Usuario();
        $pelicula = new Pelicula();
        $persona = new Persona();
        echo '</br>';
        $idUsuario = $usuario->dimeId($_SESSION["usu"]);
        echo(" tu id ".$idUsuario);
        $rolDeUsuario = $usuario->dimeRol($idUsuario);
        echo '</br>';
        echo(" tu rol ".$rolDeUsuario);
        $permisos = $usuario->dimePermisos($rolDeUsuario);
        $usuario->asignarPermisos($permisos);
        echo '</br>';
        echo(" tus permisos; ver:");
        var_dump( $usuario->permisover );
        echo '</br>';
        echo(" tus permisos; insertar:");
        var_dump( $usuario->permisoinsertar );
        echo '</br>';
        echo(" tus permisos; modificar:");
        var_dump( $usuario->permisomodificar );
        echo '</br>';
        echo(" tus permisos; borrar:");
        var_dump( $usuario->permisodelete );
        echo('<form class="cierresesion" method="post" action="'.$_SERVER['PHP_SELF'].'">');
        echo '<input type=submit name="cerrarsesion" value="cerrar sesion">';
        echo ('</form>');
        echo '</br>';
        echo '</div>';
        if (isset($_REQUEST['addpeliculaformenvio'])) {
            $pelicula->addPelicula($_REQUEST['cod_pelicula'], $_REQUEST['titulo'], $_REQUEST['genero'], $_REQUEST['pais'], $_REQUEST['year']);
        }
        if(isset($_REQUEST['addpersonaformenvio'])){
            $persona->addPersona($_REQUEST['cod_persona'],$_REQUEST['nombre'],$_REQUEST['apellidos'],$_REQUEST['pais']);
        }
        if (isset($_REQUEST['mostrarpeliculas'])) {
            $pelicula->dibujaTabla($usuario);
        }
        if (isset($_REQUEST['mostrarpersonas'])) {
            $persona->dibujaTabla($usuario);
        }
        if (isset($_REQUEST['cerrarsesion'])){
            session_destroy();
            header('Location: index.php');
        }
        if (isset($_REQUEST['borrarseleccionpelicula'])) {
            $codPelicula = $_REQUEST['checkboxseleccionada'];
            $pelicula->borrarPelicula($codPelicula);
        }
        if(isset($_REQUEST['modificarseleccionpelicula'])){
            $codPelicula = $_REQUEST['checkboxseleccionada'];
            echo($codPelicula);
            $pelicula->buscarPelicula($codPelicula);
        }
        if (isset($_REQUEST['eliminarpeliculaformenvio'])) {
            $codPelicula = $_REQUEST['cod_pelicula'];
            $pelicula->borrarPelicula($codPelicula);
        }
        if(isset($_REQUEST['eliminarpersonaformenvio'])){
            $codPersona = $_REQUEST['cod_persona'];
            $persona->borrarPersona($codPersona);
        }
        if(isset($_REQUEST['borrarseleccionpersona'])){
            $codPersona = $_REQUEST['checkboxseleccionada'];
            $persona->borrarPersona($codPersona);
        }
        if(isset($_REQUEST['guardarcambiosmodificacion'])){
            $pelicula->modifica($_REQUEST['cod_pelicula'], $_REQUEST['titulo'], $_REQUEST['genero'], $_REQUEST['pais'], $_REQUEST['year']);
        }
        ?>
        <h2>Admin panel</h2>
        </br>
        <div class="formulario">
            <h3>Peliculas</h3>
            <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <?php 
                if($usuario->permisoinsertar){
                    echo '<label for="addpelicula">Añadir Pelicula : </label><input type="button" name="addpelicula" value="addpelicula" onclick="muestra(this.value);">';
                    echo '</br>';
                }
                
                if($usuario->permisodelete){
                    echo '<label for="eliminarpelicula">Eliminar Pelicula: : </label><input type="button" name="eliminarpelicula" value="eliminarpelicula" onclick="muestra(this.value);">';
                    echo '</br>';
                }
                
                if($usuario->permisomodificar){
                    echo '<label for="modpelicula">Modificar Pelicula: : </label><input type="button" name="modpelicula" value="modpelicula" onclick="muestra(this.value);">';
                    echo '</br>';
                }
                
                echo '<label for="mostrarpeliculas">Mostrar Peliculas: : </label><input type="submit" name="mostrarpeliculas" value="Mostrar Peliculas">';
                ?>
            </form>
        </div>
        </br>
        <div class="formulario">
            <h3>Personas</h3>
            <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <?php
                if($usuario->permisoinsertar){
                    echo '<label for="addpersona">Añadir persona : </label><input type="button" name="addpersona" value="addpersona" onclick="muestra(this.value);" >';
                    echo '</br>';
                }
                
                if($usuario->permisodelete){
                    echo '<label for="eliminarpersona">Eliminar persona: : </label><input type="button" name="eliminarpersona" value="eliminarpersona" onclick="muestra(this.value);">';
                    echo '</br>';
                }
                
                if($usuario->permisomodificar){
                    echo '<label for="modpersona">Modificar persona: : </label><input type="button" name="modpersona" value="modpersona" onclick="muestra(this.value);">';
                    echo '</br>';
                }
                
                echo '<label for="mostrarpersonas">Mostrar Personas: : </label><input type="submit" name="mostrarpersonas" value="Mostrar Personas">';
                ?>
            </form>
        </div>   
        </br>
        <div id="formulariobusqueda">
            <h3>Busqueda</h3>
            <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="search">Search : </label><input type="text" name="search" value="Busqueda ..." >
                <input type="submit" name="buscar" value="buscar" >
            </form>
        </div>
        </br>
        <!-- peliculas -->
        <div id="addpelicula" class="ocultos">

            <div class="formulario">
                <h3>Añadir Pelicula</h3>
                <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="cod_pelicula">codigo_pelicula : </label><input type="text" name="cod_pelicula" >
                    </br>
                    <label for="titulo">titulo : </label><input type="text" name="titulo" required="yes" >
                    </br>
                    <!--<input type="text" name="genero" required="yes" >-->
                    <label for="genero">genero :</label>
                    <select name="genero">
                        <option value="comedia">Comedia</option>
                        <option value="accion">Accion</option>
                        <option value="drama">Drama</option>
                        <option value="romance">Romance</option>
                        <option value="fantasia">Fantasia</option>
                        <option value="thriller">Thriller</option>
                    </select>
                    </br>
                    <label for="pais">pais : </label><input type="text" name="pais" required="yes" >
                    </br>
                    <label for="year">year : </label><input type="text" name="year" required="yes" >
                    </br>                    
                    <input type="button" name="addpelicula" onclick="ocultar(this.name);" value="ocultar">
                    <input type="submit" name="addpeliculaformenvio">
                </form>
            </div>
        </div>   
        <div id="eliminarpelicula" class="ocultos">

            <div class="formulario">
                <h3>Eliminar Pelicula</h3>
                <form  method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="cod_pelicula">codigo_pelicula : </label><input type="text" name="cod_pelicula" required="yes" >
                    </br>             
                    <input type="button" name="eliminarpelicula" onclick="ocultar(this.name);" value="ocultar">
                    <input type="submit" name="eliminarpeliculaformenvio">
                </form>
            </div>
        </div>
        <div id="modpelicula" class="ocultos">

            <div class="formulario">
                <h3>Modificar Pelicula</h3>
                <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="cod_pelicula">codigo_pelicula : </label><input type="text" name="cod_pelicula"  >
                    </br>
                    <label for="titulo">titulo : </label><input type="text" name="titulo" >
                    </br>      
                    <input type="button" name="modpelicula" onclick="ocultar(this.name);" value="ocultar">
                    <input type="submit" name="modpeliculaformenvio" value="Modificar Peliculas">
                </form>
            </div>
        </div>        
        <!-- personas -->
        <div id="addpersona" class="ocultos">

            <div class="formulario">
                <h3>Añadir Persona</h3>
                <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="cod_persona">codigo_persona : </label><input type="text" name="cod_persona" >
                    </br>
                    <label for="nombre">nombre : </label><input type="text" name="nombre" required="yes" >
                    </br>
                    <label for="apellidos">apellidos : </label><input type="text" name="apellidos" required="yes" >
                    </br>
                    <label for="pais">pais : </label><input type="text" name="pais" required="yes" >
                    </br>
                    <input type="button" name="addpersona" onclick="ocultar(this.name);" value="ocultar">
                    <input type="submit" name="addpersonaformenvio">

                </form>
            </div>
        </div>
        <div id="eliminarpersona" class="ocultos">
            <h3>Eliminar Persona</h3>
            <div class="formulario">
                <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="cod_persona">codigo_persona : </label><input type="text" name="cod_persona" required="yes" >
                    </br>
                    <input type="button" name="eliminarpersona" onclick="ocultar(this.name);" value="ocultar">
                    <input type="submit" name="eliminarpersonaformenvio">

                </form>
            </div>
        </div>
        <div id="modpersona" class="ocultos">
            <h3>Modificar Persona</h3>
            <div class="formulario">
                <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="cod_persona">codigo_persona : </label><input type="text" name="cod_persona" required="yes" >
                    </br>
                    <input type="button" name="modpersona" onclick="ocultar(this.name);" value="ocultar">
                    <input type="submit" name="modpersonaformenvio">
                </form>
            </div>
        </div>        
    </body>
</html>
