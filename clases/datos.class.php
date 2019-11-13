<?php
/**
 * Clase para el manejo del software para lentes.
 * @access public
 * @see Formulario
 * @version 1.0 <i>[30 de Septiembre de 2014]</i> Versi&oacute;n Inicial
 * @author Javier David Ardila B
 * @package /Clases/
 *
 */
class Datos extends crearHtml{
	public $_idUsuario = false;
//    public $_datos_clase = array();
    
    
    function getUsuario(){
        if(!$this->_idUsuario){
            echo 'No existe Id usuario';
            exit;
        }else
            return $this->Consulta('SELECT  `id_tipodocumento`, `nombre`, `usuario`, `clave`, `direccion`, `email`, `telefono`, `celular`  FROM `usuarios` where id_usuario = '.$this->_idUsuario);
    }
    
    function getcoloracion(){
        return $this->Consulta('SELECT id_coloracion codigo,descripcion FROM `coloracion` where activo = 1');
    }
    
    function getIndices(){
        return $this->Consulta('SELECT id_indice codigo,descripcion FROM `indice` where activo = 1');
    }
    function getFocoMaterial(){
        return $this->Consulta('SELECT id_foco_material codigo,descripcion FROM `foco_material` where activo = 1');
    }
    function getTratamiento($idIndice=false){
        $sw = '';
        if($idIndice)
            $wh = ' AND id_indice = '.$idIndice;
            
        $sql = 'SELECT id_tratamiento codigo,descripcion FROM `tratamiento` where activo = 1 '.$wh;    
        return $this->Consulta($sql);
    }                  

}	
?>