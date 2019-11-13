<?
class sql{

	var $error;
	var $ok;
	var $selector;
	var $resultado;
    var $mysqli;
	
    
    /**
     * sql::sql()
     * 
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $db
     * @return
     */
     function sql($host = 'localhost', $user = 'root', $pass = '', $db = 'dna_online'){ 
     //function sql($host = 'localhost', $user = 'root', $pass = '', $db = 'cursos_dna'){
        $this->mysqli  = new mysqli($host, $user, $pass,$db);
        if($this->mysqli->errno)
            echo 'Error numero: '. $this->mysqli->errno.' <hr> Verificar:'.$this->mysqli->error.'<hr>';
    }    
    
	/**
	 * sql::InsertSql()
	 * 
	 * @param mixed $Tabla
	 * @param mixed $Campos
	 * @param mixed $Valores
	 * @param string $error
	 * @return
	 */
	function InsertSql($Tabla,$Campos,$Valores,$error="")
	{
		if($error=="")
		{
			$error="<B>Error ".mysql_errno()." :</B> ".mysql_error()."";
		}
		
		$query = "INSERT INTO " . $Tabla ."(" . $Campos. ") VALUES (". $Valores. ")";
		
		$req = mysql_query($query);
		
		if($error==1)
		{
			echo "<hr> " . $query . " <hr>";
		}	
		if (!$req){
		  echo $query."<hr><B>Error ".mysql_errno()." :</B> ".mysql_error()."";
        }
		
		
			return $last_insert_id = mysql_insert_id();
		
	}
	
	
/*	public function ControlError($Error, $Tabla = '')
	{
			
			switch($Error)
			{$this->IdConexion
				case "1062":
				
					$ShowError .= " <br> Se encontraron uno o más usuarios repetidos por favor verifique el archivo. <B><br> ".$Tabla. mysql_error(). "</B> <br>";
				
				break;

				case "1136":
				
					$ShowError .= " <br> El Numero de campos no es igual al numero de valores, <B> ".$Tabla."</B> <br>";
				
				break;
			}			
			
	return  $ShowError;
	
	}
	*/
	/**
	 * sql::SelSql()
	 * 
	 * @param mixed $Campos
	 * @param mixed $Tabla
	 * @param mixed $Condicion
	 * @param string $error
	 * @return
	 */
	function SelSql($Campos,$Tabla,$Condicion,$error="")
	{
		$query = "SELECT ". $Campos ." FROM ". $Tabla ." WHERE ".$Condicion;
		
		$req   = $mysqli->query($query); //mysql_query($query);
		
		if($error==1)
		{
			echo "<hr> " . $query . " <hr>";
		}

		if (!$req)
		{
			echo "<B>Error ".mysql_errno()." :</B> ".mysql_error()."<br><hr>".$query;
			exit; 
		}
	   	$res = mysql_num_rows($req);
	
	    if ($res == 0)
	   	{ 
	   		echo $error; return $req; 
		}
	    else
		{
			return $req;
		}
	}
	
	
	/**
	 * sql::DelSql()
	 * 
	 * @param mixed $Tabla
	 * @param mixed $Condicion
	 * @param string $error
	 * @return
	 */
	function DelSql($Tabla,$Condicion,$error="")
	{
		$query = "DELETE FROM ".$Tabla ." WHERE ".$Condicion;
		$req = mysql_query($query);
		
		if($error==1)
				{
				echo "<hr> " . $query . " <hr>";
				}
		
		if (!$req)
		{ echo "<B>Error ".mysql_errno()." :</B> ".mysql_error()."";
		exit; }
	
	}
	
	
	/**
	 * sql::ActSql()
	 * 
	 * @param mixed $Tabla
	 * @param mixed $Parametros
	 * @param mixed $Condicion
	 * @param string $error
	 * @return
	 */
	function ActSql($Tabla,$Parametros,$Condicion,$error="")
	{
		$query = "UPDATE ".$Tabla." SET ".$Parametros." WHERE ".$Condicion;
		//echo "<br><hr>";
		if($error=="")
		{
			$error="<B>Error ".mysql_errno()." :</B> ".mysql_error()."";
		}
		
		if($error==1)
		{
			echo "<br><hr> " . $query . " <hr>";
		}
		
		$req = mysql_query($query);
		
		if (!$req)
		{
			 echo "<B>Error ".mysql_errno()." :</B> ".mysql_error().""; return $req; 
		}
	}
	
	
	/**
	 * sql::Query()
	 * 
	 * @param mixed $query
	 * @return
	 */
	function Query($query)
	{
		$this->mysqli->query($query);
        /*$link = mysqli_query($query);
		if($link){
			return $link;
		}
		else{
			echo "Error en la sintaxis --> .".mysql_error();
		}*/
	}
	/**
	 * sql::QuerySql()
     * @param $query Pl sql con las instrucccion a ejecutar
     * @param $motrar, imprime la consulta enviada en caso de true 
     * @return  insert_id
	 * @param mixed $query
	 * @param bool $mostrar
	 * @return
	 */
	public function QuerySql($query, $mostrar=false)
	{
		
        if($mostrar){
            echo '<pre>';
                echo $mostrar;
            echo '</pre>';
        }
		$this->mysqli->query($query);
        if($this->mysqli->errno)
            echo 'Error numero: '. $this->mysqli->errno.' <hr> Verificar:'.$this->mysqli->error.'<hr> Consulta:'. $query. ' <hr>';
        return $this->mysqli->insert_id;
	}
	
	
	/**
	 * sql::Consulta()
	 * 
	 * @param mixed $Consulta
	 * @param string $showQuery
     * @author Javier Ardila
	 * @return
	 */
	public function Consulta($Consulta,$showQuery = false){
	   //if($showQuery)
//            imprimir($Consulta);
        $result = $this->mysqli->query($Consulta); 
        $counter = 0;
        $r = array();
        if($this->mysqli->errno)
            echo 'Error en db numero: '. $this->mysqli->errno.' <hr> Verificar:'.$this->mysqli->error.'<hr> Consulta:'. $Consulta. ' <hr>';
            
        while($data = mysqli_fetch_assoc($result)) {
				foreach($data as $field=>$value)
 				$r[$counter][$field] = $value;
				$counter ++;
			}
		
		
		return $r;
	}	

	
	
	////////////////////////////////////////////////////////////
	/**
	 * sql::Make_Table()
	 * 
	 * @param mixed $IdTabla
	 * @param mixed $CampoNuevo
	 * @return
	 */
	function Make_Table($IdTabla,$CampoNuevo)
	{
		$query = "CREATE TABLE `Frm_$IdTabla` (
		  `id` int(11) NOT NULL auto_increment,
		  $CampoNuevo
		  
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM";
		$req = mysql_query($query);
		if (!$req)
		{ 
			echo "$error"; 
			return exit;
		}
	} // Fin Crear Tabla
	///////////////////////////////////
	
	
	
	/////////////////////////////////////////
	/**
	 * sql::eliminar_Tabla()
	 * 
	 * @param mixed $Tabla
	 * @return
	 */
	function eliminar_Tabla ($Tabla)
	{
		$query = "DROP TABLE $Tabla";
		$req = mysql_query($query);
		if (!$req)
		{
			echo "<B>Error ".mysql_errno()." :</B> ".mysql_error()."";
		}
	} // Fin Eliminar Tabla
}
?>