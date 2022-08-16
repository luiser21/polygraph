<?php
class crearHtml extends sql{
    
    
    
    public $NombreUsuario = '';
    
    public $fotoUsuario = 'archivosApp/usuario.jpg';
    
    /**
     * crearHtml::$arrCss
     * 
     * @return Hojas de estilos que deben ser agregadas en el head
     */
    public $arrCss = array();
    
    /**
     * crearHtml::$barraUsuario
     * 
     * @return Determina mostrar la barra profile que muestra foto e informacion del usuario
     */    
     public $barraUsuario = true;
    
       
    /**
     * crearHtml::$arrCss
     * 
     * @return Archivos js que se deben agregar al head
     */
    public $arrJs = array();    
    
    /**
     * crearHtml::$titulo
     * 
     * @return titulo que se escribira en las etiquetas html '<Title>'.
     */
    public $titulo = 'PolyGraph';

    /**
     * crearHtml::$usuario
     * @return Nombre del usuario que se mostrara en la plantilla.
     */    
    public $usuario = '';
    
    /**
     * crearHtml::idUsuario
     * @return Id del usuario en session.
     */    
    public $idUsuario = false;
    
      
    
    /**
     * crearHtml::$PrimaryKey
     * 
     * @return primary key de la tabla trabajada '<Title>'.
     */
    public $PrimaryKey;
    
    /**
     * crearHtml::$Table
     * 
     * @return tabla que relaciona para las operaciones CRUD.
     */ 
     
     public $Table;
     
     public $mensajeCorreo = '';
     public $to = '';
     public $NombreCorreo = '';
     
     
    /**
     * crearHtml::$Esquema
     * 
     * @return esquema de la base de datos.
     */  
     
     public $Esquema ='';
     
     public $ckEditor = false;
     
     public $ValuesReserved = array('SYSDATE','NOW()');
     
     public $_file;
     
     public $MensajeActualizacion = 'Datos actualizados con &eacute;xito';
     
     /**
     * crearHtml::$extPermitidas
     * array que contiene las extensiones permitidas para la carga de archivos
     * @return array()
     */
     public $extPermitidas = array('jpg', 'png', 'gif', 'jpeg','doc','docx','pdf'); 
     
     private $ArrayColumns = array();
     private $ArrayData = array();
     private $ArrayUpdates = array();
     private $ArrayValues = array();
     private $ArrayFields = array();     
    
    /**
     * template::$menu()
     * @author David Ardila
     * @version 1.0 
     * @return Default en true para mostrar el html del menu en la plantilla.
     * @param $nombre Nombre que tendra el elemento html <select>
     * @param $id Id que tendra el elemento html <select>
     * @param $arrOpciones Arreglo con los elementos que se generaran en cada <option> del elemento <select>
     * @param $default Compara valor con el arreglo y agregar el auto select "selected"
     * @param $valorSeleccion Valor que tendra la seleccion por defecto
     * @param $textoSeleccion Texto que tendra la seleccion por defecto del elemento <select>
     * @param $complemento Texto html que tendra como complemento la etiqueta html <select> 
     */
    public $menu = true;
    
