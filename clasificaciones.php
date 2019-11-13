<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/clasificaciones.class.php');
 
$ob = new clasificaciones;
$ob->Iniciar();
?>