<?php
session_start();
if( !isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != '3' )
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/admCapitulos.class.php');
 
$ob = new Index;
$ob->Iniciar();
?>