<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/lubricanteplanta.class.php');
 
$ob = new lubricanteplanta;
$ob->Iniciar();
?>