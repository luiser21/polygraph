/*
 
Creado Por Javier David Ardila B
2015
*/

$(document).on('ready',iniciar_scripts);
            
function iniciar_scripts(){

    
    $('#guardarCurso').on('click',fn_guarda);
    $('#guardarCursoPDF').on('click',fn_guardaPDF);
    $('#guardarCurso_autoriza').on('click',fn_guarda_autoriza);
    $('#limpiarForm').on('click',fn_limpiarForm);
    
    $('#guardarImagen').on('click',fn_guarda_imagen);
    $('#guardarMasivo').on('click',fn_guarda_masivo_lubricante);
    $('#guardarUsuarios2').on('click',fn_guardaUsuario2); 
    $('#guardaringreso').on('click',fn_guardaringreso);
    $('#guardarMecMet').on('click',fn_guardarMecMet);
    $('#guardarMecMetModal').on('click',fn_guardarMecMetModal);
    $('#guardaMecMet').on('click',fn_guardaMecMet);
    $('#descargarPlantilla').on('click',fn_generarPlantilla);
    $('#subirEmpresa').on('click',fn_subeEmpresa);
    $('#subirArchivo').on('click',fn_subeArchivo);
    
    $('#buscarMecanismo').on('click',fn_buscarMecanismo);
    $('#crearOt').on('click',fn_crearOt);
	$('#fn_tomarcupo').on('click',fn_tomarcupo);
    $('#verDetalleOt').on('click',fn_verDetalleOt);  
    $('#descargarDetalleOt').on('click',fn_descargarDetalleOt);
    $('#limpiarMecanismo').on('click',fn_limpiarMecanismo);
    //$( "#formuCompra" ).submit();
    
    $('#guardarPrincipal').on('click',fn_guardaCurso);
    //$('#Eid_cursos').on('change',fn_curso);
    
    $('#guardarCapitulo').on('click',fn_guardarCapitulo);
    $('#guardarForum').on('click',fn_guardaF);
        
    $('#irEvaluacion').on('click',fn_irEvaluacion);
    $('#terminar').on('click',fn_guardarEvaluacion);
    $('#irIniciar').on('click',fn_irIniciar);
    $('.irCompra').on('click',fn_irCompra);
    /* Omar */
    $('#guardarRecord').on('click',fn_guardaRecord);
	
	$('#registroUsuario').on('click',fn_record);
	$('#actualizarRecord').on('click',fn_account);
	$('#guardarPass').on('click',fn_Pass);
	$('#subirFoto').on('click',fn_subirFoto);
    $('.irCompra').on('click',fn_irCompra);
    $('#subirEnlace').on('click',fn_cargaEnlace);
     
    /* Calificaciones */
    $('#verTrabajos').on('click',fn_verTrabajos);
    $('#guardarCalificacion').on('click',fn_guardarCalificacion);
    $('#responderPregunta').on('click',fn_responderPregunta);
    $('#recordar').on('click',fn_recordar);      
   fn_keypress();
   //buscarTabla();

        
    //	fn_keypress();    
    //	timeAjax('div_loading');
    //	fn_clear();

  

}
    
    function buscarTabla(){
        
        $('#tablaDatos thead th').each( function () {
            var title = $(this).text();
            var title = $('#tablaDatos thead th').eq($(this).index()).text();
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
        }
    );
    
    table.columns().eq(0).each(function (colIdx) {
        $('input', table.column(colIdx).footer()).on('keyup change', function () {

            table
                .column(colIdx)
                .search(this.value)
                .draw();
        });
    });
    }
     
    /*
    Funcion creada para llamar ajax que trae los diferentes combos de seleccion
    @itemTraer hace referenica al id campo de la tabla maestra que queremos jalar 
    @valor el valor que esta enviando del combo
    */
    function traerCombo(valor,div,process){
        $.post(file,{ 'process':process, 'd':valor,},function(r){
            $('#'+div).html(r);
        });
    } 
    
    function traerempresas(valor,div,process){
        $.post('login.php',{ 'process':process, 'd':valor, },function(r){
            $('#'+div).html(r);
        });
    } 
    function traerCombo_equipo(valor,valor2,div,process){
        $.post(file,{ 'process':process, 'd':valor+'-'+valor2, },function(r){
            $('#'+div).html(r);
        });
    }
    
    function fn_generarPlantilla(){
        //$.post(file,{ 'process':'generarPlantilla', 'd':'1', },function(r){
//            $('#'+div).html(r);
//        });
alert('jj');
        var url = "equiposHorasMasivo.php?plantilla=1";
        window.location.href = url; 
	   //$(location).attr('href',url);        
    }
    function fn_descargarDetalleOt(){
        $( "#formCrear" ).submit();
    }
    
    function fn_limpiarForm(){
        window.location.reload();
    }
    
    function fn_registrarCompraGratis(){
        var idProducto = $('#idCurso').val();
        $.post('carro.php',{ 'process':'compraGratis', 'd':idProducto},function(r){
            $('#divAlerta').html(r);
        });
    }
    
        /*
    * habilitarCampo()
    * Habilita varios input atravez de su clase.. (editarOt.class.php)
    */
    function habilitarCampo(id){
        if($('.'+id).prop('disabled')){
            $('.'+id).prop('disabled', false);
        }else{
            $('.'+id).prop('disabled', true);
        }
    }
   /*
    * fn_guardaEdicion()
    * Habilita varios input atravez de su clase.. (editarOt.class.php)
    */
    function fn_guardaEdicion(){
        var datos = $('#formCrear').serializeArray();
        $.post(file,{ 'process':'guardarDatos', 'd':datos},function(r){
            $("#ResultadoEdicion").fadeIn(3000).html(r.Mensaje);
            if(r.Codigo==1){
                 $("#ResultadoEdicion").addClass("alert alert-danger");
            }else{
                $("#ResultadoEdicion").addClass("alert alert-success");
            }
        },'json');

    }
    
    function pre_cierreOt(){
        $("#preGuarda").fadeOut(1000);
        $("#divObservacionesFinal").fadeIn(3000);
    }
    
    function fn_guardaOt(){
        console.log('hey');
        var datos = $('#formCrear').serializeArray();
        $.post(file,{ 'process':'cerrarOt', 'd':datos},function(r){
            $("#ResultadoEdicion").fadeIn(3000).html(r.Mensaje);
            if(r.Codigo==1){
                 $("#ResultadoEdicion").addClass("alert alert-danger");
            }else{
                $("#ResultadoEdicion").addClass("alert alert-success");
            }
        },'json');
    }
    
    /*
    * fn_registrarCompra()
    * Registra la compra realizada
    */
    function fn_registrarCompraPayu(){
        var datos = $('#formEvaluacionCompra').serializeArray();
         //$( "#formuCompra" ).submit();
         $('#botoncomprar').html('Enviando...');
        $.post('carro.php',{ 'process':'registraCarro', 'd':'1'},function(r){
            $('#referenceCode').val(r.id);
            $('#signature').val(r.signature);
            console.log('id=> '+r.id);
            console.log('signature=> '+r.signature);
            //setTimeout(function(){ alert( $('#referenceCode').val() ) }, 1000)
            setTimeout(function(){ $( "#formuCompra" ).submit() }, 1000)
            
        },'json');
    }    
    
    
