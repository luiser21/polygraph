<meta charset="ISO-8859-1">
<style type="text/css">   
    <!--
    .Estilo44 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10px; }
    .Estilo45 {font-family: Arial, Helvetica, sans-serif; font-size: 8px; }
    .Estilo46 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; }
    table {border-collapse:collapse}
    td {border:1px solid black}
   p {line-height: 140%; font-family: "arial", serif; font-size: 11px; text-align:justify;margin: 10px 0; }
    -->   
<!--
	table.page_footer {width: 100%; border: none; background-color: #FFFFFF; border-top: solid 1mm #FFFFFF; padding: 2mm}
-->

</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="webcam.js"></script>
    <script language="JavaScript">
		webcam.set_api_url( 'test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
		webcam.set_quality( 90 ); // calidad de la imagen
	</script>
		<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function do_upload() {
			// subir al servidor
			//document.getElementById('upload_results').innerHTML = '<h1>Cargando al servidor...</h1>';
			$('#autorizacion').css('display','block');
			webcam.upload();
		}
		
	</script>
	

<?php
date_default_timezone_set('America/Bogota');
setlocale(LC_ALL,"es_ES");
session_start();


if(!$_SESSION['id_usuario'])
      header('Location: ./login.php');
include './clases/packege.php';
include('./clases/autorizacion.class.php');
 
$ob = new Plantas;
$ob->Iniciar();
?>