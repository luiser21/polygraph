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
	   
	   $sql = "SELECT E.id_empresa codigo, E.NOMBRE as descripcion from empresas E
                INNER JOIN aliados A ON A.id_aliado=E.id_aliado
                WHERE E.activo = 1 and A.id_aliado=".$_SESSION['empresa'];
       $arrClientes = $this->Consulta($sql);
    				
       $sql = "SELECT id_aliado codigo, NOMBRE as descripcion from aliados WHERE activo = 1 and tipocliente like '%1%' order by NOMBRE";        
       $arrClientesterce = $this->Consulta($sql);
	   
	   
	   $sql = "SELECT id_aliado codigo, NOMBRE as descripcion from aliados WHERE activo = 1 and tipocliente like '%2%'  order by NOMBRE";        
       $arrClientesdirectos = $this->Consulta($sql);
	   
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
			</div>';
	    }
	   
			
		echo "    
<script type=\"text/javascript\">


function habilitardiv1() {

    var x = document.getElementById('directo');
	var y = document.getElementById('tercerizado');
	  var z = document.getElementById('nuevo');
    if (x.style.display === 'none') {
        x.style.display = 'block';
		y.style.display = 'none';
		z.style.display = 'none';
		document.getElementById('clientenuevo').value = '';
		document.getElementById('intermediario').value = '';
		document.getElementById('clientetercerizado').value = '';
    } else {
        x.style.display = 'none';
    }
}
function habilitardiv2() {

    var x = document.getElementById('tercerizado');
	 var y = document.getElementById('directo');
	  var z = document.getElementById('nuevo');
    if (x.style.display === 'none') {
        x.style.display = 'block';
		y.style.display = 'none';
		z.style.display = 'none';
		document.getElementById('clientenuevo').value = '';
		document.getElementById('clientefinal').value = '';
    } else {
        x.style.display = 'none';
    }
}
	
	function habilitardiv3() {

    var x = document.getElementById('nuevo');
	 var y = document.getElementById('directo');
	  var z = document.getElementById('tercerizado');
    if (x.style.display === 'none') {
        x.style.display = 'block';
		y.style.display = 'none';
		z.style.display = 'none';
		document.getElementById('clientefinal').value = '';
		document.getElementById('intermediario').value = '';
		document.getElementById('clientetercerizado').value = '';
    } else {
        x.style.display = 'none';
    }
}
	$( document ).ready(function() {
		$('#mi-modal2').modal('toggle')
	});
	
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
                                        '.$arrcupos[0]['cupo_hora'] .'<br/> 
										 <label for="id_cursos">HORA DE INICO:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        
										 '.$this->create_input('time','horareal','horareal','Hora inicio ',false,' ','', 'style="width: 15%;"').'

									 <br/> * Campos Obligatorios
                                    </div>  <p> <p> 
                                    <br/>  <br/> <br/>';
          
                                    
                                    $html.='	<p> <p> 
  <label for="id_cursos">Cliente Tipo:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>									
 <button type="button" id="tomarcupo1" class="btn btn-success" onclick="habilitardiv1()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
    Directo &nbsp;&nbsp;&nbsp;
 <button type="button" id="tomarcupo2"  onclick="habilitardiv2()" style="background-color: #ff8000;border: 2px solid #ff8000 ;" class="btn btn-danger">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
    Tercerizado  &nbsp;&nbsp;&nbsp;
 <button type="button" id="tomarcupo3" onclick="habilitardiv3()" style="background-color: #ffe032;border: 2px solid #ffe032 ; color: black;"  class="btn btn-warning">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
 Nuevo   
<p> <p>  <p> <p> 

									<div class="form-group" id="directo" style="display: none">
                                        <label for="id_cursos">Cliente (Empleador):<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->crearSelect('clientefinal','clientefinal',$arrClientesdirectos,false,false,'Seleccione...',' style="width: 50%;"').'
										  <div id="demo7"></div>
                                    </div>
									
									 <div class="form-group" id="tercerizado" style="display: none">
                                        <label for="id_cursos">Intermediario:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->crearSelect('intermediario','intermediario',$arrClientesterce,false,false,'Seleccione...','class="" style="width: 50%;"').'
										<br/>
										<label for="id_cursos">Cliente Final:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        <input type="text" name="clientetercerizado"  placeholder="Bucar Empresa..." style="width: 50%;" id="clientetercerizado" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onkeyup="javascript:load_data(this.value);this.value=this.value.toUpperCase();" onfocus="javascript:load_search_history()" />
										<span id="search_result"></span>
										 <div id="demo7"></div>
                                    </div>
									
									 <div class="form-group" id="nuevo" style="display: none">
                                        <label for="id_cursos">Cliente Nuevo:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->create_input('text','clientenuevo','clientenuevo','Cliente nuevo ',false,' ','', 'onkeyup="javascript:this.value=this.value.toUpperCase();" style="width: 60%;"').'

 <input type="radio" id="tipocliente" name="tipocliente" value="tercerizado"> <label for="cbox2">Tercerizado</label>  
