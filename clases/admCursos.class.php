<?php
class Index extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR CURSOS';
    public $_subTitulo = 'Agrega un curso';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';
       
    
    
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
            $this->_mostrar();
        }
    }
    
    /**
     * Index::getTipo()
     * retorna arreglo con las opciones de Activo,Inactivo
     * @return array()
     */
     public function getTipo(){
        $_array = array();
        array_push($_array, array( 'codigo' => '1', 'descripcion' => 'Curso') );
        array_push($_array, array( 'codigo' => '2', 'descripcion' => 'Evento') );
        return $_array;
    }
    
     
    /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
        
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>CREAR CURSO / EVENTO</h1>
                <p class="description">Crear curso para cada categor&iacute;a.</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Admin Curso / Evento</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">Crear Curso / Evento</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCreaCurso" role="form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="nombre">Curso / Evento:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required="required" placeholder="Nombre para el curso o evento nuevo">
                                        <input type="hidden" id="id_cursos" name="id_cursos" value="0">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="descripcion">Tipo:</label>
                                        '.$this->crearSelect('tipo','tipo',$this->getTipo(),false,false,false,'class="form-control"').'
                                    </div>                                    
                                    
                                    <div class="form-group">
                                        <label for="descripcion">Desripcion del curso / Evento:</label>
                                        <textarea rows="4" class="form-control"  cols="50" placeholder="Breve descripcion del curso o evento nuevo" id="descripcion" name="descripcion"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="descripcion">Informaci&oacute;n del curso / Evento:</label>
                                        <textarea rows="4" class="form-control"  cols="50" placeholder="Aqu&iacute; la informaci&oacute;n que llevara este curso" id="informacion" name="informacion"></textarea>
                                    </div>                                                                            
                                    
                                    <div class="form-group">
                                        <label for="nombre">Duraci&oacute;n:</label>
                                        <input type="text" class="form-control" id="duracion" name="duracion" maxlength="3" placeholder="Duraci&oacute;n en d&iacute;as (Solo aplica cursos)" size="4">    
                                    </div>
                                    
                                <div class="form-group">
                                        <label for="fecha_fin">Precio:</label>
                                        <input type="text" class="form-control" id="precio" name="precio" placeholder="Costo del curso o Evento">
                                        
                                    </div>                                                                        
                                    
                                    <div class="form-group">
                                        <label for="file">Imagen Curso:</label>
                                        <input type="file" id="file" name="file">
                                    </div>    
                                    
                                    <div class="form-group">
                                        <label for="file_banner">Imagen Banner</label>
                                        <input type="file" id="file_banner" name="file_banner">
                                    </div>
                                    
                                    
                                    <button type="button" id="guardarPrincipal" class="btn btn-primary">Guardar Curso</button>
                                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                                </form>


                            </div>
                        </div>
                    </div>'.$this->tablaDatos().'
                    
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
        try{
        $this->_datos = $_REQUEST;
       if(!$this->_datos['id_cursos']){
        
        $img = $this->subirArchivos('file');
        $imgBanner = $this->subirArchivos('file_banner');
        
        $sql = "INSERT INTO `cursos`(`nombre`, `tipo`, `descripcion`, `informacion`, `duracion` ,`precio` ,`id_usuario`,`img`,`img_banner`) 
                VALUES 
                ('".$this->_datos['nombre']."','".$this->_datos['tipo']."','".$this->_datos['descripcion']."','".$this->_datos['informacion']."','".$this->_datos['duracion']."','".$this->_datos['precio']."','".$this->idUsuario."','".$img."','".$imgBanner."')";
        
            $this->QuerySql($sql);
       }
       else{
        
        $addCampo = '';
            if($_FILES['file']['name'] != ''){
                $img = $this->subirArchivos('file');
                $addCampo .= " , `img` = '".$img."' ";
            }
            if($_FILES['file_banner']['name'] != ''){
                $imgBanner = $this->subirArchivos('file_banner');
                $addCampo .= " , `img_banner` = '".$imgBanner."' ";
            }
            $sql = 'UPDATE '.$this->Table ." SET nombre = '".$this->_datos['nombre']."', descripcion = '".$this->_datos['descripcion']."', informacion = '".$this->_datos['informacion']."' , duracion = '".$this->_datos['duracion']."',precio = '".$this->_datos['precio']."',`id_usuario` = '".$this->idUsuario."' ".$addCampo."  WHERE ".$this->PrimaryKey." = ".$this->_datos['id_cursos'];
            $this->QuerySql($sql); 
       }
       
            
            echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con &eacute;xito </div>';
       } catch ( Exception $e ) {
            echo '<div class="alert alert-danger">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    No se ha podido guardar el arcchivo por: '.$e->getMessage().' </div>';
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
    function getDatos(){
        $res = $this->Consulta('SELECT `id_cursos`, `nombre`, `tipo`, `descripcion`,`informacion`, duracion,precio FROM '.$this->Table ." WHERE id_cursos = ".$this->_datos);
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
        $sql = 'SELECT
                if(t.tipo=1,"Curso","Evento") Tipo, 
                t.`nombre`,
                t.`fecharegistro`,
                t.duracion,
                t.precio ,
                    
                '.$editar.','.$eliminar.' FROM '.$this->Table.' t WHERE activo = 1';
        
        $datos = $this->Consulta($sql); 
        
        if(count($datos)){
            $_array_formu = array();
            $_array_formu = $this->generateHead($datos);
            $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) ) ? $_array_formu[0]: array();
            
            $tablaHtml  ='<div class="panel-body recargaDatos">';
    		$tablaHtml .= $this->print_table($_array_formu, 7, true, 'table table-striped table-bordered',"id='tablaDatos'");
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