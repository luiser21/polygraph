<?
if($_GET['kill'])

{
	session_name("loginUsuario");
	session_start();

	session_destroy();

}

$Caso = ($_SESSION['Registrado'] == 'si') ? 'si' : 'no';
//echo 'SESSION====>'; print_r($_SESSION);
if(isset($_POST['Usuarioc']))

{
	session_name("loginUsuario");
	session_start();

	include './appcfg/cc.php';

	include './appcfg/sql.php';

	include './clases/ClassCarro.php';

	include './clases/ClassUsuariosRegistros.php';



	$NuevoUs 		= new Usuarios;

	//$OBcontenido 	= new Admincont;

	$inicio = $NuevoUs->VerificaUsuario($_POST);

	if(empty($inicio))

	{

		$Caso = 'incorrecto';

		$_SESSION['Registrado'] = 'incorrecto';

	}

	#@Declara variable que el usuario si fue registrado

	#@ Guarda nombre en session

	#@Guarda Id en session

	else 

	{

		$Caso = 'si';

		$_SESSION['Registrado'] = 'si';

		$_SESSION['Nombre'] = $inicio['nombre']. ' '.$inicio['apellido'];

		$_SESSION['IdC'] = $inicio['IdCliente'];
		$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s"); 
		
		 
		
		$Sql = new sql;

		$sql = $Sql->ActSql('`clientes`','`activo` = 1',"`IdCliente` = '".$inicio['IdCliente']."'");

		

	}

}

if($_POST['confirmar'] == 'si')

{

		if($Caso == 'si')

		{

			$Caso = 'Siconf';

		}

		else

		{

			$Caso = 'Noconf';

		}

}

switch($Caso)

{

case 'no':
?>

  <form id="form2" name="form2" method="post" action="">
    <table width="200" border="0" cellspacing="1">
      <tr>
        <td width="79">Usuario:</td>
        <td width="105">
        <input name="Usuarioc" type="text" id="Usuarioc" size="15" /></td>
      </tr>
      <tr>
        <td>Contraseña:</td>
        <td><input name="clave" type="password" id="textfield" size="15" /></td>
      </tr>
      <tr>
        <td colspan="2" class="oldido"><a href="opcionescuenta.php?Opcion=1" class="oldido" title="Olvido su contraseña" onclick="Modalbox.show(this.href, {title: this.title, width: 600}); return false;">¿Olvidó su contraseña?</a></td>
      </tr>
    </table>
    <div id="ingreso">
    	<a href="shopping_car.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image11','','img/btn_on_01.png',1)">
   	<br />
   	<br />
   	<img src="img/btn_01.png" name="Image11" width="193" height="20" border="0" id="Image11" /></a><a href="registro.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image10','','img/btn_on_02.png',1)"><img src="img/btn_02.png" name="Image10" width="113" height="20" border="0" id="Image10" /></a><button style="background-color:transparent; border-width:0px;" name="irCuenta" type="button" onclick="EnviaPost('usuario','Cuenta.php',this.form)" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image12','','img/btn_on_03.png',1)"><img src="img/btn_03.png" name="Image12" width="91" height="20" border="0" id="Image12" /></button>
 
 </div>
  </form>



<?

break;

case 'si':

?>

  <form id="form1" name="form1" method="post" action="">
    <table width="200" border="0" cellspacing="1">
      <tr>
        <th align="center" valign="middle"><?=$_SESSION['Nombre']?></th>
      </tr>
      
      <tr>
        <td colspan="2" align="center" class="oldido"><a href="#" class="oldido" onclick="EnviaLink('usuario','Cuenta.php?kill=1')">Cerrar Sesión</a></td>
      </tr>
      
      
      <tr>
        <td align="center" class="oldido"><a href="opcionescuenta.php?Opcion=2" class="oldido" title="Cambiar Contraseña" onClick="Modalbox.show(this.href, {title: this.title, width: 600}); return false;">Cambiar contraseña</a></td>
      </tr>
      <tr>
        <td align="center" class="oldido"><a href="opcionescuenta.php?Opcion=3" class="oldido" title="Editar perfil" onClick="Modalbox.show(this.href, {title: this.title, width: 600}); return false;">Editar perfil</a></td>
      </tr>
        <tr>
        <td align="center" class="oldido"><a href="micuenta.php" class="oldido" title="Mi cuenta">Mi cuenta</a></td>
        </tr>

    </table>
    <br />
  <div id="ingreso"><a href="shopping_car.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image11','','img/btn_on_01.png',1)"><img src="img/btn_01.png" name="Image11" width="193" height="20" border="0" id="Image11" /></a><a href="registro.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image10','','img/btn_on_02.png',1)"><img src="img/btn_02.png" name="Image10" width="113" height="20" border="0" id="Image10" /></a><button style="background-color:transparent; border-width:0px;" name="irCuenta" type="button" onclick="EnviaPost('usuario','Cuenta.php',this.form)" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image12','','img/btn_on_03.png',1)"><img src="img/btn_03.png" name="Image12" width="91" height="20" border="0" id="Image12" /></button>
 
 </div>
  </form>
  
<?

break;

case 'incorrecto':

?>
  
    <form id="form1" name="form1" method="post" action="">
      <table width="200" border="0" cellspacing="1">
        <tr>
          <td colspan="2" align="center">Usuario y/o contraseña incorrecto</td>
        </tr>
        <tr>
          <td width="79">Usuario</td>
          <td width="105"><input name="Usuarioc" type="text" id="Usuarioc" size="15" /></td>
        </tr>
        <tr>
          <td>Contraseña:</td>
          <td><input name="clave" type="password" id="textfield4" size="15" /></td>
        </tr>
        <tr>
          <td colspan="2" class="oldido"><a href="opcionescuenta.php?Opcion=1" class="oldido" title="Olvido su contraseña" onclick="Modalbox.show(this.href, {title: this.title, width: 600}); return false;">¿Olvidó su contraseña?</a></td>
        </tr>
      </table>
      <div id="ingreso"><a href="shopping_car.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image11','','img/btn_on_01.png',1)"><br />
      <img src="img/btn_01.png" name="Image11" width="193" height="20" border="0" id="Image11" /></a><a href="registro.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image10','','img/btn_on_02.png',1)"><img src="img/btn_02.png" name="Image10" width="113" height="20" border="0" id="Image10" /></a><button style="background-color:transparent; border-width:0px;" name="irCuenta" type="button" onclick="EnviaPost('usuario','Cuenta.php',this.form)" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image12','','img/btn_on_03.png',1)"><img src="img/btn_03.png" name="Image12" width="91" height="20" border="0" id="Image12" /></button>
 
 </div>
    </form>
<?
break;
}
?>
  
  
 
 