<script>
function fn_responder(id){
	$('#h_respuesta').val(id);
	$("#d_pregunta").html($('#h_mensaje'+id).val());
	$("#texto_pregunta").focus();
}
</script>
<?php
class Index extends crearHtml{
    
    public $_titulo = '';
    public $_subTitulo = 'EMPRESAS';
    public $_datos = '';
    public $Table2 = 'dna_foro_detalle';
    public $isEvento = false;
    public $idCurso; 

	
    public $PrimaryKey = 'id_empresas';
    public $id_foro = false;
	
    
    /**
     * Index::Iniciar()
     * 
     * @return
     */
    function Iniciar(){
        
        if( isset($_GET['id']) )
            $this->id_foro = $_GET['id'];
             
         if( isset($_SESSION['id_usuario']) ){
            $this->idUsuario = $_SESSION['id_usuario'];
            $this->NombreUsuario = $_SESSION['nombre'];
         }         
        
         $this->_file  = $_SERVER['PHP_SELF'];
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
     * Index::validaTipo()
     * Valida si es evento o curso
     * @return
     */
    function validaTipo($arr){
        if( isset( $arr[0]['tipo'] ) && $arr[0]['tipo'] == 2 ){
            $this->isEvento = true;
        }
    }
    
    
    /**
     * Index::datosClase()
     * Trae toda la informaci&oacute;n de cada capitulo segun el id
     * @return
     */
    function datosClase(){
        if(!$this->id_foro){
            die('No se encontro un foro relacionado!!');
        }
        
        $sql = ' SELECT CA.nombre,CA.`video`,C.`nombre` AS nombreCurso,C.tipo,C.id_cursos,C.informacion FROM `capitulos` CA
                 INNER JOIN cursos C ON C.`id_cursos`  = CA.`id_cursos`
                 WHERE CA.id_capitulo = '.$this->id_foro;
        $video = $this->Consulta($sql);
        $this->validaTipo($video);
        $this->_titulo = $video[0]['nombreCurso'];
        
        $this->idCurso = $video[0]['id_cursos'];
        
        
        return $video;
    }
    
    /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){        
		$respuestaArchivos = $this->tablaArchivos();	  
		$respuestaVideos = $this->datosClase();
        	  
		
$contenido= '

<section class="main-content-wrapper">
<script src="https://jwpsrv.com/library/pHZmJLAKEeS8UQp+lcGdIw.js"></script>
    		<form id="forum" name="forum">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description"> </p>
				<input type="hidden" id="id_dna_foro" name="id_dna_foro" value="' . $this->id_foro . '" /> 
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Mis Cursos -> Clase -> Foro</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-body" style="background-color:#27B6AF; color:#FFF">
                                <h3 class="panel-title" align="left" style="cursor:pointer" onclick="fn_volver();">' . stripslashes( $respuestaVideos[0]['nombre'] ). ' </h3>
                                '.$this->create_input("hidden",'nombreClase','nombreClase',false,$respuestaVideos[0]['nombre']).'
                            </div>

                            <div class="panel-body" style=" style=" float:left" >
                                    <div class="form-group" align="center">
                                        ' . stripslashes( $respuestaVideos[0]['video'] ). '
                                    </div>                                                                        
                            </div>                           
                        </div>
             </div>';
            
            $contenido .= $this->panelArchivosAyuda($respuestaArchivos,$respuestaVideos[0]['informacion']);
			 
			$contenido .='<div class="col-md-12" >
                <div class="panel panel-body" style="background-color:#6C3; color:#FFF">
                    Recuerda participar en este foro solo si tus preguntas son referentes a la clase de este video
                </div>
            </div>
			<!--  
            <div class="col-md-12" style="padding-bottom: 40px">
                <div class="panel panel-solid-success">
                            </div>
                            <div class="panel-body" style="background-color:#27B6AF; color:#FFF">
                                <div class="form-group">
                                        <label class="col-sm-7 control-label" for="descripcion">FORO:</label>
                                        <div class="col-sm-5">
                                            <input type="text" placeholder="Buscar tema en el foro" id="tema_foro" class="form-control">
                                        </diiv>
                                    </div>
                            </div>
                        </div>
            </div>
            -->
				<div class="col-md-4"> 
                        <div class="panel panel-default">
                            <div  class="panel-body" >
                                <h3 class="panel-title">INGRESAR PREGUNTA</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                           		</div>
                            </div>
                            <div id = "d_pregunta" >								
                                                   
                            </div> 
    						<div class="panel-body" id="d_area_pregunta">	
                            
                            <div class="form-group">
                                <textarea class="form-control" name="texto_pregunta" id="texto_pregunta" cols="35" rows="4"></textarea>   
    				            <input type="hidden" id="h_respuesta" name="h_respuesta" value="1" />
                            </div>							
                                 
							<p style="text-align:center;">
							<button type="button" id="guardarForum" class="btn btn-primary">Realizar Pregunta</button>
							</p>                           
                            </div> 
           					<div id="Resultado">
                            </div>                           
        				</div>
       					
						
				</div>
                    <div class="col-md-8">
						<div  id="d_detalle_forum"  >
                               '. $this->formulario().'
                        </div>                     
                    </div>
			 </form>
				</section>  ';    
		return $contenido;
    }
	
    
    public function panelArchivosAyuda($archivos,$informacion){
        if($this->isEvento) return  '';
$html ='';
             $html .= '<div class="col-md-4">
                        <div class="panel panel-default">
                            <div  class="panel-body" style="background-color:#27B6AF; color:#FFF">
                                <h3 class="panel-title">INFORMACION</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body"  >
								<div class="widget-mini"> ';

                                    $html .='
								    <span class="title text-center">
									   '.$informacion.'
								    </span>
								    ';	             			
               $html .= '</div>                                                                  
                                
                            </div>                           
                        </div>
             </div>';        
        
        
       /** $html .= '<div class="col-md-4">
                        <div class="panel panel-default">
                            <div  class="panel-body" style="background-color:#27B6AF; color:#FFF">
                                <h3 class="panel-title">ARCHIVOS DE AYUDA</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body"  >
								<div class="widget-mini"> ';

                            
                            if(count($archivos) && is_array($archivos)){
                                foreach($archivos as $r){
                                    $html .='
								    <span class="title text-center">
									   <a href="./archivosApp/' . $r['descripcion'] . '">' . $r['descripcion'] . '</a>
								    </span>
								    ';				
							     }
                            }
                            else{
                                    $html .='
								    <span class="title text-center">
									   Sin material para el curso
								    </span>
								    ';	                                
                            }								
               $html .= '</div>                                                                  
                                
                            </div>                           
                        </div>
             </div>';
             */
             return $html;
    }
    
    
    /**
     * Index::guardarDatos()
     * 
     * @return
     */
    function guardarDatos(){
		if($this->_datos['h_respuesta']>1){
			$nivel 			= 2;
			$id_padre 		= $this->_datos['h_respuesta'];
		}else{
			$nivel 			= 1;
			$id_padre 		= 0;
		}
        
        $this->id_foro = $this->_datos['id_dna_foro'];
        $this->datosClase();
		$id_dna_foro 	= $this->_datos['id_dna_foro'];
		$id_autor		= $_SESSION['id_usuario'];		
		
		$mensaje 		= $this->_datos['texto_pregunta'];
        $nombreClase 	= $this->_datos['nombre'];
		$fecha 			= date('Y-m-d H:i:s');

        $sql = "INSERT INTO `dna_foro_detalle`(`id_dna_foro`, `id_autor`, id_padre,nivel,`mensaje`,`fecha`) 
                VALUES 
                ('".$id_dna_foro."','".$id_autor."','".$id_padre."','".$nivel."','".$mensaje."','".$fecha."')";
        
        $this->QuerySql($sql);
        $this->enviaNotificacion();
        die();
            
        echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con exito </div>';          
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
        $this->mensajeCorreo = '¡Un usuario ha participado en el foro de la clase ('.$this->_datos['nombreclase'].')! ingresa y no olvides contestar sus preguntas.';
        $this->sendMailForo();
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
                WHERE `id_cursos` = " . $this->idCurso;
        $datos = $this->Consulta($sql); 
        return $datos;               
    }    
    
