<?php
class duplicarEquipos extends crearHtml{
   
   
   /**
    * DUPLICA COMPONENTES =>
    * DUPLICA MENCANIMOS DE CADA COMPONENTE
    * DUPLICA PROGRAMACION DE CADA MECANISMO
   */ 
    public $_titulo = 'DUPLICAR EQUIPOS';
    public $_subTitulo = 'Al duplicar un equipo este llevara cosigo toda su configuraci&oacute;n (Componente=>Mecanismo=>Programaci&oacute;n)';
    public $_datos = '';
    public $Table = 'equipos';
    public $PrimaryKey = 'id_equipos';
    
    
    
   function Contenido(){
    $sql = 'SELECT id_planta codigo, descripcion from plantas WHERE activo = 1';
    $arrPlantas = $this->Consulta($sql);
    
    
    $sql = "SELECT
              E.`id_equipos` codigo,
              CONCAT(
                P.`descripcion`,
                ' -- ',
                S.`descripcion`,
                ' -- ',
                E.`descripcion`
              ) descripcion
            FROM
              `equipos` E
            INNER JOIN
              secciones S ON S.id_secciones = E.`id_secciones`
            INNER JOIN
              plantas P ON P.id_planta = S.id_planta
            WHERE
              E.activo = 1 AND E.`id_equipos` NOT IN(
              SELECT
                C.id_equipos
              FROM
                componentes C
              WHERE
                activo = 1
            )";
    $arrEquipoDestino = $this->Consulta($sql);
        
        $html= '<section class="main-content-wrapper">
            <div class="pageheader">
                <h1>'.$this->_titulo.'</h1>
                <p class="description">'.$this->_subTitulo.'</p>
                <div class="breadcrumb-wrapper hidden-xs">
                    <span class="label">Estas Aqu&iacute;:</span>
                    <ol class="breadcrumb">
                        <li class="active">Administraci&oacute;n => Duplicar Equipos</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-8">
                        <div class="panel panel-default panelCrear">
                            <div class="panel-heading">
                                <h3 class="panel-title">EQUIPOS</h3>
                                <div class="actions pull-right">
                                    <i class="fa fa-expand"></i>
                                    <i class="fa fa-chevron-down"></i>
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="formCrear" role="form" enctype="multipart/form-data">
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Planta:</label>
                                        '.$this->crearSelect('id_planta','id_planta',$arrPlantas,false,false,false,'class="form-control" onchange="traerCombo(this.value,\'combo_id_secciones\',\'comboSeccion\')"').'
                                        
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Seccion:</label>
                                        <span id="combo_id_secciones"> -- </span>
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_cursos">Equipo Origen:</label>
                                        <span id="combo_id_equipos"> -- </span>
                                        
                                        
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="nombre">Nombre Equipo Destino:</label>
                                        '.
                                        $this->crearSelect('equipo_origen','equipo_origen',$arrEquipoDestino,false,false,false,'class="form-control"').
                                        $this->create_input('hidden',$this->PrimaryKey,$this->PrimaryKey,false,'0').
                                        $this->create_input('hidden','id_usuario','id_usuario',false,$_SESSION['id_usuario']).
                                        '
                                        
                                    </div>'; 
                                    if(	$_SESSION["tipo_usuario"]<>3){
                                         $html.='<button type="button" id="guardarCurso" class="btn btn-primary">Duplicar Equipo</button>';
                                    }
                                    $html.='<div class="panel" id="Resultado" style="display:none">RESULTADO</div>
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
    
    function comboSeccion(){
        $sql = 'SELECT `id_secciones` codigo, descripcion FROM `secciones` WHERE `id_planta` = '.$this->_datos.' and activo = 1';
        $arr = $this->Consulta($sql);
        echo $this->crearSelect('id_secciones','id_secciones',$arr,false,false,false,'class="form-control" onchange="traerCombo(this.value,\'combo_id_equipos\',\'comboEquipos\')"');
    }
    function comboEquipos(){
        $sql = 'SELECT `id_equipos` codigo, `descripcion` FROM `equipos` WHERE id_secciones = '.$this->_datos;
        $arrEquipos= $this->Consulta($sql);
        echo $this->crearSelect('id_equipos_origen','id_equipos_origen',$arrEquipos,false,false,false,'class="form-control"');
    }    
    
    /**
     * duplicarEquipos::getComponentes()
     * Obtiene los componentes que se deben duplicar para un equipo
     * @param number $equipo id_equipo
     * @return array()
     */
    function getComponentes($equipo){
        $sql = "SELECT
                    id_componentes,
                    '".$this->_datos['equipo_origen']."' id_destino,
                    `descripcion`,
                    `codigo_empresa`,
                    `consecutivo`,
                    `id_fabricante`,
                    `tempmaxima`,
                    `activo`
                FROM
                    componentes
                WHERE
                    id_equipos = ".$this->_datos['id_equipos_origen'];            
        return $this->Consulta($sql);
    }
    

    /**
     * duplicarEquipos::insertaComponentes()
     * Ingresa en la base de datos la información del componente
     * @param mixed $data array con data a guardar
     * @return void
     */
    function insertaComponentes($data){
        $sqlComponentes = "INSERT
                            INTO
                              `componentes`(
                                `id_equipos`,
                                `descripcion`,
                                `codigo_empresa`,
                                `consecutivo`,
                                `id_fabricante`,
                                `tempmaxima`,
                                `activo`
                              ) 
                              VALUES (
                              '".$data['id_destino']."',
                              '".$data['descripcion']."',
                              '".$data['codigo_empresa']."',
                              '".$data['consecutivo']."',
                              '".$data['id_fabricante']."',
                              '".$data['tempmaxima']."',
                              '".$data['activo']."')
                              ";
        $this->QuerySql($sqlComponentes);                                      
    }
    /**
     * duplicarEquipos::dulplicarComponente()
     * Duplica componentes a partir de un equipo Obtiene e ingresa información de la tabla componentes
     * @param mixed $equipo <b> Id del equipo que se va a duplicar
     * @return void
     */
    function dulplicarComponente($equipo){
        $arrComponentes = $this->getComponentes($equipo);
        foreach($arrComponentes as $Componentes){
            $this->insertaComponentes($Componentes);
            $this->duplicarMecanismos( $Componentes['id_componentes'], $this->lastInsertId );
        }    
    }
    
    /**
     * duplicarEquipos::insertaMecanismos()
     * 
     * @param array $data Arreglo del componente origen con todos los campos para insert
     * @param number $idComponente para insertar el idComponente destino 
     * @return void
     */
    function insertaMecanismos( $data ){
        $sqlmecanismos = "
        INSERT
        INTO
          `mecanismos`(
            `codigoempresa`,
            `id_componente`,
            `descripcion`,
             `consecutivo`,
            `tempoperacion`
          )
        VALUES
        (
         '".$data['codigoempresa']."',
         '".$data['comp_destino']."',
         '".$data['descripcion']."',
         '".$data['consecutivo']."',
         '".$data['tempoperacion']."')
        ";
        $this->QuerySql($sqlmecanismos);   
    }
    
    /**
     * duplicarEquipos::getMecanismos()
     * Obtiene los mecanismos de un componente
     * @param number $idComponente idComponente del equipo origen
     * @return void
     */
    function getMecanismos($idComponente, $idComponenteDestino){
        $sql = "
            SELECT
              `id_mecanismos`,
              '".$idComponenteDestino."' comp_destino,
              `codigoempresa`,
              `id_componente`,
              `descripcion`,
               `consecutivo`,
              `tempoperacion`
            FROM
              `mecanismos`
            WHERE
              `id_componente` = ".$idComponente."
            ";
            return $this->Consulta($sql);
    }
    
    /**
     * duplicarEquipos::insertaMecMet()
     * 
     * @param array $data arreglo con las posiciones de cada campo de la tabla mec_met para insert
     * @param number $idMecanismo idMecanisco que usara el insert en la tabla mec_met
     * @return void
     */
    function insertaMecMet($data){
                $sqlMecMet = "INSERT
                            INTO `mec_met`(
                                `id_mecanismos`,
                                  `id_metodos`,
                                  `id_tareas`,
                                  `id_frecuencias`,
                                  `id_aplicacion`,
                                  `minutos_ejecucion`,
                                  `puntos`,
                                  `id_unidad_cant`,
                                  `id_simbologia`,
                                  `cod_lubricante`,
                                  `observaciones`,
                                  `ultima_fecha_ejec`,
                                  `proxima_fecha_ejec`,
                                  `horas_acum_ult_prog`,
                                  `horas_acum_prox_prog`,
                                  `indnivel`,
                                  `indnivel_Diametro`,
                                  `indnivel_Longitud`,
                                  `tuboventeo`,
                                  `valvuladrenaje`,
                                  `rotulolubaceite`,
                                  `indtemp`,
                                  `valvulatomamuestra`,
                                  `valvulafiltracionaceite`,
                                  `grasera`,
                                  `tipograsera`,
                                  `protectorplastico`,
                                  `rotulolubgrasa`,
                                  `tapondrenaje`,
                                  `cantidad`,
                                  `fecha_registro`,
                                  `id_usuario`,
                                  `id_migracion`,
                                  `dias_ult`,
                                  `dias_prox`
                              ) 
                              VALUES (
                                  '".$data['mec_destino']."',
                                  '".$data['id_metodos']."',
                                  '".$data['id_tareas']."',
                                  '".$data['id_frecuencias']."',
                                  '".$data['id_aplicacion']."',
                                  '".$data['minutos_ejecucion']."',
                                  '".$data['puntos']."',
                                  '".$data['id_unidad_cant']."',
                                  '".$data['id_simbologia']."',
                                  '".$data['cod_lubricante']."',
                                  '".$data['observaciones']."',
                                  '".$data['ultima_fecha_ejec']."',
                                  '".$data['proxima_fecha_ejec']."',
                                  '".$data['horas_acum_ult_prog']."',
                                  '".$data['horas_acum_prox_prog']."',
                                  '".$data['indnivel']."',
                                  '".$data['indnivel_Diametro']."',
                                  '".$data['indnivel_Longitud']."',
                                  '".$data['tuboventeo']."',
                                  '".$data['valvuladrenaje']."',
                                  '".$data['rotulolubaceite']."',
                                  '".$data['indtemp']."',
                                  '".$data['valvulatomamuestra']."',
                                  '".$data['valvulafiltracionaceite']."',
                                  '".$data['grasera']."',
                                  '".$data['tipograsera']."',
                                  '".$data['protectorplastico']."',
                                  '".$data['rotulolubgrasa']."',
                                  '".$data['tapondrenaje']."',
                                  '".$data['cantidad']."',
                                  '".$data['fecha_registro']."',
                                  '".$data['id_usuario']."',
                                  '".$data['id_migracion']."',
                                  '".$data['dias_ult']."',
                                  '".$data['dias_prox']."')
                              ";
        $this->QuerySql($sqlMecMet);
    }
        
    /**
     * duplicarEquipos::getMecMet()
     *  Extrae la informacion de la tabla mec_met apartir del idMecanismo
     * @param number $idMecanismo
     * @return
     */
    function getMecMet($idMecanismo, $idMecanismodestino){
        $sql = "
        SELECT 
          '".$idMecanismodestino."' mec_destino,
          MM.`id_metodos`,
          MM.`id_tareas`,
          MM.`id_frecuencias`,
          MM.`id_aplicacion`,
          MM.`minutos_ejecucion`,
          MM.`puntos`,
          MM.`id_unidad_cant`,
          MM.`id_simbologia`,
          MM.`cod_lubricante`,
          MM.`observaciones`,
          MM.`ultima_fecha_ejec`,
          MM.`proxima_fecha_ejec`,
          MM.`horas_acum_ult_prog`,
          MM.`horas_acum_prox_prog`,
          MM.`indnivel`,
          MM.`indnivel_Diametro`,
          MM.`indnivel_Longitud`,
          MM.`tuboventeo`,
          MM.`valvuladrenaje`,
          MM.`rotulolubaceite`,
          MM.`indtemp`,
          MM.`valvulatomamuestra`,
          MM.`valvulafiltracionaceite`,
          MM.`grasera`,
          MM.`tipograsera`,
          MM.`protectorplastico`,
          MM.`rotulolubgrasa`,
          MM.`tapondrenaje`,
          MM.`cantidad`,
          MM.`fecha_registro`,
          MM.`id_usuario`,
          MM.`id_migracion`,
          MM.`dias_ult`,
          MM.`dias_prox`
        FROM
         mec_met AS MM
         WHERE MM.id_mecanismos = ".$idMecanismo;
  
  return $this->Consulta($sql);
    }
    /**
     * duplicarEquipos::duplicarMecanismos()
     * Duplica el equipo a partir del id_componente
     * @param number $idComponenteAntiguo id_componente del equipo origen
     * @param number $idComponenteNuevo id_componente del equipo nuevo
     * @return void
     */
    function duplicarMecanismos( $idComponenteAntiguo , $idComponenteNuevo ){
        
        
        $arrMecanismos = $this->getMecanismos($idComponenteAntiguo, $idComponenteNuevo);
        foreach($arrMecanismos as $Mecanismos){
            $this->insertaMecanismos( $Mecanismos);
            $this->duplicarMecMet( $Mecanismos['id_mecanismos'] , $this->lastInsertId);
        }        
    }
    
    /**
     * duplicarEquipos::duplicarMecMet()
     * 
     * @param mixed $idMecanismoAntiguo idMecanismo del equipo origen para ser duplicado al equipo destino
     * @param mixed $idMecanismoNuevo idMecanismo que se va a inserta en la nueva programacion (mec_met)
     * @return void
     */
    function duplicarMecMet($idMecanismoAntiguo, $idMecanismoNuevo){
        $arrMecMet = $this->getMecMet($idMecanismoAntiguo, $idMecanismoNuevo);
        foreach($arrMecMet as $MecMet){
            $this->insertaMecMet( $MecMet);
        } 
        
    }
    
    function guardarDatos(){
         $this->dulplicarComponente($this->_datos['equipo_origen']);      
    }

    function fn_guardar(){
        $this->runActualizar();
    }
    
    function runEliminar(){
        $sql = 'DELETE FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos;
        $this->QuerySql($sql);
        
        $sql = 'DELETE FROM mec_met WHERE id_mec_met IN(SELECT MM.`id_mec_met` FROM `mec_met` MM INNER JOIN mecanismos M ON M.id_mecanismos = MM.id_mecanismos INNER JOIN componentes C ON C.id_componentes = M.id_componentes INNER JOIN equipos E ON E.id_equipos = C.id_equipos WHERE E.id_equipos = '.$this->_datos.')';
        $sql = 'DELETE FROM MECANISMOS WHERE id_mecanismos IN (SELECT  M.id_mecanismos FROM  mecanismos M INNER JOIN componentes C ON C.id_componentes = M.id_componentes INNER JOIN equipos E ON E.id_equipos = C.id_equipos WHERE E.id_equipos = '.$this->_datos.')';
        $sql = 'DELETE FROM COMPONENTES WHERE id_equipos = '.$this->_datos;
        $this->QuerySql($sql);
        //$_respuesta = array('Codigo' => 1, "Mensaje" => 'Se ha eliminado el item con &eacute;xito');
        echo 'Se ha eliminado el item con &eacute;xito';
    }
    
    function fn_editar(){
        
    }
    
    function getDatos(){
        $res = $this->Consulta('SELECT * FROM '.$this->Table .' WHERE '.$this->PrimaryKey.' = '.$this->_datos);
        print_r( json_encode( $res[0] ) );
    }
    
    function _mostrar(){
        $html = $this->Cabecera();
        $html .= $this->contenido();
        $html .= $this->Pata();
        echo $html;
    }
    
    function tablaDatos(){

        $editar = $this->Imagenes($this->PrimaryKey,0);
        $eliminar = $this->Imagenes($this->PrimaryKey,1);
        $carta = $this->Imagenes($this->PrimaryKey,4,'vistaImprimir.php'); 
       
     $verProgramacion = <<<OE
         
        CONCAT(  '<div class="fa fa-reorder" style="cursor:pointer" title="Ver Programacion" ONCLICK=javascript:irProgramacionEquipos(',  `$this->PrimaryKey` ,  '); />' ) Ver_Programacion
        
OE;
$sql = 'SELECT
                	p.descripcion AS planta,
                	s.descripcion as Seccion,
                    e.descripcion AS Equipo,
                    e.`codigo_carta`,
                    '.$verProgramacion.','.$editar.','.$eliminar.','.$carta.' 
                FROM
                	equipos e
                INNER JOIN secciones s on s.id_secciones = e.id_secciones
                INNER JOIN plantas p ON p.id_planta = s.id_planta
                WHERE e.activo = 1';
        
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
            
    		$tablaHtml .= $this->print_table($_array_formu, 7, true, 'table table-striped table-bordered',"id='tablaDatos'");
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