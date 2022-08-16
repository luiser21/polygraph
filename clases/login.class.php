<?php
class Index extends crearHtml{
    
    public $_titulo = 'Registro';
    public $_subTitulo = 'Deseas registrar una nueva cuenta?';
    public $_datos = '';
    public $Table = 'usuarios';
    public $PrimaryKey = 'id_usuario';
    public $me = '';
    public $aleatorio = false;
    public $correo = false;
    /**
     * Index::Iniciar()
     * 
     * @return
    */
    /**
     * Index::Iniciar()
     * 
     * @return
     */
    function Iniciar(){
         $this->_file  = $_SERVER['PHP_SELF'];
         $this->idUsuario = ( isset($_SESSION['id_usuario']) ) ? $_SESSION['id_usuario'] : '';
         if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || isset($_REQUEST['uploadFileIframe'])){
            $this->_datos =  ( is_array($_REQUEST['d']) || is_object($_REQUEST['d']) )? $this->serializeArray($_REQUEST['d']) : $_REQUEST['d'];
             if( method_exists($this,$_REQUEST['process']) ){
                 call_user_func(array($this,$_REQUEST['process'])); 
                 }
            exit;
        }
        else{
            $this->_mostrar();
        }
    }  
	
	/**
	 * Index::pass()
	 * 
	 * @param mixed $email
	 * @return
	 */
	function pass($email){		
		if(!empty($email)){
			$sql = 'SELECT id_usuario,pass FROM usuarios WHERE email = "'.$email.'" ';			
			$datos = $this->Consulta($sql);			
			return $datos;
		}else{	
			echo 'Debes ingresar un correo!';
			 die();
		}
	}
	
	/**
	 * Index::pass()
	 *
	 * @param mixed $email
	 * @return
	 */
	function consultarempresa(){
	    if(!empty( $this->_datos)){
	        $sql = 'SELECT distinct p.id_parametro AS codigo, UPPER( p.empresa ) AS descripcion
        FROM usuarios u, usuarios_parametros up, parametros p 
        WHERE ((u.email =  "'. $this->_datos.'")  
        AND (p.id_parametro = up.id_parametro) 
        and (u.id_usuario = up.id_usuario) 
        and (u.duenocliente = 0)) 
        or ((u.email =  "'. $this->_datos.'") and (up.id_usuario > 0) and (u.duenocliente = 1)) ';
	        $datos = $this->Consulta($sql);
	        
	        if(count($datos)>1){
	           $combo= '<select class="form-control" id="id_empresa" name="id_empresa">';
	           $i=0;
	           foreach($datos as $value){
	               if($i==0){
	                   $combo.=' <option value="'.$value['codigo'].'" selected="selected">'.$value['descripcion'].'</option>';
	               }else{
	                   $combo.=' <option value="'.$value['codigo'].'">'.$value['descripcion'].'</option>';
	               }
	               $i++;
	           }
	           $combo.=' </select>';
	           echo $combo;
	        }elseif(count($datos)==1){
	            $combo= '<input type="hidden"  id="id_empresa" name="id_empresa" value="'.$datos[0]['codigo'].'"  >';
	            echo $combo;
	        }
	    }
	}
    
	/**
	 * Index::reseteaContrasena()
	 * Confirma enlace, resetea contraseña y envia correo con la notifiación.
     * @author David Ardila (david.ardila@gmail.com)
	 * @return
	 */
	function reseteaContrasena($codigoReseteo){
	   //session_start();
	   $dominio = $this->getEmpresaUrl();
	   $sql = "SELECT fecha_recordar,`id_usuario`,`email` FROM cartas_".$dominio.".usuarios WHERE codigo_reseteo = '$codigoReseteo'";
       $datos = $this->Consulta( $sql ) ;
       if( count( $datos ) ){
            /*if( $this->validaFecha($datos[0]['fecha_recordar']) == false ){
                echo 'el tiempo para resetear la contraseña se ha sido exedido';
            }else{*/
                $this->creaAleatorio(false ,8);
                $this->actualizaContrasena($datos[0]['id_usuario']);
                $this->notificaNuevaContrasena($datos[0]['email']);
                echo 'Se ha enviado un correo con los datos de ingreso, no olvides revisar el spam';
            //}
       }
       else{
            echo 'No cumple con la validacion de datos, no se a realizado ninguna operación';
       }
	}
    
    /**
     * Index::Aleatorio()
     * Genera una cadea aleatoria bien sea a partir de <b>$Cadena</b> 
     * Si es vacio entonces genera un aleatorio en base a time().
     * @param bool $Cadena con la que se desea realizar el aleatorio
     * @param bool $cantidad de caracteres que se desea genere el aleatorio
     * @return mixed
     * @version 1.0 - Versión inicial
     * @author Javier Ardila david.ardila@gmail.com
     */
    function creaAleatorio($Cadena = false , $cantidad = false){
        $Cadena = (!$Cadena) ? '1234567890abcdefghijklmnopqrstuvwxyz*' : $Cadena;
        $aleatorio = '';
        $arrCadena = array();
        $Cadena = "" . $Cadena;
        $largoCadena = strlen($Cadena);
        for ($i = 0; $i < $largoCadena; $i++) {
            $arrCadena[] = $Cadena[$i];
        }
        shuffle($arrCadena);
        while (list(, $Aliatorio) = each($arrCadena)) {
            $aleatorio  .= $Aliatorio;
        }
        $this->aleatorio = ( $cantidad ) ? substr ( $aleatorio , 0, $cantidad ): $aleatorio;
             
            
    }    

    /**
	 * Index::validaFecha()
	 * Actualiza la contraseña
     * @author David Ardila (david.ardila@gmail.com)
     * @param mixed $email
	 * @return bolean
	 */
    function actualizaContrasena($idUsuario){
        //session_start();
        $dominio = $this->getEmpresaUrl();
        if( $this->aleatorio ){
            $sql = "UPDATE cartas_".$dominio.".usuarios SET codigo_reseteo = '', `pass` = MD5('{$this->aleatorio}') WHERE `id_usuario` = {$idUsuario} ";
            $this->QuerySql($sql);
        }else{
            echo 'No se encontro un codigo Aleatorio';
        }
    }
    
    /**
	 * Index::validaFecha()
	 * compara que la fecha enviada en el parametro no sea mayor a 12 horas.
     * @author David Ardila (david.ardila@gmail.com)
     * @param mixed $email
	 * @return bolean
	 */
    function validaFecha($fecha){
        $datetime1 = new DateTime($fecha);
        $datetime2 = new DateTime('now');
        $interval = $datetime1->diff($datetime2);
        $horasDiferencia = $interval->format( '%h' );
        return ( $horasDiferencia > 12 ) ? false : true;
    }
    
    
	/**
	 * Index::notificaNuevaContrasena()
	 * Agrega bandera en base de datos para reseteo de clave y envia correo indicando dicha solicitud.
     * @author David Ardila (david.ardila@gmail.com)
     * @param mixed $email
	 * @return
	 */
	function  notificaNuevaContrasena($email){
	    $httpHost = explode('.',$_SERVER['HTTP_HOST']);
	    //session_start();
	    $dominio = $this->getEmpresaUrl();
		$to 	= $email;
		//$to='luishernando18@hotmail.com';
		$pass 	= $this->aleatorio;
		$this->message = '
<body>
<table width="100%" border="0" align="center" style=" font-family:Arial, Helvetica, sans-serif; color:#333; font-size:12px;">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="542" align="center"><a href="#"><img name="" src="../'.strtoupper($dominio).'/imagenes/LOGOS_SOFTWARE_02.jpg" alt="" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-size:14px;">
        <p><strong>Hola, a continuación enviamos tus nuevos datos para iniciar sesion en nuestro portal.  </strong></p>
    </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="background-color: #671675; font-size:14px; padding:20px; border-radius:6px; color:#FFF;"><strong>Usuario:</strong>'.$email.' <br /> 
    <strong>Contraseña:</strong>'.$pass.'</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="background-color:#4E4E4E; font-size:14px; padding:5px; border-radius:6px; color:#FFF;"><a href="http://'.$dominio.'.'.$httpHost[1].'.com"><img src="http://'.$dominio.'.'.$httpHost[1].'.com/mail/inicias-sesion.jpg" width="250" height="70" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">ir a <a href="http://'.$dominio.'.'.$httpHost[1].'.com">'.$dominio.'.'.$httpHost[1].'.com</a></td>
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
    <td align="center">Todos los Derechos Reservados © 2018 '.$httpHost[1].'.com</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>		
		';
    $headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    
	//$from = "ilsaslubrimaq@ilsaslubrimaq.com";
	$from = $httpHost[1]."@".$httpHost[1].".com";
	//$headers .= "From: ilsaslubrimaq <ilsaslubrimaq@ilsaslubrimaq.com>\r\n";
	$headers .= "From: ".$httpHost[1]." <".$httpHost[1]."@".$httpHost[1].".com>\r\n"; 
	
    $HTML = false;
    $this->EnviarCorreo($from,array($to),'RECUPERAR CLAVE',$this->message,$HTML); 
	echo 'Te enviamos la informacion a tu correo.'; 
		
	}

	/**
	 * Index::actualizaCodigo()
	 * Consume los metodos que realizan estas acciones (Crea codigo, actualiza codigo en base de datos y envia correo)
     * @author David Ardila (david.ardila@gmail.com)
     * @param mixed $email
	 * @return
	 */    
    function actualizaCodigo(){
        //session_start();
        $dominio = $this->getEmpresaUrl();
        $sql = "UPDATE cartas_".$dominio.".usuarios SET codigo_reseteo = '{$this->aleatorio}', fecha_recordar = NOW() WHERE email = '{$this->correo}' ";
        $this->QuerySql($sql);
    }

	/**
	 * Index::solicitaReseteo()
	 * Consume los metodos que realizan estas acciones (Crea codigo, actualiza codigo en base de datos y envia correo)
     * @author David Ardila (david.ardila@gmail.com)
     * @param mixed $email
	 * @return
	 */
	function  solicitaReseteo(){
	    if( $this->verificaCorreo() ){
	       $this->creaAleatorio(false ,8);
            $this->actualizaCodigo();
            $this->confirmaReseteoContrasena();   
	    }
        
    }
    
    public function verificaCorreo(){
        //session_start();
        $dominio = $this->getEmpresaUrl();
        $sql = 'SELECT id_usuario,pass FROM cartas_'.$dominio.'.usuarios WHERE email = "'.$this->correo.'" ';			
			$datos = $this->Consulta($sql);	
            if( count( $datos ) ){
                return true;
            }else{
                echo 'Usuario no encontrado';
            }	
			
    }
	/**
	 * Index::confirmaReseteoContrasena()
	 * Envia correo pidiendo confirmacion de reseteo de contraseña
     * @author David Ardila (david.ardila@gmail.com)
     * @param mixed $email
	 * @return
	 */
	function  confirmaReseteoContrasena(){
	    $httpHost = explode('.',$_SERVER['HTTP_HOST']);
	    //session_start();
	    $dominio = $this->getEmpresaUrl();
		$to 	= $this->correo;
		//$to='luishernando18@hotmail.com';
		$urlRecuperar = 'http://'.$dominio.'.'.$httpHost[1].'.com/recuperar.php?cod=' . $this->aleatorio;
		$this->message = '
<body>
<table width="100%" border="0" align="center" style=" font-family:Arial, Helvetica, sans-serif; color:#333; font-size:12px;">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="542" align="center"><a href="http://'.$dominio.'.'.$httpHost[1].'.com"><img name="" src="http://'.$dominio.'.'.$httpHost[1].'.com/mail/logo-dna.png" width="290" height="57" alt="" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-size:14px;">
        <p><strong>Hola, has enviado una petición para resetear tú contraseña, ingresa a la siguiente url para confirmarlo  </strong></p>
        <p><strong><a href="'.$urlRecuperar.'">'.$urlRecuperar.'</a>  </strong></p>
        <p><strong>Si no has solicitado resetear tu  contraseña has caso omiso a este correo  </strong></p>
    </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">ir a <a href="http://'.$dominio.'.'.$httpHost[1].'.com">'.$dominio.'.'.$httpHost[1].'.com</a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr><!--
  <tr>
    <td align="center"><img name="" src="http://icons.iconarchive.com/icons/danleech/simple/32/facebook-icon.png" width="32" height="32" alt="" />   &nbsp; <img name="" src="http://icons.iconarchive.com/icons/danleech/simple/32/twitter-icon.png" width="32" height="32" alt="" /></td>
  </tr> 
  -->
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">Todos los Derechos Reservados © 2018 '.$httpHost[1].'.com</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>		
		';
    $headers = "MIME-Version: 1.0\r\n ";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	
	//$from = "ilsaslubrimaq@ilsaslubrimaq.com";
	$from = $httpHost[1]."@".$httpHost[1].".com";
    //$headers .= "From: ilsaslubrimaq <ilsaslubrimaq@ilsaslubrimaq.com>\r\n"; 
	$headers .= "From: ".$httpHost[1]." <".$httpHost[1]."@".$httpHost[1].".com>\r\n"; 
	
    $HTML = false;
    $this->EnviarCorreo($from,array($to),'RECUPERAR CLAVE',$this->message,$HTML); 
    
	echo 'Te enviamos la informacion a tu correo.';
}
	    
    
	/**
	 * Index::FormRecordarPass()
	 * 
	 * @return
	 */
	function FormRecordarPass(){
		echo $this->_head();
		echo '
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="assets/js/src/main.js"></script>
		<script src="assets/js/src/aplicativo.js"></script>
		
				<section class="container animated fadeInUp">
        		<div class="row">
            	<div class="col-md-6 col-md-offset-3">
                <div id="login-wrapper">
                    
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h3 class="panel-title">     
                           OLVIDASTE TU CONTRASE&Ntilde;A?
                        </h3>
                        </div>
                        <div class="panel-body">
                            <p> Ingresa tu correo</p>
                            <form class="form-horizontal" role="form" action="" method="get">
							<input name="uu" type="hidden" value="re" />
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email"  required = "1">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-md-12" align="center">                                        										
										<input name=""  type="submit"  class="btn btn-primary btn-block" value="Recordar" class="Boton"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            	</div>
        		</div>
				</section>
		';	
	}
    /**
     * Index::Contenido()
     * 
     * @return
     */
    /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
        
        return '
       <!-- <script type="text/javascript" src="//connect.facebook.net/en_US/sdk.js"></script>-->
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="assets/js/src/main.js"></script>
		<script src="assets/js/src/aplicativo.js"></script>
 <section class="container animated fadeInUp">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div id="login-wrapper">
                    <header><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
                        <div class="brand">
                            <a href="index.html" class="logo">
                                <img src="./imagenes/polygraph-03.png" width="200"/>    
                            </a>								
                        </div>
                        <div class="brand">                         
								<span style="color:#F63"><strong>'.$this->me.'</strong></span>
                        </div>
                    </header>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">  
                           INICIAR SESI&Oacute;N
                        </h3>
                        </div>
                        <div class="panel-body">
                             Ingresa tus datos de acceso.

                            <form class="form-horizontal" id="formCrear" role="form">
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
                                        
                                        
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <div class="col-md-12" id="combo_empresas">
                                        <i class="fa fa-lock"></i>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12" align="center">
                                        <a href="#"  id="recordar" class="help-block">Olvidaste Tu Contrase&ntilde;a?</a>
                                         <button type="button" id="guardaringreso" class="btn btn-primary">Ingresar</button>
                                    </div>
                                    <div id="resultado" ></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    ';    
    }
        
   /**
    * Index::login()
    * 
    * @param mixed $email
    * @param mixed $password
    * @return
    */
    function login(){ 
        session_start();
        $dominio = $this->getEmpresaUrl();
       
        $_SESSION["bdatos"] = 'polygraph';
        if($dominio == 'admin'){
            if($_POST['email']=='adminLubricador' && $_POST['password'] == '123456'){
                $_SESSION["bdatos"] = 'cartas_inicio';   
                $_SESSION["tipo_usuario"] =1;
                $_SESSION["id_usuario"] =1;
                $_SESSION["nombre"] ='Super Admin';
                $_SESSION["foto"] ='foto';
                $_SESSION["dueno"] ='1';
                echo'
    				<script>
    				   location.href="nuevaEmpresa.php";
    				</script>
    				';
                    exit;
            }else{
				$this->Error($this->mensaje='No cuenta con permisos como Super Admin');
				exit;                
            }
        }
        $email=$_POST['email'];
        $password=$_POST['password'];
       // $empresa=(isset($_POST['empresa']))? $_POST['empresa'] : @$_POST['empresa2'];
      
	     $sql = 'SELECT u.'.$this->PrimaryKey.', u.tipo_usuario, u.activo, u.nombres, u.apellidos, u.ciudad, u.foto, u.id_facebook,u.id_aliado,
                u.email,u.duenocliente,a.logo FROM '.$_SESSION["bdatos"].'.'.$this->Table.' u
		LEFT JOIN aliados a ON a.id_aliado=u.id_aliado 
		WHERE u.email="'.$email.'" AND u.pass="'.md5($password).'" ';
		
        $datos = $this->Consulta($sql);				
		
		if(count($datos)>0){  
		  	if($datos[0]['activo']==0){
				$this->Error($this->mensaje='Este Usuario Esta inactivo');
				exit;
			}
			$var=false;
			
			$_SESSION["id_tipo"]	    = 'local';
			$_SESSION["id_usuario"]	    = $datos[0]['id_usuario'];
			$_SESSION["nombre"]		    = $datos[0]['nombres'];
			$_SESSION["apellido"]    	= $datos[0]['apellidos'];
			$_SESSION["ciudad"]		    = $datos[0]['ciudad'];
           	$_SESSION["tipo_usuario"]   = $datos[0]['tipo_usuario'];
            $_SESSION["correo"]         = $datos[0]['email'];
            $_SESSION["dueno"]          = $datos[0]['duenocliente'];
            $_SESSION["logo"]           = (!empty($datos[0]['logo']))? $datos[0]['logo'] : "./imagenes/polygraph-03.png";
			$_SESSION["empresa"]        = $datos[0]['id_aliado'];
            //$_SESSION["bdatos"]       = $datos2[0]['ruta'];
			if($datos[0]['foto']==0){				
				$_SESSION["foto"]		=   'archivosApp/usuario.jpg';
			}
			if($datos[0]['foto']==1){				
				$_SESSION["foto"]		=   'archivosApp/'.$_SESSION["id_usuario"].'.jpg';
			}

			if($datos[0]['foto']==2){				
				$_SESSION["foto"]		=   'http://graph.facebook.com/'.$datos[0]['id_facebook'].'/picture?type=large';				
			}			
			
			if($datos[0]['tipo_usuario']<>1){
			    echo'
    				<script>
    				   location.href="listados.php";
    				</script>
    				';
			}elseif($datos[0]['tipo_usuario']==1){
			    echo'
    				<script>
    				   location.href="listados_admin.php";
    				</script>
    				';
			}
			
		}else{			
			$this->Error($this->mensaje='Este Usuario No Existe');
		}			      
    } 
	
	/**
	 * Index::loginFB()
	 * 
	 * @param mixed $id_FB
	 * @param mixed $email_FB
	 * @return
	 */
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

	/**
	 * Index::Error()
	 * 
	 * @param mixed $mensaje
	 * @return
	 */
	function Error($mensaje){	
	#echo $this->mensaje;
		echo'
			<script>
			   location.href="index.php?me='.$mensaje.'";
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
    /**
     * Index::fn_editar()
     * 
     * @return
     */
    function fn_editar(){
        
    }
    

    /**
     * Index::_mostrar()
     * 
     * @return
     */
    function _mostrar(){
        /**  $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');*/
        $html = '';
       $html .= $this->_head();
       '<section id="main-wrapper" class="theme-default">';
        //$html = $this->Cabecera();
        $html .= $this->contenido();
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
    /**
     * Index::tablaDatos()
     * 
     * @return
     */
    function tablaDatos(){}   
	
/**
 * Index::enviarMail()
 * 
 * @param mixed $email
 * @return
 */
function enviarMail($email){
	$to = $email;
	$subject = "Correo de prueba";		
	
		$this->message = '
<table width="100%" border="0" align="center" style=" font-family:Arial, Helvetica, sans-serif; color:#333; font-size:12px;">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="542" align="center"><a href="http://cartasdelubricacion.com/sitio"><img name="" src="http://cartasdelubricacion.com/mail/logo-dna.png" width="290" height="57" alt="" /></a></td>
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
    <td align="center" style="background-color: #671675; font-size:14px; padding:20px; border-radius:6px; color:#FFF;"> Tu registro de usuario con face es: <strong>Usuario:</strong> '.$email.' <br /> </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="background-color:#4E4E4E; font-size:14px; padding:5px; border-radius:6px; color:#FFF;"><a href="http://www.cartasdelubricacion.com/cursos_online/login.php"><img src="http://cartasdelubricacion.com/mail/inicias-sesion.jpg" width="250" height="70" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">ir a <a href="http://cartasdelubricacion.com/sitio">cartasdelubricacion.com</a></td>
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
    $headers .= "From: DNA MUSIC <tudnamusic@gmail.com>\r\n"; 
	
	mail($to,'DNA MUSIC',$this->message,$headers);
		
	}
}
?>