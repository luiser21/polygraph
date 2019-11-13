<?php
class Index extends crearHtml{
    
    public $_titulo = '';
    public $_subTitulo = 'Proceso de compra.';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';
    public $idEvaluacion = '';
    public $idCurso = '';
    public $estadoTransaccion = '';

   /**
     * Index::Contenido()
     * 
     * @return
     */
    function Contenido(){
        
        $html =  '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Resultado Compra</li>
                    </ol>
                </div>
            </div>';
            $html .= $this->resultadoCompra();

            
        $html .=' </section>';
        
        return $html;
            
    }
    
    /**
     * Index::resultadoCompra()
     * Muestra el resultado de la compra realizada y el estado de la transaccion
     * @return
     */    
    function resultadoCompra(){
        if( $this->validaFirma() ){
            if( isset($_REQUEST['transactionState']) && $_REQUEST['transactionState'] == 4 ){
                return $this->compraExitosa();
            }else{
                return $this->compraFallida();
            }
        }
        else{
            return $this->errorValidacion();
        }
    }    
    

    
    /**
     * Index::resultadoCompra()
     * Muestra el resultado de la compra realizada y el estado de la transaccion
     * @return
     */    
    function validaFirma(){
        
        $ApiKey = "6u39nqhq8ftd0hlvnjfs66eh8c";
        $merchant_id = ( isset($_REQUEST['merchantId']) ) ? $_REQUEST['merchantId'] : '';
        $referenceCode =  ( isset($_REQUEST['referenceCode']) ) ? $_REQUEST['referenceCode'] : '';
        $TX_VALUE =  ( isset($_REQUEST['TX_VALUE']) ) ? $_REQUEST['TX_VALUE'] : '0';
        $New_value = $TX_VALUE; // number_format($TX_VALUE, 1, '.', '');
        $currency = ( isset($_REQUEST['currency']) ) ? $_REQUEST['currency'] : '';
        $transactionState = ( isset($_REQUEST['transactionState']) ) ? $_REQUEST['transactionState'] : '';
        $firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
        $firmacreada = md5($firma_cadena);
        $firma = ( isset($_REQUEST['signature']) ) ? $_REQUEST['signature'] : '';
        
        echo '$firmacreada=>'.$firmacreada;
        echo '<br> signature=> '.$firma;
        if ( strtoupper($firma) != strtoupper($firmacreada) ){
            return false;
        }
        
        
//        $reference_pol = $_REQUEST['reference_pol'];
//        $cus = $_REQUEST['cus'];
//        $extra1 = $_REQUEST['description'];
//        $pseBank = $_REQUEST['pseBank'];
//        $lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
//        $transactionId = $_REQUEST['transactionId'];

    if ($_REQUEST['transactionState'] == 4 ) {
    	$this->estadoTransaccion = "Transacci&oacute;n aprobada";
    }
    
    else if ($_REQUEST['transactionState'] == 6 ) {
    	$this->estadoTransaccion = "Transacci&oacute;n rechazada";
        //return false;
    }
    
    else if ($_REQUEST['transactionState'] == 104 ) {
    	$this->estadoTransaccion = "Error";
        //return false;
    }
    
    else if ($_REQUEST['transactionState'] == 7 ) {
    	$this->estadoTransaccion = "Transacci&oacute;n pendiente";
        //return false;
    }
    
    else {
    	$this->estadoTransaccion = $_REQUEST['mensaje'];
    }
    return true;
    }
    
    /**
     * Index::compraExitosa()
     * Formulario de exito por la compra
     * @return
     */  
    function compraExitosa(){
    $html = '';
    $html .= '<div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Resultado de la Compra</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-expand"></i>
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <div class="panel-body"  style="text-align:center;">
                            <img src="./assets/img/sonrie.jpg" height="150" width="355">
                            <hr>
                            <div style="text-align: center;">
                                
                                <div class="alert alert-success alert-dismissable">
                                
                                <strong>FELICIDADES!</strong> Tu compra ha sido exitosa ['.$this->estadoTransaccion.'], ingresa a la secci&oacute;n Cursos y Eventos Activos para acceder <br />
                                a tu curso y/o evento</div>
                                
                                <a href="http://www.payulatam.com/logos/pol.php?l=133&c=556a5f74442f1" target="_blank"><img src="http://www.payulatam.com/logos/logo.php?l=133&c=556a5f74442f1" alt="PayU Latam" border="0" /></a><br />
                                
                            </div><br>
                            <button class="btn btn-success" onclick="javascript:window.location = \'misCursos.php\'" type="button">Ir a mi cursos y eventos compartidos</button>
                        </div>
                        
                    </div>
                </div>
                </div>   ';
                
        return $html;
    }  

