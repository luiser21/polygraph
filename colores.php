<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/colores.class.php');
 
$ob = new colores;
$ob->Iniciar();
?>