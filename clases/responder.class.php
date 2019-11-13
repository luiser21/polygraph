<?php
class Responder extends crearHtml{
    
    public $_titulo = 'RESPONDER FOROS';
    public $_subTitulo = 'Responder';
    public $_datos = '';
    public $Table = 'trabajos_cargados';
    public $PrimaryKey = 'id_trabajos_cargados';
    
       
    
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
             
             
        $html =  '<section class="main-content-wrapper">
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
                                <h3 class="panel-title">RESPONDER FOROS</h3>
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
                                </form>
                                <div class="form-group">
                                       <button type="button" id="verTrabajos" class="btn btn-primary">Ver preguntas</button>                                 
                                </form>
                            </div>
                        </div>
                    </div> <div class="recargaDatos"></div>
                    '.$this->formCalificar().'
                    
                        </div>
                    </div>
            </div>                    

        </section>  ';
        
        return $html;    
        
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
     * Guarda la respuesta que le da el profesor a cada pregunta que realiza un estudiante.
     * @return
     */
    function fn_guardar(){
        
        $id_autor		= $_SESSION['id_usuario'];
        $id_padre       = $this->_datos['id_padre']; // id Foro Actual
        $id_dna_foro    = $this->_datos['id_pregunta'];
        $fecha 			= date('Y-m-d H:i:s');   
                
             echo   $sql = "INSERT INTO `dna_foro_detalle`(`id_dna_foro`, `id_autor`, id_padre,nivel,`mensaje`,`fecha`) 
                VALUES 
                ('".$id_dna_foro."','".$id_autor."','".$id_padre."','2','".$mensaje."','".$fecha."')";
        
        //$this->QuerySql($sql);
        //$this->enviaNotificacion();
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
        $res = $this->Consulta("SELECT F.id_autor AS USUARIO , F.mensaje FROM `dna_foro_detalle` F
                                JOIN `capitulos` CA ON CA.id_capitulo = F.`id_dna_foro`
                                JOIN `cursos` C ON C.id_cursos = CA.id_cursos
                                JOIN  `profesores_cursos` PC ON PC.id_cursos = C.`id_cursos`
                                WHERE C.`id_curso` = '".$this->_datos['id_cursos']."' PC.`id_profesor` = '". $this->idUsuario."' ");
        print_r( json_encode( $res[0] ) );
    }
    
    function formCalificar(){
        $html = '<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> Responder: <span id="identificador"></span></h4>
                </div>
                <div class="modal-body">
                    <form id="formResponde" role="form">
                        <div id="divCalificacion">
                            
                            <div class="form-group">
                                <label for="id_cursos">Curso:</label>
                                '.
                                $this->create_input('textarea','respuesta','respuesta','Escriba aqui su respuesta').
                                $this->create_input('hidden','id_pregunta','id_pregunta').
                                $this->create_input('hidden','id_foro','id_foro')
                                .'    
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="responderPregunta">Responder Pregunta</button>
                                    
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
    
    public function verRespuesta(){
        $sql = "SELECT F.mensaje,F.`id_dna_foro`,F.`id`  FROM `dna_foro_detalle` F WHERE F.`id` = '".$this->_datos."'";
        $res = $this->Consulta($sql);
        $res = array("mensaje"=>$res['0']['mensaje'],
            "id_foro"=>$res['0']['id_dna_foro'],
            "id_padre"=>$res['0']['id']
            );
        echo json_encode( $res );  
    }    
    
    /**
     * Index::tablaDatos()
     * 
     * @return
     */
    function tablaDatos(){
        $sql = <<<OE
                    SELECT F.id_autor AS USUARIO ,
                    IF(LENGTH(F.mensaje)>70,concat(SUBSTRING(F.mensaje,1,70),' ... '),F.mensaje)  as mensaje,
                     CONCAT(  '<div class="fa fa-edit" style="cursor:pointer" title="Responder" data-toggle="modal" data-target="#formModal" ONCLICK=javascript:fn_calificar(',F.id,'); />' ) Responder
                      
                     FROM `dna_foro_detalle` F
                                JOIN `capitulos` CA ON CA.id_capitulo = F.`id_dna_foro`
                                JOIN `cursos` C ON C.id_cursos = CA.id_cursos
                                JOIN  `profesores_cursos` PC ON PC.id_cursos = C.`id_cursos`
                                WHERE C.`id_cursos` = '{$this->_datos['id_cursos']}' AND PC.`id_profesor` = '{$this->idUsuario}'
OE;
        $res = $this->Consulta($sql);
        
        $datos = $this->Consulta($sql,1); 
        if(count($datos)){
            $_array_formu = array();
            $_array_formu = $this->generateHead($datos);
            $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();
            
            $tablaHtml  ='<div class="panel-body recargaDatos">';
    		$tablaHtml .= $this->print_table($_array_formu, 3, true, 'table table-striped table-bordered',"id='tablaDatos'");
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