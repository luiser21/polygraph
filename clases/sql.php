<?
class sql{

	var $error = array('Codigo' => 0, "Mensaje" => 'Error en la aplicación');
	var $ok;
	var $selector;
	var $resultado;
    
    /**
     * crearHtml::idUsuario
     * @return Ultimo id del un insert.
     */    
    public $lastInsertId = false;     
    
    var $mysqli;
    /** Vector array para guardar los errores.*/
    var $debug;
	
    
    /**
     * sql::sql()
     * 
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $db
     * @return
     */
     function sql($host = 'localhost', $user = 'cartas_db', $pass = 'c0ntr4s3n42018*', $db = 'polygraph'){
     //function sql($host = 'localhost', $user = 'cartas_db', $pass = 'c0ntr4s3n42018*', $db = 'cartas_pintuco'){
        
         if(isset($_SESSION["bdatos"])){
             if($_SERVER['PHP_SELF']=='/carlub/usuarios.php' ||  $_SERVER['PHP_SELF']=='/carlub/parametros.php'){
                 $db= 'polygraph';                 
             }else{
                 $db=$_SESSION["bdatos"];
             }
        }
		//print_r($host);
		
        $this->mysqli  = new mysqli($host, $user, $pass,$db);
      //  print_r($this);exit;
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
        if($this->mysqli->errno){
        	if($this->mysqli->errno ==1062){
        		$error = array('Codigo' => 0, "Mensaje" => 'Error en la aplicación');
        		throw new Exception( 'Ya existe un registro con el valor <strong>' . strstr(strstr($this->mysqli->error,"'"), "for",1). '</strong>');	
        	}
        	throw new Exception('Error numero: '. $this->mysqli->errno.' <hr> Verificar:'.$this->mysqli->error.'<hr> Consulta:'. $query,99);
           // echo 'Error numero: '. $this->mysqli->errno.' <hr> Verificar:'.$this->mysqli->error.'<hr> Consulta:'. $query. ' <hr>';
            return false;
        }
        $this->lastInsertId = $this->mysqli->insert_id;
        
        return  (strpbrk($query, 'UPDATE')) ? $this->mysqli->affected_rows : $this->mysqli->insert_id;
        
	}
	
    
    /**
     * @actualización masiva de datos(actualmente sólo genera la sql)
     * @param $table Nombre de la tabla
     * @param $data Array(Campo => Valor)
     * @param $identificator Identificador por el que se hará la where
     */
     function updateMasivo($table = "", $data = array(), $identificator = ""){
         if($table === "")
            throw new Exception("Tabla es obligatoria", 99);
         if(!is_array($data))
            throw new Exception("Data debe ser un array()", 99);
         if(empty($data))
            throw new Exception("Data es vacio", 1);
         if($identificator === "")
            throw new Exception("Identificator no es valido", 99);
         if(!array_key_exists_r($identificator, $data))
            throw new Exception("No existe identificador para clausula Where", 99);
         
         $boolInt = true;
         
         //una forma de comprobar si el campo es de tipo entero
         //$query = mysql_query("SELECT {$identificator} from {$table} where {$identificator} REGEXP '^-?[0-9]+$';");
//         
//         $type = mysql_fetch_row($query);
//         
//         if($type[0] == 1)
        // $boolInt = TRUE;
         
         //empezamos la consulta
         $sql = "UPDATE $table SET ";
         
         //obtenemos las keys del array
         $keys = array_keys($data[0]);
         
         $i = 1;
         
         //array para los identificadores necesarios para hacer la WHERE IN
         $identificators = array();
         
         //recorremos las keys
         foreach($keys as $key){
            
            //si la key no es el identificador por el que hacemos la WHERE
            if($key != $identificator){
                $sql.="$key = CASE";
                
         
            foreach($data as $value){ 
                array_push($identificators, $value[$identificator]);
                if($key != $identificator){ 
                    $val = is_numeric($value[$identificator]) ? $value[$identificator] : "'".$value[$identificator]."'";
                    $sql.=" WHEN {$identificator} = {$val} THEN '{$value[$key]}' "; 
                }
            }  
             $sql.=" ELSE {$key}";
             $sql.=($i)===(count($keys)-1) ? " END" : " END,";
             $sql.="";
             $i++;
             }
         } 
         //si no es tipo entero preparamos la WHERE IN para string
         if($boolInt === FALSE)
         {
         $sql.=" WHERE {$identificator} IN (\"".implode('","', array_unique($identificators))."\")";
         }
         //en otro caso para enteros
         else
         {
         $sql.=" WHERE {$identificator} IN (".implode(",",array_unique($identificators)).")";
         }
         
         
         return $this->QuerySql($sql);
     }
 
 
 /**
 * //http://stackoverflow.com/questions/2948948/array-key-exists-is-not-working
 * @description comprueba si existe la key de forma recursiva
 * @param $needle
 * @param $haystack
 * @param $identificator Identificador por el que se hará la where
 */
 function array_key_exists_r($needle, $haystack)
 {
     $result = array_key_exists($needle, $haystack);
     if ($result) return $result;
     foreach ($haystack as $v) 
     {
         if (is_array($v)) 
         {
             $result = array_key_exists_r($needle, $v);
         }
         if ($result) return $result;
     }
     return $result;
 }    
	
	/**
	 * sql::Consulta()
	 * 
	 * @param mixed $Consulta
	 * @param string $showQuery
     * @author Javier Ardila
	 * @return array con resultado de la consulta
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
	public function Consulta2($Consulta,$showQuery = false){
	    //if($showQuery)
	        //            imprimir($Consulta);
	   
	    $query = '';
	    $sqlScript = file('cartas_inicio.sql');
	    foreach ($sqlScript as $line)   {
	        
	        $startWith = substr(trim($line), 0 ,2);
	        $endWith = substr(trim($line), -1 ,1);
	        
	        if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
	            continue;
	        }
	        
	        $query = $query . $line;
	        if ($endWith == ';') {
	            	$this->mysqli->query($query) or die('<div class="error-response sql-import-response">Problema con la ejecucion del SQL <b>' . $query. '</b></div>');
	            $query= '';
	        }
	    }	    
	    return '<div class="success-response sql-import-response">SQL file imported exitosamente..</div>';
	}
}
?>