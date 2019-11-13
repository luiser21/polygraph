<style type="text/css">   
    <!--
    .Estilo44 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10px; }
    .Estilo45 {font-family: Arial, Helvetica, sans-serif; font-size: 8px; }
    .Estilo46 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; }
    table {border-collapse:collapse}
    td {border:1px solid black}
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
$arrEmpresas = $dbgestion->generar_informe_empresa();
$arrEquipos = $dbgestion->generarreporte($_GET["plantas"], $_GET["seccion"],$_GET["equipo"]);
//var_dump(count($arrEquipos));exit;
$l = 0;
date_default_timezone_set('America/Bogota');
ini_set('memory_limit', '5120M');
ini_set('max_execution_time', 0);
//var_dump(count($arrEquipos));
$division=count($arrEquipos)/35;
//echo '<br/>';
//var_dump($division);
$paginas=ceil($division);
//echo $paginas;
//exit; 
for($p=0;$p<$paginas;$p++){ ?>
<page pageset="old"  >
    <!--<bookmark title="Tabla de contenido" level="0" ></bookmark>
     here will be the automatic index -->
</page>
<?php }?>

    <?php
    $l = 0;
    $seccionindice='';
foreach ($arrEquipos as $value) {
    $l++;  
    $arrcomponentes = $dbgestion->generarreporte2($value['id_equipos']);
   
    if(count($arrcomponentes)>0){
       
       // if ($l == 150)
         //   break;
    ?>
    <page orientation="landscape"> 
        <br>
        <br><br>        
        <?php if ($l==1){ ?>
        <bookmark title="Planta <?php echo $value['PLANTA'] ?>" level="0" ></bookmark>
         <?php }if ($seccionindice<>$value['SECCION']){ ?>
        <bookmark title='Seccion <?php echo $value['SECCION'] ?>' level="0" ></bookmark>
         <?php }
         $seccionindice=$value['SECCION'];
         ?>
         <bookmark title='Maquina <?php echo $value['MAQUINA'] ?>' level="1" ></bookmark>
       
        <table width="120" height="108" align="center">
            <tr>
                <td colspan="13" rowspan="2" align="center">&nbsp; &nbsp; &nbsp; &nbsp;<img src="<?php echo $arrEmpresas[0]['LOGO'];?>" width="150" height="80" align="middle">
                    <span class="Estilo46">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;CARTA DE LUBRICACION &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    </span>
                    <?php  //if (file_exists($arrEmpresas[0]['LOGO2'])) {?>
                    <img src="<?php echo $arrEmpresas[0]['LOGO2'];?>" width="80" height="80" align="middle" /> 
                    <?php //} ?>
                </td>
                <td colspan="2"><span class="Estilo44">Codigo Carta  </span></td>
            </tr>
            <tr>
                <td height="45" colspan="2"><span class="Estilo44">No &nbsp;&nbsp; <?php echo $value['CODIGO_CARTA'] ?></span></td>
            </tr>
            <tr>
                <td height="6" colspan="2"><span class="Estilo44">EMPRESA: <?php echo $arrEmpresas[0]['EMPRESA'] ?></span></td>
                <td colspan="4"><span class="Estilo44">ACT. INDUSTRIAL: <?php echo $arrEmpresas[0]['TIPOACTIVIDAD'] ?></span></td>
                <td colspan="6"><span class="Estilo44">LUGAR: <?php echo $arrEmpresas[0]['ubicacion']   ?></span></td>
                <td colspan="3"><span class="Estilo44">FECHA: <?php echo date("F j, Y, g:i a") ?></span></td>
            </tr>
            <tr>
                <td height="6" colspan="2"><span class="Estilo44">PLANTA:  <?php echo $value['PLANTA'] ?></span></td>
                <td colspan="13"><span class="Estilo44">SECCION: <?php echo $value['SECCION'] ?></span></td>
            </tr>
            <tr>
                <td height="6" colspan="6"><span class="Estilo44">MAQUINA <?php echo ($l <= 7) ? '0' . $l : $l ?>:  <?php echo $value['MAQUINA'] ?></span></td>
                <td colspan="4"><span class="Estilo44">CODIGO: <?php echo $value['CODIGO_EMPRESA'] ?></span></td>
                <td colspan="5"><span class="Estilo44">FABRICANTE:</span></td>
            </tr>
    <?php
   
    $mecanismos=count($arrcomponentes);
    $componente2 = "";
    $contador=0;
    $i = 0;
    $y=0;
    $k=0;
    $j=0;
    $validar=false;
    foreach ($arrcomponentes as $value2) {
        $componente = $value2['id_componentes'];
        $idmecanismos=$value2['ID_MECA'];
        $k++;
        $i++;
        $j++;
        $contador++;
        if($j==1 && $validar==true){ 
           
            ?>
     <page  orientation="landscape"> 
        <br>
        <br><br>
        <table width="120" height="108" align="center">
            <tr>
                <td colspan="13" rowspan="2" align="center">&nbsp; &nbsp; &nbsp; &nbsp;<img src="<?php echo $arrEmpresas[0]['LOGO'];?>" width="150" height="80" align="middle">
                    <span class="Estilo46">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;CARTA DE LUBRICACION &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    </span>
                    <?php  //if (file_exists($arrEmpresas[0]['LOGO2'])) {?>
                    <img src="<?php echo $arrEmpresas[0]['LOGO2'];?>" width="80" height="80" align="middle" /> 
                    <?php //} ?>
                </td>
                <td colspan="2"><span class="Estilo44">Codigo Carta </span></td>
            </tr>
            <tr>
                <td height="45" colspan="2"><span class="Estilo44">No &nbsp;&nbsp; <?php echo $value['CODIGO_CARTA'] ?></span></td>
            </tr>
            <tr>
                <td height="6" colspan="2"><span class="Estilo44">EMPRESA: <?php echo $arrEmpresas[0]['EMPRESA'] ?></span></td>
                <td colspan="4"><span class="Estilo44">ACT. INDUSTRIAL: <?php echo $arrEmpresas[0]['TIPOACTIVIDAD'] ?></span></td>
                <td colspan="6"><span class="Estilo44">LUGAR: <?php echo $arrEmpresas[0]['ubicacion']?></span></td>
                <td colspan="3"><span class="Estilo44">FECHA: <?php echo date("F j, Y, g:i a") ?></span></td>
            </tr>
            <tr>
                <td height="6" colspan="2"><span class="Estilo44">PLANTA:  <?php echo $value['PLANTA'] ?></span></td>
                <td colspan="13"><span class="Estilo44">SECCION: <?php echo $value['SECCION'] ?></span></td>
            </tr>
            <tr>
                <td height="6" colspan="6"><span class="Estilo44">MAQUINA <?php echo ($l <= 7) ? '0' . $l : $l ?>:  <?php echo $value['MAQUINA'] ?></span></td>
                <td colspan="4"><span class="Estilo44">CODIGO: <?php echo $value['CODIGO_EMPRESA'] ?></span></td>
                <td colspan="5"><span class="Estilo44">FABRICANTE:</span></td>
            </tr>
        <?php 
        
        }if ($componente2 != $componente) {
           $y++;
           $k=1;
           if($j<=7){
            ?>
                    <tr  >
                        <td height="6" colspan="6"><span class="Estilo44">COMPONENTE <?php echo ' ' . ($y <= 7) ? '0' . $y : $y;
            echo ': ' . $value2['COMPONENTE']; ?></span></td>
                        <td colspan="4"><span class="Estilo44">CODIGO:</span></td>
                        <td colspan="5"><span class="Estilo44">FABRICANTE:</span></td>
                    </tr>
            <?php } 
        }if ($i == 1  or ($j==1 && $validar==true)) { ?>
        					
                        <tr  style="text-align: center; font-size: 10px;font-weight: bold;">
                            <td width="10" rowspan="3">No</td>
                            <td rowspan="3" >MECANISMO</td>
                            <td height="6" colspan="8">LUBRICANTE</td>
                            <td colspan="5">PROCESO</td>
                        </tr> 
                        <tr   style="text-align: center; font-size: 10px;font-weight: bold;">
                            <td width="30" rowspan="2"  height="12">Clase</td>
                            <td width="30" rowspan="2">Tipo</td>
                            <td width="40" rowspan="2">Categoria</td>
                            <td width="70" rowspan="2">Clasificaci&oacute;n</td>
                            <td width="20" rowspan="2">Nombre</td>
                            <td width="30" rowspan="2">Marca</td>
                            <td width="60" rowspan="2">M&eacute;todo Lubricaci&oacute;n</td>
                            <td width="30" rowspan="2">Tarea</td>
                            <td width="20" rowspan="2">Ptos</td>
                            <td width="20" rowspan="2">Frec</td>
                            <td width="30" colspan="2">Cantidad</td>
                            <td width="10" rowspan="2" colspan="1">R&oacute;tulo</td>
                        </tr>  
                        <tr>
                            <td height="1" colspan="2"></td>  
                        </tr>
            <?php } if($j<=7){
                ?>
                        <tr>
                            <td style="font-size: 10px;" align="center" ><?php echo ($k <= 7) ? '0' . $k : $k ?></td>
                            <td style="font-size: 10px;  width:200%;"><?php echo $value2['MECANISMO']    ?></td>
                            <td style="font-size: 10px;" align="center" ><?php echo $value2['CLASE'] ?></td>
                            <td style="font-size: 10px;  width:60%;" align="center"><?php echo $value2['TIPO'] ?></td>
                            <td style="font-size: 10px;" align="center" ><?php echo $value2['CATEGORIA'] ?></td>
                            <td style="font-size: 10px;" align="center" ><?php echo $value2['CLASIFICACION'] ?></td>
                            <td style="font-size: 10px; width:70%; text-align: center" ><?php echo $value2['NOM_LUBRICANTE'] ?></td>
                            <td style="font-size: 10px; width:60%;" align="center" ><?php echo $value2['MARCA'] ?></td>
                            <td style="font-size: 10px; width:60%;" align="center" ><?php echo $value2['METODO'] ?></td>
                            <td style="font-size: 10px; width:60%;" align="center" ><?php echo $value2['TAREAS'] ?></td>
                            <td style="font-size: 10px;" align="center"><?php echo $value2['PUNTOS'] ?></td>
                            <td style="font-size: 10px;" align="center"><?php echo $value2['FRECUENCIAS']." ".$value2['abreviaturaf']?></td>
                            <td style="font-size: 10px;" align="center" ><?php echo $value2['cantidad'] ?></td>
                            <td style="font-size: 10px;" align="center" ><?php echo $value2['abreviatura'] ?></td>
                            
                            <td style="font-size: 10px;" align="center"> 
                            <?php if($value2['RUTA']!='' || $value2['RUTA']!=null){ 
                                        $rotulo=$value2['RUTA'].$value2['ROTULO'];
                                      //  if (file_exists($rotulo)) {
                                ?>
                            <img src="<?php echo $rotulo?>" width="50" height="50" align="center" />
                             <?php // } 
                                        }?>
                            </td>
                        </tr>
                <?php
                 }
           $componente2 = $value2['id_componentes'];
       
      
           if($j==7 or $contador==$mecanismos){
                 $j=0;
                 $validar=true;
           ?>
        </table>
        <page_footer>
            <table class="page_footer">
                <tr>
                    <td style="width: 100%; text-align: center; border: none;">
                        Pag. [[page_cu]]/[[page_nb]]
                    </td>
                </tr>
            </table>
        </page_footer>
    </page> 
     <?php  } 
      }
     
     $arrimagenes = $dbgestion->generarreporte_imagen($value['id_equipos']); 
    
     if($arrimagenes[0]['RUTA']!=null){
        foreach ($arrimagenes as $value4) {
            $imagen=$value4['RUTA'].$value4['IMAGEN'];
           
     ?>     
     <page orientation="landscape">
        <br>
        <br><br>
        <br><br>
        
        <br>
        <H1 align="center">
            <span align="center"><img src="<?php echo $imagen?>"  width="600" height="500"  align="center" /></span>
        </H1>
        <br>
        <br><br>
        <br><br>
        <br>
        <page_footer>
         <table width="120" height="108" align="center"> 
                <tr>
                    <td colspan="13" rowspan="2" align="center">&nbsp; &nbsp; &nbsp; &nbsp;<img src="<?php echo $arrEmpresas[0]['LOGO'];?>" width="150" height="80" align="middle">
                        <span class="Estilo46">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                        </span>
                        
                        <img src="<?php echo $arrEmpresas[0]['LOGO2'];?>" width="80" height="80" align="middle" /> 
                       
                    </td>
                </tr>
                </table>
            <table class="page_footer">
            	 
                <tr>
                    <td style="width: 100%; text-align: center; border: none;" >
                        Pag. [[page_cu]]/[[page_nb]]
                    </td>
                </tr>
            </table>
        </page_footer>
    </page>

<?php }}
}} ?>