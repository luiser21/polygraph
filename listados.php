<?php
session_start();
include './clases/packege.php';
include('./clases/listados.class.php');
 
$ob = new Index;
if( isset( $_GET['t'] ) ){
    switch( $_GET['t'] ){
        case '1':
            $ob->listar = 1;
        break;
        case '2':
            $ob->listar = 2;
        break;
        case '3':
            $ob->gratis = 1;
        break; 
    }
}
$ob->Iniciar();
?>