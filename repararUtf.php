<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/repararUtf.class.php');
 
$ob = new RepararUtf();
$ob->actualizarTablas();
?>
