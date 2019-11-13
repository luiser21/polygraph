<?php
class Index extends crearHtml{
    
    public $_titulo = 'Mis cursos y Eventos comprados';
    public $_subTitulo = 'Este listado muestra todos los cursos y eventos comprados';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';
    /**
     * Index::$tipo
     * @return Indica si es curso o evento, default curso
     */
    public $tipo = 1;

   /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
        
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
            
            $html .= $this->listarCursos();
            
        $html .=' </section>';
        
        return $html;
            
    }
    
    
    /**
     * Index::guardarDatos()
     * 
     * @return
     */    
    function listarCursos(){
        $and = $this->tipo = ( isset( $_GET['e'] ) )? 'AND CU.tipo = 2' : 'AND CU.tipo = 1';
        $sql = "SELECT CU.nombre,CU.img,CU.id_cursos, CU.tipo, MC.estado,MC.`id` 
                FROM mis_cursos MC 
                INNER JOIN cursos CU ON CU.id_cursos = MC.id_cursos {$and}  
                INNER JOIN compras C ON C.id_compras = MC.idcompra 
                INNER JOIN factura F ON F.id_factura = C.id_factura AND F.id_usuario = '".$this->idUsuario."'";
        $cursos = $this->Consulta($sql);
        
        
        $html = '';
        if(count($cursos) && is_array($cursos)){
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
                                    <img src="'.$c['img'].'" height="150" width="325" ><hr>
                                    <div style="text-align:right;">
                                        <a href="masInfo.php?idc=' . $c['id_cursos'] . '&mic=' . $c['id'] . '"><div class="btn btn-success">'.$txtBoton.'</div></a>
                                    </div>     
                                </div>
                               
                               
                                
                            </div>
                      </div>   ';
            }
        }
        else{
            $html = '<div class="alert alert-warning alert-dismissable">No has comprado un curso a&uacute;n</div>';
        }
        return $html;
    } //<div class="panel-footer" style="float:left">'.$c['nombre'].'</div><div class="btn btn-success">
    /**
     * Index::_mostrar()
     * 
     * @return
     */
    function _mostrar(){
      /**  $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');*/
        $html = $this->Cabecera();
        $html .= $this->contenido();
        //$html .= $this->tablaDatos();
        $html .= $this->Pata();
        echo $html;
    }
}
?>