<input type="radio" id="tipocliente" name="tipocliente" value="directo" checked> <label for="cbox2">Directo</label>                                                                         
										<div id="demo7"></div>
                                    </div>
									
                                    <div class="form-group" >
                                        <label for="nombre">Tipo de Prueba:<abbr style="color: red;" title="Este campo es obligatorio">*</abbr></label>
                                        '.$this->create_input('hidden','id_fecha','id_fecha',false,$_GET['id_fecha']).'                                    
                                        '.$this->crearSelect('id_prueba','id_prueba',$arrPlantas,false,false,'Seleccione...','class=" required" style="width: 40%;"').'
                                        <div id="demo6"></div>
                                        
                                    </div>
									<div class="form-group" >
                                        <label for="nombre">Sexo:</label>
                                                               
                                         <input type="radio" name="sexo" id="sexo" value="MASCULINO" class=""> Hombre
										 <input type="radio" name="sexo" id="sexo" value="FEMENINO" class=""> Mujer
                                          <div id="demo8"></div>
                                    </div>
                                     <div class="form-group" >
                                        <label for="id_cursos">Cargo Aspirar o Actual del Evaluado:</label>
                                        '.$this->create_input('text','cargo','cargo','Cargo ',false,' ','', 'onkeyup="javascript:this.value=this.value.toUpperCase();" style="width: 60%;"').'
                                        <div id="demo"></div>
                                    </div>
									
                                    <div class="form-group" >
                                        <label for="id_cursos">Nombres y Apellidos del Evaluado:</label>
                                        '.$this->create_input('text','NOMBRES','NOMBRES','Nombrs y Apellidos del Evaluado',false,'form-control','', 'onkeyup="javascript:this.value=this.value.toUpperCase();"').'
                                        <div id="demo1"></div>
                                        
                                    </div>						
								

                                    <div class="form-group" >
                                         <label for="nombre">Tipo Documento:</label>
                                      
                                        '.$this->crearSelect('ID_TIPO','ID_TIPO',$arrTipos,false,false,'Seleccione...','class="" style="width: 40%;"').'
                                         <div id="demo5"></div>
                                    </div>                                    
                                    
                                    
                                    <div class="form-group" >
                                        <label for="id_cursos" >Numero de Identificacion:</label>
                                       '.$this->create_input('number','DOCUMENTO','DOCUMENTO','Numero de Identificacion',false,'  digits','','style="width: 50%;"').'
                                        <div id="demo3"></div>
                                    </div>                                    
                                     
									 <div class="form-group" >
                                        <label for="id_cursos" >Fecha Expedicion:</label>
                                       '.$this->create_input('date','fechaexpedicion','fechaexpedicion','DD/MM/AAAA',false,'  digits','','style="width: 20%;"').'
                                        <div id="demo3"></div>
                                    </div>   
									  <div class="form-group" >
                                        <label for="id_cursos" >Lugar de Expedicion:</label>
                                       <input type="text" name="lugarexpedicion"  placeholder="Bucar municipio..." style="width: 50%;" id="lugarexpedicion" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onkeyup="javascript:load_data_municipio(this.value);this.value=this.value.toUpperCase();"  />
										<span id="search_result_municipio"></span>
										<div id="demo3"></div>
                                    </div>   
                                    <div class="form-group"  >
                                        <label for="id_cursos">Email:</label>
                                        '.$this->create_input('email','EMAIL','EMAIL','EMAIL',false,' email','','style="width: 70%;" ').'
                                        <br/>                                       
                                        <label for="id_cursos">Email 2:</label>
                                        '.$this->create_input('email','EMAIL2','EMAIL2','EMAIL',false,' email ','','style="width: 70%;" ').'
                                         <div id="demo10"></div>
                                    </div> 
                                    
                                    <div class="form-group" >
                                        <label for="id_cursos">Telefono Contacto:</label>
                                            '.$this->create_input('number','celular','celular','Celular Contacto',false,' digits ','',' data-validation-length="min4"').'
                                            '.$this->create_input('number','telefono','telefono','Telefono Contacto',false,' digits ','',' data-validation-length="min4"').'
                                         
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
        //$this->imprimir($_POST);//exit; 
        //$this->imprimir($_SESSION['id_usuario']);
       // exit;
        try {
			
             $sql="INSERT INTO candidatos (
                    NOMBRES,
                    TIPODOCUMENTO,
                    DOCUMENTO, 
					LUGAREXPEDICION,
					FECHAEXPEDICION,					
                    EMAIL, 
                    TELEFONO,
    				CELULAR,
                    IDSOLICITANTE,
    				FECHA_CREACION,
    				FECHA_MODIFICACION,
    				SEXO) 
                    VALUES ('".$_POST['NOMBRES']."','".$_POST['ID_TIPO']."','".$_POST['DOCUMENTO']."','".$_POST['lugarexpedicion']."','".$_POST['fechaexpedicion']."','".$_POST['EMAIL']."','".$_POST['telefono']."','".$_POST['celular']."',
    						".$_SESSION['id_usuario'].",DATE_ADD(NOW(), INTERVAL -5 HOUR),DATE_ADD(NOW(), INTERVAL -5 HOUR),'".$_POST['sexo']."' )";
            $this->QuerySql($sql);            
            
            $sql="SELECT @@identity AS id_candidatos";
            $datos = $this->Consulta($sql,1);     
            
			//$this->imprimir($_POST['clientefinal']);
			if(empty($_POST['clientefinal']) && empty($_POST['clientenuevo'])  && !empty($_POST['clientetercerizado'])){

				$_POST['clientefinal']=$_POST['intermediario'];
				
				if(!empty($_POST['clientetercerizado'])){
					
					$sql="SELECT id_empresa FROM empresas WHERE NOMBRE='".$_POST['clientetercerizado']."'";
					$datos_empresa = $this->Consulta($sql,1);     
					
					if(!isset($datos_empresa[0]['id_empresa']) && empty($datos_empresa[0]['id_empresa'])){
					
						$sql="INSERT INTO empresas (NOMBRE,id_aliado) 
							VALUES ('".$_POST['clientetercerizado']."',".$_POST['clientefinal'].")";                
						$this->QuerySql($sql);
						
						$sql="SELECT @@identity AS id_empresa";
						$datos_aliado = $this->Consulta($sql,1); 					
					
						$_POST['clientetercerizado']=$datos_aliado[0]['id_empresa'];
					}else{
						$_POST['clientetercerizado']=$datos_empresa[0]['id_empresa'];
					}
				}
				
			}elseif(empty($_POST['clientefinal']) && empty($_POST['intermediario']) && !empty($_POST['clientenuevo'])){
				
				$_POST['tipocliente']=($_POST['tipocliente']=='directo')?'2':'1'; 
				
				 $sql="INSERT INTO aliados (
                    tipocliente, 
                    NOMBRE) 
                    VALUES ('".$_POST['tipocliente']."', '".$_POST['clientenuevo']."')";                
				$this->QuerySql($sql);
				
				$sql="SELECT @@identity AS id_aliado";
				$datos_aliado = $this->Consulta($sql,1); 					
				
				$_POST['clientefinal']=$datos_aliado[0]['id_aliado'];
			}
			if(empty($_POST['clientetercerizado'])){
				$_POST['clientetercerizado']=0;
			}
            $sql="INSERT INTO evaluado (
                    id_tipo_prueba, 
                    id_candidato,
                    estado,
                    resultado,
                    id_usuario,
                    cargo,
                    clientefinal,clientetercerizado,
    				fecha_cupo_tomado,
    				fecha_modificacion,
    				id_cupo_fecha,
    				primer_cupo,
					horareal) 
                    VALUES (".$_POST['id_prueba'].", ".$datos[0]['id_candidatos'].", '2', '0',".$_SESSION['id_usuario'].",'".$_POST['cargo']."',
    						".$_POST['clientefinal'].",".$_POST['clientetercerizado'].",
    						DATE_ADD(NOW(), INTERVAL -5 HOUR),DATE_ADD(NOW(), INTERVAL -5 HOUR),
    						".$_POST['id_fecha'].",".$_POST['id_fecha'].",'".$_POST['horareal']."')";                
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
    		
            $_respuesta = 'OK Se ha creado la Solicitud'.PHP_EOL;
            
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