    /**
     * Index::formulario()
     * 
     * @return
     */
    function formulario(){
       $respuestaDatos1 = $this->tablaDatos($op='nivel',$valor = 1);
        $html = '';
        $html .= ' 
                        <div class="panel panel-default">
                            <div  class="panel-body"  style="background-color:#27B6AF; color:#FFF">
                                <h3 class="panel-title" align="left">COMENTARIOS</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">';
                            for($o = 0 ;  $o < count($respuestaDatos1) ; $o++){
               $html .=             '<div>
                                <div style="float:left"><strong>'.$respuestaDatos1[$o]['nombres'].'</strong></div>
                                <div style="text-align:right"> ' . $respuestaDatos1[$o]['fecha'] . ' </div>
                                <div style="text-align:left"> '.$respuestaDatos1[$o]['mensaje'].' </div>';
                                //imprimir($_SESSION);
                            if( ( isset($_SESSION['tipo_usuario']) && ( $_SESSION['tipo_usuario'] == 2 || $_SESSION['tipo_usuario'] == 3 ) ) ){
                                $html.='
							  <div style="text-align:right; color:#33FFFF; cursor: pointer;" onclick="fn_responder('.$respuestaDatos1[$o]['id'].');"> 
							  	Responder
								<input type="hidden" id="h_mensaje'.$respuestaDatos1[$o]['id'].'" value="'.$respuestaDatos1[$o]['mensaje'].'" /> 
							</div>';
                            } 
                            $html .=' <hr>';
                            $respuestaDatos2 = $this->tablaDatos($op='id_padre',$valor = $respuestaDatos1[$o]['id']);                            
                            for($oo = 0 ;  $oo < count($respuestaDatos2) ; $oo++){
                                $html .= 
                               '<div id="div_respuesta" style="padding: 5px 0 0 15px">
                                    <div style="float:left"><strong>'.$respuestaDatos2[$oo]['nombres'].'</strong></div>
                                    <div style="text-align:right"> ' . $respuestaDatos2[$oo]['fecha'] . ' </div>
                                    <div style="text-align:left"> '.$respuestaDatos2[$oo]['mensaje'].' </div>
                                </div>
                                 <hr>
                                ';
                            }
                                                           
                       $html .=     '</div>';
                            }
                $html .='</div>                           
                        </div>
             
			 ';
        return $html;
        
        
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
        echo $sql = 'DELETE FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $this->QuerySql($sql);
    }
    
