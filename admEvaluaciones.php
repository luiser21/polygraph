<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/admEvaluaciones.class.php');
 
$ob = new Index;
$ob->Iniciar();
?>