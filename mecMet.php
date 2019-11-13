<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/mecMet.class.php');
 
$ob = new mecMet;
$ob->Iniciar();
?>