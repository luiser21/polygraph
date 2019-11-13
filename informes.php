<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/generarOt.class.php');
 
$ob = new generarOt;
$ob->Iniciar();
?>