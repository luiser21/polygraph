<?php

session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/solicitudes.class.php');
 
$ob = new Plantas;
$ob->Iniciar();
?>