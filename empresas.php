<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/empresas.class.php');
 
$ob = new empresas;
$ob->Iniciar();
?>