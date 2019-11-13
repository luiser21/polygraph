<?php
class Index extends crearHtml{
    
    public $_titulo = 'Evaluando';
    public $_subTitulo = 'Proceso de certificacion.';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';

   /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
        $html =  '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Mis Cursos -> Evaluaci&oacute;n</li>
                    </ol>
                </div>
            </div>';
            $html .= '<form id="formCalificacion">';
            $html .= $this->evaluacion();
            $html .= '</form>';
        $html .=' </section>';
        
        return $html;
            
    }
    
    
    /**
     * Index::panel1()
     * 
     * @return
     */    
    function evaluacion(){
        $html = '';
        
        $miEvaluacion = ( isset( $_POST['mi_evaluacion'] ) ) ? $_POST['mi_evaluacion'] : 0;
        
        $sql = "SELECT p.id_preguntas,p.descripcion pregunta, rp.descripcion respuesta, rp.correcta ,rp.id_respuestas_preguntas
                FROM evaluaciones_cursos ec 
                INNER JOIN preguntas p ON p.id_evaluacion = ec.id_evaluacion and ec.id_evaluacion = '".$miEvaluacion."' 
                INNER JOIN respuestas_preguntas rp ON rp.id_preguntas = p.id_preguntas";
        $preguntas = $this->Consulta($sql);
        if( count($preguntas) ){
            foreach($preguntas as $p){
                $arrPreguntas[$p['id_preguntas']] = $p['pregunta'];
            }
           
            $html .= '
                    <div class="row" id="Resultado">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title panelPregunta"><h1> Pregunta <span class="pregActual">1</span>/'.count($arrPreguntas).' </h1></h3>
                                    <div class="actions pull-right">
                                        <i class="fa fa-expand"></i>
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>
    
                            <div class="panel-body">
                                    ' . $this->create_input('hidden','mic','mic',false, $_POST['mic']) . '
                                    
                                    <div class="btn btn-success terminar" id="terminar" style="display:none">TERMINAR</div>
                               
                            </div>
                     ';
                      
                   $j=0;//$this->create_input('hidden','id_pegunta','id_pegunta',false,$k).
            foreach($arrPreguntas  as $k=>$arr){
                $s = ($j) ? 'style="display:none"' : '';
                $html.= '<div class="pregunta" '.$s.' id="preg'.$k.'">
                <div class="panel-body">
                
                                <div>
                                    '.$arr.'
                                </div>';
                          foreach($preguntas as $pre){
                                if($pre['id_preguntas']==$k )
                                    $html .= '<div id="preg'.$k.'">
                                                <div class="radio">
                                                    '.$this->create_input('radio','respuesta_'.$k,$pre['id_respuestas_preguntas'],false,$pre['id_respuestas_preguntas'],'icheck').'
                                                    <label for="'.$pre['id_respuestas_preguntas'].'">'.$pre['respuesta'].'</label>
                                                </div>
                                             </div>';                                   
                          }
                $html.=         '
                                </div>
                                <div class="panel-footer" style="text-align: right;">
                                    <div class="btn btn-danger" style="float:left margin:10px; margin:10px;">CANCELAR</div><div class="btn btn-success siguiente" style="margin:10px; margin:10px;">SIGUIENTE</div>
                                </div>
                           </div>
                        ';
            $j++;
            }
        }
        
        else{
          $html .= '<div class="alert alert-danger fade in">
                        <h4>Atenci&oacute;n!</h4>
                        <p>No se ha asignado ninguna evaluaci&oacute;n para este curso.</p>
                    </div>';
        }
        return $html;
        
        
    }
    
    
    /**
    * Index::guardarRespuestas()
    * 
    * @return
    */
    function guardarRespuestas(){
        $this->titulo = 'EVALUACI&Oacute;N DE CONOCIMIENTOS'; 
        $id_respuestas = array();
        
        foreach($this->_datos as $k=>$v){
            if($k !='mic')
                $id_respuestas[] = $v;
        }
        //mic
        $sql = "SELECT id_respuestas_preguntas FROM respuestas_preguntas WHERE id_respuestas_preguntas IN(".implode(',',$id_respuestas).") AND `correcta` = 1 ";
        $respuestas = $this->Consulta($sql);
        $cRespuestas = count( $respuestas );
        $cPreguntas =  ( count( $this->_datos )-1 );
        $resultado = round( ( ( 100/$cPreguntas )*$cRespuestas ) );
        
        $mensaje = $cRespuestas.'/'.$cPreguntas;
        $aprobado = false;
        if($resultado >79){
            $aprobado = true; 
            $this->_subTitulo = 'APROBADO'; 
        }else{        
            $this->_subTitulo = 'No APROBADO';
        }
        
        $this->actualizaResultado($this->_datos['mic'],$aprobado);
        
        $html = $this->resultadoEvaluacion($mensaje,$aprobado);
        echo $html;
    }
    /**
    * Index::actualizaResultado()
    * 
    * @return
    */  
    function actualizaResultado($mic,$aprobado){
        if(!$aprobado){
            $sql = 'UPDATE mis_cursos SET intentos = (`intentos`+1), estado = 2 WHERE id = '.$this->_datos['mic'];    
        }else{
            $sql = "UPDATE mis_cursos SET estado = 1, fecha_aprobado = NOW(), codigoaprobado = '".strtoupper(dechex(time()))."' WHERE id = ".$this->_datos['mic'];
        }
        $this->QuerySql($sql);
         
    }
    
    /**
    * Index::resultadoEvaluacion()
    * 
    * @return
    */    
    function resultadoEvaluacion($mensaje,$aprobado){
        $html = '
        
        <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">RESULTADO</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                              <h1>'.$this->_subTitulo.'</h1>
                               <h1>'.$mensaje.'</h1>
                                ';
                            if(!$aprobado){
                                $html .='                            
                            <div class="btn btn-success" onclick="tryAgain();" style="margin:10px; margin:10px;">Intentar de nuevo</div>
                            ';
                            } else{
                             $html .= '<h1>Felicitaciones, Tu certificado ya est&aacute; disponible </h1>
                                        <div class="btn btn-success" onclick="miCuenta();" style="margin:10px; margin:10px;">Ir a mi cuenta</div> 
                                    ';
                            }
                            
         $html .= '
                            </div>
                        </div>
                    </div>
        ';
        return $html;
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
        //$html .= $this->tablaDatos();
        $html .= $this->Pata();
        echo $html;
    }
}
?>