<?php

class Plantas extends crearHtml{

    
    public $_titulo = 'ADMINISTRAR AUTORIZACIONES';
    public $_subTitulo = 'Autorizar';
    public $_datos = '';
    public $Table = 'agenda';
    public $PrimaryKey = 'id_agenda';
    
    
    
   function Contenido(){
      
       $sql = "SELECT ae.idautorcandidato,a.idautorizacion,a.nombre as nombre_autorizacion,a.politicas,a.clientetercerizado,E.cargo,E.clientefinal,C.DOCUMENTO as CEDULA,
                CONCAT(C.NOMBRES) AS EVALUADO,C.CELULAR,t.NOMBRE as tipo_prueba,C.LUGAREXPEDICION,a.logo
                FROM autorizaciones a
                INNER JOIN autorizacion_evaluado ae ON ae.idautorizacion=a.idautorizacion
                INNER JOIN evaluado E ON E.id_candidato=ae.idcandidato
                INNER JOIN candidatos C ON C.id_candidatos=E.id_candidato
                INNER JOIN tipo_prueba t ON t.ID_PRUEBA=E.id_tipo_prueba
                WHERE a.estado='A' and ae.estado='P' and C.DOCUMENTO=".$_GET['cedula'];
       $arrPlantas = $this->Consulta($sql);
       
       //var_dump($arrPlantas);
       $titulo=$arrPlantas[0]['nombre_autorizacion'];
       $nombre=$arrPlantas[0]['EVALUADO'];
       $cedula=$arrPlantas[0]['CEDULA'];
       $ciudadexpedicion=$arrPlantas[0]['LUGAREXPEDICION'];
       $cliente=$arrPlantas[0]['clientefinal'];
       $cargo=$arrPlantas[0]['cargo'];
       $politica=$arrPlantas[0]['politicas'];
       $tipo_prueba=$arrPlantas[0]['tipo_prueba'];
       $celular=$arrPlantas[0]['CELULAR'];
       $empresa=$arrPlantas[0]['clientetercerizado'];
       
       $politica=explode('#', $politica);
       
       $autorizacion=$politica[0].' <strong>'.$nombre.'</strong> '.$politica[1].' <strong>'.$cedula.'</strong> '.$politica[2].' <strong>'.$ciudadexpedicion.'</strong> '.$politica[3].' <strong>'.$cargo.'</strong> ';
       $autorizacion.=$politica[4].' <strong>'.$empresa.'</strong> '.$politica[5].' <strong>'.$empresa.'</strong> '.$politica[6].' <strong>'.$cliente.'</strong> '.$politica[7].' <strong>'.$empresa.'</strong> ';
       $autorizacion.=$politica[8].' <strong>'.$empresa.'</strong> '.$politica[9].' <strong>'.$empresa.'</strong> '.$politica[10];
         
         $html='<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Solicitudes</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                          <div class="panel panel-default panelCrear">
                             <div class="panel-heading">
                                <h3 class="panel-title">Autorizacion</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                  <input type="hidden" name="idautorcandidato" value="'.$arrPlantas[0]['idautorcandidato'].'" id="idautorcandidato">
                                           <input type="hidden" name="cedula" value="'.$cedula.'" id="cedula"> 
                                    <div class="form-group" align="center">
                                        <img src="'.$arrPlantas[0]['logo'].'" width="400" height="130" class="img-fluid"  />
                                        <br/>
                                    </div>
                                      <h1 align="center">'.$titulo.'</h1><br/>
                                    <div class="form-group" align="center">
                                        <script language="JavaScript">
                                    	document.write( webcam.get_html(220, 240) );//dimensiones de la camara
                                    	</script>                                       
                                        <div id="upload_results" align="center">    
                                        	
                                                <br/>
                                                <button type="button" class="btn btn-primary" onClick="webcam.freeze()">Tomar foto</button>
                                                <button type="button" class="btn btn-primary" onClick="do_upload()">Subir</button>
                                        	
                                        </div> 
                                    </div> <br/>
                                    <div class="form-group">'.$autorizacion.'

                                    </div>
                                     <div class="form-group">
                                        <p>Lugar y Fecha: <strong>'.date('d') . ' de ' . date('M') . ' del ' . date('Y').'</strong></p>
                                        <p>Tipo de Prueba: <strong>'.$tipo_prueba.' </strong></p>
                                        <p>No de Celular: <strong>'.$celular.'</strong></p>
                                        <p>&nbsp;</p>
                                          
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">FIRMA DEL EVALUADO:</label>
                                         
                                        '.$this->create_input('text','firma','firma','FIRMA DEL EVALUADO',false,'form-control').'
                                    
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">OBSERVACIONES:</label>
                                        '.$this->create_input('textarea','observaciones','observaciones','',false,'form-control').'
                                        
                                    </div>
                                    <div align="center" id="autorizacion" style="display:none">
                                    '.$this->create_input('checkbox','autorizar','autorizar','0',false,'required').'                                        
                                    <button type="button" id="guardarCursoPDF" class="btn btn-primary">Autorizar</button>
                                    </div>
                                    <div id="resultadoajax" style="display:none"></div>
                                    <div id="Resultado" style="display:none">RESULTADO</div>
                                     
                                </form>
                            </div>
                        </div>

                    </div> 
                    
                        </div>
                    </div>
                </div>                    

        </section>  '; 
        return $html;
        
    }
    
    function guardarDatos(){
       //  $this->imprimir($_POST);exit; 
        //$this->imprimir($_SESSION['id_usuario']);
        try {
            $sql="UPDATE autorizacion_evaluado set 
                            estado='A', 
                            foto='".$_POST['id_foto']."',
                            observaciones='".$_POST['observaciones']."',
                            firma='".$_POST['firma']."',
                            fecha=DATE_ADD(NOW(), INTERVAL -5 HOUR)                        
                   where estado='P' and idautorcandidato=".$_POST['idautorcandidato'];
             $this->QuerySql($sql);       
             $_respuesta = 'Se Autorizo Exitosamente';
        }
        catch (exception $e) {
            $_respuesta =  $e->getMessage();
        }
        
        echo $_respuesta;       
    }

    
    function _mostrar(){
      /**  $this->arrCss = array('./css/misDatos.css','./css/theme.blue.css');
        $this->arrJs = array('./js/jsCrud.js');*/
        $html = $this->Cabecera();
        $html .= $this->contenido();
      //  $html .= $this->tablaDatos();
        $html .= $this->Pata();
        echo $html;
    }
    
    
}
?>