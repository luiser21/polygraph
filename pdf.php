<?php
require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');        
include(dirname(__FILE__).'/vistaImprimir.php'); 
//Pasamos esa vista a PDF       
$content = ob_get_clean();
// convert in PDF
$html2pdf = new HTML2PDF('P', 'A4', 'es',true, 'UTF-8',array(20,10,20,10));
$html2pdf->setDefaultFont('arial');
$html2pdf->WriteHTML($content);       
$html2pdf->Output('autorizaciones_pdf/autorizacion_'.$_GET["cedula"].'.pdf','F','D');
?>