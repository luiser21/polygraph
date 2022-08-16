<?php
session_start();
include('clases/sql.php');
include('clases/crearHtml.class.php');
$dbgestion = new crearHtml();
  
$directorio_empresa = $dbgestion->sacar_empresa();
  // read input stream
	$data = file_get_contents("php://input");
	
	// filtering and decoding code adapted from
  // http://stackoverflow.com/questions/11843115/uploading-canvas-context-as-image-using-ajax-and-php?lq=1
	// Filter out the headers (data:,) part.
	$filteredData=substr($data, strpos($data, ",")+1);
	// Need to decode before saving since the data we received is already base64 encoded
	$decodedData=base64_decode($filteredData);

	// store in server
	$fic_name = $_GET['archivo'];
	$fp = fopen($directorio_empresa.'/imagenes/rotulos/'.$fic_name, 'wb');
	$ok = fwrite( $fp, $decodedData);
	fclose( $fp );
	if($ok)
		echo $fic_name;
	else
		echo "ERROR";
?>
