<?php
include 'session.php';
include './appcfg/cc.php';
include './appcfg/sql.php';
include './appcfg/funciones.php';

include './admin/admincont/cursos/cursos.class.php';


$cid = $_SESSION['IdC'];


    $con = new Conection();
	
	
	
	$ObjCursos = new Cursos;
	$ObjCursos->idUsuario = $cid;
	
	$miEvaluacion = $ObjCursos->miEvaluacion($_GET['Curso'],$_SESSION['IdC']);
	
//imprimir($miEvaluacion);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::-Evaluacion de curso-::</title>
<style>
fieldset {
width:500px;
border:4px double #FFFFFF;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
/*-webkit-box-shadow: 8px 8px 6px #808080;
-moz-box-shadow: 8px 8px 6px #808080;
box-shadow: 8px 8px 6px #808080;*/
background-color: #e5e5e5;
padding: 10px;
font-family: Arial, Helvetica, sans-serif;
color: #0B173B;
/*-webkit-transform: rotate(-6deg);
-moz-transform: rotate(-6deg);
-o-transform: rotate(-6deg);*/
}
legend {
text-align:center;
font-weight:bold;
/*font-size:18pt;*/
/*color:#B4045F;*/
/*text-shadow: 0px 0px 10px #BA55D3;*/
}
</style>

<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/jquery.validate.js"></script>
<link rel="stylesheet" type="text/css" href="js/cmxform.css"/>


<script>
		/*   
			alert("Está activado");  
		} else {  
			alert("No está activado");  
		} */

	function mostrarSiguiente(idActual,Radio,Maximo){
		
		var Mostrar = idActual+1;
		if( $("#Form input[name='"+Radio+"']:radio").is(':checked')) {
			$('#Oculto'+idActual).hide('slow');
			$('#Oculto'+Mostrar).show('slow');
			if(idActual==Maximo){
				$('#divGuardar').show('slow');
				
			}
		}
		else { 
			alert('Debe elegir una respuesta para poder continuar');
		}
	}
</script>

</head>

<body>
<?
if(isset($_POST['Guardar'])){
	if($miEvaluacion[0]['Intentos'] > 2)
		echo 'ha superado el nivel de intentos <input type="button" value="Ok-Cerrar" />';
	else{
		$ObjCursos->Intentos	= $miEvaluacion[0]['Intentos'];
		//echo '<hr>INTENTOS=>'.$ObjCursos->Intentos.'<hr>';
		$ObjCursos->idMiCurso 	= $_GET['Curso'];
        
		$ResultExamen = $ObjCursos->compruebaResultado($_POST);
		//imprimir($_SESSION);
		echo $ResultExamen;
	}
	
}
elseif($miEvaluacion[0]['Intentos'] < 3){

echo '
	<form name="Form" id="Form" method="post">
<fieldset><legend>Usted esta en:</legend>
<table border="0">
						<tr> 
							<td><b>Evaluacion:</b> '.$miEvaluacion[0]['nombreEvaluacion'].'</td>
						</tr>
							<tr>
						<td><b>Curso:</b> '.$miEvaluacion[0]['nombreCurso'].'</td> 
						</tr>
</table>					 
					 </fieldset><br>
					 ';

//imprimir($miEvaluacion);

//Dejos los id en un unico para luego recorrerlos
foreach($miEvaluacion as $Curso){
	
	$Idp[] = $Curso['Ids'];
	$NombrePreg[] = $Curso['nombrePregunta'];
}
$idPreguntas = array_unique($Idp);
//imprimir($idPreguntas);

$Cant = count($idPreguntas);
$i=1;
	foreach($idPreguntas as $Clave => $IdPreg){
	
	if($i>1)
		echo  '<div style="display:none" id="Oculto'.$i.'">';
	else
		echo  '<div id="Oculto'.$i.'">';
		
		echo '<fieldset><legend>Pregunta '.$i.'/'.$Cant.' - '.$NombrePreg[$Clave].'</legend>
		<table border="0">
		';
		
		foreach($miEvaluacion as $Curso){
			if($Curso['Ids'] == $IdPreg){
			//$Co
				echo '<tr> 
						<td>'.$Curso['Pregunta'].'</td>
						<td><input name="Respuesta[]'.$IdPreg.'" id="Respuesta'.$IdPreg.'" type="radio" value="'.$Curso['Correcta'].'" class="required" /></td> 
					 </tr>';
			}
		}
		
		echo '</table>
		</fieldset><br>';
		
		echo '<input type="button" value="Siguiente" onclick="mostrarSiguiente('.$i.',\'Respuesta[]'.$IdPreg.'\','.$Cant.')">';
		
		echo '</div>';
		
		$i++;
	}
echo '<br>El número de preguntas mínimo a responder para poder pasar el examen es de:'.round($Cant*70/100).'<br>';

echo '<div id="divGuardar" style="display:none"> <hr> Ha completado el examen, clic en guardar para finalizar el proyecto <input type="submit" name="Guardar" id="Guardar" value="Guardar" /> <hr> </div> <br> 
<input type="button" value ="Cancelar" onclick="window.close();" />
</form>
';
}
else echo 'El número de intentos para esta evaluación ha sido superado';
?>
</body>
</html>