function fn_recordar(){
	window.open("login.php?uu=fr", "myWindow","status = 1, height = 600, width = 300, resizable = 1,scrollbars=1" );
}


function fn_guardarEvaluacion(){
    var datos = $('#formCalificacion').serializeArray();
    $.post(file,{ 'process':'guardarRespuestas', 'd':datos},function(r){
        $("#Resultado").html(r); 
    });
}

function fn_irEvaluacion(){
     $( "#formEvaluacion" ).submit();
}

function fn_irIniciar(){
    $( "#formMiEvaluacion" ).submit();
}

function fn_irCompra(){
    $( "#formEvaluacionCompra" ).submit();
}


function fn_volver(){
    window.history.back();
}

function tryAgain(){
    window.location = 'misCursos.php';
}
function miCuenta(){
    window.location ='account.php';
}



function fn_subirFoto(){
	window.open("clases/account_subirArchivo.class.php", "myWindow","status = 1, height = 100, width = 350, resizable = 1,scrollbars=1" );

}

function fn_Pass(){
	var datos = $('#formPass').serializeArray();
	var formData = new FormData(document.getElementById("formPass"));
	formData.append( "process", "guardarPass" );
	$.ajax({
                url: file,
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                  $("#ResultadoPass").fadeOut("slow");
                $("#ResultadoPass").fadeIn(3000).html(res);
                //    $("#Resultado").html("Respuesta: " + res);
                });

}

