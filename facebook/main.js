// JavaScript Document
$(function (){
	var app_id = '404082466442891';
	var scopes = 'email, user_likes';
	
	
	var btn_login = '<a href="#" id="login" class="btn btn-primary"> Iniciar Sesion</a>';
	
	var div_session = "<div id ='facebook-session'>"+
					  "<strong></strong>"+
					  "<img>"+
					  "<a href='#' id='logout' class='btn btn-danger'> Cerrar session</a>"+
					  "</div>";
					  
	 window.fbAsyncInit = function() {
	  FB.init({
		appId      : app_id,
		status	   : true,
		cookie     : true,  
		xfbml      : true,  
		version    : 'v2.1' 
	  });
	  
	  
	  FB.getLoginStatus(function(response) {
		statusChangeCallback(response, function (){
												 
		});
	  });
	
	};				  
			
	var statusChangeCallback = function(response, callback) {				
		console.log(response);
		if (response.status === 'connected') {
		  	getFacebookData();
		} else {	
			callback(false);
		}
  	}
	var  checkLoginState = function(callback) {
		FB.getLoginStatus(function(response) {
		 statusChangeCallback(response, function (data){
			callback(data);									 
			});
		});
	  }	
	  
	var getFacebookData  = function(){
		FB.api('/me', function(response) {
			$('#login').after(div_session);
			$('#login').remove();
			$('#facebook-session strong').text("Bienvenido:"+response.name);
			$('#facebook-session img').attr('src','http://graph.facebook.com/'+response.id+'/picture?type=large');
			console.log(response);
			gestionUsuario(response);
		})
		
	}
	  
	var facebookLogin = function (){
		checkLoginState(function(response) {
			if(!response){
				FB.login(function (response){
					if(response.status === 'connected')
						getFacebookData();
				}, {scope: scopes});
			}					 
		})
	}	
	
	var facebookLogout = function(){
		FB.getLoginStatus(function(response){
			if(response.status ==='connected'){
				FB.logout(function(response){
					$('#facebook-session').before(btn_login);
					$('#facebook-session').remove();
				})				
			}
		})
	}
	
	
	$(document).on('click','#login', function (e){
		e.preventDefault();
		
		facebookLogin();
	})

	$(document).on('click','#logout', function (e){
		e.preventDefault();		
		facebookLogout();
	})

	var gestionUsuario =  function(response){
		$.ajax({
		    url: "index.php",
			type: 'POST',
			cache: false,
			dataType: 'json',
			data: ({
				wa		:'guardar',
				id		:response.id,											
				email	:response.email
			}),
			error:function(objeto, quepaso, otroobj){alert('error');},
			success: function(data){
				alert(data.res);
			}
		});		
	}

			
})