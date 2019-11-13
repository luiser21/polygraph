/* 
Creado Por Javier David Ardila B
david.ardila@gmail.com
2015
*/

$(document).on('ready',iniciar_scripts);
            
function iniciar_scripts(){
   $('#Guardar').on('click',fn_guardar);	
    //	fn_keypress();
    //	timeAjax('div_loading');
    //	fn_clear();
}
 
function fn_guardar(){
    fn_envio('runActualizar',0);
}
 
function fn_envio(Metodo,Id,f){
    var datos = (Id == 0)? $('#formulario').serializeArray() : Id;
    $.post(f,{ 'process':Metodo, 'd':datos },function(r){
        $('#resultado').html(r);
        refrescar();
  });
}

function refrescar(){
    location.reload(true);
    var datos = 'r';
    var Metodo = 'tablaDatos';
    $.post('Configurar.php',{ 'process':Metodo, 'd':datos },function(r){
        $('#tablaDatos').html(r);
  });
}

function fn_editar(id,f){
    fn_envio('runEditar',id,f);    
}        
function fn_limpiar(){
    location.href= '{$this->_file}';
}
function fn_eliminar(id,f){
    var Mensaje = '¿Realmente desea eliminar este registro?';
    if( confirm(Mensaje) )
        fn_envio('runEliminar',id,f);
}