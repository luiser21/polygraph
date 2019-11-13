<?php
class codigo extends crearHtml{
    
    function getCodigo($cod){    
        $sql = "SELECT `fecha_aprobado`, `codigoaprobado`  FROM `mis_cursos` WHERE `codigoaprobado` = '{$cod}'";
        /** 57CDD3D1*/
        
        $datos = $this->Consulta($sql); 
        if( count( $datos ) )   return true;
        else    return false;
    }
}
?>