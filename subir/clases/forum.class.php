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
     * Index::datosClase()
     * Trae toda la información de cada capitulo segun el id
     * @return
     */
    function datosClase(){
        if(!$this->id_foro){
            die('No se encontro un foro relacionado!!');
        }
        
        $sql = 'SELECT video,nombre FROM capitulos WHERE id_capitulo = '.$this->id_foro;
        $video = $this->Consulta($sql);
        $this->_titulo = $video[0]['nombre'];
        
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
                    <span class="label">You are here:</span>
                    <ol class="breadcrumb">
                        <li class="active">Admin Curso</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Video - '.$respuestaVideos[0]['nombre'].'</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body" style=" style=" float:left" >
                               
                                    <div class="form-group" align="center">
                                        '.$respuestaVideos[0]['video'].'
                                    </div>                                                                        
                               
                            </div>                           
                        </div>
             </div>
            <div class="col-md-8" class="col-md-6" style="width:30%">
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
								<div class="widget-mini" style=" height:250px;"> ';


                                      
                                foreach($respuestaArchivos as $r){
                                    $contenido .='
								<span class="title text-center">
									* <a href="./archivosApp/' . $r['descripcion'] . '">' . $r['descripcion'] . '</a>
								</span>
								';
													
							}
										
										
										
										
               $contenido .= '</div>                                                                  
                                
                            </div>                           
                        </div>
             </div>
			 
			
			
			<table width="98%" border="0" align="center">
                  <tr>
                    <td width="8%" height="59" align="center"  style="background-color:#6C3; color:#FFF">
                    	USO DEL<br />
                    	FORO
                   	</td>
                    <td width="2%" style="background-color:#6C3; color:#FFF" align="center"> </td>
                    <td width="90%" style="background-color:#6C3; color:#FFF">
                    	Participe en este foro solo si sus preguntas son con respecto al tema referente a este video. Si su pregunta ya ha sido tratado en otro foro, el
                    	monitor lo dirijira a donde se encuentra la respuesta. NO SE RESPONDERAN PREGUNTAS QUE NO SEAN TEMAS DE LOS VIDEOS
                    </td>
                  </tr>
                  <tr>
                    <td height="23" colspan="3">&nbsp;</td>
                  </tr>
                </table>
				
			<table width="98%" border="0" align="center">
                  <tr>
                    <td width="8%" height="59" align="center" style="background-color:#27B6AF; color:#FFF">FORO </td>
                    <td width="42%" style="background-color:#27B6AF; color:#FFF" align="center"> <p></p></td>
                   <td width="50%" style="background-color:#27B6AF; color:#FFF">
                    <input type="text" placeholder="Buscar tema en el foro" id="tema_foro" class="form-control">
                    </td>
					 <td width="2%" style="background-color:#27B6AF; color:#FFF">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="23" colspan="3">&nbsp;</td>
                  </tr>
                </table>
            	
				<table width="98%" border="0" align="center" >
                  <tr>
                    <td width="30%" height="59" align="center" valign="top" > 
                        <div class="panel panel-default">
                            <div  class="panel-body" >
                                <h3 class="panel-title">INGRESAR PREGUNTA</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                           		</div>
                            </div>                          
        				</div>
       					<div id = "d_pregunta" >								
                                                   
                        </div> 
						<div class="panel-body"   id="d_area_pregunta">								
                            <textarea name="texto_pregunta" id="texto_pregunta" cols="35" rows="4"></textarea>   
							<input type="hidden" id="h_respuesta" name="h_respuesta" value="1" /> 
							<p> 
							<button type="button" id="guardarForum" class="btn btn-primary">Realizar Pregunta</button>
							</p>                           
                        </div> 
       					<div id = "Resultado" >								
                                                   
                        </div> 
						
						
                    <td width="70%" align="center" >
						<div  id="d_detalle_forum"  >
                               '. $this->formulario().'
                        </div>                     
                    </td>                    
                  </tr>
                  <tr><td height="23" colspan="4"></td></tr>
                </table>
				
			 </form>
				</section>  ';    
		return $contenido;
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

		$id_dna_foro 	= $this->_datos['id_dna_foro'];
		$id_autor		= 999;		
		
		$mensaje 		= $this->_datos['texto_pregunta'];
		$fecha 			= date('Y-m-d h:m');

        $sql = "INSERT INTO `dna_foro_detalle`(`id_dna_foro`, `id_autor`, id_padre,nivel,`mensaje`,`fecha`) 
                VALUES 
                ('".$id_dna_foro."','".$id_autor."','".$id_padre."','".$nivel."','".$mensaje."','".$fecha."')";
        
        $this->QuerySql($sql);
            
        echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con exito </div>';          
    }
    
    /**
     * Index::formulario()
     * 
     * @return
     */
    function formulario(){
       $respuestaDatos1 = $this->tablaDatos($op='nivel',$valor = 1);
        $html = '';
        $html .= ' <div class="col-md-8" class="col-md-6" style="width:100%">
                        <div class="panel panel-default">
                            <div  class="panel-body"  style="background-color:#27B6AF; color:#FFF">
                                <h3 class="panel-title" align="left" style="cursor:pointer" onclick="fn_volver();"><< REGRESAR AL CURSO </h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
							<table width="100%" border="0" align="center">
							';
							for($o = 0 ;  $o < count($respuestaDatos1) ; $o++){
		$html .=			'<tr><td>
								<table width="100%" border="0" align="center">
									<tr>
										<td align="left"><strong>'.$respuestaDatos1[$o]['id_autor'].'</strong></td>
										<td align="right">'.$respuestaDatos1[$o]['fecha'].'</td>										
									</tr>
									<tr>									
									  <td colspan="2">'.$respuestaDatos1[$o]['mensaje'].'</td>
									</tr>
									<tr>
									  <td colspan="2" align="right" style="color:#33FFFF; cursor: pointer;" onclick="fn_responder('.$respuestaDatos1[$o]['id'].');"> 
									  	Responder
										<input type="hidden" id="h_mensaje'.$respuestaDatos1[$o]['id'].'" value="'.$respuestaDatos1[$o]['mensaje'].'" /> 
									</td>
									</tr>
											<tr>										
												<td colspan="2"><HR width=100% align="center"></td>
											</tr>
									
								</table>
								';
								$respuestaDatos2 = $this->tablaDatos($op='id_padre',$valor = $respuestaDatos1[$o]['id']);
								# Imprimir($respuestaDatos2);
								for($oo = 0 ;  $oo < count($respuestaDatos2) ; $oo++){
				$html .=			'
										<table width="100%" border="0" align="center">
											<tr>
												<td width="6%" rowspan="3">&nbsp;</td>
												<td align="left"><strong>'.$respuestaDatos2[$oo]['id_autor'].'</strong></td>
												<td align="right">'.$respuestaDatos2[$o]['fecha'].'</td>
											</tr>
											
											<tr>
											  <td colspan="2" >'.$respuestaDatos2[$oo]['mensaje'].'</td>
											</tr>
											<tr>										
												<td colspan="2"><HR width=100% align="center"></td>
											</tr>
										</table>
										';
									
									
								}
		$html .=			'</td></tr>';								
							}
                                                                
                                
        $html .=            '
							</table>
							</div>                           
                        </div>
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
        $sql = 'SELECT id, id_dna_foro, id_autor, id_padre, nivel, mensaje, fecha  FROM '.$this->Table2.' WHERE '.$condicion.' ORDER BY fecha';
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