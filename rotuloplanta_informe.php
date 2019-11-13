
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
session_start();
include('clases/sql.php');
include('clases/crearHtml.class.php');

if(isset($_POST["id_planta"])){
   
    
    
    $dbgestion = new crearHtml();

    $sql="SELECT
            p.id_planta,
        	p.descripcion PLANTA,
        	CONCAT(
        		f.descripcion,
        		'_',
        		l.clase,
        		'_',
        		a.aplicacion,
        		'_',
        		l.categoria,
        		'_',
        		cl.abreviatura
        	) PARAMETROS_ROTULO,
        	l.DESCRIPCION,
        	l.MARCA,
        	sum(me.puntos) CANTIDAD,
        	CONCAT(si.ruta, si.descripcion) ARCHIVO
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
        	l.id_lubricantes = me.cod_lubricante
        )
        INNER JOIN aplicaciones_lub a ON (
        	me.id_aplicacion = a.id_aplicacion
        )
        INNER JOIN frecuencias f ON (
        	me.id_frecuencias = f.id_frecuencias
        )
        INNER JOIN clasificaciones cl ON (
        	l.cod_clasificacion = cl.id_clasificaciones
        )
        INNER JOIN simbologia si ON (
        	me.id_simbologia = si.id_simbologia
        )

    ";
    if($_POST['id_planta']<>0){
        $sql.=" WHERE p.id_planta = ".$_POST['id_planta']." ";
    }
    $sql.=" GROUP BY
    	p.descripcion,
    	Parametros_Rotulo,
    	l.descripcion,
    	l.marca,
    	Archivo
        ORDER BY
    	p.descripcion,
    	Parametros_Rotulo ";
     
    if(isset($_POST["sin_id_planta"])==1){
        $sql="SELECT
            	CONCAT(
            		f.descripcion,
            		'_',
            		l.clase,
            		'_',
            		a.aplicacion,
            		'_',
            		l.categoria,
            		'_',
            		cl.abreviatura
            	) PARAMETROS_ROTULO,
            	l.DESCRIPCION,
            	l.MARCA,
            	sum(me.puntos) CANTIDAD,
            	CONCAT(si.ruta, si.descripcion) ARCHIVO
            FROM
            	mec_met me
            INNER JOIN lubricantes l ON (
            	l.id_lubricantes = me.cod_lubricante
            )
            INNER JOIN aplicaciones_lub a ON (
            	me.id_aplicacion = a.id_aplicacion
            )
            INNER JOIN frecuencias f ON (
            	me.id_frecuencias = f.id_frecuencias
            )
            INNER JOIN clasificaciones cl ON (
            	l.cod_clasificacion = cl.id_clasificaciones
            )
            INNER JOIN simbologia si ON (
            	me.id_simbologia = si.id_simbologia
            )
            GROUP BY
            	Parametros_Rotulo,
            	l.descripcion,
            	l.marca,
            	Archivo
            ORDER BY
            	Parametros_Rotulo";
        }
    $partidos= $dbgestion->Consulta($sql);
}

date_default_timezone_set('America/Bogota');
ini_set('memory_limit', '5120M');
ini_set('max_execution_time', 0);

   
    
    ?>
   
     <page  > 
        <br>
        <br><br>
       
        <table width="120" height="108" align="center">
            
            
             <?php 
             $planta=0;
             foreach ($partidos as $value) {
                 if(!isset($_POST["sin_id_planta"])){
                    if($planta<>$value['id_planta'] ){?>
            <tr>
                <td height="6" colspan="15"><span class="Estilo44">PLANTA:  <?php echo $value['PLANTA'] ?></span></td>
            </tr>
            
       
                       
                        <tr   style="text-align: center; font-size: 10px;font-weight: bold;">
                            <td width="90"   height="12">PARAMETROS ROTULO</td>
                            <td width="30" >DESCRIPCION</td>
                            <td width="40" >MARCA</td>
                            <td width="70" >CANTIDAD</td>
                            <td width="20">ARCHIVO</td>
                        </tr>  
                       
             <?php  }
                      $planta=$value['id_planta'];
                 }else{
                     if($planta==0){
                     ?>
                 
                  <tr   style="text-align: center; font-size: 10px;font-weight: bold;">
                            <td width="90"   height="12">PARAMETROS ROTULO</td>
                            <td width="30" >DESCRIPCION</td>
                            <td width="40" >MARCA</td>
                            <td width="70" >CANTIDAD</td>
                            <td width="20">ARCHIVO</td>
                        </tr>  
           <?php    }
                    $planta++;
                 }
                  
             ?>
                        <tr>
                            <td style="font-size: 10px;" align="center" ><?php echo $value['PARAMETROS_ROTULO'] ?></td>
                            <td style="font-size: 10px;  width:60%;" align="center"><?php echo $value['DESCRIPCION'] ?></td>
                            <td style="font-size: 10px;" align="center" ><?php echo $value['MARCA'] ?></td>
                            <td style="font-size: 10px;" align="center" ><?php echo $value['CANTIDAD'] ?></td>
                            <td style="font-size: 10px;" align="center"> 
                            <?php if($value['ARCHIVO']!='' || $value['ARCHIVO']!=null){ 
                                        $rotulo=$value['ARCHIVO'];
                                        if (file_exists($rotulo)) {
                                ?>
                            <img src="<?php echo $rotulo?>" width="50" height="50" align="center" />
                             <?php } 
                                        }?>
                            </td>
                        </tr>
               <?php } ?>
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
    