function fn_account(){    
    var datos = $('#formRecord').serializeArray();
    var formData = new FormData(document.getElementById("formRecord"));
    
            formData.append( "process", "guardarDatos" );
            formData.append( "d", '1' );
			//fotmData.append( "tipo_documento", $('#tipo_documento').val());
			//fotmData.append( "pais", $('#pais').val());
			//fotmData.append( "codigo_municipio", $('#codigo_municipio').val());
            
            $.ajax({
                url: file,
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                  $("#Resultado").fadeOut("slow");
                $("#Resultado").fadeIn(3000).html(res);
                //    $("#Resultado").html("Respuesta: " + res);
                });
}



function fn_record(){
	var url = "record.php"; 
	$(location).attr('href',url);				   							  				
}

function fn_guardaRecord(){    
    var datos = $('#formRecord').serializeArray();
    var formData = new FormData(document.getElementById("formRecord"));
       
            formData.append( "process", "guardarDatos" );
            formData.append( "d", '1' );
            
            $.ajax({
                url: file,
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                  $("#Resultado").fadeOut("slow");
                $("#Resultado").fadeIn(3000).html(res);
                //    $("#Resultado").html("Respuesta: " + res);
                });
}




function fn_guardaF(){

    var datos = $('#forum').serializeArray();
    
    $.post(file,{ 'process':'guardarDatos', 'd':datos},function(r){
        $("#Resultado").fadeOut("slow");
        $("#Resultado").fadeIn(3000).html(r);
		window.location.reload();       
        //recargaDatosF();
        
    });
}

function recargaDatosF(){
    $.post(file,{ 'process':'formulario', 'd':'r'},function(r){		
        $('#d_detalle_forum').html(r);
       // $('#d_detalle_forum').dataTable();
    });
}



function fn_guardaCurso(){
    
    var datos = $('#formCreaCurso').serializeArray();
    var formData = new FormData( document.getElementById( "formCreaCurso" ) );
            formData.append( "process", "guardarDatos" );
            formData.append( "d", '1' );
            
            $.ajax({
                url: file,
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                  $("#Resultado").fadeOut("slow");
                $("#Resultado").fadeIn(3000).html(res);
                //    $("#Resultado").html("Respuesta: " + res);
                });
}
   
   /*
    * function::fn_cargaEnlace();
    * Funcion llamada desde el archivo miEvaluacion.php, se encarga de enviar la informacion para guardar el enlace de carga del archivo  
    * Realiza el envio de un archivo para su posterior carga en ajax. 
    */ 
function fn_cargaEnlace(){
    
    var datos = $('#formSubeEvaluacion').serializeArray();
    $.post(file,{ 'process':'guardarEnlace', 'd':datos},function(r){
        $("#ResultadoTrabajo").fadeOut("slow");
        $("#ResultadoTrabajo").fadeIn(3000).html(r);        
    });
}

    function fn_subeArchivo(){
        var datos = $('#formCrear').serializeArray();
        var formData = new FormData( document.getElementById( "formCrear" ) );
                formData.append( "process", "registrarArchivos" );
                formData.append( "d", '1' );
                
                $.ajax({
                    url: file,
                    type: "post",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
    	     processData: false
                })
                    .done(function(r){
                    //$("#Resultado").fadeIn(3000).html(res);
                    $("#Resultado").fadeIn(3000).html(r.Mensaje);
                    if(r.Codigo == 99){
                        jQuery("#Resultado").addClass('alert alert-danger alert-dismissable');
                        return false;
                    }else{
                        jQuery("#Resultado").removeClass('alert alert-danger alert-dismissable');
                        jQuery("#Resultado").addClass('alert alert-success alert-dismissable');
                    }                    
                    //    $("#Resultado").html("Respuesta: " + res);
                    });
    }
    
function fn_subeEmpresa(){
        var datos = $('#formCrear').serializeArray();
        var formData = new FormData( document.getElementById( "formCrear" ) );
                formData.append( "process", "guardarDatos" );
                formData.append( "d", '1' );
                
                $.ajax({
                    url: file,
                    type: "post",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
    	     processData: false
                })
                    .done(function(r){
                    //$("#Resultado").fadeIn(3000).html(res);
                    $("#Resultado").fadeIn(3000).html(r.Mensaje);
                    if(r.Codigo == 99){
                        jQuery("#Resultado").addClass('alert alert-danger alert-dismissable');
                        return false;
                    }else{
                        jQuery("#Resultado").removeClass('alert alert-danger alert-dismissable');
                        jQuery("#Resultado").addClass('alert alert-success alert-dismissable');
                    }                    
                    //    $("#Resultado").html("Respuesta: " + res);
                    });
    }    

