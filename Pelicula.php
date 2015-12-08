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
class Pelicula {

    public $cod_Pelicula;
    public $titulo;
    public $genero;
    public $pais;
    public $year;

    public function __construct() {
        
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

    public function dibujaTabla($usuario) { //dibuja tabla con caracteristicas dadas
        $r = new Respuestas();
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r->respuestaBuena();
        }
        $sql = "SELECT * FROM peliculas";
        $resultado = $con->query($sql); 
        $fila = $resultado->fetch_array(); 
        echo('<div id="mostrarpelicula">');
        echo('<table id="1">');
        echo('<form class="tablalistado" method="post" action="adminpanel.php">');
        $numerofila = 0;
        while ($fila != false) { 
            echo('<tr>');
            for ($j = 0; $j <= 4; $j++) {
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
            echo("<input name='borrarseleccionpelicula' value='borrarseleccion' type='submit'></input>");
        }
        if($usuario->permisomodificar){
            echo("<input name='modificarseleccionpelicula' value='modificarseleccion' type='submit'></input>");
        }
        echo("<input type='button' name='mostrarpelicula' onclick='ocultar(this.name);' value='ocultar'>");
        echo('</form>');
        echo('</div>');
        mysqli_close($con);
    }
    public function buscarPelicula($cod_pelicula) {
        $r = new Respuestas();
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r->respuestaBuena();
        }
        $sql = "SELECT * FROM peliculas WHERE cod_pelicula=".$cod_pelicula; //guardamos la consulta en resultado
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


public function addPelicula($cod_pelicula, $titulo, $genero, $pais, $year) {
        $r = new Respuestas();
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r->respuestaBuena();
        }
        $sql = "INSERT INTO peliculas values('$cod_pelicula','$titulo','$genero','$pais','$year')"; //guardamos la consulta en resultado
        if ($con->query($sql) === TRUE) {
            $r->exitoInsert();
        } else {
            $cadena = "Error: " . $sql . "<br>" . $con->error;
            $r->respuestaMala($cadena);
        }
        mysqli_close($con);
    }
    public function borrarPelicula($cod_pelicula){
        $r = new Respuestas();
        $con = new mysqli ("localhost", "root", "", "videoclub");
                if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r->respuestaBuena();
        }
        $sql = "DELETE FROM peliculas WHERE cod_pelicula = ".$cod_pelicula; //guardamos la consulta en resultado
        if ($con->query($sql) === TRUE) {
            $r->exitoDelete();
        } else {
            $cadena = "Error: " . $sql . "<br>" . $con->error;
            $r->respuestaMala($cadena);
        }
        mysqli_close($con);
    }

}
