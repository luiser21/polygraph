<?php
session_start();
include './clases/packege.php';
include('./clases/misCursos.class.php');
 
$ob = new Index;
$ob->Iniciar();
?>