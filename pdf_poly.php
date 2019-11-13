<?php
/*if($_GET["plantas"]==1 && $_GET["seccion"]==0 && $_GET["equipo"]==0 ){
    $filename = "cartalubricacion.pdf";
    header("Content-Type: application/force-download");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    readfile("ECOPETROL/cartalubricacion.pdf");
    exit;
}else*/
ini_set('max_execution_time', 0);

        require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
        
        //Recogemos el contenido de la vista
        
        ob_start();
        
        include(dirname(__FILE__).'/vistaImprimir_poly.php');
        
        //Pasamos esa vista a PDF
        
        $content = ob_get_clean();
        
        // convert in PDF
        
        $html2pdf = new HTML2PDF('P', 'A4', 'es',true, 'UTF-8',array(10,10,10,10));
        
        $html2pdf->setDefaultFont('Arial');
        
        $html2pdf->WriteHTML($content);
        
        $html2pdf->Output('autorizacion.pdf','D');
        


?>