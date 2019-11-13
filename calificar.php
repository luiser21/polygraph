<?php
session_start();
if( isset($_SESSION['tipo_usuario']) && ($_SESSION['tipo_usuario'] == '2' || $_SESSION['tipo_usuario'] == '3') ){    
    include './clases/packege.php';
    include('./clases/calificar.class.php');
    $ob = new Index;
    $ob->Iniciar();
}
else{
    header('Location: ./login.php');
}
?>