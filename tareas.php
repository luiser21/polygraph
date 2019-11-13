<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/tareas.class.php');
 
$ob = new tareas;
$ob->Iniciar();
?>