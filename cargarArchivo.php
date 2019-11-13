<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/cargarArchivo.class.php');
 
$ob = new cargarArchivo;
$ob->Iniciar();
?>