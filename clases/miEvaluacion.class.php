<?php
class Index extends crearHtml{
    
    public $_titulo = '';
    public $_subTitulo = 'Proceso de certicaci&oacute;n.';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';
    public $idEvaluacion = '';
    public $idCurso = '';
    public $evaluacionAsignada = true;

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

            if( isset( $_SESSION['id_usuario'] ) && isset($this->idCurso) && !empty( $this->idCurso ) ){
                $html .= '<form name="formMiEvaluacion" id="formMiEvaluacion" action="evaluando.php" method="POST">';
                $html .= $this->panel1();
                $html .= '</form>';
                $html .= '<form name="formSubeEvaluacion" id="formSubeEvaluacion" method="POST" enctype="multipart/form-data">';
                $html .= $this->panel2();    
                $html .= '</form>';
            }
            else{
                $html .= '<div class="alert alert-danger fade in">
                        <h4>Atenci&oacute;n!</h4>
                        <p>Sin informaci&oacute;n para validar .</p>
                    </div>';
            }
        $html .=' </section>';
        
        return $html;
            
    }
    
    function Iniciar(){
         $this->_file  = $_SERVER['PHP_SELF'];
         if( isset($_POST['idCurso']) ){
            $this->idCurso = $_POST['idCurso'];
            $this->getInfoEvaluacion();
         }
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
        $sql            = 'SELECT E.`id_evaluacion`, C.nombre FROM `evaluacion` E INNER JOIN cursos C ON C.id_cursos = E.`id_cursos` AND E.`id_cursos` = ' . $this->idCurso . ' AND E.activo =1';
        $datos          = $this->Consulta($sql);
        if(count($datos) > 0){
            $this->_titulo  = $datos[0]['nombre'] . ' / Evaluacion ';
            $this->idEvaluacion = $datos[0]['id_evaluacion'];    
        }
        else{
            $this->evaluacionAsignada = false;
        }
                
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
                    <div class="panel-body">';
        if($this->evaluacionAsignada){

                                $e = $this->verificaEvaluacion();
                                if(!$e[0]){
                                    $html .= $e[1];
                                }
                                else{
                                    if( !empty($e[1]) )
                                        $html .= $e[1];
                                        
           $html .=               '&iquest;ESTAS PREPARADO?<br>
                                    Cuentas con 30 m&iacute;nutos para solucionar 30 preguntas, recuerda que para
    aprobar esta evaluaci&oacute;n, necesitar&aacute;s una calificaci&oacute;n arriba de 8 (Ocho). Si
    no apruebas, puedes volver a intentarlo el d&iacute;a siguiente.
                                </div>
                                <div style="width:100%; text-align: center;">
                                '.$this->create_input('hidden','mi_evaluacion','mi_evaluacion',false,$this->idEvaluacion).'
                                '.$this->create_input('hidden','mic','mic',false,$this->idCurso).'
                                
                                <span class="btn btn-success" id="irIniciar">INICIAR</span>
                                    
                                </div>';
                                }

          }else{
            $html .= '<div class="alert alert-danger fade in">
                        <h4>Atenci&oacute;n!</h4>
                        <p>No se ha asignado ninguna evaluaci&oacute;n para este curso.</p>
                    </div>';
          }
           $html .=      '   </div>
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
        $t = $this->verificaTrabajos();
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
                            <div class="panel-body" id="ResultadoTrabajo">';
                            if(!$t[0]){
                                $html .= '<div class="alert alert-success alert-dismissable">
                                            <h4>Atenci&oacute;n!</h4>
                                            <p>'.$t[1].'</p>
                                         </div>';
                            }else{
                                if( !empty($t[1]) ){
                                    $html .= '<div class="alert alert-danger fade in">
                                                    <h4>Atenci&oacute;n!</h4>
                                                    <p>'.$t[1].'</p>
                                              </div>';
                                }
                            $html .= 'Env&iacute;anos tu proyecto comprimido en .zip. Para esto debes compartirnos el url para que lo descarguemos, 
                            puedes hacerlo usando Google Drive, MEGA o Dropbox.
Si ya tienes el URL de tu proyecto c&oacute;pialo y p&eacute;galo a continuaci&oacute;n:
.<hr>

                            <h1>URL Proyecto</h1>
                            '.$this->create_input( 'textarea', 'enlace_tarea', 'enlace_tarea', 'Escriba el enlace donde se podra descargar o ver su trabajo realizado para esta evaluacion' ).'
                            '.$this->create_input('hidden','idCursoEnlace','idCursoEnlace',false,$this->idCurso).'
                            <div style="padding:20px 20px 20px 20px;">
                                <span class="btn btn-success" id="subirEnlace">Enviar</span>
                            </div>
                            </div>';
                            }
              $html.='</div>
                    </div>
                    </div>';
        
        return $html;
        
        /**
         * Opcion de subir archivo se inabilito se deha codigo realizado
         
         $this->create_input('file','trabajo','trabajo','Archivo del trabajo').'
                            <div style="padding:20px 20px 20px 20px;">
                                <span class="btn btn-success" id="subirTrabajo">Enviar</span>
                            </div>
        */
    } 

    /**
     * Index::verificaEvaluacion()
     * Verifica el estado en el que se encuentra la evaluaci&oacute;n presentada por el usuario
     * @return
     */    
    function verificaEvaluacion(){
        $sql = 'SELECT estado,intentos FROM mis_cursos WHERE id = '.$_REQUEST['idCurso'];
        $res = $this->Consulta($sql);
        $pasa = 1;
        $mensaje = '';
        if( is_array($res) && count($res) ){
            if( $res[0]['estado'] ==1 ){
                $pasa = 0;
                $mensaje = '<div class="alert alert-success alert-dismissable">
                                                    <h4>Atenci&oacute;n!</h4>
                                                    <p>Esta evaluaci&oacute;n ya fue aprobada, en la pagina de "Mi Cuenta" podr&aacute;s descargar tus certificados</p>
                                              </div>';
            }
            elseif($res[0]['estado'] ==2 ){
                $pasa = 1;
                $mensaje =' <div class="alert alert-warning alert-dismissable">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                                Esta evaluaci&oacute;n no ha sido superada en '.$res[0]['intentos'].' oportunidades 
                            </div>';
            }
        }
        return array($pasa,$mensaje);
    }    
    
    /**
     * Index::verificaTrabajos()
     * Verifica si el usuario ya cargo un trabajo y si esta calificado
     * @return
     */
    function verificaTrabajos(){
        
        $sql = 'SELECT `calificacion` FROM `trabajos_cargados` WHERE `id_usuario` = '.$_SESSION['id_usuario'] . ' AND id_curso = '.$this->idCurso;
        $res = $this->Consulta($sql);
        $mensaje = '';
        $pasa = 1;
        if( is_array($res) && count($res) ){
            if( $res[0]['calificacion'] ===null ){
                $pasa = 0;
                $mensaje = 'El trabajo enviado a&uacute;n no ha sido calificado';
            }
            elseif( !$res[0]['calificacion'] ){
                $mensaje = 'El trabajo no fue aprobado, vuelve a intentarlo';
                $pasa = 1;
            }
            else{
                $mensaje = 'Felicitaciones, tu trabajo ha sido calificado y aceptado por DNA';
                $pasa = 0;
            }            
        }
        return array($pasa,$mensaje);
    }
       
    /**
     * Index::subirEvaluacion()
     * Sube archivo del trabajo y llama a funcion que guarda el registro de la informaci&oacute;n.
     * @return
     */
    function subirEvaluacion(){
        try{
            $rutaArchivo = $this->subirArchivos('trabajo','./trabajos/');

        $this->guardarRegistro($rutaArchivo);
        
        echo '<div class="alert alert-success alert-dismissable">
        <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
        Trabajo cargado con exito, ahora debemos esperar la calificacion del profesor encargado</div>';
        }catch(Exception $e){
            echo $e->getMessage();
        }  
    }

    /**
     * Index::guardarRegistro()
     * Organiza los datos para guardar el registro de carga cuando es un enlace
     * @return
     */    
    function guardarEnlace(){
        $this->idCurso =  $this->_datos['idcursoenlace'];
        $r = $this->_datos['enlace_tarea'];
        $this->guardarRegistro($r);
        echo '<div class="alert alert-success alert-dismissable">
        <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
        Trabajo enviado con &eacute;xito, ahora debemos esperar la calificacion del profesor encargado</div>';
    }
