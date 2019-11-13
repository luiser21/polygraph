<?php
session_start();
if( isset($_SESSION['tipo_usuario']) && ($_SESSION['tipo_usuario'] == '2' || $_SESSION['tipo_usuario'] == '3') ){    
    include './clases/packege.php';
    include('./clases/responder.class.php');
    $ob = new Responder;
    $ob->Iniciar();
}
else{
    header('Location: ./login.php');
}
?>