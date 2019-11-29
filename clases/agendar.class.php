<?php
class Plantas extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR AGENDAMIENTOS';
    public $_subTitulo = 'Crear Solicitudes';
    public $_datos = '';
    public $Table = 'evaluado';
    public $PrimaryKey = 'id_evaluado';
    
    
    
   function Contenido(){
       
       if(isset($_GET['liberar'])){
		   $sql = "UPDATE cupo_fechas SET estado='LIBRE' WHERE id_cupo_fecha=".$_GET['liberar'];
		   $this->QuerySql($sql);
	   }
       
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
            
            <div class="col-md-8 ">
                          

                    </div> '.$this->tablaDatos().'
                    
                        </div>
                    </div>
                </div>                    

        </section>  '; 
        return $html;
        
    }
    
    function guardarDatos(){
        //$this->imprimir($_POST);exit; 
        //$this->imprimir($_SESSION['id_usuario']);
        try {
        $sql="INSERT INTO candidatos (
                NOMBRES,
                APELLIDOS, 
                TIPODOCUMENTO,
                DOCUMENTO, 
                LUGAREXPEDICION,
                EMAIL, 
                TELEFONO, 
                IDSOLICITANTE) 
                VALUES ('".$_POST['NOMBRES']."', '".$_POST['APELLIDOS']."', ".$_POST['id_tipo'].", ".$_POST['DOCUMENTO'].", '".$_POST['LUGAREXPEDICION']."', '".$_POST['EMAIL']."', ".$_POST['TELEFONO'].", ".$_SESSION['id_usuario'].") ";
        $this->QuerySql($sql);
        
        
        $sql="SELECT @@identity AS id";
        $datos = $this->Consulta($sql,1); 

        
        $sql="INSERT INTO evaluado (
                id_tipo_prueba, 
                id_candidato,
                estado,
                resultado,
                id_usuario,
                cargo,
                clientefinal) 
                VALUES (".$_POST['id_prueba'].", ".$datos[0]['id'].", '1', '0',".$_SESSION['id_usuario'].",'".$_POST['cargo']."','".$_POST['clientefinal']."')";     
       
        $this->QuerySql($sql);
        
        $sql="SELECT @@identity AS id";
        $datos2 = $this->Consulta($sql,1); 
        
        $sql="SELECT u.id_usuario,a.idautorizacion,a.clientetercerizado FROM usuarios U
                INNER JOIN usuarios_parametros UP ON UP.id_usuario=U.id_usuario
                INNER JOIN autorizaciones A on A.idautorizacion=UP.clientercerizados
                where u.id_usuario=".$_SESSION['id_usuario'];
        $datos3 = $this->Consulta($sql,1); 
        
        $sql="INSERT INTO autorizacion_evaluado (
                idcandidato,
                idautorizacion,
                idevaluado,
                estado)
                VALUES (".$datos[0]['id'].", ".$datos3[0]['idautorizacion'].",".$datos2[0]['id'].",'P')";
        
        $this->QuerySql($sql);
        
        $_respuesta = 'OK Se ha creado la Solicitud';
        }
        catch (exception $e) {
            $_respuesta =  $e->getMessage();
        }
        
        echo $_respuesta;
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
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
      //  $eliminar = $this->Imagenes($this->PrimaryKey,1);
// Produce: You should eat pizza, beer, and ice cream every day

$healthy = array("Monday", "Tuesday", "Wednesday","Thursday","Friday","Saturday","Sunday");
$yummy   = array("Lunes", "Martes", "Miercoles","Jueves","Viernes","Sabado","Domingo");   
//$newphrase = str_replace($healthy, $yummy, $phrase);    

	   $sql="SELECT cp.cupo_hora,id_cupo_hora
				FROM cupo_hora cp
				WHERE activo=1
				GROUP BY cupo_hora";        
     
        $datos = $this->Consulta($sql,1); 
		
		for($i=0;$i<count($datos);$i++){
			
			$sql2="SELECT DATE_FORMAT(fecha, '%W, %e %b') as fecha,estado,id_cupo_fecha
					FROM cupo_fechas
					where activo=1 and id_cupo_hora=".$datos[$i]['id_cupo_hora'];      
			$datos2 = $this->Consulta($sql2,1);
			foreach($datos2 as $value2){
				$value2['fecha'] = str_replace($healthy, $yummy, $value2['fecha']);   
				if($value2['estado']=='LIBRE'){
					$datos[$i][$value2['fecha']]='<button type="button" id="tomarcupo"  ONCLICK=javascript:fn_tomarcupo('.$value2['id_cupo_fecha'].'); class="btn btn-success">'.$value2['estado'].'</button>';
				}
				if($value2['estado']=='TOMADO'){
					$datos[$i][$value2['fecha']]='<button type="button" id="tomarcupo"  class="btn btn-danger">'.$value2['estado'].'</button>';
				}
				if($value2['estado']=='BLOQUEADO'){
					$datos[$i][$value2['fecha']]='<button type="button" id="tomarcupo"  class="btn btn-warning">'.$value2['estado'].'</button>';
				}
			}
			unset($datos[$i]['id_cupo_hora']);
		}
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
    		$tablaHtml .= $this->print_table($_array_formu, 4, true, 'table table-striped table-bordered',"id='tablaDatos'");
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