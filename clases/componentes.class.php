<?php
/**
 * Index
 * 
 * @package carLub
 * @author Javier Ardila
 * Clase dependientede crearHtml.class.php
 * @copyright 2017
 * @version 0.1
 * @access public
 */
class Index extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA COMPONENTES';
    public $_subTitulo = 'Los componentes son asociados en un arbol de Planta => Seccion =>Equipo';
    public $_datos = '';
    public $Table = 'componentes';
    public $PrimaryKey = 'id_componentes';
     
    
    
   /**
    * Index::Contenido()
    * Crea primer formulario de interfaz visual para el usuario.
    * 
    * @return Html con contenido de formulario
    */
   function Contenido(){
    
    $sql = 'SELECT id_planta codigo, descripcion from plantas WHERE activo = 1';
    $arrPlantas = $this->Consulta($sql);
    
        $html= '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Componentes</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">COMPONENTES</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Componente:</label>
                                        '.
                                        
                                        $this->create_input('text','descripcion','descripcion','Nombre del componente',false,'form-control required').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Planta:</label>
                                        '.$this->crearSelect('id_planta','id_planta',$arrPlantas,false,false,false,'class="form-control required" onchange="traerCombo(this.value,\'combo_id_secciones\',\'comboSeccion\')"').'
                                        
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Seccion:</label>
                                        <span id="combo_id_secciones"> -- </span>
                                        
                                    </div>                                    
                                    
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Equipos:</label>
                                        <span id="combo_id_equipos"> -- </span>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Codigo Empresa:</label>
                                        '.$this->create_input('text','codigo_empresa','codigo_empresa','Codigo de la empresa',false,'form-control required').'
                                        
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Consecutivo:</label>
                                        '.$this->create_input('text','consecutivo','consecutivo','escriba consecutivo',false,'form-control required').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Fabricante:</label>
                                        '.$this->create_input('text','id_fabricante','id_fabricante','cod fabricante',false,'form-control required').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Temperatura Maxima:</label>
                                        '.$this->create_input('text','tempmaxima','tempmaxima','Temperatura Maxima ',false,'form-control required').'
                                        
                                    </div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='<button type="button" id="guardarCurso" class="btn btn-primary">Guardar Componente</button>';
                                    }
                                    $html.='<div id="Resultado" style="display:none">RESULTADO</div>
                                </form>
                            </div>
                        </div>
                    </div> '.$this->tablaDatos().'
                    
                        </div>
                    </div>
                </div>                    

        </section>  ';  
        return $html;
        
    }
    
    function comboSeccion(){
        $sql = 'SELECT `id_secciones` codigo, descripcion FROM `secciones` WHERE `id_planta` = '.$this->_datos.' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_secciones','id_secciones',$arr,false,false,false,'class="form-control required" onchange="traerCombo(this.value,\'combo_id_equipos\',\'comboEquipo\')"');
    }
    
    function comboEquipo(){
        $sql = 'SELECT `id_equipos` codigo, descripcion FROM `equipos` WHERE `id_secciones` = '.$this->_datos.' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_equipos','id_equipos',$arr,false,false,false,'class="form-control required"');
    }        
    
    
    
    function guardarDatos(){
        $this->runActualizar();        
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * Index::runEliminar()
     * Realiza eliminar de las tablas componentes=> mecanismos => mec_met
     * @return void
     */
    function runEliminar(){
       
        $sql = "DELETE FROM mec_met WHERE id_mecanismos IN (SELECT id_mecanismos FROM mecanismos WHERE id_componente=".$this->_datos.")";
        $this->QuerySql($sql);
        $sql = "DELETE FROM mecanismos WHERE id_componente=".$this->_datos;
        $this->QuerySql($sql);
        $sql = "DELETE FROM componentes WHERE id_componentes=".$this->_datos;
        $_respuesta = array('Codigo' => 0, "Mensaje" => '<strong> OK: </strong> El registro se ha eliminado.');
        try {            
            $this->QuerySql($sql);
        }
        catch (exception $e) {
            $_respuesta = array('Codigo' => 99, "Mensaje" => $e->getMessage());
        }
        
        print_r(json_encode($_respuesta));
    }
    
    function fn_editar(){
        
    }
    
    /**
     * Index::getDatos()
     * Extrae todos los datos y los retorna como Json, creada para llenar formularios en el editar de cada interfaz 
     * @return void
     */
    function getDatos(){
        $res = $this->Consulta('SELECT C.*, P.id_planta FROM '.$this->Table .' C
                                    INNER JOIN
                      equipos E ON E.id_equipos = C.`id_equipos`
                    INNER JOIN
                      secciones S ON S.id_secciones = E.id_secciones
                    INNER JOIN
                      plantas P ON P.id_planta = S.id_planta
  
        WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        $resultado = $res[0];
       // $resultado = array_map('utf8_encode',$resultado);
        
        print_r( json_encode( $resultado ) );
    }
    
    /**
     * Index::_mostrar()
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
     * Index::tablaDatos()
     * Muestra listado de datos en las interfaces de usuario 
     * @return Tabla con contenido HTML (Lista de datos)
     */
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = 'SELECT
        C.id_componentes,
  P.descripcion planta,
  S.descripcion secciones,
  E.descripcion Equipo,
  C.`descripcion` Componente
 ,'.$editar.','.$eliminar.' 
FROM
  `componentes` C
INNER JOIN
  equipos E ON E.id_equipos = C.`id_equipos`
INNER JOIN
  secciones S ON S.id_secciones = E.id_secciones
INNER JOIN
  plantas P ON P.id_planta = S.id_planta
WHERE
        
      C.`activo` = 1';
        
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
    		$tablaHtml .= $this->print_table($_array_formu, 7, true, 'table table-striped table-bordered',"id='tablaDatos'");
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