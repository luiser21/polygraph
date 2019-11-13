<?php
class carroCompras extends crearHtml{
    
    public $_titulo = 'COMPRAS';
    public $_subTitulo = 'Listado de compras a realizar';
    public $_datos = '';
    public $Table = 'cursos';
    public $PrimaryKey = 'id_cursos';
    /**
     * carroCompras::$apiKey
     * 
     * @return apiKey proporcionado por Payu
     */
    //public $apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c";
    public $apiKey = "d51nQ9A6zjIMjmayJ0hr7D6Q0U"; #Produci&oacute;n
             
    /**
     * carroCompras::$apiLogin
     * 
     * @return apiLogin proporcionado por Payu
     */
    //public $apiLogin = "11959c415b33d0c";
    public $apiLogin = "5wCTssMN30zQQKF"; #Producci&oacute;n
    
    /**
     * carroCompras::$accountId
     * 
     * @return accountId proporcionado por Payu
     */
  //  public $accountId = "500538"; 
    public $accountId = "530015"; #Produccion
    
    /**
     * carroCompras::$merchantId
     * Es el n&uacute;mero identificador de su comercio en el sistema de PayU, este n&uacute;mero lo encontrar&aacute; en el correo de creaci&oacute;n de la cuenta
     * @return 
     */
    //public $merchantId = '500238';
    public $merchantId = '528194'; #Produccion
    
    
    /**
     * carroCompras::currency
     * La moneda respectiva en la que se realiza el pago. 
       El proceso de conciliaci&oacute;n se hace en pesos a la tasa representativa del día.
     * @return 
     */
    public $currency = 'COP';
    
    /**
     * carroCompras::$amount
     * Es el monto total de la transacci&oacute;n. Puede contener dos dígitos decimales. Ej. 10000.00 &oacute; 10000.
     * @return 
     */
    public $amount = false;
    
    /**
     * carroCompras::$refereceCode
     * Es la referencia de la venta o pedido. Deber ser &uacute;nico por cada transacci&oacute;n que se envía al sistema. Payu
     * @return 
     */
    public $refereceCode;
    
    /**
     * carroCompras::$refereceCode
     * Es la descripsion de los productos comprados
     * @return 
     */    
    public $descripcionCompra = 0;
    
    /**
     * carroCompras::$urlPayu
     * Ip a la que se envia el formulario a payu
     * @return 
     */
    //public $urlPayu = 'https://stg.gateway.payulatam.com/ppp-web-gateway/';     
    public $urlPayu = 'https://gateway.payulatam.com/ppp-web-gateway/'; #Producci&oacute;n
    /**
     * carroCompras::$testPayu
     * indica si esta enviado o no un test a la plataforma de Payu 
     * @return 
     */
    public $testPayu = '0';    

