<?php
session_start();
include './clases/packege.php';
//include './payu-php/lib/PayU.php';
include './clases/carro.class.php';
include('./clases/confirma.class.php');
 
$ob = new confirmaCompra;
$ob->Iniciar();
?>