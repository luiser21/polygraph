<?

#Clase encargada del manejo de cursos y evaluaciones
class Cursos extends sql{
	
	var $Html;
	var $Ruta;
	var $IdEvaluacion;
	var $DatosIns;
	var $Intentos;
	var $idMiCurso;
	var $idUsuario;
	
	function Cabezote(){
		$this->Ruta = $_SERVER['HTTP_REFERER'];
		$this->Html  = '<div align="center">Administrar Cursos</div>';
		$this->Html .= '<div align="center" class="MenuCabezote">
					<ul>
						<li><a href="javascript:cargarIframe(\'cargaFormularios\',\''.$this->Ruta.'/cursos/Cursos.php\');">Crear</a></li>
						
						<li>Editar</li>
						<li>Eliminar</li>
					</ul>
					<div align="left">
					<iframe name="cargaFormularios" width="100%" height="600" id="cargaFormularios" frameborder="0" scrolling="auto" src=""></iframe></di>
					';
	}
	
	function CrearCurso($Datos,$Files=false){
		

		$Archivos = $this->SubirImagen($Files);
		//print_r($Archivos);
		$Tabla = 'cursos_online';
		$Campos = '`IdCategoria`,
		`Curso`,
		`Descripcion`,
		`Archivo1`,
		`Archivo2`,
		`Precio`,
		`Img`,
		`Logo`,
		`ImgMiembro1`,  `ImgMiembro2`,  `ImgMiembro3`,  `ImgMiembro4`,  `ImgMiembro5`,  `ImgMiembro6`,  `ImgPatrocinador1`,  `ImgPatrocinador2`,  `ImgPatrocinador3`,  `ImgPatrocinador4`,  `ImgPatrocinador5`,  `ImgPatrocinador6`';
		$Valores = "'".$Datos[idCategoria]."',	'".$Datos[Curso]."',  '".$Datos[Descripcion]."',  '".$Archivos[0]."',  '".$Archivos[1]."',   '".$Datos[Precio]."',	'".$Archivos[2]."',	'".$Archivos[3]."','".$Archivos[4]."',	'".$Archivos[5]."',	'".$Archivos[6]."',	'".$Archivos[7]."',	'".$Archivos[8]."',	'".$Archivos[9]."',	'".$Archivos[10]."',	'".$Archivos[11]."',	'".$Archivos[12]."',	'".$Archivos[13]."',	'".$Archivos[14]."',	'".$Archivos[15]."'";
		
		$IdCursoOnline = $rec=$this->InsertSql($Tabla,$Campos ,$Valores); 
		
		//Crea Seccion en el admin de contenidos para la infomacion del curso.
		echo $rec=$this->InsertSql('site_web','Title,IdCursoOnline,Idioma','"'.$Datos[Curso].'", "'.$IdCursoOnline.'","es"'); 
		
	}
	
