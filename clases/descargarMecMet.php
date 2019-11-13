<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/descargarMecMet.class.php');
 
$ob = new descarcarMecMet;

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=programacionMecanismos".date('Y-m-d').".csv");
header("Pragma: no-cache");
header("Expires: 0");

$arr = $ob->traerMecMet();
$arrCsv = $ob->generateHead($arr);
echo $ob->print_table_plain($arrCsv);
?>