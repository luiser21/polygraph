<?php
session_start();
include './clases/packege.php';
include './clases/carro.class.php';
 
$ob = new carroCompras;
$ob->Iniciar();
if( isset($_GET['l']) ) unset($_SESSION['item']);
?>