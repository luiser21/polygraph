<?php
session_start();
include('clases/sql.php');
include('clases/crearHtml.class.php');
$dbgestion = new crearHtml();
date_default_timezone_set('America/Bogota');
ini_set('memory_limit', '512M');
ini_set('upload_max_filesize', '10M');
//ini_set('max_execution_time', 6000);
setlocale(LC_ALL, 'es_ES.UTF-8');
$mostrar="";
//Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
if(!empty($_POST["id_equipos"])){
    
    foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista
        if($_FILES["archivo"]["name"][$key]) {
            
            $filename = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
            
            
            $directorio_empresa = $dbgestion->sacar_empresa();
            $directorio = $directorio_empresa.'/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
            
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");
            }
            $filename=str_replace(" ", '', $filename);
            $filename=str_replace("Ñ", '', $filename);
            $filename=str_replace("Ñ", 'N', $filename);
            $filename=str_replace("ñ", 'n', $filename);
            $filename=str_replace("-", '', $filename);
            $filename=str_replace("/", '', $filename);
            $filename=strtolower($filename);
            $dir=opendir($directorio); //Abrimos el directorio de destino
            $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
            
          
            //Movemos y validamos que el archivo se haya cargado correctamente
            //El primer campo es el origen y el segundo el destino
            if(move_uploaded_file($source, $target_path)) {
                $arrImagenes = $dbgestion->guardar_imagen('equipos_imagen',$_POST["id_equipos"],$filename,$directorio);
                $mostrar.= $arrImagenes;
                //echo "El archivo $filename se ha almacenado de forma exitosa.<br>";
            } else {
                $_respuesta = 'Ha ocurrido un error, por favor inténtelo de nuevo. Validar peso Imagen no puede sobrepasar 1Mb por imagen.<br>';
                $mostrar.= $_respuesta;
            }
            closedir($dir); //Cerramos el directorio de destino
        }
    }
    ?>
    <!doctype html>
    <html lang="es">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1"> 
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="/resources/demos/style.css">
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script>
      $( function() {
        $( "#dialog-message" ).dialog({
          modal: true,
          buttons: {
            Ok: function() {
              $( this ).dialog( "close" );
              window.location = "cargar_imagenes.php";
            }
          }
        });
      } );
      </script>
    </head>
    <body>
     
    <div id="dialog-message" title="Download complete">
      <p>
        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;" >Carga de Imagenes Equipos</span>
       <?php echo $mostrar ?>
       </p> 
    </div> 
    </body>
    </html>
<?php } ?>