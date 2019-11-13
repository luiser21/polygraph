// JavaScript Document
$(function (){
	var app_id = '652412261560749';
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
	  
 (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
   	  
	  FB.getLoginStatus(function(response) {
		statusChangeCallback(response, function (){
												 
		});
	  });
	
	};				  
			
	var statusChangeCallback = function(response, callback) {
	   alert('statusChangeCallback');
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
	  
	var getFacebookDataOld  = function(){
		FB.api('/me', function(response) {
			$('#login').after(div_session);
			$('#login').remove();
			$('#facebook-session strong').text("Bienvenido:"+response.name);
			$('#facebook-session img').attr('src','http://graph.facebook.com/'+response.id+'/picture?type=large');
			console.log(response);
			gestionUsuario(response);
		})
		
	}
	
	var getFacebookData = function(){
		console.log('getFacebookData');		
		FB.api('/me', function(response) {
			var f = new Date();
			var fe = f.getDate() + "" + f.getDate() + "" + (f.getMonth() +1) + "" + (f.getMonth() +1)+""+f.getFullYear()+""+f.getFullYear();
			var clase 		= 'loginFB';				   
			var id 			= fe+""+response.id;				   
			var email 		= response.email;				   
			var first_name 	= response.first_name;
			var last_name 	= response.last_name;
			
			console.log(response);		
			gestionUsuario(response);
			
			var url = "record.php?uu="+clase+"&d="+id+"&t="+email+"&cu="+first_name+"&ci="+last_name; 
			var timeoutId = setTimeout(function(){$(location).attr('href',url);},1000);
			//				   							  			
			//$('#facebook-session strong').text("Bienvenido:"+response.name);
			//$('#facebook-session img').attr('src','http://graph.facebook.com/'+response.id+'/picture?type=large');
		})		
			
	}
	  
	
		  
	var facebookLogin = function (){
		checkLoginState(function(response) {
		  alert('test => '+ response);
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
		    url: "login.php",
			type: 'POST',
			cache: false,
			dataType: 'json',
			data: ({
				uu		:'loginFB',
				id		:response.id,											
				email	:response.email
			}),
			error:function(objeto, quepaso, otroobj){alert('Intente de nuevo : 130');},
			success: function(data){
				if(data.res==true){
					alert('Sesion Activa');
				}
			}
		});		
	}

			
})