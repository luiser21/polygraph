<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/secciones.class.php');
 
$ob = new secciones;
$ob->Iniciar();
?>