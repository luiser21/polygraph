<?php
class Index extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA FRECUENCIAS';
    public $_subTitulo = 'Crear frecuencia';
    public $_datos = '';
    public $Table = 'frecuencias';
    public $PrimaryKey = 'id_frecuencias';
    
    
    
   function Contenido(){
        
    $sql = "SELECT id_unidades codigo, descripcion from unidades WHERE activo = 1 and descripcion in('Dias','Horas')";
    $arrUnidad = $this->Consulta($sql);        
        
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Frecuencias</li>
                    </ol>
                </div>
            </div>
            <!--
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">FRECUENCIAS</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                    <div class="form-group">
                                        <label for="nombre">Frecuencia:</label>
                                        '.
                                        
                                        $this->create_input('text','descripcion','descripcion','Frecuencia',false,'form-control required').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Unidad:</label>
                                        '.$this->crearSelect('id_unidad','id_unidad',$arrUnidad,false,false,false,'class="form-control required"').'
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">Dias Hora:</label>
                                        '.$this->create_input('text','dias_horas','dias_horas','dias horas con que toma la frecuencia',false,'form-control required').'
                                        
                                    </div> 
                                    
                                    <button type="button" id="guardarCurso" class="btn btn-primary">Guardar Frecuencia</button>
                                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                                </form>
                            </div>
                        </div>
                    </div> --> '.$this->tablaDatos().'
                    
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
    
    function runEliminar(){
        $sql = 'UPDATE '.$this->Table .' SET activo = 0 WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $this->QuerySql($sql);
        //$_respuesta = array('Codigo' => 1, "Mensaje" => 'Se ha eliminado el item con &eacute;xito');
        echo 'Se ha eliminado el item con &eacute;xito';
    }
    
    function fn_editar(){
        
    }
    
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
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
        $sql = 'SELECT
                  t.descripcion Frecuencia,
                  u.descripcion unidad,
                  t.abreviatura,
                  t.dias_horas
                FROM
                  `frecuencias` t
                INNER JOIN
                  unidades u ON u.id_unidades = t.id_unidad
                WHERE
                  t.activo = 1';
        
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
    		$tablaHtml .= $this->print_table($_array_formu, 6, true, 'table table-striped table-bordered',"id='tablaDatos'");
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