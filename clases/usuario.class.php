<?php
class Usuario extends crearHtml{
    
    public $sesion = false;
    public $msg_sesion;
    
    function iniciarSesion($usuario,$clave){
        $sql = "SELECT nombre,tipo,id_usuario FROM usuarios WHERE usuario = '".$usuario."' AND clave = '".md5($clave)."'";
        $datos = $this->Consulta($sql);
        if(is_array($datos) && count($datos)){
            $this->sesion = 1;
            $this->msg_sesion = 'Usuario Correcto';
            return $datos;
        }
        else{
            $this->sesion = false;
            $this->msg_sesion = 'Usuario y/o contraseña incorrectos';    
        }
        
    }
}
    
?>