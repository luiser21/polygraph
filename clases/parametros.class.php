
<?php

/**
 * Index
 * 
 * @package carLub
 * @author Javier Ardila
 * Clase dependientede crearHtml.class.php
 * @copyright 2017
 * @version 0.1
 * @access public
 */
class parametros extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR TABLA CLIENTES TERCERIZADOS';
    public $_subTitulo = 'Crear Parametros';
    public $_datos = '';
    public $Table = 'autorizaciones';
    public $PrimaryKey = 'idautorizacion';
    
    
    
   /**
    * Index::Contenido()
    * Crea primer formulario de interfaz visual para el usuario.
    * 
    * @return Html con contenido de formulario
    */
   function Contenido(){



        
        return '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administrar Parametros</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">PARAMETROS</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form" enctype="multipart/form-data" method="post">
                                    <div class="form-group">
                                        <label for="nombre">Cliente Tercerizado:</label>
                                        '.
                                        
                                        $this->create_input('text','clientetercerizado','clientetercerizado','Nombre de la Empresa',false,'form-control required').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>                                  

                                   <div class="form-group">
                                        <label for="id_cursos">Titulo Autorizacion:</label>
                                        '. $this->create_input('text','nombre','nombre','Titulo Autorizacion',false,'form-control').'
                                        
                                    </div>
                                      <div class="form-group">
                                        <label for="id_cursos">Politicas:</label>                                        
                                         <textarea name="politicas" id="politicas" class="form-control" placeholder="Describe la politicas..."></textarea> 
                                        
                                    </div>                       
                                       <div class="form-group">
    							         <label for="id_cursos">Logo Empresa:</label>						   
    							     	<input type="file" class="form-control" accept="image/jpg" id="logo" name="logo" onchange="control(this)">
    							    </div>  
                                    <button type="button" id="guardarCurso" class="btn btn-primary">Guardar Parametro</button>
                                    <div id="Resultado" style="display:none">RESULTADO</div>
                                </form>
                            </div>
                        </div>
                    </div> '.$this->tablaDatos().'
                    
                        </div>
                    </div>
                </div>                    

        </section>  ';    
        
    }
    
    function guardarDatos(){
       // $this->imprimir($_FILES);
       // $this->imprimir($_POST);exit;
        try{
            $_respuesta="";
            $filename='';
            if($_FILES["logo"]["name"]) {                
                $filename = $_FILES["logo"]["name"];
                $source = $_FILES["logo"]["tmp_name"];
                
                $filename=str_replace(" ", '', $filename);
                $filename=str_replace("Ñ", '', $filename);
                $filename=str_replace("Ñ", 'N', $filename);
                $filename=str_replace("ñ", 'n', $filename);
                $filename=str_replace("-", '', $filename);
                $filename=str_replace("/", '', $filename);               
                
                $directorio = 'imagenes/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                
                if(move_uploaded_file($source, $target_path)) {
                    $_respuesta.="Se cargo Imagen exitosamente. <br> ";
                    
                }else {
                    $_respuesta.= 'Ha ocurrido un error al intentar subir la imagen.<br>';
                   
                }
            }
            if($_POST['idautorizacion']==0){
                $sql="INSERT INTO autorizaciones (
                        nombre,
                        politicas,
                        clientetercerizado,
                        logo                    
                        )
                        VALUES ('".$_POST['nombre']."', '".$_POST['politicas']."','".$_POST['clientetercerizado']."','imagenes/".$filename."')";
                
                $this->QuerySql($sql);
            }else{
                $sql="UPDATE autorizaciones set
                        nombre='".$_POST['nombre']."',
                        politicas='".$_POST['politicas']."',
                        clientetercerizado='".$_POST['clientetercerizado']."' ";
                if($filename!=""){
                     $sql.=" ,logo='imagenes/".$filename."' ";
                }   
                $sql.=" WHERE 
                        idautorizacion=".$_POST['idautorizacion'];
                $this->QuerySql($sql);
                
            }
        
            $_respuesta.= 'OK Se guardo la informacion exitosamente';
        }
        catch (exception $e) {
            $_respuesta =  $e->getMessage();
        }
        
        echo $_respuesta;
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    /**
     * Index::runEliminar()
     * Realiza eliminar Logico de la tabla parametrizada en los objetos globales 
     * @return void
     */
    function runEliminar(){
        $sql = "UPDATE ".$this->Table ." SET estado ='I' WHERE ".$this->PrimaryKey." = ".$this->_datos;
        $this->QuerySql($sql);
        //$_respuesta = array('Codigo' => 1, "Mensaje" => 'Se ha eliminado el item con &eacute;xito');
        echo 'Se ha eliminado el item con &eacute;xito';
    }
    
    function fn_editar(){
        
    }
    
    /**
     * Index::getDatos()
     * Extrae todos los datos y los retorna como Json, creada para llenar formularios en el editar de cada interfaz 
     * @return void
     */
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    /**
     * Index::_mostrar()
     * Muestra los datos armados atravez de 3 metodos $this->Cabecera(); $this->contenido(); $this->Pata();  
     * @return void
     */
    function _mostrar(){
        $html = $this->Cabecera();
        $html .= $this->contenido();
        $html .= $this->Pata();
        echo $html;
    }
    
    /**
     * Index::tablaDatos()
     * Muestra listado de datos en las interfaces de usuario 
     * @return Tabla con contenido HTML (Lista de datos)
     */
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $imagen = $this->Imagenes($this->PrimaryKey,12);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $sql = "SELECT L.clientetercerizado,".$imagen.",L.nombre,".$editar.",".$eliminar." FROM ".$this->Table." L where estado='A'";
        
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
    		$tablaHtml .= $this->print_table($_array_formu, 5, true, 'table table-striped table-bordered',"id='tablaDatos'");
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