    /**
     * Index::fn_editar()
     * 
     * @return
     */
    function fn_editar(){
        
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
        $html .= $this->Pata();
        echo $html;
    }
    
    /**
     * Index::tablaDatos()
     * 
     * @param mixed $op
     * @param mixed $valor
     * @return
     */
    function tablaDatos($op,$valor){
        $condicion = 'id_dna_foro = '.$this->id_foro.' ';
		if($op=='nivel'){
			$condicion .= ' AND  nivel  = '.$valor;
		}
		if($op=='id_padre'){
			$condicion .= ' AND id_padre  = '.$valor;
		}
        $sql = 'SELECT id, id_dna_foro, id_autor, id_padre, nivel, mensaje, fecha,U.nombres  FROM '.$this->Table2.' F 
        INNER JOIN usuarios U ON U.id_usuario = F.id_autor 
        
        WHERE '.$condicion.' ORDER BY fecha DESC';
        $sql.'<hr>';
        $datos = $this->Consulta($sql); 
        return $datos;        
    } 
	
	/**
	 * Index::tablaArchivos()
	 * 
	 * @param mixed 
	 * @return
	 */
	function tablaArchivos(){
        if(!$this->id_foro){
            die('No se encontro un foro relacionado!!');
        }
        $sql = 'SELECT descripcion FROM archivos_app WHERE id_capitulo = '.$this->id_foro;
        
        $datos = $this->Consulta($sql); 
        return $datos;        
	}

	/**
	 * Index::videoArchivos()
	 * 
	 * @return
	 */
	function videoArchivos(){
	   
	}
	  
}
?>