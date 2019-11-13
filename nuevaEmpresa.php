<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/nuevaEmpresa.class.php');
 
$ob = new nuevaEmpresa;
$ob->Iniciar();
?>