<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/procedimientosTareas.class.php');
 
$ob = new procedimientosTareas;
$ob->Iniciar();
?>