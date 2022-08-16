<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/rotuloplanta.class.php');
 
$ob = new rotuloplanta;
$ob->Iniciar();
?>