<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/imagenesEquipos.class.php');
 
$ob = new imagenesEquipo;
$ob->Iniciar();
?>