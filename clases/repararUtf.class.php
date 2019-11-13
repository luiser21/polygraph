<?php
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
   function actualizarTablas(){
    



     $arrActualiza[0]['tabla'] = 'plantas';
     $arrActualiza[0]['campo'] = 'id_planta';

     $arrActualiza[1]['tabla'] = 'secciones';
     $arrActualiza[1]['campo'] = 'id_secciones';

     $arrActualiza[2]['tabla'] = 'equipos';
     $arrActualiza[2]['campo'] = 'id_equipos';

    $arrActualiza[3]['tabla'] = 'mecanismos';
    $arrActualiza[3]['campo'] = 'id_mecanismos';

    $arrActualiza[4]['tabla'] = 'componentes';
    $arrActualiza[4]['campo'] = 'id_componentes';

     $arrActualiza[5]['tabla'] = 'metodos';
     $arrActualiza[5]['campo'] = 'id_metodos';

    $arrActualiza[6]['tabla'] = 'tareas';
    $arrActualiza[6]['campo'] = 'id_tareas';

     $arrActualiza[7]['tabla'] = 'lubricantes';
     $arrActualiza[7]['campo'] = 'id_lubricantes';



   
    foreach ($arrActualiza as $v) {
        echo $sql = 'SELECT descripcion,'.$v['campo'].' from '.$v['tabla'];
        echo '<br>';
        $arrResult = $this->Consulta($sql);
        foreach ($arrResult as $key => $value) {
            if(mb_check_encoding($value['descripcion'],'utf8')){
                echo 'VALIDO => '.  $value['descripcion'].'<br>';
            }else{
                echo 'INVALIDO => '.utf8_encode($value['descripcion']).'<br>';
                echo $sql = "UPDATE ".$v['tabla']." SET descripcion = '".utf8_encode($value['descripcion'])."' WHERE ".$v['campo']." = ".$value[$v['campo']];
                echo '<br>';
                $this->QuerySql($sql);
            }

            //echo $value['descripcion'] .' ( '.mb_detect_encoding($value['descripcion']).' )  utf=> '. utf8_encode($value['descripcion'].' Ecode => '.mb_detect_encoding($value['descripcion']).' ( '.$value['id_componentes'].' )<br>');
        }
    }
    
    
        
    }
    
   
    

}



?>