    /**
     * Index::compraFallida()
     * Formulario que muestra resultado de compra fallida
     * @return
     */  
    function compraFallida(){
    $html = '';
    $html .= '<div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Resultado de la Compra</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-expand"></i>
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <div class="panel-body"  style="text-align:center;">
                            <img src="./assets/img/triste.png" height="150" width="355">
                            <hr>
                            <div style="text-align: center;">
                                
                                <div class="alert alert-danger fade in">
                                
                                <strong>UPS,</strong> Algo sucedio Tu Compra se encuentra en estado ['.$this->estadoTransaccion.'], por favor revisa con tu entidad qu&eacute; pudo haber ocurrido 
                            si la transacci&oacute;n se encuentra en estado pendiente te avisaremos cuando este el resultado final.  </div>
                                
                                <a href="http://www.payulatam.com/logos/pol.php?l=133&c=556a5f74442f1" target="_blank"><img src="http://www.payulatam.com/logos/logo.php?l=133&c=556a5f74442f1" alt="PayU Latam" border="0" /></a><br />
                                
                            </div><br>
                            
                            <button class="btn btn-success" onclick="javascript:window.location = \'misCursos.php\'" type="button">Ir a mi cursos y eventos compartidos</button>
                        </div>
                        
                    </div>
                </div>
                </div>   ';
                
        return $html;        
    }
  
    /**
     * Index::resultadoCompra()
     * Muestra el error en la validacion de la firma
     * @return
     */       
    function errorValidacion(){
    $html = '';
    $html .= '<div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Resultado de la Compra</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-expand"></i>
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <div class="panel-body"  style="text-align:center;">
                            <img src="./assets/img/triste.png" height="150" width="355">
                            <hr>
                            <div style="text-align: center;">
                                
                                <div class="alert alert-danger fade in">
                                
                                <strong>UPS,</strong> Se ha encontrado un error en la validacion de datos. por favor revisa tu transacci&oacute;n ya que esta no quedar&aacute; registrada en el sistema.</div>
                                
                                <a href="http://www.payulatam.com/logos/pol.php?l=133&c=556a5f74442f1" target="_blank"><img src="http://www.payulatam.com/logos/logo.php?l=133&c=556a5f74442f1" alt="PayU Latam" border="0" /></a><br />
                                
                            </div><br>
                            
                            <button class="btn btn-success" onclick="javascript:window.location = \'misCursos.php\'" type="button">Ir a mi cursos y eventos compartidos</button>
                        </div>
                        
                    </div>
                </div>
                </div>   ';
                
        return $html;        
    } 

    
    function Iniciar(){
         $this->_file  = $_SERVER['PHP_SELF'];
         if( isset($_POST['idCurso']) ){
            $this->idCurso = $_POST['idCurso'];
            $this->getInfoEvaluacion();
         }
         if( isset($_SESSION['id_usuario']) ){
            $this->idUsuario = $_SESSION['id_usuario'];
            $this->NombreUsuario = $_SESSION['nombre'];
         }         
         if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || isset($_REQUEST['uploadFileIframe'])){
            $this->_datos =  ( is_array($_REQUEST['d']) || is_object($_REQUEST['d']) )? $this->serializeArray($_REQUEST['d']) : $_REQUEST['d'];
             if( method_exists($this,$_REQUEST['process']) ){
                 call_user_func(array($this,$_REQUEST['process'])); 
                 }
            exit;
        }
        else{
            $this->_mostrar();
        }
    }    
    
    /**
     * Index::_mostrar()
     * 
     * @return
     */
    function _mostrar(){
        $html = $this->Cabecera();
        $html .= $this->contenido();
        //$html .= $this->tablaDatos();
        $html .= $this->Pata();
        echo $html;
    }
}
?>