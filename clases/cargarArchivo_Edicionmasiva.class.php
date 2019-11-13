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
class cargarArchivo extends crearHtml{
    
    public $_titulo = 'ACTUALIZAR MASIVO';
    public $_subTitulo = 'Subir Archivo y enviar actualizar';
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
                                <h3 class="panel-title">ACTUALIZAR DATOS MASIVAMENTE</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                                             

                                    <div class="form-group">
                                        <label for="nombre">Archivo:</label>
                                        '.
                                        $this->create_input('file','archivo','arhivo',false,'0')
                                        .
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='<button type="button" id="subirArchivo" class="btn btn-primary">Actualizar Datos</button>';
                                    }
                                    $html.='<div id="Resultado" style="display:none">RESULTADO</div>
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
     
    /**
     * editarOt::registrarArchivos()
     * 
     * @return
     */
    function registrarArchivos(){
        $Ruta = './archivosApp/';
		$origen = $_FILES['archivo']['tmp_name'];
		$nombreImagen = $_FILES['archivo']['name'];
		
		$destino =$Ruta.$nombreImagen;
		$tipo = $_FILES['archivo']['type'];

		$tamano = $_FILES['archivo']['size'];
        try{
            $this->leerCsv($origen );
        }catch(Exception $e){
           $_respuesta = array('Codigo' => $e->getCode(), "Mensaje" => $e->getMessage());
           echo json_encode( $_respuesta  ); 
        }	

    }
    
    function leerCsv($archivo){

        $registros = array();
        $c = 0;
        $fila = 1;
        if (($fichero = fopen( $archivo, "r")) !== FALSE) {
            // Lee los nombres de los campos
            $nombres_campos = fgetcsv($fichero, 0, ";", "\"", "\"");
            $num_campos = count($nombres_campos);            
            try{
            while (($datos = fgetcsv($fichero, 1000, ";")) !== FALSE) {
                    $numero = count($datos);                   
                   
                    $this->validarData($datos[0],'numero',$c,'CODIGO');
                    $this->validarData($datos[5],'numero',$c,'E_CONSEC_EQUIPO');
                    $this->validarData($datos[6],'numero',$c,'E_CODIGO_EMPRESA');
                    $this->validarData($datos[9],'numero',$c,'C_CONSEC_COMPONENTE');
                    $this->validarData($datos[10],'numero',$c,'C_CODIGO_EMPRESA');
                    $this->validarData($datos[11],'numero',$c,'C_TEMP_MAXIMA');
                    $this->validarData($datos[14],'numero',$c,'M_CODIGO_EMPRESA');
                    $this->validarData($datos[15],'numero',$c,'M_CONSEC_MECANISMO');
                    $this->validarData($datos[16],'numero',$c,'M_TEMP_OPERACION');
                    $this->validarData($datos[22],'numero',$c,'PUNTOS');
                    $this->validarData($datos[23],'numero',$c,'MINUTOS_EJECUCION');
                    $this->validarData($datos[24],'numero',$c,'CANTIDAD');
                    
                    $arrData[$c]['CODIGO']= trim($datos[0]);
                    $arrData[$c]['E_CONSEC_EQUIPO']= trim($datos[5]);
                    $arrData[$c]['E_CODIGO_EMPRESA']= trim($datos[6]);
                    $arrData[$c]['C_CONSEC_COMPONENTE']=trim($datos[9]);
                    $arrData[$c]['C_CODIGO_EMPRESA']=trim($datos[10]); 
                    $arrData[$c]['C_TEMP_MAXIMA']=trim($datos[11]); 
                    $arrData[$c]['M_CODIGO_EMPRESA']=trim($datos[14]); 
                    $arrData[$c]['M_CONSEC_MECANISMO']=trim($datos[15]); 
                    $arrData[$c]['M_TEMP_OPERACION']=trim($datos[16]); 
                    $arrData[$c]['PUNTOS']=trim($datos[22]); 
                    $arrData[$c]['MINUTOS_EJECUCION']=trim($datos[23]); 
                    $arrData[$c]['CANTIDAD']=trim($datos[24]); 
                    $arrData[$c]['ULTIMA_PROG']=trim($datos[26]); 
                    $arrData[$c]['PROXIMA_PROG']=trim($datos[27]); 
                    
                    $sql="SELECT MM.id_mecanismos,ME.id_componente,CO.id_equipos  FROM mec_met MM
                            INNER JOIN mecanismos ME ON ME.id_mecanismos=MM.id_mecanismos
                            INNER JOIN componentes CO ON CO.id_componentes=ME.id_componente
                            where id_mec_met=".$arrData[$c]['CODIGO'];
                    $datos = $this->Consulta($sql,1);
                    
                    $sql="UPDATE mecanismos SET codigoempresa='".$arrData[$c]['M_CODIGO_EMPRESA']."',
                          consecutivo='". $arrData[$c]['M_CONSEC_MECANISMO']."',
                          tempoperacion='".$arrData[$c]['M_TEMP_OPERACION']."'
                          where id_mecanismos=".$datos[0]['id_mecanismos'];
                    $this->QuerySql($sql);
                    
                    $sql="UPDATE componentes SET codigo_empresa='".$arrData[$c]['C_CODIGO_EMPRESA']."',
                          consecutivo='". $arrData[$c]['C_CONSEC_COMPONENTE']."',
                          tempmaxima='".$arrData[$c]['C_TEMP_MAXIMA']."'
                          where id_componentes=".$datos[0]['id_componente'];
                    $this->QuerySql($sql);
                    
                    $sql="UPDATE equipos SET codigo_empresa='".$arrData[$c]['E_CODIGO_EMPRESA']."',
                          consecutivo='". $arrData[$c]['E_CONSEC_EQUIPO']."'
                          where id_equipos=".$datos[0]['id_equipos'];
                    $this->QuerySql($sql);
                    
                    $sql="UPDATE mec_met SET puntos='".$arrData[$c]['PUNTOS']."',
                          minutos_ejecucion='". $arrData[$c]['MINUTOS_EJECUCION']."',
                          cantidad='". $arrData[$c]['CANTIDAD']."'
                          ,ultima_fecha_ejec='". $arrData[$c]['ULTIMA_PROG']."'
                          ,proxima_fecha_ejec='". $arrData[$c]['PROXIMA_PROG']."'
                          where id_mec_met=".$arrData[$c]['CODIGO'];;
                    $this->QuerySql($sql);
                    
                    
                    $c++;
            }
            
        /**
         * Envia actualización masiva
        */
        
       
            //echo 'Se han editado ('.$j.') registros de '.$c;
            $_respuesta = array('Codigo' => 0, "Mensaje" => 'Se han editado '.$c.' registros. ');
            echo json_encode( $_respuesta );
        }catch(Exception $e){
            echo $e->getMessage();
        }

        fclose($fichero);
        }
        //$_respuesta = array('Codigo' => 99, "Mensaje" => 'Se han editado ('.$c.') registros con exito');
            
        //print_r(json_encode($_respuesta));        
    }     

    /**
     * cargarArchivo::validarData()
     * Valida que la data que se esta insertando sea según lo exigido al usuario
     * @param mixed $data dato a validar
     * @param mixed $tipo numero, texto, fecha(dd/mm/aaaa)
     * @return void
     */
    function validarData($data,$tipo,$linea,$campo){
        $c = $linea;
        switch($tipo){
            case 'numero':
                if( empty($data) && $data<>'0' ){
                    $_respuesta = array('Codigo' => 0, "Mensaje" => "No puede estar vacio el campo '".$campo."'. Fila ".($c+2).'. <br> No se actualizo ningun registro');
                    echo json_encode( $_respuesta ) ;
                    exit;
                }    
            break;
            case 'fecha':
                $fecha = explode('/',$data);
                if( empty($data) || @!checkdate($fecha[1],$fecha[0],$fecha[2]) ){
                    throw new Exception("No puede estar vacio el campo '".$campo."' y debe contener format de fecha <strong>dd/mm/aaaa</strong>. <br> Fila ".($c+2).'. <br> No se actualizo ningun registro', 99);
                }    
            break;
        }
        
        
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
        
        $and = '';
        
        if( !empty($idD) && is_array($idD) ){
            $and = " AND id_detalle NOT IN(".implode(',',$idD).") ";
        }elseif( isset( $this->_datos['ejec'] ) )
            $and = " AND id_detalle != '".$idD."'";
            
        $sql = "UPDATE `ot_detalle` SET ejecutado = '1' where  $and ";
        $this->QuerySql($sql);
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
            $fecha_r = $this->keyToVal($this->_datos['fecha_r']);
            $observaciones_r = $this->keyToVal($this->_datos['observaciones_r']);
    
            if( is_array( $id_detalle ) ){
                $i = 0;
                foreach( $id_detalle as $v ){
                    $sql = "UPDATE `ot_detalle` SET `cantidad_real`='".$cantidad_real[$i]."',`fecha_real`='".$fecha_r[$i]."',`ejecutado`=1,`observaciones_ejec`= '".$observaciones_r[$i]."'
                            WHERE id_detalle =  '".$v."'
                            ";
                    $this->QuerySql($sql);
                    $_respuesta = array('Codigo' => 99, "Mensaje" => 'Se han modificado con exito los registros');
                    $i++;
                    
                }     
            }else{
                $sql = "UPDATE `ot_detalle` SET `cantidad_real`='".$this->_datos['cantidad_real']."',`fecha_real`='".$this->_datos['fecha_r']."',`ejecutado`=1,`observaciones_ejec`= '".$this->_datos['observaciones_r']."'
                            WHERE id_detalle =  '".$this->_datos['id_detalle']."'";
                $this->QuerySql($sql);
                $_respuesta = array('Codigo' => 99, "Mensaje" => 'El registro se modifico con exito');
            }
        }
        print_r(json_encode($_respuesta));
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
INNER JOIN lubricantes lub ON lub.id_lubricantes = lub.id_lubricantes
where otd.id_ot = '3'
ORDER BY pl.descripcion, sec.descripcion, q.descripcion, com.descripcion, meca.descripcion, me.descripcion ASC";
        
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