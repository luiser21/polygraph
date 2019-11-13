<?php
session_start();
include './clases/packege.php';
//include './payu-php/lib/PayU.php';
include('./clases/compra.class.php');
 
$ob = new Index;
$ob->Iniciar();
?>