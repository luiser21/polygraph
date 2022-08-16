<?php 
session_start();
include('clases/sql.php');
include('clases/crearHtml.class.php');

if(isset($_POST["id_planta"])){
   

$dbgestion = new crearHtml();

$sql="SELECT DISTINCT
	p.descripcion Planta,
	l.marca Marca,
	l.tipo Tipo,
	l.clase Clase,
	l.categoria Categoria,
	l.descripcion Lubricante
FROM
	mec_met me
INNER JOIN mecanismos m ON (
	me.id_mecanismos = m.id_mecanismos
)
INNER JOIN componentes c ON (
	m.id_componente = c.id_componentes
)
INNER JOIN equipos e ON (c.id_equipos = e.id_equipos)
INNER JOIN secciones s ON (
	e.id_secciones = s.id_secciones
)
INNER JOIN plantas p ON (s.id_planta = p.id_planta)
INNER JOIN lubricantes l ON (
	me.cod_lubricante = l.id_lubricantes
) ";
if($_POST['id_planta']<>0){
    $sql.=" WHERE p.id_planta = ".$_POST['id_planta']." ";
}
$sql.=" ORDER BY
	p.descripcion,
	l.marca,
	l.tipo,
	l.clase,
	l.descripcion";

$res= $dbgestion->Consulta($sql);
$_array_formu = array();
$_array_formu = generateHead2($res);
$dbgestion->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();

$file = "Lubricantes_por_planta.csv";

header('Expires: 0');
header('Cache-control: private');
header('Content-Type: application/x-octet-stream'); // Archivo de Excel
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Last-Modified: '.date('D, d M Y H:i:s'));
header('Content-Disposition: attachment; filename="'.$file.'"');
header("Content-Transfer-Encoding: binary");
echo print_table_plain2($_array_formu,4);
}


function print_table_plain2($array){
    $_return = '';
    if( is_array($array) ){
        $_fila = 0;
        foreach($array as $c => $k){
            if( is_array($k) ){
                foreach($k as $c1 => $k1){
                    $_return.=$k1.";";
                }
            }
            $_return.="\n";
            $_fila++;
        }
    }
    return $_return;
}
function generateHead2($_array){
    $_array_formu = array();
    if( isset($_array[0]) && is_array($_array[0]) ){
        foreach($_array[0] as $c => $k){
            $_array_formu[0][] = STRTOUPPER($c) ;
        }
    }
    return $_array_formu = array_merge($_array_formu, $_array);
}
?>