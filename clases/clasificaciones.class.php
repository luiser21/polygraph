<?php
/**
 * clasificaciones
 * 
 * @package carLub
 * @author JAVIER ARDILA
 * @copyright 2017
 * @version $Id$
 * @access public
 */
class clasificaciones extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA CLASIFICACIONES';
    public $_subTitulo = 'Crear Clasificacion';
    public $_datos = '';
    public $Table = 'clasificaciones';
    public $PrimaryKey = 'id_clasificaciones';
    
    
    
   /**
    * clasificaciones::Contenido()
    * 
    * @return
    */
   function Contenido(){
    $sql = 'SELECT id_colores codigo, descripcion, hexadecimal from colores WHERE activo = 1';
    $arrOpciones = $this->Consulta($sql);
    
        $html = '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Clasificaciones</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">CLASIFICACIONES</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                    
                                    <div class="form-group">
                                        <label for="nombre">Clasificación:</label>
                                        '.
                                        
                                        $this->create_input('text','descripcion','descripcion','Nombre de la clasificacion',false,'form-control required').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                    
                                      <div class="form-group">
                                        <label for="id_cursos">Abreviatura:</label>
                                        '.$this->create_input('text','abreviatura','abreviatura','abreviatura',false,'form-control required').'
                                        
                                    </div> 
                                    
                                      <div class="form-group">
                                        <label for="id_cursos">Color:</label>
                                        
                                        ';
                                                $html .=  '<select name="id_colores" id="id_colores" class="form-control required">';
        $html .= '<option value="">Seleccione un color</option>';
                if(is_array($arrOpciones) && count($arrOpciones)){
                    foreach($arrOpciones as $opt){
                        $html .= '<option value="'.$opt['codigo'].'" style="background:'.$opt['hexadecimal'].'">'.$opt['descripcion'].'</option>'; 
                    }
                }
                
         $html .= '</select>';  
        $html .=  '</div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='
                    <button type="button" id="guardarCurso" class="btn btn-primary">Guardar clasificación</button>';
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
    
  
    /**
     * clasificaciones::guardarDatos()
     * 
     * @return
     */
    function guardarDatos(){
        $this->runActualizar();        
    }

    /**
     * clasificaciones::fn_guardar()
     * 
     * @return
     */
    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * clasificaciones::runEliminar()
     * 
     * @return
     */
    function runEliminar(){
        $sql = 'UPDATE '.$this->Table .' SET activo = 0 WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $this->QuerySql($sql);
        //$_respuesta = array('Codigo' => 1, "Mensaje" => 'Se ha eliminado el item con &eacute;xito');
        echo 'Se ha eliminado el item con &eacute;xito';
    }
    
    /**
     * clasificaciones::fn_editar()
     * 
     * @return
     */
    function fn_editar(){
        
    }
    
    /**
     * clasificaciones::getDatos()
     * 
     * @return
     */
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    /**
     * clasificaciones::_mostrar()
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
     * clasificaciones::tablaDatos()
     * 
     * @return
     */
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = 'SELECT
  t.descripcion Clasificacion,
  `abreviatura`,
  c.descripcion Color
  ,'.$editar.','.$eliminar.'
FROM
  `clasificaciones` t
INNER JOIN
  colores c ON c.id_colores = t.id_colores
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