    /**
     * carroCompras::Contenido()
     * 
     * @return
     */
    function Contenido(){

        $html =  '<section class="main-content-wrapper">
        <div id="contenidoCarro">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Cursos y Eventos</li>
                    </ol>
                </div>
            </div>';
            
            $html .= '<div class="row">
                    <div class="col-md-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Carro de compras</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">

                                <div class="table-responsive">
                                    <form method="post" id="formuCompra" action="'.$this->urlPayu.'">
                                    '.$this->verCarro().'
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>';

        $html .=' </div> 
        </section>';
        
        return $html;
    }

    
   /**
     * carroCompras::Contenido()
     * 
     * @return
     */
    function verCarro(){
        

        $html = '';
        $_tabla = array();
        $i=0;
        if( isset( $_GET['ppp'] ) ) imprimir($_SESSION,'$_SESSION');
        if( isset($_SESSION['item']) && count($_SESSION['item']) ){
            $valorSum = array();
            $itemsElegidos = array();
            $_tabla[$i]['Descipcion']   = 'Descripcion';
            $_tabla[$i]['Valor']   = 'Valor';
            $_tabla[$i]['Elimar']   = 'Elimar';
            foreach($_SESSION['item'] as $pos=>$item){
                $valorSum[] = $item['precio'];
                $itemsElegidos[] = $item['nombre'];
                $i++;
                $_tabla[$i][] =  $item['nombre'];
                $_tabla[$i][] =  '$'.number_format($item['precio']);
                $_tabla[$i][] =  '<i class="fa fa-minus-square" style="cursor:pointer"></i>'; //onclick="fn_eliminaItem('.$pos.')"
            }
            $i++;
            $_tabla[$i][] =  'Total Pedido $'.number_format( array_sum( $valorSum ) );
            $t = ( isset( $_GET['ppp'] ) ) ? '<span class="btn btn-info" id="botoncomprarPayu">TEST DE PRUEBA</span>' : '';
            /** Produccion 
             $apiKey = "d51nQ9A6zjIMjmayJ0hr7D6Q0U"; //Ingrese aquí su propio apiKey.
             $apiLogin = "5wCTssMN30zQQKF"; //Ingrese aquí su propio apiLogin.
             $accountId = "530015"; //Ingrese aquí su Id de Comercio.
             $merchantId = '528194';
             $refereceCode = '01 Curso';
             $amount  = '10.000';
             $currency = 'COP';
             $signaturePayu = "$apiKey~$merchantId~$refereceCode~$amount~$currency";
              */
              


             //ApiKey~merchantId~referenceCode~amount~currency
              //$_SESSION['correo']
            $this->descripcionCompra = implode(',',$itemsElegidos);
            $this->amount = array_sum( $valorSum );
            $camposPayu = $this->getPayu();
                
            $_tabla[$i][] = $camposPayu.'<span class="btn btn-info" id="botoncomprar">COMPRAR</span> '.$t;
            
            //$_tabla[$i][] =  $this->create_input('button','pagar','pagar',false,'Pagar','buttonLogin');
            $_array_formu = $this->generateHead($_tabla);
            $html = $this->print_table($_tabla,3,false,'table table-bordered table-striped');
            $html.= '<hr><div id="resultadoCompra"> </div>';
            //  .= $this->itemFila('',$this->create_input('button','enviarListado','enviarListado',false,'Terminar y Enviar pedido','buttonLogin' ) );
            return $html;            
        }else $html = 'Sin productos en el carro.';
        return $html;
    }


    /**
     * carroCompras::getPayu()
     * Genera los campos hidden solicitados por Payu.
     * @return Retorna los campos hiddden con los valores para retornar a Payu 
     */    
     function getPayu(){
        //$refereceCode = '0';
        //$this->amount = '30000';
        //$signaturePayu = "$this->apiKey~$this->merchantId~$this->refereceCode~$this->amount~$this->currency";
        
        $camposPayu = $this->create_input('hidden','merchantId','merchantId',0,$this->merchantId).
                            $this->create_input('hidden','accountId','accountId',0,$this->accountId).
                            $this->create_input('hidden','description','description',0,$this->descripcionCompra).
                            $this->create_input('hidden','referenceCode','referenceCode',0,$this->refereceCode).
                            $this->create_input('hidden','amount','amount',0,$this->amount).
                            $this->create_input('hidden','tax','tax',0,'0').
                            $this->create_input('hidden','taxReturnBase','taxReturnBase',0,'0').
                            $this->create_input('hidden','currency','currency',0,$this->currency).
                            $this->create_input('hidden','signature','signature',0 , '000' ).
                            $this->create_input('hidden','test','test',0,$this->testPayu).
                            $this->create_input('hidden','buyerEmail','buyerEmail',0,'david.ardila@gmail.com').
                            $this->create_input('hidden','nombreComprador','nombreComprador',0,'David Ardila').
                            $this->create_input('hidden','documentoIdentificacion','documentoIdentificacion',0,'1111').
                            $this->create_input('hidden','telefonoMovil','telefonoMovil',0,'23333').  
                            $this->create_input('hidden','responseUrl','responseUrl',0,'http://www.dnamusiconline.com/cursos_online/compra.php').
                            $this->create_input('hidden','confirmationUrl','confirmationUrl',0,'http://www.dnamusiconline.com/cursos_online/compra.php');
        return $camposPayu;
     }
    /**
     * carroCompras::registraCarro
     * Guarda registro de la posible compra del usuario.
     */
    function registraCarro(){
        if( isset($_SESSION['id_usuario']) ){
            $sql = "INSERT INTO `factura`(`id_usuario`, `fecharegistro`) 
                        VALUES
                    ('".$_SESSION['id_usuario']."' , NOW() )";
                    
            $this->refereceCode = $this->QuerySql($sql);
            $valorSum = array();
            foreach($_SESSION['item'] as $pos=>$item){
                
                $valorSum[] = $item['precio'];
                
                $sql = "INSERT INTO `compras`(`id_factura`) VALUES ('".$this->refereceCode."')";
                $id = $this->QuerySql($sql);
                
                $sql = "INSERT INTO `mis_cursos`
                    (`idcompra`, `id_cursos`) 
                    VALUES ('".$id."','".$item['id_cursos']."')";
            
                $this->QuerySql($sql);
            }
            $this->amount = array_sum( $valorSum );
            $this->amount = '30000';
            $this->refereceCode = 'rf00'.$this->refereceCode;
            $signaturePayu = "$this->apiKey~$this->merchantId~$this->refereceCode~$this->amount~$this->currency";
            $respuesta = array('id'=>$this->refereceCode,'signature'=> md5($signaturePayu) );
            echo json_encode( $respuesta );
        }
    }
    
