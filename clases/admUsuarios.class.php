<?php
class Index extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR USUARIOS';
    public $_subTitulo = 'Administrar usuarios';
    public $_datos = '';
    public $Table = 'usuarios';
    public $PrimaryKey = 'id_usuario';
    
    
    /**
     * crearHtml::getEstados()
     * retorna arreglo con las opciones de Activo,Inactivo
     * @return array()
     */
     public function getTipoUsuario(){
        $sql = 'SELECT `id_tipo_usuario` codigo, `descripcion` FROM `tipo_usuario` WHERE `activo` = 1';
        return $this->Consulta($sql);
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
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Usuarios</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-12">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">Usuario</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                '.$this->formularioUsuarios().'
                            </div>
                        </div>
                    </div>'.$this->tablaDatos().'
                    
                        </div>
                    </div>
                </div>                    

        </section>  ';    
    }
   
   
    function formularioUsuarios(){
        $html = '<form id="formUsuario" role="form">
                                    <div class="form-group">
                                        <label for="nombre">Nombres:</label>
                                        <input type="text" class="form-control"  id="nombres" name="nombres" required="required" placeholder="Digite sus nombres">
                                    </div>  
                                    <div class="form-group">
                                        <label for="nombre">Apellidos:</label>
                                        <input type="text" class="form-control"  id="apellidos" name="apellidos" required="required" placeholder="Digite sus apellidos">
                                    </div>  
                                    
                                    <div class="form-group">
                                        <label for="nombre">Email:</label>
                                        <input type="email" class="form-control"  id="email" name="email" required="required" placeholder="El correo elecronico sera usado omo usuario">
                                    </div>  
                                                                        
                                    <div class="form-group">
                                        <label for="nombre">Documento:</label>
                                        	<select class="form-control input-sm" id="tipo_documento" name ="tipo_documento" >
                                            	<option value="1">Cedula</option>
                                            	<option value="2">Tarjeta Identidad</option>
                                            	<option value="3">Pasaporte</option>
                                            	<option value="4">Cedula Extran</option>
                                            </select>
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label for="numero">Numero:</label>                                    
                                        <input type="text" class="form-control"  id="numero_documento" name="numero_documento" required="required" placeholder="Numero de documento">
                                    </div>

                                    <div class="form-group">
                                        <label for="pais">Pais:</label>
                                        '.$this->consultarPais().'
                                    </div>
                                      
                                    <div class="form-group">
                                        <label for="pais">Ciudad:</label>
                                        '.$this->consultarMunicipio().'
                                    </div>
                                                                        
                                    <div class="form-group">
                                        <label for="nombre">Telefono Movil:</label>
                                        <input type="text" class="form-control"  id="telefono" name="telefono" required="required" placeholder="Digite su telefono movil">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nombre">Tipo de usuario:</label>
                                        '.$this->crearSelect('tipo_usuario','tipo_usuario',$this->getTipoUsuario(),false,false,false,'class="form-control"').'
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nombre">Activo en el sistema:</label>
                                        '.$this->crearSelect('activo','activo',$this->getEstados(),false,false,false,'class="form-control"').'
                                    
                                    </div> 
                                                                                                              
                                    <div class="form-group">
                                        <button type="button" id="guardarUsuario" class="btn btn-primary">ACTUALIZAR</button>
                                        <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
    									<input name="id_usuario" id="id_usuario" type="hidden" />                                                                                                                                                                                     
                                    </div>
                                </form>';
             return $html;
    }
   
    
    /**
     * Index::guardarDatos()
     * 
     * @return
     */
    function guardarDatos(){
       if( !isset($this->_datos['id_usuario']) || empty($this->_datos['id_usuario']) ){
        $sql = "INSERT INTO `usuarios`(`nombres`, `apellidos`,email, tipo_documento,numero_documento,`pais`,`ciudad`,`telefono`,tipo_usuario,activo,pass) 
                VALUES 
                ('".$this->_datos['nombres']."','".$this->_datos['apellidos']."','".$this->_datos['email']."','".$this->_datos['tipo_documento']."','".$this->_datos['numero_documento']."','".$this->_datos['pais']."','".$this->_datos['ciudad']."','".$this->_datos['telefono']."','".$this->_datos['tipo_usuario']."','".$this->_datos['activo']."','dna2015')";
        
            $this->QuerySql($sql);
       }else{
           $sql = 'UPDATE '.$this->Table ." SET 
            `nombres` = '".$this->_datos['nombres']."',
            `apellidos` = '".$this->_datos['apellidos']."',
            `email` = '".$this->_datos['email']."',
            `tipo_documento` = '".$this->_datos['tipo_documento']."',
            `numero_documento` = '".$this->_datos['numero_documento']."',
            `pais` = '".$this->_datos['pais']."',
            `ciudad` = '".$this->_datos['ciudad']."',
            `telefono` = '".$this->_datos['telefono']."',
            `tipo_usuario` = '".$this->_datos['tipo_usuario']."',
            `activo` = '".$this->_datos['activo']."'  
             WHERE ".$this->PrimaryKey." = ".$this->_datos['id_usuario'];
            $this->QuerySql($sql); 
       }
            echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con &eacute;xito </div>';        
    }

    /**
     * Index::subirArchivos()
     * @param string $campo, hace referencia al nombre del input file que lleva el archivo a subir
     * @return
     
    function subirArchivos($campo){
        
        $Ruta = './imgCursos/';
		$origen = $_FILES[$campo]['tmp_name'];
		$nombreImagen = $_FILES[$campo]['name'];
		
		$destino =$Ruta.$nombreImagen;
		$tipo = $_FILES[$campo]['type'];
		$tamano = $_FILES[$campo]['size'];

		if(copy($origen, $destino)){
		  return $destino;
        }
    }
*/
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
    function getDatos(){
        $res = $this->Consulta('SELECT `id_usuario`, `tipo_usuario`,`email`, `nombres`, `apellidos`, `tipo_documento`, `numero_documento`, `telefono`, `pass`, `fecha_registro`, `pais`, `ciudad`, `activo` FROM '.$this->Table ." WHERE " . $this->PrimaryKey . " = ".$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    /**
     * Index::_mostrar()
     * 
     * @return
     */
    function _mostrar(){
      /**  $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');*/
        $html = $this->Cabecera();
        $html .= $this->contenido();
      //  $html .= $this->tablaDatos();
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
        $sql = 'SELECT `email`, `nombres`, `apellidos`, `numero_documento`, `telefono`, `activo` , '.$editar.','.$eliminar.' FROM '.$this->Table.' t WHERE activo = 1';
        
        $datos = $this->Consulta($sql); 
        
        if(count($datos)){
            $_array_formu = array();
            $_array_formu = $this->generateHead($datos);
            $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();
            
            $tablaHtml  ='<div class="panel-body recargaDatos">';
    		$tablaHtml .= $this->print_table($_array_formu, 8, true, 'table table-striped table-bordered',"id='tablaDatos'");
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