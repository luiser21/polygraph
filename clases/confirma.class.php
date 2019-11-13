<?php
class confirmaCompra extends carroCompras{
    
    public $_titulo = '';
    public $_subTitulo = 'Proceso de compra.';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';
    public $idEvaluacion = '';
    public $idCurso = '';
    public $estadoTransaccion = '';

    
    /**
     * confirmaCompra::resultadoCompra()
     * Muestra el resultado de la compra realizada y el estado de la transaccion
     * @return
     */    
    function resultadoCompra(){
        if( $this->validaFirma() ){
            $this->guardaRegistro();
        }
    }    
    
    
    function guardaRegistro(){
        $this->guardaRegistro();
    }

    
    /**
     * confirmaCompra::resultadoCompra()
     * Muestra el resultado de la compra realizada y el estado de la transaccion
     * @return
     */    
    function validaFirma(){
        
        $ApiKey = "6u39nqhq8ftd0hlvnjfs66eh8c";
        $merchant_id = ( isset($_REQUEST['merchant_id']) ) ? $_REQUEST['merchant_id'] : '';
        $referenceCode =  ( isset($_REQUEST['reference_sale']) ) ? $_REQUEST['reference_sale'] : '';
        $TX_VALUE =  ( isset($_REQUEST['value']) ) ? $_REQUEST['value'] : '0';
        $New_value = $TX_VALUE; // number_format($TX_VALUE, 1, '.', '');
        $currency = ( isset($_REQUEST['currency']) ) ? $_REQUEST['currency'] : '';
        $transactionState = ( isset($_REQUEST['state_pol']) ) ? $_REQUEST['state_pol'] : '';
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
    
   
}
?>