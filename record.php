<?php
session_start();
include './clases/packege.php';
include('./clases/record.class.php');
 
$ob 	= 	new Index;
$class	=	isset( $_REQUEST['uu'] ) ? $_REQUEST['uu'] : '';

$me 			= array();
switch($class){	
	case 'loginFB':{			
		$dia	 	=  	date("d");
		$dia		=	(string)(int)$dia;
		$mes 		=  	date("m");
		$mes		=	(string)(int)$mes;
		$a 			=	date("Y");
		$fecha 		=   $dia.$dia.$mes.$mes.$a.$a;						   		
		$explode_id =   explode($fecha,$_REQUEST['d']);		
		$me['id'] 			= $explode_id[1];
		$me['email'] 		= $_REQUEST['t'];
		$me['first_name'] 	= $_REQUEST['cu'];
		$me['last_name'] 	= $_REQUEST['ci'];
		
		$ob->ValidarUsuario($me);
	}break;
	default:{					
		$ob->Iniciar();
	}break;
}

?>