function fn_guardarCapitulo(){
    var contenido = CKEDITOR.instances['descripcionC'].getData();
    $('#descripcionCapitulo').val(contenido);
    CKEDITOR.instances.descripcionC.setData('');
    
    var datos = $('#formCreaCurso').serializeArray();
    $.post(file,{ 'process':'guardarDatos', 'd':datos},function(r){
        $("#Resultado").fadeOut("slow");
        $("#Resultado").fadeIn(3000).html(r);
        $('#formCreaCurso').find('input').val(''); 
        $('#formCreaCurso').find('textarea').val('');
        $('#formCreaCurso').find('select').val('');
    
        
    });
}




    /*
    * function::fn_subeTrabajo();
    * Funcion llamada desde el archivo miEvaluacion.php, 
    * Realiza el envio de un archivo para su posterior carga en ajax. 
    */


    function fn_guardaEquipos(){
        var datos = $('#formSubeEvaluacion').serializeArray();
        var formData = new FormData( document.getElementById( "formSubeEvaluacion" ) );
                formData.append( "process", "subirEvaluacion" );
                formData.append( "d", '1' );
                
                $.ajax({
                    url: file,
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
    	     processData: false
                })
                    .done(function(res){
                      $("#ResultadoTrabajo").fadeOut("slow");
                    $("#ResultadoTrabajo").fadeIn(3000).html(res);
                    //    $("#Resultado").html("Respuesta: " + res);
                    });
    }

/* Funcion estandar para guardar datos*/

function fn_guarda(){
	//alert(hola);
	 if(validar_all('required')){
		  var datos = $('#formCrear').serializeArray();
	      var formData = new FormData( document.getElementById( "formCrear" ) );
	              formData.append( "process", "guardarDatos" );
	              formData.append( "d", '1' );
	              
	              $.ajax({
	                  url: file,
	                  type: "post",
	                  dataType: "html",
	                  data: formData,
	                  cache: false,
	                  contentType: false,
	  	     processData: false
	              })
	                  .done(function(res){
	                  $("#Resultado").removeClass('alert alert-danger alert-dismissable');	                	
	                  $("#Resultado").fadeOut("slow");
	                  $("#Resultado").fadeIn(3000).html(res);
	                  $("#Resultado").addClass('alert alert-success alert-dismissable');
	                  $('#formCrear').find('select').val('');
	                  $('#formCrear').find('input').val('');
	                  recargaDatos('formCrear');	                  
	                  });
	  }else{
	        alert('Campos obligatorios');
	  }    
}


function fn_guardaPDF(){
	 if(validar_all('required')){
		 if(confirm("Confirma que leyo detenidamente dicha autorizacion!")){
			  var datos = $('#formCrear').serializeArray();
			  var cedula=$("#cedula").val();
			  var idautorcandidato=$("#idautorcandidato").val();;
		      var formData = new FormData( document.getElementById( "formCrear" ) );
		              formData.append( "process", "guardarDatos" );
		              formData.append( "d", '1' );
		              
		              $.ajax({
		                  url: file,
		                  type: "post",
		                  dataType: "html",
		                  data: formData,
		                  cache: false,
		                  contentType: false,
		  	     processData: false
		              })
		                  .done(function(res){
		                  $("#Resultado").removeClass('alert alert-danger alert-dismissable');	                	
		                  $("#Resultado").fadeOut("slow");
		                  $("#Resultado").fadeIn(3000).html(res);
		                  $("#Resultado").addClass('alert alert-success alert-dismissable');
		                  $('#formCrear').find('select').val('');
		                  $('#formCrear').find('input').val('');
		                  recargaDatos('formCrear');	
		                  ajaxpdf(cedula,idautorcandidato);
		                  })
		 }
	      //  window.open("pdf.php?cedula="+cedula+"&idautorcandidato="+idautorcandidato, '_parent');
	  }else{
	        alert('Campos obligatorios');
	  }    
}

