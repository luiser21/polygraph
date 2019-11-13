<?php 
session_start();
include('clases/sql.php');
include('clases/crearHtml.class.php');

if(isset($_POST["id_planta"]) && isset($_POST["fecha_ini"]) && isset($_POST["fecha_fin"])){
   

$dbgestion = new crearHtml();

$sql="SELECT
                	p.descripcion Planta,
                	s.descripcion Seccion,
                	e.codigo_empresa Cod_Equipo,
                	e.descripcion Equipo,
                	c.codigo_empresa Cod_Componente,
                	c.descripcion Componente,
                	m.codigoempresa Cod_Mecanismo,
                	m.descripcion Mecanismo,
                	met.descripcion Metodo,
                	t.descripcion Tarea,
                	od.puntos Puntos,
                	l.descripcion Lubricante,
                	l.marca Marca,
                	l.tipo Tipo,
                	l.clase Clase,
                	l.categoria Categoria,
                	cl.descripcion Clasificacion,
                	f.descripcion Frecuencia,
                	od.cantidad_real Cantidad,
                	u.abreviatura Unidad,
                	od.minutos_ejec_real Minutos_Ejec,
                	od.observaciones_ejec Observaciones,
                	od.fecha_real fecha_Ejec,
                	CASE od.ejecutado
                WHEN 1 THEN
                	'SI'
                ELSE
                	'NO'
                END AS Ejecutado
                FROM
                	ot_detalle od
                INNER JOIN ot ON (od.id_ot = ot.id_ot)
                INNER JOIN mecanismos m ON (
                	od.id_mecanismos = m.id_mecanismos
                )
                INNER JOIN componentes c ON (
                	m.id_componente = c.id_componentes
                )
                INNER JOIN equipos e ON (c.id_equipos = e.id_equipos)
                INNER JOIN secciones s ON (
                	e.id_secciones = s.id_secciones
                )
                INNER JOIN plantas p ON (s.id_planta = p.id_planta)
                LEFT JOIN lubricantes l ON (
                	od.id_lubricante = l.id_lubricantes
                )
                LEFT JOIN metodos met ON (
                	od.id_metodos = met.id_metodos
                )
                LEFT JOIN tareas t ON (od.id_tareas = t.id_tareas)
                LEFT JOIN frecuencias f ON (
                	od.id_frecuencias = f.id_frecuencias
                )
                LEFT JOIN unidades u ON (
                	od.codunidad_cant_real = u.id_unidades
                )
                LEFT JOIN clasificaciones cl ON (
                	l.cod_clasificacion = cl.id_clasificaciones
                )
                WHERE
                	ot.estado = 1
                AND od.fecha_prog BETWEEN '".$_POST['fecha_ini']."' AND '".$_POST['fecha_fin']."' ";
if($_POST['id_planta']<>0){
    $sql.=" AND p.id_planta = ".$_POST['id_planta']." ";
}

$sql.= " ORDER BY
                	p.descripcion,
                	s.descripcion,
                	e.descripcion,
                	c.descripcion,
                	m.descripcion,
                	met.descripcion,
                	t.descripcion";
$res= $dbgestion->Consulta($sql);
$_array_formu = array();
$_array_formu = generateHead2($res);
$dbgestion->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();

$FI =$_POST['fecha_ini'];
$FF =$_POST['fecha_fin'];
$file = "Exportar_OTs_Cerradas".$FI." AL ".$FF.".csv";

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