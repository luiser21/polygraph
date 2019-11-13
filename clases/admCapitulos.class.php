<?php
class Index extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR CAPITULOS';
    public $_subTitulo = 'Agrega un Capitulo';
    public $_datos = '';
    public $Table = 'capitulos';
    public $PrimaryKey = 'id_capitulo';
    

    /**
     * Index::Iniciar()
     * @return
     */
    function Iniciar(){
        $this->ckEditor = 'descripcionC';
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
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
        $sql = 'SELECT id_cursos codigo, nombre as descripcion from cursos WHERE activo = 1';
        $cursos = $this->Consulta($sql);
        
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Capitulos</li>
                    </ol>
                </div>
            </div>

            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">Crear Capitulo</h3>
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
                                        '.$this->crearSelect('id_cursos','id_cursos',$cursos,false,false,false,'class="form-control"').'
                                        
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="nombre">Capitulo:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required="required" placeholder="Para el curso nuevo">
                                        <input type="hidden" id="id_capitulo" name="id_capitulo" value="0">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="descripcion">Video del capitulo:</label>
                                        <textarea rows="4" class="form-control"  cols="50" placeholder="agrege el codigo para ingresar el video" id="video" name="video"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="descripcion">Desripcion del capitulo :</label>
                                        <textarea name="descripcionC" id="descripcionC" rows="10" cols="80"></textarea>
                                        <input type="hidden" name="descripcionCapitulo" id="descripcionCapitulo" />
                                    </div>

                                    <button type="button" id="guardarCapitulo" class="btn btn-primary">Guardar Curso</button>
                                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                                </form>


                            </div>
                        </div>
                    </div> '.$this->tablaDatos().'
                    
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
       if(!$this->_datos['id_capitulo']){ 
        $sql = "INSERT INTO `".$this->Table."` (`id_cursos`, `nombre`, `video`, `descripcionCapitulo`,`id_usuario`) 
                VALUES 
                ('".$this->_datos['id_cursos']."', '".$this->_datos['nombre']."', '".addslashes( $this->_datos['video'] )."', '".addslashes( $this->_datos['descripcioncapitulo'] )."','".$this->idUsuario."')";
        
            $this->QuerySql($sql);
       }else{
           $sql = 'UPDATE '.$this->Table ." SET nombre = '".$this->_datos['nombre']."', video = '".addslashes( $this->_datos['video'] )."', descripcionCapitulo = '".addslashes( $this->_datos['descripcioncapitulo'] )."',`id_usuario` = '".$this->idUsuario."' WHERE ".$this->PrimaryKey." = ".$this->_datos['id_capitulo'];
            $this->QuerySql($sql); 
       }
       
        
        echo '<div class="alert alert-success alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                Datos guardados con &eacute;xito 
        </div>';        
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
        $res = $this->Consulta('SELECT `id_cursos`,`id_capitulo`, `nombre`, `video`,  `descripcionCapitulo` FROM '.$this->Table ." WHERE id_capitulo = ".$this->_datos);
        $result = array_map( "stripslashes" , $res[0] );
        print_r( json_encode( $result ) );
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