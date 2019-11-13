<?php
/**
 * simbologia
 * 
 * @package carLub
 * @author Javier Ardila
 * Clase dependiente de crearHtml.class.php
 * @copyright 2017
 * @version 0.1
 * @access public
 */
class simbologia extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA SIMBOLOGIA';
    public $_subTitulo = 'Crear Simbología';
    public $_datos = '';
    public $Table = 'simbologia';
    public $PrimaryKey = 'id_simbologia';
    
    
    
   /**
    * simbologia::Contenido()
    * Crea primer formulario de interfaz visual para el usuario.
    *  Extrae informacion de las tablas colores y frecuencias.
    * @return Html con contenido de formulario
    */
   function Contenido(){
    
     $sql = 'SELECT id_colores codigo, descripcion from colores WHERE activo = 1';
     $arrColores = $this->Consulta($sql);
     
     $sql = 'SELECT id_frecuencias codigo, descripcion from frecuencias WHERE activo = 1';
     $arrFrecuencias = $this->Consulta($sql);
     
     $sql = 'SELECT id_clasificaciones codigo, descripcion from clasificaciones WHERE activo = 1';
     $arrClasificaciones = $this->Consulta($sql);
     
     
        
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Simbologías</li>
                    </ol>
                </div> 
            </div>
             
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">SIMBOLOGIA</h3>
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
                                        
                                        $this->create_input('text','descripcion','descripcion','Nombre del archivo',false,'form-control').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Frecuencia:</label>
                                        '.$this->crearSelect('id_frecuencia','id_frecuencia',$arrFrecuencias,false,false,false,'class="form-control"').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Color:</label>
                                        '.$this->crearSelect('id_colores','id_colores',$arrColores,false,false,false,'class="form-control"').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Clasificaciones:</label>
                                        '.$this->crearSelect('id_clasificaciones','id_clasificaciones',$arrClasificaciones,false,false,false,'class="form-control"').'
                                        
                                    </div>                               
                                    
                                    
                                    
                                   <div class="form-group">
                                        <label for="id_cursos">Ruta:</label>
                                        '. $this->create_input('file','ruta','ruta','simbolo en .jpg',false,'form-control').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Tipo:</label>
                                        '. $this->create_input('text','tipo','tipo','Tipo',false,'form-control').'
                                        
                                    </div>
                                     
                                    
                                    
                                    
                                    <button type="button" id="guardarCurso" class="btn btn-primary">Guardar Simbolo</button>
                                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                                </form>
                            </div>
                        </div>
                    </div> '.$this->tablaDatos().'
                    
                        </div>
                    </div>
                </div>                    

        </section>  ';    
        
    }
    
    function guardarDatos(){
        $this->runActualizar();        
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * simbologia::runEliminar()
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
     * simbologia::getDatos()
     * Extrae todos los datos y los retorna como Json, creada para llenar formularios en el editar de cada interfaz 
     * @return void
     */
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    /**
     * simbologia::_mostrar()
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
     * simbologia::tablaDatos()
     * Muestra listado de datos en las interfaces de usuario 
     * @return Tabla con contenido HTML (Lista de datos)
     */
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = 'SELECT t.`descripcion`,t.`fecha_registro`,'.$editar.','.$eliminar.' FROM '.$this->Table.' t
          WHERE t.activo = 1';
        
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