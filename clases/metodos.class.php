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
class metodos extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA METODOS';
    public $_subTitulo = 'Crear metodos';
    public $_datos = '';
    public $Table = 'metodos';
    public $PrimaryKey = 'id_metodos';
    
    
    
   /**
    * Index::Contenido()
    * Crea primer formulario de interfaz visual para el usuario.
    * 
    * @return Html con contenido de formulario
    */
   function Contenido(){
    $_tipo = array();
    array_push($_tipo, array( 'codigo' => 'Predictivo', 'descripcion' => 'Predictivo') );
    array_push($_tipo, array( 'codigo' => 'Preventivo', 'descripcion' => 'Preventivo') );
    $sql = 'SELECT id_tareas codigo, descripcion from tareas WHERE activo = 1';
    $arrTareas = $this->Consulta($sql);
        
    $html= '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Metodos</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">METODOS</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Metodo:</label>
                                        '.
                                        
                                        $this->create_input('text','descripcion','descripcion','Nombre del metodo',false,'form-control required').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Tipo:</label>
                                        '.$this->crearSelect('tipo','tipo',$_tipo,false,false,false,'class="form-control required"').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Mostrar en cartas:</label>
                                        '.$this->crearSelect('mostrarencarta','mostrarencarta',$this->getEstados(),false,false,false,'class="form-control required"').'
                                        
                                    </div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='<button type="button" id="guardarCurso" class="btn btn-primary">Guardar Metodo</button>';
                                    }
                                    $html.='<div class="panel" id="Resultado" style="display:none">RESULTADO</div>
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
    
    function guardarDatos(){
        if($this->validarSellado()){
            $this->runActualizar();
        }else{
            $_respuesta = array('Codigo' => 1, "Mensaje" => 'No se puede Ingresar un metodo que se llame Sellado');
        }
        print_r(json_encode($_respuesta));
                
    }
    
    function validarSellado(){
        if($this->_datos['descripcion'] != 'Sellado'){
            return true;    
        }else{
            return 0;
        }
        
        
    }
    
    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * Index::runEliminar()
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
     * Index::getDatos()
     * Extrae todos los datos y los retorna como Json, creada para llenar formularios en el editar de cada interfaz 
     * @return void
     */
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
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

       // $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        
        $editar = <<<OE
                IF(`descripcion`!='Sellado',CONCAT(  '<div class="fa fa-edit" style="cursor:pointer" title="Editar" ONCLICK=javascript:fn_editar(',  `$this->PrimaryKey` ,  ',\'{$this->_file}\'); />' ),'N/A') Editar
OE;

        $eliminar = <<<OE
                IF(`descripcion`!='Sellado',CONCAT(  '<div class="icon-ban" style="cursor:pointer" title="Eliminar" ONCLICK=javascript:fn_eliminar(',  $this->PrimaryKey ,  ',\'{$this->_file}\'); />' ),'N/A') Eliminar
OE;

        $sql = "SELECT `descripcion`, `tipo`, IF(`mostrarencarta`=1,'SI','NO') CARTA , $editar,$eliminar FROM `metodos` WHERE activo = 1";
        
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
    		$tablaHtml .= $this->print_table($_array_formu, 5, true, 'table table-striped table-bordered',"id='tablaDatos'");
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