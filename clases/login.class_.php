<?php


class Index extends crearHtml{
    
    public $_titulo = 'Registro';
    public $_subTitulo = 'Deseas registrar una nueva cuenta?';
    public $_datos = '';
    public $Table = 'usuarios';
    public $PrimaryKey = 'id_usuario';
    
    
    
    /**
     * Index::Iniciar()
     * 
     * @return
     */
    function Iniciar($me){
         $this->_file  = $_SERVER['PHP_SELF'];
         $this->idUsuario = '1';
         if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || isset($_REQUEST['uploadFileIframe'])){
            $this->_datos =  ( is_array($_REQUEST['d']) || is_object($_REQUEST['d']) )? $this->serializeArray($_REQUEST['d']) : $_REQUEST['d'];
             if( method_exists($this,$_REQUEST['process']) ){
                
                 call_user_func(array($this,$_REQUEST['process'])); 
                 }
            exit;
        }
        else{
            $this->_mostrar($me);
        }
    } 
    /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido($me){
        
        return '
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="assets/js/src/main.js"></script>
		<script src="assets/js/src/aplicativo.js"></script>
 <section class="container animated fadeInUp">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div id="login-wrapper">
                    <header>
                        <div class="brand">
                            <a href="index.html" class="logo">
                                <i class="icon-layers"></i>
                                <span>DNA</span>MUSIC</a>								
                        </div>
                        <div class="brand">                         
								<span style="color:#F63"><strong>'.$me.'</strong></span>
                        </div>
                    </header>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">     
                           REGISTRARSE
                        </h3>
                        </div>
                        <div class="panel-body">
                            <p> Entre para acceder a su cuenta.</p>
                            <form class="form-horizontal" role="form" action="" method="get">
							<input name="uu" type="hidden" value="Auten" />
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        <i class="fa fa-lock"></i>
                                        <a href="javascript:void(0)" class="help-block">Olvidaste Tu Contrase&ntilde;a?</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12" align="center">
                                        <input name=""  type="submit"  class="btn btn-primary" value="INGRESAR" class="Boton"  style="width:500"/>	
										<hr />
										<a href="#" id="login" class="btn btn-primary"  style="width:500"> Iniciar Sesion Facebook</a>
                                        <hr />
										<button type="button" id="registroUsuario" class="btn btn-primary"  style="width:500">REGISTRAR</button>
										                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script>
 // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, "script", "facebook-jssdk"));
</script>
    ';    
    }
    
   public function login($email,$password){ 
		
		$sql = 'SELECT '.$this->PrimaryKey.', activo, nombres, apellidos, ciudad FROM '.$this->Table.' 
		WHERE email="'.$email.'" AND pass="'.$password.'" ';
		#Imprimir($sql);die();
        $datos = $this->Consulta($sql);				
		
		if(count($datos)>0){  
		
			//->MIRAMOS SI ESTA CANCELADO
		  	if($datos[0]['activo']==0){
				$this->Error($mensaje='Este Usuario Esta Cancelado');
				exit;
			}
			
			session_start();
			$_SESSION["id_tipo"]	= 'local';
			$_SESSION["id_usuario"]	=$datos[0]['id_usuario'];
			$_SESSION["nombre"]		=$datos[0]['nombres'];
			$_SESSION["apellido"]	=$datos[0]['apellidos'];
			$_SESSION["ciudad"]		=$datos[0]['ciudad'];
            $_SESSION["tipo_usuario"]	= '1';
		
			
			#header('Location: ../misCursos.php'); 
			echo'
			<script>
			   location.href="listados.php";
			</script>
			';
		}else{			
			$this->Error($mensaje='Este Usuario No Existe');
		}			      
    } 
	
	function loginFB($id_FB,$email_FB){
		
		$sql = 'SELECT id_usuario,id_facebook FROM usuarios WHERE id_facebook = "'.$id_FB.'" ';		
		#echo $sql;
        $datos = $this->Consulta($sql);				
		
		if(count($datos)>0){
			echo json_encode((object)array("res"=>true));
		} else {
			$sql = "INSERT INTO usuarios (id_facebook, email, foto) VALUES ('".$id_FB."', '".$email_FB."',2)";
			$this->QuerySql($sql);
			$this->enviarMail($email_FB);
			echo json_encode((object)array("res"=>false));			
		}		
	}

	function Error($mensaje){	
	#echo $mensaje;
		echo'
			<script>
			   location.href="login.php?me='.$mensaje.'";
			</script>
			';
	}	

    /**
     * Index::fn_guardar()
     * 
     * @return
     */
    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * Index::runEliminar()
     * 
     * @return
     */
    function runEliminar(){
        $sql = 'UPDATE '.$this->Table .' SET activo = 0 WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $this->QuerySql($sql);
        //$_respuesta = array('Codigo' => 1, "Mensaje" => 'Se ha eliminado el item con &eacute;xito');
        echo 'Se ha eliminado el item con &eacute;xito';
    }
    
    /**
     * Index::fn_editar()
     * 
     * @return
     */
    function fn_editar(){
        
    }
    
    /**
     * Index::getDatos()
     * 
     * @return
     */
    function getDatos(){}
    
    /**
     * Index::_mostrar()
     * 
     * @return
     */
    function _mostrar($me){
        /**  $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');*/
        $html = '';
       $html .= $this->_head();
       '<section id="main-wrapper" class="theme-default">';
        //$html = $this->Cabecera();
        $html .= $this->contenido($me);
        $html .= '</section>';
      //  $html .= $this->tablaDatos();
        //$html .= $this->Pata();
        echo $html;
    }
    
    /**
     * Index::tablaDatos()
     * 
     * @return
     */
    function tablaDatos(){}   
	
function enviarMail($email){
	$to = $email;
	$subject = "Correo de prueba";
		$message = '
<table width="100%" border="0" align="center" style=" font-family:Arial, Helvetica, sans-serif; color:#333; font-size:12px;">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="542" align="center"><a href="http://dnamusiconline.com/sitio"><img name="" src="http://dnamusiconline.com/mail/logo-dna.png" width="290" height="57" alt="" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-size:14px;"><strong>Gracias por registrarse en DNA MUSIC ONLINE</strong><br /> <br /> 
      La siguiente es la informaci&oacute;n para iniciar sesi&oacute;n</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="background-color: #671675; font-size:14px; padding:20px; border-radius:6px; color:#FFF;"><strong>Usuario:</strong> [correo] <br /> 
    <strong>Contraseña:</strong> [clave]</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="background-color:#4E4E4E; font-size:14px; padding:5px; border-radius:6px; color:#FFF;"><a href="http://www.dnamusiconline.com/cursos_online/login.php"><img src="http://dnamusiconline.com/mail/inicias-sesion.jpg" width="250" height="70" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">ir a <a href="http://dnamusiconline.com/sitio">DNAMUSICONLINE.COM</a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><img name="" src="http://icons.iconarchive.com/icons/danleech/simple/32/facebook-icon.png" width="32" height="32" alt="" />   &nbsp; <img name="" src="http://icons.iconarchive.com/icons/danleech/simple/32/twitter-icon.png" width="32" height="32" alt="" /></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">Todos los Derechos Reservados © 2015 dnamusic.edu.co</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>';
    
    $headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$from = "tudnamusic@gmail.com";
	$headers = "From:" . $from;
	mail($to,'DNA MUSIC',$message,$headers);
		
	}
}
?>