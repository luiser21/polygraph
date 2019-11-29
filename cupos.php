<?php
date_default_timezone_set("America/Bogota");


// Incluimos nuestro archivo config
include 'config.php'; 

// Sentencia sql para traer los agenda desde la base de datos
$sql="SELECT inicio_normal,final_normal FROM agenda"; 

// Verificamos si existe un dato
if ($conexion->query($sql)->num_rows)
{ 

    // creamos un array
    $datos = array(); 

    //guardamos en un array multidimensional todos los datos de la consulta
    $i=0; 

    // Ejecutamos nuestra sentencia sql
    $e = $conexion->query($sql); 
$hora=array();
$hora_sinsegu=array();
$horasola='';

$hora2=array();
$hora_sinsegu2=array();
$horasola2='';

$cupo=array();
    while($row=$e->fetch_array()) // realizamos un ciclo while para traer los agenda encontrados en la base de dato
    {	
		// Alimentamos el array con los datos de los agenda
		 $datos[$i] = $row; 
		 $hora=explode(' ',$datos[$i]['inicio_normal']);
		 $hora_sinsegu=explode(':',$hora[1]);
		 $horasola=$hora_sinsegu[0].':'.$hora_sinsegu[1];
		 
		
		 $hora2=explode(' ',$datos[$i]['final_normal']);
		 $hora_sinsegu2=explode(':',$hora2[1]);
		 $horasola2=$hora_sinsegu2[0].':'.$hora_sinsegu2[1];
		 
		 $cupo[]=$horasola.'-'.$horasola2;
		
		 $i++;
    }
	var_dump(array_unique($cupo));

   
}
   
?>