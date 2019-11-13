<?php
class Index extends crearHtml{
    
    public $_titulo = 'CALIFICAR TRABAJOS';
    public $_subTitulo = 'Calificar';
    public $_datos = '';
    public $Table = 'trabajos_cargados';
    public $PrimaryKey = 'id_trabajos_cargados';
    
    /**
    * Index::getClf()
    * Arreglo con las opciones (Todos, Sin Calificar, Calificados)
    * @return array()
    */
     public function getClf(){
        $_array = array();
        array_push($_array, array( 'codigo' => '', 'descripcion' => 'Todos') );
        array_push($_array, array( 'codigo' => '0', 'descripcion' => 'Sin Calificar') );
        array_push($_array, array( 'codigo' => '1', 'descripcion' => 'Calificados') );
        return $_array;
    }
    
    /**
    * Index::getCalificaciones()
    * arreglo con las opciones (Aprobado, No-Aprobado)
    * @return array()
    */
     public function getCalificaciones(){
        $_array = array();
        array_push($_array, array( 'codigo' => '1', 'descripcion' => 'Aprobado') );
        array_push($_array, array( 'codigo' => '0', 'descripcion' => 'No-Aprobado') );
        return $_array;
    }    
    
   /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
            $sql = "SELECT C.id_cursos codigo, C.nombre as descripcion 
                FROM  `cursos` C
                INNER JOIN  `profesores_cursos` PC ON C.id_cursos = PC.`id_cursos` 
            WHERE PC.`id_profesor` = '".$this->idUsuario."' AND C.activo = 1 AND PC.activo = 1
            ";
            $arrCursos = $this->Consulta($sql);
            
            $sql = 'SELECT id_usuario codigo, CONCAT(nombres , " " ,apellidos) as descripcion FROM usuarios WHERE activo = 1 AND tipo_usuario = 2';
            $arrProfesor = $this->Consulta($sql);
             
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Evaluaciones</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">CREAR EVALUACI&Oacute;N</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCalificacion" role="form">                                                                        
                                    <div class="form-group">
                                        <label for="id_cursos">Curso:</label>
                                        '.
                                        $this->crearSelect('id_cursos','id_cursos',$arrCursos,false,false,false,'class="form-control"')
                                        .'    
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">Calificados:</label>
                                        '.
                                        $this->crearSelect('calificacion_c','calificacion_c',$this->getClf(),false,false,false,'class="form-control"')
                                        .'    
                                    </div>                                 
                                </form>
                                <div class="form-group">
                                       <button type="button" id="verTrabajos" class="btn btn-primary">Ver Trabajos</button>                                 
                                </form>
                            </div>
                        </div>
                    </div> <div class="recargaDatos"></div>
                    '.$this->formCalificar().'
                    
                        </div>
                    </div>
            </div>                    

