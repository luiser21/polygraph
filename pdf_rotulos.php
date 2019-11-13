<?php
/*if($_GET["plantas"]==1 && $_GET["seccion"]==0 && $_GET["equipo"]==0 ){
    $filename = "cartalubricacion.pdf";
    header("Content-Type: application/force-download");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    readfile("ECOPETROL/cartalubricacion.pdf");
    exit;
}else*/
ini_set('max_execution_time', 0);
if(isset($_POST["id_planta"])){
        
        require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
        
        //Recogemos el contenido de la vista
        
        ob_start();
        
        include(dirname(__FILE__).'/rotuloplanta_informe.php');
        
        //Pasamos esa vista a PDF
        
        $content = ob_get_clean();
        
        // convert in PDF
        
        $html2pdf = new HTML2PDF('P', 'A4', 'es',true, 'UTF-8',array(10,10,20,20));
        
        $html2pdf->setDefaultFont('Arial');
        
        $html2pdf->WriteHTML($content);
        
      //  $html2pdf->createIndex('Tabla de Contenido', 20, 12, false, true, 1);
        
        $html2pdf->Output('Rotulosxplantas.pdf','D');
        
}

?>