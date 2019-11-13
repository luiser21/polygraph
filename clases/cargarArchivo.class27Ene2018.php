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
                                <h3 class="panel-title">VER OT</h3>
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
                                        
                                    </div>
                                    
                                    <button type="button" id="subirArchivo" class="btn btn-primary">Actualizar Detalles de ot</button>
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
	    $this->leerCsv($origen );	

    }
    
    function leerCsv($archivo){
        $registros = array();
        $c = 0;
        if (($fichero = fopen( $archivo, "r")) !== FALSE) {
            // Lee los nombres de los campos
            $nombres_campos = fgetcsv($fichero, 0, ",", "\"", "\"");
            $num_campos = count($nombres_campos);
            // Lee los registros
            while (($datos = fgetcsv($fichero, 0, "|", "\"", "\"")) !== FALSE) {
            // Crea un array asociativo con los nombres y valores de los campos
            
            $sql = "UPDATE `ot_detalle` SET `cantidad_real`='".$datos[19]."',`minutos_ejec_real`='".$datos[20]."',`fecha_real`='".$datos[18]."',`ejecutado`='".$datos[22]."',`observaciones_ejec`= '".$datos[21]."'
                            WHERE id_detalle =  '".$datos[1]."'
                            ";
            $this->QuerySql($sql);
            //imprimir($sql);
            
            $c++;
        }
        fclose($fichero);
        }
        //$_respuesta = array('Codigo' => 99, "Mensaje" => 'Se han editado ('.$c.') registros con exito');
        echo 'Se han editado ('.$c.') registros con exito';    
        //print_r(json_encode($_respuesta));        
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
            
        $sql = "UPDATE `ot_detalle` SET ejecutado = '1' where id_ot = '".$idOt."' $and ";
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