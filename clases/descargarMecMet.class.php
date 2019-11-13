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
class descarcarMecMet extends crearHtml{
    
  public function traerMecMet(){
        

        $sql = "SELECT
  mec.id_mec_met Codigo, 
  pl.descripcion planta,
  sec.descripcion seccion,
  eq.id_equipos id_equipo,
  eq.descripcion equipo,
  eq.consecutivo e_consec_equipo,
  eq.codigo_empresa e_codigo_empresa,
  com.id_componentes id_componente,
  com.descripcion componente,
  com.consecutivo c_consec_componente,
  com.codigo_empresa c_codigo_empresa,
  com.tempmaxima c_temp_maxima, 
  meca.id_mecanismos id_mecanismo,
  meca.descripcion mecanismo,
  meca.codigoempresa m_codigo_empresa,
  meca.consecutivo m_consec_mecanismo,
  meca.tempoperacion m_temp_operacion,
  me.descripcion metodo,
  me.descripcion metodo,
  tar.descripcion tareas,
  lub.descripcion lubricante,
  F.descripcion Frecuencia,
  AL.aplicacion,
  mec.puntos,
  mec.minutos_ejecucion,
  mec.cantidad,
  uni.abreviatura unidad,
  mec.ultima_fecha_ejec Ultima_prog,
  mec.proxima_fecha_ejec Proxima_Prog
FROM
  mec_met mec
INNER JOIN
  mecanismos meca ON mec.id_mecanismos = meca.id_mecanismos
LEFT JOIN
  unidades uni ON uni.id_unidades = mec.id_unidad_cant
INNER JOIN
  componentes com ON meca.id_componente = com.id_componentes
INNER JOIN
  equipos eq ON com.id_equipos = eq.id_equipos
INNER JOIN
  secciones sec ON eq.id_secciones = sec.id_secciones
INNER JOIN
  plantas pl ON sec.id_planta = pl.id_planta
INNER JOIN
  metodos me ON mec.id_metodos = me.id_metodos
LEFT JOIN
  tareas tar ON tar.id_tareas = mec.id_tareas
LEFT JOIN
  lubricantes lub ON lub.id_lubricantes = mec.cod_lubricante
LEFT JOIN
  frecuencias F ON F.id_frecuencias = mec.id_frecuencias
LEFT JOIN
  aplicaciones_lub AL ON AL.id_aplicacion = mec.id_aplicacion
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
                                            <th>E Cod Empresa</th>
                                            <th>Componente</th>
                                            <th>C Cod Empresa</th>
                                            <th>Mecanismo</th>
                                            <th>M Cod Empresa</th>
                                            <th>Metodo</th>
                                            <th>Tarea</th>
                                            <th>Ptos</th>
                                            <th>Lubricante</th>
                                            <th>Cant</th>
                                            <th>Und</th>
                                            <th>Observaciones</th>
                                            <th>Ejec</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    foreach($arrDetalleOts as $Detalle){
                                        $html .=  '<tr>
                                            <td align="center">'.utf8_encode($Detalle['fecha_prog']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['seccion']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['equipo']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['e_codigo_empresa']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['componente']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['c_codigo_empresa']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['mecanismo']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['m_codigo_empresa']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['metodo']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['tareas']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['puntos']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['lubricante']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['cantidad']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['unidad']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['observaciones_ejec']).'</td>
                                            <td align="center"><input type="checkbox" name="chk" value=""> </td>
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
    
    /**
     * descarcarMecMet::getDatos()
     * Extrae todos los datos y los retorna como Json, creada para llenar formularios en el editar de cada interfaz 
     * @return void
     */
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    /**
     * descarcarMecMet::_mostrar()
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
     * descarcarMecMet::tablaDatos()
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
INNER JOIN lubricantes lub ON lub.id_lubricantes = lub.id_lubricantes
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