function ajaxpdf(cedula,idautorcandidato) {
	$('#autorizacion').css('display','none');
	$('#resultadoajax').css('display','block');
	 $('#resultadoajax').html('<div align="center"><img src="img/loader.gif" alt="loading" width="200" height="150"  /><br/>Un momento por favor, generando pdf...</div>');
    $.ajax({
        url:   'pdf.php',
        type:  'get',
        data:	"cedula="+cedula+"&idautorcandidato="+idautorcandidato,
       
        success:  function (data) {   
        	//$("#resultadoajax").html("Documento Generado Exitosamente");
        	$('#resultadoajax').css('display','none');
        	$('#Resultado').fadeIn(1000).html("Documento Generado Exitosamente");
 
        }
    });
 
}

function fn_guarda_autoriza(){
	 if(validar_all('required')){
		  var datos = $('#formCrear').serializeArray();
	      var formData = new FormData( document.getElementById( "formCrear" ) );
	              formData.append( "process", "guardarDatos" );
	              formData.append( "d", '1' );
	              
	              $.ajax({
	                  url: file,
	                  type: "post",
	                  dataType: "html",
	                  data: formData,
	                  cache: false,
	                  contentType: false,
	  	     processData: false
	              })
	                  .done(function(res){
	                  $("#Resultado").removeClass('alert alert-danger alert-dismissable');	                	
	                  $("#Resultado").fadeOut("slow");
	                  $("#Resultado").fadeIn(3000).html(res);
	                  $("#Resultado").addClass('alert alert-success alert-dismissable');
	                  $('#formCrear').find('select').val('');
	                  $('#formCrear').find('input').val('');
	                  recargaDatos('formCrear');	                  
	                  });
	  }else{
	        alert('Campos obligatorios');
	  }    
}

function my_completion_handler(msg) {
	
	if (msg.match(/(http\:\/\/\S+)/)) {
		var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
		
		// Muestra la imagen en la pantalla
		document.getElementById('upload_results').innerHTML = 
			'<img src="' + image_url + '">'+
			//'<form action="gestion_foto.php" method="post">'+
			'<input type="hidden" name="id_foto" id="id_foto" value="' + image_url + '"  /><br/><br/>'+	
			'<button type="button" class="btn btn-primary" onClick="webcam.freeze()">Tomar foto</button>&nbsp;&nbsp;'		
			//'<button type="button" class="btn btn-primary" onClick="do_upload()">Subir</button>'		
		    //'<input type="submit" name="button" id="button" value="Enviar" class="btn btn-primary"/></form>'
			;
		// reset camera for another shot
		webcam.reset();
	}
	else alert("PHP Error: " + msg);
}
/* Funcion estandar para guardar datos*/

function fn_guardaMecMet(){
    var j = $("option:selected", '#id_metodos').text();
    if(validar_all('required')){
        $('.noSellado').prop('disabled', false);
        var datos = $('#formCrear').serializeArray();
        console.log(datos);
        $.post(file,{ 'process':'guardarDatos', 'd':datos},function(r){
            $("#Resultado").fadeOut("slow");
            $("#Resultado").fadeIn(3000).html(r.Mensaje);
            $('#formCrear').find('input[type=text]').val('');
            recargaDatos('formCrear');
            
        },'json');
        if(j == 'Sellado'){
            $('.noSellado').prop('disabled', true);
        }
    }else{
        alert('Campos obligatorios');
    }
}

function fn_guarda_imagen(){
    if(validar_all('required')){
        var datos = $('#formCrear').serializeArray();
        $.post(file,{ 'process':'guardarDatos', 'd':datos},function(r){
            $("#Resultado").fadeOut("slow");
            $("#Resultado").fadeIn(3000).html(r.Mensaje);
            $('#formCrear').find('select').val('');
            $('#formCrear').find('input').val('');
            recargaDatos();
            
        },'json');
    }else{
        alert('Campos obligatorios');
        return false;
    }
}

function control(f){
    var ext=['jpg','jpeg','png'];
    var v=f.value.split('.').pop().toLowerCase();
    for(var i=0,n;n=ext[i];i++){
        if(n.toLowerCase()==v)
            return
    }
    var t=f.cloneNode(true);
    t.value='';
    f.parentNode.replaceChild(t,f);
    alert('Extension no valida, solo se permiten imagenes tipo jpg');
}

