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
class equiposHorasMasivo extends crearHtml{
    
    public $_titulo = 'ACTUALIZAR MASIVO';
    public $_subTitulo = 'Actualizar Horas por equipos';
    public $_datos = '';
    public $Table = 'equipos';
    public $PrimaryKey = 'id_equipos';
    
    
    
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
                                <h3 class="panel-title">ACTUALIZAR HORAS ACUMULADAS DE EQUIPOS</h3>
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
                                         $html.='<button type="button" id="subirArchivo" class="btn btn-primary">Actualizar Horas Acomuladas</button>';
                                    }
                                    $html.='<button type="button" id="descargarPlantilla" class="btn btn-primary">Descargar Plantilla</button>
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
            
            $sql = "UPDATE `equipos` SET `horas_acum` = '".$datos[4]."'
                            WHERE id_equipos =  '".$datos[0]."'
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
       
  
    
    function generarPlantilla(){
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=file.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
                
                $sql = "SELECT  `id_equipos` , p.descripcion Planta, s.descripcion Seccion, e.`descripcion` Equipo, e.horas_acum
        FROM  `equipos` e
        INNER JOIN secciones s ON s.`id_secciones` = e.`id_secciones` 
        INNER JOIN plantas p ON s.id_planta = p.id_planta";
        $datos = $this->Consulta($sql); 
        $arrdatos = $this->generateHead($datos);
        echo $this->print_table_plain($arrdatos);
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
        
    }   
}
?>