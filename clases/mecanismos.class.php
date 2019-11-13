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
class mecanismos extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA MECANISMOS';
    public $_subTitulo = 'Crear Mecanismos';
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
    
    
     $sql = 'SELECT id_planta codigo, descripcion from plantas WHERE activo = 1';
     $arrPlantas = $this->Consulta($sql);

     
    $_tipos_lub = array();
        array_push($_tipos_lub, array( 'codigo' => 'AG', 'descripcion' => 'Aceite / Grasa') );
        array_push($_tipos_lub, array( 'codigo' => 'A', 'descripcion' => 'Aceite') );
        array_push($_tipos_lub, array( 'codigo' => 'G', 'descripcion' => 'Grasa') );
        
        $html =  '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Mecanismos</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">MECANISMOS</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                    <div class="form-group">
                                        <label for="nombre">Mecanismo:</label>
                                        '.
                                        
                                        $this->create_input('text','descripcion','descripcion','Nombre del mecanismo',false,'form-control required borrar').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0','borrar').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                    
                                     <div class="form-group">
                                        <label for="id_cursos">Planta:</label>
                                        '.$this->crearSelect('id_planta','id_planta',$arrPlantas,false,false,false,'class="form-control" onchange="traerCombo(this.value,\'combo_id_secciones\',\'comboSeccion\')"').'
                                        
                                        
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
                                        <label for="id_cursos">Componente:</label>
                                        <span id="combo_id_componentes"> -- </span>
                                        
                                    </div>                                                                                                                                
                                     <div class="form-group">
                                        <label for="id_cursos">Codigo empresa:</label>
                                        '.$this->create_input('text','codigoempresa','codigoempresa','Codigo empresa ',false,'form-control').'
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">Consecutivo:</label>
                                        '.$this->create_input('text','consecutivo','consecutivo','Consecutivo ',false,'form-control').'
                                        
                                    </div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='<button type="button" id="guardarMecMet" class="btn btn-primary">Guardar Mecanismo e Ingresar Programaci&oacute;n</button>
                                    <!-- <button type="button" id="guardarCurso" class="btn btn-primary">Guardar Mecanismo</button> --> ';
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
        
        $html .= $this->formularioMecMet();
        
        return $html;             
        
    }
    
    function comboSeccion(){
        $sql = 'SELECT `id_secciones` codigo, descripcion FROM `secciones` WHERE `id_planta` = '.$this->_datos.' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_secciones','id_secciones',$arr,false,false,false,'class="form-control" onchange="traerCombo(this.value,\'combo_id_equipos\',\'comboEquipo\')"');
    }
    
    function comboEquipo(){
        $sql = 'SELECT `id_equipos` codigo, descripcion FROM `equipos` WHERE `id_secciones` = '.$this->_datos.' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_equipos','id_equipos',$arr,false,false,false,'class="form-control"  onchange="traerCombo(this.value,\'combo_id_componentes\',\'comboComponente\')"');
    }        
    
    function comboComponente(){
        $sql = 'SELECT `id_componentes` codigo, descripcion FROM `componentes` WHERE `id_equipos` = '.$this->_datos.' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_componente','id_componentes',$arr,false,false,false,'class="form-control"');
    }    
    
    
    public function formularioMecMet(){
        
     $sql = 'SELECT id_mecanismos codigo, descripcion from mecanismos WHERE activo = 1';
     $arrMecanismos = $this->Consulta($sql);
     
     $sql = 'SELECT id_metodos codigo, descripcion from metodos WHERE activo = 1';
     $arrMetodos = $this->Consulta($sql);
     
     $sql = 'SELECT id_lubricantes codigo, descripcion from lubricantes WHERE activo = 1 ORDER BY descripcion';
     $arrLubricantes = $this->Consulta($sql);
     
     $sql = 'SELECT id_aplicacion codigo, aplicacion descripcion from aplicaciones_lub';
     $arrAplicacion = $this->Consulta($sql);
     
     
     
     $sql = 'SELECT id_frecuencias codigo, descripcion from frecuencias WHERE activo = 1';
     $arrFrecuencias = $this->Consulta($sql);
         
     $sql = 'SELECT id_tareas codigo, descripcion from tareas WHERE activo = 1';
     $arrTareas = $this->Consulta($sql); 
     
     $sql = 'SELECT  `id_unidades` codigo,  `descripcion` FROM  `unidades` WHERE  `activo` =1';
     $arrUnidades = $this->Consulta($sql);
        
            $html =  $html = '
                <div class="modal fade" id="divMecMet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                   
                   
                   
                           <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> Programaci&oacute;n para mecanismo <strong id="mecTitulo"> - </strong></h4>
                </div>
                <div class="modal-body">
                    
                    <form class="form-horizontal" id="formCrearMecMet" role="form">
                    ';
            
           
            $html .= '
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="nombre" class="col-sm-2 control-label">Metodos:</label>
                                        <div class="col-sm-10">'.
                                        var_dump( $this);
                                            $this->crearSelect('id_metodos','id_metodos',$arrMetodos,false,false,false,'class="form-control requirido limpiar" onchange="metodoSellando($(this).text())"').
                                            $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0',$this->PrimaryKey).
                                            $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '</div>
                                        
                                    </div>
                                    
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Tarea:</label>
                                        <div class="col-sm-10">
                                            '.$this->crearSelect('id_tareas','id_tareas',$arrTareas,false,false,false,'class="form-control limpiar noSellado"').'
                                        </div>
                                    </div>
                                    
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Lubricante:</label>
                                        <div class="col-sm-10">
                                            '.$this->crearSelect('cod_lubricante','cod_lubricante',$arrLubricantes,false,false,false,'class="form-control noSellado"').'
                                        </div>
                                    </div>                                                                           
                                    
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Aplicacion:</label>
                                        <div class="col-sm-10">
                                            '.$this->crearSelect('id_aplicacion','id_aplicacion',$arrAplicacion,false,false,false,'class="form-control noSellado"').'
                                        </div>
                                    </div>                                     
                                                                   
                                    
                                   <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Puntos:</label>
                                        <div class="col-sm-10">
                                            '.$this->create_input('text','puntos','puntos','Puntos a lubricar',false,'form-control limpiar  noSellado').'
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Frecuencias:</label>
                                        <div class="col-sm-10">
                                            '.$this->crearSelect('id_frecuencias','id_frecuencias',$arrFrecuencias,false,false,false,'class="form-control noSellado"').'
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Minuto Ejecuci&oacute;n:</label>
                                        <div class="col-sm-10">
                                            '.$this->create_input('text','minutos_ejecucion','minutos_ejecucion','Minutos de ejecuci&oacute;n',false,'form-control limpiar noSellado').'
                                        </div>
                                    </div>                     
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Fecha Proxima:</label>
                                        <div class="col-sm-10">
                                            '.$this->create_input('date','proxima_fecha_ejec','proxima_fecha_ejec','Feca Proxima',false,'form-control limpiar noSellado').'
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="id_cursos">Observaciones:</label>
                                        <div class="col-sm-10">
                                            '.$this->create_input('textarea','observaciones','observaciones','Observaciones',false,'form-control limpiar noSellado').'
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
                                            '.$this->crearSelect('id_unidad_cant','id_unidad_cant',$arrUnidades,false,false,false,'class="form-control noSellado"').'
                                        </div>
                                    </div>                                                                                                          
                                <div class="panel" id="ResultadoModal" style="display:none">RESULTADO</div>
                                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="guardarMecMetModal">Guardar programaci&oacute;n</button>
                    <button type="button" id="limpiarMecanismo" class="btn btn-default" data-dismiss="modal">Terminar</button>
                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                </div>
            </div>
        </div>
                </div>'; 
        return $html;
    }
    
    function guardarDatos(){
        $this->runActualizar();        
    }
    
    function guardarMecanismos(){
        //imprimir($this->_datos);
        $this->Table = 'mecanismos';
        $this->PrimaryKey = 'id_mecanismos';
        $this->save($this->_datos);
        $id = ($this->mysqli->insert_id==0) ? $this->_datos['id_mecanismos'] : $this->mysqli->insert_id;
        
        $_respuesta = array('guardo'=>1,
                            'id'=>$id,
                            'nombreMecaniso'=>$this->_datos['descripcion']
                            );
                            
                            
                            
       echo json_encode($_respuesta); 
    }

    function guardarMecMet(){
        //imprimir($this->_datos);
        $this->Table = 'mec_met';
        $this->PrimaryKey = 'id_mec_met';
        $_respuesta = '';
        try{$this->save($this->_datos);
            $_respuesta = array('Codigo' => 1, "Mensaje" => 'Datos Ingresados con &eacute;xito');
        }catch(Exception $e){
            $_respuesta = array('Codigo' => 0, "Mensaje" => 'Error, por favor revisar los datos guardados e ingresar => '.$e);
        }
        //$id = $this->mysqli->insert_id;
//        
//        $_respuesta = array('guardo'=>1,
//                            'id'=>$id,
//                            'nombreMecaniso'=>$this->_datos['descripcion']
//                            );        
       echo json_encode($_respuesta); 
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
        $sql = "DELETE FROM mec_met WHERE id_mecanismos IN (SELECT id_mecanismos FROM mecanismos WHERE id_mecanismos=".$this->_datos.")";
        $this->QuerySql($sql);
        $sql = "DELETE FROM mecanismos WHERE id_mecanismos=".$this->_datos;
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
        $resultado = $res[0];
        //$resultado = array_map('utf8_encode',$resultado);
        print_r( json_encode( $resultado ) );
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
        // 
        $verProgramacion = <<<OE
         
        CONCAT(  '<div class="fa fa-reorder" style="cursor:pointer" title="Ver Programacion" ONCLICK=javascript:irProgramacion(',  `$this->PrimaryKey` ,  '); />' ) VerProgram
        
OE;
        $sql = 'SELECT
        t.id_mecanismos,
    P.descripcion planta,
  S.descripcion secciones,
  E.descripcion Equipo,
  C.`descripcion` Componente,        
  t.descripcion Mecanismo,
  '.$verProgramacion.' 
FROM
  `mecanismos` t
INNER JOIN
    `componentes`C ON C.id_componentes = t.id_componente AND C.`activo` = 1 
INNER JOIN 
  equipos E ON E.id_equipos = C.`id_equipos` AND E.`activo` = 1 
INNER JOIN
  secciones S ON S.id_secciones = E.id_secciones AND S.`activo` = 1 
INNER JOIN
   plantas P ON P.id_planta = S.id_planta and P.`activo` = 1   
WHERE
  t.`activo` = 1 
##LIMIT 1,1646';
        
        $datos = $this->Consulta($sql,1); 
        $y=0;
        foreach($datos as $value){
            $datos[$y]['secciones']=utf8_encode($datos[$y]['secciones']);
            $datos[$y]['Mecanismo']=utf8_encode($datos[$y]['Mecanismo']);
            $datos[$y]['VerProgram']='<div class="fa fa-reorder" 
                style="cursor:pointer" 
                title="Ver Programacion" 
                ONCLICK=javascript:irProgramacion('.$datos[$y]['id_mecanismos'].')></div>';
            $datos[$y]['Editar']="<div class='fa fa-edit' 
                style='cursor:pointer' 
                title='Editar'
                ONCLICK=javascript:fn_editar(".$datos[$y]['id_mecanismos'].",'/mecanismos.php')></div>";
            $datos[$y]['Eliminar']="<div class='icon-ban' 
                style='cursor:pointer' 
                title='Inactivar'
                ONCLICK=javascript:fn_eliminar(".$datos[$y]['id_mecanismos'].",'/mecanismos.php','formCrear')></div>";
            
            $y++;
                
        }
        
        
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
            //imprimir($_array_formu);
            //   exit;
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