    function compraGratis(){
        if( isset($_SESSION['id_usuario']) ){
            $sql = "INSERT INTO `factura`(`id_usuario`, `fecharegistro`) 
                        VALUES
                    ('".$_SESSION['id_usuario']."' , NOW() )";
                    
            $this->refereceCode = $this->QuerySql($sql);
            
            $valorSum = array();
            $sql = "INSERT INTO `compras`(`id_factura`) VALUES ('".$this->refereceCode."')";
            $idCompra = $this->QuerySql($sql);
            $sql = "INSERT INTO `mis_cursos`
                (`idcompra`, `id_cursos`) 
                VALUES ('".$idCompra."','".$this->_datos."')";
            
            $this->QuerySql($sql);
            $respuesta = array('id'=>'1','descripcion'=> 'Curso agregado con &eacute;xito' );
            echo '<div class="alert alert-success alert-dismissable">
                                <strong>FELICIDADES!</strong> Felicidades, tu curso o Evento se ha agregado con &eacute;xito. <a href="./misCursos.php">Ir a mis cursos</a><br />
                                </div>';
           // echo json_encode( $respuesta );
        }
    }
    /**
     * carroCompras::agProductoCarro()
     * Agrega el item elegido al arreglo del carro de compras, trae los datos por medio de consulta y verifica que no se repita la informaci&oacute;n.
     * @return
     */    
      function agProductoCarro(){
        if( empty( $this->_datos['idcurso'] ) ){
            die( 'Error al tratar de consultar un producto para compra' );
        }
        $res = $this->Consulta('SELECT `id_cursos`, `nombre`, `precio` FROM `cursos` WHERE `id_cursos` = '.$this->_datos['idcurso']);
        if(count($res)){    
            if($_SESSION['item']){
                if( recursive_array_search( $this->_datos['idcurso'] , $_SESSION['item'] ) === false ){
                    $_SESSION['item'][] = $res[0];
                }
            }else{
                $_SESSION['item'][] = $res[0];
            }
        }else{
            die('Producto no encontrado!');
        }

    }    
    
    function agCantidadCarro(){
        $c = $this->_datos;
        $p = $_REQUEST['posicion'];
        $_SESSION['item'][$p]['cantidad'] = $c;
                
        //echo "p $p => cantidad $c";
//        imprimir($_SESSION,'$_SESSION');
        echo $this->redirect;
    }
    
    function borrarItemCarro(){
        $p = $this->_datos;
        //imprimir('$_SESSION[item]['.$p.'][cantidad].');
       // unset($_SESSION['item'][$p]);
        echo $this->redirect;
    }
    
    
    
    /**
     * carroCompras::getDatos()
     * 
     * @return
     */
    function getDatos(){
        $res = $this->Consulta('SELECT `id_cursos`, `nombre`, `descripcion`,fecha_ini,fecha_fin FROM '.$this->Table ." WHERE id_cursos = ".$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    /**
     * carroCompras::_mostrar()
     * 
     * @return
     */
    function _mostrar(){
        $html = $this->Cabecera();
        $html .= $this->contenido();
        $html .= $this->Pata();
        echo $html;
    }
}
?>