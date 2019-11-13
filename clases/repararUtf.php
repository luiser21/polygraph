<?php
session_start();
include 'packege.php';
/**
 * Index
 * 
 * @package carLub
 * @author Javier Ardila
 * Clase dependientede crearHtml.class.php
 * @copyright 2017
 * @version 0.1
 * @access public
 */
class RepararUtf extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA COMPONENTES';
    public $_subTitulo = 'Los componentes son asociados en un arbol de Planta => Seccion =>Equipo';
    public $_datos = '';
    public $Table = 'componentes';
    public $PrimaryKey = 'id_componentes';
     
    
    
   /**
    * Index::Contenido()
    * Crea primer formulario de interfaz visual para el usuario.
    * 
    * @return Html con contenido de formulario
    */
   function RepararUtf(){
    
    $sql = 'SELECT descripcion from componentes WHERE  `id_componentes` 
			IN ( 10, 12 ) ';
    $arrResult = $this->Consulta($sql);
    foreach ($arrResult as $key => $value) {
    	echo $value['descripcion'] .'utf=>'. utf8_encode($value['descripcion'].'<br>');
    }
    
        
    }
    
   
    
    function guardarDatos(){
        $this->runActualizar();        
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * Index::runEliminar()
     * Realiza eliminar de las tablas componentes=> mecanismos => mec_met
     * @return void
     */
    function runEliminar(){

        
        $sql = 'DELETE C, M, MM FROM componentes C 
                LEFT JOIN mecanismos M ON M.id_componente = C.id_componentes
                LEFT JOIN mec_met MM ON MM.id_mecanismos = M.id_mecanismos
                WHERE C.id_componentes = '.$this->_datos;
               // echo 'Componente eliminado con exito';
        
        $_respuesta = array('Codigo' => 0, "Mensaje" => '<strong> OK: </strong> El registro se ha eliminado.');
        try {            
            $this->QuerySql($sql);
        }
        catch (exception $e) {
            $_respuesta = array('Codigo' => 99, "Mensaje" => $e->getMessage());
        }
        
        print_r(json_encode($_respuesta));
    }
    
    function fn_editar(){
        
    }
    
    /**
     * Index::getDatos()
     * Extrae todos los datos y los retorna como Json, creada para llenar formularios en el editar de cada interfaz 
     * @return void
     */
    function getDatos(){
       
    }
  
    
    
}

$j = new RepararUtf();
$j->RepararUtf();

?>