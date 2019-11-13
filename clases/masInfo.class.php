<?php
class Index extends crearHtml{
    
    public $_titulo = 'Curso';
    public $_subTitulo = 'Informaci&oacute;n sobre el curso';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';
    public $idCurso;
    public $infoCurso = array(); 
    
    public $isEvento = false; 
    public $caduca = false;
    public $countDown = false; 
    public $trabajoCargados = false;
    public $evaluacionPresentada = false;
    public $calificacion = false;
    
    
   /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
        $this->idCurso = $_GET['idc'];
        $this->getInfoCurso();
        $this->_subTitulo = $this->infoCurso[0]['nombre'];
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
            
            $html .= $this->informacion();
            $html .= $this->listaClases();
            
            $html .= $this->validaSesionCompra();

        $html .=' </section>';
        
        return $html;
            
    }
    
    /**
     * Index::panel1()
     * Valida si el usuario esta logueado,
     * Valida en caso de estar logueado que el usuario all&aacute; comprado o no el curso
     * @return
     */    
    function validaSesionCompra(){
        $html = '';
            if( !isset( $_SESSION["id_usuario"] ) )
                $html = $this->seccionPago();
            else{
                $html = ( $this->verificaCursoComprado() ) ? $this->informacionEstado() : $this->seccionPago();
            }
        return $html;
    }
    
    function getInfoCurso(){
        $sql = 'SELECT `id_cursos`, `nombre`, `descripcion`,`img`, `img_banner`, `precio`,`tipo` FROM cursos WHERE activo = 1 AND id_cursos = '.$this->idCurso;
        $this->infoCurso = $this->Consulta($sql);
        $this->validaTipo();
    }
    
    /**
     * Index::validaTipo()
     * Valida si es evento o curso
     * @return
     */
    function validaTipo(){
        if( isset( $this->infoCurso[0]['tipo'] ) && $this->infoCurso[0]['tipo'] == 2 ){
            $this->isEvento = true;
        }
    }
    
    /**
     * Index::panel1()
     * muestra la descripcion del curso
     * @return
     */    
    function informacion(){
        if(!$this->idCurso){
            die('No se encontro ningun curso selecciona, es imposible continuar');
        }
        
        
        $html = '';
        $html .= '<div class="col-md-12" style="margin:0px 0px 20px 0px;">';
        $html .= '<img src="'.$this->infoCurso[0]['img_banner'].'" class="img-responsive" >';    
        $html .= '</div>';
        $html .= '<div class="col-md-4">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">DESCRIPCI&Oacute;N</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                            ' . $this->infoCurso[0]['descripcion'] . '
                            </div>
                            
                        </div>
                    </div>
                    </div>';
        return $html;
    }
    
    function listaClases(){
        
        $sql = 'SELECT nombre,id_cursos,id_capitulo FROM capitulos WHERE id_cursos = '.$this->idCurso;
        $clases = $this->Consulta($sql);
        $html = '';
        
        $html .= '<div class="col-md-4">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Clases</h3>
                                        <div class="actions pull-right">
                                            <i class="fa fa-expand"></i>
                                            <i class="fa fa-chevron-down"></i>
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </div>
                                    <div class="panel-body">';
                                    $a = '#';
                                   // '<span class="btn btn-info" data-toggle="modal" data-target="#ventanaModal">COMPRAR</span>'
                                    foreach($clases as $c){
                                        $a = ( isset($_SESSION['id_usuario']) && ($this->getCursosComprados()===true  || $_SESSION['tipo_usuario'] == 2) ) ? 'href="forum.php?id='.$c['id_capitulo'].'"' : 'href="#" data-toggle="modal" data-target="#sinAcceso"';
                                        $html .= '<h2><a '.$a.'>'.$c['nombre'].'</a></h2><hr>';
                                    }
        $html.='                   </div>
                                    
                                </div>
                            </div>
                            </div>   ';
        $html .= $this->alertCapitulo();
        return $html;     
    }
    
    /**
     * Index::getCursosComprados()
     * Trae los cursos comprados del id usuario para mantenerlo en session
     * @return
     */
    function getCursosComprados(){
        $sql = "SELECT CU.id_cursos 
                FROM mis_cursos MC INNER JOIN cursos CU ON CU.id_cursos = MC.id_cursos AND MC.id_cursos = '".$this->idCurso."'
                INNER JOIN compras C ON C.id_compras = MC.idcompra 
                INNER JOIN factura F ON F.id_factura = C.id_factura AND F.id_usuario = '".$_SESSION['id_usuario']."'";
        $datos = $this->Consulta($sql);
        $id = array();                
        if( count($datos) ){
         return true;
        }
        else    return false;
    }    
    
    public function alertCapitulo(){
        $html = '<div class="modal fade" id="sinAcceso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="myModalLabel">Alerta</h4>
                             </div>
                             <div class="modal-body">
                                 <p>Para que puedas acceder a esta informaci&oacute;n debes iniciar sesion o comprar este curso</p>
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                             </div>
                         </div>
                     </div>
                 </div>';
                 
                 return $html;
    }
    
    /**
     * Index::seccionPago()
     * Crea las ventanas modal que se usaran seg&uacute;n sea el caso
     * @return
     */     
    public function ventanaModal(){
        if( isset( $_SESSION['id_usuario'] ) && !empty( $_SESSION['id_usuario'] ) ){
            
            $html = '<div class="modal fade" id="ventanaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Realizar Compra</span></h4>
                    </div>
                    <div class="modal-body">
                        <form id="formCalifica" role="form">
                            <div id="divCalificacion">
                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="comprarIr">Comprar e ir al carro</button>    
                                    <a href="record.php"><button type="button" class="btn btn-info" id="comprarContinuar">Comprar y continuar navegando</button></a>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>';

       $html .= '<div class="modal fade" id="ventanaObtener" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Agregar Curso</span></h4>
                    </div>
                    <div class="modal-body">
                        <form id="formCalifica" role="form">
                            <div id="divCalificacion">
                                <div class="form-group" id="divAlerta">
                                    <button type="button" class="btn btn-success" id="Obtener">Agregar a Mis Cursos</button>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>';        
        
        }else{
            $html = '<div class="modal fade" id="ventanaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Debes ingresar al sistema para poder acceder a todos nuestros beneficios</span></h4>
                    </div>
                    <div class="modal-body">
                        <form id="formCalifica" role="form">
                            <div id="divCalificacion">
                                <div class="form-group">
                                    <a href="login.php"><button type="button" class="btn btn-success" id="iniciarSesion">Iniciar sesion</button></a>    
                                    <a href="record.php"><button type="button" class="btn btn-info" id="iniciarSesion">Registrarme</button></a>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>';
        
        $html .= '<div class="modal fade" id="ventanaObtener" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Debes ingresar al sistema para poder acceder a este curso GRATUITO</span></h4>
                    </div>
                    <div class="modal-body">
                        <form id="formCalifica" role="form">
                            <div id="divCalificacion">
                                <div class="form-group">
                                    <a href="login.php"><button type="button" class="btn btn-success" id="iniciarSesion">Iniciar sesion</button></a>    
                                    <a href="record.php"><button type="button" class="btn btn-info" id="iniciarSesion">Registrarme</button></a>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>';        
    }
    return $html;
    }
    
    /**
     * Index::seccionPago()
     * Muestra la el precio del producto y da la opcion de compra
     * @return
     */    
    function seccionPago(){
        
        $html = '';
        $iniciarSesion = ($this->infoCurso[0]['precio'] == 0) ? '<span class="btn btn-info" data-toggle="modal" data-target="#ventanaObtener">OBTENER</span>' : '<span class="btn btn-info" data-toggle="modal" data-target="#ventanaModal">COMPRAR</span>'; 
        
        
        $html .= $this->ventanaModal();
        $html .= '<div class="col-md-4">
                            <div class="panel">
                                <div class="panel-heading" style="background:#590C7A">
                                    <h3 class="panel-title" style="color:#FFF">PRECIO CURSO</h3>
                                    <div class="actions pull-right">
                                        <i class="fa fa-expand"></i>
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>
                                 
                                <div class="panel-body" style="background:#590C7A"> 
                                    <form id="formEvaluacionCompra" action="compra.php" method="post">
                                        <h1 style="float:left; margin:10px; color:#FFF">$' . number_format( $this->infoCurso[0]['precio'] ) . '</h1>
                                        '.$this->create_input('hidden' , 'idCurso' , 'idCurso' , false ,  $this->idCurso).'
                                        '.$this->create_input('hidden' , 'nombreCurso' , 'nombreCurso' , false , $this->infoCurso[0]['nombre'] ) . '
                                        
                                        ' . $iniciarSesion . '
                                    </form>
                                </div>
                                <div>
                                <a href="http://www.payulatam.com/logos/pol.php?l=133&c=556a5f74442f1" target="_blank"><img src="http://www.payulatam.com/logos/logo.php?l=133&c=556a5f74442f1" alt="PayU Latam" border="0" /></a>
                                </div>
                                <div style="margin-top:10px; padding:10px 10px 10px 10px;">
                                    <h1> Qu&eacute; Recibir&aacute;s? </h1>
                                    <hr>
                                    <div class="panel-body">
                                        <div style="float:left"><img src="./assets/img/Folder-Movies-icon.png" /></div> <div class="col-md-8"><h2>Video Curso, paso a paso</h2> <br> Contenidos 100% online, Videos de alta calidad que puedes ver cuantas veces quieras a las horas que quieras</div>
                                    </div
                                    <hr>
                                    <div class="panel-body">
                                        <div style="float:left"><img src="./assets/img/key-icon.png" /></div> <div class="col-md-8"><h2>Acceso Ilimitado</h2> tus cursos son tuyos nunca expirar&aacute;n disponibles las 24 hrs del d&iacute;a sin rstricciones de ning&uacute;n tipo.</div>
                                    </div>
                                    <hr>
                                    <div class="panel-body">
                                        <div style="float:left"><img src="./assets/img/mobile-icon.png" /></div> <div class="col-md-8"><h2>Disponibilidad total</h2> puedes tomar tus cursos desde cualquier dispositivo telefono, tablet o computador incluso desde varios a la vez. </div>
                                    </div>
                                    <div class="panel-body">
                                        <div style="float:left"><img src="./assets/img/Business-Diploma-1-icon.png" /></div> <div class="col-md-8"><h2>Certificaci&oacute;n al terminar</h2> Cuando completes al 100% de tu curso el sistema te dar&aacute; acceso a tu certificaci&oacute;n para que la descargues e imprimas  </div>
                                    </div>                                    
                                
                                </div>
                                
                                </div>
                                
                            </div>
                        </div>
                        </div>   ';                                   
        return $html;
    }
    /**
     * Index::informacionEstado()
     * Verifica si el curso que esta observando ya lo compra para mostrar la opcion de estado (Index::informacionEstado), 
     * En caso contrario muestra la de compra (Index::seccionPago)
     * @return
     */    
    function verificaCursoComprado(){
        echo $sql = "SELECT 
                    mc.`id_cursos`,
                    f.fecharegistro,
                    CU.duracion,
                    DATE (DATE_ADD(f.fecharegistro, INTERVAL CU.duracion DAY)) vence,
                    DATEDIFF( DATE_ADD(f.fecharegistro, INTERVAL CU.duracion DAY),NOW() ) queda,
                    mc.estado EstadoEvaluacion,
                    TC.id_trabajos_cargados,
                    TC.calificacion
                FROM `mis_cursos` mc 
                    INNER JOIN compras c on c.id_compras = mc.idcompra 
                    INNER JOIN factura f on f.id_factura = c.id_factura AND f.id_usuario = '".$_SESSION["id_usuario"] ."' AND mc.`id_cursos` = '".$this->idCurso."'  
                    INNER JOIN cursos CU ON CU.id_cursos = mc.`id_cursos`
                    LEFT JOIN trabajos_cargados TC ON TC.id_curso = mc.id_cursos AND TC.id_usuario = '".$this->idUsuario."'";
                    //imprimir($sql);
        $datos = $this->Consulta($sql);
        if( count($datos) ){
            $this->caduca = $datos[0]['vence'];
            $this->countDown = $datos[0]['queda'];
            $this->evaluacionPresentada = $datos[0]['EstadoEvaluacion'];
            $this->trabajoCargados =  $datos[0]['id_trabajos_cargados'];
            $this->calificacion =  $datos[0]['calificacion'];
            
        }            
        return $datos;
         
    }
    
    /**
     * Index::informacionEstado()
     * Muesra el avance del curso, da la opcion de comenzar la evaluacion  y muestra el profesor encargado del area
     * @return
     */
    function informacionEstado(){
        
        if($this->isEvento) return  '';

        $avance = 0;
        
        if($this->evaluacionPresentada==1){
            $avance +=50;
        }
        if($this->trabajoCargados!=0 ){
            $avance +=50;
                if($this->calificacion===null or $this->calificacion==2){
                    $avance -=20;
                }            
        }


        if($avance < 100){
                
            $alertaAvance = '
            <form id="formEvaluacion" action="miEvaluacion.php" method="post">
                        '.$this->create_input('hidden','idCurso','idCurso',false,$this->idCurso).'
                        '.$this->create_input('hidden','mic','mic',false,@$_REQUEST['mic']).'
                        <div class="alert alert-warning alert-dismissable">
                            Tienes '.$this->countDown.' d&iacute;as para certificarte
                        </div>
                        <span class="btn btn-info" id="irEvaluacion">Realizar evaluaci&oacuten</span>
                        </form>
            
            ';
        }
        
        else{                
            $alertaAvance = '<div class="alert alert-success alert-dismissable">
                <h4>Te has certificado</h4> Recuerda ver tus diplomas en la secci&oacute;n "Mi Cuenta"
            </div>';
        }
        
        $html = '';
        $html .= '<div class="col-md-4">
                        <div class="panel">
                            <div class="panel-heading">
                            <h3 class="panel-title">ESTADO DEL CURSO</h3>
                            <div class="actions pull-right">
                            <i class="fa fa-expand"></i>
                            <i class="fa fa-chevron-down"></i>
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                        
                     <div class="panel-body"> 
                        <div class="progress">
                            <div style="width: '.$avance.'%" class="progress-bar progress-bar-success">'.$avance.'%</div>
                        </div>
                    
                        '.$alertaAvance.'
                     </div>
                     <div>
                     </div>
                     <div style="margin-top:10px; padding:10px 10px 10px 10px;">
                        <h1> &iexcl;IMPORTANTE! </h1>
                        <hr>
                        Semana tras semana iremos subiendo 1 nueva clase en cada curso.<br>
                        Los cursos ser&aacute;n totalmente gratuitos hasta que nuestra plataforma este totalmente a punto.<br>
                        Las personas inscritas en nuestra plataforma antes de pasar a modo pago, obtendr&aacute;n 50% de descuentos en el curso que desee hacer luego de la fecha mencionada.
                        La fecha de terminaci&oacute;n gratuita ser&aacute; publicada en nuestras redes sociales y en los portales DNA MUSIC
                     </div>
                        
                    </div>
                </div>
                  </div>';
                                   
        return $html;      
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