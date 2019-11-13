<?php
class diploma extends crearHtml{
    
    /**
     * diploma::diploma()
     * 
     * @return
     */

    
    function verDiploma(){
        $pl_sql = 'SELECT 
                MC.fecha_aprobado,
				MC.codigoaprobado,
				CU.nombre,
				CONCAT(U.nombres ," ",U.apellidos ) nombreUsuario,
				U.numero_documento
                FROM mis_cursos MC 
                INNER JOIN cursos CU ON CU.id_cursos = MC.id_cursos AND MC.estado = 1 AND MC.id = '.$_GET['id'].'
                INNER JOIN compras C ON C.id_compras = MC.idcompra 
                INNER JOIN factura F ON F.id_factura = C.id_factura AND F.id_usuario = '.$_SESSION['id_usuario'].'
				INNER JOIN usuarios U ON U.id_usuario = F.id_usuario';
        
        $res = $this->Consulta( $pl_sql );
        if(count($res) && is_array($res)){
        $res = $res[0];
        $html = '';
        $html = '
            <html>
            <head>
            <title>Certificado</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            
            </head>
            <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
            <!-- Save for Web Slices (dipoma-01.tif) -->
            <table id="Tabla_01" width="980" height="691" border="0" cellpadding="0" cellspacing="0">
            	<tr>
            		<td colspan="4" rowspan="3">
            			<img src="./diploma/img/diploma_01.png" width="300" height="253" alt=""></td>
            		<td colspan="4">
            			<img src="./diploma/img/diploma_02.png" width="362" height="148" alt=""></td>
            		<td rowspan="11">
            			<img src="./diploma/img/diploma_03.png" width="318" height="690" alt=""></td>
            	</tr>
            	<tr>
            		<td colspan="4" height="29px" style="text-align:center;"><span style="font-size:15px; color:#FFF; background-color:#593487; padding:1px 3px;">No. ' . $res['codigoaprobado'] . '</span><span style="font-size:15px;"> &nbsp;Fecha de expedici&oacute;n: '.$res['fecha_aprobado'].'</span>
                    
                     </td>
            	</tr>
            	<tr>
            		<td>
            			<img src="./diploma/img/diploma_05.png" width="1" height="76" alt=""></td>
            		<td colspan="2">
            			<img src="./diploma/img/diploma_06.png" width="360" height="76" alt=""></td>
            		<td>
            			<img src="./diploma/img/diploma_07.png" width="1" height="76" alt=""></td>
            	</tr>
            	<tr>
            		<td colspan="2" rowspan="2">
            			<img src="./diploma/img/diploma_08.png" width="68" height="71" alt=""></td>
            		<td colspan="6" height="70px"><span style="font-size:42px;">' . $res['nombreUsuario'] . '</span></td>
            	</tr>
            	<tr>
            		<td>
            			<img src="./diploma/img/diploma_10.png" width="182" height="1" alt=""></td>
            		<td colspan="3" rowspan="2"><span style="font-size:16px;"> &nbsp; No. ' . $res['numero_documento'] . '</span></td>
            		<td colspan="2">
            			<img src="./diploma/img/diploma_12.png" width="246" height="1" alt=""></td>
            	</tr>
            	<tr>
            		<td colspan="3">
            			<img src="./diploma/img/diploma_13.png" width="250" height="24" alt=""></td>
            		<td>
            			<img src="./diploma/img/diploma_14.png" width="245" height="24" alt=""></td>
            		<td>
            			<img src="./diploma/img/diploma_15.png" width="1" height="24" alt=""></td>
            	</tr>
            	<tr>
            		<td colspan="8">
            			<img src="./diploma/img/diploma_16.png" width="662" height="46" alt=""></td>
            	</tr>
            	<tr>
            		<td>
            			<img src="./diploma/img/diploma_17.png" width="67" height="1" alt=""></td>
            		<td colspan="7" rowspan="2" height="54px"><span style="font-size:28px;">'.$res['nombre'].'</span></td>
            	</tr>
            	<tr>
            		<td>
            			<img src="./diploma/img/diploma_19.png" width="67" height="53" alt=""></td>
            	</tr>
            	<tr>
            		<td colspan="8">
            			<img src="./diploma/img/diploma_20.png" width="662" height="158" alt=""></td>
            	</tr>
            	<tr>
            		<td colspan="7">
            			<img src="./diploma/img/diploma_21.png" width="661" height="84" alt=""></td>
            		<td>
            			<img src="./diploma/img/diploma_22.png" width="1" height="84" alt=""></td>
            	</tr>
            	<tr>
            		<td>
            			<img src="./diploma/img/espacio.gif" width="67" height="1" alt=""></td>
            		<td>
            			<img src="./diploma/img/espacio.gif" width="1" height="1" alt=""></td>
            		<td>
            			<img src="./diploma/img/espacio.gif" width="182" height="1" alt=""></td>
            		<td>
            			<img src="./diploma/img/espacio.gif" width="50" height="1" alt=""></td>
            		<td>
            			<img src="./diploma/img/espacio.gif" width="1" height="1" alt=""></td>
            		<td>
            			<img src="./diploma/img/espacio.gif" width="115" height="1" alt=""></td>
            		<td>
            			<img src="./diploma/img/espacio.gif" width="245" height="1" alt=""></td>
            		<td>
            			<img src="./diploma/img/espacio.gif" width="1" height="1" alt=""></td>
            		<td>
            			<img src="./diploma/img/espacio.gif" width="318" height="1" alt=""></td>
            	</tr>
            </table>
            <!-- End Save for Web Slices -->
            </body>
            </html>';
        }
        else{
            $html = 'No se cumplen los requisitos para generar este diploma';
        }
echo $html;
    } 
}
?>