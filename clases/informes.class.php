<?php
/**
 * clasificaciones
 * 
 * @package carLub
 * @author JAVIER ARDILA
 * @copyright 2017
 * @version $Id$
 * @access public
 */
class generarOt extends crearHtml{
    
    public $_titulo = 'GENERAR INFORMES';
    public $_subTitulo = 'Informes';
    public $_datos = '';
    public $Table = 'ot_detalle';
    public $PrimaryKey = 'id_detalle';
    
    
    
   /**
    * generarOt::Contenido()
    * 
    * @return
    */
   function Contenido(){        
    
     $sql = "SELECT descripcion codigo, descripcion from unidades WHERE activo = 1 and descripcion in('Dias','Horas')";
     $arrUnidad = $this->Consulta($sql);   
    
     $sql = 'SELECT id_planta codigo, descripcion from plantas WHERE activo = 1';
     $arrPlantas = $this->Consulta($sql);    
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Generar Informe</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">Generar OT</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                    
                                    <div class="form-group">
                                        <label for="nombre">Informes:</label>
                                        '.
                                        
                                        $this->crearSelect('id_planta','id_planta',$arrPlantas,false,false,false,'class="form-control"').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                    
                                                                   
                                                
                                    <button type="button" id="buscarMecanismo" class="btn btn-primary">Buscar mecanismos</button>
                                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                        </div>
                    </div>
                </div>                    

        </section>  ';    
        
    }
    
  

    /**
     * generarOt::buscarMecanismos()
     * @author Javier Ardila
     *  Realiza busqueda de mecanimos que se van a  agendar para una o varias plantas
     * @return none
     */  
  function buscarMecanismos(){
            $arrMecanismos = $this->traerMecMetAgendar();
            $cantidad = count($arrMecanismos);
            
            echo '<div class="alert alert-info alert-dismissable">
                    Se encontrar&oacute;n <strong>'.$cantidad .'</strong> trabajos para agendar
                  </div>';
                  if($cantidad > 0){
                      echo '<button type="button" class="btn btn-success" onclick="fn_crearOt();"><i class="fa fa-check"></i> Crear Ot</button>
                      <div id="divCrearOt"> </div>
                      ';
                  }
  }
    /**
     * generarOt::crearOt()
     * @author Javier Ardila
     *  Recibe información de $this->_datos para ingresar la OT.
     * @return none
     */    
  public function crearOt(){
    //imprimir($this->_datos);
    $this->guardaOt();
    $this->guardaDetalleOt();
  }
  
    /**
     * generarOt::guardaOt()
     * @author Javier Ardila
     *  Guarda la data en la tabla OT.
     * @return none
     */     
  
  public function guardaOt(){
    $sql = "INSERT INTO `ot` (
	`id_planta`,
        `fecha_inicial`,
	`fecha_final`,
	`observacion_inicial`,
	`id_usuario_incial`,
	`fecha_registro_inical`,
	`estado`
)
VALUES
	(
		'".$this->_datos['id_planta']."',
                '".$this->_datos['fecha_ini']."',
		'".$this->_datos['fecha_fin']."',
		'".$this->_datos['observaciones']."',
		'".$this->_datos['id_usuario']."',
		NOW(),
		0
	)";
    
