<?php
include './clases/packege.php';
include('./clases/login.class.php');
$ob 	= 	new Index;
if(isset($_GET['p'])){
    echo date('Y-m-d H:i:s');
    $ob->reseteaContrasena('ABC');
    die('<hr> FIN');
}
$class	=	( isset( $_REQUEST['uu'] ) ) ?  $_REQUEST['uu'] : '';
$ob->me	= ( isset( $_REQUEST['me'] ) ) ? $_REQUEST['me'] : '';
#Imprimir ($_REQUEST)	;
switch($class){
	case 'Auten':{						
		$ob->login($_REQUEST['email'],$_REQUEST['password']);
	}break;
	case 'loginFB':{						
		$ob->loginFB($_REQUEST['id'],$_REQUEST['email']);
	}break;
	case 'fr':{	#Formulario Recordar				
		$ob->FormRecordarPass();
	}break;	
	case 're':{	#Recordar
        $ob->correo = $_REQUEST['email'];
        $ob->solicitaReseteo();
	}break;	
	
	default:{
		$ob->Iniciar();
	}break;
}



?>