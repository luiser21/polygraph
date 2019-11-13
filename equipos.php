<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/equipos.class.php');
 
$ob = new equipos;
$ob->Iniciar();
?>