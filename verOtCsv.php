<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/editarOt.class.php');
 
$ob = new editarOt;

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");

$arr = $ob->traerDetalleOt(1);
$arrCsv = $ob->generateHead($arr);
echo $ob->print_table_plain($arrCsv);



?>