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
include_once  'respuestas.php';
class Usuario {

    public $cod_Usuario;
    public $user = 'admin';
    public $password = 'pass';
    public $permisover = false;
    public $permisomodificar = false;
    public $permisodelete = false;
    public $permisoinsertar = false;

    public function __construct() {
        
    }

    public function addUsuario() {
        
    }
    public function asignarPermisos($permisos){
        //1 es ver
        //3 es ver y editar
        //6 es ver editar y borrar
        //10 es todo
        //5 es permisos de insertor
        $this->permisover = true;
        if($permisos >= 3){
            $this->permisomodificar = true;
        }
        if($permisos >= 6){
            $this->permisodelete = true;
        }
        if($permisos >=10){
            $this->permisoinsertar = true;
        }
        if($permisos == 5){
            $this->permisoinsertar = true;
            $this->permisomodificar = false;
        }
    }

    public function login($usuario, $password) {
        $r2d2 = new Respuestas();
        $login = false;
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r2d2->respuestaBuena();
        }
        $result = $con->query("SELECT * FROM usuarios WHERE user='$usuario'"); //guardamos la consulta en resultado
        $registro = $result->fetch_assoc();  // recuperamos un array asociativo y lo guardamos en registro
        if(password_verify($password, $registro['pass'])){
            $login = true;
        }
        return $login;
    }
    public function dimeId($nombreusuario){
        $r = new Respuestas();
        $login = false;
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        }
        $result = $con->query("SELECT * FROM usuarios WHERE user='$nombreusuario'"); //guardamos la consulta en resultado
        $registro = $result->fetch_assoc();  // recuperamos un array asociativo y lo guardamos en registro
        return $registro['id'];
        
    }
    public function dimeRol($idusuario){
        $r = new Respuestas();
        $login = false;
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        }
        $result = $con->query("SELECT * FROM usuarios_roles WHERE idusuario='$idusuario'"); //guardamos la consulta en resultado
        $registro = $result->fetch_assoc();  // recuperamos un array asociativo y lo guardamos en registro
        return $registro['rolusuario'];
    }
    public function dimePermisos($rol){
        $r = new Respuestas();
        $login = false;
        $valor = 0;
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        }
        $result = $con->query("SELECT * FROM permisosroles WHERE nombrerol='$rol'"); //guardamos la consulta en resultado
        $registro = $result->fetch_assoc();  // recuperamos un array asociativo y lo guardamos en registro
        while ($registro != false) { 
            $valor = $valor + $registro['idpermiso'];
            $registro = $result->fetch_array(); 
        }
        return $valor;
    }
    public function register($usuario, $password, $iduser = "") {
        $r = new Respuestas();
        $con = new mysqli("localhost", "root", "", "videoclub"); //conectamos con la base de datos
        if ($con->connect_error) { //si la conexion da error :
            die("error en la conexion" . $con->connect_error);
        } else {
            $r->respuestaBuena();
        }
        $passcifrada = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios values('$iduser','$usuario','$passcifrada')"; //guardamos la consulta en resultado
        if ($con->query($sql) === TRUE) {
            $r->exitoInsert();
        } else {
            $cadena = "Error: " . $sql . "<br>" . $con->error;
            $r->respuestaMala($cadena);
        }
    }

}
