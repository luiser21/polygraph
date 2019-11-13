<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/mecanismos.class.php');
 
$ob = new mecanismos;
$ob->Iniciar();
?>