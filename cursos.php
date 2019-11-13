<?
session_name("loginUsuario");
session_start();
include './appcfg/cc.php';
include './appcfg/sql.php';
include './clases/ClassAdmin.php';
include './clases/ClassCarro.php';
include './clases/ClassProducto.php';

$OBcontenido = new Admincont;
$OBcarro 	= new Admin;
$OBproducto = new  Producto;

$ProductoDestacado = $OBproducto->ListarProductoDestacado(); //Esta funcion se usa en el include 'CursosAbiertos'


$Contenido =$OBcontenido->MuestraContenido(4);

$Fabricantes=$OBcarro->ListarFabricante();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Open Ingeniería  © 2011</title>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<link href="css/texto.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="./img/xfade2_o.css">
<script type="text/javascript" src="./img/xfade2.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript" src="js/modalbox.js"></script>
<script type="text/javascript" src="./appcfg/AjaxLibrary/Funciones.js"></script>
<script language="javascript" type="text/javascript" src="./appcfg/AjaxLibrary/Funciones.js"></script>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/modalbox.css" type="text/css" media="screen" />
<style type="text/css">
<!--
#apDiv1 {
	position: absolute;
	width: 408px;
	height: 96px;
	z-index: 1;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
-->
</style>
<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
</head>

<body onload="MM_preloadImages('img/btn_on_01.png','img/btn_on_02.png','img/btn_on_03.png','img/menu/menu_off_05.png')">

<div id="contenedor">
	<div id="pata"><table width="1024" border="0">
  <tr>
    <td width="507" height="33" rowspan="2">www.openingenieria.com / Todos los Derecos Reservados 2011 ©</td>
    <td width="82" rowspan="2">&nbsp;</td>
    <td width="47" rowspan="2">&nbsp;</td>
    <td width="370"><div id="apDiv1"><img src="img/logos.png" width="429" height="96" border="0" usemap="#Map" /></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table>
  </div>
	 
  <div id="banner">
  
  
  <div id="imageContainer">
		<img src="./img/img1.jpg" width="500" height="140" alt="Swimming Pool Water" style="display: block; opacity: 0.99; ">
		<img src="./img/img2.jpg" width="500" height="140" alt="Notebook" style="opacity: -0.010000000000000328; display: none; ">
		<img src="./img/img3.jpg" width="500" height="140" alt="Bottle Neck" style="opacity: -0.010000000000000328; display: none; ">
		<img src="./img/img4.jpg" width="500" height="140" alt="Nail in a Board" style="opacity: -0.010000000000000328; display: none; ">
		<img src="./img/img5.jpg" width="500" height="140" alt="Door Knob" style="opacity: -0.010000000000000328; display: none; ">
		<img src="./img/img6.jpg" width="500" height="140" alt="Basket in the Snow" style="opacity: -0.010000000000000328; display: none; ">
</div>
  </div>
  <div id="usuario">
<? include('Cuenta.php'); ?>
</div>
  <div id="linea"></div>
  <div id="buscar">
 <form name="FormBuscar" id="FormBuscar" method="post" action="ResultadosBusqueda.php">
<input name="Buscar" type="text" id="Buscar" size="30"  style="border:0px"/>
<!--<input type="submit" name="BuscarButton" value="BuscarButton" style="visibility:hidden" />-->

	<button type="submit" class="Botoninvisible">
    	<img src="img/buscar.png" alt="Buscar" width="15" height="24" border="0"/>
     </button>

</form>
</div>
<div id="botones">
<? include('menu.php'); ?>
  
  </div>
  
  
  <div id="item_destacados"><img src="img/destacados_img2.png" width="113" height="26" /></div>
  
<div id="contenido"><span class="titulo">CURSOS PRESENCIALES</span>
  <table width="200" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><a href="cursos.php"><img src="img/presenciales.jpg" alt="a" width="100" height="26" border="0" /></a></td>
      <td>&nbsp;</td>
      <td><a href="on-line.php"><img src="img/on-line.jpg" alt="s" width="100" height="26" border="0"/></a></td>
    </tr>
  </table>
  <p>Para más información sobre cada uno de los cursos, de click sobre los siguientes vinculos.</p>
  
  <?
  foreach($Fabricantes as $Categoria)
  {
	  echo '<div id="portafolio_cursos"> - <a href="interna_cursos.php?Idf='.$Categoria['IdFabricante'].'" id="portafolio_cursos">'.$Categoria['Fabricante'].'</a></div>';
  }
  ?>
    
  </div>

<div id="destacados">
<? include('CursosAbiertos.php'); ?>
</div>
<div id="shadow"><img src="img/shadow_2.png" width="750" height="50" /></div>

</div>

<map name="Map" id="Map">
  <area shape="rect" coords="21,9,73,70" href="#" />
  <area shape="rect" coords="78,9,153,69" href="#" />
  <area shape="rect" coords="158,9,294,69" href="#" />
  <area shape="rect" coords="299,9,349,70" href="#" />
</map>
</body>
</html>