        </section>  ';    
        
    }
    
    /**
     * Index::guardarDatos()
     * 
     * @return
     */
    function guardarDatos(){
        if( isset( $this->_datos[$this->PrimaryKey]) ){
            $sql = 'UPDATE '. $this->Table ." SET calificacion = '".$this->_datos['calificacion']."', id_profesor = '".$this->idUsuario."', fecha_calificacion = NOW() WHERE ".$this->PrimaryKey." = ".$this->_datos[$this->PrimaryKey];
            $this->QuerySql($sql); 
       
            echo '<div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button> 
                    Datos guardados con &eacute;xito </div>';
        }        
    }

    /**
     * Index::fn_guardar()
     * 
     * @return
     */
    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * Index::runEliminar()
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
     * Index::fn_editar()
     * 
     * @return
     */
    function fn_editar(){
        
    }
    
    /**
     * Index::getDatos()
     * 
     * @return
     */
    function getDatos(){
        $res = $this->Consulta("SELECT 
                                C.nombre Curso,
                                CONCAT(U.nombres, ' ',U.apellidos ) Nombre ,
                                TC.`ruta_trabajo` 
                                FROM `trabajos_cargados` TC 
                                INNER JOIN usuarios U ON TC.`id_usuario` = U.id_usuario AND U.activo = 1 
                                INNER JOIN cursos C ON C.id_cursos = TC.`id_curso` AND C.activo = 1 
                                WHERE `id_curso` = '".$this->_datos['id_cursos']."' AND TC.calificacion IS NULL");
        print_r( json_encode( $res[0] ) );
    }
    
    function formCalificar(){
        $html = '<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> Calificar Trabajo con el identificador numero <span id="identificador"></span></h4>
                </div>
                <div class="modal-body">
                    <form id="formCalifica" role="form">
                        <div id="divCalificacion">
                            
                            <div class="form-group">
                                <label for="id_cursos">Curso:</label>
                                '.
                                $this->crearSelect('calificacion','calificacion',$this->getCalificaciones(),false,false,false,'class="form-control"').
                                $this->create_input('hidden','id_trabajos_cargados','id_trabajos_cargados')
                                .'    
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="guardarCalificacion">Guardar Calificaci&oacute;n</button>
                                    
                            </div>
                            <div id="divCalificacionResuldado">
                            
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>';
    return $html;
    }
    
    /**
     * Index::_mostrar()
     * 
     * @return
     */
    function _mostrar(){
      
        $html = $this->Cabecera();
        $html .= $this->contenido();
        $html .= $this->Pata();
        echo $html;
    }
    
    /**
     * Index::tablaDatos()
     * 
     * @return
     */
    function tablaDatos(){
        $w = '';
        switch( $this->_datos['calificacion_c'] ){
            case '':
                $w = '';
            break;
            case '0':
                $w = 'AND TC.calificacion IS NULL';
            break;
            
            case '1':
                $w = 'AND TC.calificacion IS NOT NULL';
            break;            
            
        }
        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = <<<OE
                    SELECT
                        TC.id_trabajos_cargados identificador,
                        C.nombre Curso,
                        CONCAT(U.nombres, ' ',U.apellidos ) Nombre ,
                        IF(`ruta_trabajo`='','Sin Archivo',CONCAT('<a href="',`ruta_trabajo`,'">Descargar</a>') ) AS Descargar,
                        otra_plataforma,
                         CASE TC.calificacion WHEN 'NULL' THEN 'No Aprobado'
                               WHEN 1 THEN 'Aprobado'
                         ELSE 'Sin Calificar' END AS Calificacion,
                        CONCAT(  '<div class="fa fa-edit" style="cursor:pointer" title="Calificar" data-toggle="modal" data-target="#formModal" ONCLICK=javascript:fn_calificar(',id_trabajos_cargados,'); />' ) Calificar
                         
                    FROM `trabajos_cargados` TC 
                    INNER JOIN usuarios U ON TC.`id_usuario` = U.id_usuario AND U.activo = 1 
                    INNER JOIN cursos C ON C.id_cursos = TC.`id_curso` AND C.activo = 1 
                    WHERE `id_curso` = '{$this->_datos['id_cursos']}' {$w}
OE;
        
        $datos = $this->Consulta($sql,1); 
        if(count($datos)){
            $_array_formu = array();
            $_array_formu = $this->generateHead($datos);
            $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();
            
            $tablaHtml  ='<div class="panel-body recargaDatos">';
    		$tablaHtml .= $this->print_table($_array_formu, 6, true, 'table table-striped table-bordered',"id='tablaDatos'");
            $tablaHtml .='</div>';
        }else{
            $tablaHtml = '<div class="col-md-8 recargaDatos">
                            <div class="alert alert-info alert-dismissable">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                                <strong>Atenci&oacute;n</strong>
                                No se encontraron registros.
                            </div>
                          </div>';
        }
        echo $tablaHtml;
        //if($this->_datos=='r')  echo $tablaHtml;
//        else    return $tablaHtml;
        
    }
}
?>