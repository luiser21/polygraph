
<?php
/** 

 * Index

 * 

 * @package carLub

 * @author Eric Chitan

 * Clase dependientede Cargar Imagenes

 * @copyright 2017

 * @version 0.1

 * @access public

 */
class Index extends crearHtml {

    public $_titulo = 'Modificaci&oacute;n Masiva de Lubricantes';
    public $_subTitulo = 'Reemplazar un lubricante por otro en los equipos seleccionados';
    public $_datos = '';
    public $Table = 'equipos_imagen';
    public $PrimaryKey = 'id_equipo_imagen';
    
    /**

     * Index::Contenido()

     * Crea primer formulario de interfaz visual para el usuario.

     * 

     * @return Html con contenido de formulario

     */
    function Contenido() {


        $sql = 'SELECT id_lubricantes codigo, descripcion from lubricantes WHERE activo = 1';
        $arrLubricantes = $this->Consulta($sql);
        
        $sql = 'SELECT 0 as codigo, "TODOS" AS descripcion from DUAL
                        UNION 
                SELECT id_planta codigo, descripcion from plantas WHERE activo = 1';
        $arrPlantas = $this->Consulta($sql);
        



        $html= '<section class="main-content-wrapper">
            <div class="pageheader"> 
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Configurar => Modificaci&oacute;n Masiva de Lubricantes</li>
                    </ol>
                </div>
            </div>
        
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">MODIFICACION MASIVA DE LUBRICANTES</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">					
					       <form  id="formCrear" role="form" >
						      
						           <div class="form-group">
                                        <label for="id_cursos">Lubricante Actual:</label>
                                        '.$this->crearSelect('id_lubricantes','id_lubricantes',$arrLubricantes,false,false,false,'class="form-control required"').'
                                                                              
                                    </div>
                                     <div class="form-group">
                                        <label for="id_cursos">Lubricante Nuevo:</label>
                                        '.$this->crearSelect('id_lubricantes_nuevo','id_lubricantes_nuevo',$arrLubricantes,false,false,false,'class="form-control required"').'
                                                                              
                                    </div>
						           <div class="form-group">
                                        <label for="id_cursos">Planta:</label>
                                        '.$this->crearSelect('id_planta','id_planta',$arrPlantas,false,false,false,'class="form-control required" onchange="traerCombo(this.value,\'combo_id_secciones\',\'comboSeccion\')"').'
                                                                              
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Seccion:</label>
                                        <span id="combo_id_secciones"> -- </span>
                                        
                                    </div>
                                    
                                     <div class="form-group">
                                        <label for="id_cursos">Equipo:</label>
                                        <span id="combo_id_equipo"> -- </span>
                                        
                                    </div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='<button type="button" id="guardarMasivo" class="btn btn-primary">Asociar Masivamente</button>';
						            }
                                    $html.='<div class="panel" id="Resultado" style="display:none">RESULTADO</div>
                                </form>
                            </div>
                        </div>
                    </div>                     
                        </div>
                    </div>
                </div>                    

        </section>  ';
        return $html;
    }
    
    function comboSeccion(){
        $sql = 'SELECT 0 as codigo, "TODOS" AS descripcion from DUAL
                        UNION 
                SELECT `id_secciones` codigo, descripcion FROM `secciones` WHERE `id_planta` = '.$this->_datos.' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_secciones','id_secciones',$arr,false,false,false,'class="form-control required" onchange="traerCombo(this.value,\'combo_id_equipo\',\'comboEquipos\')"');
    }
    function comboEquipos(){
        $sql = 'SELECT 0 as codigo, "TODOS" AS descripcion from DUAL
                        UNION 
                SELECT `id_equipos` codigo, descripcion FROM `equipos` WHERE `id_secciones` = '.$this->_datos.' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_equipos','id_equipos',$arr,false,false,false,'class="form-control required"');
    }
    
    function guardarDatos(){
       
        $_respuesta = array('Codigo' => 0, "Mensaje" => $this->MensajeActualizacion);
        try {     
           
            $sql ="SELECT MEC.id_mec_met FROM mec_met MEC
            INNER JOIN mecanismos ME ON ME.id_mecanismos = MEC.id_mecanismos
            INNER JOIN componentes CO ON CO.id_componentes=ME.id_componente
            INNER JOIN equipos e ON e.id_equipos=CO.id_equipos
            INNER JOIN secciones SE ON SE.id_secciones=e.id_secciones
            WHERE e.activo=1 AND SE.activo=1 AND MEC.cod_lubricante=".$this->_datos['id_lubricantes'];
            
            if($this->_datos['id_planta']<>0){
                $sql.=" AND SE.id_planta=".$this->_datos['id_planta'];
            }
            if($this->_datos['id_secciones']<>0){
                $sql.=" AND SE.id_secciones=".$this->_datos['id_secciones'];
            }
            if($this->_datos['id_equipos']<>0){
                $sql.=" AND e.id_equipos=".$this->_datos['id_equipos'];
            }             
            $mecmet = $this->Consulta($sql);
            foreach($mecmet as $value) {
                $sql="UPDATE mec_met set cod_lubricante=".$this->_datos['id_lubricantes_nuevo']."
                      WHERE cod_lubricante=".$this->_datos['id_lubricantes']." AND 
                            id_mec_met=".$value['id_mec_met'];
               $this->QuerySql($sql);
            }      
        }
        catch (exception $e) {
            $_respuesta = array('Codigo' => 99, "Mensaje" => $e->getMessage());
        }
        print_r(json_encode($_respuesta));
    }
    
    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        $sql = 'DELETE FROM '.$this->Table .'  WHERE '.$this->PrimaryKey.' = '.$this->_datos;
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

    /**

     * Index::tablaDatos()

     * Muestra listado de datos en las interfaces de usuario 

     * @return Tabla con contenido HTML (Lista de datos)

     */
    function tablaDatos(){
        
 
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = 'SELECT
                	p.descripcion AS planta,
                	s.descripcion as Seccion,
                    e.descripcion AS Equipo,
					im.file AS imagen,
                    '.$eliminar.'                  
                FROM
                	equipos_imagen im
				INNER JOIN equipos e on e.id_equipos=im.id_equipos
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