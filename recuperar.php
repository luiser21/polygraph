<?php
include './clases/packege.php';
include('./clases/login.class.php');
// $cu = correo del usuario
// $cr = codigo del usuario 
$ob 	= 	new Index;
if( isset( $_GET['cr'] ) && isset( $_GET['cu'] ) ){
    $ob->correo = $_GET['cu'];
    $ob->solicitaReseteo();
}elseif( isset( $_GET['cod'] ) ){
    $ob->reseteaContrasena($_GET['cod']);
}