function fn_guarda_masivo_lubricante(){
    if(validar_all('required')){
        var datos = $('#formCrear').serializeArray();
        $.post(file,{ 'process':'guardarDatos', 'd':datos},function(r){
            $("#Resultado").fadeOut("slow");
            $("#Resultado").fadeIn(3000).html(r.Mensaje);
            $('#formCrear').find('select').val('');           
            recargaDatos();
            
        },'json'); 
    }else{
        alert('Campos obligatorios');
    }
}

/*
CARLUB
para trabajar la busqueda de mecanismos que se van a agendar
*/

function fn_buscarMecanismo(){
    
    var datos = $('#formCrear').serializeArray();
    $.post(file,{ 'process':'buscarMecanismos', 'd':datos},function(r){

        $("#Resultado").fadeOut("slow");
        $("#Resultado").fadeIn(3000).html(r);
        
        
        
    });
}

function fn_guardarMecMet(id,url){
 
	  var datos = id;
	 $.post(file,{ 'process':'formularioMecMet', 'd':datos},function(r){
       
	 },'json');
	// document.getElementById("p1").innerHTML = "Muchas gracias!";
	 $("#divMecMet").modal({backdrop: "static"});
     $( '#id_metodos' ).focus(); 
     $('#evaluado').val(id);
}

function fn_guardarMecMetModal(){
    var datos = $('#formCrearMecMet').serializeArray();
    if(validar_all('required')){
	    $.post(file,{ 'process':'guardarMecMet', 'd':datos},function(r){    
	       
	        
	        if(r.Codigo==1){
	            $( "#id_metodos" ).focus(); 
	            $('#formCrearMecMet').find('.limpiar').val('');
	             
	            $('#formCrearMecMet').find('textarea').val('');
	            $('#formCrearMecMet').find('select').val('');
	            recargaDatos();
	        }
	        
	    },'json');
	    $("#ResultadoModal").fadeOut("slow");
	    $("#ResultadoModal").fadeIn(500).html('Datos Ingresados con &eacute;xito');
    }else{
        alert('Campos obligatorios');
        return false;
    }
    
    
}

function fn_limpiarMecanismo(){
    
    location.href = 'plantas.php';    
    //  $('#formCrear').find('.borrar').val('');
    //  $('#formCrear').find('#descripcion').focus();
}

function fn_crearOt(){
    //console.log('aqui');
    var datos = $('#formCrear').serializeArray();
    $.post(file,{ 'process':'crearOt', 'd':datos},function(r){

        $("#divCrearOt").fadeOut("slow");
        $("#divCrearOt").fadeIn(3000).html(r);
        
        
        
    });
}

function fn_tomarcupo(id_fecha){
    //console.log('aqui');
    location.href = 'agendamiento.php?id_fecha='+id_fecha;    
}


function fn_verDetalleOt(){
    $("#Resultado").html("Cargando...");
    
    var datos = $('#formCrear').serializeArray();
    $.post(file,{ 'process':'verDetalleOt', 'd':datos},function(r){
        $("#Resultado").fadeIn(3000).html(r);
        $('#tablaDetalle').dataTable();
        
        
        
    });
}

function irProgramacion(idProgramacion){
    location.href = 'mecMet.php?id='+idProgramacion;
}

function irProgramacionEquipos(idEquipo){
        location.href = 'mecMet.php?idE='+idEquipo;
} 

