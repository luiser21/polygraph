<?php
/**
 * Index
 * 
 * @package carLub
 * @author Eric Chitan
 * Clase dependientede Cargar Imagenes
 * @copyright 2017
 * @version 0.1
 * @access public
 */    

error_reporting(E_ALL);
ini_set("display_errors", 1);
include ('clases/includes.inc');

foreach($_POST as $key => $value)
{
    if(substr($key, 0, 6) === 'delete')
    {
        $code = substr($key,6);
        $delete = $_POST['delete' . $code];
 
        $sqlImage = mysqli_query($link,"select * from equipos_imagen where code= $code;") or die (mysqli_error());
        $image = mysqli_fetch_array($sqlImage);
        if($image != null)
        {
            if(file_exists(DIR_IMAGES . $image['file']))
                unlink(DIR_IMAGES . $image['file']);
        }
        
        mysqli_query($link,"delete from equipos_imagen where code=$code") or die (mysqli_error());
    }
}

foreach($_POST as $key => $value)
{
    if(substr($key, 0, 8) === 'ordering')
    {
        $code = substr($key,8);
        $ordering = $_POST['ordering' . $code];
        if(!is_numeric($ordering))
        {
            $ordering = 0;
        }
        
        mysqli_query($link,"update equipos_imagen set ordering=$ordering where code=$code") or die (mysqli_error());     
    }
	
    if(substr($key, 0, 4) === 'name')
    {
        $code = substr($key,4);
        $name = $_POST['name' . $code];      
        mysqli_query($link,"update equipos_imagen set name='" . mysqli_real_escape_string($link,$name) .  "' where code=$code") or die (mysqli_error());     
    }
    	
    if(substr($key, 0, 11) === 'description')
    {
        $code = substr($key,11);
        $description = $_POST['description' . $code];      
        mysqli_query($link,"update equipos_imagen set description='" . mysqli_real_escape_string($link,$description) .  "' where code=$code") or die (mysql_error());     
    }
}

foreach($_FILES as $key => $value)
{
    if($value['name'] != '' && ($value['type'] == 'image/jpeg' || $value['type'] == 'image/png' || $value['type'] == 'image/gif'))
    {
        $code = substr($key,5);
        $name = $_POST['name' . $code];
        $ordering = $_POST['ordering' . $code];
		$description = $_POST['description' . $code];
		
        if(!is_numeric($ordering))
        {
            $ordering = 0;
        }
     
        $sqlImage = mysqli_query($link,"select * from equipos_imagen where code= $code;") or die (mysql_error());
        $image = mysqli_fetch_array($sqlImage);

        $extension = '';
        switch($value['type'])
        {
            case 'image/jpeg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
            case 'image/gif':
                $extension = 'gif';
                break;
        }
                       
        if($image != null) // update
        {
            if(file_exists('../'.DIR_IMAGES . $image['file']))
                unlink('../'.DIR_IMAGES . $image['file']);
            
            mysqli_query($link,"update equipos_imagen set name='$name', ordering=$ordering, description='" . mysqli_real_escape_string($link,$description) . "', file='" . $code . '.' . $extension . "' where code=$code") or die (mysql_error());
        }
        else // insert
        {
            mysqli_query($link,"insert into equipos_imagen(code, name, ordering, description,file) values ($code, '$name', $ordering, '" . mysqli_real_escape_string($link,$description) . "','" . $code . '.' . $extension .  "')") or die (mysql_error());           
        }
                     
        move_uploaded_file($value['tmp_name'],'../'.DIR_IMAGES . $code . '.' . $extension);
        //chmod(DIR_IMAGES . $name, 755);
    }
}
?>
	<script>
		self.location="/carlub/cargar_imagenes.php";
	</script>