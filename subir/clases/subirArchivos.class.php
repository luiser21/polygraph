<?php
class Index extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR CAPITULOS';
    public $_subTitulo = 'Agrega un Capitulo';
    public $_datos = '';
    public $Table = 'capitulos';
    public $PrimaryKey = 'id_capitulo';
    
    
    
    /**
     * Index::Iniciar()
     * 
     * @return
     */
    function Iniciar(){
         $this->_file  = $_SERVER['PHP_SELF'];
         $this->idUsuario = '1';
         echo '';
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
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
        $sql = 'SELECT id_cursos codigo, nombre as descripcion from cursos WHERE activo = 1';
        $cursos = $this->Consulta($sql);
        
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>Cargar Archivos</h1>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">You are here:</span>
                    <ol class="breadcrumb">
                        <li><a href="index.html">Dashboard</a>
                        </li>
                        <li>Forms</li>
                        <li class="active">Multiple File Upload</li>
                    </ol>
                </div>
            </div>
            <section id="main-content" class="animated fadeInUp">
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">ASOCIAR</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCreaCurso" role="form">
                                    <div class="form-group">
                                        <label for="id_cursos">Curso:</label>
                                        '.$this->crearSelect('id_cursos','Eid_cursos',$cursos,false,false,false,'class="form-control"').'
                                        
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="nombre">Capitulo</label>
                                        <div class="panel" id="Resultado">Elija un Curso</div>
                                    </div>

                               <!--     <button type="button" id="guardarCurso" class="btn btn-primary">Guardar Curso</button>
                                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div> --!>
                                </form>


                            </div>
                        </div>
                    </div>                    
                        </div>
                    </div>
                </div>  
                
                <div class="row panelArchivo" style="display:none">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Dropzone</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form action="?process=subirArchivos&d=1" enctype="multipart/form-data" class="dropzone" id="my-awesome-dropzone">
                                    '.$this->create_input('hidden','Sid_capitulo','Sid_capitulo').'
                                </form>

                            </div>
                        </div>
                    </div>
                </div>                
            </section>
        </section>  ';    
    }
    
    /**
     * Index::guardarDatos()
     * 
     * @return
     
    function guardarDatos(){
        
       if(!$this->_datos['id_capitulo']){ 
        $sql = "INSERT INTO `".$this->Table."` (`id_cursos`, `nombre`, `descripcion`,`id_usuario`) 
                VALUES 
                ('".$this->_datos['id_cursos']."', '".$this->_datos['nombre']."','".$this->_datos['descripcion']."','".$this->idUsuario."')";
        
            $this->QuerySql($sql);
       }else{
           $sql = 'UPDATE '.$this->Table ." SET nombre = '".$this->_datos['nombre']."', descripcion = '".$this->_datos['descripcion']."',`id_usuario` = '".$this->idUsuario."' WHERE ".$this->PrimaryKey." = ".$this->_datos['id_capitulo'];
            $this->QuerySql($sql); 
       }
       
            
            echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con éxito </div>';        
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
     * Index::mostrarCapitulos()
     * 
     * @return
     */
    function mostrarCapitulos(){
        if( !isset( $this->_datos ) ){
            die( 'No se ha seleccionado un Id de Curso!' );
        }
        $sql = 'SELECT id_capitulo as codigo, nombre as descripcion FROM capitulos WHERE id_cursos = '.$this->_datos;
        $datos = $this->Consulta($sql);
        echo $this->crearSelect('id_capitulo','id_capitulo',$datos,false,false,false,'class="form-control" onchange="agregaCapitulo();"');
    }
    
    /**
     * Index::subirArchivos()
     * 
     * @return
     */
    function subirArchivos(){
        imprimir($_POST);
        $Ruta = './archivosApp/';
		$origen = $_FILES['file']['tmp_name'];
		$nombreImagen = $_FILES['file']['name'];
		
		$destino =$Ruta.$nombreImagen;
		$tipo = $_FILES['file']['type'];

		$tamano = $_FILES['file']['size'];
	    	
        
		if(copy($origen, $destino)){
		  /** Guarda en tabla los archivos que se cargan */
          $sql = "INSERT INTO `archivos_app`(`id_capitulo`, `descripcion`, `tipo`, `id_usuario`) VALUES ('".$_POST['Sid_capitulo']."' ,'".$nombreImagen."','".$tipo."', '".$this->idUsuario."')";
          $this->QuerySql($sql);
        }
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
        $res = $this->Consulta('SELECT `id_cursos`,`id_capitulo`, `nombre`, `descripcion` FROM '.$this->Table ." WHERE id_capitulo = ".$this->_datos);
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
        $sql = 'SELECT t.`nombre`,c.nombre as curso,t.`fecharegistro`,'.$editar.','.$eliminar.' FROM '.$this->Table.' t
        INNER JOIN cursos c on t.id_cursos = c.id_cursos 
          WHERE t.activo = 1';
        
        $datos = $this->Consulta($sql,1); 
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
                                <strong>Atención</strong>
                                No se encontraron registros.
                            </div>
                          </div>';
        }
 
        if($this->_datos=='r')  echo $tablaHtml;
        else    return $tablaHtml;
        
    }   
}
?>