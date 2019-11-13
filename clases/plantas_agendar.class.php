<?php
class Plantas extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR SOLICITUDES';
    public $_subTitulo = 'Crear Solicitudes';
    public $_datos = '';
    public $Table = 'plantas';
    public $PrimaryKey = 'id_planta';
    
    
    
   function Contenido(){
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
            
            <div class="col-md-8">
                        	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />	
	<link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />

	<div class="row-fluid">
	<div class="portlet box blue calendar">		
		<div class="portlet-body light-grey">
			<div class="row-fluid">
				
				<div class="span9">
				<br/>
					<div id="event_box" align="center">
						</div>
					<div id="calendar" class="has-toolbar"></div>
				</div>
			</div>		
		</div>
	</div>
</div>

	<script src="assets/js/jquery-1.8.3.min.js"></script>			
	<script src="assets/breakpoints/breakpoints.js"></script>			
	<script src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>		
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>	
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("calendar");
			App.init();
		});

	</script>
                    </div> 
                    
                        </div>
                    </div>
                </div>                    

        </section>  '; 
        
        return $html;
        
    }
    
    
   
    
    function guardarDatos(){
        $this->runActualizar();        
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
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        $resultado = $res[0];
        
        print_r( json_encode( $resultado ) );
    }
    
    function _mostrar(){
      /**  $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');*/
        $html = $this->Cabecera();
        $html .= $this->contenido();
      //  $html .= $this->tablaDatos();
        $html .= $this->Pata();
        echo $html;
    }
    
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
      //  $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql=<<<OE
              SELECT
              E.id,
            	tp.NOMBRE AS TIPO,
            	CONCAT(c.NOMBRES, ' ', c.APELLIDOS) AS EVALUADO,
                c.DOCUMENTO AS CEDULA,
                C.EMAIL,
                C.TELEFONO,
                E.cargo AS CARGO_ASPIRAR,	
                E.clientefinal AS CLIENTE_FINAL,
            	E.fecha_inicio AS FECHA,	
            	ea.nombre_estado_agenda AS ESTADO,    
            	CASE
            	WHEN E.resultado=1 THEN CONCAT('<div align="center"><img src="img/verde.png" align="center" width="20" height="20" /></div>') 
            	WHEN E.resultado=2 THEN CONCAT('<div align="center"><img src="img/amarillo.png" align="center" width="20" height="20" /></div>') 
            	WHEN E.resultado=3 THEN CONCAT('<div align="center"><img src="img/rojo.png" align="center" width="20" height="20" /></div>')  
            	END AS RESULTADO,
                CONCAT(  '<div class="fa fa-edit" align="center" style="cursor:pointer" title="Crear Reporte" ONCLICK=javascript:fn_guardarMecMet(',  E.id ,  ',\'{$this->_file}\'); />' ) 
                    AS ACCION
            FROM
            	candidatos c
            INNER JOIN evaluado E ON E.id_candidato = c.ID
            INNER JOIN tipo_prueba tp ON tp.ID_PRUEBA = E.id_tipo_prueba 
            INNER JOIN estados_agenda ea ON ea.id_estados=E.estado 
OE;
        
        
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
    		$tablaHtml .= $this->print_table($_array_formu, 12, true, 'table table-striped table-bordered',"id='tablaDatos'");
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