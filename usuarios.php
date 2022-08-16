<?php
include('footer.php');
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/usuarios.class.php');
 
$ob = new Usuarios;
$ob->Iniciar();
include('header.php');
?>