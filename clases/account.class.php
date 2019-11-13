<?php
class Index extends crearHtml{
    
    public $_titulo = 'Mi cuenta';
    public $_subTitulo = '';
    public $_datos = '';
    public $Table = 'usuarios';
    public $PrimaryKey = 'id_usuario';
	public $email = '';
	public $id_usuario = '';
    
   
    /**
     * Index::Iniciar()
     * 
     * @return
     */
    function Iniciar(){
		
         $this->_file  = $_SERVER['PHP_SELF'];
         $this->idUsuario = $_SESSION['id_usuario'];
         if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || isset($_REQUEST['uploadFileIframe'])){
            $_REQUEST['d'] = (isset($_REQUEST['d'])) ? $_REQUEST['d'] : '1';
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
	
		$datosUsuario = $this->getDatos();
        $html ='';
		if($datosUsuario==false){
			#Si es false es por que no existe sesion
			echo'
				<script>
				   location.href="index.php";
				</script>
				';	
		}
		#Imprimir($datosUsuario);
		if(isset($datosUsuario)){
			$nombres 		= $datosUsuario[0]['nombres'];
			$apellidos 		= $datosUsuario[0]['apellidos'];
			$email 			= $datosUsuario[0]['email'];
			$tipo_documento = $datosUsuario[0]['tipo_documento'];
			$s_1 =  ( $tipo_documento == 1 )? ' selected="selected"' : '';
			$s_2 =  ( $tipo_documento == 2 )? ' selected="selected"' : '';
			$s_3 =  ( $tipo_documento == 3 )? ' selected="selected"' : '';
			$s_4 =  ( $tipo_documento == 4 )? ' selected="selected"' : '';
			$numero_documento 	= $datosUsuario[0]['numero_documento'];
			$telefono 			= $datosUsuario[0]['telefono'];
			$id 				= $datosUsuario[0]['id_usuario'];	
			
			
					
		}else{
			$nombres 		= '';
			$apellidos 		= '';
			$email 			= '';
			$tipo_documento = '';
			$numero_documento 	= '';
			$telefono 			= '';
			$id 				= '';
			
		}

        $html .= '<section class="main-content-wrapper">
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
                                <h3 class="panel-title">MI INFORMACION</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formRecord" role="form" enctype="multipart/form-data" >
                                    <div class="form-group">
                                        <label for="nombre">Nombres:</label>
                                        <input type="text" class="form-control"  id="nombre" name="nombre" required="required" placeholder="Digite sus nombres" value="'.$nombres.'">
                                    </div>  
                                    <div class="form-group">
                                        <label for="nombre">Apellidos:</label>
                                        <input type="text" class="form-control"  id="apellido" name="apellido" required="required" placeholder="Digite sus apellidos" value="'.$apellidos.'">
                                    </div>  
                                    <div class="form-group">
                                        <label for="nombre">Documento:</label>
                                        	<select class="form-control input-sm" id="tipo_documento" name ="tipo_documento" >
                                            	<option value="1" '.$s_1.' >Cedula</option>
                                            	<option value="2" '.$s_2.'>Tarjeta Identidad</option>
                                            	<option value="3" '.$s_3.'>Pasaporte</option>
                                            	<option value="4" '.$s_4.'>Cedula Extran</option>
                                            </select>
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label for="numero">Numero:</label>                                    
                                        <input type="text" class="form-control"  id="numero_doc" name="numero_doc" required="required" placeholder="Numero de documento" value="'.$numero_documento.'">
                                    </div>
                                    
                                    
                                     
                                                       
                                    <div class="form-group">
                                        <label for="nombre">Telefono Movil:</label>
                                        <input type="text" class="form-control"  id="telefono" name="telefono" required="required" placeholder="Digite su telefono movil" value="'.$telefono.'">
                                    </div> 
                                    <div class="form-group">

                                    <button type="button" id="actualizarRecord" class="btn btn-primary">ACTUALIZAR</button>
                                        <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
    									<input name="id_usuario" id="id_usuario" type="hidden" value="'.$id.'" />                                                                                                                                                                                     
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                          
                    
                        </div>
                    </div>
                </div> ';
           // $html .= $this->getCertificaciones();

           $html .= ' <div class="col-md-4">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">CONTRASE&Ntilde;A</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                              
                                    <div class="form-group">
									 <form id="formPass" role="form" enctype="multipart/form-data" >
<table width="100%" border="0">									
  <tr>
    <td>Contrase&ntilde;a actual</td>
</tr>
  <tr>	
    <td colspan="5"><input type="password" class="form-control " required="" name="pass_actual" id="pass_actual" placeholder="Actual"></td>
  </tr>
  <tr>
    <td>Contrase&ntilde;a nueva</td>
</tr>
  <tr>	
    <td colspan="5"><input type="password" class="form-control " name="pass_nuevo" id="pass_nuevo" required="true" placeholder="Nuevo"></td>
  </tr>
  <tr>
    <td>Confirmar Contrase&ntilde;a </td>
</tr>
  <tr>	
    <td colspan="5"><input type="password" class="form-control " required="" name="pass_nuevo_conf" id="pass_nuevo_conf" placeholder="Confirme"></td>
  </tr>
</table>                                        
                                   <input name="id_usuario" id="id_usuario" type="hidden" value="'.$id.'" />
                                    <button type="button" id="guardarPass" class="btn btn-primary">Cambiar Contrase&ntilde;a</button>
                                    <div class="panel" id="ResultadoPass" style="display:none">RESULTADO</div>
                               		</div>	
</form>
                            </div>
                     </div>
                  

        </section>  '; 
		return $html;
    }

   
    
