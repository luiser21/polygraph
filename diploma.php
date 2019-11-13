<?php

/**

 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

    // get the HTML
    ob_start();
   // header("Content-Type: application/pdf");
    include('./diploma/diploma.php');
    $content = ob_get_clean();

    // convert in PDF
    require_once('./html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'fr');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
		$html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content,isset($_GET['vuehtml'])); //
      //  header('Cache-Control: private, max-age=0, must-revalidate');
        $html2pdf->Output('Diploma.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>