    /**
     * crearHtml::Iniciar()
     * 
     * @return
     */
    function Iniciar(){
        $this->Esquema = ($_SESSION['bdatos']<>'')? $_SESSION['bdatos']: 'plygraph';
         $this->_file  = $_SERVER['PHP_SELF'];
         if( isset($_SESSION['id_usuario']) ){
            $this->idUsuario = $_SESSION['id_usuario'];
            $this->NombreUsuario = $_SESSION['nombre'];
            $this->ApellidoUsuario = $_SESSION['apellido'];
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
    
     /**
     * crearHtml::crearSelect()
     * Metodo generico para traer informacion para campo select
     * @param string $valorSeleccion
     * @param string $textoSeleccion
     * @param bool $complemento
     * @return
     */
    public function getCombo($id,$desc){
        $sql = "SELECT {$id} codigo, {$desc} from mecanismos WHERE activo = 1";
        return  $this->Consulta($sql);
    }
    
    
    /**
     * crearHtml::crearSelect()
     * 
     * @param mixed $nombre
     * @param mixed $id
     * @param mixed $arrOpciones
     * @param bool $default
     * @param string $valorSeleccion
     * @param string $textoSeleccion
     * @param bool $complemento
     * @return
     */
    function crearSelect($nombre,$id,$arrOpciones,$default=false,$valorSeleccion='',$textoSeleccion='Seleccione una opci&oacute;n',$complemento=false){
        $Html =  '<select name="'.$nombre.'" id="'.$id.'" '.$complemento.'>';
        $Html .= '<option value="'.$valorSeleccion.'">'.$textoSeleccion.'</option>';
                if(is_array($arrOpciones) && count($arrOpciones)){
                    foreach($arrOpciones as $opt){
                        $Html .= '<option value="'.$opt['codigo'].'">'.$opt['descripcion'].'</option>'; 
                    }
                }
                
        return $Html .= '</select>';   
    }
    
    function menuAdmin(){
		
        $open = ( strpos($_SERVER['SCRIPT_NAME'],'generarOt.php') )? 'open' : ''; 
        $html ='';
        if(!isset($_SESSION["tipo_usuario"])){           
            $_SESSION["tipo_usuario"]='autorizacion';
        }
        if($_SESSION["tipo_usuario"]==3){
            $html = '<li class="nav-dropdown">
                            <a href="#" title="AGENDAMIENTO">
                                <i class="fa fa-bar-chart-o"></i>AGENDAMIENTO
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a href="agendar.php?adm=1&liberar='.@$_SESSION["liberar"].'" title="Listar">
                                        Agendar
                                    </a>
                                </li>
                                <li>
                                    <a href="reagendar.php?adm=1&liberar='.@$_SESSION["liberar"].'" title="Listar">
                                        Reagendar
                                    </a>
                                </li>
								 <li>
                                    <a href="solicitudes.php?adm=1&liberar='.@$_SESSION["liberar"].'" title="Listar">
                                        Reportes
                                    </a>
                                </li>
                
                        </ul>
                
                         <li class="nav-dropdown  '.$open.'">';
        }
        if($_SESSION["tipo_usuario"]==4){
            $html = '<li class="nav-dropdown">
                            <a href="#" title="Buscar">
                                <i class="fa fa-bar-chart-o"></i>BUSCAR AUTORIZACION
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a href="buscador.php?adm=1" title="Buscar">
                                         Buscar Autorizacion
                                    </a>
                                </li>
                
                        </ul>
                
                         <li class="nav-dropdown  '.$open.'">';
        }
        if($_SESSION["tipo_usuario"]==2 || $_SESSION["tipo_usuario"]==1){
        $html = '<li class="nav-dropdown">
                            <a href="#" title="INFORME DE POLIGRAFO">
                                <i class="fa fa-bar-chart-o"></i>INFORME DE POLIGRAFO
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a href="plantas.php?adm=1" title="Listar">
                                         Listar Solicitudes
                                    </a>
                                </li>
                                <li>
                                    <a href="reportes.php?adm=1" title="Listar">
                                         Listar Autorizaciones
                                    </a>
                                </li>
                                            
                        </ul>
                                                                                   
                         <li class="nav-dropdown  '.$open.'">';
              if( $_SESSION["tipo_usuario"]<>0 && $_SESSION["tipo_usuario"]<>3){
                                    $html .= '
                            <a href="#" title="Forms">
                                <i class="fa fa-users"></i>USUARIOS
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a href="usuarios.php" title="Usuarios">
                                         Usuarios
                                    </a>
                                </li> ';
              if($_SESSION["tipo_usuario"]==2 || $_SESSION["tipo_usuario"]==1){
                      $html .= '<li>
                                    <a href="parametros.php" title="Parametros">
                                         Parametros
                                    </a>
                                </li>
                                
                                ';
                                }
                    $html.= '</ul>';
                  }
                  if($_SESSION["tipo_usuario"]==2 || $_SESSION["tipo_usuario"]==1){
                 $html.='</li>                                                         
                         <li class="nav-dropdown  '.$open.'">
                            <a href="#" title="Forms">
                                <i class="fa  fa-fw fa-cogs"></i>CONFIGURAR
                            </a>
                            <ul class="nav-sub">
                                 <li>
                                    <a href="procedimientosTareas.php" title="Procedimientos Tareas">
                                         Procedimientos Tareas
                                    </a>
                                </li>
                                                                                         
                            </ul>
                        </li>';
 			
                        $html .='
                        <li class="nav-dropdown  '.$open.'">
                            <a href="#" title="Forms">
                                <i class="fa fa-file-pdf-o"></i> CARTAS
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a href="descargarMecMet.php" title="Programaci&oacute;n">
                                        Exportar configuraci&oacute;n de cartas
                                    </a>
                                </li>                            
                                <li>
                                    <a href="reportes.php" title="Informes">Imprimir Cartas</a>
                                </li>
                                                             
                            </ul>
                        </li>
                    ';
                  }
                      
        }
                    return $html;
    }
    
 
    /**
     * Index::subirArchivos()
     * @throws Exception C&oacute;digo 01 - Extension no valida para carga de archivo
     * @param string $campo, hace referencia al nombre del input file que lleva el archivo a subir
     * @param string $Ruta, ruta en donde se va a cargar el archvo
     * @return
     */
    function subirArchivos($campo,$Ruta = './imgCursos/'){
        $arrExt = $this->extPermitidas;
        $ext = explode( '.', $_FILES[$campo]['name'] );
        try{
            if( in_array( end( $ext ) , $arrExt  ) ){
                $origen = $_FILES[$campo]['tmp_name'];
        		$nombreImagen = $_FILES[$campo]['name'];
        		
        		$destino =$Ruta.$nombreImagen;
        		$tipo = $_FILES[$campo]['type'];
        
        		$tamano = $_FILES[$campo]['size'];
        	    	
                
        		if(copy($origen, $destino)){
        		  return $destino;
                }    
            }
            else{
                throw new Exception ( "Extension no valida para carga de archivo", "Extension no valida para carga de archivo" );
            }
        }catch(Exception $e){
            throw $e;
        }
    }
    
    function consultarPais($id_pais=false){       
		$condicion = '';
        if($id_pais){
			$condicion = ' id  = '.$id_pais.' AND';
		}
        $sql = 'SELECT id, codigo_pais, descripcion  FROM z_pais WHERE '.$condicion.'  cancel  = 0';
        $datos = $this->Consulta($sql); 
		$html = ' <select class="form-control input-sm" id="pais" name="pais"> ';
		
		for($oo = 0 ;  $oo < count($datos) ; $oo++){
				$html .= ' <option value="'.$datos[$oo]['id'].'">'.$datos[$oo]['descripcion'].'</option> ';
		}		
		$html .= '</select>';		
        return $html;        
    } 
    
    function consultarMunicipio($id_Muni=false){    	
        $condicion = '';
        $sql = 'SELECT id, z_departamento_id, codigo_municipio, descripcion  FROM z_municipio WHERE '.$condicion.'  cancel  = 0';
        $datos = $this->Consulta($sql); 
		$html = ' <select class="form-control input-sm" id="ciudad" name="ciudad"> ';
		
		for($oo = 0 ;  $oo < count($datos) ; $oo++){
				$s_1 =  ( $id_Muni == $datos[$oo]['id'] )? ' selected="selected"' : '';
				$html .= ' <option value="'.$datos[$oo]['id'].'" '.$s_1.'>'.$datos[$oo]['descripcion'].'</option> ';
		}		
		$html .= '</select>';		
        return $html;        
    } 
    
    /**
     * crearHtml::menuUsuario()  
     * @return Html con el contenido del menu para usuarios no Logueados en el sistema
     * @author David Ardila (david.ardila@gmail.com)
     * @version 1.0
     * @return
     */     
    function getNumeroForos(){
        $sql = "SELECT COUNT(*) as cuantos FROM `dna_foro_detalle` F
                JOIN `capitulos` CA ON CA.id_capitulo = F.`id_dna_foro`
                JOIN `cursos` C ON C.id_cursos = CA.id_cursos
                JOIN  `profesores_cursos` PC ON PC.id_cursos = C.`id_cursos`
                WHERE PC.`id_profesor` = ". $this->idUsuario;
        $datos = $this->Consulta($sql);
        return $datos[0]['cuantos'];        
    }
            
    /**
     * crearHtml::menuUsuario()  
     * @return Html con el contenido del menu para usuarios no Logueados en el sistema
     * @author David Ardila (david.ardila@gmail.com)
     * @version 1.0
     * @return
     */    
    function menuUsuario(){
        $html = '<li class="nav-dropdown open">
                    <div style="width:100%">
                    <a href="index.php" title="Iniciar sesion">
                        <div class="btn btn-success" style="width:100%">Iniciar Sesi&oacute;n</div>
                    </a>
                    <div style="color:#FFF; width:100%;" class="text-center">&Oacute;</div>
                    <a href="record.php" title="Registrarse en DNA">
                        <div class="btn btn-info" style="width:100%">Registrarte</div>
                    </a>
                    </div>
                 </li>       ';
                    return $html;
    }
    
function menuLogueado(){
        $open = ( strpos($_SERVER['SCRIPT_NAME'],'misCursos.php') )? 'open' : ''; 
        $html = '<li class="nav-dropdown '.$open.'">
                            <a href="misCursos.php" title="Mis cursos">
                                <i class="fa  fa-fw fa-edit"></i> MIS CURSOS
                            </a>
                            <!-- <ul class="nav-sub">    
                                <li>
                                    <a href="misCursos.php" title="Mis cursos">
                                         Mis Cursos
                                    </a>
                                </li>
                                <li>
                                    <a href="misCursos.php?e=1" title="Mis cursos">
                                         Mis Eventos en vivo
                                    </a>
                                </li>                                
                            </ul> 
                            -->
                        </li>       ';
                    return $html;
    }        

    /**
     * crearHtml::menuProfesor()  
     * @return Html con el contenido del menu para profesores o administradores
     * @author David Ardila (david.ardila@gmail.com)
     * @version 1.0
     * @return
     */   
    function menuProfesor(){
       // $numeroMensajes = $this->getNumeroForos();
        $open = ( strpos($_SERVER['SCRIPT_NAME'],'calificar.php') )? 'open' : ''; 
        $html = '<li class="nav-dropdown '.$open.'">
                    <a href="#" title="Forms">
                        <i class="fa  fa-fw fa-edit"></i> PROFESOR
                    </a>
                    <ul class="nav-sub">
                        <li>
                            <a href="calificar.php" title="Calificar trabajos">
                                 Calificar
                            </a>
                        </li> 
                        <a href="responder.php" title="Foros">
                            <i class="fa fa-fw fa-envelope-o"></i> Foros
                            <span class="label label-primary label-circle pull-right">1</span>
                        </a>                                                              
                    </ul>
                 </li>       ';
        return $html;        
    }

    /**
     * crearHtml::menuUsuario()  
     * @return Html con el contenido del menu para usuarios no Logueados en el sistema
     * @author David Ardila (david.ardila@gmail.com)
     * @version 1.0
     * @return
     */    
    function menuEstandar(){
        $open = ( strpos($_SERVER['SCRIPT_NAME'],'listados.php') )? 'open' : ''; 
        $html = '<li class="nav-dropdown '.$open.'">
                    <a href="listados.php" title="Ver todos los cursos disponibles">
                        <i class="fa  fa-fw fa-edit"></i>CURSOS
                    </a>
                    <!--
                    <ul class="nav-sub">
                        
                        <li>
                            <a href="listados.php" title="Ver todos los cursos disponibles">
                                 Todos
                            </a>
                        </li>
                        
                        <li>
                            <a href="listados.php?t=1" title="Ver todos los cursos disponibles">
                                 Cursos
                            </a>
                        </li>                        
                        
                        <li>
                            <a href="listados.php?t=2" title="Ver todos los eventos disponibles">
                                 Eventos en vivo
                            </a>
                        </li>
                        
                        <li>
                            <a href="listados.php?t=3" title="Ver todos los cursos gratis disponibles">
                                 Gratis
                            </a>
                        </li>                                             
                    </ul> -->
                 </li>       ';
                    return $html;
    }

    function getEmpresaUrl(){
        $httpHost = explode('/',$_SERVER['HTTP_HOST']);
   
        if( isset($httpHost[0]) && $httpHost[0] == 'localhost' )
            return $httpHost[0];
        else
            $httpHost = explode('.',$_SERVER['HTTP_HOST']);
        
        return $httpHost[0]; 
    }
    
        
    function plantillaCorreo(){
        $this->mensajeCorreo;
		$cuerpoCorreo = '<table width="548" border="0" align="center" style=" font-family:Arial, Helvetica, sans-serif; color:#333; font-size:12px;">
  <tr>
    <td width="542" align="center"><a href="http://dnamusiconline.com"><img name="" src="http://dnamusiconline.com/mail/logo-dna.png" width="290" height="57" alt="" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-size:20px;">Hola<strong> '.$this->NombreCorreo.' </strong></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-size:14px;">Información importante:</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="background-color:#671675; color:#FFFFFF; font-size:14px; padding:20px; border-radius:6px;">&quot;'.$this->mensajeCorreo.'&quot;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><a href="http://www.dnamusiconline.com/cursos_online/listados.php"><img name="" src="http://dnamusiconline.com/mail/imagen1-mail.jpg" width="553" height="315" alt="" /></a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://dnamusicapp.com"><img name="" src="http://dnamusiconline.com/mail/imagen2-mail.png" width="553" height="311" alt="" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><a href="https://www.facebook.com/DnaMusicDJ"><img name="" src="http://icons.iconarchive.com/icons/danleech/simple/32/facebook-icon.png" width="32" height="32" alt="" /></a>   &nbsp; <a href="https://www.instagram.com/dnamusicdj/"><img name="" src="http://icons.iconarchive.com/icons/designbolts/free-instagram/32/Active-Instagram-1-icon.png" width="32" height="32" alt="" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">info@dnamusic.edu.co | dnamusiconline.com <br /> PBX: +57 (1) 745217<br />
      Calle 45A # 28-13<br />
    Bogot&aacute; - Colombia</td>
  </tr>
  <tr>
    <td align="center">Todos los Derechos Reservados &copy; 2016</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>	 
		';
        return $cuerpoCorreo;
    }
    
    function sendMail(){
        $mensaje = $this->plantillaCorreo();
        $to 	= $this->to;
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";        
        $from = "tudnamusic@gmail.com";
        $headers .= "From: DNA MUSIC <tudnamusic@gmail.com>\r\n"; 
      
        if(mail($to,'DNA MUSIC',$mensaje,$headers)){
            
            //echo $return = 'Mensaje enviado con exito a :' .$to . $mensaje;
            $return = 1;
        }else{
            echo $return = 'Correo no enviado';
        }
        return $return;
        
    }

    function plantillaCorreoForo(){
        $this->mensajeCorreo;
		$cuerpoCorreo = '<table width="548" border="0" align="center" style=" font-family:Arial, Helvetica, sans-serif; color:#333; font-size:12px;">
  <tr>
    <td width="542" align="center"><a href="http://dnamusiconline.com"><img name="" src="http://dnamusiconline.com/mail/logo-dna.png" width="290" height="57" alt="" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-size:20px;">Hola<strong> '.$this->NombreCorreo.' </strong></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-size:14px;">Información importante:</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="background-color:#671675; color:#FFFFFF; font-size:14px; padding:20px; border-radius:6px;">&quot;'.$this->mensajeCorreo.'&quot;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><a href="https://www.facebook.com/DnaMusicDJ"><img name="" src="http://icons.iconarchive.com/icons/danleech/simple/32/facebook-icon.png" width="32" height="32" alt="" /></a>   &nbsp; <a href="https://www.instagram.com/dnamusicdj/"><img name="" src="http://icons.iconarchive.com/icons/designbolts/free-instagram/32/Active-Instagram-1-icon.png" width="32" height="32" alt="" /></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">info@dnamusic.edu.co | dnamusiconline.com <br /> PBX: +57 (1) 745217<br />
      Calle 45A # 28-13<br />
    Bogot&aacute; - Colombia</td>
  </tr>
  <tr>
    <td align="center">Todos los Derechos Reservados &copy; 2016</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>	 
		';
        return $cuerpoCorreo;
    }
    
    function sendMailForo(){
        $mensaje = $this->plantillaCorreoForo();
        $to 	= $this->to;
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";        
        $from = "tudnamusic@gmail.com";
        $headers .= "From: DNA MUSIC <tudnamusic@gmail.com>\r\n"; 
      
        if(mail($to,'DNA MUSIC',$mensaje,$headers)){
            
            //echo $return = 'Mensaje enviado con exito a :' .$to . $mensaje;
            $return = 1;
        }else{
            echo $return = 'Correo no enviado';
        }
        return $return;
        
    }        
    
    function getTipoUsuario(){
        $tipo = array();
        if( isset( $_SESSION[ 'tipo_usuario' ] ) ){
            $sql = 'SELECT descripcion FROM tipo_usuario where id_tipo_usuario = '.$_SESSION['tipo_usuario'];
            $tipo = $this->Consulta($sql);
        }
        return $tipo;
    }
    function generar_informe_empresa($pdf,$idautorizacion){
        $sql = "UPDATE autorizacion_evaluado set pdf='".$pdf."' where estado='A' and idautorcandidato=".$idautorizacion;
        $tipo = $this->QuerySql($sql);
        
        //return $tipo;
    }
    function generarreporte($cedula,$autorizacion){
        
        $sql = "SELECT ae.idautorcandidato,a.idautorizacion,a.nombre as nombre_autorizacion,a.politicas,a.clientetercerizado,e.cargo,e.clientefinal,C.DOCUMENTO as CEDULA,
                CONCAT(c.NOMBRES, ' ', c.APELLIDOS) AS EVALUADO,C.CELULAR,t.NOMBRE as tipo_prueba,c.LUGAREXPEDICION,a.logo,ae.foto,ae.observaciones,
                DATE_FORMAT(ae.fecha,'%d de %M del %Y %H:%i:%S') as FECHA
                FROM autorizaciones a
                INNER JOIN autorizacion_evaluado ae ON ae.idautorizacion=a.idautorizacion
                INNER JOIN evaluado E ON e.id_candidato=ae.idcandidato
                INNER JOIN candidatos C ON C.ID=E.id_candidato
                INNER JOIN tipo_prueba t ON t.ID_PRUEBA=e.id_tipo_prueba
                WHERE a.estado='A' and ae.estado='A' and C.DOCUMENTO=".$cedula." and idautorcandidato=".$autorizacion;
       
        $tipo = $this->Consulta($sql);
        
        return $tipo;
    }
    function generarreporte_imagen($equipos){
        
        $sql = 'SELECT IM.description AS RUTA, IM.file as IMAGEN
                FROM equipos e
                LEFT JOIN equipos_imagen IM ON IM.id_equipos = e.id_equipos
                WHERE e.activo =1 AND e.id_equipos ='.$equipos;
        $tipo = $this->Consulta($sql);
        
        return $tipo;
        
    } 
    function generarreporte2($equipos){
        
        $sql = 'SELECT
            	CO.id_componentes,
            	CO.descripcion AS COMPONENTE,
            	ME.id_mecanismos AS ID_MECA,
            	ME.descripcion AS MECANISMO,
                ME.consecutivo AS CONSECUTIVO,
            	LU.CLASE,
            	LU.TIPO,
            	LU.CATEGORIA,
            	LU.descripcion AS NOM_LUBRICANTE,
            	LU.MARCA,
            	CL.descripcion AS CLASIFICACION,
            	MET.descripcion AS METODO,
        	    TA.descripcion AS TAREAS,
	            FRE.dias_horas AS FRECUENCIAS,
	            MEC.PUNTOS,
                MEC.cantidad,
                UNI.abreviatura,
                UNIF.abreviatura as abreviaturaf,
                SIM.ruta AS RUTA,
                SIM.descripcion AS ROTULO
            FROM
            	componentes CO
            INNER JOIN mecanismos ME ON ME.id_componente = CO.id_componentes
            INNER JOIN mec_met MEC ON MEC.id_mecanismos=ME.id_mecanismos
            LEFT JOIN lubricantes LU ON LU.id_lubricantes=MEC.cod_lubricante
            LEFT JOIN clasificaciones CL ON CL.id_clasificaciones=LU.cod_clasificacion
            LEFT JOIN metodos MET ON MET.id_metodos=MEC.id_metodos
            LEFT JOIN tareas TA ON TA.id_tareas=MEC.id_tareas
            LEFT JOIN frecuencias FRE ON FRE.id_frecuencias=MEC.id_frecuencias
            LEFT JOIN unidades UNI ON UNI.id_unidades=MEC.id_unidad_cant
            LEFT JOIN unidades UNIF ON UNIF.id_unidades=FRE.id_unidad
            LEFT JOIN simbologia SIM ON SIM.id_simbologia=MEC.id_simbologia
            WHERE
            	CO.id_equipos = '.$equipos.'
            ORDER BY
            	CO.consecutivo,ME.consecutivo ';
        //  echo  $sql;exit();
        $tipo = $this->Consulta($sql);
        
        return $tipo;
    }
    
    function updateMasivo($tabla='',$arryaData=array(),$id_detalle=''){
        $contador=0;
        foreach($arryaData as $valor){
            $contador++;
            $Query1="UPDATE ".$tabla." SET
                    minutos_ejec_real=".$valor['minutos_ejec_real']."
                    ,cantidad_real=".$valor['cantidad_real']."
                    ,fecha_real=trim('".$valor['fecha_real']."')
                    ,ejecutado=".$valor['ejecutado']."
                    ,observaciones_ejec='".$valor['observaciones_ejec']."'
                    WHERE ".$id_detalle."=".$valor['id_detalle'];
            $this->QuerySql( $Query1 ); 
        }
        return $contador;
    }
    function rotulo_figuras($frecuencia=0,$aplicacion=0,$lubricante=0){
          
        if($frecuencia==0 && $aplicacion==0 && $lubricante==0){
            $Query1="DELETE FROM simbologia";
            $this->QuerySql( $Query1 ); 
        }
        $sql = "SELECT DISTINCT f.descripcion Frecuencia,
                    CASE l.clase
                    	WHEN 'Mineral' THEN 'Amarillo'
                    	WHEN 'Sintetico' THEN 'Azul'
                    	WHEN 'Vegetal' THEN 'Verde'
                    ELSE 'NA'
                    END as Color_Borde,
                    c.descripcion Color_Fig_Ext,
                    CASE l.categoria
                            WHEN 'H1' THEN 'Cuadrado'
                            WHEN 'H2' THEN 'Circulo'
                            WHEN 'H3' THEN 'Triangulo'
                            ELSE 'NA'
                    END as Fig_Interna,
                    c1.descripcion Color_Fig_Interna, cl.abreviatura Texto_Fig_Interna,
                    CONCAT(f.descripcion, '_', CASE l.clase
                                  	WHEN 'Mineral' THEN 'Amarillo'
                            		WHEN 'Sintetico' THEN 'Azul'
                                    WHEN 'Vegetal' THEN 'Verde'
                                  	ELSE 'NA'
                    END, '_', c.descripcion, '_', CASE l.categoria
                                  	WHEN 'H1' THEN 'Cuadrado'
                            		WHEN 'H2' THEN 'Circulo'
                                    WHEN 'H3' THEN 'Triangulo'
                                  	ELSE 'NA'
                    END, '_', c1.descripcion, '_', cl.abreviatura, '.png') Archivo,
                    m.id_frecuencias,
                    m.id_aplicacion,
                    m.cod_lubricante,
                    c.hexadecimal hexa_color_ext,
                    c1.hexadecimal hexa_color_int
                    FROM mec_met m
                    inner join lubricantes l on (m.cod_lubricante=l.id_lubricantes)
                    inner join aplicaciones_lub a on (m.id_aplicacion=a.id_aplicacion)
                    inner join clasificaciones cl on (l.cod_clasificacion=cl.id_clasificaciones)
                    inner join frecuencias f on (m.id_frecuencias=f.id_frecuencias)
                    inner join colores c on (a.id_colores=c.id_colores)
                    inner join colores c1 on (cl.id_colores=c1.id_colores)
                    where m.id_frecuencias > 0
                    and m.cod_lubricante > 0
                    and m.id_aplicacion > 0 ";
                    if($frecuencia<>0){
                        $sql.=" AND m.id_frecuencias=$frecuencia ";
                    }
                    if($aplicacion<>0){
                        $sql.=" AND m.id_aplicacion=$aplicacion ";
                    }
                    if($lubricante<>0){
                        $sql.=" AND m.cod_lubricante=$lubricante ";
                    }
                    $sql.=" order by m.id_frecuencias, m.id_aplicacion, m.cod_lubricante ";
                    //echo $sql;
        $tipo = $this->Consulta($sql); 
        
        return $tipo;
    }
    function insertar_rotulo_figuras($id_frecuencias,$id_aplicacion,$cod_lubricante,$Archivo, 
        $ruta, $usuario_session){  
        
       
            
        $Query="INSERT INTO simbologia (id_frecuencia, id_aplicacion, id_lubricante, descripcion, ruta, id_usuario) VALUES
         (".$id_frecuencias.",".$id_aplicacion.",".$cod_lubricante.",'".$Archivo."','".$ruta."',".$usuario_session.")";
        $this->QuerySql( $Query );
          
        $Query2="UPDATE mec_met set id_simbologia=(SELECT MAX(id_simbologia) FROM simbologia)
        where id_frecuencias=".$id_frecuencias." and id_aplicacion=".$id_aplicacion." and cod_lubricante=".$cod_lubricante;
        $this->QuerySql( $Query2 );
    }
    function barraProfile(){
        $this->fotoUsuario = $_SESSION['foto'];
       // print_r($this);
        $tipoUsuario = $this->getTipoUsuario();
		$imagen='<img  class="img-circle profile-image" src="./imagenes/polygraph-03.png" alt="profile" width="85" height="85">';
		if(!empty($_SESSION["logo"])){
			$imagen='<style>
					.sidebar-profile .profile-image {
						width: 150px;						
					}
				</style>
				<img style=" background-color: #ffffff; " class=" profile-image" src="'.$_SESSION["logo"].'" alt="profile" width="85" height="85">';
		}
        $html = ' 
                <div class="sidebar-profile">
                   
                    <div class="profile-body dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><h4>'.$this->NombreUsuario.' '.$this->ApellidoUsuario.'  <span class="caret"></span></h4></a>
                        <small class="title">'.$tipoUsuario[0]['descripcion'].'</small>
                        <ul class="dropdown-menu animated fadeInRight" role="menu">
                            <li class="profile-progress">
                                <h5>
                                    <span>80%</span>
                                    <small>Profile complete</small>
                                </h5>
                                <div class="progress progress-xs">
                                    <div class="progress-bar progress-bar-primary" style="width: 80%">
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                           <li>
                                <a href="account.php">
                                    <span class="icon"><i class="fa fa-user"></i>
                                    </span>Mi cuenta</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="salir.php">
                                    <span class="icon"><i class="fa fa-sign-out"></i>
                                    </span>Salir</a>
                            </li>
                        </ul>
                    </div>
                </div>';
                
                return $html;
    }
    
    /**
     * crearHtml::crearMenu()  
     * @return Html con el contenido del menu, usa variable $menu
     * @author David Ardila
     * @version 1.0
     * @return
     */
    function crearMenu(){
        if($this->menu){
            $html = '<aside class="sidebar sidebar-left">';
            if($this->idUsuario && $this->barraUsuario)
                $html .= $this->barraProfile();
            
            $html .= '
                <nav>
                    <br>
                    <ul class="nav nav-pills nav-stacked">';
                     /** $html .= $this->menuEstandar();   
                        if( isset( $_SESSION['id_usuario'] ) )
                            $html .= $this->menuLogueado();
                        else
                            $html .= $this->menuUsuario();
                        
                        if( isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == '3' )
                            $html .= $this->menuAdmin();
                            
                        if( isset($_SESSION['tipo_usuario']) && ( $_SESSION['tipo_usuario'] == '3' || $_SESSION['tipo_usuario'] == '2' ) )
                            $html .= $this->menuProfesor();                                                    
                        */
                        $html .= $this->menuAdmin();
                            
                        
                $html .= '</ul>
                <br>
                </nav>
                
                
            </aside>';
            return $html;
        }
    }
    
    /**
     * crearHtml::crearMenu()
     * @return Html etiqueta <header> con el contenido previo cargado
     * @author David Ardila
     * @version 1.0
     */   
    /**
     * crearHtml::_header()
     * 
     * @return
     */
    function _header(){
        $html = ' <header id="header">
            <!--logo start--> 
            <div class="brand" align="center" style="padding-right: 120px;">
				<img src="'.$_SESSION["logo"] .'" width="90" height="90"/>                    								        
            </div>
            <!--logo end-->
             <!--logo start-->
            <div  align="center" style="position: absolute; float: right !important; padding-left: 170px;" class="col-md-6 col-md-offset-6 clearfix">
				<img src="./imagenes/polygraph-03.png" width="90" height="90"/>                    								        
            </div>
            <!--logo end-->
            <ul class="nav navbar-nav navbar-left">
                <li class="toggle-navigation toggle-left">
                    <button class="sidebar-toggle" id="toggle-left">
                        <i class="fa fa-bars"></i>
                    </button>
                </li>
                <li class="toggle-profile hidden-xs">
                    <button type="button" class="btn btn-default" id="toggle-profile">
                        <i class="icon-user"></i>
                    </button>
                </li>
                
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <!-- aqui estaba --!>
                 <li class="toggle-fullscreen hidden-xs">
                    <button type="button" class="btn btn-default expand" id="toggle-fullscreen">
                        <i class="fa fa-expand"></i>
                    </button>
                </li>
            </ul>
        </header>';
        
        return $html;
    }
    
    /**
     * crearHtml::_head()
     * 
     * @return
     */
    function _head(){
        $html = '

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>'.$this->titulo.'</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Fonts  -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/simple-line-icons.css">
    <!-- CSS Animate -->
    <link rel="stylesheet" href="assets/css/animate.css">
    
    <!-- Drop Zone-->
    <link rel="stylesheet" href="assets/plugins/dropzone/css/dropzone.css">
    <link rel="stylesheet" href="assets/plugins/dropzone/css/basic.css">
        
        <!-- DataTables-->
    <link rel="stylesheet" href="assets/plugins/dataTables/css/dataTables.css">
    <!-- Daterange Picker -->
    <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- Calendar demo -->
    <link rel="stylesheet" href="assets/css/clndr.css">
    
    
        <link rel="stylesheet" href="assets/plugins/icheck/css/all.css">
    
    <!-- Switchery -->
    <link rel="stylesheet" href="assets/plugins/switchery/switchery.min.css">
    <!-- Custom styles for this theme -->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- Feature detection -->
    <script src="assets/js/vendor/modernizr-2.6.2.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    
    <!--[if lt IE 9]>
    <script src="assets/js/vendor/html5shiv.js"></script>
    <script src="assets/js/vendor/respond.min.js"></script>

    <![endif]-->';
                    if(is_array($this->arrCss) && count($this->arrCss))
                        foreach($this->arrCss as $css)
                            $html.= '<link media="screen" rel="stylesheet" href="'.$css.'" type="text/css" />';
                    
                    if(is_array($this->arrJs) && count($this->arrJs))
                        foreach($this->arrJs as $js)
                            $html.= '<script src="'.$js.'"></script>';    
$html.= '</head>';
    return $html;
    }
    
    
    /**
     * crearHtml::itemFila()
     * @return Crea html con con el formato de <div>-label-span</div>
     * @param $label Contenido que llevara la etiqueta.
     * @param $input Input o contenido que estara en la etiqueta span 
     * @author David Ardila
     * @version 1.0
     */
    /**
     * crearHtml::itemFila()
     * 
     * @param mixed $descripcion
     * @param mixed $input
     * @param bool $class
     * @return
     */
    function itemFila($descripcion,$input,$class=false){
        $html = '<div class="'.$class.'"><label>'.$descripcion.'</label><span>'.$input.'</span></div>';
        return $html;
    }
    
    /**
    * Construye objeto tipo input  
    * @param String $type text,hidden,radio, textarea, checkbox
    * @param String $name propiedad
    * @param String $id propiedad
    * @param String $value propiedad
    * @param String $clase  propiedad class
    * @param String $style  propiedad style
    * @param String $complemento codigo adicional a ingresar al objeto
    * @return String html
    * @author David Ardila
    * @version 1.0     
    */
    /**
     * crearHtml::create_input()
     * 
     * @param mixed $type
     * @param mixed $name
     * @param mixed $id
     * @param bool $placeholder
     * @param bool $value
     * @param bool $clase
     * @param bool $style
     * @param bool $complemento
     * @return
     */
    function create_input($type, $name, $id, $placeholder = false,$value = false, $clase = false, $style = false ,$complemento = false){
        $_return = "";
        switch($type){
            case 'radio':
                $_return.="<input type='".$type."' name='".$name."' id='".$id."' value='".$value."' class='".$clase."' ";
            break;
            case 'checkbox':
                $_return.="<input type='".$type."' name='".$name."' id='".$id."' value='".$value."' class='".$clase."' ";
            break;
            case 'textarea':
                $_return.="<textarea name='".$name."' id='".$id."' class='".$clase."' ";
            break;
            default:                
                $_return.="<input type='".$type."' name='".$name."' id='".$id."' value='".$value."' class='".$clase."' placeholder='".$placeholder."' ";
            break;    
        }
        $_return.=( !empty($style) )? " style='".$style."' " : "";
        $_return.=( !empty($complemento) )? $complemento : "";
        switch($type){          
            case 'textarea':
                $_return.=">".$value." </textarea>";
            break;            
            default:                
                $_return.=" />";
            break;    
        }        
        return $_return;
    }    
    
    /**
     * addCss
    
    function enlazarCss(){
        if(is_array($this->arrCss) && count($this->arrCss)){
            $r = '';
            foreach($this->arrCss as $css){
                $r[] = '<link media="screen" rel="stylesheet" href="'.$css.'" type="text/css" />';
            }
        }
        return ;
        
    }
    */
    /**
     * crearHtml::Cabecera()
     * 
     * @return Html con el contenido de la cabecera.
     */
    /**
     * crearHtml::Cabecera()
     * 
     * @return
     */
    function Cabecera(){
        $html ='<!DOCTYPE html>
                    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
                    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
                    <!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
                    <!--[if gt IE 8]><!-->
                    <html class="no-js">
                    <!--<![endif]--> 
                    
                    ';
        $html .= $this->_head();
        $html .= '<section id="main-wrapper" class="theme-default sidebar-mini">';
        $html .= $this->_header();
        $html .= $this->crearMenu();
        $html .= '';
                    
        return $html;
    }

    /**
     * crearHtml::Pata()
     * 
     * @return Html con el contenido del pie de pagina.
     */    
    /**
     * crearHtml::Pata()
     * 
     * @return
     */
    function Pata(){
        $ckEdit = ($this->ckEditor) ? " var ckeditor = ".$this->ckEditor :  'var ckeditor = ""';
       $html = '
       </section>
            <!--/Config demo-->
    <!--Global JS-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="assets/plugins/navgoco/jquery.navgoco.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/fullscreen/jquery.fullscreen-min.js"></script>
    <script src="assets/js/src/app.js"></script>
    <script>
    var file = \''.$this->_file.'\';
    '.$ckEdit.'
    </script>
    <script src="assets/js/src/aplicativo.js"></script>
    <script src="assets/js/src/main.js"></script>
    <!--Page Level JS-->
    <script src="assets/plugins/countTo/jquery.countTo.js"></script>
    <script src="assets/plugins/weather/js/skycons.js"></script>
    
    <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
    
    <script src="assets/plugins/dataTables/js/jquery.dataTables.js"></script>
    <script src="assets/plugins/dataTables/js/dataTables.bootstrap.js"></script>
    <!-- ChartJS  -->
    <script src="assets/plugins/chartjs/Chart.min.js"></script>
    <!-- Morris  -->
    <script src="assets/plugins/morris/js/morris.min.js"></script>
    <script src="assets/plugins/morris/js/raphael.2.1.0.min.js"></script>
    
    <!-- Gauge  
    <script src="assets/plugins/gauge/gauge.min.js"></script>
    <script src="assets/plugins/gauge/gauge-demo.js"></script> -->
   
    <!-- Switch -->
    <script src="assets/plugins/switchery/switchery.min.js"></script>
    <!--Load these page level functions-->
    
    <script src="assets/plugins/dropzone/js/dropzone.min.js"></script>
    <script src="assets/plugins/icheck/js/icheck.min.js"></script>   
    <script src="assets/plugins/ckeditor/ckeditor.js"></script>
     
     
    <script>

    $(document).ready(function() {
    $(\'#tablaDatos\').dataTable();
        app.dateRangePicker();
        app.chartJs();
        app.weather();
        app.spinStart();
        app.spinStop();
        app.customCheckbox();
        ';
        
        if($this->ckEditor){
            $html .= 'CKEDITOR.replace(\''.$this->ckEditor.'\')';
        }

$html .='    });
    </script>';
       return $html;

    }
    
    /**
     * form_creation::serializeArray()
     * Decodifica objeto enviado desde javascript 
     * @param Object $a
     * @return Array
     */
    /**
     * crearHtml::serializeArray()
     * 
     * @param mixed $a
     * @return
     */
    public function serializeArray($a){
		$_array_return = array();
        $array_replace = array('['=>'',']'=>'');
		if( is_array($a) ){
			foreach($a as $c => $k){
				$_name = trim(strtolower($a[$c]['name']));
                $_value = trim($a[$c]['value']);
                $_pos = strpos($_name,'['); 
                if( $_pos !== false ){
                    $_cadena = strtr( substr($_name,$_pos) , $array_replace );
                    $_name = substr($_name,0,$_pos);
                    if( isset($_array_return[$_name][$_cadena])){					
    					if( is_array($_array_return[$_name][$_cadena]) )
    						$_array_return[$_name][$_cadena][$_value]=true;
    					else{
    						$_tmp = $_array_return[$_name][$_cadena];
    						$_array_return[$_name][$_cadena]=array($_tmp => true, $_value => true);
    					}
    				}
    				else
    					$_array_return[$_name][$_cadena] =  $_value;
                         
                }else{
    				if( isset($_array_return[$_name])){					
    					if( is_array($_array_return[$_name]) )
    						$_array_return[$_name][$_value]=true;
    					else{
    						$_tmp = $_array_return[$_name];
    						$_array_return[$_name]=array($_tmp => true, $_value => true);
    					}
    				}
    				else
    					$_array_return[$_name] =  $_value;   
                }
			}
		}		
		return $_array_return;
	}             
 
    function keyToVal($array){
        $newArray = array();
        if(is_array($array)){
            foreach($array as $k=>$v){
                $newArray[] = $k;   
            }
        }else{
            return $array;
        }
        return $newArray;
    }
 
    /**
     * form_creation::print_table()
     * Genera html en base a un array
     * @param String $array arreglo 
     * @param Numeric $columnas numero de columnas que posee el arreglo
     * @param Boolean $paginar True = paginacion, False = no 
     * @param String  $complemento style, class, action
     * @return String html
     */
    function print_table($array,$columnas,$paginar = false,$_class="", $complemento = "", $arrayPropiedades = array() ){
        $_return = '';
        $limiteCab = ( isset($arrayPropiedades['limiteCabecera']) )?$arrayPropiedades['limiteCabecera']:0;
        if( is_array($array) ){
//            if($paginar){
//                if(!empty($_class)){
//                    $_class.=' '.$this->class_table_pag;
//                }
//                else 
//                    $_class=$this->class_table_pag;
//            }
                
            $_return.="<table border='0' width='100%' ".$complemento." class='".$_class."' >";
            $_fila = 0;
                foreach($array as $c => $k){
                    $_etiqueta = 'td';
                    if($paginar){
                        if($_fila == 0){
                            $_return.="<thead>";
                            if( isset($arrayPropiedades['complementoHead']) ){
                                $_return.=$arrayPropiedades['complementoHead'];
                            }
                            $_etiqueta = 'th';
                        }else if($_fila <=  $limiteCab ){
                            $_etiqueta = 'th';                       
                        }else if($_fila == $limiteCab ){
                            $_return.="<tbody>";
                        }
                    }
                    $_return.="<tr>";
                        if( is_array($k) ){
                            if( count($k)==1 ){
								$_linea = 1;
                                foreach($k as $c1 => $k1){
									$_return.="<".$_etiqueta." colspan='".$columnas."' >".$k1."</".$_etiqueta.">";
                                    $_linea++;
                                }     								
							}
                            else{
                                $_linea = 1;
                                foreach($k as $c1 => $k1){
                                    if( !isset($k[$_linea+1]) && count($k) == $_linea )
                                        $_return.="<".$_etiqueta." colspan='".($columnas-$_linea+1)."' nowrap>".$k1."</".$_etiqueta.">";
                                    else
                                        $_return.="<".$_etiqueta." nowrap>".$k1."</".$_etiqueta.">";
                                    $_linea++;
                                }                                    
                            }
                        }
                    $_return.="</tr>";
                    
                    if($paginar){
                        if($_fila == $limiteCab){
                            $_return.="</thead>";
                        }
                    }
                    $_fila++;
                }
            if($paginar){
                $_return.="</body>";
            }
            $_return.="</table>";
        }
        return $_return;
    }
  
	/**
     * form_creation::print_table_plain()
     * Genera html en base a un array Csv
     * @param String $array arreglo 
     * @return String html
     */
    function print_table_plain($array){
        $_return = '';
        if( is_array($array) ){
            $_fila = 0;
			foreach($array as $c => $k){
				if( is_array($k) ){
					foreach($k as $c1 => $k1){
						$_return.=$k1."|";
					}     													
				}
				$_return.="\n";
				$_fila++;
			}
        }
        return $_return;
    }  
  
  
    /**
     * crearHtml::generateHead()
     * 
     * @param mixed $_array
     * @return
     */
    function generateHead($_array){
        $_array_formu = array();
        if( isset($_array[0]) && is_array($_array[0]) ){
            foreach($_array[0] as $c => $k){
                $_array_formu[0][] = STRTOUPPER($c) ;
            }
        }
        return $_array_formu = array_merge($_array_formu, $_array);
    }
    
    /**
     * crearHtml::Imagenes()
     * 
     * @param mixed $Campo identificador por el cual tomara la acci&oacute;n de eliminar o actualizar un registro
     * @param integer $Accion Enviar 0 (Editar) 1(Eliminar) default:0
     * @return
     */
    function Imagenes($Campo, $Accion = 0,$formulario='formCrear'){
        switch( $Accion ){
            case 0:
                return <<<OE
                CONCAT(  '<div class="fa fa-edit" style="cursor:pointer" title="Editar" ONCLICK=javascript:fn_editar(',  `$Campo` ,  ',\'{$this->_file}\'); />' ) Editar
OE;
             break;
            case 1:
                 return <<<OE
                CONCAT(  '<div class="icon-ban" style="cursor:pointer" title="Inactivar" ONCLICK=javascript:fn_eliminar(',  `$Campo` ,  ',\'{$this->_file}\',\'{$formulario}\'); />' ) Eliminar
OE;
            break;
            case 2:
                return <<<OE
                CONCAT(  '<div class="fa fa-file-pdf-o" style="cursor:pointer" title="Descargar Autorizacion" ONCLICK=javascript:fn_generar(',  `$Campo` ,  ',\'{$this->_file}\',\'{$formulario}\'); />' ) PDF
OE;
                break;
            case 3:
                return <<<OE
                CONCAT(  '<div class="icon-ban" style="cursor:pointer"   />' ) SECCIONES
OE;
                break;
            case 4:
                return <<<OE
                CONCAT(  '<div class="fa fa-file-pdf-o" style="cursor:pointer" title="Generar Carta de Lubricacion" ONCLICK=javascript:fn_generar_carta_equipo(',  `$Campo` ,  ',\'{$this->_file}\',\'{$formulario}\'); />' ) Generar_Carta
OE;
                break;
            case 5:
                return <<<OE
                CONCAT(  '<div  style="cursor:pointer" id="combo_id_secciones"></div>' ) EQUIPOS
OE;
                break;
            case 6:
                return <<<OE
                CONCAT('<a class="thumbnail" href="#thumb"><img src="',im.description,im.FILE,'" width="50" height="50" /><span><img src="',im.description,im.FILE,'" class="imgderecha" /></span></a>') imagen
OE;
                break;
            case 7:
                if(	$_SESSION["tipo_usuario"]==3){
                return <<<OE
                CONCAT(  '<div class="fa fa-edit" style="cursor:pointer" title="Editar"  />' ) Editar
OE;
                }else{
                    return <<<OE
                CONCAT(  '<div class="fa fa-edit" style="cursor:pointer" title="Editar" ONCLICK=javascript:fn_editar(', t.`$Campo` ,  ',\'{$this->_file}\'); />' ) Editar
OE;
                }
                break;
            case 8:
                if(	$_SESSION["tipo_usuario"]==3){
                return <<<OE
                CONCAT(  '<div class="icon-ban" style="cursor:pointer" title="Inactivar"  />' ) Eliminar
OE;
                }else{
                    return <<<OE
                CONCAT(  '<div class="icon-ban" style="cursor:pointer" title="Inactivar" ONCLICK=javascript:fn_eliminar(',  t.`$Campo` ,  ',\'{$this->_file}\',\'{$formulario}\'); />' ) Eliminar
OE;
                }
                break;
            case 9:
                return <<<OE
                CONCAT('<a class="thumbnail" href="#thumb"><img src="',s.ruta,s.descripcion,'" width="50" height="50" /><span><img src="',s.ruta,s.descripcion,'" class="imgderecha" /></span></a>') imagen
OE;
                break;
            case 10:
                return <<<OE
                CONCAT(  '<div class="fa fa-reorder" style="cursor:pointer" title="Ver Programacion" ONCLICK=javascript:irProgramacion(',  `$this->PrimaryKey` ,  '); />' ) Ver_Programacion
OE;
            case 11:
                return <<<OE
                CONCAT(  '<div class="icon-ban" style="cursor:pointer"   />' ) TIPOUSUARIO
OE;
                break;
            case 12:
                return <<<OE
                CONCAT('<a class="thumbnail" href="#thumb"><img src="',L.logo,'" width="100" height="100" /><span></span></a>') LOGO
OE;
                break;
            case 13:
                return <<<OE
                CONCAT('<a class="thumbnail" href="#thumb"><img src="',e.LOGO2,'" width="100" height="100" /><span></span></a>') Logo_cliente
OE;
                break;
            case 14:
                return <<<OE
                CASE
                    WHEN ea.id_estados = 1 THEN CONCAT('<button type="button" id="guardarreagenda"   ONCLICK=javascript:fn_reagendar(',  `$Campo` ,  ',\'{$this->_file}\'); class="btn btn-success">REAGENDAR</button>' )
                    WHEN ea.id_estados = 2 THEN CONCAT('<button type="button" id="guardarreagenda"  ONCLICK=javascript:fn_reagendar(',  `$Campo` ,  ',\'{$this->_file}\'); class="btn btn-success">REAGENDAR</button>' )
                    WHEN ea.id_estados = 8 THEN CONCAT('<button type="button" id="guardarreagenda"  ONCLICK=javascript:fn_reagendar(',  `$Campo` ,  ',\'{$this->_file}\'); class="btn btn-success">REAGENDAR</button>' )
                    WHEN ea.id_estados IN (4,5,6,7) THEN " "
                END AGENDAR
OE;
                break;
            default:
                return "";
            break;
        }        
    }    
    /**
     * crearHtml::getEstados()
     * retorna arreglo con las opciones de Activo,Inactivo
     * @return array()
     */
     public function getEstados(){
        $_array = array();
        array_push($_array, array( 'codigo' => '1', 'descripcion' => 'SI') );
        array_push($_array, array( 'codigo' => '0', 'descripcion' => 'NO') );
        return $_array;
    }


     /**
      * crearHtml::getGenero()
      * 
      * @return
      
     public function getGenero(){
        $_array = array();
        array_push($_array, array( 'CODIGO' => '1', 'DESC' => 'FEMENINO') );
        array_push($_array, array( 'CODIGO' => '0', 'DESC' => 'MASCULINO') );
        return $_array;
    }
*/
    /**
     * crearHtml::getColumnsTable()
     * 
     * @param mixed $Param
     * @return
     */
    function getColumnsTable( $Param = array() ){
        $ArrayColumns  = $this->getMetadaData($this->Table,'Columns');
        if( !sizeof($ArrayColumns) )
            throw new Exception("Tabla no existe!");
        if( is_array($ArrayColumns) ){
            foreach($ArrayColumns as $Field ){
                if( isset($Param['FIELDS']) && is_array($Param['FIELDS']) && sizeOf($Param['FIELDS']) ){
                    if( in_array($Field['COLUMN_NAME'],$Param['FIELDS']) )
                        $ArrayFields[$Field['COLUMN_NAME']] = $Field['COLUMN_NAME'];
                }else{
                    $ArrayFields[$Field['COLUMN_NAME']] = $Field['COLUMN_NAME'];   
                }
            }
        }
        return $ArrayFields;
    }
    
/**
 * crearHtml::save()
 * 
 * @param mixed $Data
 * @param mixed $Parametros
 * @return
 */
function save($Data = array(), $Parametros = array() ){        
        if( !IS_ARRAY($Data)  OR !SIZEOF($Data) )
            throw new Exception("Campos requeridos!");
        //$this->ArrayData[ STRTOUPPER($this->PrimaryKey) ] = 0;
        foreach($Data as $c => $k){
            if( !is_array($c) && !is_object($c) && !is_array($k) && !is_object($k) )
                $this->ArrayData[ $c ] = $k;
        }
        $New = false;
        if( !isset($this->ArrayData[ $this->PrimaryKey ]) )
            $New = true;
        else{
            $sql="SELECT count(1) as CONTAR FROM {$this->Table} WHERE {$this->PrimaryKey} = '".$this->ArrayData[ $this->PrimaryKey ]."' ";
            $datos = $this->Consulta( $sql );
            if( $datos[0]['CONTAR'] == 0 )
                $New = true;                                         
        }
        
        $this->ArrayColumns  = $this->getMetadaData($this->Table,'Columns');        
        if( !sizeof($this->ArrayColumns) )
            throw new Exception("Tabla no existe!");
        if( is_array($this->ArrayColumns) ){
            foreach($this->ArrayColumns as $Field ){
                if( isset($this->ArrayData[$Field['COLUMN_NAME']]) ){
                    $this->ArrayFields[$Field['COLUMN_NAME']] = $Field['COLUMN_NAME'];
                    $this->ArrayValues[$Field['COLUMN_NAME']] = "'{$this->ArrayData[$Field['COLUMN_NAME']]}'";
                    $this->ArrayUpdates[$Field['COLUMN_NAME']] = " {$Field['COLUMN_NAME']} =  '".$this->ArrayData[$Field['COLUMN_NAME']]."' ";
                    
                    switch( $Field['DATA_TYPE'] ){
                        case 'int':
                            if( !isset($this->ArrayData[$Field['COLUMN_NAME']]) or !is_numeric($this->ArrayData[$Field['COLUMN_NAME']]) )
                                throw new Exception("Campo {$Field['COLUMN_NAME']} es numerico!");
                        break;
                    }
                    if( isset($this->ArrayData[$Field['COLUMN_NAME']]) ){
                        if( $Field['DATA_LENGTH'] !='' && ( strlen($this->ArrayData[$Field['COLUMN_NAME']]) > $Field['DATA_LENGTH'] ) )
                            throw new Exception("Valor del {$Field['COLUMN_NAME']} superior a maximo {$Field['DATA_LENGTH']}!");
                    
                        if( in_array($this->ArrayData[$Field['COLUMN_NAME']],$this->ValuesReserved) ){
                            $this->ArrayValues[$Field['COLUMN_NAME']] = $this->ArrayData[$Field['COLUMN_NAME']];
                            $this->ArrayUpdates[$Field['COLUMN_NAME']] = " {$Field['COLUMN_NAME']} =  ".$this->ArrayData[$Field['COLUMN_NAME']];
                        }
                    }
                        
                }
            }
        }
        if( $New ){
           // if( !empty($this->Sequence) )
//                $this->ArrayValues[$this->PrimaryKey] = "{$this->Sequence}.NEXTVAL";
            $Query = "INSERT INTO {$this->Table} (".implode(',',$this->ArrayFields).")VALUES(".implode(',',$this->ArrayValues).")";
        }else{
            $Query = "UPDATE {$this->Table} SET ".implode(',',$this->ArrayUpdates)." WHERE {$this->PrimaryKey} = '".$this->ArrayData[ $this->PrimaryKey ]."' ";
        }      
        $this->QuerySql( $Query );
        
}    

function guardar_imagen($tabla,$equipo,$file,$ruta){
    
        $New = false;
        $sql="SELECT count(1) as CONTAR FROM $tabla WHERE file = '".$file."' and id_equipos='".$equipo."'";
        $datos = $this->Consulta( $sql );
        if( $datos[0]['CONTAR'] == 0 ){
            $New = true;
            if( $New ){
                
                $Query = "INSERT INTO $tabla (description,file,id_equipos) VALUES ('".$ruta."','".$file."',$equipo)";
            }
            try{
                $_respuesta = "El archivo $file se ha almacenado de forma exitosa.<br>";
                $this->QuerySql( $Query );
                $Query2="DELETE FROM $tabla WHERE file='' AND  description=''";
                $this->QuerySql( $Query2 );
            }catch(Exception $e){
                $_respuesta =  $e->getMessage();
            }
        }else{
            $_respuesta = "Imagen $file ya Existe Verificar.<br>";
        }
        return $_respuesta;
        
    }  
    function guardar_imagen_empresa($tabla,$equipo,$nombre,$tipo,$ubicacion,$file,$ruta,$file2){
        
     
                 
        $Query = "UPDATE $tabla SET NOMBRE='".$nombre."', TIPOACTIVIDAD='".$tipo."',ubicacion='".$ubicacion."' ";
        if($file<>'' && $file2<>''){
            $Query.= ",LOGO='".$ruta.$file."',LOGO2='".$ruta.$file2."' ";
        }elseif($file<>'' && $file2==''){
            $Query.= ",LOGO='".$ruta.$file."' ";
        }elseif($file=='' && $file2<>''){
            $Query.= ",LOGO2='".$ruta.$file2."' ";
        }
        $Query.= " WHERE id_empresa='".$equipo."' ";
       
        try{
            $_respuesta = "El archivo $file se ha almacenado de forma exitosa.<br>";
            $this->QuerySql( $Query );
           
        }catch(Exception $e){
            $_respuesta =  $e->getMessage();
        }
       
        return $_respuesta;
        
    }  
    
    function sacar_empresa(){
        
        $New = false;
        $sql="SELECT upper(empresa) as EMPRESA FROM parametros where ruta='".$_SESSION['bdatos']."'";
        $datos = $this->Consulta( $sql );
        
        return $datos[0]['EMPRESA'];
    }

   /**
    * crearHtml::getMetadaData()
    * 
    * @param string $Tabla
    * @param string $Opcion
    * @return
    */
   function getMetadaData($Tabla = '', $Opcion = ''){
        if( empty($Tabla) or empty($Opcion) )
            throw new Exception("Tabla y opcione requirido!");
        switch($Opcion){
            case 'Columns':
                $Sql = "SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH AS DATA_LENGTH, COLUMN_DEFAULT AS DATA_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name =  '{$Tabla}'
AND table_schema =  '{$this->Esquema}'";
                //$Sql="SELECT COLUMN_NAME,DATA_TYPE,DATA_LENGTH, DATA_DEFAULT FROM ALL_TAB_COLUMNS WHERE TABLE_NAME = '{$Tabla}' AND OWNER = '{$this->Esquema}' ORDER BY COLUMN_ID";
                $datos = $this->Consulta( $Sql);
                return  $datos;
            break;
        }
    }

    /**
     * crearHtml::runActualizar()
     * 
     * @return
     */
    public function runActualizar()
    {
        $_respuesta = array('Codigo' => 0, "Mensaje" => $this->MensajeActualizacion);
        try {            
            $this->save($this->_datos);
        }
        catch (exception $e) {
            $_respuesta = array('Codigo' => 99, "Mensaje" => $e->getMessage());
        }
        print_r(json_encode($_respuesta));
    }
    
/**
 * crearHtml::tablaCheckbox()
 * 
 * @param mixed $ArrayValores
 * @param mixed $Nombre
 * @param mixed $Id
 * @return
 */
function tablaCheckbox($ArrayValores,$Nombre,$Id){
			
	$contador = 1;
	if(is_array($ArrayValores) && count($ArrayValores)>0){
		$Check = "<table width='100%' border='0'>";
		$propiedad = '';
		foreach($ArrayValores as $Indice => $Valor){
			$propiedad = '';
	 		if($contador == 1){ 
				$Check .= "<tr bgcolor='#F4F4F4'>";
			}					
		
        	$Check .= "<td class='txt2'> <label>";
			$Check .= "<input class='required ".$Nombre."' title='".$Valor['descripcion']."' id='".$Id."' type='checkbox' name='".$Nombre."' value='".$Valor['codigo']."' ".$propiedad." />";
			
				$Check .= "<b>[".$Valor['descripcion']."]</b>";
				$cons = 4;
			
			?>
			
			<?php
			$Check .= "</label></td>";
			
			if($contador == $cons){
				$contador = 1; 
				$Check .= "</tr>";
			}else{ 
				$contador = $contador + 1;  
			}	
		}
		if($contador<$cons){
			for($i=$contador;$i<=$cons;$i++){
				$Check .= "<td>&nbsp;&nbsp;</td>";		
			}
			$Check .= "</tr>";
		}
		$Check .= "<tr><td class='txt1' colspan='".($cons)."'>";
		$Check .= "<label><input type='checkbox' name='chk_all'  id='chk_".$Nombre."' class='".$Nombre."' value='".$Nombre."' onclick='SelectAll(this.value,this.checked)' />";
		$Check .= "<b>Seleccionar Todos...</b></label>";
		$Check .= "</td></tr>"; 
		$Check .= "</table>";
		
		return $Check;		
	   }
    }
    
    function Imprimir($Array)
    {
        echo "<pre>";
        print_r($Array);
        echo "</pre>";
    }
    
    function HTMLToText($Texto)
    {
        $Texto = str_replace("\n","",$Texto);
        while (str_replace("  "," ",$Texto)!=$Texto) { $Texto = str_replace("  "," ",$Texto); }
        $Texto = str_replace("&nbsp;"," ",$Texto);
        $Texto = str_replace("<br>","\n",$Texto);
        $Texto = str_replace("&aacute;","Ã¡",$Texto);
        $Texto = str_replace("&eacute;","Ã©",$Texto);
        $Texto = str_replace("&iacute;","Ã­",$Texto);
        $Texto = str_replace("&oacute;","Ã³",$Texto);
        $Texto = str_replace("&uacute;","Ãº",$Texto);
        $Texto = str_replace("&lt;","<",$Texto);
        $Texto = str_replace("&gt;",">",$Texto);
        $Texto = str_replace("&iquest;","Â¿",$Texto);
        $Texto = str_replace("&Ntilde;","Ã‘",$Texto);
        $Texto = str_replace("&ntilde;","Ã±",$Texto);
        return $Texto;
    }
    
    function EnviarSms($celular,$fecha,$hora){
        
        $query = http_build_query(array(
            'key' => '901aa18b42da8c55f02bfa16bb72269db58ad6955ea7a4cda6790',
            'client' => '1174',
            'phone' => $celular,
            'sms' => 'SAIPolygraph,Agendo Cita para el dia '.$fecha.'-'.$hora.' Prueba Preempleo, presentarse 10min antes, direccion Av18E #19AN-36 Niza(Cucuta N.S)',
            'country-code' => 'CO'
        ));
        //$this->imprimir($query);
     /*
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.onurix.com/api/v1/send-sms",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST  => 1,
            CURLOPT_POSTFIELDS => $query,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));
      
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
      */  
        $err=TRUE;
        if ($err) {
            return  "cURL Error #:" . $err;
        } else {
            return  'Se envio SMS al celular'.PHP_EOL;
        }
    }
    
    function EnviarCorreo($fullname, $clienteterce, $solicitud, $fecha, $hora ){
      
        $sql = "SELECT upper(empresas.NOMBRE) as NOMBRE
                        FROM
                        empresas
                        Inner Join aliados ON aliados.id_aliado = empresas.id_aliado
                        WHERE empresas.id_empresa=".$clienteterce;
        $clienteterce = $this->Consulta($sql);
        $clienteterce=$clienteterce[0]['NOMBRE'];
        
       $html='
<html><meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
  <head>
    <style type="text/css">
      ReadMsgBody{ width: 100%;}
      .ExternalClass {width: 100%;}
      .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
      body {-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;margin:0 !important;}
      p { margin: 1em 0;}
      table td { border-collapse: collapse;}
      img {outline:0;}
      a img {border:none;}
      p {margin: 1em 0;}
      @-ms-viewport{ width: device-width;}
    .Estilo1 {
	font-size: 19px;
	color: #00aec7;
}
</style><!--[if mso]>       <style type="text/css">           /* Begin Outlook Font Fix */           body, table, td {               font-family: Arial, Helvetica, sans-serif ;               font-size:16px;               color:#808080;               line-height:1;           }           /* End Outlook Font Fix */       </style>     <![endif]-->
  </head>
  <body bgcolor="#efefef" text="#808080" style="background-color: #efefef; color: #808080; margin: 0px; padding: 20px; -webkit-text-size-adjust:none; line-height: normal; font-size: 16px; font-family:arial,helvetica,sans-serif;"><style type="text/css">
div.preheader 
{ display: none !important; } 
</style>   
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td align="center" valign="top">
          
        </td>
      </tr>
      <tr>
        <td align="center">
          <table cellspacing="0" cellpadding="0" border="0" width="600" class="container" align="center">
            <tr>
              <td>
                <!-- added the border style here -->
                <table class="tb_properties border_style" cellspacing="0" cellpadding="0" bgcolor="#ffffff" width="100%">
                  <!-- end of comment -->
                  <tr>
                    <td align="center" valign="top">
                      <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                          <!-- added padding here -->
                          <td class="content_padding" style="padding:10px;border:0px;">
                            <!-- end of comment -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td align="left" class="header" valign="top">
                                  <table cellpadding="0" cellspacing="0" width="100%" style="border-bottom: 1px solid #AEAEAE; min-width: 100%; " class="slot-styling"><tr>
                                    <td class="slot-styling camarker-inner"><!---->
                                    <!---->
                                        <!---->
                                        <!----></td>
                                  </tr></table>
                                  
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="" valign="top">
                                  <table cellpadding="0" cellspacing="0" width="100%" style="border-bottom: 1px solid #AEAEAE; min-width: 100%; " class="slot-styling"><tr><td style="padding-top: 10px; padding-bottom: 10px; " class="slot-styling camarker-inner"><!----><table cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img data-assetid="168313" src="http://saipolygraph.com/polygraph/img/agent-scorecard.png" width="600" style="display: block; padding: 0px; text-align: center; height: auto; width: 100%; border: 0px;"></td></tr></table></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: transparent; min-width: 100%; " class="stylingblock-content-wrapper"><tr>
<td style="padding: 15px 25px; " class="stylingblock-content-wrapper camarker-inner" align="center"><span style="color:#0033a0;"><i><span style="font-size:21px;"><span style="font-family:Arial,Helvetica,sans-serif;" ><b>Hola ¡'.$fullname.'!
<br/>
La empresa <span style="color:#b30707;"> '.$clienteterce.' </span>
<br/>
SOLICITA PRACTICARLE PRUEBA DE POLIGRAFO 


<br/><br/>
Solicitud No. '.$solicitud.'

</b></span></span></i></span><br>
<br>
<span style="font-size:17px;"><span style="font-family:Arial,Helvetica,sans-serif;">Queremos informarle que la empresa '.$clienteterce.', solicit&oacute; practicarle una prueba de Pol&iacute;grafo. Le invitamos a presentarse el pr&oacute;ximo '.$fecha.' a las '.$hora.', en la direcci&oacute;n: Av18E # 19AN-36 Niza (C&uacute;cuta N.S).</span></span></td>
                                  </tr></table><!----><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #00AEC7; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 15px 25px; " class="stylingblock-content-wrapper camarker-inner"><span style="color:#ffffff;"><span style="font-size:20px;"><i><b>Recomendaciones para la prueba de POLIGRAFO:</b></i></span></span></td></tr></table>
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 10px solid #F2F2F2; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 10px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" style="width: 20%; padding-right: 0px;"><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: transparent; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 3px 0px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img data-assetid="168306" src="http://saipolygraph.com/polygraph/img/personas.png" height="82" width="85" style="display: block; padding: 0px; text-align: center; height: 62px; width: 65px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" style="width: 80%; padding-left: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr>
  <td style="padding: 15px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><p><span style="color:#00aec7;"><b><span style="font-size:19px;">Presente su cédula de ciudadanía original.</span></b></span></p></td>
</tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 0px 5px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr>
</tr></table></td></tr></table><!---->
</td></tr></table></td></tr></table></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 10px solid #F2F2F2; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: transparent; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 3px 0px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><br/>
<img data-assetid="168309" src="http://saipolygraph.com/polygraph/img/durmiendo.png" height="82" width="85" style="display: block; padding: 0px; text-align: center; height: 62px; width: 65px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" style="width: 80%; padding-left: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 23px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><font color="#00aec7"><span style="font-size: 19px;"><b>Descanse muy bien la noche anterior, m&iacute;nimo 6 horas, procure no trasnochar.</b></span></font></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr>
<td style="padding: 0px 0px 5px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr>
</tr></table></td></tr></table><!----></td></tr></table></td></tr></table></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 10px solid #F2F2F2; min-width: 100%; " class="stylingblock-content-wrapper"><tr>
<td style="padding: 0px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: transparent; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 3px 0px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img data-assetid="168318" src="http://saipolygraph.com/polygraph/img/reloj.png" height="84" width="85" style="display: block; padding: 0px; text-align: center; height: 84px; width: 85px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" style="width: 80%; padding-left: 0px;"><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 18px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><span style="color:#00aec7;"><span style="font-size:18px;"><b>Pres&eacute;ntese en el lugar indicado con 20 minutos antes de la hora agendada. Disponga de dos horas (2) para la realizaci&oacute;n de la prueba.</b></span></span></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 0px 5px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr>
</tr></table></td></tr></table><!----></td></tr></table></td></tr></table></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 10px solid #F2F2F2; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" align="center" cellspacing="0" width="100%" style="background-color: transparent; min-width: 100%; " class="stylingblock-content-wrapper">
<tr><td style="padding: 3px 0px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><br/><img data-assetid="168308" src="http://saipolygraph.com/polygraph/img/medicamento.png" height="62" width="65" style="display: block; padding: 0px; text-align: center; height: 62px; width: 65px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" style="width: 80%; padding-left: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 15px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><span style="color:#00aec7;"><span style="font-size:18px;"><b>Consuma los medicamentos prescritos por su médico de manera habitual (en los casos que aplique).</b></span></span></td></tr></table><!----><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 0px 5px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr>
</tr></table></td></tr></table><!----></td></tr></table></td></tr></table></td></tr></table><!----><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 10px solid #F2F2F2; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: transparent; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 3px 0px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><br/>
<img data-assetid="168307" src="http://saipolygraph.com/polygraph/img/Alcohol.png" height="82" width="85" style="display: block; padding: 0px; text-align: center; height: 62px; width: 75px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" style="width: 80%; padding-left: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 23px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><span style="color:#00aec7;"><span style="font-size:18px;"><b>No consuma bebidas alcohólicas, sustancias alucinógenas, antidepresivos o energizantes 24 horas antes de la prueba.</b></span></span></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr>
  
</tr></table><!----></td></tr></table></td></tr></table></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 10px solid #F2F2F2; min-width: 100%; " class="stylingblock-content-wrapper"><tr>
<td style="padding: 0px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: transparent; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 3px 0px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img data-assetid="168310" src="http://saipolygraph.com/polygraph/img/comida.png" height="82" width="85" style="display: block; padding: 0px; text-align: center; height: 82px; width: 85px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" style="width: 80%; padding-left: 0px;"><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 15px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><span style="color:#00aec7;"><span style="font-size:18px;"><b>Desayune y/o almuerce bien de manera previa (según la hora de su cita).</b></span></span></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr>
 
</tr></table><!----></td></tr></table></td></tr></table></td></tr></table><!----><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 10px solid #F2F2F2; min-width: 100%; " class="stylingblock-content-wrapper"><tr>
<td style="padding: 0px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: transparent; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 3px 0px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img data-assetid="168310" src="http://saipolygraph.com/polygraph/img/adulto.png" height="82" width="85" style="display: block; padding: 0px; text-align: center; height: 82px; width: 85px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" style="width: 80%; padding-left: 0px;"><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 15px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><span style="color:#00aec7;"><span style="font-size:18px;"><b>Tome en cuenta que no se permiten acompa&ntilde;antes, especialmente menores de edad ni adultos mayores.</b></span></span></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr>
  
</tr></table><!----></td></tr></table></td></tr></table></td></tr></table>


<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 10px solid #F2F2F2; min-width: 100%; " class="stylingblock-content-wrapper"><tr>
<td style="padding: 0px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: transparent; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 3px 0px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img data-assetid="168310" src="http://saipolygraph.com/polygraph/img/lluvia.jpg" height="82" width="85" style="display: block; padding: 0px; text-align: center; height: 82px; width: 85px; border: 0px;"></td>
</tr></table></td></tr></table><!----></td><td valign="top" style="width: 80%; padding-left: 0px;"><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 15px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><span style="color:#00aec7;"><span style="font-size:18px;"><b><br/>En caso de lluvia evite presentarse mojado.</b></span></span></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr>

</tr></table><!----></td></tr></table></td></tr></table></td></tr></table>

<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #00AEC7; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 15px 25px; " class="stylingblock-content-wrapper camarker-inner"><span style="color:#ffffff;"><span style="font-size:20px;"><i><b>Excepciones para la prueba de POLIGRAFO:</b></i></span></span></td></tr></table>
<!---->
<!---->
<!---->
<!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 0px; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 10px 2px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" class="responsive-td" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: transparent; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 8px 0px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0">
<tr><td align="center"><img data-assetid="168349" src="http://saipolygraph.com/polygraph/img/embarazada.jpg" height="72" width="74" style="display: block; padding: 0px; text-align: center; height: 72px; width: 74px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" class="responsive-td" style="width: 80%; padding-left: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 9px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><span style="font-size:17px;"><span style="color:#0033a0;"><br/>Mujeres en Gestaci&oacute;n (Embarazo).</span>
</span></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 0px 10px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr>
</tr></table></td></tr></table><!----></td></tr></table></td></tr></table></td></tr></table><!----><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 7px 25px 15px; " class="stylingblock-content-wrapper camarker-inner"><span style="color:#00aec7;"><span style="font-size: 20px;"><b><i>Personas     que    presenten alguna de las siguientes condiciones de salud</i></b></span></span></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 0px; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 10px 2px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" class="responsive-td" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr>
<td class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img data-assetid="162606" src="http://saipolygraph.com/polygraph/img/corazon.jpg" height="77" width="99" style="display: block; padding: 0px; text-align: center; height: 77px; width: 99px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" class="responsive-td" style="width: 80%; padding-left: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 15px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><span style="font-size:17px;"><span style="color:#0033a0;">Enfermedad Cardiovascular como marcapasos o cirug&iacute;a a coraz&oacute;n abierto.</span></span></td></tr></table><!----><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 0px 10px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr>
</tr></table></td></tr></table><!----></td></tr></table></td></tr></table></td></tr></table><!----><!---->
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 0px; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 10px 2px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td valign="top" class="responsive-td" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img data-assetid="167171" src="http://saipolygraph.com/polygraph/img/enfermo.jpg" height="96" width="99" style="display: block; padding: 0px; text-align: center; height: 96px; width: 99px; border: 0px;">
</td></tr></table></td></tr></table><!----></td><td valign="top" class="responsive-td" style="width: 80%; padding-left: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 15px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner"><span style="font-size:17px;"><span style="color:#0033a0;">Episodios gripales fuertes (fiebre, congesti&oacute;n nasal severa y/o sintomatolog&iacute;a Covid 19).</span></span></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 0px 10px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr>
</tr></table></td></tr></table><!----></td></tr></table></td></tr></table></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border: 0px; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 10px 2px; " class="stylingblock-content-wrapper camarker-inner"><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr>
<td valign="top" class="responsive-td" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img data-assetid="168311" src="http://saipolygraph.com/polygraph/img/sentado.jpg" height="96" width="99" style="display: block; padding: 0px; text-align: center; height: 96px; width: 99px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" class="responsive-td" style="width: 80%; padding-left: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 15px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner">
<span style="font-size:17px;"><span style="color:#0033a0;">Que no puedan permanecer sentadas por lo menos durante 2 horas de forma continua.</span></span></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 0px 10px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr>
</tr></table></td>
</tr></table><!----></td></tr></table></td></tr></table><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr><td><table cellspacing="0" cellpadding="0" style="width: 100%;"><tr>
<td valign="top" class="responsive-td" style="width: 20%; padding-right: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img data-assetid="168311" src="http://saipolygraph.com/polygraph/img/epilepsia.png" height="96" width="99" style="display: block; padding: 0px; text-align: center; height: 66px; width: 69px; border: 0px;"></td></tr></table></td></tr></table><!----></td><td valign="top" class="responsive-td" style="width: 80%; padding-left: 0px;"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 15px 20px 10px 10px; " class="stylingblock-content-wrapper camarker-inner">
<span style="font-size:17px;"><span style="color:#0033a0;">Diagn&oacute;stico de Epilepsia.</span></span></td></tr></table><!----><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 0px 0px 10px; " class="stylingblock-content-wrapper camarker-inner"><table width="100%" cellspacing="0" cellpadding="0"><tr>
</tr></table></td>
</tr></table><!----></td></tr></table></td></tr></table></td></tr></table>
<!---->
<!---->
<!---->
<!---->
<!---->
<!----><!---->
<!---->
<!---->
<!---->
<!----></td>
                                  </tr></table>
                                  
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="" valign="top">
                                  <table cellpadding="0" cellspacing="0" width="100%" style="border-bottom: 1px solid #AEAEAE; min-width: 100%; " class="slot-styling"><tr><td style="padding-top: 10px; padding-bottom: 10px; " class="slot-styling camarker-inner"><!----><table cellpadding="0" cellspacing="0" width="100%" style="background-color: #0033A0; min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding: 10px 0px; " class="stylingblock-content-wrapper camarker-inner"><div style="text-align: center;">
	<span style="color:#ffffff;"><span style="font-size:15px;"><a href="http://saipolygraph.com" style="color:#ffffff;text-decoration:none;">www.saipolygraph.com</a></span></span></div></td></tr></table><!----></td></tr></table>
                                  
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="" valign="top">
                                  <table cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%; " class="slot-styling"><tr><td style="padding-top: 20px; " class="slot-styling camarker-inner"><!----><table cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td style="padding-top: 10px; padding-right: 10px; padding-left: 10px; " class="stylingblock-content-wrapper camarker-inner"><div style="text-align: justify;">
	<font size="1"><font color="#686868" face="Arial" style="font-size:12px;">Por su tranquilidad, seguridad y la de su Familia al llegar al lugar  indicado para la prueba se le informara  el  <strong><span style="color: #0033a0;">protocolo de prevenci&oacute;n</span></strong> con el fin de evitar la propagaci&oacute;n del COVID-19: <br/><br/> <strong><span style="color: #0033a0;">
Si usted o alguno de los miembros de su n&uacute;cleo familiar o de convivencia ha tenido alg&uacute;n signo de alerta como fiebre, tos, dolor de cabeza, dolor de  garganta, malestar de gripa, hace o ha hecho parte de la cadena de contagio o fue diagnosticado positivo con COVID -19 favor abstenerse de presentarse a la prueba y <span style="color: #ff0000;"> solicite la reprogramaci&oacute;n </span> de la misma de forma inmediata. <br/><br/></span></strong>
Comun&iacute;quese con nosotros a los siguientes  tel&eacute;fonos/WS: 3107552830/ 3002475138  fijo: 5971536


<br>
	<br>
	<p align="center"><span style="color: #0033a0;" ><strong><span style="font-size: 10pt;">Tu bienestar es primero, si no es indispensable salir, qu&eacute;date en casa</span>
<br/><span style="color: #ff0000;">“OJOS, NARIZ Y BOCA NO SE TOCAN”</span>
</strong></span>&nbsp;</p>
	</font></font>
	<div style="text-align: center;">
		<font size="1"><font color="#686868" face="Arial" size="1"><font color="#336666" face="Arial" size="1"><a   href="#" title="Ver Políticas de Uso y seguridad">Ver Pol&iacute;ticas de Uso y seguridad</a> - <a   href="#" title="Ver Políticas de Privacidad Ley de Datos Personales">Ver Pol&iacute;ticas de Privacidad Ley de Datos Personales</a> </font> </font></font></div><font size="1"><font color="#686868" face="Arial" size="1"> </font></font>
<div style="text-align: center;">
		<font size="1"><font color="#686868" face="Arial" size="1"><font size="1"><font color="#686868" face="Arial">Este email fue enviado por: SAIPOLYGRAPH, Colombia </font> </font> </font></font></div><font size="1"><font color="#686868" face="Arial" size="1"> </font></font></div></td></tr></table><!----></td></tr></table>
                                  
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td valign="top">
          
        </td>
      </tr>
    </table>
  </body>
</html>';
            
        return $html;
            
    }
    
    
  
}
?>