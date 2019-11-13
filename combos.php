<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/combos.class.php');
 
$ob = new combos;
echo $ob->Contenido();
?>