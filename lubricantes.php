<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/lubricantes.class.php');
 
$ob = new lubricantes;
$ob->Iniciar();
?>