<?php
class Usuarios extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA USUARIOS';
    public $_subTitulo = 'Crear usuarios';
    public $_datos = '';
    public $Table = 'usuarios';
    public $PrimaryKey = 'id_usuario';
    
    /**
     * Index::Iniciar()
     *
     * @return
     */
   /* function Iniciar(){
        
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
    */
   function Contenido(){
       
      /* $datosUsuario = $this->getDatos();
       
       if(isset($datosUsuario)){
           $nombres 		= $datosUsuario[0]['nombres'];
           $apellidos 		= $datosUsuario[0]['apellidos'];
           $email 			= $datosUsuario[0]['email'];
           $tipo_documento = $datosUsuario[0]['tipo_documento'];
           $s_1 =  ( $tipo_documento == 1 )? ' selected="selected"' : '';
           $s_2 =  ( $tipo_documento == 2 )? ' selected="selected"' : '';
           $s_3 =  ( $tipo_documento == 0 )? ' selected="selected"' : '';
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
           $s_1 =  ( $tipo_documento == 1 )? ' selected="selected"' : '';
           $s_2 =  ( $tipo_documento == 2 )? ' selected="selected"' : '';
           $s_3 =  ( $tipo_documento == 3 )? ' selected="selected"' : '';
           $s_4 =  ( $tipo_documento == 0 )? ' selected="selected"' : '';
           
       }
       */
       $sql = 'SELECT id_parametro as codigo, empresa as descripcion FROM parametros ';
       $arr = $this->Consulta($sql);
       
       if($_SESSION['tipo_usuario']==2){
           $sql = 'SELECT id_tipo_usuario as codigo, descripcion FROM tipo_usuario where id_tipo_usuario<>1';
           $arrtipo = $this->Consulta($sql);
       }else{
           $sql = 'SELECT id_tipo_usuario as codigo, descripcion FROM tipo_usuario ';
           $arrtipo = $this->Consulta($sql);
       }
       
       
          
          
          $mostrar= '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Usuarios</li>
                    </ol>
                </div>
            </div>
                    
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">Usuarios</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                    <div class="form-group">
                                        <label for="id_cursos">Tipo Usuarios:</label>
                                        '.$this->crearSelect('tipo_usuario','tipo_usuario',$arrtipo,false,false,false,'class="form-control required"').'
                                        '.$this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').'
                                        '.$this->create_input('hidden','id_empresa','id_empresa',false,$arr[0]['codigo']).'
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">N&uacute;mero de Documento:</label>
                                        '.                                     
                                        $this->create_input('text','numero_documento','numero_documento','Numero del documento',false,'form-control required').
                                        '
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">Nombres:</label>
                                        '. $this->create_input('text','nombres','nombres','Nombre del usuario',false,'form-control required').'
                                            
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">Apellidos del Usuario:</label>
                                        '. $this->create_input('text','apellidos','apellidos','Apellido del usuario',false,'form-control required').'
                                            
                                    </div>
                                   
                                    <div class="form-group">
                                        <label for="id_cursos">Email - (Usuario):</label>
                                        '. $this->create_input('text','email','email','Email-Usuario',false,'form-control required').'
                                            
                                    </div> 
                                     ';
                                    
                                        $mostrar.=$this->create_input('hidden','duenocliente','duenocliente',false,0);
                                        
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                        $mostrar.='<button type="button" id="guardarCurso" class="btn btn-primary">Guardar Usuario</button>';
                                    }
                                    $mostrar.='<div id="Resultado" style="display:none">RESULTADO</div>
                                </form>
                            </div>
                        </div>
                    </div> '.$this->tablaDatos().'
                        
                        </div>
                    </div>
                </div>
                        
        </section>  ';
                                        
   return $mostrar;
   
    }
    
    
    function guardarDatos(){
       
        try {
            $sql="SELECT COUNT(1) AS USUARIOS FROM usuarios WHERE email='".$this->_datos['email']."' AND  ACTIVO=1 AND numero_documento='".$this->_datos['numero_documento']."'";
            $datos= $this->Consulta($sql);
            if($datos[0]['USUARIOS']>=1){
                $sql="UPDATE usuarios SET 
                    tipo_usuario=".$this->_datos['tipo_usuario'].",
                    nombres='".$this->_datos['nombres']."',
                    apellidos='".$this->_datos['apellidos']."',
                    duenocliente=".$this->_datos['duenocliente']."
                    WHERE email='".$this->_datos['email']."' AND  numero_documento='".$this->_datos['numero_documento']."' ";
                $this->QuerySql($sql);
                $_respuesta = array('Codigo' => 1, "Mensaje" => 'Datos Ingresados con &eacute;xito');
                
            }else{
                $sql="SELECT COUNT(1) AS USUARIOS FROM usuarios WHERE email='".$this->_datos['email']."' AND ACTIVO=1 ";
                $datos= $this->Consulta($sql);
                if($datos[0]['USUARIOS']>=1){
                    $respuesta2= '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button>
                    Ya existe un usuario con ese email favor verificar datos! </div>';	
                    $_respuesta = array('Codigo' => 0, "Mensaje" => 'Ya existe un usuario con ese email favor verificar datos!');
                }else{
                   $sql = "INSERT INTO usuarios (email,tipo_usuario,nombres,apellidos,numero_documento,duenocliente,pass)
                    VALUES('".$this->_datos['email']."',
                            ".$this->_datos['tipo_usuario'].",
                           '".$this->_datos['nombres']."',
                           '".$this->_datos['apellidos']."',
                            ".$this->_datos['numero_documento'].",
                            ".$this->_datos['duenocliente'].",'e10adc3949ba59abbe56e057f20f883e')";
                   $this->QuerySql($sql);
                   $sql = "SELECT id_usuario from usuarios where email='".$this->_datos['email']."'";
                   $datos = $this->Consulta($sql); 
                   
                   
                   $sql = "INSERT INTO usuarios_parametros (id_parametro,id_usuario,lubrimaq,duenocliente)VALUES(".$this->_datos['id_empresa'].",".$datos[0]['id_usuario'].",1,".$this->_datos['duenocliente'].")";
                   $this->QuerySql( $sql);
                   $_respuesta = array('Codigo' => 1, "Mensaje" => 'Datos Ingresados con &eacute;xito');
                }
            }
        }
        catch (exception $e) {
            $_respuesta = array('Codigo' => 0, "Mensaje" => 'Error, por favor revisar los datos guardados e ingresar => '.$e);
        }
        
        echo json_encode($_respuesta); 
        
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        $sql = 'DELETE FROM '.$this->Table .'  WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $this->QuerySql($sql);
        
        $sql = 'DELETE FROM usuarios_parametros WHERE id_usuario='.$this->_datos;
        $this->QuerySql($sql);
        //$_respuesta = array('Codigo' => 1, "Mensaje" => 'Se ha eliminado el item con &eacute;xito');
        echo 'Se ha eliminado el item con &eacute;xito';
    }
    
    function fn_editar(){
        
    }
    
    /**
     * Index::getDatos()
     * Extrae todos los datos y los retorna como Json, creada para llenar formularios en el editar de cada interfaz
     * @return void
     */
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    /**
     * Index::_mostrar()
     * Muestra los datos armados atravez de 3 metodos $this->Cabecera(); $this->contenido(); $this->Pata();
     * @return void
     */
    function _mostrar(){
        $html = $this->Cabecera();
        $html .= $this->contenido();
        $html .= $this->Pata();
        echo $html;
    }
    
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $seccion= $this->Imagenes($this->PrimaryKey,11);
        $sql = '';
        if(	$_SESSION["tipo_usuario"]==1){
             $sql = '
        SELECT 
            t.id_usuario as ID,
            t.nombres,
            t.apellidos, 
            t.numero_documento,
            t.email as USUARIO,     
            '.$seccion.',  
            '.$editar.',
            '.$eliminar.' 
            FROM '.$this->Table.' t 
            WHERE t.activo = 1 
            ORDER BY t.id_usuario';
           
       }     
      
        $datos = $this->Consulta($sql,1); 
        if(count($datos)){
            $_array_formu = array();
            $y=0;
            foreach($datos as $value){
                $sql = 'SELECT ti.descripcion FROM usuarios u, tipo_usuario ti 
                        WHERE u.tipo_usuario=ti.id_tipo_usuario and u.id_usuario='.$datos[$y]['ID'];
                $arrSecciones = $this->Consulta($sql);
                $datos[$y]['TIPOUSUARIO']=$arrSecciones[0]['descripcion'];
                $y++;
                    
            }
            $_array_formu = $this->generateHead($datos);
            $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();
            
            $tablaHtml  = '<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body recargaDatos"  style="page-break-after: always;">
                            <div class="table-responsive">';
            $tablaHtml  .='';
    		$tablaHtml .= $this->print_table($_array_formu, 8, true, 'table table-striped table-bordered',"id='tablaDatos'");
    		$tablaHtml .=' </div>
           </div>
                        </div>
                    </div>
                </div>
            ';
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