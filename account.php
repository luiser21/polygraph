<?php
session_start();
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
    
include './clases/packege.php';
include('./clases/account.class.php');

$ob 	= 	new Index;
$class	= ( isset($_REQUEST['uu']) ) ? $_REQUEST['uu'] : ''; 
$me = array();
switch($class){	
	case 'archivo':{							
		$ob->subirFoto();
	}break;
	default:{	
		$ob->Iniciar();
	}break;
}

?>