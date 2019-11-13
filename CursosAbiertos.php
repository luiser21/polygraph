<? 
$Destacados =$OBcontenido->MuestraContenido(10); 
echo '<div align="center">';
		include('calendario.php'); 
echo '</div><hr />';

if($ProductoDestacado[0]['IdFabricante']!=''){
	foreach($ProductoDestacado as $DestacadosS){
		echo '<div id="cursos"><a  id="cursosAbiertos" href="interna_cursos.php?Idf='.$DestacadosS['IdFabricante'].'" >'.$Destacados['Fabricante'].' - '.$DestacadosS['Nombre'].' '.$DestacadosS['Descripcion'].'</a></div>';
	}
}
echo $Destacados['descripcion'];
?>

<div style="text-align:center"><hr />
  <img src="img/redes.png" width="70" height="23" border="0" usemap="#Map2" />
  <map name="Map2" id="Map2">
    <area shape="rect" coords="49,3,68,21" href="#" />
    <area shape="rect" coords="26,2,45,24" href="#" />
    <area shape="rect" coords="2,3,23,22" href="http://twitter.com/#!/Open_Ingenieria" target="_blank" />
  </map>
<hr />
<span class="direccion">OPEN INGENIER&IacuteA<br />
Carrera 3A No. 60 - 15<br />
Móvil: 3103073460<br />
info@openingenieria.com<br />
Bogot&aacute - Colombia </span></div>
