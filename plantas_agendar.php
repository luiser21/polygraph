<meta charset="ISO-8859-1">
<?php

session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/plantas_agendar.class.php');
 
$ob = new Plantas;
$ob->Iniciar();
?>