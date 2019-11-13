<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/simbologia.class.php');
 
$ob = new simbologia;
$ob->Iniciar();
?>