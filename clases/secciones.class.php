<?php
/**
 * secciones
 * 
 * @package   
 * @author carLub
 * @copyright JAVIER ARDILA
 * @version 2017
 * @access public
 */
class secciones extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA SECCIONES';
    public $_subTitulo = 'Crear secciones';
    public $_datos = '';
    public $Table = 'secciones';
    public $PrimaryKey = 'id_secciones';
    
    
    
   /**
    * secciones::Contenido()
    * 
    * @return
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
                        <li class="active">Administrar Secciones</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">SECCIONES</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                    <div class="form-group">
                                        <label for="nombre">Nombre secci&oacute;n:</label>
                                        '.
                                        
                                        $this->create_input('text','descripcion','descripcion','Nombre de la secci&oacute;n',false,'form-control required').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Planta:</label>
                                        '.$this->crearSelect('id_planta','id_planta',$arrPlantas,false,false,false,'class="form-control required"').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Codigo Empresa:</label>
                                        '.$this->create_input('text','codigo_empresa','codigo_empresa','Codigo de la empresa',false,'form-control required').'
                                        
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Consecutivo:</label>
                                        '.$this->create_input('text','consecutivo','consecutivo','escriba consecutivo',false,'form-control').'
                                        
                                    </div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='<button type="button" id="guardarCurso" class="btn btn-primary">Guardar Secci&oacute;n</button>';
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
    
    
    /**
     * clasificaciones::validarConsecutivo()
     * Valida que un consecutivo no se encuentre en la misma planta. de lo contrario arroja false
     * @return
     */
    function validarConsecutivo(){
        
        
        return true;
        $sql = "SELECT id_secciones  FROM `secciones` WHERE `consecutivo` = '".$this->_datos['consecutivo']."' AND `id_planta` = '".$this->_datos['id_planta']."'";
        $resultado = $this->Consulta($sql);
        
        if(is_array($resultado) and count($resultado)){
            $_respuesta = array('Codigo' => 99, "Mensaje" => 'No se puede repetir el mismo consecutivo en una sección');
            print_r(json_encode($_respuesta));
            //return false;
        }
        echo 'DEBUG => '.__line__;
        $_respuesta = array('Codigo' => 99, "Mensaje" => 'No se puede repetir el mismo consecutivo en una sección');
            echo 'DEBUG => '.__line__;
            print_r(json_encode($_respuesta));
            print_r($_respuesta);
            echo 'DEBUG => '.__line__;
        return false;
        
    }    
    
    /**
     * secciones::guardarDatos()
     * 
     * @return
     */
    function guardarDatos(){
        if($this->validarConsecutivo()){
            $this->runActualizar();
        }         
    }

    /**
     * secciones::fn_guardar()
     * 
     * @return
     */
    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * secciones::runEliminar()
     * 
     * @return
     */
    function runEliminar(){
    
        $sql = 'DELETE S, E, C, M, MM FROM secciones S 
                LEFT JOIN equipos E ON E.id_secciones = S.id_secciones
                LEFT JOIN componentes C ON C.id_equipos = E.id_equipos
                LEFT JOIN mecanismos M ON M.id_componente = C.id_componentes
                LEFT JOIN mec_met MM ON MM.id_mecanismos = M.id_mecanismos
                WHERE S.id_secciones = ' . $this->_datos;
        $this->QuerySql($sql);
        echo 'Se ha eliminado el item con &eacute;xito';
    }
    
    /**
     * secciones::fn_editar()
     * 
     * @return
     */
    function fn_editar(){
        
    }
    
    /**
     * secciones::getDatos()
     * 
     * @return
     */
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        $resultado = $res[0];
        
        print_r( json_encode( $resultado ) );
    }
    
    /**
     * secciones::_mostrar()
     * 
     * @return
     */
    function _mostrar(){
      /**  $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');*/
        $html = $this->Cabecera();
        $html .= $this->contenido();
      //  $html .= $this->tablaDatos();
        $html .= $this->Pata();
        echo $html;
    }
    
    /**
     * secciones::tablaDatos()
     * 
     * @return
     */
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = 'SELECT
            	p.descripcion AS planta,
                t.descripcion AS Nombre_Seccion
                ,'.$editar.','.$eliminar.' 
                FROM
        	   secciones t
                INNER JOIN plantas p ON p.id_planta = t.id_planta
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