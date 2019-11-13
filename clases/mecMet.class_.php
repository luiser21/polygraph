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
class mecMet extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR CARTA LUBRICACI&Oacute;N';
    public $_subTitulo = '';
    public $_datos = '';
    public $Table = 'mec_met';
    public $PrimaryKey = 'id_mec_met';
    
    
    
   /**
    * Index::Contenido()
    * Crea primer formulario de interfaz visual para el usuario.
    * 
    * @return Html con contenido de formulario
    */
   function Contenido(){
    
     $sql = 'SELECT id_mecanismos codigo, descripcion from mecanismos WHERE activo = 1';
     $arrMecanismos = $this->Consulta($sql);
     
     $sql = 'SELECT id_metodos codigo, descripcion from metodos WHERE activo = 1';
     $arrMetodos = $this->Consulta($sql);
     
     $sql = 'SELECT id_lubricantes codigo, descripcion from lubricantes WHERE activo = 1';
     $arrLubricantes = $this->Consulta($sql);
     
     $sql = 'SELECT id_aplicacion codigo, aplicacion descripcion from aplicaciones_lub';
     $arrAplicacion = $this->Consulta($sql);
     
     
     
     $sql = 'SELECT id_frecuencias codigo, descripcion from frecuencias WHERE activo = 1';
     $arrFrecuencias = $this->Consulta($sql);
         
     $sql = 'SELECT id_tareas codigo, descripcion from tareas WHERE activo = 1';
     $arrTareas = $this->Consulta($sql); 
     
     $sql = 'SELECT  `id_unidades` codigo,  `descripcion` FROM  `unidades` WHERE  `activo` =1';
     $arrUnidades = $this->Consulta($sql);     
     $input = '';
     if( isset( $_REQUEST['id'] ) ){
      $input =  $this->create_input('hidden','id_mecanismos','id_mecanismos',false,$_REQUEST['id']);   
     }else if( isset( $_REQUEST['idE'] ) ){
        $input = $this->create_input('hidden','id_equipos_e','id_equipos_e',false,$_REQUEST['idE']);
     }
     
        
     
     
        $html = '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Carta Lubricaci&oacute;n</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="formCrear" role="form">
                    

                        
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="nombre" class="col-sm-2 control-label">Metodos:</label>
                                        <div class="col-sm-10">'.
                                            $this->crearSelect('id_metodos','id_metodos',$arrMetodos,false,false,false,'class="form-control requirido limpiar" onchange="metodoSellando($(this).text())"').
                                            $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0',$this->PrimaryKey).
                                            $input.
                                            $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '</div>
                                        
                                    </div>
                                    
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Tarea:</label>
                                        <div class="col-sm-10">
                                            '.$this->crearSelect('id_tareas','id_tareas',$arrTareas,false,'0','Ninguno','class="form-control limpiar noSellado"').'
                                        </div>
                                    </div>
                                    
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Lubricante:</label>
                                        <div class="col-sm-10">
                                            '.$this->crearSelect('cod_lubricante','cod_lubricante',$arrLubricantes,false,'0','Ninguno','class="form-control noSellado" ').'
                                        </div>
                                    </div>                                                                           
                                    
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Aplicacion:</label>
                                        <div class="col-sm-10">
                                            '.$this->crearSelect('id_aplicacion','id_aplicacion',$arrAplicacion,false,'0','Ninguno','class="form-control noSellado"').'
                                        </div>
                                    </div>                                     
                                                                   
                                    
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Puntos:</label>
                                        <div class="col-sm-10">
                                            '.$this->create_input('text','puntos','puntos','Puntos a lubricar',false,'form-control limpiar noSellado').'
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Frecuencias:</label>
                                        <div class="col-sm-10">
                                            '.$this->crearSelect('id_frecuencias','id_frecuencias',$arrFrecuencias,false,'0','Ninguno','class="form-control noSellado"').'
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Minuto Ejecuci&oacute;n:</label>
                                        <div class="col-sm-10">
                                            '.$this->create_input('text','minutos_ejecucion','minutos_ejecucion','Minutos de ejecuci&oacute;n',false,'form-control limpiar noSellado').'
                                        </div>
                                    </div>                     
                                    
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Cantidad:</label>
                                        <div class="col-sm-10">
                                            '.$this->create_input('text','cantidad','cantidad','Cantidad de lubricante',false,'form-control limpiar noSellado').'
                                        </div>
                                    </div>
                                                                        
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Unidad</label>
                                        <div class="col-sm-10">
                                            '.$this->crearSelect('id_unidad_cant','id_unidad_cant',$arrUnidades,false,'0','Ninguno','class="form-control noSellado"').'
                                        </div>
                                    </div>   
                                <button type="button" id="guardaMecMet" class="btn btn-primary">Guardar Programaci&oacute;n</button>                                                                                                       
                                <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
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
        $sql = 'DELETE FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos;
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
        if(isset($_REQUEST['m'])){
            $post =  ( is_array($_REQUEST['m']) || is_object($_REQUEST['m']) )? $this->serializeArray($_REQUEST['m']) : $_REQUEST['m'];
        }
        //imprimir($post);
        $sqlWhere = '';
        if(isset($_REQUEST['id'])){
            $sqlWhere = ' WHERE mec.id_mecanismos = '. $_REQUEST['id'];
        }else if(isset($post['id_mecanismos'])){
            $sqlWhere = ' WHERE mec.id_mecanismos = '. $post['id_mecanismos'];
        }else if(isset($_REQUEST['idE'])){
            $sqlWhere = ' WHERE eq.id_equipos = '. $_REQUEST['idE'];
        }else if(isset($post['id_equipos_e'])){
            $sqlWhere = ' WHERE eq.id_equipos = '. $post['id_equipos_e'];
        }


        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
//          
$sql = 'SELECT
  pl.descripcion planta,
  sec.descripcion seccion,
  eq.descripcion equipo,
  com.descripcion componente,
  meca.descripcion mecanismo,
  me.descripcion metodo,
  me.descripcion metodo,
  tar.descripcion tareas,
  lub.descripcion lubricante,
  F.descripcion Frecuencia,
  AL.aplicacion,
  mec.puntos,
  mec.minutos_ejecucion,
  mec.cantidad,
  uni.abreviatura unidad
  ,'.$editar.','.$eliminar.'
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

  '.$sqlWhere.'
';
        
        $datos = $this->Consulta($sql,1); 
        if(count($datos)){
            $_array_formu = array();
            $_array_formu = $this->generateHead($datos);
            $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();
            
            $tablaHtml  ='<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body recargaDatos"  style="page-break-after: always;">
                            <div class="table-responsive">';
    		$tablaHtml .= $this->print_table($_array_formu, 15, true, 'table table-striped table-bordered',"id='tablaDatos'");
            $tablaHtml .='</div>
           </div>
                        </div>
                    </div>
                </div>';
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