/*
Envíanos tu proyecto comprimido en .zip. Para esto debes compartirnos el url para que lo descarguemos, puedes hacerlo usando Google Drive, MEGA o Dropbox.
Si ya tienes el URL de tu proyecto c&oacute;pialo y p&eacute;galo a continuaci&oacute;n:
*/
    
    /**
     * Index::guardarRegistro()
     * Guarda la ruta del trabajo cargado por el usuario, bien sea en el servidor o de una plataforma separada.
     * @return
     */    
    function guardarRegistro($r=false){
        $ruta = $r;
        $sql = "INSERT INTO `trabajos_cargados` 
        (`id_usuario`, `ruta_trabajo`, `id_curso`, `fecha_carga`) 
        VALUES
        ('".$_SESSION['id_usuario']."', '".$ruta."','".$this->idCurso."', NOW() )";
        $this->QuerySql($sql);
        $this->enviaNotificacion();
    }
    
    
    /**
     * Index::enviaNotificacion()
     * Envia corre de notificación al profesor sobre el trabajo.
     * @return
     */
    function enviaNotificacion(){
        $res = $this->getCorreo();
        $this->to = $res[0]['email'];
        $this->NombreCorreo = $res[0]['Nombre'];
        $this->mensajeCorreo = 'Se ha cargado un nuevo trabajo en la plataforma DNA, no olvide revisarlo';
        $this->sendMail();
    }
    
    /**
     * Index::getCorreo()
     * Obtiene correo de envio
     * @return
     */    
    function getCorreo(){
        $sql = "SELECT U.email , concat(U.nombres, ' ' ,U.apellidos) as Nombre
                FROM `profesores_cursos` PC 
                INNER JOIN usuarios U ON U.id_usuario = PC.`id_profesor`
                WHERE `id_cursos` = " . $this->idCurso ;
        $datos = $this->Consulta($sql); 
        return $datos;               
    }
    /**
     * Index::_mostrar()
     * 
     * @return
     */
    function _mostrar(){
        $html = $this->Cabecera();
        $html .= $this->contenido();
        $html .= $this->Pata();
        echo $html;
    }
    
}
?>