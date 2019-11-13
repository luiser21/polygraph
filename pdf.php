<?phpini_set('max_execution_time', 0);
require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');        //Recogemos el contenido de la vistaob_start();        
include(dirname(__FILE__).'/vistaImprimir.php'); 
//Pasamos esa vista a PDF       
$content = ob_get_clean();
// convert in PDF
$html2pdf = new HTML2PDF('P', 'A4', 'es',true, 'UTF-8',array(20,10,20,10));
$html2pdf->setDefaultFont('arial');
$html2pdf->WriteHTML($content);       
$html2pdf->Output('autorizaciones_pdf/autorizacion_'.$_GET["cedula"].'.pdf','F','D');$dbgestion = new crearHtml(); $dbgestion->generar_informe_empresa('autorizaciones_pdf/autorizacion_'.$_GET["cedula"].'.pdf',$_GET["idautorcandidato"]);
?><!-- <script type="text/javascript">       function traerPDF() {window.location ='autorizaciones_pdf/autorizacion_112641527.pdf';}setTimeout("traerPDF()", 1000);     </script>         -->