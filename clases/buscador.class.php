<?php
class Plantas extends crearHtml{
    
    public $_titulo = 'ADMINISTRAR AUTORIZACIONES';
    public $_subTitulo = 'Buscar autorizacion';
    public $_datos = '';
    public $Table = 'agenda';
    public $PrimaryKey = 'id_agenda';
    
  
   function Contenido(){
       
 
         $html='<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aquí:</span>
                    <ol class="breadcrumb">
                        <li class="active">Buscar Autorizacion</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                          <div class="panel panel-default panelCrear">
                             <div class="panel-heading">
                                <h3 class="panel-title">Buscador</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form">
                                   <div class="form-group">
                                        <label for="id_cursos">Digite Numero de Cedula:</label>
                                        '.$this->create_input('text','cedula','cedula','Documento de identidad',false,'form-control required').'                                        
                                    </div>
                                    <button type="button" id="guardarCurso" class="btn btn-primary">Buscar Autorizacion</button>
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
        try{
            //$this->imprimir($_POST);exit; 
            $sql = "SELECT ae.idautorcandidato,a.idautorizacion,a.nombre as nombre_autorizacion,a.politicas,a.clientetercerizado,e.cargo,e.clientefinal,C.DOCUMENTO as CEDULA,
                    CONCAT(c.NOMBRES, ' ', c.APELLIDOS) AS EVALUADO,C.CELULAR,t.NOMBRE as tipo_prueba,c.LUGAREXPEDICION,a.logo
                    FROM autorizaciones a
                    INNER JOIN autorizacion_evaluado ae ON ae.idautorizacion=a.idautorizacion
                    INNER JOIN evaluado E ON e.id_candidato=ae.idcandidato
                    INNER JOIN candidatos C ON C.ID=E.id_candidato
                    INNER JOIN tipo_prueba t ON t.ID_PRUEBA=e.id_tipo_prueba
                    WHERE a.estado='A' and ae.estado='P' and C.DOCUMENTO=".trim($_POST['cedula']);
            $datos = $this->Consulta($sql);
            if(count($datos)){               
            ?>
                <script>
                window.location.replace("autorizacion.php?cedula=<?php echo trim($_POST['cedula']) ?>");
                </script>
              <?php   
              exit;
            }else{
                echo $_respuesta= 'No se encontro registro para autorizar';
            }
            
          
        }
        catch (exception $e) {
          echo   $_respuesta =  $e->getMessage();
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