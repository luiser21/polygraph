<?php
class Index extends crearHtml{
    
    public $_titulo = '';
    public $_subTitulo = 'Proceso de certicaci&oacute;n.';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';
    public $idEvaluacion = '';
    public $idCurso = '';

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
                        <li class="active">Cursos y Eventos</li>
                    </ol>
                </div>
            </div>';
            $html .= '<form name="formMiEvaluacion" id="formMiEvaluacion" action="evaluando.php" method="POST">';
            $html .= $this->panel1();
            $html .= $this->panel2();
            $html .= '</form>';
        $html .=' </section>';
        
        return $html;
            
    }
    
    function Iniciar(){
         $this->_file  = $_SERVER['PHP_SELF'];
         if( isset($_POST['idCurso']) ){
            $this->idCurso = $_POST['idCurso'];
            $this->getInfoEvaluacion();
         }
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
    
    function getInfoEvaluacion(){
        $sql            = 'SELECT E.`id_evaluacion`, C.nombre FROM `evaluacion` E INNER JOIN cursos C ON C.id_cursos = E.`id_cursos` AND E.`id_cursos` = '.$this->idCurso;
        $datos          = $this->Consulta($sql);
        $this->_titulo  = $datos[0]['nombre'] . ' / Evaluacion ';
        $this->idEvaluacion = $datos[0]['id_evaluacion'];        
    }
    /**
     * Index::panel1()
     * 
     * @return
     */    
    function panel1(){
        $html = '';
        
        
        $html .= '<div class="col-md-8">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">EVALUACI&Oacute;N DE CONOCIMIENTOS</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                &iquest;ESTAS PREPARADO?<br>
                                Cuentas con 30 m&iacute;nutos para solucionar 30 preguntas, recuerda que para
aprobar esta evaluaci&oacute;n, necesitar&aacute;s una calificaci&oacute;n arriba de 8 (Ocho). Si
no apruebas, puedes volver a intentarlo el d&iacute;a siguiente.
                            </div>
                            <div style="width:100%; text-align: center;">
                            '.$this->create_input('hidden','mi_evaluacion','mi_evaluacion',false,$this->idEvaluacion).'
                            '.$this->create_input('hidden','mic','mic',false,$_REQUEST['mic']).'
                            
                            <span class="btn btn-success" id="irIniciar">INICIAR</span>
                                
                            </div>
                        </div>
                    </div>
                    </div>   ';
          
        
        return $html;
    }
    
    /**
     * Index::panel2()
     * 
     * @return
     */    
    function panel2(){
        $sql = 'SELECT CU.nombre,CU.img,CU.id_cursos,MC.estado FROM mis_cursos MC 
                INNER JOIN cursos CU ON CU.id_cursos = MC.id_cursos
                INNER JOIN compras C ON C.id_compras = MC.idcompra 
                INNER JOIN factura F ON F.id_factura = C.id_factura AND F.id_usuario = 1';
        $cursos = $this->Consulta($sql);
        
        $html = '';
        
        
        $html .= '<div class="col-md-4">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">EVALUACI&Oacute;N DE TRABAJO    </h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                Adjunta tus archivos comprimidos en .zip o .rar (1 solo
paquete). recuerda que no deben pesar m&aacute;s de 20MB y
debes disponer del tiempo de crga suficiente para que estos
logren subir satisfactoriamente. tambien puedes subirlo a
GoogleDrive, MEGA o Dropbox y compartirnos el enlace.<hr>
<h1>Opcion 1</h1>
'.$this->create_input('file','tarea','tarea','Archivo del trabajo').'
                            <span class="btn btn-success" id="irIniciar">Enviar</span>
                            <hr>
                            <h1>Opcion 2</h1>
                            '.$this->create_input( 'textarea', 'ennlace_tarea', 'enlace_tarea', 'Escriba el enlace donde se podra descargar o ver su trabajo realizado para esta evaluacion' ).'
                                
                            </div>
                        </div>
                    </div>
                    </div>   ';
        
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