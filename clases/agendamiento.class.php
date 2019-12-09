<?php
@$_SESSION["liberar"]=@$_GET['id_fecha'];
class Plantas extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR AGENDAMIENTOS';
    public $_subTitulo = 'Crear Solicitudes';
    public $_datos = '';
    public $Table = 'evaluado';
    public $PrimaryKey = 'id_evaluado';
    
    
    
   function Contenido(){
       $html='';
	   if(isset($_GET['id_fecha'])){
	   

	   $sql = "SELECT estado FROM cupo_fechas WHERE id_cupo_fecha=".$_GET['id_fecha'];
	   $validar_estado = $this->Consulta($sql);
	   
	   
	   
       $sql = 'SELECT id_prueba codigo, nombre as descripcion from tipo_prueba WHERE estado = 1';
       $arrPlantas = $this->Consulta($sql);
       
       $sql = "SELECT id_tipo codigo, CONCAT(TIPO_DOC, ' ', DESCRIPCION) as descripcion from tipo_identificacion WHERE estado = 'A'";
       $arrTipos = $this->Consulta($sql);
	   
	   $sql = "SELECT id_empresa codigo, NOMBRE as descripcion from empresas WHERE activo = 1";
       $arrClientes = $this->Consulta($sql);
	   
	   $sql = "UPDATE cupo_fechas SET estado='BLOQUEADO', hora=DATE_ADD(NOW(), INTERVAL -5 HOUR) WHERE id_cupo_fecha=".$_GET['id_fecha'];
       $this->QuerySql($sql);
	   
	   $healthy = array("Monday", "Tuesday", "Wednesday","Thursday","Friday","Saturday","Sunday");
	   $yummy   = array("Lunes", "Martes", "Miercoles","Jueves","Viernes","Sabado","Domingo");  
	   
	   $mesesin = array("January", "February", "March","April","May","June","July","August","September","October","November","December");
	   $meseses   = array("de Enero de ", "de Febrero de ", "de Marzo de ","de Abril de ","de Mayo de ","de Junio de ","de Julio de ","de Agosto de ","de Septiembre de ","de Octubre de","de Noviembre de ","de Diciembre de");
	   
	   $sql = "SELECT
					DATE_FORMAT(CF.fecha, '%W, %e %M %Y') AS fecha,
					CH.cupo_hora
				FROM
					cupo_fechas CF
				INNER JOIN cupo_hora CH ON CH.id_cupo_hora = CF.id_cupo_hora
				WHERE
					CF.activo = 1
				AND CF.id_cupo_fecha =".$_GET['id_fecha'];
       $arrcupos = $this->Consulta($sql);
	    
		$arrcupos[0]['fecha'] = str_replace($healthy, $yummy, $arrcupos[0]['fecha']);   
		$arrcupos[0]['fecha'] = str_replace($mesesin, $meseses, $arrcupos[0]['fecha']);   				
		if($validar_estado[0]['estado']=='BLOQUEADO' || $validar_estado[0]['estado']=='TOMADO'){
		  	/*
		   echo '<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal2">
			  <div class="modal-dialog modal-sm">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Este cupo <br/>
						 <label for="nombre">FECHA PROGRAMADA:</label>&nbsp;&nbsp;'.$arrcupos[0]['fecha'] .'<br/>
										  <label for="nombre">FRANJA:</label>&nbsp;&nbsp;'.$arrcupos[0]['cupo_hora'] .'
					<br/> ya fue tomado</h4>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="window.location=\'agendar.php?liberar='.$_GET['id_fecha'].'\'">ACEPTAR</button>
				  </div>
				</div>
			  </div>
			</div>';*/
	    }
	   
			
		echo "<script type=\"text/javascript\">
				function sayHi() {
					$( document ).ready(function() {
						$('#mi-modal3').modal('toggle')
					});
				   
				}
				setTimeout(sayHi, 600000);
			</script>";  
		
         $html='
		
		 <section class="main-content-wrapper">
		
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Solicitudes</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8 ">
                          <div class="panel panel-default panelCrear">
                             <div class="panel-heading">
                                <h3 class="panel-title">Desplegar para Crear Solicitud </h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-up"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
									<div class="form-group" style="height:10px; color: red;">
                                        <label for="nombre">FECHA PROGRAMADA:</label>
                                        '.$arrcupos[0]['fecha'] .'
										  <label for="nombre">FRANJA:</label>
                                        '.$arrcupos[0]['cupo_hora'] .'
										
                                    </div>
                                    <br/>
									 <div class="form-group" >
                                        <label for="id_cursos">Cliente (Empleador):<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->crearSelect('clientefinal','clientefinal',$arrClientes,false,false,'Seleccione...','class=" required" style="width: 50%;"').'
										  <div id="demo7"></div>
                                    </div>
                                    <div class="form-group" >
                                        <label for="nombre">Tipo de Prueba:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->create_input('hidden','id_fecha','id_fecha',false,$_GET['id_fecha']).'                                    
                                        '.$this->crearSelect('id_prueba','id_prueba',$arrPlantas,false,false,'Seleccione...','class=" required" style="width: 40%;"').'
                                        <div id="demo6"></div>
                                        
                                    </div>
                                     <div class="form-group" >
                                        <label for="id_cursos">Cargo al que Aspira el Evaluado:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->create_input('text','cargo','cargo','Cargo Aspirar',false,' required','', 'onkeyup="javascript:this.value=this.value.toUpperCase();" style="width: 60%;"').'
                                        <div id="demo"></div>
                                    </div>
									<div class="form-group" >
                                        <label for="nombre">Sexo:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                                               
                                         <input type="radio" name="sexo" id="sexo" value="MASCULINO" class="required"> Hombre
										 <input type="radio" name="sexo" id="sexo" value="FEMENINO" class="required"> Mujer
                                          <div id="demo8"></div>
                                    </div>
                                    <div class="form-group" >
                                        <label for="id_cursos">Nombres del Evaluado:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->create_input('text','NOMBRES','NOMBRES','Nombre del Entrevistado',false,'form-control required','', 'onkeyup="javascript:this.value=this.value.toUpperCase();"').'
                                        <div id="demo1"></div>
                                        
                                    </div>
									
									 <div class="form-group" >
                                        <label for="id_cursos">Apellido del Evaluado:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->create_input('text','APELLIDOS','APELLIDOS','Apellido del Entrevistado',false,'form-control required','', 'onkeyup="javascript:this.value=this.value.toUpperCase();"').'
                                        <div id="demo2"></div>
                                        
                                    </div>

                                    <div class="form-group" >
                                         <label for="nombre">Tipo Documento:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                      
                                        '.$this->crearSelect('ID_TIPO','ID_TIPO',$arrTipos,false,false,'Seleccione...','class=" required" style="width: 40%;"').'
                                         <div id="demo5"></div>
                                    </div>                                    
                                    
                                    
                                    <div class="form-group" >
                                        <label for="id_cursos" >Numero de Identificacion:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                       '.$this->create_input('text','DOCUMENTO','DOCUMENTO','Numero de Identificacion',false,' required','','style="width: 50%;"').'
                                        <div id="demo3"></div>
                                    </div>                                    
                                   
                                    <div class="form-group"  >
                                        <label for="id_cursos">Email:</label>
                                        '.$this->create_input('email','EMAIL','EMAIL','EMAIL',false,'','','style="width: 80%;"').'
                                        
                                    </div> 
                                    
                                    <div class="form-group" >
                                        <label for="id_cursos">Telefono Contacto:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->create_input('text','telefono','telefono','Telefono Contacto',false,' ','','').'
                                         '.$this->create_input('text','celular','celular','Celular Contacto',false,' ','','').'
                                        <div id="demo4"></div>
                                    </div>
                                    
									'; 
                                  
                                     $html.='<button type="button" class="btn btn-primary" onclick="window.location=\'agendar.php?liberar='.$_GET['id_fecha'].'\'">Cancelar</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                      $html.='<button  type="button" class="btn btn-primary" id="guardarCurso">Guardar Solicitud</button>';
                                    $html.='<div id="Resultado" style="display:none; >RESULTADO</div>
                                
								</form>
                            </div>
                        </div>

                    </div> '.$this->tablaDatos().'
                    
                        </div>
                    </div>
                </div>         
        </section>
		
			<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
			  <div class="modal-dialog modal-sm">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">¿Confirma la Información cargada?</h4>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" id="modal-btn-si">Si</button>
					<button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
				  </div>
				</div>
			  </div>
			</div>
			
			  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal3">
			  <div class="modal-dialog modal-sm">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Se ha exedido el limite de espera para agendar sera redericcionado. <br/> <br/>Vuelva a seleccionar un nuevo cupo</h4>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="window.location=\'agendar.php?liberar='.$_GET['id_fecha'].'\'">ACEPTAR</button>
				  </div>
				</div>
			  </div>
			</div>
			
		'; 
	   }
		if(isset($_GET['agendar']) && isset($_GET['cupo']) && $_GET['agendar']==1){
			
	   
	   
		   $healthy = array("Monday", "Tuesday", "Wednesday","Thursday","Friday","Saturday","Sunday");
		   $yummy   = array("Lunes", "Martes", "Miercoles","Jueves","Viernes","Sabado","Domingo");  
		   
		   $mesesin = array("January", "February", "March","April","May","June","July","August","September","October","November","December");
		   $meseses   = array("de Enero de ", "de Febrero de ", "de Marzo de ","de Abril de ","de Mayo de ","de Junio de ","de Julio de ","de Agosto de ","de Septiembre de ","de Octubre de","de Noviembre de ","de Diciembre de");
		   
		   $sql = "SELECT
						DATE_FORMAT(CF.fecha, '%W, %e %M %Y') AS fecha,
						CH.cupo_hora,
						ea.nombre_estado_agenda AS ESTADO,
						tp.NOMBRE AS TIPO_PRUEBA,
						c.NOMBRES AS EVALUADO,
						c.DOCUMENTO AS CEDULA,
						E.cargo AS CARGO_ASPIRAR,
						ti.TIPO_DOC AS TIPO_DOCUMENTO,
					  c.DOCUMENTO,
					  c.EMAIL,
					  c.TELEFONO,
					  c.CELULAR,
					  c.SEXO,
					  CONCAT(em.nit,' - ',em.NOMBRE) AS CLIENTEFINAL,
					  DATE_FORMAT( E.fecha_cupo_tomado, '%e %M %Y a las %H:%i:%S' ) AS CUPO_TOMADO,
					  u.nombres AS PROGAMADOPOR  
					FROM
						cupo_fechas CF
					INNER JOIN cupo_hora CH ON CH.id_cupo_hora = CF.id_cupo_hora
					INNER JOIN evaluado E ON E.id_cupo_fecha = CF.id_cupo_fecha
					INNER JOIN candidatos c ON c.id_candidatos = E.id_candidato
					INNER JOIN tipo_prueba tp ON tp.ID_PRUEBA = E.id_tipo_prueba
					INNER JOIN estados_agenda ea ON ea.id_estados = E.estado
					INNER JOIN tipo_identificacion ti on ti.ID_TIPO=c.TIPODOCUMENTO
					INNER JOIN empresas em on em.id_empresa=E.clientefinal
					INNER JOIN usuarios u on u.id_usuario=E.id_usuario
					WHERE CF.id_cupo_fecha =".$_GET['cupo'];
		   $arrcupos = $this->Consulta($sql);
			
			$arrcupos[0]['fecha'] = str_replace($healthy, $yummy, $arrcupos[0]['fecha']);   
			$arrcupos[0]['fecha'] = str_replace($mesesin, $meseses, $arrcupos[0]['fecha']);   				
			
			$arrcupos[0]['CUPO_TOMADO'] = str_replace($healthy, $yummy, $arrcupos[0]['CUPO_TOMADO']);   
			$arrcupos[0]['CUPO_TOMADO'] = str_replace($mesesin, $meseses, $arrcupos[0]['CUPO_TOMADO']);   					
			
         $html='<section class="main-content-wrapper">
		
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Solicitudes</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8 ">
                          <div class="panel panel-default panelCrear">
                             <div class="panel-heading">
                                <h3 class="panel-title">Informacion de la Agenda</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-up"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                
									<div class="form-group" style="height:10px; color: red;">
                                        <label for="nombre">FECHA PROGRAMADA:</label>
                                        '.$arrcupos[0]['fecha'] .'
										  <label for="nombre">FRANJA:</label>
                                        '.$arrcupos[0]['cupo_hora'] .'
										
                                    </div>
									 <br/>
									 
									<div class="form-group" >
                                        <label for="nombre">Cupo tomado el :</label>
                                        '.$arrcupos[0]['CUPO_TOMADO'] .' <br/><br/>
										  <label for="nombre">Programada Por:</label>
                                        '.$arrcupos[0]['PROGAMADOPOR'] .' &nbsp;&nbsp;&nbsp;&nbsp;
										
										<label for="nombre">Estado Solicitud:</label>
                                        '.$arrcupos[0]['ESTADO'] .'
										
                                    </div>
									<div class="form-group" >
                                        <label for="id_cursos">Cliente (Empleador):</label>
                                        '.$arrcupos[0]['CLIENTEFINAL'] .'
                                    </div>
                                    <div class="form-group" >
                                        <label for="nombre">Tipo de Prueba:</label>                                                                
                                        Poligrafia - '.$arrcupos[0]['TIPO_PRUEBA'] .'
                                        
                                    </div>
                                     <div class="form-group" >
                                        <label for="id_cursos">Cargo al que Aspira el Evaluado:</label>
                                         '.$arrcupos[0]['CARGO_ASPIRAR'] .'
                                    </div>
                                    <div class="form-group" >
                                        <label for="id_cursos">Sexo:</label>
                                         '.$arrcupos[0]['SEXO'] .'
                                    </div>
                                    <div class="form-group" >
                                        <label for="id_cursos">Nombres y Apellido del Evaluado:</label>
                                         '.$arrcupos[0]['EVALUADO'] .'
                                        
                                    </div>

                                    <div class="form-group" >
                                         <label for="nombre">Tipo Documento:</label>
                                          '.$arrcupos[0]['TIPO_DOCUMENTO'] .' &nbsp;&nbsp;&nbsp;&nbsp;
                                          <label for="id_cursos" >Numero de Identificacion:</label>
                                        '.$arrcupos[0]['DOCUMENTO'] .'
                                    </div> 
                                    <div class="form-group"  >
                                        <label for="id_cursos">Email:</label>
                                         '.$arrcupos[0]['EMAIL'] .'
                                    </div> 
                                    
                                    <div class="form-group" >
                                        <label for="id_cursos">Telefono Contacto:</label>
                                        '.$arrcupos[0]['TELEFONO'] .' - '.$arrcupos[0]['CELULAR'] .'
                                    </div>
                                    
                                   
                                    
									
									
									'; 
                                    $html.='<button type="button" class="btn btn-primary" onclick="window.location=\'solicitudes.php\'">OK</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    
                                    $html.='</div>
                        </div>

                    </div> 
                    
                        </div>
                    </div>
                </div>         
        </section>  '; 
		}
		
        return $html;
        
    }
    

    function guardarDatos(){
        //$this->imprimir($_POST);//exit; 
        //$this->imprimir($_SESSION['id_usuario']);
        try {
			
         $sql="INSERT INTO candidatos (
                NOMBRES,
                TIPODOCUMENTO,
                DOCUMENTO, 				
                EMAIL, 
                TELEFONO,
				CELULAR,
                IDSOLICITANTE,
				FECHA_CREACION,
				FECHA_MODIFICACION,
				SEXO) 
                VALUES ('".$_POST['NOMBRES']." ".$_POST['APELLIDOS']."',".$_POST['ID_TIPO'].",".$_POST['DOCUMENTO'].",'".$_POST['EMAIL']."','".$_POST['telefono']."','".$_POST['celular']."',
						".$_SESSION['id_usuario'].",DATE_ADD(NOW(), INTERVAL -5 HOUR),DATE_ADD(NOW(), INTERVAL -5 HOUR),'".$_POST['sexo']."' )";
        $this->QuerySql($sql);
        
        
        $sql="SELECT @@identity AS id_candidatos";
        $datos = $this->Consulta($sql,1); 

        
        $sql="INSERT INTO evaluado (
                id_tipo_prueba, 
                id_candidato,
                estado,
                resultado,
                id_usuario,
                cargo,
                clientefinal,
				fecha_cupo_tomado,
				fecha_modificacion,
				id_cupo_fecha,
				primer_cupo) 
                VALUES (".$_POST['id_prueba'].", ".$datos[0]['id_candidatos'].", '2', '0',".$_SESSION['id_usuario'].",'".$_POST['cargo']."',
						".$_POST['clientefinal'].",
						DATE_ADD(NOW(), INTERVAL -5 HOUR),DATE_ADD(NOW(), INTERVAL -5 HOUR),
						".$_POST['id_fecha'].",".$_POST['id_fecha'].")";     
       
        $this->QuerySql($sql);
        
         $sql="SELECT @@identity AS id_evaluado";
        $datos2 = $this->Consulta($sql,1); 
       
        $sql="SELECT U.id_usuario,A.idautorizacion,A.clientetercerizado FROM usuarios U
                INNER JOIN usuarios_parametros UP ON UP.id_usuario=U.id_usuario
                INNER JOIN autorizaciones A on A.idautorizacion=UP.clientercerizados
                where U.id_usuario=".$_SESSION['id_usuario'];
        $datos3 = $this->Consulta($sql,1); 
        
        $sql="INSERT INTO autorizacion_evaluado (
                idcandidato,
                idautorizacion,
                idevaluado,
                estado)
                VALUES (".$datos[0]['id_candidatos'].", ".$datos3[0]['idautorizacion'].",".$datos2[0]['id_evaluado'].",'P')";
        
        $this->QuerySql($sql);
        
		$sql="UPDATE cupo_fechas set estado='TOMADO' WHERE id_cupo_fecha=".$_POST['id_fecha'];
        
        $this->QuerySql($sql);
		
        $_respuesta = 'OK Se ha creado la Solicitud';
        }
        catch (exception $e) {
			 echo    $_respuesta =  $e->getMessage();
			 exit;
        }
        
        echo $_respuesta;
		
		echo '  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal4">
			  <div class="modal-dialog modal-sm">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Agendamiento Realizado con Exito </h4>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="window.location=\'agendamiento.php?agendar=1&cupo='.$_POST['id_fecha'].'\'">ACEPTAR</button>
				  </div>
				</div>
			  </div>
			</div>';
		echo "<script type=\"text/javascript\">				
				  $( document ).ready(function() {
						$('#mi-modal4').modal('show')
					});	
			</script>";  
		
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        $_respuesta = array('Codigo' => 99, "Mensaje" => 'Registro Eliminado con exito');
        $sql = 'DELETE  P, S, E, C, M, MM FROM plantas P 
                LEFT JOIN secciones S ON S.id_planta = P.id_planta
                LEFT JOIN equipos E ON E.id_secciones = S.id_secciones
                LEFT JOIN componentes C ON C.id_equipos = E.id_equipos
                LEFT JOIN mecanismos M ON M.id_componente = C.id_componentes
                LEFT JOIN mec_met MM ON MM.id_mecanismos = M.id_mecanismos
                WHERE P.id_planta = ' .  $this->_datos;
        try{
        $this->QuerySql($sql);
        }catch (exception $e) {
            $_respuesta = array('Codigo' => 99, "Mensaje" => $e->getMessage());
        }
        print_r(json_encode($_respuesta));
    }
    
    function fn_editar(){
     
    }
    
    function getDatos(){
      
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' 
        WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        $resultado = $res[0];
        
        print_r( json_encode( $resultado ) );
    }
    
    function _mostrar(){
      /**  $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');*/
        $html = $this->Cabecera();
        $html .= $this->contenido();
        //$html .= $this->tablaDatos();
        $html .= $this->Pata();
        echo $html;
    }
    
    function tablaDatos(){
       $agendar = $this->Imagenes($this->PrimaryKey,14);
        //$editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
      //  $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql="SELECT
              
                ea.nombre_estado_agenda AS ESTADO,
            	tp.NOMBRE AS TIPO_PRUEBA,
				c.NOMBRES AS EVALUADO,
                c.DOCUMENTO AS CEDULA,            
            	e.cargo AS CARGO_ASPIRAR,	
                e.clientefinal AS CLIENTE_FINAL                      
            FROM
            	evaluado e
            INNER JOIN candidatos c ON e.id_candidato = c.id_candidatos
            INNER JOIN tipo_prueba tp ON tp.ID_PRUEBA = e.id_tipo_prueba 
            INNER JOIN estados_agenda ea ON ea.id_estados=e.estado ";
        
     
        $datos = $this->Consulta($sql,1); 
        if(count($datos)){
            $_array_formu = array();
            $_array_formu = $this->generateHead($datos);
            $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();
            
            $tablaHtml  = '<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body recargaDatos"  style="page-break-after: always;">
                            <div class="table-responsive">';
            $tablaHtml  .='';
    		$tablaHtml .= $this->print_table($_array_formu, 6, true, 'table table-striped table-bordered',"id='tablaDatos'");
    		$tablaHtml .=' </div>
           </div>
                        </div>
                    </div>
                </div>
            ';
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