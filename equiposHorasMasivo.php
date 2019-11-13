<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/equiposHorasMasivo.class.php');
 
$ob = new equiposHorasMasivo;
if(  isset($_GET['plantilla']) ){
    $ob->generarPlantilla();    
}else{
$ob->Iniciar();
}
?>