	function guardarPass(){
		#Imprimir($_REQUEST);
		$resp = $this->getDatos();
		$this->_datos = $_REQUEST;
      //  imprimir($resp);
       // imprimir($this->_datos);
		if( $resp[0]['pass'] != md5( $this->_datos['pass_actual'] ) ){
			echo '<div class="alert alert-warning alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Contrase&ntilde;a actual incorrecta
				  </div>';  
			exit;
		}
		if($this->_datos['pass_nuevo']=='' || $this->_datos['pass_nuevo_conf']==''){
			echo '<div class="alert alert-warning alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Todos los campos son obligatorios
				  </div>';  
			exit;
		}
		if($this->_datos['pass_nuevo'] != $this->_datos['pass_nuevo_conf']){
			echo '<div class="alert alert-warning alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    No coinciden la contrase&ntilde;a nueva con la confirmacion
				  </div>'; 
			exit;
		}		
		 $sql = 'UPDATE '.$this->Table ." SET pass = '".md5($this->_datos['pass_nuevo'])."' WHERE ".$this->PrimaryKey." = ".$this->_datos['id_usuario'];
         $this->QuerySql($sql); 
        
		 	echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Contrase&ntilde;a cambiada exitosamente.
				  </div>'; 		 
	}

    /**
     * Index::guardarDatos()
     * 
     * @return
     */
    function guardarDatos(){
		#Imprimir($_REQUEST);
        $this->_datos = $_REQUEST;
        $email = '';
        $clave = '';        
       if(!$this->_datos['id_usuario']){
		   if(count($this->consultarRegitro($this->_datos['numero_doc']))==0){
				$sql = "INSERT INTO ".$this->Table."(email,nombres,apellidos,tipo_documento,numero_documento,telefono,pass,fecha_registro,tipo_documento) 
						VALUES 
						('".$this->_datos['email']."','".$this->_datos['nombre']."','".$this->_datos['apellido']."','".$this->_datos['tipo_documento']."','".$this->_datos['numero_doc']."','".$this->_datos['telefono']."','".md5($this->_datos['input7'])."','".date('Y-m-d')."','".$this->_datos['tipo_documento']."')";
				
					$this->QuerySql($sql);
					$mensaje = true;
		   }else{
			   $mensaje = false;
			}
       }else{
            if( isset( $this->_datos['email'] ) )
                $email = " email = '".$this->_datos['email']."',";
            if( isset( $this->_datos['input7'] ) )
                $clave = "pass = '".md5($this->_datos['input7'])."',";
                
            $sql = 'UPDATE '.$this->Table ." SET {$email} nombres = '".$this->_datos['nombre']."', apellidos = '".$this->_datos['apellido']."', 
                        tipo_documento = '".$this->_datos['tipo_documento']."', numero_documento = '".$this->_datos['numero_doc']."', 
                        telefono = '".$this->_datos['telefono']."', {$clave} fecha_registro = '".date('Y-m-d')."' , 
                        tipo_documento = '".$this->_datos['tipo_documento']."'  
                        WHERE ".$this->PrimaryKey." = ".$this->_datos['id_usuario'];
            $this->QuerySql($sql); 
            
       }
	
            if( isset( $mensaje ) && $mensaje==true ){
            echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con exito </div>';        
			}else{
			   echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Actualizacion Exitosa! </div>';	
			}
			
    }

    function consultarRegitro($documento){       
		$condicion = ' numero_documento  = "'.$documento. '" AND ';
        $sql = 'SELECT '.$this->PrimaryKey.'  FROM '.$this->Table.' WHERE '.$condicion.' activo  = 1';
        $datos = $this->Consulta($sql); 
        return $datos;        
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
    function getDatos(){
		if(isset($_SESSION["id_tipo"])){
			if($_SESSION["id_tipo"]=='local'){
				$condicion = '  id_usuario = '.$_SESSION["id_usuario"];
			}else{
				$condicion = '  id_facebook = '.$_SESSION["id_facebook"];
			}
			
			$sql = 'SELECT '.$this->PrimaryKey .',email,nombres,apellidos,tipo_documento,numero_documento,telefono,pass,fecha_registro,id_facebook 
								   FROM '.$this->Table .' WHERE  '.$condicion . ' AND activo = 1';				   
								  
			$datos = $this->Consulta($sql); 
		}else{
			
			$datos = false;
		}
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
        $html .= $this->contenido();
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
}
?>