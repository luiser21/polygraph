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
class rotuloplanta extends crearHtml{
    
    public $_titulo = 'GENERAR INFORMES ROTULOS POR PLANTA';
    public $_subTitulo = 'Informes';
    public $_datos = '';
    public $Table = 'ot_detalle';
    public $PrimaryKey = 'id_detalle';
    
    
    
   /**
    * generarOt::Contenido()
    * 
    * @return
    */
   function Contenido(){        
    
     $sql = 'SELECT id_planta codigo, descripcion from plantas WHERE activo = 1';
     $arrPlantas = $this->Consulta($sql);    
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Generar Informe</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">ROTULOS POR PLANTA</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form  id="formCrear" role="form" method="post" action="pdf_rotulos.php">
                                    
                                    <div class="form-group">
                                        <label for="nombre">Plantas:</label>
                                        '.
                                        
                                        $this->crearSelect('id_planta','id_planta',$arrPlantas,'0','0','TODOS','class="form-control required"').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        
                                        '.
                                        $this->create_input('checkbox','sin_id_planta','sin_id_planta',false,'1').
                                        '
                                        <label for="nombre"> Consolidado Total por Empresa</label>
                                    </div>
                                
                                                                   
                                                
                                    <button type="submit" id="guardarImagen" class="btn btn-primary">Generar Informe</button>
                                    <div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                        </div>
                    </div>
                </div>                    

        </section>  ';    
        
    }
    
  

     
    /**
     * generarOt::guardarDatos()
     * 
     * @return
     */
    function guardarDatos(){
        $this->runActualizar();        
    }

    /**
     * generarOt::fn_guardar()
     * 
     * @return
     */
    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * generarOt::runEliminar()
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
     * generarOt::fn_editar()
     * 
     * @return
     */
    function fn_editar(){
        
    }
    
    /**
     * generarOt::getDatos()
     * 
     * @return
     */
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    /**
     * generarOt::_mostrar()
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
    
   
}

?>