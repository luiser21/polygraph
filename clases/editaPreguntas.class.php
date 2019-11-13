<?php
class Index extends crearHtml{
    
    public $_titulo = 'EDITAR PREGUNTAS';
    public $_subTitulo = 'Editar Preguntas';
    public $_datos = '';
    public $Table = 'evaluacion';
    public $PrimaryKey = 'id_evaluacion';
    
    
    
    /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
            
            $sql = 'SELECT id_evaluacion codigo, nombre as descripcion FROM evaluacion WHERE activo = 1';
            $arrEvaluacion = $this->Consulta($sql);
                         
        $html =  '<section class="main-content-wrapper">
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
            
            <div class="col-md-8 pagina">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">EDITAR PREGUNTAS DE UNA EVALUACI&Oacute;N</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formEditaCurso" role="form">
                                   <div class="form-group">
                                        <label for="id_cursos">Evaluacion:</label>
                                        '.
                                        $this->crearSelect('id_evaluacion','id_evaluacion',$arrEvaluacion,false,false,false,'class="form-control evaluacionPregunta"').'
                                    </div>
                                   
                                    <div class="form-group getPregunta">
                                        <label for="nombre">Pregunta:</label>
                                        
                                    </div>
                                    
                                                                 
                                    <button type="button" id="btnVerEditarPreguntas" class="btn btn-primary" data-toggle="modal" data-target="#verRespuestas">Editar Pregunta</button>
                                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                                    '.$this->verEditarPreguntas().'
                                </form>
                            </div>
                        </div>
                    </div> 
                    
                        </div>
                    </div>
                </div>                    

        </section>  ';
        //$html .= 
        return $html;    
        //'.$this->tablaDatos().'
    }
    /**
     * Index::getPreguntas()
     *  Trae lista desplegable con las preguntas segun su evaluacion
     * @return
     */
    public function getPreguntas(){
        $sql = "SELECT `id_preguntas` codigo , `descripcion`  FROM `preguntas` WHERE `id_evaluacion` = '".$this->_datos['id_evaluacion']."'";
        $arrPreguntas = $this->Consulta($sql);
        echo $this->crearSelect('id_pregunta','id_pregunta',$arrPreguntas,false,false,false,'class="form-control"');
    }
        
    /**
     * Index::guardarDatos()
     *  
     * @return
     */
    function guardarDatos(){
        $query = "DELETE FROM `respuestas_preguntas` WHERE id_preguntas = '".$this->_datos['id_pregunta'] ."'";
        $this->QuerySql($query);
        $i = 0;
        $correcta = '0';
        foreach($this->_datos['pregunta'] as $pregunta=>$val){
            $correcta = ($i==$this->_datos['respuesta']) ? '1': '0';
            $i++;
            $sql = "INSERT INTO `respuestas_preguntas`(`id_preguntas`, `descripcion`, `correcta`,  `id_usuario` ) 
                            VALUES ('".$this->_datos['id_pregunta']."' , '".$pregunta."' , '".$correcta."' , '".$this->idUsuario."')";
            $this->QuerySql($sql);
        }
        echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con &eacute;xito  <a href="editaPreguntas.php">Seguir editando</a></div>';                        
    }
    
    function verEditarPreguntas(){
         $html = '<div class="modal fade" id="verRespuestas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="myModalLabel">Alerta</h4>
                             </div>
                             <div class="modal-body" id="getRespuestas">
                                
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                 <button class="btn btn-primary" id="guardaPreguntaEdit" type="button">Guardar Cambios</button>
                             </div>
                         </div>
                     </div>
                 </div>';
                 
                 return $html;
    }
    
    public function getRespuestas(){
        //imprimir($this->_datos);
        if(isset( $this->_datos['id_pregunta'] ) && !empty( $this->_datos['id_pregunta'] ) ){
            $sql = "SELECT `id_respuestas_preguntas`, `id_preguntas`, `descripcion`, `correcta`
                    FROM `respuestas_preguntas` 
                    WHERE `activo` = 1 
                    AND `id_preguntas`= ".$this->_datos['id_pregunta'];
            $arrRespuestas = $this->Consulta($sql);

            
        $html ='<div class="form-group">
                    <label for="descripcion">Respuestas para esta pregunta:</label> 
                    <p class="help-block">Respuestas para esta pregunta e indique cual es la correcta.</p>
                    <hr>
                    <div id="items_respuestas">
                    ';
                    $ch = '';
                    $j=1;
                    $f=0;
                    foreach($arrRespuestas as $respuestas){
                        $ch = ($respuestas['correcta'] == 1) ? 'checked="checked"' : ''; 
                        $html .='<div class="respuesta">
                                <label for="descripcion">Respuesta <span class="num">'.$j.'</span> </label> <label class="radio-inline">
                                <input type="radio" '.$ch.' id="respuesta" name="respuesta" value="'.$f.'"> Correcta </label>
                                '.$this->create_input('text','pregunta','pregunta','Pregunta para el bloque',$respuestas['descripcion'],'form-control').' <li id="Clonar" class="fa fa-plus-circle pull-right" style="cursor:pointer" title="Agregar"> </li> <li id="Eliminar" style="cursor:pointer" class="fa fa-minus-circle pull-right" title="Eliminar"> </li>
                            </div>';
                            $j++;
                            $f++;                
                    }
        
        
         $html.='<div>
                </div>';                
         echo $html;   
            
            
            
        }else{
            echo 'Debes elegir una pregunta';
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
        $res = $this->Consulta('SELECT `nombre`, `descripcion` FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
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