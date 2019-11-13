<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/aplicaciones.class.php');
 
$ob = new aplicaciones;
$ob->Iniciar();
?>