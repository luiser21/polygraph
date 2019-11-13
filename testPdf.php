<?php
require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
//require_once(dirname(__FILE__).'/pdf2/mpdf-development/src/Mpdf.php');
//require_once(dirname(__FILE__).'/pdf2/mpdf-mpdf-a15743d/Mpdf.php');
//$estilo = file_get_contents(dirname(__FILE__).'/formas.css');
//ob_start();
include(dirname(__FILE__).'/vistaImprimir.php');
//$content = ob_get_clean();
//$content = 'Hola Mundo';
//$pdf = new mPDF('c');
//$pdf->WriteHTML($content,2);
//$pdf->Output();
//
//$html2pdf = new HTML2PDF('P', 'A4', 'es',true, 'UTF-8',array(10,10,10,10));
//$html2pdf->setDefaultFont('Arial');
//$html2pdf->WriteHTML($content);
//$html2pdf->createIndex('Tabla de Contenido', 20, 12, false, true, 1);
//$html2pdf->Output('j.pdf');
?>