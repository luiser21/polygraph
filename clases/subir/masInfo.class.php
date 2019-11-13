<?php
class Index extends crearHtml{
    
    public $_titulo = 'Curso';
    public $_subTitulo = 'Informaci&oacute;n sobre el curso';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';
    public $idCurso;
    public $infoCurso = array(); 
    
    
   /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
        $this->idCurso = $_GET['idc'];
        $this->getInfoCurso();
        
        $html =  '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Cursos y Eventos</li>
                    </ol>
                </div>
            </div>';
            
            $html .= $this->informacion();
            $html .= $this->listaClases();
            if( !isset( $_SESSION["id_usuario"] ) )
                $html .= $this->seccionPago();
            else{
                $html .= $this->informacionEstado();
            }
        $html .=' </section>';
        
        return $html;
            
    }
    
    
    function getInfoCurso(){
        $sql = 'SELECT `id_cursos`, `nombre`, `descripcion`,`img`, `img_banner`, `precio` FROM cursos WHERE activo = 1 AND id_cursos = '.$this->idCurso;
        $this->infoCurso = $this->Consulta($sql);
    }
    
    /**
     * Index::panel1()
     * muestra la descripcion del curso
     * @return
     */    
    function informacion(){
        if(!$this->idCurso){
            die('No se encontro ningun curso selecciona, es imposible continuar');
        }
        
        
        $html = '';
        $html .= '<div class="col-md-12" style="margin:0px 0px 20px 0px;">';
        $html .= '<img src="'.$this->infoCurso[0]['img_banner'].'" height="260" width="1160" >';    
        $html .= '</div>';
        $html .= '<div class="col-md-4">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">DESCRIPCION</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                            ' . $this->infoCurso[0]['descripcion'] . '
                            </div>
                            
                        </div>
                    </div>
                    </div>';
        return $html;
    }
    
    function listaClases(){
        
        $sql = 'SELECT nombre,id_cursos,id_capitulo FROM capitulos WHERE id_cursos = '.$this->idCurso;
        $clases = $this->Consulta($sql);
        $html = '';
        $html .= '<div class="col-md-4">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Clases</h3>
                                        <div class="actions pull-right">
                                            <i class="fa fa-expand"></i>
                                            <i class="fa fa-chevron-down"></i>
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </div>
                                    <div class="panel-body">';
                                    
                                    foreach($clases as $c){
                                        $html .= '<h2><a href="forum.php?id='.$c['id_capitulo'].'">'. $c['nombre'] . '</a></h2><hr>';
                                    }
                                    
        $html.='                   </div>
                                    
                                </div>
                            </div>
                            </div>   ';
        return $html;     
    }
    /**
     * Index::seccionPago()
     * Muestra la el precio del producto y da la opcion de compra
     * @return
     */    
    function seccionPago(){
        
        $html = '';
        $html .= '<div class="col-md-4">
                            <div class="panel">
                                <div class="panel-heading" style="background:#590C7A">
                                    <h3 class="panel-title" style="color:#FFF">PRECIO CURSO</h3>
                                    <div class="actions pull-right">
                                        <i class="fa fa-expand"></i>
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>
                                
                                <div class="panel-body" style="background:#590C7A"> 
                                <h1 style="float:left; color:#FFF">$' . number_format( $this->infoCurso[0]['precio'] ). '</h1>
                                <span class="btn btn-info">COMPRAR</span>
                                </div>
                                <div>
                                <a href="http://www.payulatam.com/logos/pol.php?l=133&c=556a5f74442f1" target="_blank"><img src="http://www.payulatam.com/logos/logo.php?l=133&c=556a5f74442f1" alt="PayU Latam" border="0" /></a>
                                </div>
                                <div style="margin-top:10px; padding:10px 10px 10px 10px;">
                                <h1> Qu&eacute; Recibirsa&eacute? </h1>
                                <hr>
                                AQUI LISTA LOS ITEMS QUE RECIBIRA LA PERSONA..
                                ESTOS ITEMS SON FIJOS
                                </div>
                                
                            </div>
                        </div>
                        </div>   ';                                   
        return $html;
    }
    /**
     * Index::informacionEstado()
     * Muesra el avance del curso, da la opcion de comenzar la evaluacion  y muestra el profesor encargado del area
     * @return
     */
    function informacionEstado(){
        $html = '';
        $html .= '  <div class="col-md-4">
                        <div class="panel">
                            <div class="panel-heading">
                            <h3 class="panel-title">ESTADO DEL CURSO</h3>
                            <div class="actions pull-right">
                            <i class="fa fa-expand"></i>
                            <i class="fa fa-chevron-down"></i>
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                        
                     <div class="panel-body"> 
                        <div class="progress">
                            <div style="width: 40%" class="progress-bar progress-bar-success">40%</div>
                        </div>
                        <form id="formEvaluacion" action="miEvaluacion.php" method="post">
                        '.$this->create_input('hidden','idCurso','idCurso',false,$this->idCurso).'
                        '.$this->create_input('hidden','mic','mic',false,$_REQUEST['mic']).'
                        Este curso caduca: Agosto 19 2015<span class="btn btn-info" id="irEvaluacion">Realizar evaluaci&oacuten</span>
                        </form>
                        
                     </div>
                     <div>
                        
                        
                     </div>
                     
                     <div style="margin-top:10px; padding:10px 10px 10px 10px;">
                        <h1> &iexcl;IMPORTANTE! </h1>
                        <hr>
                        AQUI LISTA LOS ITEMS QUE RECIBIRA LA PERSONA..
                        ESTOS ITEMS SON FIJOS
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
}
?>