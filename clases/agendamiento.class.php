<?php
class Plantas extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR AGENDAMIENTOS';
    public $_subTitulo = 'Crear Solicitudes';
    public $_datos = '';
    public $Table = 'agenda';
    public $PrimaryKey = 'id_agenda';
    
    
    
   function Contenido(){
       
       $sql = 'SELECT id_prueba codigo, nombre as descripcion from tipo_prueba WHERE estado = 1';
       $arrPlantas = $this->Consulta($sql);
       
       $sql = "SELECT id_tipo codigo, CONCAT(TIPO_DOC, ' ', DESCRIPCION) as descripcion from tipo_identificacion WHERE estado = 'A'";
       $arrTipos = $this->Consulta($sql);
       
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
                          <div class="panel panel-default panelCrear">
                             <div class="panel-heading">
                                <h3 class="panel-title">Agendamiento</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                    <div class="form-group">
                                        <label for="nombre">Tipo de Prueba:</label>
                                      
                                        '.$this->crearSelect('id_prueba','id_prueba',$arrPlantas,false,false,false,'class="form-control required"').'
                                        
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Nombres del Entrevistado:</label>
                                        '.$this->create_input('text','nombre','nombre','Nombre del Entrevistado',false,'form-control required','', 'onkeyup="javascript:this.value=this.value.toUpperCase();"').'
                                        
                                        
                                    </div>

                                     <div class="form-group">
                                        <label for="id_cursos">Apellidos del Entrevistado:</label>
                                        '.$this->create_input('text','apellido','apellido','Apellidos del Entrevistado',false,'form-control required','', 'onkeyup="javascript:this.value=this.value.toUpperCase();"').'
                                        
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                         <label for="nombre">Tipo Documento:</label>
                                      
                                        '.$this->crearSelect('id_tipo','id_tipo',$arrTipos,false,false,false,'class="form-control required"').'
                                        
                                    </div>                                    
                                    
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Numero de Identificacion:</label>
                                       '.$this->create_input('text','identificacion','identificacion','Numero de Identificacion',false,'form-control required').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Lugar de Expedicion:</label>
                                       '.$this->create_input('text','lugarexpedicion','lugarexpedicion','Lugar de Expedicion',false,'form-control required').'
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="id_cursos">Email:</label>
                                        '.$this->create_input('email','email','email','email',false,'form-control required').'
                                        
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Telefono Contacto:</label>
                                        '.$this->create_input('text','telefono','telefono','Telefono Contacto',false,'form-control required','','pattern="^[9|8|7|6]\d{8}$"').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Cargo Aspirar:</label>
                                        '.$this->create_input('text','cargo','cargo','Cargo Aspirar',false,'form-control required','', 'onkeyup="javascript:this.value=this.value.toUpperCase();"').'
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Cliente Final:</label>
                                        '.$this->create_input('text','clientefinal','clientefinal','Cliente Final',false,'form-control required','', 'onkeyup="javascript:this.value=this.value.toUpperCase();"').'
                                        
                                    </div>'; 
                                  
                                         $html.='<button type="button" id="guardarCurso" class="btn btn-primary">Guardar Solicitud</button>';
                                    
                                    $html.='<div id="Resultado" style="display:none">RESULTADO</div>
                                </form>
                            </div>
                        </div>

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
                VALUES ('".$_POST['nombre']."', '".$_POST['apellido']."', ".$_POST['id_tipo'].", ".$_POST['identificacion'].", '".$_POST['lugarexpedicion']."', '".$_POST['email']."', ".$_POST['telefono'].", ".$_SESSION['id_usuario'].") ";
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
              E.id,
                ea.nombre_estado_agenda AS ESTADO,
            	tp.NOMBRE AS TIPO_PRUEBA,
            	CONCAT(c.NOMBRES, ' ', c.APELLIDOS) AS EVALUADO,
                c.DOCUMENTO AS CEDULA,
                c.EMAIL,
                c.TELEFONO,
            	E.fecha_inicio AS FECHA,
            	E.cargo AS CARGO_ASPIRAR,	
                E.clientefinal AS CLIENTE_FINAL            	
            FROM
            	candidatos c
            INNER JOIN evaluado E ON E.id_candidato = c.ID
            INNER JOIN tipo_prueba tp ON tp.ID_PRUEBA = E.id_tipo_prueba 
            INNER JOIN estados_agenda ea ON ea.id_estados=E.estado
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