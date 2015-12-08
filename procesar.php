<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
    </head>
    <body>
        <?php
        include_once 'Usuario.php';
        $u = new Usuario();
        $r = new Respuestas();
        if (isset($_POST['registrar'])){
            $u->register($_POST['nombre'],$_POST['password']);
            $r->exitoRegistro();

        }
        if ($u->login($_POST['nombre'],$_POST['password'])) {
            $r->loginCorrecto();
        } else {
            $r->loginIncorrecto();
        }
        ?>
    </body>
</html>
