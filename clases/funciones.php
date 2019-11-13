<?

function Aletorio(){
	
	$Rango = range(0,5);
	shuffle($Rango);
	while (list(,$Aliatorio) = each($Rango)) {
		$ale .= $Aliatorio ;
		}
	return $ale;
	}

function SubirImagen($Imagen,$Destino='')
	{	
        $Ruta = './imagenes/';
		$origen = $Imagen['newImagen']['tmp_name'];
		$nombreImagen = $Imagen['newImagen']['name'];
		//$nombreImagen = strstr($nombreImagen,'.');
	//	$nombreImagen = date('yis').rand(123,999).$nombreImagen;
		$destino =$Ruta.$nombreImagen;
		$tipo = $Imagen['newImagen']['type'];

		$tamano = $Imagen['newImagen']['size'];
	    /**
         *Cambio para deas, cada que agrega la imagen le hace una redimendci&oacute;n para banner del index.
        */	
        
		if(copy($origen, $destino)){
		}

		return $nombreImagen;
	}

function resizeImage($filename, $max_width, $max_height)
{
    list($orig_width, $orig_height) = getimagesize($filename);

    $width = $orig_width;
    $height = $orig_height;

    # taller
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }

    # wider
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }

    $image_p = imagecreatetruecolor($width, $height);

    $image = imagecreatefromjpeg($filename);

    imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
                                     $width, $height, $orig_width, $orig_height);

    return $image_p;
}

    /**
     * imprimir()
     * realiza un print_r organizo en medio de etiquetas '<pre>'
     * @param $array Arreglo o string que desea ver
     * @param $texto El titulo que se mostrara en la impresion 
     * @return Array
     */    
function imprimir($array,$texto=false){
    
    echo '<hr>';
    if($texto) echo ' <b>'.$texto.'</b></hr>';
    
    echo '<pre>';
    print_r($array);
    echo '</pre>
            </hr>';    
}

    /**
     * serializeArray()
     * Decodifica objeto enviado desde javascript 
     * @param Object $a
     * @return Array
     */
 function serializeArray($a){
		$_array_return = array();
        $array_replace = array('['=>'',']'=>'');
		if( is_array($a) ){
			foreach($a as $c => $k){
				$_name = trim(strtolower($a[$c]['name']));
                $_value = trim($a[$c]['value']);
                $_pos = strpos($_name,'['); 
                if( $_pos !== false ){
                    $_cadena = strtr( substr($_name,$_pos) , $array_replace );
                    $_name = substr($_name,0,$_pos);
                    if( isset($_array_return[$_name][$_cadena])){					
    					if( is_array($_array_return[$_name][$_cadena]) )
    						$_array_return[$_name][$_cadena][$_value]=true;
    					else{
    						$_tmp = $_array_return[$_name][$_cadena];
    						$_array_return[$_name][$_cadena]=array($_tmp => true, $_value => true);
    					}
    				}
    				else
    					$_array_return[$_name][$_cadena] =  $_value;
                         
                }else{
    				if( isset($_array_return[$_name])){					
    					if( is_array($_array_return[$_name]) )
    						$_array_return[$_name][$_value]=true;
    					else{
    						$_tmp = $_array_return[$_name];
    						$_array_return[$_name]=array($_tmp => true, $_value => true);
    					}
    				}
    				else
    					$_array_return[$_name] =  $_value;   
                }
			}
		}		
		return $_array_return;
}

/**
 * array_key_exists_r()
 * Usa array_key_exists de forma recursiva. 
 * @param mixed $needle
 * @param mixed $haystack
 * @return
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

function keyToVal($a){
    $r= array();
    if(is_array($a) && count($a))
        foreach($a as $k=>$v)
            $r[] = $k;
    return $r;
}

    /**
     * in_multiarray()
     * Recursivo para busar en el array (in_array())
     * @param $elem Aguja
     * @param $array arreglo en donde se realizara la busqueda (pajar) 
     * @return Array
    */ 
function in_multiarray($elem, $array){
    $top = sizeof($array) - 1;
    $bottom = 0;
    while($bottom <= $top)
    {
        if($array[$bottom] == $elem)
            return true;
        else 
            if(is_array($array[$bottom]))
                if(in_multiarray($elem, ($array[$bottom])))
                    return true;
                
        $bottom++;
    }        
    return false;
}


function recursive_array_search($needle,$haystack) {
    if( is_array($haystack) ){
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
                return $current_key;
            }
        }
    }
    return false;
}

function multidimensional_search($searched, $parents) { 
  if (empty($searched) || empty($parents)) { 
    return false; 
  } 

  foreach ($parents as $key => $value) { 
    $exists = true; 
    foreach ($searched as $skey => $svalue) { 
      $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue); 
    } 
    if($exists){ return $key; } 
  } 

  return false; 
} 


/**
* @return integer
* @param var $needle
* @param array $haystack
* @desc Feed a sorted array to $haystack and a value to search for to $needle.
             It will return false if not found or the index where it was found.
             This function is superfast. Try an array with 50.000 elements and search for something,
             you will be amazed.
*/
function binsearch($needle, $haystack)
{
    $high = count($haystack);
    $low = 0;
    
    while ($high - $low > 1){
        $probe = ($high + $low) / 2;
        if ($haystack[$probe] < $needle){
            $low = $probe;
        }else{
            $high = $probe;
        }
    }

    if ($high == count($haystack) || $haystack[$high] != $needle) {
        return false;
    }else {
        return $high;
    }
}
?>
