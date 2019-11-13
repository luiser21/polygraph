<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/unidades.class.php');
 
$ob = new unidades;
$ob->Iniciar();
?>