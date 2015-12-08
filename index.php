<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
    </head>
    <body>
        <?php
        include_once  'Persona.php';
        include_once  'Pelicula.php';
        include_once  'Usuario.php';
        $p = new Usuario()
        ?>
        <div id="login" class="formulario">
            <form action="procesar.php" method="post">
                <label for="nombre">Nombre : </label><input type="text" name="nombre" required="yes"><br/>
                <label for="password">Password : </label><input type="password" name="password" required="yes"></br>
                <input type="submit" name="envio" value="Login">
                <input type="submit" name="registrar" value="registrar">
            </form>
        </div>

    </body>
</html>
