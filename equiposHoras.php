<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/equiposHoras.class.php');
 
$ob = new equiposHoras;
$ob->Iniciar();
?>