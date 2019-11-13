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

print_r($_POST);
exit;
//Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
if(!empty($_POST)){
    
    
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