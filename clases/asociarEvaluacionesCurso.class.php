<?php
class Index extends crearHtml{
    
    public $_titulo = 'ASOCIAR EVALUACIONES';
    public $_subTitulo = 'Evaluaciones';
    public $_datos = '';
    public $Table = 'evaluaciones_cursos';
    public $PrimaryKey = 'id_evaluaciones_cursos';
    
    
    
    /**
     * Index::Iniciar()
     * 
     * @return
   
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
      */
    /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
            $sql = 'SELECT id_cursos codigo, nombre as descripcion FROM cursos WHERE activo = 1';
            $arrCursos = $this->Consulta($sql);
            
            $sql = 'SELECT id_evaluacion codigo, nombre as descripcion FROM evaluacion WHERE activo = 1';
            $arrEvaluacion = $this->Consulta($sql);
             
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Evaluaciones</li>
                    </ol>
                </div>
            </div>
            
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
                                        '.
                                        $this->crearSelect('id_cursos','id_cursos',$arrCursos,false,false,false,'class="form-control"').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey).
                                        '
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="descripcion">Evaluacion:</label>
                                        '.$this->crearSelect('id_evaluacion','id_evaluacion',$arrEvaluacion,false,false,false,'class="form-control"').'
                                    </div>                                  
                                    <button type="button" id="guardarCurso" class="btn btn-primary">Asociar</button>
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
        
       if( isset( $this->_datos[$this->PrimaryKey]) ){ 
        $sql = "INSERT INTO `".$this->Table."` (`id_cursos`, `id_evaluacion`) 
                VALUES 
                ('".$this->_datos['id_cursos']."','".$this->_datos['id_evaluacion']."')";
        
            $this->QuerySql($sql);
       }else{
           $sql = 'UPDATE '.$this->Table ." SET id_cursos = '".$this->_datos['id_cursos']."', id_evaluacion = '".$this->_datos['id_evaluacion']."' WHERE ".$this->PrimaryKey." = ".$this->_datos['id_capitulo'];
            $this->QuerySql($sql); 
       }
       
            
            echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con &eacute;xito </div>';        
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
        echo 'Se ha eliminado el item con éxito';
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
        $res = $this->Consulta('SELECT  `id_cursos`, `id_evaluacion` FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
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
        $sql = 'SELECT c.nombre Cursos , e.nombre Evaluacion,'.$editar.','.$eliminar.' 
                FROM `evaluaciones_cursos` as ec 
                INNER JOIN cursos c on c.id_cursos = ec.`id_cursos` AND c.activo = 1 
                INNER JOIN evaluacion e on e.id_evaluacion = ec.`id_evaluacion` AND e.activo = 1 
                WHERE ec.activo = 1';
        
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