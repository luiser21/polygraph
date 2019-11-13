<?php
class Index extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR EVALUACIONES';
    public $_subTitulo = 'Crear Una evaluacion';
    public $_datos = '';
    public $Table = 'evaluacion';
    public $PrimaryKey = 'id_evaluacion';
    
    
    
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
                        <li class="active">Administrar Evaluaciones</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">CREAR EVALUACI&Oacute;N</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCreaCurso" role="form">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Evaluaci&oacute;n:</label>
                                        '.
                                        
                                        $this->create_input('text','nombre','nombre','Nombre de la evaluaci&oacute;n',false,'form-control').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey).
                                        '
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">Curso:</label>
                                        '.$this->crearSelect('id_cursos','id_cursos',$cursos,false,false,false,'class="form-control"').'
                                        
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label for="descripcion">Desripcion de la evaluacion:</label>
                                        <textarea rows="4" class="form-control"  cols="50" id="descripcion" name="descripcion"></textarea>
                                    </div>                                  
                                    <button type="button" id="guardarCurso" class="btn btn-primary">Guardar Curso</button>
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
    
    function guardarDatos(){
        
       if( isset( $this->_datos[$this->PrimaryKey]) ){ 
        $sql = "INSERT INTO `".$this->Table."` (`id_cursos`, `nombre`, `descripcion`, `id_usuario`) 
                VALUES 
                ('".$this->_datos['id_cursos']."','".$this->_datos['nombre']."','".$this->_datos['descripcion']."','".$this->idUsuario."')";
        
            $this->QuerySql($sql);
       }else{
           $sql = 'UPDATE '.$this->Table ." SET `id_cursos` = '".$this->_datos['id_cursos']."' ,nombre = '".$this->_datos['nombre']."', descripcion = '".$this->_datos['descripcion']."' WHERE ".$this->PrimaryKey." = ".$this->_datos['id_capitulo'];
            $this->QuerySql($sql); 
       }
       
            
            echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con éxito </div>';        
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        $sql = 'UPDATE '.$this->Table .' SET activo = 0 WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $this->QuerySql($sql);
        //$_respuesta = array('Codigo' => 1, "Mensaje" => 'Se ha eliminado el item con éxito');
        echo 'Se ha eliminado el item con éxito';
    }
    
    function fn_editar(){
        
    }
    
    function getDatos(){
        $res = $this->Consulta('SELECT `nombre`, `descripcion`, `id_cursos`FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    function _mostrar(){
      /**  $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');*/
        $html = $this->Cabecera();
        $html .= $this->contenido();
      //  $html .= $this->tablaDatos();
        $html .= $this->Pata();
        echo $html;
    }
    
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = 'SELECT t.`nombre`,t.`fecharegistro`,'.$editar.','.$eliminar.' FROM '.$this->Table.' t
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