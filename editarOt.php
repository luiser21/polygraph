<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/editarOt.class.php');
$ob = new editarOt;
$ob->Iniciar();
?>