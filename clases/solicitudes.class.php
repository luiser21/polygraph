<?php
class Plantas extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR SOLICITUDES';
    public $_subTitulo = 'Listar Solicitudes';
    public $_datos = '';
    public $Table = 'evaluado';
    public $PrimaryKey = 'id_evaluado';
    
    
    
   function Contenido(){
       
     
         $html='<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'. $this->NombreUsuario.' '. $this->ApellidoUsuario.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">SAI Poligraf&iacute;as <p><a href="http://saipolygraph.com" target="_blank" ><strong style="font-size:13px;color:#EE1414;"> www.saipolygraph.com </strong></a></li>
                  
                    </ol>
                </div>
            </div>
         
               <div class="col-md-8">
                      
                           
                        </div>
                    </div> '.$this->tablaDatos().'
                    
                        </div>
                    </div>
                </div>                   

        </section>  '; 
        return $html;
        
    }
    
    function guardarDatos(){
       
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        
		try{
			
			
			$sql = 'SELECT estado,id_candidato,id_cupo_fecha FROM evaluado where id_evaluado='.$this->_datos;
			$evaluado = $this->Consulta($sql);
			//print_r($evaluado);
			if($evaluado[0]['estado']=='2' || $evaluado[0]['estado']=='8'){
				  $sql = 'DELETE FROM evaluado  where id_evaluado='.$this->_datos;
				  $this->QuerySql($sql);			

				  $sql = 'DELETE FROM autorizacion_evaluado where idcandidato='.$evaluado[0]['id_candidato'];
				  $this->QuerySql($sql);

				  $sql = "UPDATE  cupo_fechas set estado='SALA1' where id_cupo_fecha=".$evaluado[0]['id_cupo_fecha'];
				  $this->QuerySql($sql);	
				  
				  $sql = 'DELETE FROM candidatos  where id_candidatos='.$evaluado[0]['id_candidato'];
				  $this->QuerySql($sql);
				  
				 $_respuesta = array('Codigo' => 99, "Mensaje" => 'Registro Eliminado con exito');				  
				 // print_r(json_encode($_respuesta));	
				
			}else{
				 $_respuesta = array('Codigo' => 0, "Mensaje" => 'No se Puede eliminar por favor comuniquese con el administrador');
				 print_r(json_encode($_respuesta));	
			}
		  
       
        }catch (exception $e) {			
			 $_respuesta = array('Codigo' => 0, "Mensaje" =>  $e->getMessage());
			 print_r(json_encode($_respuesta));	
		  
        }
       
    }
    
    function fn_editar(){
     
    }
    
    function getDatos(){
      
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' 
        WHERE '.$this->PrimaryKey.' = '.$this->_datos);
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
       $agendar = $this->Imagenes($this->PrimaryKey,14);
        //$editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,15);
      //  $eliminar = $this->Imagenes($this->PrimaryKey,1);
		
        $sql="SELECT
                $agendar,
                $eliminar,
                ea.nombre_estado_agenda AS ESTADO,
            	tp.NOMBRE AS PRUEBA,
				c.NOMBRES AS EVALUADO,
                c.DOCUMENTO AS CEDULA,             
            	CONCAT(DATE_FORMAT(fecha, '%e %b %Y'),' ',ch.cupo_hora) AS FECHA_AGENDADA,
            	e.cargo AS CARGO_ASPIRAR,	
                 em.NOMBRE AS CLIENTE_FINAL                                  
            FROM
            	evaluado e
            INNER JOIN candidatos c ON e.id_candidato = c.id_candidatos
            INNER JOIN tipo_prueba tp ON tp.ID_PRUEBA = e.id_tipo_prueba 
            INNER JOIN estados_agenda ea ON ea.id_estados=e.estado 
			INNER JOIN cupo_fechas cp on cp.id_cupo_fecha=e.id_cupo_fecha
			INNER JOIN cupo_hora ch on ch.id_cupo_hora=cp.id_cupo_hora
			INNER JOIN aliados em on em.id_aliado=e.clientefinal
			WHERE c.idsolicitante=".$_SESSION['id_usuario'];
        
     
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
    		$tablaHtml .= $this->print_table($_array_formu, 9, true, 'table table-striped table-bordered',"id='tablaDatos'");
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