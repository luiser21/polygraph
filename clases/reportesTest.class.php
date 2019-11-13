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
class Index extends crearHtml{
    
    public $_titulo = 'IMPRIMIR CARTAS';
    public $_subTitulo = 'REPORTES';
    public $_datos = '';
    public $Table = 'plantas';
    public $PrimaryKey = 'id_planta';
    
    
    
   /**
    * Index::Contenido()
    * Crea primer formulario de interfaz visual para el usuario.
    * 
    * @return Html con contenido de formulario
    */
   function Contenido(){
    
    /* $sql = 'SELECT id_equipos codigo, descripcion from equipos WHERE activo = 1';
     $arrEquipos = $this->Consulta($sql);
        
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Secciones</li>
                    </ol>
                </div>
            </div>   '.$this->tablaDatos().'
                    
                        </div>
                    </div>
                </div>                    

        </section>  ';   */
       $sql = 'SELECT id_planta codigo, descripcion from plantas WHERE activo = 1 ';
       $arrPlantas = $this->Consulta($sql);
       
       $sql = 'SELECT id_secciones codigo, descripcion from secciones WHERE activo = 1  and id_planta=5';
       $arrSecciones = $this->Consulta($sql);
       
       return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Imprimir Cartas</li>
                    </ol>
                </div>
            </div>
                    
            '.$this->tablaDatos().'
                        
                        </div>
                    </div>
                </div>
                        
        </section>  ';
                                        
        
    }
    function comboSeccion(){
      
        $array = explode("-", $this->_datos);
        //var_dump($array);
        $sql = 'SELECT 0 as codigo, "TODOS" AS descripcion from DUAL
                        UNION 
                SELECT `id_equipos` codigo, descripcion FROM `equipos` WHERE `id_secciones` = '.$array[0].' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_equipos'.$array[0],'id_equipos'.$array[1],$arr,false,false,false,'class="form-control"');
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

        $editar = <<<OE
                CONCAT(  '<div class="fa fa-file-pdf-o" style="cursor:pointer" title="Generar Carta de Lubricacion" ONCLICK=javascript:fn_generarTest(',  `$this->PrimaryKey` ,  ',\'{$this->_file}\',\'jj\'); />' ) Generar_CartaTest
OE;
        $seccion= $this->Imagenes($this->PrimaryKey,3);
        $equipos= $this->Imagenes($this->PrimaryKey,5);
        $sql = 'select E.id_planta as ID,E.descripcion AS PLANTAS,'.$seccion.','.$equipos.','.$editar.' from '.$this->Table.' E where E.activo=1';
       
       // echo $sql;
      
        $datos = $this->Consulta($sql,1); 
        if(count($datos)){
            //var_dump($datos);
            $_array_formu = array();
            $y=0;
            foreach($datos as $value){
                $sql = 'SELECT 0 as codigo, "TODOS" AS descripcion from DUAL
                        UNION 
                        SELECT id_secciones codigo, descripcion from secciones WHERE activo = 1  and id_planta='. $datos[$y]['ID'];
                $arrSecciones = $this->Consulta($sql);
                $datos[$y]['SECCIONES']=$this->crearSelect('id_secciones'.$datos[$y]['ID'],'id_secciones'.$datos[$y]['ID'],$arrSecciones,false,false,false,'class="form-control", onchange="traerCombo_equipo(this.value,'.$datos[$y]['ID'].',\'combo_id_secciones'.$datos[$y]['ID'].'\',\'comboSeccion\')"');
            
                
                $sql = 'SELECT 0 as codigo, "TODOS" AS descripcion from DUAL';
                $arreEquipos = $this->Consulta($sql);
                $datos[$y]['EQUIPOS']='<div  style="cursor:pointer" id="combo_id_secciones'.$datos[$y]['ID'].'">'.
                                    $this->crearSelect('id_equipos'.$datos[$y]['ID'],'id_equipos'.$datos[$y]['ID'],$arreEquipos,false,false,false,'class="form-control"').'</div>';
                
                $y++;
                
            }
            //var_dump($datos); 
            $_array_formu = $this->generateHead($datos);		        
           
			
            $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();
            
            $tablaHtml  = '<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body recargaDatos"  style="page-break-after: always;">
                            <div class="table-responsive">';
            $tablaHtml  .='';
    		$tablaHtml .= $this->print_table($_array_formu, 5, true, 'table table-striped table-bordered',"id='tablaDatos'");
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