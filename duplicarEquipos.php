<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/duplicarEquipos.class.php');
 
$ob = new duplicarEquipos;
$ob->Iniciar();
?>