	/**
	 * Producto::EditarCurso()
	 * 
	 * @return
	 */	
	function EditarCurso($Datos,$Files){
		
		
		$Archivos = $this->subirEditarFile($Files,15,$Datos);
		
		$actualizaArchivo 	.= ($Archivos[0]!='') ? ' ,`Archivo1` = "'.$Archivos[0].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[1]!='') ? ' ,`Archivo2` = "'.$Archivos[1].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[2]!='') ? ' ,`Img` = "'.$Archivos[2].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[3]!='') ? ' ,`Logo` = "'.$Archivos[3].'" ' : ' ';
		
		$actualizaArchivo 	.= ($Archivos[4]!='') ? ' ,`ImgMiembro1` = "'.$Archivos[4].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[5]!='') ? ' ,`ImgMiembro2` = "'.$Archivos[5].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[6]!='') ? ' ,`ImgMiembro3` = "'.$Archivos[6].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[7]!='') ? ' ,`ImgMiembro4` = "'.$Archivos[7].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[8]!='') ? ' ,`ImgMiembro5` = "'.$Archivos[8].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[9]!='') ? ' ,`ImgMiembro6` = "'.$Archivos[9].'" ' : ' ';
		
		$actualizaArchivo 	.= ($Archivos[10]!='') ? ' ,`ImgPatrocinador1` = "'.$Archivos[10].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[11]!='') ? ' ,`ImgPatrocinador2` = "'.$Archivos[11].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[12]!='') ? ' ,`ImgPatrocinador3` = "'.$Archivos[12].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[13]!='') ? ' ,`ImgPatrocinador4` = "'.$Archivos[12].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[14]!='') ? ' ,`ImgPatrocinador5` = "'.$Archivos[14].'" ' : ' ';
		$actualizaArchivo 	.= ($Archivos[15]!='') ? ' ,`ImgPatrocinador6` = "'.$Archivos[15].'" ' : ' ';
		
		
		$Tabla 		= 'cursos_online';
		$Set 		= "`IdCategoria` = '".$Datos['idCategoria']."', `Curso` = '".$Datos[Curso]."',  `Descripcion` = '".$Datos[Descripcion]."',`Precio` = '".$Datos[Precio]."' ".$actualizaArchivo."";
		$Where 		=  'Id = '.$Datos[IdCurso];
		$rec=$this->ActSql($Tabla,$Set,$Where); 
		
		#Cambia el nombre en la seccion creada del administrador
		$rec=$this->ActSql('site_web','Title = "'.$Datos[Curso].'"','IdCursoOnline = '.$Datos[IdCurso]);
	}	
	
	
	/**
	 * Producto::SubirImagen()
	 * @param Imagen, recibe $_FILES 
	 * @param Recibe cantidad de veces que debe recoger los FILES
	 * @param Hidden de la imagen para comparar
	 * @return array con nombre de los archivos cargados
	 */
	function subirEditarFile($Imagen,$Vueltas='15',$Datos)
	{
		/*echo '<pre>';
		print_r($Imagen);
        echo '</pre>';*/
		for($i=0; $i<=$Vueltas; $i++)
		{//&& $Datos['ArchivoH'][$i]!=""
			if($Imagen['Archivo']['name'][$i] !='' )
			{
				$origen 			= $Imagen['Archivo']['tmp_name'][$i];
				$nombreImagen 		= $Imagen['Archivo']['name'][$i];
				$nombreImagen 		= strstr($nombreImagen,'.');
				$retornaImagen[$i] 	= date(yis).rand(123,999).$nombreImagen;
				$destino 			= '../../../ArchivosCursosOnline/'.$retornaImagen[$i];
				
				move_uploaded_file($origen, $destino);
				unlink('../../../ArchivosCursosOnline/'.$Datos['ArchivoH'][$i]);
			}
			else $retornaImagen[$i] = '';
		}
		return $retornaImagen;
	}
	
	
	function GetCursos($Id='',$Idcategoria='',$Orden=false){
		
		$Where = (!empty($Id)) ? ' WHERE Id = '.$Id : '';
		$Wherec = (!empty($Idcategoria)) ? ' WHERE IdCategoria = '.$Idcategoria : '';
		
		
		$orderBy ='';
		if($Orden){	
			foreach($Orden as $Llave=>$Valor)
				if($Valor!='')
					$orderBy = ' ORDER BY '.$Llave.' '.$Valor;
		}
		else{
			$orderBy = ' ORDER BY Curso ASC';
		}
		
		
		$Consulta = 'SELECT * FROM cursos_online C
					JOIN site_web SW ON SW.`IdCursoOnline` = C.Id
		'.$Where.$Wherec.$orderBy;
		return $rec=$this->Consulta($Consulta);
	}
	
	#Funcion que trae los cursos comprados por el usuario
	#En la consulta trae el estado de cada curso.
	#Si idCurso no es false, lo trae por curso
	function getMisCursos($idUsuario,$idCurso=false){
		
		$Where = ($idCurso) ? ' AND MC.IdCurso = '.$idCurso : '';
		
		$Consulta = 'SELECT 
						CO.*,
						MC.Intentos,
						MC.Id AS IdCc,
						MC.Estado,
						MC.FechaAprobado,
						MC.CodigoAprobado
						FROM `ventafactura` V
						JOIN `mis_cursos` MC ON MC.`IdCompra` = V.`IdVentaFactura`
						JOIN `cursos_online` CO ON CO.`Id` = MC.`IdCurso`
						WHERE V.`IdUsuario` = '.$idUsuario.$Where;
		return $rec=$this->Consulta($Consulta);
	}	
	
	
	/**function GetCursosOnCarro(){
		$j=0;
		echo $j;
	}
	
	
	*Para carro de compras, 
	* @param idCompras, recibe arreglo con los id elegidos 
	*/
	function GetCursosOnCarro($idCompras,$Posicion){
		
		
		$Where = (count($idCompras) == 1) ? "CO.`Id` = '".key($idCompras)."'" : 'CO.`Id` IN ('.implode(',',$idCompras).')';
		
		$rec=$this->SelSql("
						 CO.`Id` AS IdProducto,
						'N/A' AS Fecha,
						CO.`Curso` AS Fabricante,
						'N/A' AS Inicio,
						'N/A' AS Final,
						CO.`Curso` AS Nfabricante,
						CO.`Precio` AS precio,
						'1' AS Cantidad,
						'0' AS Descuento,
						'curso_online' AS tipo
						",
						'`cursos_online` CO'						
						,$Where. '');
		
		$contador = $Posicion; //($Posicion>0) ? $Posicion : 0;
		//$=0;

		while($ResultadoConsultaWhile = mysql_fetch_object($rec))
			{

				foreach($ResultadoConsultaWhile as $clave => $valor)
				
				{
					$ResultadoConsulta[$contador][$clave] = $valor;
				}

				$contador++;

			}
		return $ResultadoConsulta;
		
		
		
		
		
	}
	
	
	
	
	function getContenidoCursos($idCurso){
		
		$Consulta = 'SELECT 
						IdCursoOnline,Title,Content
						FROM `site_web` 
						
						WHERE `IdCursoOnline` = '.$idCurso;
		return $rec=$this->Consulta($Consulta);
	}	
	
	
	function EliminarCurso($Datos){
		
		#Consulta la tabla para saber que imagenes borrar
		$Imagenes = $this->GetCursos($Datos[IdCurso]);
		unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['Archivo1']);
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['Archivo2']); //Es posible que no exista Archivo2
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['Img']); //Es posible que no exista Archivo2
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgMiembro1']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgMiembro2']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgMiembro3']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgMiembro4']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgMiembro5']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgMiembro6']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgPatrocinador1']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgPatrocinador2']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgPatrocinador3']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgPatrocinador4']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgPatrocinador5']); //Es posible que no exista 
		@unlink('../../../ArchivosCursosOnline/'.$Imagenes[0]['ImgPatrocinador6']); //Es posible que no exista 
		
