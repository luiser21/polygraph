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
class Index extends crearHtml {

    public $_titulo = 'Asignacion Automatica de Rotulos';
    public $_subTitulo = 'Asignacion Automatica de Rotulos';
    public $_datos = '';
    public $Table = 'mec_met';
    public $PrimaryKey = 'id_mec_met';
    
    /**

     * Index::Contenido()

     * Crea primer formulario de interfaz visual para el usuario.

     * 

     * @return Html con contenido de formulario

     */
    function Contenido() {



        $sql = "SELECT distinct f.id_frecuencias codigo, f.descripcion from mec_met m
                inner join frecuencias f on (m.id_frecuencias=f.id_frecuencias) 
                WHERE f.activo = 1";
        $arrPlantas = $this->Consulta($sql);
        

        $sqlapli = "SELECT distinct a.id_aplicacion codigo, a.aplicacion descripcion FROM mec_met m
                inner join aplicaciones_lub a on (m.id_aplicacion=a.id_aplicacion)
                WHERE a.activo = 1";
        $arrapli = $this->Consulta($sqlapli);
        
        $sqllubri = "SELECT distinct l.id_lubricantes codigo, l.descripcion FROM mec_met m
                inner join lubricantes l on (m.cod_lubricante=l.id_lubricantes)
                WHERE l.activo = 1";
        $arrlubri = $this->Consulta($sqllubri);

        $html= '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Configurar => Asignacion Automatica de Rotuloss</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">ROTULOS</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">					
					       <form  id="formCrear" role="form" method="post" action="rotulos_figura.php" >
						      <h4 class="text-center">Generar Multiples Rotulos</h4>
						
						           <div class="form-group">
                                        <label for="id_cursos">Frecuencias:</label>
                                        '.$this->crearSelect('id_frecuencias','id_frecuencias',$arrPlantas,false,'0','TODOS','class="form-control required"').'
                                        '.$this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Aplicaciones:</label>
                                        <span id="combo_id_secciones">
                                        '.$this->crearSelect('id_aplicacion','id_aplicacion',$arrapli,false,'0','TODOS','class="form-control required" ').'    
                                         </span>
                                        
                                    </div>
                                    
                                     <div class="form-group">
                                        <label for="id_cursos">Lubricantes:</label>
                                        <span id="combo_id_equipo">
                                        '.$this->crearSelect('id_lubricantes','id_lubricantes',$arrlubri,false,'0','TODOS','class="form-control required"').'
                                        </span>
                                        
                                    </div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='
                                   			
						           	<button type="submit" id="guardarImagen" class="btn btn-primary">Generar Rotulos</button>
						             ';
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
    
    
    function guardarDatos(){  
        
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

    /**

     * Index::tablaDatos()

     * Muestra listado de datos en las interfaces de usuario 

     * @return Tabla con contenido HTML (Lista de datos)

     */
    function tablaDatos(){
        
 
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $imagen = $this->Imagenes($this->PrimaryKey,9);
        
        
         $sql = "SELECT DISTINCT  $imagen, 
                    ##f.descripcion Frecuencia,
                    CASE l.clase
                    	WHEN 'Mineral' THEN CONCAT(f.descripcion,' ','Amarillo') 
                    	WHEN 'Sintetico' THEN CONCAT(f.descripcion,' ','Azul')
                    	WHEN 'Vegetal' THEN  CONCAT(f.descripcion,' ','Verde')
                    ELSE 'NA'
                    END as Frecuencia_Color_Borde,
                    c.descripcion Color_Fig_Ext,
                    CASE l.categoria
                            WHEN 'H1' THEN CONCAT('Cuadrado ',c1.descripcion)
                            WHEN 'H2' THEN CONCAT('Circulo ',c1.descripcion)
                            WHEN 'H3' THEN 'Triangulo'
                            ELSE 'NA'
                    END as Fig_Interna,
                    ##c1.descripcion Color_Fig_Interna, 
                    cl.abreviatura Texto_Fig,
                    CONCAT(f.descripcion, '_', CASE l.clase
                                  	WHEN 'Mineral' THEN 'Amarillo'
                            		WHEN 'Sintetico' THEN 'Azul'
                                    WHEN 'Vegetal' THEN 'Verde'
                                  	ELSE 'NA'
                    END, '_', c.descripcion, '_', CASE l.categoria
                                  	WHEN 'H1' THEN 'Cuadrado'
                            		WHEN 'H2' THEN 'Circulo'
                                    WHEN 'H3' THEN 'Triangulo'
                                  	ELSE 'NA'
                    END, '_', c1.descripcion, '_', cl.abreviatura, '.png') Archivo
                    ##m.id_frecuencias,
                    ##m.id_aplicacion,
                    ##m.cod_lubricante,
                    ##c.hexadecimal hexa_color_ext,
                    ##c1.hexadecimal hexa_color_int
                    FROM mec_met m
                    inner join lubricantes l on (m.cod_lubricante=l.id_lubricantes)
                    inner join aplicaciones_lub a on (m.id_aplicacion=a.id_aplicacion)
                    inner join clasificaciones cl on (l.cod_clasificacion=cl.id_clasificaciones)
                    inner join frecuencias f on (m.id_frecuencias=f.id_frecuencias)
                    inner join colores c on (a.id_colores=c.id_colores)
                    inner join colores c1 on (cl.id_colores=c1.id_colores)
                    inner join simbologia s on s.id_simbologia=m.id_simbologia
                    where m.id_frecuencias > 0
                    and m.cod_lubricante > 0
                    and m.id_aplicacion > 0 ##AND f.descripcion='Semestral'
                    order by m.id_frecuencias, m.id_aplicacion, m.cod_lubricante";
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