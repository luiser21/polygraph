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
class lubricantes extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA LUBRICANTES';
    public $_subTitulo = 'Crear Lubricante';
    public $_datos = '';
    public $Table = 'lubricantes';
    public $PrimaryKey = 'id_lubricantes';
    
    
    
   /**
    * Index::Contenido()
    * Crea primer formulario de interfaz visual para el usuario.
    * 
    * @return Html con contenido de formulario
    */
   function Contenido(){


$arrClase = array();
    array_push($arrClase, array( 'codigo' => 'Mineral', 'descripcion' => 'Mineral') );
    array_push($arrClase, array( 'codigo' => 'Sintetico', 'descripcion' => 'Sintetico') );
    array_push($arrClase, array( 'codigo' => 'Vegetal', 'descripcion' => 'Vegetal') );
    
$arrTipo = array();
    array_push($arrTipo, array( 'codigo' => 'Aceite', 'descripcion' => 'Aceite') );
    array_push($arrTipo, array( 'codigo' => 'Grasa', 'descripcion' => 'Grasa') );
    array_push($arrTipo, array( 'codigo' => 'Pelicula Solida', 'descripcion' => 'Pelicula Solida') );
    
$arrCategoria = array();
    array_push($arrCategoria, array( 'codigo' => 'H1', 'descripcion' => 'H1') );            
    array_push($arrCategoria, array( 'codigo' => 'H2', 'descripcion' => 'H2') );
    array_push($arrCategoria, array( 'codigo' => 'H3', 'descripcion' => 'H3') );
    
    

     $sql = 'SELECT  `id_clasificaciones` codigo,  `descripcion` 
             FROM  `clasificaciones` 
             WHERE activo =1';
     $arrClasificaciones = $this->Consulta($sql);
    
     $sql = 'SELECT id_colores codigo, descripcion from colores WHERE activo = 1';
     $arrColores = $this->Consulta($sql);
        
        $html= '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Lubricantes</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">LUBRICANTES</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                    <div class="form-group">
                                        <label for="nombre">Lubricante:</label>
                                        '.
                                        
                                        $this->create_input('text','descripcion','descripcion','Nombre del lubricante',false,'form-control required').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                    

                                   <div class="form-group">
                                        <label for="id_cursos">Clase:</label>
                                        '.$this->crearSelect('clase','clase',$arrClase,false,false,false,'class="form-control required"').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Tipo:</label>
                                        '.$this->crearSelect('tipo','tipo',$arrTipo,false,false,false,'class="form-control required"').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Categor&iacute;a:</label>
                                        '.$this->crearSelect('categoria','categoria',$arrCategoria,false,false,false,'class="form-control required"').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Marca:</label>
                                        '. $this->create_input('text','marca','marca','Marca',false,'form-control required').'
                                        
                                    </div>

                                    <div class="form-group">
                                        <label for="id_cursos">Codigo Clasificacion:</label>
                                        '.$this->crearSelect('cod_clasificacion','cod_clasificacion',$arrClasificaciones,false,false,false,'class="form-control required"').'
                                        
                                    </div> '; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='<button type="button" id="guardarCurso" class="btn btn-primary">Guardar Lubricante</button>';
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
        $this->runActualizar();        
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

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = 'SELECT L.`descripcion`,L.`clase`, L.`tipo`, L.`categoria`, L.`marca`, C.descripcion as Clasificacion,'.$editar.','.$eliminar.' 
        FROM `lubricantes` L
        INNER JOIN clasificaciones C ON L.cod_clasificacion = C.id_clasificaciones
         WHERE L.activo = 1
            ORDER BY L.marca,L.clase,C.descripcion'
        ;
        
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
    		$tablaHtml .= $this->print_table($_array_formu, 8, true, 'table table-striped table-bordered',"id='tablaDatos'");
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