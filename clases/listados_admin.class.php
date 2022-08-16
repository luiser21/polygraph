<?php
class Index extends crearHtml{
    
    public $_titulo = 'Modulos de trabajo';
    public $_subTitulo = 'Modulos del sistema administrativo';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';
    public $listar = 0;
    public $gratis = false;
    
   /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
        
        $html =  '
		
		<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Modulos de trabajo</li>
                    </ol>
                </div>
            </div>
			 <div class="col-md-8" >
						
                       <div class="embed-container" align="center" >
                           <iframe width="1000" height="450" src="http://saipolygraph.com/" frameborder="0" allowfullscreen  scrolling="no"></iframe>
                        </div>
                    </div> 
                    
                        </div>
                    </div>
                </div>   
			
			';
            //$html .= $this->listarCursos();
            
        $html .=' </section>';
        
        return $html;
            
    }
    
    
    /**
     * Index::listarCursos()
     * 
     * @return
     */    
    function listarCursos(){
        $w = '';
        if($this->listar){
                $w .= ' AND tipo = '.$this->listar;
        }
        if($this->gratis){
            $w .= ' AND precio = 0';
        }
        $sql = 'SELECT `id_cursos`, `tipo`, `nombre`, `descripcion`,`img` FROM cursos WHERE activo = 1 '.$w;
        $cursos = $this->Consulta($sql);
        
        $html = '';
        $a = '#';
        foreach($cursos as $c){
            $txtBoton = ($c['tipo']==='1') ? 'VER CURSO' : 'VER EVENTO';
            $txtTitulo = ($c['tipo']==='1') ? 'CURSO' : 'EVENTO';
        $html .= '<div class="col-md-4">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">'.$txtTitulo.'</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <img class="img-responsive" src="'.$c['img'].'" height="150" width="355" >
                                <hr>
                                <div style="text-align: right;">';
                               $a =  'masInfo.php?idc=' . $c['id_cursos'];
                            $html .= '<a href="'.$a.'"><div class="btn btn-success">'.$txtBoton.'</div></a>';
                       $html .=   '</div>
                            </div>
                            
                        </div>
                    </div>
                    </div>   ';
        }
        return $html;
    }

    
    /**
     * Index::getDatos()
     * 
     * @return
     */
    function getDatos(){
        $res = $this->Consulta('SELECT `id_cursos`, `nombre`, `descripcion`,fecha_ini,fecha_fin FROM '.$this->Table ." WHERE id_cursos = ".$this->_datos);
        print_r( json_encode( $res[0] ) );
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