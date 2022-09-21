<?php
class Plantas extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR SOLICITUDES';
    public $_subTitulo = 'Crear Solicitudes';
    public $_datos = '';
    public $Table = 'evaluado';
    public $PrimaryKey = 'id_evaluado';
    
    
    
   function Contenido(){
         $html='<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Solicitudes</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        
                    </div> '.$this->tablaDatos().'
                    
                        </div>
                    </div>
                </div>                    

        </section>  '; 
         $html .= $this->formularioMecMet();
        return $html;
        
    }
    
    
    public function formularioMecMet(){
      //  var_dump($this->_datos);
        $evaluado='';
        
         $html = '
                <div class="modal fade" id="divMecMet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            
                 
                           <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
         
         if(!empty($this->_datos)){
               $sql="SELECT
                	tp.NOMBRE AS TIPO,
                	CONCAT(c.NOMBRES, ' ', c.APELLIDOS) AS EVALUADO,
                    E.cargo AS CARGO_ASPIRAR,
                    E.clientefinal AS CLIENTE_FINAL
                FROM
                	candidatos c
                INNER JOIN evaluado E ON E.id_candidato = c.ID
                INNER JOIN tipo_prueba tp ON tp.ID_PRUEBA = E.id_tipo_prueba
                WHERE E.id=".@$this->_datos;
             
             
             $datos = $this->Consulta($sql,1);
             // $_SESSION['EVALUADO']=$datos[0]['EVALUADO'];
             $evaluado=@$datos[0]['EVALUADO'];
         
              $html.='      <h4 class="modal-title" id="myModalLabel"> Programaci&oacute;n para <strong id="mecTitulo"> '.@$evaluado.' </strong>
<p id="p1">Hola Cybernauta!</p>
</h4>';
         }
       $html.='         </div>
                <div class="modal-body">
          
                    <form class="form-horizontal" id="formCrearMecMet" role="form">            
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="nombre" class="col-sm-2 control-label">Fecha:</label>
                                         <div class="col-sm-10">
                                            '.$this->create_input('date','fecha','fecha','Fecha',false,'form-control required').'
                                            '.$this->create_input('hidden','evaluado','evaluado',false).'
                                        </div>
                                      </div>  
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label" for="nombre" class="col-sm-2 control-label">Hora:</label>
                                         <div class="col-sm-10">
                                            <input type="time" name="hora" id="hora" value="07:00:00" class="form-control required" min="07:00:00" max="19:00:00" step="1">
                                          </div>
                                                                                 
                                    </div>   
                                <div class="panel" id="ResultadoModal" style="display:none">RESULTADO</div>
                                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="guardarMecMetModal">Guardar programaci&oacute;n</button>
                    <button type="button" id="limpiarMecanismo" class="btn btn-default" data-dismiss="modal">Terminar</button>
                    <div class="panel" id="ResultadoModal" style="display:none">RESULTADO</div>
                </div>
            </div>
        </div>
                </div>';
        return $html;
    }
    
    function guardarMecanismos(){
       // var_dump($this->_datos);
       // exit;
        $_SESSION['EVALUADO']='';
        $sql="SELECT
            	tp.NOMBRE AS TIPO,
            	CONCAT(c.NOMBRES, ' ', c.APELLIDOS) AS EVALUADO,               
                E.cargo AS CARGO_ASPIRAR,
                E.clientefinal AS CLIENTE_FINAL
            FROM
            	candidatos c
            INNER JOIN evaluado E ON E.id_candidato = c.ID
            INNER JOIN tipo_prueba tp ON tp.ID_PRUEBA = E.id_tipo_prueba
            WHERE E.id=".$this->_datos;
        
        
        $datos = $this->Consulta($sql,1); 
        $_SESSION['EVALUADO']=$datos[0]['EVALUADO'];
        $evaluado=$datos[0]['EVALUADO'];
        $this->create_input('text','evaluado','evaluado','evaluado',false,$evaluado);
        ?>
        <script type="text/javascript">
        document.getElementById("p1").innerHTML ='pendejo' ;
        </script>
       <?php 
             $_respuesta = array('guardo'=>1,
            'id'=>$datos[0]['EVALUADO']
        );
        
        echo json_encode($_respuesta); 
    }
    function guardarMecMet(){
        try{
        $sql="UPDATE events set estado='I' where idcandidato=".$this->_datos['evaluado'];
        $this->QuerySql($sql);        
        
        $sql="INSERT INTO events (idcandidato,fecha,hora) values (".$this->_datos['evaluado'].",'".$this->_datos['fecha']."','".$this->_datos['hora']."') ";
        $this->QuerySql($sql);
        
        $sql="SELECT estado FROM evaluado where id_candidato=".$this->_datos['evaluado'];
        $datos = $this->Consulta($sql,1); 
        
        if($datos[0]['estado']==2){
            $sql='UPDATE evaluado set estado=8 where id_candidato='.$this->_datos['evaluado'];
           $this->QuerySql($sql);
        }else{
           $sql='UPDATE evaluado set estado=2 where id_candidato='.$this->_datos['evaluado'];
            $this->QuerySql($sql);
        } 
        
            $_respuesta = array('Codigo' => 1, "Mensaje" => 'Datos Ingresados con &eacute;xito');
           
        }catch(Exception $e){
            $_respuesta = array('Codigo' => 0, "Mensaje" => 'Error, por favor revisar los datos guardados e ingresar => '.$e);
        }
       
        echo json_encode($_respuesta);
    }
    
    
    function guardarDatos(){
        $this->runActualizar();        
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        $_respuesta = array('Codigo' => 99, "Mensaje" => 'Registro Eliminado con exito');
        $sql = 'DELETE  P, S, E, C, M, MM FROM plantas P 
                LEFT JOIN secciones S ON S.id_planta = P.id_planta
                LEFT JOIN equipos E ON E.id_secciones = S.id_secciones
                LEFT JOIN componentes C ON C.id_equipos = E.id_equipos
                LEFT JOIN mecanismos M ON M.id_componente = C.id_componentes
                LEFT JOIN mec_met MM ON MM.id_mecanismos = M.id_mecanismos
                WHERE P.id_planta = ' .  $this->_datos;
        try{
        $this->QuerySql($sql);
        }catch (exception $e) {
            $_respuesta = array('Codigo' => 99, "Mensaje" => $e->getMessage());
        }
        print_r(json_encode($_respuesta));
    }
    
    function fn_editar(){
        
    }
    
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        $resultado = $res[0];
        
        print_r( json_encode( $resultado ) );
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
    
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
      //  $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql=<<<OE
              SELECT
             
            	tp.NOMBRE AS TIPO,
				c.NOMBRES AS EVALUADO,
                c.DOCUMENTO AS CEDULA,
                c.EMAIL,
                c.TELEFONO,
                E.cargo AS CARGO_ASPIRAR,	
                empresas.NOMBRE AS CLIENTE_FINAL,
                aliados.NOMBRE AS CLIENTETERCERIZADO,
            --	E.fecha_inicio AS FECHA,	
            	ea.nombre_estado_agenda AS ESTADO,    
            	CASE
            	WHEN E.resultado=1 THEN CONCAT('<div align="center"><img src="img/verde.png" align="center" width="20" height="20" /></div>') 
            	WHEN E.resultado=2 THEN CONCAT('<div align="center"><img src="img/amarillo.png" align="center" width="20" height="20" /></div>') 
            	WHEN E.resultado=3 THEN CONCAT('<div align="center"><img src="img/rojo.png" align="center" width="20" height="20" /></div>')  
            	END AS RESULTADO,
                CONCAT(  '<div class="fa fa-edit" align="center" style="cursor:pointer" title="Crear Reporte" ONCLICK=javascript:fn_guardarMecMet(',  E.id_evaluado ,  ',\'{$this->_file}\'); />' ) 
                    AS ACCION
            FROM
            	candidatos c
            INNER JOIN evaluado E ON E.id_candidato = c.id_candidatos
            INNER JOIN tipo_prueba tp ON tp.ID_PRUEBA = E.id_tipo_prueba 
            INNER JOIN estados_agenda ea ON ea.id_estados=E.estado 
            Inner Join aliados ON aliados.id_aliado = E.clientefinal
			Inner Join empresas ON empresas.id_empresa = E.clientetercerizado
OE;
        
        
        $datos = $this->Consulta($sql,1); 
        if(count($datos)){
            $_array_formu = array();
            $_array_formu = $this->generateHead($datos);
            $this->CamposHead = ( isset($_array_formu[0]) && is_array($_array_formu[0]) )? $_array_formu[0]: array();
            
            $tablaHtml  = '<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body recargaDatos"  style="page-break-after: always;">
                            <div class="table-responsive">';
            $tablaHtml  .='';
    		$tablaHtml .= $this->print_table($_array_formu, 12, true, 'table table-striped table-bordered',"id='tablaDatos'");
    		$tablaHtml .=' </div>
           </div>
                        </div>
                    </div>
                </div>
            ';
        }else{
            $tablaHtml = '<div class="col-md-8">
                            <div class="alert alert-info alert-dismissable">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                                <strong>Atenci&oacute;n</strong>
                                No se encontraron registros.
                            </div>
                          </div>';
        }
 
        if($this->_datos=='r')  echo $tablaHtml;
        else    return $tablaHtml;
        
    }   
}
?>