/*		$Tabla 		= 'cursos_online';
		$Where 		=  'Id = '.$Datos[IdCurso];
		$rec=$this->DelSql($Tabla,$Where); 
	*/	
		$Sql = "DELETE CO,EV,PE,RP FROM `evaluacion` EV 
		
		JOIN `cursos_online` CO ON EV.`IdCurso` = CO.`Id` 
		JOIN `preguntas_evaluacion` PE ON PE.`IdEvaluacion` = EV.`Id` 
		JOIN `respuestas_preguntas` RP ON RP.`IdPreguntaEvaluacion` = PE.`Id` 
		
		WHERE CO.`Id` = ".$Datos[IdCurso];
		$rec=$this->Query($Sql);
		
		
		#Elimina tambien en la tabla del administrador de contenidos
		$rec=$this->DelSql('site_web','IdCursoOnline = '.$Datos[IdCurso]);
		
	}	
	
	
	
	/**
	 * Producto::SubirImagen()
	 * 
	 * @return
	 */
	function SubirImagen($Imagen,$Vueltas='15')
	{
		//print_r($Imagen);
		for($i=0; $i<=$Vueltas; $i++)
		{
			if($Imagen['Archivo']['name'][$i] !='')
			{
				$origen 			= $Imagen['Archivo']['tmp_name'][$i];
				$nombreImagen 		= $Imagen['Archivo']['name'][$i];
				$nombreImagen 		= strstr($nombreImagen,'.');
				$retornaImagen[$i] 	= date(yis).rand(123,999).$nombreImagen;
				$destino 			= '../../../ArchivosCursosOnline/'.$retornaImagen[$i];
				
				move_uploaded_file($origen, $destino);		
			}
			else $retornaImagen[$i] = '';
		}
		return $retornaImagen;
	}	
	
	
	
	/*****################EVALUACIÓN###################EVALUACIÓN###################EVALUACIÓN#######*/
	
	
	function CrearEvaluacionCompleta($idEvaluacion=false){
		
		
		(($idEvaluacion)) ? $this->IdEvaluacion = $idEvaluacion : $this->CreaEvaluacion();
		
		/*INSERTA PREGUNTAS DE LA EVALUACION*/
		$this->CreaPreguntaEvaluacion();		
		

		return 'La evaluacion se ha creado de forma satifactoria';
	}
	
	function CreaEvaluacion(){
		
		
		/**
		INSERTA LA EVALUACION*/
		$Tabla = 'evaluacion';
		$Campos = '`IdCurso`,  `Descripcion`';
		$Valores = "'".$this->DatosIns['Curso']."',  '".$this->DatosIns['Descripcion']."'";
		$this->IdEvaluacion = $rec=$this->InsertSql($Tabla,$Campos ,$Valores); 
	}
	
	function CreaPreguntaEvaluacion(){
		/*INSERTA LA EVALUACION*/
		$Tabla = 'preguntas_evaluacion';
		$Campos = '`IdEvaluacion`,  `Descripcion`';
				
		foreach($this->DatosIns['Pregunta'] as $Key => $Pregunta){
			
			$Valores = "'".$this->IdEvaluacion."',  '".$Pregunta."'";
			$IdPreguntaEvaluacion = $rec=$this->InsertSql($Tabla,$Campos ,$Valores);
			
			/*
			Ahora inserta las respuestas de cada pregunta, las saca del value
			*/
			$OptCorrecta = $this->DatosIns['OpcionCorrecta'][$Key][0];
			for($i=0; $i< count($this->DatosIns['Respuesta'][$Key]); $i++){	
				
				//Opcion correcta
				$Correcto = ($OptCorrecta == $i) ? 1 : 0;
				
				
				$CamposRespuestas 	= 'IdPreguntaEvaluacion,Descripcion,Correcta';
				$ValoresRespuestas 	= "'".$IdPreguntaEvaluacion."','".$this->DatosIns['Respuesta'][$Key][$i]."','".$Correcto."'";
				$rec=$this->InsertSql('respuestas_preguntas',$CamposRespuestas ,$ValoresRespuestas);
			}

			
		}
		
		
	}
	
	function getEvaluacionesCursos($idCurso=false){
		
		if($idCurso)
			$Where = 'WHERE  CO.`Id` = '.$idCurso;
		
		$Consulta = 'SELECT 
						EV.`Descripcion` nombreEvaluacion,
						EV.Id
						FROM  `evaluacion` EV
						JOIN `cursos_online` CO ON EV.`IdCurso` = CO.`Id`
						'.$Where;
						
		
		return $rec=$this->Consulta($Consulta);
	}
	
	
	function getEvaluacion($idEvaluacion){
		
		$Consulta = 'SELECT 
						CO.`Descripcion` nombreCurso,
						EV.`Descripcion` nombreEvaluacion,
						PE.`Descripcion` nombrePregunta,
						RP.`Descripcion` Pregunta,
						RP.`Correcta`,
						RP.`IdPreguntaEvaluacion` Ids,
						RP.Id IdRespuestas
						FROM `evaluacion` EV
						JOIN `cursos_online` CO ON EV.`IdCurso` = CO.`Id`
						JOIN `preguntas_evaluacion` PE ON PE.`IdEvaluacion` = EV.`Id`
						JOIN `respuestas_preguntas` RP ON RP.`IdPreguntaEvaluacion` = PE.`Id`
						WHERE EV.`Id` = '.$idEvaluacion;
		
		return $rec=$this->Consulta($Consulta);				
	}
	
	
	function miEvaluacion($idCurso){
		
		$Consulta = 'SELECT 
						CO.`Curso` nombreCurso,
						EV.`Descripcion` nombreEvaluacion,
						PE.`Descripcion` nombrePregunta,
						RP.`Descripcion` Pregunta,
						MC.Intentos,
						RP.`Correcta`,
						RP.`IdPreguntaEvaluacion` Ids
						FROM `mis_cursos` MC 
						JOIN `cursos_online` CO ON CO.`Id` = MC.`IdCurso`
						JOIN `evaluacion` EV ON EV.`IdCurso` = CO.`Id`
						JOIN `preguntas_evaluacion` PE ON PE.`IdEvaluacion` = EV.`Id`
						JOIN `respuestas_preguntas` RP ON RP.`IdPreguntaEvaluacion` = PE.`Id`
						WHERE CO.`Id` = '.$idCurso;
		
		return $rec=$this->Consulta($Consulta);				
	}
	
	function compruebaResultado($Datos){
		
		if(array_sum($Datos['Respuesta']) < round(count($Datos['Respuesta'])*70/100)){
			$Resp = array_sum($Datos['Respuesta']);
			$this->Intentos = $this->Intentos+1;
			$Msg = 'El examen no fue aprobado, respuestas acertadas '.$Resp.'; Recuerde que tiene maximo 3 intentos, intentos realizados '.$this->Intentos;
			$this->ActualizaResultado(2);
			return $Msg;
		}
		else{
			$Msg =  'Felicitaciones su examen ha sido aprobado, clic en cerrar y ahora podra generar su diploma';
			$this->ActualizaResultado(1);
			return $Msg;
			}
	}
	
	function ActualizaResultado($Estado){
		
		if($Estado == 2 && $this->Intentos > 2)
			$Est = " ,`Estado` = '".$Estado."'";
		elseif($Estado==1)
			$Est = " ,`Estado` = 1, FechaAprobado = NOW(), CodigoAprobado = '".strtoupper(dechex(time()))."'";
		$Sql = 'UPDATE  `mis_cursos` MC 
				  JOIN `ventafactura` V ON MC.`IdCompra` = V.`IdVentaFactura`
				  SET MC.Intentos = '.$this->Intentos.'
				  WHERE V.`IdUsuario` = '.$this->idUsuario.' AND MC.`IdCurso` = '.$this->idMiCurso;
		
		/*$Tabla 		= 'mis_cursos';
		$Set 		= "`Intentos` = '".$this->Intentos."' ".$Est;
		$Where 		=  'Id = '.$this->idMiCurso;*/
		$rec=$this->Query($Sql);
		//$rec=$this->ActSql($Tabla,$Set,$Where,1); 
		
	}
	
	function EliminaPregunta($idPregunta){
			$rec=$this->DelSql('respuestas_preguntas','Id = '.$idPregunta); 
			echo '<script>alert("La respuesta ha sido eliminada de esta pregunta.")</script>';
	}
		
	function EditarPregunta($idPregunta,$Datos){
		
		$Tabla 		= 'respuestas_preguntas';
		
		
		#Si actualiza la pregunta a uno (Correta) Entones las pone todas en cero para que no quede mas de una con esta opcion
			($Datos['Correcta'] == 1) ? $rec=$this->ActSql($Tabla,'Correcta = 0','IdPreguntaEvaluacion = '.$Datos['idPregunta']) :'';	
		
		#Actualiza los cambios del usuario
		$Set 		= "`Descripcion` = '".$Datos['Respuesta']."', Correcta = ".$Datos['Correcta'];
		$Where 		=  'Id = '.$idPregunta;
		$rec=$this->ActSql($Tabla,$Set,$Where);
		echo '<script>alert("Los cambios se han guardado con &eacute;xito.")</script>';
	}	
	
	function EliminaGrupo($idGrupo){
		
		$rec=$this->DelSql('preguntas_evaluacion','Id = '.$idGrupo); 
		$rec=$this->DelSql('respuestas_preguntas','IdPreguntaEvaluacion = '.$idGrupo); 
		
		echo '<script>alert("La pregunta ha sido eliminada junto a sus opciones de respuesta")</script>';
	}
	
	function EliminaEvaluacion($idEvaluacion){
		
		/*$rec=$this->DelSql('preguntas_evaluacion','Id = '.$idGrupo); 
		$rec=$this->DelSql('respuestas_preguntas','IdPreguntaEvaluacion = '.$idGrupo); 
		$rec=$this->DelSql('respuestas_preguntas','IdPreguntaEvaluacion = '.$idGrupo); */
		$Sql = "DELETE EV,PE,RP FROM `evaluacion` EV 
				
				JOIN `cursos_online` CO ON EV.`IdCurso` = CO.`Id` 
				JOIN `preguntas_evaluacion` PE ON PE.`IdEvaluacion` = EV.`Id` 
				JOIN `respuestas_preguntas` RP ON RP.`IdPreguntaEvaluacion` = PE.`Id` 
				
				WHERE EV.`Id` = ".idEvaluacion;
		$rec=$this->Query($Sql);
		/*echo '<script>alert("El grupo ha sido eliminado completamente")</script>';*/
        return 'El grupo ha sido eliminado completamente';
	}	
	
	function getCategorias($Idc=false){
		
		if($Idc)
			$Where = 'WHERE CC.`Id` = '.$Idc;
			
		$Consulta = 'SELECT * FROM	categoria_cursos CC '.$Where ;
		return $rec=$this->Consulta($Consulta);	
	}
	
	function crearCategoria($Datos){
		
		$Tabla = 'categoria_cursos';
		$Campos = '`Descripcion`, `Activo`';
		$Valores = "'".$Datos['Categoria']."',1";
		$rec=$this->InsertSql($Tabla,$Campos ,$Valores); 
	}
	
	function editarCategoria($Datos){
		
		$Tabla 		= 'categoria_cursos';
		$Set 		= "`Descripcion` = '".$Datos['Categoria']."'";
		$Where 		=  'Id = '.$Datos['idCategoria'];
		$rec=$this->ActSql($Tabla,$Set,$Where); 
	}	
	function eliminarCategoria($Datos){
		
		//echo 'Si la quiere eliminar';
		$Tabla = 'categoria_cursos';
		$Where =  'Id = '.$Datos['idCategoria'];
		$rec=$this->DelSql($Tabla,$Where);
	}		
}
?>