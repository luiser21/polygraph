<style type="text/css">   
    <!--
    .Estilo44 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10px; }
    .Estilo45 {font-family: Arial, Helvetica, sans-serif; font-size: 8px; }
    .Estilo46 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; }
    table {border-collapse:collapse}
    td {border:1px solid black}
   p {line-height: 100%; font-family: "arial", serif; font-size: 11px; text-align:justify;margin: 10px 0; }
    -->   
<!--
	table.page_footer {width: 100%; border: none; background-color: #FFFFFF; border-top: solid 1mm #FFFFFF; padding: 2mm}
-->

</style>
<?php
include('clases/sql.php');
include('clases/crearHtml.class.php');
session_start();

$dbgestion = new crearHtml(); 

$arrPlantas = $dbgestion->generarreporte($_GET["cedula"],$_GET["idautorcandidato"]);

$titulo=$arrPlantas[0]['nombre_autorizacion'];
$nombre=$arrPlantas[0]['EVALUADO'];
$cedula=$arrPlantas[0]['CEDULA'];
$ciudadexpedicion=$arrPlantas[0]['LUGAREXPEDICION'];
$cliente=$arrPlantas[0]['clientefinal'];
$cargo=$arrPlantas[0]['cargo'];
$politica=$arrPlantas[0]['politicas'];
$tipo_prueba=$arrPlantas[0]['tipo_prueba'];
$celular=$arrPlantas[0]['CELULAR'];
$empresa=$arrPlantas[0]['clientetercerizado'];
$fecha=$arrPlantas[0]['FECHA'];
$foto=$arrPlantas[0]['foto'];
$observacion=$arrPlantas[0]['observaciones'];
$politica=explode('#', $politica);

$autorizacion=$politica[0].' <strong>'.$nombre.'</strong> '.$politica[1].' <strong>'.$cedula.'</strong> '.$politica[2].' <strong>'.$ciudadexpedicion.'</strong> '.$politica[3].' <strong>'.$cargo.'</strong> ';
$autorizacion.=$politica[4].' <strong>'.$empresa.'</strong> '.$politica[5].' <strong>'.$empresa.'</strong> '.$politica[6].' <strong>'.$cliente.'</strong> '.$politica[7].' <strong>'.$empresa.'</strong> ';
$autorizacion.=$politica[8].' <strong>'.$empresa.'</strong> '.$politica[9].' <strong>'.$empresa.'</strong> '.$politica[10];


date_default_timezone_set('America/Bogota');
ini_set('memory_limit', '5120M');
ini_set('max_execution_time', 0);
 ?>
    <page > 
        <br>
        <br><br>
        <table width="120" height="108" align="center">
           <tr>
                <td>&nbsp;<img src="<?php echo $arrPlantas[0]['logo'] ?>" width="250" height="100"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                
                 <td>  <img src="<?php echo $foto ?>" width="100" height="100"  /></td>
           </tr>
        </table>
        <h3 align="center"><?php echo $titulo; ?></h3><br/>
      <?php echo $autorizacion; ?>
      
       <div >
            <p>Lugar y Fecha: <strong><?php  echo $fecha; ?></strong></p>
            <p>Tipo de Prueba: <strong><?php echo $tipo_prueba; ?> </strong></p>
            <p>No de Celular: <strong><?php echo $celular; ?></strong></p>
            <p>&nbsp;</p>              
        </div>
         <p>OBSERVACIONES:  <?php echo $observacion; ?></p>
    </page> 
         
    
