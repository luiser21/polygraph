<?php
session_start();
include './clases/packege.php';
include('./clases/forum.class.php');
 
$ob = new Index;
$ob->Iniciar();
?>