function fn_guardaUsuario2(){
    /*var datos = $('#formCrear').serializeArray();
    $.post(file,{ 'process':'guardarDatos', 'd':datos},function(r){
        $("#Resultado").fadeOut("slow");
        $('#formUsuario').find('input').val(''); 
        $('#formUsuario').find('textarea').val('');
        $('#formUsuario').find('select').val('');
        recargaDatos();
        
    });
    */
    var datos = $('#formCrear').serializeArray();
	var formData = new FormData(document.getElementById("formCrear"));
	formData.append( "process", "guardarDatos" );
	$.ajax({
                url: file,
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
                .done(function(res){
                  $("#Resultado").fadeOut("slow");
                $("#Resultado").fadeIn(3000).html(res);
                recargaDatos();
                //    $("#Resultado").html("Respuesta: " + res);
                });

}

function fn_guardaringreso(){
	var datos = $('#formCrear').serializeArray();
    var parametros = {
            "email" : $('#email').val() ,
    		"password" : $('#password').val() ,
            "empresa" :  $('#id_empresa :selected').val(),
            "empresa2" :  $('#id_empresa').val(),
            "process":'login',
            "d":datos
    };
    $.ajax({
            data:  parametros, //datos que se envian a traves de ajax
            url:   'login.php', //archivo que recibe la peticion
            type:  'post', //método de envio
            beforeSend: function () {
                    $("#resultado").html("Procesando, espere por favor...");
            },
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    $("#resultado").html(response);
            }
    });
}

function fn_calificar(id){
    $.post(file,{ 'process':'verRespuesta', 'd':id,},function(r){
        ("id_pregunta").val(r.id_foro);
        ('#id_foro')(r.id_padre);
        $('#identificador').html(r.mensaje);
    },'json');
}


function fn_guardarCalificacion(){
    var datos = $('#formResponde').serializeArray();
    $.post(file,{ 'process':'guardarDatos', 'd':datos},function(r){
        $('#divCalificacionResuldado').html(r);
        //$('#divCalificacion').html(r);
        fn_verTrabajos();
    });
}

function fn_responderPregunta(){
    var datos = $('#formCalifica').serializeArray();
    $.post(file,{ 'process':'fn_guardar', 'd':datos},function(r){
        $('#divCalificacionResuldado').html(r);
        //$('#divCalificacion').html(r);
        //fn_verTrabajos();
    });
}

function fn_verTrabajos(){
    var datos = $('#formCalificacion').serializeArray();
    $.post(file,{ 'process':'tablaDatos', 'd':datos},function(r){
        $('.recargaDatos').html(r);
        $('#tablaDatos').dataTable();

    });
}


function recargaDatos(formulario,Busqueda=''){
    if(formulario){
        var datos = $('#'+formulario).serializeArray();
    }else{
        var datos = '';
    }
    $.post(file,{ 'process':'tablaDatos', 'd':'r','m':datos},function(r){
        $('.recargaDatos').html(r);
        //j = $('#tablaDatos').dataTable();
        var table = $('#tablaDatos').DataTable();
        if(Busqueda != ''){
            $('.dataTables_filter input').val(Busqueda);
            table.search( Busqueda ).draw();
        }
    });
}

function fn_editar(id,f){
    
    efectoPanel('panelCrear');
    if($('#guardarMecMet').length){
        var text = $("#guardarMecMet").html();
    }
    else if($("#guardarCurso").length){
        var text = $("#guardarCurso").html();
    }
    else{
        var text = $("#guardaMecMet").html();
    }
    
    $(".btn-primary").html( text.replace('Guardar','Editar') );
   if ( $("#limpiarForm").length < 1 ) {
        $(".btn-primary").after(' <input type="button" style="display:none" id="limpiarForm" class="btn btn-primary" value="Registro Nuevo" onclick="fn_limpiarForm()" />');
    }
    $("#limpiarForm").fadeIn(3000);
    
    $.post(f, { 'process':'getDatos', 'd':id},function(res){ 
        if(ckeditor != '')
            CKEDITOR.instances.descripcionC.setData(res.descripcionCapitulo);
        for( campo in res){
            var tmp = campo.toLowerCase();                                    
            if( $('#'+campo).length > 0)
                $('#'+campo).val($.trim(res[campo]));
        }
    }, 'json');
    
}

function fn_eliminar(id,f,formulario){
    
   if( confirm('Realmente desea eliminar este item? ') ){
        $.post(f, { 'process':'runEliminar', 'd':id},function(res){
            var json=jQuery.parseJSON(res);
            alert(json.Mensaje);  			
        }).done(recargaDatos());
    }
  
}

function metodoSellando(valor){
    var j = $("option:selected", '#id_metodos').text();
    if(j == 'Sellado'){
        $('.noSellado').val('0');
        $('.noSellado').prop('disabled', true);
        
        
        console.log('jj1');
    }else{
        $('.noSellado').prop('disabled', false);
    }

}

function fn_generar(id,f,formulario){
	
	var estado =document.getElementById("estado"+id).value;	  
	var equipo =document.getElementById("cedula"+id).value;	  
	
	if(equipo!='' && estado=='AUTORIZO'){
		//window.open("pdf.php?plantas=" + id+"&seccion="+seccion+"&equipo="+equipo, '_blank');
		window.open("autorizaciones_pdf/autorizacion_"+equipo+".pdf");
	}else{		
		alert("No se ha Realizado el proceso de Autorizaci\u00F3n");
	} 
}
function fn_generarTest(id,f,formulario){
	var seccion =document.getElementById("id_secciones"+id).value;	
	var equipo =document.getElementById("id_equipos"+id).value;	  
	if(seccion!='' && equipo!=''){
		window.open("pdfTest.php?plantas=" + id+"&seccion="+seccion+"&equipo="+equipo, '_blank');
	}else{		
		alert("Porfavor Seleccione la Seccion y el Equipo");
	} 
}
function fn_generar_carta_equipo(id,f,formulario){
		window.open("pdf.php?plantas=0&seccion=0&equipo=" + id, '_blank');
		
}

function fn_eliminarArchivos(id,f){
  
    if( confirm('¿ Realmentte desea eliminar este item? ') ){
        $.post(f, { 'process':'runEliminar', 'd':id},function(res){
            
                alert(res);    
        }).done(recargaDatos());
    }
  
}


function efectoPanel(panel){
        $("."+panel).fadeOut("slow");
        $("."+panel).fadeIn(1000);
}
/********************VALIDACIONES ESTANDAR*********************************/


function fn_keypress(){
    jQuery('.numero').each(function(){       
        jQuery(this).keypress(function(event){
            return fn_key_press(event,1,this);
        });                                  
    });
    
    jQuery('.decimales').each(function(){       
        jQuery(this).keypress(function(event){
            return fn_key_press(event,2,this);
        });                                  
    });    
    
    jQuery('.caracter').each(function(){
        jQuery(this).keypress(function(event){
            return  fn_key_press(event,3,this);
        });                                  
    });
    
    jQuery('.fecha').each(function(){
        jQuery(this).datepicker({
            showOn: "both",
			buttonImage: "/Calendar/cal.gif",
			buttonImageOnly: true,
            altFormat: 'dd/mm/yy' 
        });                           
    });
    
    jQuery('.email').each(function(){
        jQuery(this).bind({
            change:function(e){
                if( !fn_valida_email(this.value) )
                    jQuery(this).addClass('class_error');
                else
                    jQuery(this).removeClass('class_error');
            }
        });         
    });
}

function fn_key_press(e,opc,field){
    var patron='';
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8 || tecla==0)
    {
        return true;
    }
    if (tecla == 13)
    {
        var i;
        for (i = 0; i < field.form.elements.length; i++)
            if (field == field.form.elements[i])
                break;
        i = (i + 1) % field.form.elements.length;
        field.form.elements[i].focus();
        return false;
    }
    switch(opc)
    {
        case 1:
            patron = /[1234567890]/;/* Solo Numeros */
        break;
        case 2:
            patron = /[-.1234567890,]/;/* Numero, coma, punto */
        break;
        case 3:
            if (tecla==32) return true;
            patron = /[a-zA-Z1234567890_]/;
        break;
    }
   
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function validar_all(c){
    var valido = true;
    var obj_r = new Array();
    var obj = jQuery('.'+c);
    obj.each(function(){
        var tipo = jQuery(this).prop('type');
        if( tipo == 'radio' || tipo == 'checkbox'){
            var name_r = jQuery(this).prop('name');
            if( jQuery.trim(name_r) != ''){
                if( obj_r.length ==  0 )
                    obj_r.push(name_r);
                else{
                    var v1 = true; 
                    for( var i in obj_r){
                        if( name_r == obj_r[i])  
                            v1 = false;
                    }
                    if( v1 )
                        obj_r.push(name_r);
                }                               
            }
        }
        else{
            if( jQuery(this).hasClass('class_error')  )
                jQuery(this).removeClass('class_error');
            if( jQuery.trim(this.value) == ''){
                valido = false;
                jQuery(this).addClass('class_error');
            }                
        }
    });
    
    if( obj_r.length > 0 ){     
        for( var i = 0; i < obj_r.length ; i++){
            jQuery('input[name="'+obj_r[i]+'"]').parent().removeClass('class_error');
            var a_radio = jQuery('input[name="'+obj_r[i]+'"]');
            if( !a_radio.is(':checked') ){
                jQuery('input[name="'+obj_r[i]+'"]').parent().addClass('class_error');             
                valido = false;
            }                                   
        }                               
    }                               
    return valido;
}
function validarFormatoFecha(campo) {
    var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
    if ((campo.match(RegExPattern)) && (campo!='')) {
          return true;
    } else {
          return false;
    }
}