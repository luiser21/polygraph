<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/metodos.class.php');
 
$ob = new metodos;
$ob->Iniciar();
?>