<?php
class empresas extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA EMPRESAS';
    public $_subTitulo = 'Ingrese o edite las empresas';
    public $_datos = '';
    public $Table = 'empresas';
    public $PrimaryKey = 'id_empresa';
    
    
    
    function Contenido(){
        $sql = 'SELECT ubicacion from empresas WHERE id_empresa='.$this->PrimaryKey.' and activo = 1';
        $arrPlantas = $this->Consulta($sql);
        
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administraci&oacute;n => Empresas</li>
                    </ol>
                </div>
            </div>
                    
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">EMPRESAS</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form"  method="post" action="guarda_empresa.php" enctype="multipart/form-data">
                    
                                    
                                    <div class="form-group">
                                        <label for="nombre">Nombre Empresa:</label>
                                        '.
                                        
                                        $this->create_input('text','NOMBRE','NOMBRE','Nombre de la Empresa',false,'form-control required',false).
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                            
                                    </div>
                                      <div class="form-group">
                                        <label for="id_cursos">TIPO ACTIVIDAD:</label>
                                        '.$this->create_input('text','TIPOACTIVIDAD','TIPOACTIVIDAD','Tipo Actividad',false,'form-control').'
                                        
                                    </div>   
                                     <div class="form-group">
                                        <label for="id_cursos">UBICACION:</label>
                                        '.$this->create_input('text','ubicacion','ubicacion','Ubicacion',false,'form-control').'
                                        
                                    </div>
                                     <div class="form-group">
    							         <label for="id_cursos">Logo Empresa:</label>						   
    							     	<input type="file" class="form-control" accept="image/jpg" id="LOGO" name="LOGO" onchange="control(this)">
    							    </div>
                                     <div class="form-group">
    							         <label for="id_cursos">Logo Cliente:</label>						   
    							     	<input type="file" class="form-control" accept="image/jpg" id="LOGO2" name="LOGO2" onchange="control(this)">
    							    </div>			       
                                             
                                    <button type="submit" id="guardarCurso" class="btn btn-primary">Guardar Empresa</button>
                                    <div id="Resultado" style="display:none">RESULTADO</div>
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
        var_dump($_POST);
        var_dump($_FILES);
        EXIT;
        $this->runActualizar();
    }
    
    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        
        
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
        $imagen = $this->Imagenes($this->PrimaryKey,12);
        $imagen2 = $this->Imagenes($this->PrimaryKey,13);
        
        $sql = 'SELECT
                    e.NOMBRE AS Empresa,e.TIPOACTIVIDAD,e.ubicacion,
                     '.$imagen.','.$imagen2.','.$editar.'
                FROM
                	empresas e
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