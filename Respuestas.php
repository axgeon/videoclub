<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Respuestas
 *
 * @author Usuario
 */
class Respuestas {
    public function __construct() {
        
    }
    public function respuestaBuena(){
            echo "<div class='respuestaphpbuena'>";
            echo("Conexion realizada con exito");
            echo "</div>";
            echo "</br>";
        
    }
    public function respuestaMala($cadena){
            echo "<div class='respuestaphpmala'>";
            echo $cadena;
            echo "</div>";
    }
    public function exitoInsert(){
           echo "<div class='respuestaphpbuena'>";
            echo "Insert realizado con exito";
            echo "</div>";
    }
    public function exitoDelete(){
            echo "<div class='respuestaphpbuena'>";
            echo "DELETE realizado con exito";
            echo "</div>";
    }
    public function exitoUpdate(){
            echo "<div class='respuestaphpbuena'>";
            echo "UPDATE realizado con exito";
            echo "</div>";
    }
    public function exitoRegistro(){
            echo "<div class='respuestaphpbuena'>Se ha registrado el usuario.";
            echo'<form action="adminpanel.php" method="post">';
            echo'<input type="submit" name="envio" value="Proseguir">';
            echo'</form>';
            echo '</div>';
    }
    public function loginCorrecto(){
            echo "<div class='respuestaphpbuena'>login correcto";
            echo'<form action="adminpanel.php" method="post">';
            echo'<input type="submit" name="envio" value="Proseguir">';
            echo('<input type="hidden" name="login" value="si" />');
            echo('<input type="hidden" name="usernamedesdeprocesar" value="'.$_REQUEST['nombre'].'" />');
            echo'</form>';
            echo '</div>';
    }
    public function loginIncorrecto(){
            echo "<div class='respuestaphpmala'>login incorrecto";
            echo'<form action="index.php" method="post">';
            echo'<input type="submit" name="envio" value="volver">';
            echo'</form>';
            echo '</div>';
    }
}
