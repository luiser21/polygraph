<?php
class equipos extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA EQUIPOS';
    public $_subTitulo = 'Ingrese o edite los equipos';
    public $_datos = '';
    public $Table = 'equipos';
    public $PrimaryKey = 'id_equipos';
    
    
    
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
                        <li class="active">Administraci&oacute;n => Equipos</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">EQUIPOS</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form" enctype="multipart/form-data">
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Planta:</label>
                                        '.$this->crearSelect('id_planta','id_planta',$arrPlantas,false,false,false,'class="form-control" onchange="traerCombo(this.value,\'combo_id_secciones\',\'comboSeccion\')"').'
                                        
                                        
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Seccion:</label>
                                        <span id="combo_id_secciones"> -- </span>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre Equipo:</label>
                                        '.
                                        
                                        $this->create_input('text','descripcion','descripcion','Nombre del equipo',false,'form-control required',false).
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                                                        
                                    <div class="form-group">
                                        <label for="id_cursos">Fabricante:</label>
                                        '.$this->create_input('text','id_fabricante','id_fabricante','Fabricante',false,'form-control').'
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">Codigo empresa:</label>
                                        '.$this->create_input('text','codigo_empresa','codigo_empresa','Codigo empresa ',false,'form-control').'
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">Consecutivo:</label>
                                        '.$this->create_input('text','consecutivo','consecutivo','Consecutivo ',false,'form-control').'
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">Codigo carta:</label>
                                        '.$this->create_input('text','codigo_carta','codigo_carta','Codigo Carta ',false,'form-control').'
                                        
                                    </div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='<button type="button" id="guardarCurso" class="btn btn-primary">Guardar Equipos</button>';
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
    
    function comboSeccion(){
        $sql = 'SELECT `id_secciones` codigo, descripcion FROM `secciones` WHERE `id_planta` = '.$this->_datos.' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_secciones','id_secciones',$arr,false,false,false,'class="form-control"');
    }
    
    function guardarDatos(){
        $this->runActualizar();        
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        $sql = "DELETE FROM equipos_imagen WHERE id_equipos=".$this->_datos;
        $this->QuerySql($sql);
        $sql = "DELETE FROM mec_met WHERE id_mecanismos IN (SELECT id_mecanismos FROM mecanismos WHERE id_componente IN (SELECT id_componentes FROM componentes WHERE id_equipos=".$this->_datos."))";
        $this->QuerySql($sql);
        $sql = "DELETE FROM mecanismos WHERE id_componente IN (SELECT id_componentes FROM componentes WHERE id_equipos=".$this->_datos.")";
        $this->QuerySql($sql);
        $sql = "DELETE FROM componentes WHERE id_equipos=".$this->_datos;
        $this->QuerySql($sql);
        $sql = "DELETE FROM equipos WHERE id_equipos=".$this->_datos;
        $this->QuerySql($sql);
      
    }
    
    function fn_editar(){
        
    }
    
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        $resultado = $res[0];
        $resultado = array_map('utf8_encode',$resultado);        
        print_r( json_encode( $res[0] ) );
    }
    
    function _mostrar(){
        $html = $this->Cabecera();
        $html .= $this->contenido();
        $html .= $this->Pata();
        echo $html;
    }
    
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $carta = $this->Imagenes($this->PrimaryKey,4,'vistaImprimir.php'); 
       
     $verProgramacion = <<<OE
         
        CONCAT(  '<div class="fa fa-reorder" style="cursor:pointer" title="Ver Programacion" ONCLICK=javascript:irProgramacionEquipos(',  `$this->PrimaryKey` ,  '); />' ) Ver_Programacion
        
OE;
        $sql = 'SELECT
                	p.descripcion AS planta,
                	s.descripcion as Seccion,
                    e.descripcion AS Equipo,
                    e.`codigo_carta`,
                    '.$verProgramacion.','.$editar.','.$eliminar.','.$carta.' 
                FROM
                	equipos e
                INNER JOIN secciones s on s.id_secciones = e.id_secciones
                INNER JOIN plantas p ON p.id_planta = s.id_planta
                WHERE e.activo = 1';
        
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
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">�</button>
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