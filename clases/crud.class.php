<?php
class crud extends crearHtml{
    
    public $_titulo;
    public $_subTitulo;
    public $_datos;
    public $Table;
    public $PrimaryKey;
    
    
    function Iniciar(){
         $this->_file  = $_SERVER['PHP_SELF'];
         if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || isset($_REQUEST['uploadFileIframe'])){
            $this->_datos =  ( is_array($_REQUEST['d']) || is_object($_REQUEST['d']) )? $this->serializeArray($_REQUEST['d']) : $_REQUEST['d'];
             if( method_exists($this,$_REQUEST['process']) ){
                 call_user_func(array($this,$_REQUEST['process'])); 
                 }
            exit;
        }
        else{
            $this->_mostrar();
        }
    }
    
    function formulario(){
        $html = $this->itemFila('Descripcion',$this->create_input('text','DESCRIPCION','DESCRIPCION','Escriba el nombre aquí'),'divOrden');
        $html .= $this->itemFila('',$this->create_input('button','Guardar','Guardar',false,'Guardar'),'divOrden');
        $html .= '<div id="resultado"></div>';
        return $html;
        
        
    }
    
    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        echo $sql = 'DELETE FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $this->QuerySql($sql);
    }
    
    function fn_editar(){
        
    }
    
    function _mostrar(){
        $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');
        $html = $this->Cabecera();
        $html .=  '<div id="contenido">
            <h1 style="text-align: center;">'.$this->_titulo.'</h1>
            <form id="formulario">
                <fieldset>
                    <legend> '.$this->_subTitulo.' </legend>';
                    $html .= $this->formulario();
                    $html .= '
                </fieldset>
            ';
           
        $html .= '<br><br>';
        $html .= $this->tablaDatos();
            $html .= '</form></div>';
        echo $html;
    }
    
    function tablaDatos(){
        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = 'SELECT t.`descripcion`,t.`fecharegistro`,'.$editar.','.$eliminar.' FROM '.$this->Table.' t';
        //$sql .= ' INNER JOIN tipo_lente tl ON t.id_tipo_lente = tl.id_tipo_lente';
        $datos = $this->Consulta($sql); 
        
        $_array_formu = array();
        $_array_formu = $this->generateHead($datos);
        $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0] : array();
        $tablaHtml  ='<div id="tablaDatos">';
		$tablaHtml .= $this->print_table($_array_formu, 7, true, 'tablesorter');
        $tablaHtml .='</div>';
        if($this->_datos =='r')
            echo $tablaHtml;
        else
            return $tablaHtml;
        
    }   
}
?>