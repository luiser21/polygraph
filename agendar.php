<meta charset="ISO-8859-1">
<meta http-equiv=refresh content=60;URL=agendar.php>
<?php
include('footer.php');
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/agendar.class.php');
 
$ob = new Plantas;
$ob->Iniciar();
include('header.php');
?>