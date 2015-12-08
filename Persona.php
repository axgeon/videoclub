<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of persona
 *
 * @author Usuario
 */
include_once 'Respuestas.php';
class Persona {
    public $cod_Persona;
    public $nombre;
    public $apellidos;
    public $pais;
    
    
    public function __construct() {
    }
    public function borrarPersona($cod_persona){
        $r = new Respuestas();
        $con = new mysqli ("localhost", "root", "", "videoclub");
                if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r->respuestaBuena();
        }
        $sql = "DELETE FROM personas WHERE cod_persona = ".$cod_persona; //guardamos la consulta en resultado
        if ($con->query($sql) === TRUE) {
            $r->exitoDelete();
        } else {
            $cadena = "Error: " . $sql . "<br>" . $con->error;
            $r->respuestaMala($cadena);
        }
        mysqli_close($con);
    }
    public function addPersona($codPersona,$nombre,$apellidos,$pais){
        $r = new Respuestas();
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r->respuestaBuena();
        }
        $sql = "INSERT INTO personas values('$codPersona','$nombre','$apellidos','$pais')"; //guardamos la consulta en resultado
        if ($con->query($sql) === TRUE) {
            $r->exitoInsert();
        } else {
            $cadena = "Error: " . $sql . "<br>" . $con->error;
            $r->respuestaMala($cadena);
        }
        mysqli_close($con);
    }
    public function dibujaTabla($usuario) { //dibuja tabla con caracteristicas dadas
        $r = new Respuestas();
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r->respuestaBuena();
        }
        $sql = "SELECT * FROM personas";
        $resultado = $con->query($sql); 
        $fila = $resultado->fetch_array(); 
        echo('<div id="mostrarpersona">');
        echo('<table id="2">');
        echo('<form class="tablalistado" method="post" action="adminpanel.php">');
        $numerofila = 0;
        while ($fila != false) { 
            echo('<tr>');
            
            for ($j = 0; $j <= 3; $j++) {
                echo('<td class="campo"'.$numerofila.$j.'>');
                echo($fila[$j]); 
                echo('</td>');
            }
            
            echo('<td class="checkboxes">');
                echo("<input type='checkbox' value=$fila[0] class='seleccionTabla' id=$numerofila.$j name='checkboxseleccionada' ></input>");
            echo('</td>');
            $numerofila++;
            echo('</tr>');
            $fila = $resultado->fetch_array(); 
        }
        
        echo('</table>');
        if($usuario->permisodelete){
            echo("<input name='borrarseleccionpersona' value='borrarseleccion' type='submit'></input>");
        }
        if($usuario->permisomodificar){
            echo("<input name='modificarseleccion' value='modificarseleccion' type='submit'></input>");
        }
        echo("<input type='button' name='mostrarpersona' onclick='ocultar(this.name);' value='ocultar'>");
        echo('</form>');
        echo('</div>');
        mysqli_close($con);
    }
        public function buscarPersona($cod_persona) {
        $r = new Respuestas();
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r->respuestaBuena();
        }
        $sql = "SELECT * FROM peliculas WHERE cod_pelicula=".$cod_persona; //guardamos la consulta en resultado
        echo($sql);
        $resultado = $con->query($sql);
        $fila = $resultado->fetch_array();
        $campo = $resultado->fetch_fields();
            while ($fila != false) {
                echo('<div id="modificarpeliculaseleccionada">');
                echo('<form class="formulario">');
                for ($j = 0; $j <= 4; $j++) {
                    //var_dump($campo[$j]);
                    //echo($campo[$j]->name);
                    echo '<label for="campo'.$j.'">'.$campo[$j]->name.'</label>';
                    if($j == 0){
                       echo('<input type="text" class="campomodificar" readonly value="'.$fila[$j].'" name="'.$campo[$j]->name.'" />'); 
                    }else{
                        echo('<input type="text" class="campomodificar" value="'.$fila[$j].'" name="'.$campo[$j]->name.'" />');
                    }
                    echo('</br>');
                    $campo = $resultado->fetch_fields();
                }
                $fila = $resultado->fetch_array(); 
                echo('<input type="submit" name="guardarcambiosmodificacion" value="Guardar">');
                echo("<input type='button' name='modificarpeliculaseleccionada' onclick='ocultar(this.name);' value='ocultar'>");
                echo('</form>');
                echo('</div>');
            }
        mysqli_close($con);
    }
    public function modifica($cod_pelicula, $titulo, $genero, $pais, $year){
        $r = new Respuestas();
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r->respuestaBuena();
        }
        $sql = "UPDATE peliculas SET titulo='$titulo',genero ='$genero',pais = '$pais',year = '$year'  WHERE cod_pelicula = '$cod_pelicula'";
        if ($con->query($sql) === TRUE) {
            $r->exitoUpdate();
        } else {
            $cadena = "Error: " . $sql . "<br>" . $con->error;
            $r->respuestaMala($cadena);
        }
        mysqli_close($con);
    }
}
