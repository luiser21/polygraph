<style>
<!--
.thumbnail {position: relative; z-index: 0; }

.thumbnail:hover{ background-color: transparent; z-index: 2;

position:absolute;

top:18x ;

left:80px;

}

.thumbnail span{ /* Estilos para la imagen agrandada */

position: absolute;

visibility: hidden;

text-decoration: none;

}

.thumbnail span img{ border-width: 0; width:500px;height:500px; float:left; }

.thumbnail:hover span{ visibility: visible; top: 0; left: 0px; position: relative;
float: left; }

.imgderecha {width: 40%;

		margin: 6px;

		margin-right: 0;

        float: right;

}

.imgderecha:hover {

    width: 65%;

}
-->
</style>

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

    public $_titulo = 'Cargar  Imagenes Equipos';
    public $_subTitulo = 'Estas imagenes se muestran en las cartas de lubricación';
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



        $sql = 'SELECT id_planta codigo, descripcion from plantas WHERE activo = 1';
        $arrPlantas = $this->Consulta($sql);
        



        $html= '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Configurar => Equipos Imagenes</li>
                    </ol>
                </div>
            </div>
    		
    		<style>
    			body {
    			padding-top: 20px;
    			padding-bottom: 20px;
    			}
    		</style>
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">EQUIPOS IMAGENES</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">					
					       <form  id="formCrear" role="form" method="post" action="guarda.php" enctype="multipart/form-data" >
						      <h4 class="text-center">Cargar Multiples Archivos</h4>
						
						           <div class="form-group">
                                        <label for="id_cursos">Planta:</label>
                                        '.$this->crearSelect('id_planta','id_planta',$arrPlantas,false,false,false,'class="form-control required" onchange="traerCombo(this.value,\'combo_id_secciones\',\'comboSeccion\')"').'
                                        '.$this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Seccion:</label>
                                        <span id="combo_id_secciones">
                                        '.$this->crearSelect('id_secciones','id_secciones',array(),false,false,false,'class="form-control required" ').'    
                                         </span>
                                        
                                    </div>
                                    
                                     <div class="form-group">
                                        <label for="id_cursos">Equipo:</label>
            Solo se permite imagenes < 1Mb y la suma total de imagenes no puede sobrepasar 2M
                                        <span id="combo_id_equipo">
                                        '.$this->crearSelect('id_equipos','id_equipos',array(),false,false,false,'class="form-control required"').'
                                        </span>
                                        
                                    </div>

                                    <div class="form-group">
    							      <label class="col-sm-2 control-label">Archivos</label>    							   
    							     	<input type="file" class="form-control required" accept="image/jpg" id="archivo[]" name="archivo[]" multiple=""  onchange="control(this)">
    							    </div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='<button type="submit" id="guardarImagen" class="btn btn-primary">Guardar Imagenes</button>';
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
        echo $this->crearSelect('id_secciones','id_secciones',$arr,false,false,false,'class="form-control required" onchange="traerCombo(this.value,\'combo_id_equipo\',\'comboEquipos\')"');
    }
    function comboEquipos(){
        $sql = 'SELECT `id_equipos` codigo, descripcion FROM `equipos` WHERE `id_secciones` = '.$this->_datos.' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_equipos','id_equipos',$arr,false,false,false,'class="form-control required"');
    }
    
    function guardarDatos(){
        
        
        $this->runActualizar();
    }
    
    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        
        $sql='SELECT description, file FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $res=$this->Consulta($sql);
        
        $imagen_borar=$res[0]['description'].$res[0]['file'];       
        unlink($imagen_borar);
        
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
        $imagen = $this->Imagenes($this->PrimaryKey,6);
        $sql = "SELECT
                    $imagen,
                	p.descripcion AS planta,
                	s.descripcion as Seccion,
                    e.descripcion AS Equipo,                   
                    $eliminar                   
                FROM
                	equipos_imagen im
				INNER JOIN equipos e on e.id_equipos=im.id_equipos
                INNER JOIN secciones s on s.id_secciones = e.id_secciones
                INNER JOIN plantas p ON p.id_planta = s.id_planta				
                WHERE e.activo = 1";
        
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