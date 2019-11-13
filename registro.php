<?
session_name("loginUsuario");
session_start();
include './appcfg/cc.php';
include './appcfg/sql.php';
include './clases/ClassAdmin.php';
include './clases/ClassCarro.php';
include './clases/ClassProducto.php';
include './clases/ClassUsuariosRegistros.php';




$OBcontenido = new Admincont;
$OBcarro 	= new Admin;
$OBproducto = new  Producto;
$NuevoUs 		= new Usuarios;

$ProductoDestacado = $OBproducto->ListarProductoDestacado(); //Esta funcion se usa en el include 'CursosAbiertos'


$Contenido =$OBcontenido->MuestraContenido(4);

$Fabricantes=$OBcarro->ListarFabricante();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Keywords" content="Ahorro de Energía, Protección del Medio Ambiente, Manejo de Aguas, Aire Limpio, Mejorar la Calidad de Vida, Construcción Sostenible, Eficiencia Energética, Energías Alternativas, Materiales Reciclables, Calentamiento Globlal, Ahorro de Energía, Protección del Medio Ambiente, Manejo de Aguas, Aire Limpio, Mejorar la Calidad de Vida, Construcción Sostenible, Eficiencia Energética, Energías Alternativas, Materiales  Reciclables, Calentamiento Globlal, open, ingenieria, cursos, diplomados" >
<meta http-equiv="expires" content="-1" >
<meta http-equiv="Pragma" content="no-cache" >
<meta http-equiv="Window-target" content="_top" >
<meta name="Description" content="Empresa dedicada a la formación técnica, específicamente en temas de electricidad, comunicaciones, energías alternativas, edificios inteligentes, edificios verdes y seguridad eléctrica, con cursos, seminarios y eventos. Adicionalmente, toda la normatividad nacional e internacional, relacionada con estos temas." >

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Open Ingeniería  © 2011</title>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<link href="css/texto.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="./img/xfade2_o.css">
<script type="text/javascript" src="./img/xfade2.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<!--<script type="text/javascript" src="js/lightbox.js"></script>-->
<!--<script type="text/javascript" src="js/modalbox.js"></script>-->
<script type="text/javascript" src="js/livevalidation_prototype.js"></script>
<script type="text/javascript" src="./appcfg/AjaxLibrary/Funciones.js"></script>
<script language="javascript" type="text/javascript" src="./appcfg/AjaxLibrary/Funciones.js"></script>

<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/modalbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/liveValidation.css" type="text/css" media="screen" />
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:365px;
	height:96px;
	z-index:1;
}
/*
.LV_validation_message{
    font-weight:bold;
    margin:0 0 0 5px;
}
.LV_validation_message{
    font-weight:bold;
    margin:0 0 0 5px;
}

.LV_valid {
    color:#00CC00;
}
	
.LV_invalid {
    color:#CC0000;
}
    
.LV_valid_field{
input.LV_valid_field:hover, 
input.LV_valid_field:active,
textarea.LV_valid_field:hover, 
textarea.LV_valid_field:active 
    border: 1px solid #00CC00;
}
    
.LV_invalid_field{ 
input.LV_invalid_field:hover, 
input.LV_invalid_field:active,
textarea.LV_invalid_field:hover, 
textarea.LV_invalid_field:active ,
    border: 1px solid #CC0000;
}
*/
-->
</style>
<script type="text/javascript">


function ValidarCampos(){
		if(document.getElementById('nombre').value == ''){
			alert('El campo nombre es obligatorio');
			return false;
		}
		
	}


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

<body onload="MM_preloadImages('img/btn_on_01.png','img/btn_on_02.png','img/btn_on_03.png','img/menu/menu_off_02.png','img/menu/menu_off_03.png','img/menu/menu_off_04.png','img/menu/menu_off_05.png','img/menu/menu_off_06.png')">

<div id="contenedor">
	<div id="pata"><table width="1024" border="0">
  <tr>
    <td width="507" height="33" rowspan="2">www.openingenieria.com / Todos los Derecos Reservados 2011 ©</td>
    <td width="82" rowspan="2">&nbsp;</td>
    <td width="47" rowspan="2">&nbsp;</td>
    <td width="370"><div id="apDiv1"><img src="img/logos.png" width="365" height="96" border="0" usemap="#Map" /></div></td>
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
 <div id="botones"><? include('menu.php'); ?></div>
 <div id="item_destacados"><img src="img/cursos_abiertos.png" width="155" height="29" /></div>
  
