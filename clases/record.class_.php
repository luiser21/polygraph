<?php
class Index extends crearHtml{
    
    public $_titulo = 'Registro de usuario';
    public $_subTitulo = 'Deseas registrar una nueva cuenta?';
    public $_datos = '';
    public $Table = 'usuarios';
    public $PrimaryKey = 'id_usuario';
	public $email = '';
    
    function ValidarUsuario($me){	
		$datosUsuario = $this->getDatos($me);
		#Imprimir($datosUsuario);
		
		#echo $datosUsuario[0]['email'];die();
		if($datosUsuario[0]['id_facebook']==''){	
			echo'
				<script>
				  // location.href="login.php";
				</script>
				';	
		}else{
			session_start();
			$_SESSION["id_tipo"]		= 'facebook';
			$_SESSION["id_facebook"]	= $datosUsuario[0]['id_facebook'];
			$_SESSION["nombre"]			= $me['first_name'];
			$_SESSION["apellido"]		= $me['last_name'];
            $_SESSION["tipo_usuario"]	= '1';
			echo'
				<script>
				   location.href="listados.php";
				</script>
				';	
		}        		                  
       
    } 
    
    
    /**
     * Index::Iniciar()
     * 
     * @return
     */
    function Iniciar(){
		
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
			#echo '<pre>'; print_r($me);
            $this->_mostrar();
        }
    } 
    /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){		
		
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqui:</span>
                    <ol class="breadcrumb">
                        <li class="active">'.$this->_titulo.'</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">Registro</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formRecord" role="form" enctype="multipart/form-data" >
<table width="100%" border="0">
  <tr>
    <td width="35%"> <label for="nombre">Nombres:</label></td>
    <td colspan="5">
    <input type="text" class="form-control"  id="nombre" name="nombre" required="required" placeholder="Digite sus nombres">
    </td>
  </tr>
  <tr>
    <td> <label for="nombre">Apellidos:</label></td>
    <td colspan="5">
    <input type="text" class="form-control"  id="apellido" name="apellido" required="required" placeholder="Digite sus apellidos">
    </td>
  </tr>
  <tr>
    <td> <label for="nombre">Documento:</label></td>
    <td width="17%">
    	<select class="form-control input-sm" id="tipo_documento">
        	<option value="1">Cedula</option>
        	<option value="2">Tarjeta Identidad</option>
        	<option value="3">Pasaporte</option>
        	<option value="4">Cedula Extran</option>
        </select>
    </td>
    <td width="16%"><label for="nombre">Numero:</label></td>
    <td colspan="3">
    <input type="text" class="form-control"  id="numero_doc" name="numero_doc" required="required" placeholder="Numero de documento">
    </td>
  </tr>
  <tr>
    <td><label for="nombre">Pais:</label></td>
    <td colspan="2">'.$this->consultarPais('').'</td>
    <td width="10%"><label for="nombre">Ciudad:</label></td>
    <td width="22%" colspan="2">'.$this->consultarMunicipio('').'</td>
  </tr>
  <tr>
    <td><label for="nombre">Telefono Movil:</label></td>
    <td colspan="5">
    <input type="text" class="form-control"  id="telefono" name="telefono" required="required" placeholder="Digite su telefono movil">
    </td>
  </tr>
  <tr>
    <td><label for="nombre">Correo Electronico:</label></td>
    <td colspan="5"><input type="text" class="form-control " required="" name="email" id="email" placeholder="Digite su e-mail"></td>
  </tr>
  <tr>
    <td><label for="nombre">Contrase&ntilde;a:</label></td>
    <td colspan="5"><input type="password" class="form-control " name="input7" id="input7" required="" placeholder="Password"></td>
  </tr>
  <tr>
    <td><label for="nombre">Confirmar Contrase&ntilde;a:</label></td>
    <td colspan="5"><input type="password" class="form-control " required="" name="input8" id="input8" placeholder="Recordar Password"></td>
  </tr>
</table>
                                    
                                    <div class="form-group">
                                        
                                    
                                    <button type="button" id="guardarRecord" class="btn btn-primary">Crear Cuenta</button>
                                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                                </form>


                            </div>
                        </div>
                    </div>
                    
                        </div>
                    </div>
                </div>                    

        </section>  '; 
		
    }
    
    /**
     * Index::guardarDatos()
     * 
     * @return
     */
    function guardarDatos(){
		#Imprimir($_REQUEST);
        $this->_datos = $_REQUEST;        
       if(!$this->_datos['id_usuario']){
		   if(count($this->consultarRegitro($this->_datos['numero_doc']))==0){
				$sql = "INSERT INTO ".$this->Table."(email,nombres,apellidos,tipo_documento,numero_documento,telefono,pass,fecha_registro) 
						VALUES 
						('".$this->_datos['email']."','".$this->_datos['nombre']."','".$this->_datos['apellido']."','".$this->_datos['tipo_documento']."','".$this->_datos['numero_doc']."','".$this->_datos['telefono']."','".$this->_datos['input7']."','".date('Y-m-d')."')";
				
					$this->QuerySql($sql);
					$this->enviarMail($this->_datos['email']);
					$mensaje = true;
		   }else{
			   $mensaje = false;
			}
       }else{
           $sql = 'UPDATE '.$this->Table ." SET email = '".$this->_datos['email']."', nombres = '".$this->_datos['nombre']."', apellidos = '".$this->_datos['apellido']."', tipo_documento = '".$this->_datos['tipo_documento']."', numero_documento = '".$this->_datos['numero_doc']."', telefono = '".$this->_datos['telefono']."', pass = '".$this->_datos['input7']."', = '".date('Y-m-d')."' WHERE ".$this->PrimaryKey." = ".$this->_datos['id_usuario'];
            $this->QuerySql($sql); 
       }
       
            if($mensaje==true){
            echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con exito </div>';   
					echo'
				<script>
				   location.href="listados.php";
				</script>
				';	
			}else{
			   echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Usuario Ya existe, Si olvido su contraseña click aqui! </div>';        
				
			}
			
    }

    function consultarRegitro($documento){       
		$condicion = ' numero_documento  = "'.$documento. '" AND ';
        $sql = 'SELECT '.$this->PrimaryKey.'  FROM '.$this->Table.' WHERE '.$condicion.' activo  = 1';
        $datos = $this->Consulta($sql); 
        return $datos;        
    } 

    function consultarPais($id_pais){       
		if($id_pais){
			$condicion = ' id  = '.$id_pais.' AND';
		}
        $sql = 'SELECT id, codigo_pais, descripcion  FROM z_pais WHERE '.$condicion.'  cancel  = 0';
        $datos = $this->Consulta($sql); 
		$html = ' <select class="form-control input-sm" id="pais"> ';
		
		for($oo = 0 ;  $oo < count($datos) ; $oo++){
				$html .= ' <option value="'.$datos[$oo]['id'].'">'.$datos[$oo]['descripcion'].'</option> ';
		}		
		$html .= '</select>';		
        return $html;        
    } 
    function consultarMunicipio($id_Muni){       
		if($id_Muni){
			$condicion = ' id  = '.$id_Muni.' AND';
		}
        $sql = 'SELECT id, z_departamento_id, codigo_municipio, descripcion  FROM z_municipio WHERE '.$condicion.'  cancel  = 0';
        $datos = $this->Consulta($sql); 
		$html = ' <select class="form-control input-sm" id="pais"> ';
		
		for($oo = 0 ;  $oo < count($datos) ; $oo++){
				$html .= ' <option value="'.$datos[$oo]['id'].'">'.$datos[$oo]['descripcion'].'</option> ';
		}		
		$html .= '</select>';		
        return $html;        
    } 


    /**
     * Index::subirArchivos()
     * 
     * @return
     */
    function subirArchivos(){
        
        $Ruta = './imgCursos/';
		$origen = $_FILES['file']['tmp_name'];
		$nombreImagen = $_FILES['file']['name'];
		
		$destino =$Ruta.$nombreImagen;
		$tipo = $_FILES['file']['type'];

		$tamano = $_FILES['file']['size'];
	    	
        
		if(copy($origen, $destino)){
		  return $destino;
        }
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
    function getDatos($me){
        $sql = 'SELECT '.$this->PrimaryKey .',email,nombres,apellidos,tipo_documento,numero_documento,telefono,pass,fecha_registro,id_facebook 
							   FROM '.$this->Table .' WHERE id_facebook = '.$me['id'];				   
							   
		$datos = $this->Consulta($sql); 
        return $datos;
    }
    
    /**
     * Index::_mostrar()
     * 
     * @return
     */
    function _mostrar(){
		#echo '<pre>'; print_r($me);die();
        $html = $this->Cabecera();
        $html .= $this->contenido($me);
        $html .= $this->Pata();
        echo $html;
    }
    
    /**
     * Index::tablaDatos()
     * 
     * @return
     */
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = 'SELECT email,nombres,apellidos,tipo_documento,numero_documento,telefono,pass,fecha_registro,'.$editar.','.$eliminar.' 
				FROM '.$this->Table.' WHERE activo = 1';
        
        $datos = $this->Consulta($sql); 
        
        if(count($datos)){
            $_array_formu = array();
            $_array_formu = $this->generateHead($datos);
            $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();
            
            $tablaHtml  ='<div class="panel-body recargaDatos">';
    		$tablaHtml .= $this->print_table($_array_formu, 4, true, 'table table-striped table-bordered',"id='tablaDatos'");
            $tablaHtml .='</div>';
        }else{
            $tablaHtml = '<div class="col-md-8">
                            <div class="alert alert-info alert-dismissable">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                                <strong>Atenci&oacute;n</strong>
                                No se encontraron registros.
                            </div>
                          </div>';
        }
 
        if($this->_datos=='r')  echo $tablaHtml;
        else    return $tablaHtml;
        
    }   
	function enviarMail($email){
	$to = $email;
	$subject = "Correo de prueba";
	$message = '<body>
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
</table>
</body>';


    $headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$from = "tudnamusic@gmail.com";
	$headers = "From:" . $from;
	mail($to,'DNA MUSIC',$message,$headers);
	echo "Correo enviado";		
	}
	
}
?>