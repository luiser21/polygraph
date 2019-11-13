<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/verOt.class.php');
 
$ob = new verOt;
$ob->Iniciar();
?>