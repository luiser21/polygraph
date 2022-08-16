<?php
include('footer.php');
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/parametros.class.php');
 
$ob = new parametros;
$ob->Iniciar();
include('header.php');
?>