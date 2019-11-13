<?php
/**
 * mecanismos
 * 
 * @package carLub
 * @author Javier Ardila
 * Clase dependiente de crearHtml.class.php
 * @copyright 2017
 * @version 0.1
 * @access public
 */
class editarOt extends crearHtml{
    
    public $_titulo = 'EDITAR OT';
    public $_subTitulo = 'Ver detalle y editar una ot';
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
CONCAT( `id_ot` ,' - ', `fecha_inicial`,' / ', `fecha_final`, ' - ', `observacion_inicial`) as descripcion
FROM ot WHERE estado = 0 ORDER BY  id_ot DESC";
     $arrOts = $this->Consulta($sql);
     

        $html =  '
        <section class="main-content-wrapper">
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
        
        return $html;             
        
    }
    
    public function traerDetalleOt(){
        $this->_datos['id_ot'] = ( isset($_REQUEST['id_ot']) ) ? $_REQUEST['id_ot'] : $this->_datos['id_ot'] ;

        $sql = "SELECT 
    otd.id_ot,
    otd.id_detalle,
    mec.id_mec_met,
    pl.descripcion planta,
    sec.descripcion seccion,
	eq.descripcion equipo,
    eq.codigo_empresa eq_codigo_empresa,
    com.descripcion componente,
	meca.descripcion mecanismo,
    meca.codigoempresa as mc_codigoempresa,
    me.descripcion metodo,
    fre.descripcion frecuencia,
	otd.puntos,
	me.descripcion metodo,
	tar.descripcion tareas,
	lub.descripcion lubricante,
	otd.cantidad,
    uni.abreviatura unidad,
    otd.minutos_ejec_prog,
    otd.observaciones_prog,
    otd.fecha_prog,
    otd.fecha_real,
    otd.cantidad_real,
    otd.minutos_ejec_real,
    otd.observaciones_ejec,
    otd.ejecutado
    
    
    
FROM
 ot_detalle otd 
INNER JOIN mec_met mec on mec.id_mecanismos = otd.id_mecanismos and mec.id_metodos = otd.id_metodos 
INNER JOIN unidades uni on uni.id_unidades = otd.codunidad_cant  
INNER JOIN mecanismos meca ON mec.id_mecanismos = meca.id_mecanismos
INNER JOIN componentes com ON meca.id_componente = com.id_componentes
INNER JOIN equipos eq ON com.id_equipos = eq.id_equipos
INNER JOIN secciones sec ON eq.id_secciones = sec.id_secciones
INNER JOIN plantas pl ON sec.id_planta = pl.id_planta
INNER JOIN metodos me ON mec.id_metodos = me.id_metodos
INNER JOIN tareas tar ON tar.id_tareas = mec.id_tareas
INNER JOIN lubricantes lub ON lub.id_lubricantes = otd.id_lubricante
INNER JOIN frecuencias fre ON otd.id_frecuencias = fre.id_frecuencias
where otd.id_ot = '".$this->_datos['id_ot']."'  
ORDER BY pl.descripcion, sec.descripcion, eq.descripcion, com.descripcion, meca.descripcion, me.descripcion ASC
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
                            <form name="formCrear">
                                <table id="tablaDetalle" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Planta</th>
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
                                            <th>Minutos</th>
                                            <th>Observ prog</th>
                                            <th>Cant Real</th>
                                            <th>Min Real</th>
                                            <th>Fecha Real</th>
                                            <th>Observ Ejec</th>
                                            <th>Editar</th>
                                            <th>No Ejec</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $i=0;
                                    foreach($arrDetalleOts as $Detalle){
                                        $html .=  '<tr>
                                            <td align="center">'.utf8_encode($Detalle['fecha_prog']).'</td>
                                            <td align="center">'.utf8_encode($Detalle['planta']).'</td>
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
                                           <td align="center">'.$this->create_input('text','cantidad_real','cantidad_real',false,$Detalle['cantidad_real'],$i,false,'maxlength="4" size="4" disabled="1"').'</td>
                                            <td align="center">'.$this->create_input('text','minutos_real','minutos_real',false,$Detalle['minutos_ejec_real'],$i,false,'maxlength="4" size="4" disabled="1"').'</td>
                                           <td align="center">'.$this->create_input('text','fecha_r','fecha_r',"DD/MM/YYYY",$Detalle['fecha_real'],$i,false,'maxlength="10" size="10" disabled="1"').'</td> 
                                            <td align="center">'.$this->create_input('textarea','observaciones_r','observaciones_r',false,$Detalle['observaciones_ejec'],$i,false,' disabled="1"').'</td>
                                            <td align="center"><input type="checkbox" name="chk" value="" onclick="habilitarCampo('.$i.')" > </td>
                                            <td align="center"><input type="checkbox" name="ejec" value="'.$Detalle['id_detalle'].'"> 
                                                                '.$this->create_input('hidden','id_detalle','id_detalle',false,$Detalle['id_detalle'],$i,false,' disabled="1"').'
                                                                '.$this->create_input('hidden','id_mec_met','id_mec_met',false,$Detalle['id_mec_met'],$i,false,'').'
                                            </td>
                                                                                 
 					</tr>';
                                        $i++;
                                    }
                                        
                                        
$html .='                           </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" onclick="fn_guardaEdicion();">Guardar Cambios</button>
                                <div id="preGuarda"><button type="button" class="btn btn-primary" onclick="pre_cierreOt();">Cerrar OT</button></div>
                                <div id="divObservacionesFinal" style="display:none">
                                    <div class="form-group">
                                        <label for="nombre">Observaciones Finales:
                                        
                                        '.$this->create_input('hidden','idOt','idOt',false,$arrDetalleOts[0]['id_ot']).'</label>
                                        '.
                                        $this->create_input('textarea','observaciones_final','observaciones_final')
                                        .

                                        '
                                        
                                    </div>
                                  <button type="button" class="btn btn-primary" onclick="fn_guardaOt();">Cerrar OT</button>
                                </div>
                                <div class="panel" id="ResultadoEdicion" style="display:none">RESULTADO</div>
                                </form>
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
     * editarOt::guardarDatos()
     * 
     * @return void
     */
    function guardarDatos(){
        $this->guardaOtDetalle();
    }
    
    
    /**
     * editarOt::actualizaEjecutados()
     * Actualiza ejecutado 1 de todos los detalles excetuando los que tengan check "No ejecutado"
     * $this->_datos['ejec']  = arreglo que trae los NO ejecutados 
     * @return void
     */
    function actualizaEjecutados(){        
        $idD = ( isset( $this->_datos['ejec'] ) && !empty( $this->_datos['ejec'] ) ) ? $this->_datos['ejec'] : '';
        $idD = $this->keyToVal( $idD );
        $idOt= $this->_datos['idot'];
        $and = '';
        
        if( !empty($idD) && is_array($idD) ){
            $and = " AND id_detalle NOT IN(".implode(',',$idD).") ";
        }elseif( isset( $this->_datos['ejec'] ) )
            $and = " AND id_detalle != '".$idD."'";
            
    //    $sql = "UPDATE `ot_detalle` SET ejecutado = '1' where id_ot = '".$idOt."' $and ";
    //    $this->QuerySql($sql);
    }
    
    /**
     * editarOt::guardaOtDetalle()
     * Metodo se llama desde el boton guardar Cambios, actualiza ot_detalle unicamente con los campos modificados 
     * Actualiza Ejecutado en 1
     * @return void
     */
    function guardaOtDetalle(){
        if(!isset( $this->_datos['id_detalle'] ) ){
            $_respuesta = array( 'Codigo' => 1, "Mensaje" => 'No se encontro ningun registro modificado para editar' );
            
        }else{
            $id_detalle = $this->keyToVal($this->_datos['id_detalle']);
            $cantidad_real = $this->keyToVal($this->_datos['cantidad_real']);
            $minutos_real = $this->keyToVal($this->_datos['minutos_real']);
            $fecha_r = $this->keyToVal($this->_datos['fecha_r']);
            $observaciones_r = $this->keyToVal($this->_datos['observaciones_r']);
    
            if( is_array( $id_detalle ) ){
                $i = 0;
                foreach( $id_detalle as $v ){
                    $sql = "UPDATE `ot_detalle` SET `cantidad_real`='".$cantidad_real[$i]."', `minutos_ejec_real`='".$minutos_real[$i]."', `fecha_real`='".$fecha_r[$i]."',`ejecutado`=1,`observaciones_ejec`= '".$observaciones_r[$i]."'
                            WHERE id_detalle =  '".$v."'
                            ";
                    $this->QuerySql($sql);
                    $_respuesta = array('Codigo' => 99, "Mensaje" => 'Se han modificado con exito los registros');
                    $i++;
                    
                }     
            }else{
                $sql = "UPDATE `ot_detalle` SET `cantidad_real`='".$this->_datos['cantidad_real']."',`minutos_ejec_real`='".$this->_datos['minutos_real']."',`fecha_real`='".$this->_datos['fecha_r']."',`ejecutado`=1,`observaciones_ejec`= '".$this->_datos['observaciones_r']."'
                        WHERE id_detalle =  '".$this->_datos['id_detalle']."'";
                $this->QuerySql($sql);
                $_respuesta = array('Codigo' => 99, "Mensaje" => 'El registro se modifico con exito');
            }
        }
        print_r(json_encode($_respuesta));
    }
    
    
    
    public function cerrarOt(){        
        
     //   $this->actualizaEjecutados();
        /**
         * Actualiza los MecMet Con el cierre de OT.
         * 
        */
        
        
        $idD = ( isset( $this->_datos['ejec'] ) && !empty( $this->_datos['ejec'] ) ) ? $this->_datos['ejec'] : '';
        $idD = $this->keyToVal( $idD );
        $idOt= $this->_datos['idot'];
        $and = '';        
/**        
*        if( !empty($idD) && is_array($idD) ){
*            $and = " AND OTD.id_detalle NOT IN(".implode(',',$idD).") ";
*        }elseif( isset( $this->_datos['ejec'] ) )
*            $and = " AND OTD.id_detalle != '".$idD."'";        
*/        
	$and = " AND OTD.ejecutado = '1'";

        
        $mec_met = $this->keyToVal($this->_datos['id_mec_met']);
        if( is_array( $mec_met ) ){
            $i = 0;
            foreach( $mec_met as $v ){
                $sql = " 
                UPDATE `mec_met` MM
                INNER JOIN ot_detalle OTD ON MM.id_mecanismos = OTD.id_mecanismos and MM.id_metodos = OTD.id_metodos
                INNER JOIN frecuencias fr ON fr.id_frecuencias = MM.id_frecuencias                 
                SET ultima_fecha_ejec = OTD.fecha_real, `proxima_fecha_ejec` = ADDDATE(OTD.fecha_real, INTERVAL fr.dias_horas DAY)
                WHERE OTD.id_ot = '".$idOt."' $and ";
                $this->QuerySql($sql);
                $_respuesta = array('Codigo' => 99, "Mensaje" => 'Se han modificado con exito los registros');
                $i++;
            }     
            }else{
                $sql = "UPDATE `mec_met` MM
                INNER JOIN ot_detalle OTD ON MM.id_mecanismos = OTD.id_mecanismos and MM.id_metodos = OTD.id_metodos
                INNER JOIN frecuencias fr ON fr.id_frecuencias = MM.id_frecuencias                 
                SET ultima_fecha_ejec = OTD.fecha_real, `proxima_fecha_ejec` = ADDDATE(OTD.fecha_real, INTERVAL fr.dias_horas DAY)
                WHERE OTD.id_ot = '".$idOt."' AND `id_mec_met` = '".$this->_datos['id_mec_met']."' $and ";
                $this->QuerySql($sql);
                $_respuesta = array('Codigo' => 99, "Mensaje" => 'El registro se modifico con exito');
            } 
        /**
         * Realiza el cierre de OT.
         * 
        */            
        $sql = "UPDATE `ot` SET `fecha_cierre`=SYSDATE(),`observacion_final`='".$this->_datos['observaciones_final']."',`id_usuario_final`='".$_SESSION['id_usuario']."',`fecha_registro_final`=SYSDATE(),`estado`=1 WHERE id_ot = '".$this->_datos['id_ot']."'";
        $_respuesta = array('Codigo' => 99, "Mensaje" => 'Ot cerrada con exito');
        $this->QuerySql($sql);
        //print_r(json_encode($_respuesta));
        
       
        
        /**
         * SELECT `id_mec_met` , `ultima_fecha_ejec`,`proxima_fecha_ejec` , ADDDATE(SYSDATE(), INTERVAL fr.dias_horas DAY) DIAS FROM `mec_met` MM 
INNER JOIN frecuencias fr  ON fr.id_frecuencias = MM.id_frecuencias
WHERE `id_mec_met` = 2048;
*/
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
    function tablaDatos(){}
}
?>