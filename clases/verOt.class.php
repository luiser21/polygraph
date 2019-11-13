<?php
/**
 * mecanismos
 * 
 * @package carLub
 * @author Javier Ardila
 * Clase dependientede crearHtml.class.php
 * @copyright 2017
 * @version 0.1
 * @access public
 */
class verOt extends crearHtml{
    
    public $_titulo = 'VER OT';
    public $_subTitulo = 'Ver detalle de una ot';
    public $_datos = '';
    public $Table = 'mecanismos';
    public $PrimaryKey = 'id_mecanismos';
    
    
    
   /**
    * mecanismos::Contenido()
    * Crea primer formulario de interfaz visual para el usuario.
    * 
    * @return Html con contenido de formulario
    */
   function Contenido(){
    
     $sql = "SELECT id_ot as codigo, observacion_inicial descripcion ,
CONCAT(`descripcion`,' OT # ',`id_ot` ,' - ', `fecha_inicial`,' / ', `fecha_final`, ' - ', `observacion_inicial`) as descripcion
FROM ot inner join plantas on (ot.id_planta=plantas.id_planta) ORDER BY  id_ot DESC";
     $arrOts = $this->Consulta($sql);
     

        $html =  '<section class="main-content-wrapper">
            <!-- <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Seleccione la programación que desea ver </li>
                    </ol>
                </div>
            </div> !-->
            
<div class="col-md-16">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">VER OT</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form" action="verOtCsv.php">
                                    <div class="form-group">
                                        <label for="nombre">Ots Generadas:</label>
                                        '.
                                        $this->crearSelect('id_ot','id_ot',$arrOts,false,false,false,'class="form-control"')
                                        .
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                    
                                    <button type="button" id="verDetalleOt" class="btn btn-primary">Ver detalle programaci&oacute;n</button>
                                    <button type="button" id="descargarDetalleOt" class="btn btn-primary">Descargar detalle programaci&oacute;n</button>
                                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                                </form>
                            </div>
                        </div>
                    </div> 
                    
                        </div>
                    </div>
                </div>              
            
        </section>  ';
        
       // $html .= $this->formularioMecMet();
        
        return $html;             
        
    }
    
    public function traerDetalleOt(){
        $this->_datos['id_ot'] = ( isset($_REQUEST['id_ot']) ) ? $_REQUEST['id_ot'] : $this->_datos['id_ot'] ;

        $sql = "SELECT 
    pl.descripcion planta,
    sec.descripcion seccion,
	eq.descripcion equipo,
    com.descripcion componente,
	meca.descripcion mecanismo,
    me.descripcion metodo,
    fre.descripcion frecuencia,
	otd.puntos,
	tar.descripcion tareas,
	lub.descripcion lubricante,
	otd.cantidad,
	otd.observaciones_prog,
    uni.abreviatura unidad,
    otd.fecha_prog,
    otd.minutos_ejec_prog,
    eq.codigo_empresa eq_codigo_empresa,
    meca.codigoempresa as mc_codigoempresa
    
FROM
 ot_detalle otd 
INNER JOIN unidades uni on uni.id_unidades = otd.codunidad_cant  
INNER JOIN mecanismos meca ON otd.id_mecanismos = meca.id_mecanismos
INNER JOIN componentes com ON meca.id_componente = com.id_componentes
INNER JOIN equipos eq ON com.id_equipos = eq.id_equipos
INNER JOIN secciones sec ON eq.id_secciones = sec.id_secciones
INNER JOIN plantas pl ON sec.id_planta = pl.id_planta
INNER JOIN metodos me ON otd.id_metodos = me.id_metodos
INNER JOIN tareas tar ON tar.id_tareas = otd.id_tareas
INNER JOIN lubricantes lub ON lub.id_lubricantes = otd.id_lubricante
INNER JOIN frecuencias fre ON otd.id_frecuencias = fre.id_frecuencias
where otd.id_ot = '".$this->_datos['id_ot']."'
ORDER BY fecha_prog,pl.descripcion,sec.descripcion ASC
";

return $this->Consulta($sql);

    }
    
