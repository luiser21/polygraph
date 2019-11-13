<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/descargarMecMet.class.php');
 
$ob = new descarcarMecMet;

$arr = $ob->traerMecMet();
$_array_formu = array();
$_array_formu = generateHead2($arr);
$ob->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();
$file = "Configuracion de Cartas.csv";

header('Expires: 0');
header('Cache-control: private');
header('Content-Type: application/x-octet-stream'); // Archivo de Excel
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Last-Modified: '.date('D, d M Y H:i:s'));
header('Content-Disposition: attachment; filename="'.$file.'"');
header("Content-Transfer-Encoding: binary");

echo print_table_plain2($_array_formu,4);



function print_table_plain2($array){
    $_return = '';
    if( is_array($array) ){
        $_fila = 0;
        foreach($array as $c => $k){
            if( is_array($k) ){
                foreach($k as $c1 => $k1){
                    $_return.=$k1.";";
                }
            }
            $_return.="\n";
            $_fila++;
        }
    }
    return $_return;
}
function generateHead2($_array){
    $_array_formu = array();
    if( isset($_array[0]) && is_array($_array[0]) ){
        foreach($_array[0] as $c => $k){
            $_array_formu[0][] = STRTOUPPER($c) ;
        }
    }
    return $_array_formu = array_merge($_array_formu, $_array);
}
?>