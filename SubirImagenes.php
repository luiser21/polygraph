<?php
session_start();
include './clases/packege.php';
class scripImg extends sql{
    function scandirRecursivo($carpeta){
        $readFiles = scandir($carpeta);
        $carpetaAnt = '';
        
        
        if(is_array($readFiles)){
            foreach ($readFiles as $values){
                if($values != '.' and $values != '..'){
                    $dir = 'EPSA/'.$values;
                    if(is_dir($dir)){
                        echo "<strong>$values</strong> <br>";
                        $carpetaAnt = $values;
                        $this->scandirRecursivo($dir);
                    }else{
                        $this->insertaDatos($values,$carpeta);
                    }
                }
            }
        }
    }
    
    function insertaDatos($values,$carpeta){
        $id  = explode('/',$carpeta);
        $orden = explode(".",$values);
        //echo $values.' | '.$id[1].'<br>';
        echo $sql = "INSERT INTO `equipos_imagen`(`description`, `file`, `id_equipos`,orden) 
        VALUES ('".$values."','".$values."','".$id[1]."','".$orden[0]."')";
        
        try{
            $this->QuerySql( $sql );
        }catch(Exception $e){
            echo $e;
        }
    }

    
}
$ob = new scripImg();
$readFiles = $ob->scandirRecursivo('EPSA');
?>