    public function verDetalleOt(){
        
        $arrDetalleOts = $this->traerDetalleOt();       

        $html = '<section id="main-content" class="animated fadeInUp">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <div class="table-responsive">
                                <table id="tablaDetalle" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Secci&oacute;n</th>
                                            <th>Equipo</th>
                                            <th>Cod Equipo</th>
                                            <th>Componente</th>
                                            <th>Mecanismo</th>
                                            <th>Cod Mecanismo</th>
                                            <th>Metodo</th>
                                            <th>Frecuencia</th>
                                            <th>Tarea</th>
                                            <th>Ptos</th>
                                            <th>Lubricante</th>
                                            <th>Cant</th>
                                            <th>Und</th>
					    <th>Min</th>
                                            <th>Observaciones</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    foreach($arrDetalleOts as $Detalle){
                                        $html .=  '<tr>
                                            <td align="center">'.utf8_encode($Detalle['fecha_prog']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['seccion']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['equipo']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['eq_codigo_empresa']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['componente']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['mecanismo']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['mc_codigoempresa']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['metodo']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['frecuencia']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['tareas']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['puntos']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['lubricante']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['cantidad']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['unidad']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['minutos_ejec_prog']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['observaciones_prog']).'</td>
 
                                        </tr>';
                                    }
                                        
                                        
$html .='                           </tbody>
                                </table>
                                </div>
           </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>';
                
                echo $html;
        
    }
    
    
    function guardarDatos(){
        $this->runActualizar();        
    }
    
    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * mecanismos::runEliminar()
     * Realiza eliminar Logico de la tabla parametrizada en los objetos globales 
     * @return void
     */
    function runEliminar(){
        $sql = 'UPDATE '.$this->Table .' SET activo = 0 WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $this->QuerySql($sql);
        //$_respuesta = array('Codigo' => 1, "Mensaje" => 'Se ha eliminado el item con &eacute;xito');
        echo 'Se ha eliminado el item con &eacute;xito';
    }
    
    function fn_editar(){
        
    }
    
    /**
     * mecanismos::getDatos()
     * Extrae todos los datos y los retorna como Json, creada para llenar formularios en el editar de cada interfaz 
     * @return void
     */
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    /**
     * mecanismos::_mostrar()
     * Muestra los datos armados atravez de 3 metodos $this->Cabecera(); $this->contenido(); $this->Pata();  
     * @return void
     */
    function _mostrar(){
        $html = $this->Cabecera();
        $html .= $this->contenido();
        $html .= $this->Pata();
        echo $html;
    }
    
    /**
     * mecanismos::tablaDatos()
     * Muestra listado de datos en las interfaces de usuario 
     * @return Tabla con contenido HTML (Lista de datos)
     */
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = "SELECT 
    pl.descripcion planta,
    sec.descripcion seccion,
	eq.descripcion equipo,
    com.descripcion componente,
	meca.descripcion mecanismo,
    me.descripcion metodo,
	otd.puntos,
	me.descripcion metodo,
	tar.descripcion tareas,
	lub.descripcion lubricante,
	otd.cantidad,
	otd.observaciones_ejec,
    uni.abreviatura unidad,
    otd.fecha_prog
    
FROM
 ot_detalle otd 
INNER JOIN mec_met mec on mec.id_mecanismos = otd.id_mecanismos
INNER JOIN unidades uni on uni.id_unidades = otd.codunidad_cant  
INNER JOIN mecanismos meca ON mec.id_mecanismos = meca.id_mecanismos
INNER JOIN componentes com ON meca.id_componente = com.id_componentes
INNER JOIN equipos eq ON com.id_equipos = eq.id_equipos
INNER JOIN secciones sec ON eq.id_secciones = sec.id_secciones
INNER JOIN plantas pl ON sec.id_planta = pl.id_planta
INNER JOIN metodos me ON mec.id_metodos = me.id_metodos
INNER JOIN tareas tar ON tar.id_tareas = mec.id_tareas
INNER JOIN lubricantes lub ON lub.id_lubricantes = mec.cod_lubricante
where otd.id_ot = '3'
ORDER BY fecha_prog,pl.descripcion,sec.descripcion ASC";
        
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
    		$tablaHtml .= $this->print_table($_array_formu, 4, true, 'table table-striped table-bordered',"id='tablaDatos'");
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