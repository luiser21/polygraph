<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/exportarotscerradas.class.php');
 
$ob = new exportarotscerradas;
$ob->Iniciar();
?>