<div id="contenido">
<?
if(isset($_POST[Enviar])){
	$NuevoUs->RegistraUsuarios($_POST);
	echo '<div align="center" class="etiquetas_formulario">Gracias por su registro, se ha enviado un correo electronico a su cuenta para con  sus datos </div>';
}
else {
?>
  <form id="form1" name="form1" method="post" action="" onsubmit="return false();">
    <p><span class="titulo">REGISTRO DE USUARIO </span><br />
    </p>
    <table width="600px" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td height="23" colspan="8" bgcolor="#F3F3F3" class="etiquetas_formulario"><span class="sub_titulo">Información personal</span>:</td>
      </tr>
      <tr>
        <td height="14" colspan="8" class="etiquetas_formulario"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr>
        <td height="23" colspan="2" class="etiquetas_formulario"><span class="Estilo1">*</span> Nombres:</td>
        <td colspan="6" valign="middle">
        	<input name="nombre" type="text" id="nombre" />
        	<script>
			var nombre = new LiveValidation('nombre', {validMessage: ""});
nombre.add( Validate.Presence, {failureMessage: "Su nombre"} );
</script>
        </td>
        </tr>
      <tr>
        <td height="23" colspan="2" class="etiquetas_formulario"><span class="Estilo1">*</span> Apellidos:</td>
        <td colspan="6" valign="middle"><input name="apellido" type="text" id="apellido" />
                <script>
        			var direccion = new LiveValidation('apellido',{validMessage: ""});
					direccion.add( Validate.Presence ,{failureMessage: "Apellido"});
                </script>
        </td>
        </tr>
      <tr>
        <td height="23" colspan="2" class="etiquetas_formulario"><span class="Estilo1">*</span> <span class="Estilo1">E-mail:</span></td>
        <td colspan="6" valign="top"><input name="correo" type="text" id="correo" />
       
           <script>
            	var correo = new LiveValidation('correo', {validMessage: ""});
				correo.add( Validate.Email , {failureMessage: "Direccion de correo electronico para contacto"});
			</script>
          Este ser&aacute; su usuario </td>
      </tr>
      <tr>
        <td height="23" colspan="2" class="Estilo1">* Repetir email</td>
        <td colspan="6" valign="top"><input name="correo2" type="text" id="correo2" />
        <script>
        var correo2 = new LiveValidation('correo2', {validMessage: ""});
		correo2.add( Validate.Confirmation, { match: 'correo' , failureMessage: "Confirme su direccion de correo"});
</script>
        </td>
      </tr>
      <tr>
        <td height="23" colspan="2" valign="middle"><span class="Estilo1">* </span>Contrase&ntilde;a:</td>
        <td colspan="6" valign="top">
        	<input name="contrasena" type="password" id="contrasena" />
            	<script>
        			var contrasena = new LiveValidation('contrasena',{validMessage: ""});
					contrasena.add( Validate.Presence ,{failureMessage: "Escriba con la contraseña con la que usted ingresara al panel"});
                </script>
        </td>
        </tr>
      <tr>
        <td height="23" colspan="2" valign="middle" class="etiquetas_formulario">Tipo de documento:</td>
        <td colspan="6" valign="top"><input type="radio" name="radio" id="radio" value="radio" />
          <label for="radio"></label>
          CC. 
          · 
          <input type="radio" name="radio2" id="radio2" value="radio2" />
          <label for="radio2"></label>
          CE          </td>
        </tr>
      <tr>
        <td height="23" colspan="2" valign="middle" class="etiquetas_formulario">No. documento</td>
        <td colspan="6" valign="top">
        	<input name="documento" type="text" id="documento" />
                  
        </td>
        </tr>
      <tr>
        <td height="23" colspan="2" valign="middle" class="etiquetas_formulario"><span class="Estilo1">*</span> Pa&iacute;s:</td>
        <td colspan="6" valign="top">
        	<input name="pais" type="text" id="pais" />
                    <script>
        			var pais = new LiveValidation('pais',{validMessage: ""});
					pais.add( Validate.Presence ,{failureMessage: "Pais de vivienda"});
                </script>
        </td>
        </tr>
      <tr>
        <td height="23" colspan="2" valign="top" class="etiquetas_formulario"><span class="Estilo1">*</span> Ciudad:</td>
        <td colspan="6" valign="top">
        	<input name="ciudad" type="text" id="ciudad" />
                   <script>
        			var ciudad = new LiveValidation('ciudad',{validMessage: ""});
					ciudad.add( Validate.Presence ,{failureMessage: "Ciudad de vivienda"});
                </script>
         </td>
        </tr>
      <tr>
        <td height="23" colspan="2" valign="top" class="etiquetas_formulario"><span class="Estilo1">*</span> Tel&eacute;fono:</td>
        <td colspan="6">
        	<input name="telefono" type="text" id="telefono" />
                    <script>
        			var telefono = new LiveValidation('telefono',{validMessage: ""});
					telefono.add( Validate.Presence ,{failureMessage: "Su numero de contacto"});
                </script>
            </td>
        </tr>
      <tr>
        <td height="23" colspan="2" valign="top" class="etiquetas_formulario">Direcci&oacute;n:</td>
        <td colspan="6">
        	<input name="direccion" type="text" id="direccion" />
           
            </td>
        </tr>
      <tr>
        <td width="32" height="23" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td colspan="2" valign="top" class="etiquetas_formulario"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td width="53" valign="top" class="etiquetas_formulario"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td colspan="3" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td width="37">&nbsp;</td>
      </tr>
      <tr>
        <td height="1"></td>
        <td width="86"></td>
        <td width="72"></td>
        <td></td>
        <td width="55"></td>
        <td width="86"></td>
        <td width="179"></td>
        <td></td>
      </tr>
    </table>
    <table width="600px" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td height="23" colspan="3" valign="top" bgcolor="#F3F3F3" class="etiquetas_formulario"><span class="sub_titulo">Información empresarial: </span></td>
      </tr>
      <tr>
        <td height="14" colspan="3" valign="top" class="etiquetas_formulario"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr>
        <td height="23" colspan="2" valign="top" class="etiquetas_formulario">Raz&oacute;n social:</td>
        <td valign="middle"><input name="emp_razonsocial" type="text" id="emp_razonsocial" /></td>
        </tr>
      <tr>
        <td width="85" height="23" class="etiquetas_formulario">Tel&eacute;fono:</td>
        <td width="23" rowspan="4">&nbsp;</td>
        <td valign="middle"><input name="emp_telefono" type="text" id="emp_telefono" /></td>
        </tr>
      <tr>
        <td height="23" class="etiquetas_formulario">Direcci&oacute;n:</td>
        <td valign="top"><input name="emp_direccion" type="text" id="emp_direccion" /></td>
        </tr>
      <tr>
        <td height="23" class="etiquetas_formulario">E-mail:</td>
        <td valign="top"><input name="emp_correo" type="text" id="emp_correo" /></td>
        </tr>
      <tr>
        <td height="22" valign="middle" class="etiquetas_formulario">Nit:</td>
        <td valign="top"><input name="emp_nit" type="text" id="emp_nit" /></td>
        </tr>
      <tr>
        <td height="23" colspan="2" valign="middle" class="etiquetas_formulario">Persona contacto: </td>
        <td valign="top"><input name="emp_personacontacto" type="text" id="emp_personacontacto" /></td>
        </tr>
      <tr>
        <td height="23" valign="top" class="etiquetas_formulario">Sitio web:</td>
        <td>&nbsp;</td>
        <td valign="top"><input name="emp_sitioweb" type="text" id="emp_sitioweb" /></td>
        </tr>
      <tr>
        <td height="23" valign="top" class="etiquetas_formulario"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        </tr>
  </table>
    <table width="600" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td height="25" colspan="5" bgcolor="#F3F3F3"><span class="sub_titulo">Información adicional:</span></td>
      </tr>
      <tr>
        <td height="14" colspan="4"></td>
        <td width="88"></td>
      </tr>
      <tr>
        <td width="20" height="20" valign="top"><input name="Registro2" type="checkbox" id="Registro2" value="checkbox" /></td>
        <td colspan="3" valign="top" class="etiquetas_formulario"> Si, me gustar&iacute;a recibir m&aacute;s informaci&oacute;n de OPEN INGENIERÍA por correo electr&oacute;nico </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="14"></td>
        <td width="224"></td>
        <td width="194"></td>
        <td width="181"></td>
        <td></td>
      </tr>
      <tr>
        <td height="34" valign="top"><input name="Acepto" type="checkbox" id="Acepto" value="checkbox" /></td>
        <td colspan="3" rowspan="2" valign="top" class="etiquetas_formulario"><div align="justify">Acepto que mis datos personales sean procesados por OPEN INGENIERÍAconforme a su Pol&iacute;tica de Privacidad. Cuando se registre tambi&eacute;n crear&aacute; una identificaci&oacute;n de usuario personal y una contrase&ntilde;a. Mantenga la identificaci&oacute;n de usuario personal y la contrase&ntilde;a protegidas en todo momento y no las revele a nadie ya que usted es el &uacute;nico responsable de las compras que se realicen con su identificaci&oacute;n de usuario y contrase&ntilde;a. Tambi&eacute;n puede gestionar sus datos personales enel panel TU CUENTA </div></td>
        <td></td>
      </tr>
      <tr>
        <td height="50">&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td height="19">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
    </table>
    <p>
      <input type="submit" name="Enviar" id="Enviar" value="Enviar" />
    </p>
  </form>
  <p>&nbsp;</p>
  <?
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
