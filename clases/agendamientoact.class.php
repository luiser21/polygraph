<?php

class Plantas extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR AGENDAMIENTOS';
    public $_subTitulo = 'Actualizar Solicitudes';
    public $_datos = '';
    public $Table = 'evaluado';
    public $PrimaryKey = 'id_evaluado';
    
    
    
   function Contenido(){
       $html='';
	  
	   if(isset($_GET['id_fecha']) && $_GET['actualizar']=='actualizar'){
		   
		 
		    $sql = "SELECT
						DATE_FORMAT(CF.fecha, '%W, %e %M %Y') AS fecha,
						CH.cupo_hora,
						ea.nombre_estado_agenda AS ESTADO,
						tp.NOMBRE AS TIPO_PRUEBA,
						c.NOMBRES AS EVALUADO,
						c.DOCUMENTO AS CEDULA,
						E.cargo AS CARGO_ASPIRAR,
						ti.ID_TIPO AS TIPO_DOCUMENTO,
					  c.DOCUMENTO,
					  c.EMAIL,
					  c.TELEFONO,
					  c.CELULAR,E.horareal,
					  CASE  WHEN em.tipocliente=1 THEN 'TERCERIZADO'
						ELSE 'DIRECTO'
						END AS TIPOCLIENTE, 
					 em.NOMBRE AS INTERMEDIARIO, 
					 cf.NOMBRE AS CLIENTETERCERIZADO,
					  c.SEXO,
					  CONCAT(em.nit,' - ',em.NOMBRE) AS CLIENTEFINAL,
					  DATE_FORMAT( E.fecha_cupo_tomado, '%e %M %Y a las %H:%i:%S' ) AS CUPO_TOMADO,
					  u.nombres AS PROGAMADOPOR,
					c.LUGAREXPEDICION,
					c.FECHAEXPEDICION,
					E.id_evaluado,
					c.id_candidatos,
					CF.id_cupo_fecha 
					FROM
						cupo_fechas CF
					INNER JOIN cupo_hora CH ON CH.id_cupo_hora = CF.id_cupo_hora
					INNER JOIN evaluado E ON E.id_cupo_fecha = CF.id_cupo_fecha
					INNER JOIN candidatos c ON c.id_candidatos = E.id_candidato
					INNER JOIN tipo_prueba tp ON tp.ID_PRUEBA = E.id_tipo_prueba
					INNER JOIN estados_agenda ea ON ea.id_estados = E.estado
					LEFT JOIN tipo_identificacion ti on ti.ID_TIPO=c.TIPODOCUMENTO
					INNER JOIN aliados em on em.id_aliado=E.clientefinal
					LEFT JOIN empresas cf on cf.id_empresa=E.clientetercerizado
					INNER JOIN usuarios u on u.id_usuario=E.id_usuario
					WHERE CF.id_cupo_fecha =".$_GET['id_fecha']." or E.id_evaluado=".$_GET['id_fecha'];
		   $agendamientoact = $this->Consulta($sql);   
		   
		  // $this->imprimir($agendamientoact);
	   $_GET['id_fecha']=$agendamientoact[0]['id_cupo_fecha'];
		
	   $sql = "SELECT estado FROM cupo_fechas WHERE id_cupo_fecha=".$_GET['id_fecha'];
	   $validar_estado = $this->Consulta($sql);
	 
	   
       $sql = 'SELECT id_prueba codigo, nombre as descripcion from tipo_prueba WHERE estado = 1';
       $arrPlantas = $this->Consulta($sql);
       
       $sql = "SELECT id_tipo codigo, CONCAT(TIPO_DOC, ' ', DESCRIPCION) as descripcion from tipo_identificacion WHERE estado = 'A'";
       $arrTipos = $this->Consulta($sql);
	   
	   $sql = "SELECT E.id_empresa codigo, E.NOMBRE as descripcion from empresas E
                INNER JOIN aliados A ON A.id_aliado=E.id_aliado
                WHERE E.activo = 1 and A.id_aliado=".$_SESSION['empresa'];
       $arrClientes = $this->Consulta($sql);
    				
       $sql = "SELECT id_aliado codigo, NOMBRE as descripcion from aliados WHERE activo = 1 and tipocliente like '%1%' order by NOMBRE";        
       $arrClientesterce = $this->Consulta($sql);
	   
	   
	   $sql = "SELECT id_aliado codigo, NOMBRE as descripcion from aliados WHERE activo = 1 and tipocliente like '%2%'  order by NOMBRE";        
       $arrClientesdirectos = $this->Consulta($sql);
	   
	  
	   
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
		
	   
			
		echo "    
<script type=\"text/javascript\">

	$( document ).ready(function() {
		$('#mi-modal2').modal('toggle')
	});
	
</script>";  
		
         $html='
		
		 <section class="main-content-wrapper">
		
            <div class="pageheader">
                <h1>'. $this->NombreUsuario.' '. $this->ApellidoUsuario.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">SAI Poligraf&iacute;as <p><a href="http://saipolygraph.com" target="_blank" ><strong style="font-size:13px;color:#EE1414;"> www.saipolygraph.com </strong></a></li>
                  
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8 ">
                          <div class="panel panel-default panelCrear">
                             <div class="panel-heading">
                                <h3 class="panel-title">Desplegar para Actualizar Solicitud </h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-up"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
																 
									<div class="form-group" >
                                        <label for="nombre">Cupo tomado el :</label>
                                        '.$agendamientoact[0]['CUPO_TOMADO'] .'  &nbsp;&nbsp;&nbsp;&nbsp;  
										<label for="nombre">Hora Real:</label>
										'.$agendamientoact[0]['horareal'] .' 
										<br/>
										  <label for="nombre">Programada Por:</label>
                                        '.$agendamientoact[0]['PROGAMADOPOR'] .' &nbsp;&nbsp;&nbsp;&nbsp;
										
										<label for="nombre">Estado Solicitud:</label>
                                        '.$agendamientoact[0]['ESTADO'] .'
										<br/>
										<label for="nombre">Cliente Tipo:</label>
                                        '.$agendamientoact[0]['TIPOCLIENTE'] .'  
                                    </div> ';          
                                    
									if($agendamientoact[0]['TIPOCLIENTE']=='DIRECTO'){
										$html.='<div class="form-group" >
                                        <label for="id_cursos">Cliente (Empleador):</label>
										'.$agendamientoact[0]['INTERMEDIARIO'] .'  
										</div>	';	
									}else{								
										$html.=' <div class="form-group" >
											<label for="id_cursos">Intermediario:</label>
											'.$agendamientoact[0]['INTERMEDIARIO'] .'  &nbsp;&nbsp;&nbsp;&nbsp;										
											<label for="id_cursos">Cliente Final:</label>
											 '.$agendamientoact[0]['CLIENTETERCERIZADO'] .'  										 
										</div>';
									}
									
									$html.=' 
                                    <div class="form-group" >
                                        <label for="nombre">Tipo de Prueba:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->create_input('hidden','id_fecha','id_fecha',false,$_GET['id_fecha']).'    
										'.$this->create_input('hidden','id_evaluado','id_evaluado',false,$agendamientoact[0]['id_evaluado']).' 
										'.$this->create_input('hidden','id_candidatos','id_candidatos',false,$agendamientoact[0]['id_candidatos']).' 
                                         <select name="id_prueba"  id="id_prueba" class=" required" style="width: 40%;">';
										   for($i=0;$i<count($arrPlantas);$i++){
												if($arrPlantas[$i]['descripcion']==$agendamientoact[0]['TIPO_PRUEBA']){
													$html.= '<option value="'.$arrPlantas[$i]['codigo'].'"  selected="selected" >'.$arrPlantas[$i]['descripcion'].'</option>';
												}else{
													$html.= '<option value="'.$arrPlantas[$i]['codigo'].'">'.$arrPlantas[$i]['descripcion'].'</option>';
												}
										   }
								   $html.='  </select>   <div id="demo6"></div>
                                        
                                    </div>
									<div class="form-group" >
                                        <label for="nombre">Sexo:</label>';
                                                if($agendamientoact[0]['SEXO']=='MASCULINO'){
												         $html.='  <input type="radio" name="sexo" id="sexo" value="MASCULINO"  checked > Hombre
																   <input type="radio" name="sexo" id="sexo" value="FEMENINO" > Mujer';
												}else{
												         $html.='<input type="radio" name="sexo" id="sexo" value="MASCULINO"   > Hombre 	
																<input type="radio" name="sexo" id="sexo" value="FEMENINO"  checked > Mujer';
												}               
                                         
                                       $html.='    <div id="demo8"></div>
                                    </div>
                                     <div class="form-group" >
                                        <label for="id_cursos">Cargo Aspirar o Actual del Evaluado:</label>
                                        '.$this->create_input('text','cargo','cargo','',$agendamientoact[0]['CARGO_ASPIRAR'],'','', 'onkeyup="javascript:this.value=this.value.toUpperCase();" style="width: 60%;"').'
                                        <div id="demo"></div>
                                    </div>
									
                                    <div class="form-group" >
                                        <label for="id_cursos">Nombres y Apellidos del Evaluado:</label>
                                        '.$this->create_input('text','NOMBRES','NOMBRES','',$agendamientoact[0]['EVALUADO'],'form-control','', 'onkeyup="javascript:this.value=this.value.toUpperCase();"').'
                                        <div id="demo1"></div>
                                        
                                    </div>						
								

                                    <div class="form-group" >
                                         <label for="nombre">Tipo Documento:</label>
										  <select name="ID_TIPO"  id="ID_TIPO"  style="width: 40%;">';
										   for($i=0;$i<count($arrTipos);$i++){
											  // var_Dump( $value);
												if($arrTipos[$i]['codigo']==$agendamientoact[0]['TIPO_DOCUMENTO']){
													$html.= '<option value="'.$arrTipos[$i]['codigo'].'"  selected="selected" >'.$arrTipos[$i]['descripcion'].'</option>';
												}else{
													$html.= '<option value="'.$arrTipos[$i]['codigo'].'">'.$arrTipos[$i]['descripcion'].'</option>';
												}
										   }
										
                                        $html.='  </select>   <div id="demo5"></div>
                                    </div>                                    
                                    
                                    
                                    <div class="form-group" >
                                        <label for="id_cursos" >Numero de Identificacion:</label>
                                       '.$this->create_input('number','DOCUMENTO','DOCUMENTO','',$agendamientoact[0]['DOCUMENTO'],'  digits','','style="width: 50%;"').'
                                        <div id="demo3"></div>
                                    </div>                                    
                                     
									 <div class="form-group" >
                                        <label for="id_cursos" >Fecha Expedicion:</label>
                                       '.$this->create_input('date','fechaexpedicion','fechaexpedicion','',$agendamientoact[0]['FECHAEXPEDICION'],'  digits','','style="width: 20%;"').'
                                        <div id="demo3"></div>
                                    </div>   
									  <div class="form-group" >
                                        <label for="id_cursos" >Lugar de Expedicion:</label>
                                       <input type="text" name="lugarexpedicion" value="'.$agendamientoact[0]['LUGAREXPEDICION'].'"  placeholder="Bucar municipio..." style="width: 50%;" id="lugarexpedicion" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onkeyup="javascript:load_data_municipio(this.value);this.value=this.value.toUpperCase();"  />
										<span id="search_result_municipio"></span>
										<div id="demo3"></div>
                                    </div>   
                                    <div class="form-group"  >
                                        <label for="id_cursos">Email:</label>
                                        '.$this->create_input('email','EMAIL','EMAIL','',$agendamientoact[0]['EMAIL'],' email','','style="width: 70%;" ').'
                                        <br/>                                       
                                        <label for="id_cursos">Email 2:</label>
                                        '.$this->create_input('email','EMAIL2','EMAIL2','EMAIL',false,' email ','','style="width: 70%;" ').'
                                         <div id="demo10"></div>
                                    </div> 
                                    
                                    <div class="form-group" >
                                        <label for="id_cursos">Telefono Contacto:</label>
                                            '.$this->create_input('number','celular','celular','',$agendamientoact[0]['CELULAR'],' digits ','',' data-validation-length="min4"').'
                                            '.$this->create_input('number','telefono','telefono','',$agendamientoact[0]['TELEFONO'],' digits ','',' data-validation-length="min4"').'
                                         
                                        <div id="demo4"></div>
                                    </div>
                                    
									'; 
                                  
                                      $html.='<button  type="button" class="btn btn-primary" id="guardarCursoupdate">Actualizar Solicitud</button>';
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
					<h4 class="modal-title" id="myModalLabel">&iquest;Confirma la Informaci&oacute;n cargada?</h4>
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
					<button type="button" class="btn btn-default" onclick="window.location=\'agendar.php\'">ACEPTAR</button>
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
					LEFT JOIN tipo_identificacion ti on ti.ID_TIPO=c.TIPODOCUMENTO
					INNER JOIN aliados em on em.id_aliado=E.clientefinal
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
                                    $html.='<button type="button" class="btn btn-primary" onclick="window.location=\'solicitudes.php\'">OK</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <button type="button" class="btn btn-primary" onclick="window.location=\'agendar.php\'">AGENDAR SIGUIENTE</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    
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
		
        try {
			
             $sql="UPDATE candidatos SET 
                    NOMBRES='".$_POST['NOMBRES']."',
                    TIPODOCUMENTO='".$_POST['ID_TIPO']."',
                    DOCUMENTO='".$_POST['DOCUMENTO']."', 
					LUGAREXPEDICION='".$_POST['lugarexpedicion']."',
					FECHAEXPEDICION='".$_POST['fechaexpedicion']."',					
                    EMAIL='".$_POST['EMAIL']."', 
                    TELEFONO='".$_POST['telefono']."',
    				CELULAR='".$_POST['celular']."',
                    IDSOLICITANTE=".$_SESSION['id_usuario'].",
    				FECHA_MODIFICACION=DATE_ADD(NOW(), INTERVAL -5 HOUR),
    				SEXO='".$_POST['sexo']."'
                   WHERE id_candidatos='".$_POST['id_candidatos']."'";
            $this->QuerySql($sql);            
           			
			
            $sql="UPDATE evaluado SET
                    id_tipo_prueba=".$_POST['id_prueba'].",                    
                    cargo='".$_POST['cargo']."',
    				fecha_modificacion=DATE_ADD(NOW(), INTERVAL -5 HOUR) 
					WHERE id_candidato=".$_POST['id_candidatos']." AND id_evaluado=".$_POST['id_evaluado'];                
            $this->QuerySql($sql);            
            
    		
            $_respuesta = 'OK Se Actualizo la Solicitud'.PHP_EOL;
            
            $mesesin = array("January", "February", "March","April","May","June","July","August","September","October","November","December");
            $meseses   = array("de Enero de ", "de Febrero de ", "de Marzo de ","de Abril de ","de Mayo de ","de Junio de ","de Julio de ","de Agosto de ","de Septiembre de ","de Octubre de","de Noviembre de ","de Diciembre de");
            
            $sql = "SELECT
					DATE_FORMAT(CF.fecha,'%e %M %Y') AS fecha,
					TIME_FORMAT(  SUBSTRING(CH.cupo_hora,1,5) , '%h:%i %p')  as hora,
                    DATE_FORMAT(CF.fecha,'%d/%m/%Y') AS fechasms,
                    TIME_FORMAT(  SUBSTRING(CH.cupo_hora,1,5) , '%h:%i%p')      as horasms		
				FROM
					cupo_fechas CF
				INNER JOIN cupo_hora CH ON CH.id_cupo_hora = CF.id_cupo_hora
				WHERE
					CF.activo = 1
				AND CF.id_cupo_fecha =".$_POST['id_fecha'];
            $arrcupos = $this->Consulta($sql);
            
            $sql = "SELECT count(1) as solicitudes FROM evaluado";
            $solicitudes = $this->Consulta($sql);
            
          
            $arrcupos[0]['fecha'] = str_replace($mesesin, $meseses, $arrcupos[0]['fecha']); 
            
        
            //Envio de Correo
            if(!empty($_POST['EMAIL'])){
                $from = "confirmacion@saipolygraph.com";
                $to = trim($_POST['EMAIL']);
               
                $subject = "Confirmación agendamiento de Cita – Prueba de Polígrafo";             
                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";            
                // Create email headers
                $headers .= 'From: '.$from."\r\n".
                    'Reply-To: '.$from."\r\n" .
                    'Cc: '.$_POST['EMAIL2'] . "\r\n" .  // esto sería copia normal
                    'X-Mailer: PHP/' . phpversion();            
                $fullname=$_POST['NOMBRES'];
                $clienteterce=''; 
                $solicitud='';
                $fecha=''; 
                $hora='';
                // Compose a simple HTML email message
                $message = $this->EnviarCorreo($fullname,$_POST['clientefinal'], '1000'.$solicitudes[0]['solicitudes'], $arrcupos[0]['fecha'],$arrcupos[0]['hora']);            
                mail($to,$subject,$message, $headers);
                echo "Se envio correo".PHP_EOL;
            }
            
            //Envio Mensaje de Texto
            if(!empty($_POST['celular'])){
               echo  $this->EnviarSms($_POST['celular'],$arrcupos[0]['fechasms'],$arrcupos[0]['horasms']);
            }
        
        }catch (exception $e) {
			 echo    $_respuesta =  $e->getMessage();
			 exit;
        }
      
        echo $_respuesta;
		
		echo '  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal4">
			  <div class="modal-dialog modal-sm">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Actualizacion Realizada con Exito </h4>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="window.location=\'agendamientoact.php?agendar=1&cupo='.$_POST['id_fecha'].'\'">ACEPTAR</button>
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
 $html = $this->Pata();       
	   $html .= $this->Cabecera();
        $html .= $this->contenido();
        //$html .= $this->tablaDatos();
       // $html .= $this->Pata();
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