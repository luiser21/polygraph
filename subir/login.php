<?php
include './clases/packege.php';
include('./clases/login.class.php');
$ob 	= 	new Index;
$class = '';
$me = '';
if(isset($_REQUEST['class']))
    $class	=	$_REQUEST['class'];
if( isset( $_REQUEST['me'] ) ) 
    $me		=	$_REQUEST['me'];

switch($class){
	case 'Auten':{						
		$ob->login($_REQUEST['email'],$_REQUEST['password']);
	}break;
	default:{
	   $ob->me = $me;
		$ob->Iniciar();
	}break;
}



?>