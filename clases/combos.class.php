<?php
class combos extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA COLORES';
    public $_subTitulo = 'Crear Color';
    public $_datos = '';
    public $Table = 'colores';
    public $PrimaryKey = 'id_colores';
    
    
    
   function Contenido(){
    $item = $_REQUEST['d'];
    $otroItem = $_REQUEST['otroItem'];
    
    $sql = ''; 
    switch($item){
        case'id_secciones':
        $sql = 'SELECT `id_secciones` codigo, descripcion FROM `secciones` WHERE `id_planta` = '.$_REQUEST['valor'].' and activo = 1';
        if($otroItem == 'si'){
            $onchange = 'onchange="traerCombo(\'id_equipos\',this.value)"';    
        }
        break;   
    }
    
    $onchange = '';
    
    if($_REQUEST['otroItem'] != 'none'){
        
        $span = '<div class="form-group">
                  <label for="id_cursos">Seccion:</label>
                  <span id="combo_id_secciones"> -- </span>
                 </div>';
    }
    
    $arr = $this->Consulta($sql);
     
    return $this->crearSelect($item,$item,$arr,false,false,false,'class="form-control" $onchange');    
        
    } 
}
?>