    $this->QuerySql($sql);
  }
  
  public function guardaDetalleOt(){  
    $idOt = $this->mysqli->insert_id;
    $sql = "
    INSERT INTO `ot_detalle` (
	`id_ot`,
	`id_mecanismos`,
	`id_metodos`,
	`id_tareas`,
	`id_lubricante`,
	`id_frecuencias`,
	`codunidad_frec`,
	`puntos`,
	`cantidad`,
    `cantidad_real`,
    `codunidad_cant`,
    `codunidad_cant_real`,
    `fecha_prog`,
    `fecha_real`,
    `ejecutado`,
    `observaciones_prog`,
    `minutos_ejec_prog`,
    `minutos_ejec_real`
    
)

		SELECT
        '".$idOt."',
        meca.`id_mecanismos`,
    	mec.id_metodos,
    	mec.id_tareas,
    	mec.cod_lubricante,
    	mec.id_frecuencias,
        fre.id_unidad,
    	mec.puntos,
    	mec.cantidad,
        mec.cantidad cantidad_real,
        mec.id_unidad_cant,
        mec.id_unidad_cant id_cantidad_real,
        mec.proxima_fecha_ejec,
        mec.proxima_fecha_ejec fecha_real,
        '1',
        mec.`observaciones`,
        mec.`minutos_ejecucion`,
        mec.`minutos_ejecucion`
                
        FROM
            mec_met mec
            INNER JOIN frecuencias fre on mec.id_frecuencias = fre.id_frecuencias
            INNER JOIN mecanismos meca ON mec.id_mecanismos = meca.id_mecanismos
            AND mec.proxima_fecha_ejec <= '".$this->_datos['fecha_fin']."'
            INNER JOIN componentes com ON meca.id_componente = com.id_componentes
            INNER JOIN equipos eq ON com.id_equipos = eq.id_equipos
            INNER JOIN secciones sec ON eq.id_secciones = sec.id_secciones
            INNER JOIN plantas pl ON sec.id_planta = pl.id_planta
            AND pl.id_planta = '".$this->_datos['id_planta']."'        
	WHERE meca.id_mecanismos not in (select d.id_mecanismos from ot_detalle d inner join ot o on (d.id_ot=o.id_ot) where o.estado=0)";
    $this->QuerySql($sql);
    
    echo '<div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <strong>Correcto!</strong> Se ha generado la OT '.$idOt.'.</div>';
    
  }
  
  public function traerMecMetAgendar(){
    $whereHoras ='';
  if($this->_datos['id_unidad'] == "Horas"){
        $whereHoras = " AND  mec.horas_acum_prox_prog > eq.horas_acum";    
    }
    $sql = "SELECT
            		meca.`id_mecanismos`,
                	mec.id_metodos,
                	mec.id_tareas,
                	mec.cod_lubricante,
                	mec.id_frecuencias,
                	mec.cod_lubricante,
                	mec.puntos,
                	mec.cantidad,
                	'codunidad_cant' codunidad_cant
            FROM
            	mec_met mec
            INNER JOIN mecanismos meca ON mec.id_mecanismos = meca.id_mecanismos
            AND mec.proxima_fecha_ejec <= '".$this->_datos['fecha_fin']."'
            INNER JOIN componentes com ON meca.id_componente = com.id_componentes
            INNER JOIN equipos eq ON com.id_equipos = eq.id_equipos
            INNER JOIN secciones sec ON eq.id_secciones = sec.id_secciones
            INNER JOIN plantas pl ON sec.id_planta = pl.id_planta
            AND pl.id_planta = '".$this->_datos['id_planta']."' 
	    WHERE meca.id_mecanismos not in (select d.id_mecanismos from ot_detalle d inner join ot o on (d.id_ot=o.id_ot) where o.estado=0)
        ".$whereHoras;
            return  $this->Consulta($sql);
  }
  
  
    /**
     * generarOt::guardarDatos()
     * 
     * @return
     */
    function guardarDatos(){
        $this->runActualizar();        
    }

    /**
     * generarOt::fn_guardar()
     * 
     * @return
     */
    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * generarOt::runEliminar()
     * 
     * @return
     */
    function runEliminar(){
        $sql = 'UPDATE '.$this->Table .' SET activo = 0 WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $this->QuerySql($sql);
        //$_respuesta = array('Codigo' => 1, "Mensaje" => 'Se ha eliminado el item con &eacute;xito');
        echo 'Se ha eliminado el item con &eacute;xito';
    }
    
    /**
     * generarOt::fn_editar()
     * 
     * @return
     */
    function fn_editar(){
        
    }
    
    /**
     * generarOt::getDatos()
     * 
     * @return
     */
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    /**
     * generarOt::_mostrar()
     * 
     * @return
     */
    function _mostrar(){
      /**  $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');*/
        $html = $this->Cabecera();
        $html .= $this->contenido();
      //  $html .= $this->tablaDatos();
        $html .= $this->Pata();
        echo $html;
    }
    
   
}
?>