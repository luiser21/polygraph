<?php
include('footer.php');
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

switch($class){
    case 'Auten':{
        //  Imprimir ($_POST)	;exit;
        $ob->login($_REQUEST['email'],$_REQUEST['password'],(isset($_REQUEST['id_empresa'])?$_REQUEST['id_empresa']:''));
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

include('header.php');

?>