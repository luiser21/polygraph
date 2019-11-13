<?php 
session_start();
include('clases/sql.php');
include('clases/crearHtml.class.php');

if(isset($_POST["id_frecuencias"]) && isset($_POST["id_aplicacion"]) && isset($_POST["id_lubricantes"])){
   
?>
<script type="text/javascript"> 

       
        function radianes(grados){
        	 var radianes = (Math.PI/180)*grados;
        	 return radianes;
        }
		function dibujarCanvas(){
		
<?php
$dbgestion = new crearHtml();

$arr = $dbgestion->rotulo_figuras($_POST["id_frecuencias"],$_POST["id_aplicacion"],$_POST["id_lubricantes"]);
$directorio_empresa = $dbgestion->sacar_empresa();

for($i=0;$i<count($arr);$i++){
    
    $texto=explode(' ', $arr[$i]['Texto_Fig_Interna']);
    if(strlen($texto[0])>=4){
        $texto[0]=' '.$texto[0];
    }
    if(strlen($texto[1])==4){
        $texto[1]=' '.$texto[1];
    }
    if(strlen($texto[1])==1){
        $texto[1]='    '.$texto[1];
    }
    if(strlen($texto[1])==2){
        $texto[1]='   '.$texto[1];
    }
    if(strlen($texto[1])==3){
        $texto[1]='  '.$texto[1];
    }
    //imprimir($texto);
    $colorborde='';
    if($arr[$i]['Color_Borde']=='Azul'){
        $colorborde='#39388a';
    }elseif($arr[$i]['Color_Borde']=='Amarillo'){
        $colorborde='#f0e027';
    }elseif($arr[$i]['Color_Borde']=='Verde'){
        $colorborde='#0e6133';
    }    

    switch ($arr[$i]['Frecuencia']){
        case "Semanal":        
             ?>
            //SEMANAL FIGURA OVALO CON CIRCULO
            var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');
            var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');
    	    //PRIMER OVALO
            var height=300;
            var width=350;
            var x=0;
            var y=25;
            var radius=125; 
               
            contexto<?php echo $i?>.beginPath();
            contexto<?php echo $i?>.moveTo(x,y+radius);
            contexto<?php echo $i?>.lineTo(x,y+height-radius);
            contexto<?php echo $i?>.quadraticCurveTo(x,y+height,x+radius,y+height);
            contexto<?php echo $i?>.lineTo(x+width-radius,y+height);
            contexto<?php echo $i?>.quadraticCurveTo(x+width,y+height,x+width,y+height-radius);
            contexto<?php echo $i?>.lineTo(x+width,y+radius);
            contexto<?php echo $i?>.quadraticCurveTo(x+width,y,x+width-radius,y);
            contexto<?php echo $i?>.lineTo(x+radius,y);
            contexto<?php echo $i?>.quadraticCurveTo(x,y,x,y+radius);
            contexto<?php echo $i?>.fillStyle = "<?php echo $colorborde?>";
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.stroke();
    		  //SEGUNDO OVALO
            var height=250;
            var width=300;
            var x=25;
            var y=50;
            var radius=100;
        
            contexto<?php echo $i?>.beginPath();
            contexto<?php echo $i?>.moveTo(x,y+radius);
            contexto<?php echo $i?>.lineTo(x,y+height-radius);
            contexto<?php echo $i?>.quadraticCurveTo(x,y+height,x+radius,y+height);
            contexto<?php echo $i?>.lineTo(x+width-radius,y+height);
            contexto<?php echo $i?>.quadraticCurveTo(x+width,y+height,x+width,y+height-radius);
            contexto<?php echo $i?>.lineTo(x+width,y+radius);
            contexto<?php echo $i?>.quadraticCurveTo(x+width,y,x+width-radius,y);
            contexto<?php echo $i?>.lineTo(x+radius,y);
            contexto<?php echo $i?>.quadraticCurveTo(x,y,x,y+radius);
            contexto<?php echo $i?>.fillStyle = "<?php echo $arr[$i]['hexa_color_ext']?>";
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.stroke();
    
            <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
        		  //CIRCULO 3 SOBRE PUESTO
                contexto<?php echo $i?>.beginPath();	
                contexto<?php echo $i?>.arc(175,175,90, radianes(0),radianes(360),false);
                contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
                contexto<?php echo $i?>.fill();
                contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
                contexto<?php echo $i?>.stroke();   
            <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
             	 //Tercer Cuadrado
              	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
             	 contexto<?php echo $i?>.fillRect (85, 85, 180, 180);          		
         	<?php }if($arr[$i]['Fig_Interna']=='Triangulo'){?>              
            	//TERCER TRIANGULO
                 contexto<?php echo $i?>.beginPath();
                 contexto<?php echo $i?>.moveTo(175,70);
                 contexto<?php echo $i?>.lineTo(80,240);
                 contexto<?php echo $i?>.lineTo(120,240); 
                 contexto<?php echo $i?>.lineTo(270,240);
                 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
                 contexto<?php echo $i?>.fill(); 
            <?php } ?>
    		  //TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
            contexto<?php echo $i?>.font = "bold 40px sans-serif"; 
            //contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",95,160);
            //contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",100,190);
            <?php if(strlen($texto[0])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",135,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }else{ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",110,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }
            if(strlen($texto[1])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",135,210);
            contexto<?php echo $i?>.textAlign="start";            
            <?php }else{ ?>   
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",110,210);
            contexto<?php echo $i?>.textAlign="start";
            <?php } ?>   

             
            var data = canvas<?php echo $i?>.toDataURL('image/png');
            var xhr = new XMLHttpRequest();   
            xhr.onreadystatechange = function() {
              // request complete  
              if (xhr.readyState == 4) { 
                 // window.open('http://<?php echo $_SERVER['HTTP_HOST']?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
              }   
            }   
            xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
            xhr.setRequestHeader('Content-Type', 'application/upload'); 
            xhr.send(data);  
                	
    <?php      
         $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
        $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
    
            break;
        case 'Mensual': ?>
       		 //MENSUAL FIGURA CUADRADA CON CIRCULO
       		 var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');
       		 var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');
    		 //Primer Cuadrado
     	 	 contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
           	 contexto<?php echo $i?>.fillRect (0, 0, 350, 350);
             //Segundo Cuadrado
           	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
          	 contexto<?php echo $i?>.fillRect (30, 30, 290, 290);
           	<?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
          	 //circulo 3 sobrepuesto
             contexto<?php echo $i?>.arc(175,175,110, radianes(0),radianes(360),false);
             contexto<?php echo $i?>.lineWidth = 1;
             contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>'; 
             contexto<?php echo $i?>.fill();
             contexto<?php echo $i?>.stroke();
             <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
         	 //Tercer Cuadrado
          	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
         	 contexto<?php echo $i?>.fillRect (70, 70, 210, 210);          		
         	 <?php }if($arr[$i]['Fig_Interna']=='Triangulo'){?>              
        	//TERCER TRIANGULO
             contexto<?php echo $i?>.beginPath();
             contexto<?php echo $i?>.moveTo(175,60);
             contexto<?php echo $i?>.lineTo(60,250);
             contexto<?php echo $i?>.lineTo(140,250); 
             contexto<?php echo $i?>.lineTo(280,250); 
             contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
             contexto<?php echo $i?>.fill();     	 
           	 <?php } ?>
    		 //texto	
             contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
             contexto<?php echo $i?>.font = "bold 40px sans-serif"; 
            // contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",100,200);
             <?php if(strlen($texto[0])<=3){ ?>
             contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",140,170);
             contexto<?php echo $i?>.textAlign="start"; 
             <?php }else{ ?>
             contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",110,170);
             contexto<?php echo $i?>.textAlign='start'; 
             <?php }
             if(strlen($texto[1])<=3){ ?>
             contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",140,220); 
             contexto<?php echo $i?>.textAlign='start';            
             <?php }else{ ?>   
             contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",110,220);
             contexto<?php echo $i?>.textAlign='start'; 
             <?php } ?>   
                
             var data = canvas<?php echo $i?>.toDataURL('image/png');
             var xhr = new XMLHttpRequest(); 
             xhr.onreadystatechange = function() {
               // request complete  
               if (xhr.readyState == 4) { 
                // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
               }   
             }   
             xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
             xhr.setRequestHeader('Content-Type', 'application/upload'); 
             xhr.send(data); 
    	
        <?php 
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break;
        case 'Quincenal': ?>
            //QUINCENAL DIAMANTE  CON CIRCULO
            var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
            var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext("2d");
    		  //PRIMER DIAMANTE
    	    contexto<?php echo $i?>.beginPath();    
            contexto<?php echo $i?>.translate(175,175);
            contexto<?php echo $i?>.moveTo(175,0);
            contexto<?php echo $i?>.lineTo(175*Math.cos((Math.PI/180)*88),175*Math.sin((Math.PI/180)*80));
            contexto<?php echo $i?>.lineTo(175*Math.cos((Math.PI/180)*(80+90)),175*Math.sin((Math.PI/180)*(80+98)));
            contexto<?php echo $i?>.lineTo(175*Math.cos((Math.PI/180)*(80+90+100)),175*Math.sin((Math.PI/180)*(80+90+100)));
            contexto<?php echo $i?>.lineTo(175*Math.cos((Math.PI/180)*(80+90+100+30)),175*Math.sin((Math.PI/180)*(80+90+100+60)));
            contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.closePath();
            contexto<?php echo $i?>.stroke();
    		  //SEGUNDO DIAMANTE	
            contexto<?php echo $i?>.beginPath();    
            contexto<?php echo $i?>.translate(0,0);
            contexto<?php echo $i?>.moveTo(150,0);
            contexto<?php echo $i?>.lineTo(150*Math.cos((Math.PI/180)*88),150*Math.sin((Math.PI/180)*80));
            contexto<?php echo $i?>.lineTo(150*Math.cos((Math.PI/180)*(80+90)),150*Math.sin((Math.PI/180)*(80+98)));
            contexto<?php echo $i?>.lineTo(150*Math.cos((Math.PI/180)*(80+90+100)),150*Math.sin((Math.PI/180)*(80+90+100)));
            contexto<?php echo $i?>.lineTo(150*Math.cos((Math.PI/180)*(80+90+100+30)),150*Math.sin((Math.PI/180)*(80+90+100+60)));
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.closePath();
            contexto<?php echo $i?>.stroke();
            <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
    		  //CIRCULO 3 SOBREPUESTO
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(0,0,90, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
            contexto<?php echo $i?>.stroke(); 
            <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
        	 //Tercer Cuadrado
         	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
        	 contexto<?php echo $i?>.fillRect (-70, -70, 140, 140);          		
       		 <?php } ?> 

    		 //TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
            contexto<?php echo $i?>.font = "bold 50px sans-serif"; 
            <?php if(strlen($texto[0])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",-40,0);
            contexto<?php echo $i?>.textAlign="start";
            <?php }else{ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",-70,0);
            contexto<?php echo $i?>.textAlign="start";
            <?php }
            if(strlen($texto[1])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",-40,40);
            contexto<?php echo $i?>.textAlign="start";            
            <?php }else{ ?>   
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",-75,40);
            contexto<?php echo $i?>.textAlign="start";
            <?php } ?>
            
            var data = canvas<?php echo $i?>.toDataURL('image/png');
            var xhr = new XMLHttpRequest(); 
            xhr.onreadystatechange = function() {
              // request complete  
              if (xhr.readyState == 4) { 
               // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
              }   
            }   
            xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
            xhr.setRequestHeader('Content-Type', 'application/upload'); 
            xhr.send(data); 
                 
        <?php    
            
            $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
                    
            break;
        case 'Bimestral'; ?> 
       		 //BIMESTRAL FIGURA PENTAGONO 	CON CIRCULO		
       		 var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
       		 var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');
    		   //PRIMER PENTAGONO  - TRIANGULO SUPERIOR		
    		 contexto<?php echo $i?>.beginPath();
    		 contexto<?php echo $i?>.moveTo(175,0);
      	  	 contexto<?php echo $i?>.lineTo(0,175);
    		 contexto<?php echo $i?>.lineTo(200,175);
    		 contexto<?php echo $i?>.lineTo(350,175);	
      	     contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
       	  	 contexto<?php echo $i?>.fill();
             // PRIMER PENTAGONO - CUADRADO INFERIOR
             contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
         	 contexto<?php echo $i?>.fillRect (0, 175, 350, 350);
    		   //SEGUNTO PENTAGONO - TRIANGULO SUPERIOR
             contexto<?php echo $i?>.beginPath();
             contexto<?php echo $i?>.moveTo(175,30);
             contexto<?php echo $i?>.lineTo(30,175);
             contexto<?php echo $i?>.lineTo(200,175);
             contexto<?php echo $i?>.lineTo(320,175);
             contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
             contexto<?php echo $i?>.fill();    		   
    		   //SEGUNDO PENTAGONO - CUADRADO INFERIOR
             contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
         	 contexto<?php echo $i?>.fillRect (30, 175, 290, 150);
         	 <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
    		   //CIRUCLO 3 SOBRE PUESTO
             contexto<?php echo $i?>.beginPath();	
             contexto<?php echo $i?>.arc(175,200,90, radianes(0),radianes(360),false);
             contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
             contexto<?php echo $i?>.fill();
             contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
             contexto<?php echo $i?>.stroke();  
             <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
         	 //Tercer Cuadrado
          	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
         	 contexto<?php echo $i?>.fillRect (100, 130, 160, 150);          		
         	 <?php }if($arr[$i]['Fig_Interna']=='Triangulo'){?>              
         	//TERCER TRIANGULO
              contexto<?php echo $i?>.beginPath();
              contexto<?php echo $i?>.moveTo(175,80);
              contexto<?php echo $i?>.lineTo(60,280);
              contexto<?php echo $i?>.lineTo(140,280); 
              contexto<?php echo $i?>.lineTo(280,280); 
              contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
              contexto<?php echo $i?>.fill();     	 
         	 <?php } ?>   
    		   //TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
             contexto<?php echo $i?>.font = "bold 40px sans-serif"; 
            // contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",95,220); 
             <?php if(strlen($texto[0])<=3){ ?>
             contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",130,200);
             contexto<?php echo $i?>.textAlign="start";
             <?php }else{ ?>
             contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",110,200);
             contexto<?php echo $i?>.textAlign="start";
             <?php }
             if(strlen($texto[1])<=3){ ?>
             contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",130,250); 
             contexto<?php echo $i?>.textAlign="start";           
             <?php }else{ ?>   
             contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",100,250);
             contexto<?php echo $i?>.textAlign="start";
             <?php } ?>   
             
             var data = canvas<?php echo $i?>.toDataURL('image/png');
             var xhr = new XMLHttpRequest(); 
             xhr.onreadystatechange = function() {
               // request complete  
               if (xhr.readyState == 4) { 
                // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
               }   
             }   
             xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
             xhr.setRequestHeader('Content-Type', 'application/upload'); 
             xhr.send(data); 
        <?php 
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break;
        case 'Anual':?>
            //ANUAL FIGURA CUADRADO CORTADO  CON CIRCULO		
            var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
            var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');              
    		//PRIMER CUADRADO CORTADO
       	    contexto<?php echo $i?>.beginPath();
    	    contexto<?php echo $i?>.moveTo(0,0);    		  
    		contexto<?php echo $i?>.lineTo(200,0);
    		contexto<?php echo $i?>.lineTo(350,150);
    		contexto<?php echo $i?>.lineTo(350,350);
     	    contexto<?php echo $i?>.lineTo(0,350);		
    	    contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
    	    contexto<?php echo $i?>.fill();
            //SEGUNDO CUADRADO CORTADO
       	    contexto<?php echo $i?>.beginPath();
    		contexto<?php echo $i?>.moveTo(20,20);    		  
    		contexto<?php echo $i?>.lineTo(180,20);
    		contexto<?php echo $i?>.lineTo(325,160);
    		contexto<?php echo $i?>.lineTo(325,330);
     	    contexto<?php echo $i?>.lineTo(20,330);		
    	    contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
    	    contexto<?php echo $i?>.fill();
    	    <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
       	   //CIRUCLO 3 SOBRE PUESTO
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(165,175,90, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
            contexto<?php echo $i?>.stroke();
			 <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
        	 //Tercer Cuadrado
         	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
        	 contexto<?php echo $i?>.fillRect (85,100, 170, 170); 
        	 <?php }if($arr[$i]['Fig_Interna']=='Triangulo'){?>              
          	//TERCER TRIANGULO
               contexto<?php echo $i?>.beginPath();
               contexto<?php echo $i?>.moveTo(175,60);
               contexto<?php echo $i?>.lineTo(60,260);
               contexto<?php echo $i?>.lineTo(140,260); 
               contexto<?php echo $i?>.lineTo(280,260); 
               contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
               contexto<?php echo $i?>.fill();          		
       		 <?php } ?> 
    		   //TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
            contexto<?php echo $i?>.font = "bold 40px sans-serif"; 
            //contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",85,190);  
            <?php if(strlen($texto[0])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",130,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }else{ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",110,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }
            if(strlen($texto[1])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",130,210);
            contexto<?php echo $i?>.textAlign="start";            
            <?php }else{ ?>   
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",100,210);
            contexto<?php echo $i?>.textAlign="start";
            <?php } ?>
            
            var data = canvas<?php echo $i?>.toDataURL('image/png');
            var xhr = new XMLHttpRequest(); 
            xhr.onreadystatechange = function() {
              // request complete  
              if (xhr.readyState == 4) { 
               // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
              }   
            }   
            xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
            xhr.setRequestHeader('Content-Type', 'application/upload'); 
            xhr.send(data); 
        <?php 
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break;
        case 'Bi-anual':?>
            //CADA 2 AÑOS FIGURA HEXAGONO RECTANGULAR CON CIRCULO		
            var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
            var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');              
    		//PRIMER HEXAGONO RECTANGULAR
       	    contexto<?php echo $i?>.beginPath();
    	    contexto<?php echo $i?>.moveTo(0,0);    		  
    	    contexto<?php echo $i?>.lineTo(175,0);
    	    contexto<?php echo $i?>.lineTo(350,175);
     	    contexto<?php echo $i?>.lineTo(350,350);
     	    contexto<?php echo $i?>.lineTo(175,350);
     	    contexto<?php echo $i?>.lineTo(0,175);		
    	    contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
    	    contexto<?php echo $i?>.fill();
            //SEGUNDO HEXAGONO RECTANGULAR
       	    contexto<?php echo $i?>.beginPath();
    		contexto<?php echo $i?>.moveTo(25,25);    		  
    		contexto<?php echo $i?>.lineTo(175,25);
    		contexto<?php echo $i?>.lineTo(330,175);
     	    contexto<?php echo $i?>.lineTo(330,330);
     	    contexto<?php echo $i?>.lineTo(175,330);
     	    contexto<?php echo $i?>.lineTo(25,175);		
    	    contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
    	    contexto<?php echo $i?>.fill();
    	    <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
       	   //CIRUCLO 3 SOBRE PUESTO
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,90, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
            contexto<?php echo $i?>.stroke();
            <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
        	 //Tercer Cuadrado
         	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
        	 contexto<?php echo $i?>.fillRect (110,110, 140, 140);  
        	 <?php }if($arr[$i]['Fig_Interna']=='Triangulo'){?>              
           	//TERCER TRIANGULO
                contexto<?php echo $i?>.beginPath();
                contexto<?php echo $i?>.moveTo(175,60);
                contexto<?php echo $i?>.lineTo(90,230);
                contexto<?php echo $i?>.lineTo(140,230); 
                contexto<?php echo $i?>.lineTo(260,230); 
                contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
                contexto<?php echo $i?>.fill();              		
       		 <?php } ?> 
    		   //TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
            contexto<?php echo $i?>.font = "bold 40px sans-serif"; 
            //contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",100,190); 
            <?php if(strlen($texto[0])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",140,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }else{ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",120,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }
            if(strlen($texto[1])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",140,210);
            contexto<?php echo $i?>.textAlign="start";            
            <?php }else{ ?>   
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",110,210);
            contexto<?php echo $i?>.textAlign="start";
            <?php } ?>

            var data = canvas<?php echo $i?>.toDataURL('image/png');
            var xhr = new XMLHttpRequest(); 
            xhr.onreadystatechange = function() {
              // request complete  
              if (xhr.readyState == 4) { 
               // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
              }   
            }   
            xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
            xhr.setRequestHeader('Content-Type', 'application/upload'); 
            xhr.send(data); 
        <?php 
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break;
        case 'Semestral': ?>
            //SEMESTRAL FIGURA HEXAGONO CON CIRCULO
            var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
            var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext("2d");
           	  //PRIMER HEXAGONO
        	  var R = 175;
        	  var X = canvas<?php echo $i?>.width/2;
        	  var Y = canvas<?php echo $i?>.height/2;
        	  contexto<?php echo $i?>.fillStyle = "<?php echo $colorborde?>";
        	  // un angulo de 60deg.
        	  var rad = ( Math.PI / 180 ) * 60;
        	  contexto<?php echo $i?>.beginPath();
        	  for( var i = 0; i<6; i++ ){
        	  	x = X + R * Math.cos( rad*i );
        	  	y = Y + R * Math.sin( rad*i );
        	  	contexto<?php echo $i?>.lineTo(x, y);
        	  }
        	  contexto<?php echo $i?>.closePath();
        	  contexto<?php echo $i?>.fill();
        	  //SEGUNDO HEXAGONO
        	  var R = 145;
        	  var X = canvas<?php echo $i?>.width/2;
        	  var Y = canvas<?php echo $i?>.height/2;
        	  contexto<?php echo $i?>.fillStyle = "<?php echo $arr[$i]['hexa_color_ext']?>";
        	  // un angulo de 60deg.
        	  var rad = ( Math.PI / 180 ) * 60;
        	  contexto<?php echo $i?>.beginPath();
        	  for( var i = 0; i<6; i++ ){
        	  	x = X + R * Math.cos( rad*i );
        	  	y = Y + R * Math.sin( rad*i );
        	  	contexto<?php echo $i?>.lineTo(x, y);
        	  }
    	    contexto<?php echo $i?>.closePath();
            contexto<?php echo $i?>.fill();
            <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
    	    //CIRCULO 3 SOBRE PUESTO	
    		contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,90, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
            contexto<?php echo $i?>.stroke(); 
            <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
         	 //Tercer Cuadrado
          	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
         	 contexto<?php echo $i?>.fillRect (95, 95, 160, 160);          		
         	<?php }if($arr[$i]['Fig_Interna']=='Triangulo'){?>              
        	//TERCER TRIANGULO
             contexto<?php echo $i?>.beginPath();
             contexto<?php echo $i?>.moveTo(175,60);
             contexto<?php echo $i?>.lineTo(80,240);
             contexto<?php echo $i?>.lineTo(120,240); 
             contexto<?php echo $i?>.lineTo(270,240);
             contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
             contexto<?php echo $i?>.fill();
             <?php } ?>       	 
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
            contexto<?php echo $i?>.font = "bold 40px sans-serif"; 
           // contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",95,190);  
            <?php if(strlen($texto[0])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",140,180);
            contexto<?php echo $i?>.textAlign="start";
            <?php }else{ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",110,180);
            contexto<?php echo $i?>.textAlign="start";
            <?php }
            if(strlen($texto[1])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",140,220);
            contexto<?php echo $i?>.textAlign="start";            
            <?php }else{ ?>   
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",110,220);
            contexto<?php echo $i?>.textAlign="start";
            <?php } ?>

            var data = canvas<?php echo $i?>.toDataURL('image/png');
            var xhr = new XMLHttpRequest(); 
            xhr.onreadystatechange = function() {
              // request complete  
              if (xhr.readyState == 4) { 
               // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
              }   
            }   
            xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
            xhr.setRequestHeader('Content-Type', 'application/upload'); 
            xhr.send(data); 
        <?php 
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break;
        case 'Anual-Predic':?>
            //PREDICTIVA FIGURA CIRCULO CON CIRCULO
            var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
            var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');
    		  //SEGUNDO CIRCULO           
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,160, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.lineWidth = 30;
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>'; //circulo 2 sobre puesto
            contexto<?php echo $i?>.fill();
            //PRIMER CIRCULO 
            contexto<?php echo $i?>.strokeStyle='<?php echo $colorborde?>'; // circulo 1 principal 1              
            contexto<?php echo $i?>.stroke();   
            <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
    		  //CIRCULO 3 circulo sobre puesto		
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,90, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
            contexto<?php echo $i?>.stroke();  
			 <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
        	 //Tercer Cuadrado
         	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
        	 contexto<?php echo $i?>.fillRect (90,90, 175, 175);          		
        	 <?php }if($arr[$i]['Fig_Interna']=='Triangulo'){?>              
         	//TERCER TRIANGULO
              contexto<?php echo $i?>.beginPath();
              contexto<?php echo $i?>.moveTo(175,60);
              contexto<?php echo $i?>.lineTo(80,240);
              contexto<?php echo $i?>.lineTo(120,240); 
              contexto<?php echo $i?>.lineTo(270,240);
              contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
              contexto<?php echo $i?>.fill(); 
            <?php } ?> 
    		  //TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
            contexto<?php echo $i?>.font = "bold 40px sans-serif"; 
            //contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",100,200);
            <?php if(strlen($texto[0])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",140,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }else{ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",110,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }
            if(strlen($texto[1])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",140,210); 
            contexto<?php echo $i?>.textAlign="start";           
            <?php }else{ ?>   
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",110,210);
            contexto<?php echo $i?>.textAlign="start";
            <?php } ?>

            var data = canvas<?php echo $i?>.toDataURL('image/png');
            var xhr = new XMLHttpRequest(); 
            xhr.onreadystatechange = function() {
              // request complete  
              if (xhr.readyState == 4) { 
               // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
              }   
            }   
            xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
            xhr.setRequestHeader('Content-Type', 'application/upload'); 
            xhr.send(data); 
        <?php 
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break;
        case 'Predictiva':?>
            //PREDICTIVA FIGURA CIRCULO CON CIRCULO
            var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
            var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');
    		  //SEGUNDO CIRCULO           
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,160, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.lineWidth = 30;
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>'; //circulo 2 sobre puesto
            contexto<?php echo $i?>.fill();
            //PRIMER CIRCULO 
            contexto<?php echo $i?>.strokeStyle='<?php echo $colorborde?>'; // circulo 1 principal 1              
            contexto<?php echo $i?>.stroke();   
            <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
    		  //CIRCULO 3 circulo sobre puesto		
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,90, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
            contexto<?php echo $i?>.stroke();  
			 <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
        	 //Tercer Cuadrado
         	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
        	 contexto<?php echo $i?>.fillRect (90,90, 175, 175);          		
        	 <?php }if($arr[$i]['Fig_Interna']=='Triangulo'){?>              
         	//TERCER TRIANGULO
              contexto<?php echo $i?>.beginPath();
              contexto<?php echo $i?>.moveTo(175,60);
              contexto<?php echo $i?>.lineTo(80,240);
              contexto<?php echo $i?>.lineTo(120,240); 
              contexto<?php echo $i?>.lineTo(270,240);
              contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
              contexto<?php echo $i?>.fill(); 
            <?php } ?> 
    		  //TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
            contexto<?php echo $i?>.font = "bold 40px sans-serif"; 
            //contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",100,200);
            <?php if(strlen($texto[0])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",140,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }else{ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",110,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }
            if(strlen($texto[1])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",140,210); 
            contexto<?php echo $i?>.textAlign="start";           
            <?php }else{ ?>   
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",110,210);
            contexto<?php echo $i?>.textAlign="start";
            <?php } ?>

            var data = canvas<?php echo $i?>.toDataURL('image/png');
            var xhr = new XMLHttpRequest(); 
            xhr.onreadystatechange = function() {
              // request complete  
              if (xhr.readyState == 4) { 
               // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
              }   
            }   
            xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
            xhr.setRequestHeader('Content-Type', 'application/upload'); 
            xhr.send(data); 
        <?php 
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break;
        case 'Trimestral': ?>
             //TRIMESTRAL FIGURA TRIANGULO CON CIRCULO
             var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
             var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');
    		 //PRIMER TRIANGULO
    		 contexto<?php echo $i?>.beginPath();
    		 contexto<?php echo $i?>.moveTo(175,0);
      	     contexto<?php echo $i?>.lineTo(0,350);
    		 contexto<?php echo $i?>.lineTo(200,350);
    		 contexto<?php echo $i?>.lineTo(350,350);	
      	     contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
       	     contexto<?php echo $i?>.fill();
    		//SEGUNDO TRIANGULO
             contexto<?php echo $i?>.beginPath();
             contexto<?php echo $i?>.moveTo(175,40);
             contexto<?php echo $i?>.lineTo(30,330);
             contexto<?php echo $i?>.lineTo(200,330);
             contexto<?php echo $i?>.lineTo(320,330);
             contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
             contexto<?php echo $i?>.fill();
             <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
    		//CIRCULO 3 SOBREPUESTO	
             contexto<?php echo $i?>.beginPath();	
             contexto<?php echo $i?>.arc(175,240,85, radianes(0),radianes(360),false);
             contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
             contexto<?php echo $i?>.fill();
             contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
             contexto<?php echo $i?>.stroke(); 
             <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
         	 //Tercer Cuadrado
          	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
         	 contexto<?php echo $i?>.fillRect (110, 180, 130, 130);          		
         	 <?php }if($arr[$i]['Fig_Interna']=='Triangulo'){?>              
          	//TERCER TRIANGULO
               contexto<?php echo $i?>.beginPath();
               contexto<?php echo $i?>.moveTo(175,110);
               contexto<?php echo $i?>.lineTo(80,300);
               contexto<?php echo $i?>.lineTo(260,300); 
               contexto<?php echo $i?>.lineTo(270,300); 
               contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
               contexto<?php echo $i?>.fill();   
             <?php } ?>   
    		//TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
             contexto<?php echo $i?>.font = "bold 38px sans-serif"; 
             //contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",100,250); 
             <?php if(strlen($texto[0])<=3){ ?>
             contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",140,230);
             contexto<?php echo $i?>.textAlign="start";
             <?php }else{ ?>
             contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",120,230);
             contexto<?php echo $i?>.textAlign="start";
             <?php }
             if(strlen($texto[1])<=3){ ?>
             contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",140,270);
             contexto<?php echo $i?>.textAlign="start";            
             <?php }else{ ?>   
             contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",120,270);
             contexto<?php echo $i?>.textAlign="start";
             <?php } ?>

             var data = canvas<?php echo $i?>.toDataURL('image/png');
             var xhr = new XMLHttpRequest(); 
             xhr.onreadystatechange = function() {
               // request complete  
               if (xhr.readyState == 4) { 
                // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
               }   
             }   
             xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
             xhr.setRequestHeader('Content-Type', 'application/upload'); 
             xhr.send(data); 
                 	
        <?php 
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break;  
        case 'Diario':?>
            	//DIARIO FIGURA TRIANGULO REDONDO CON CIRCULO		
            	var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
            	var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');              
            	//PRIMER TRIANGULO CUADRADO
                contexto<?php echo $i?>.beginPath();
            	contexto<?php echo $i?>.moveTo(175,0);    		  
            	contexto<?php echo $i?>.lineTo(0,116);
            	contexto<?php echo $i?>.lineTo(0,233);
                contexto<?php echo $i?>.lineTo(350,233);
                contexto<?php echo $i?>.lineTo(350,116);	
                contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
                contexto<?php echo $i?>.fill();
                //PRIMER CIRCULO TRIANGULO CUADRADO
                contexto<?php echo $i?>.beginPath();	
                contexto<?php echo $i?>.arc(175,160,190, radianes(0),radianes(180),false);
                contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
                contexto<?php echo $i?>.fill();
                contexto<?php echo $i?>.strokeStyle='<?php echo $colorborde?>'; 
                contexto<?php echo $i?>.stroke();   
                //SEGUNDO TRIANGULO CUADRADO
                contexto<?php echo $i?>.beginPath();
            	contexto<?php echo $i?>.moveTo(175,25);    		  
            	contexto<?php echo $i?>.lineTo(29,116);
            	contexto<?php echo $i?>.lineTo(29,200);
                contexto<?php echo $i?>.lineTo(319.2,200);
                contexto<?php echo $i?>.lineTo(319.2,116);	
                contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
                contexto<?php echo $i?>.fill();
                //SEGUNDO CIRCULO TRIANGULO CUADRADO
                contexto<?php echo $i?>.beginPath();	
                contexto<?php echo $i?>.arc(174,185,145, radianes(0),radianes(180),false);
                contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
                contexto<?php echo $i?>.fill();
                contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_ext']?>'; 
                contexto<?php echo $i?>.stroke(); 
                <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
                //CIRUCLO 3 SOBRE PUESTO
                contexto<?php echo $i?>.beginPath();	
                contexto<?php echo $i?>.arc(175,175,90, radianes(0),radianes(360),false);
                contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
                contexto<?php echo $i?>.fill();
                contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
                contexto<?php echo $i?>.stroke();  
                <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
            	 //Tercer Cuadrado
             	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
            	 contexto<?php echo $i?>.fillRect (90,90, 165, 165);          		
            	 <?php }if($arr[$i]['Fig_Interna']=='Triangulo'){?>              
               	//TERCER TRIANGULO
                    contexto<?php echo $i?>.beginPath();
                    contexto<?php echo $i?>.moveTo(175,60);
                    contexto<?php echo $i?>.lineTo(80,250);
                    contexto<?php echo $i?>.lineTo(260,250); 
                    contexto<?php echo $i?>.lineTo(270,250); 
                    contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
                    contexto<?php echo $i?>.fill();   
                <?php } ?> 
            	   //TEXTO
                contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
                contexto<?php echo $i?>.font = "bold 40px sans-serif"; 
                //contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",100,190);
                <?php if(strlen($texto[0])<=3){ ?>
                contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",140,170);
                contexto<?php echo $i?>.textAlign="start";
                <?php }else{ ?>
                contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",110,170);
                contexto<?php echo $i?>.textAlign="start";
                <?php }
                if(strlen($texto[1])<=3){ ?>
                contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",140,210);
                contexto<?php echo $i?>.textAlign="start";            
                <?php }else{ ?>   
                contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",110,210);
                contexto<?php echo $i?>.textAlign="start";
                <?php } ?>
                
                var data = canvas<?php echo $i?>.toDataURL('image/png');
                var xhr = new XMLHttpRequest(); 
                xhr.onreadystatechange = function() {
                  // request complete  
                  if (xhr.readyState == 4) { 
                  //  window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
                  }   
                }   
                xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
                xhr.setRequestHeader('Content-Type', 'application/upload'); 
                xhr.send(data); 
                    	
        <?php 
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break;
        case 'Tri-anual': ?>
            //CADA 3 AÑOS FIGURA RECTANGULO DESVIADO  CON CIRCULO		
            var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
            var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');              
    		   //PRIMER RECTANGULO DESVIADO
       	    contexto<?php echo $i?>.beginPath();
    		contexto<?php echo $i?>.moveTo(120,0);
    		contexto<?php echo $i?>.lineTo(0,350);
    		contexto<?php echo $i?>.lineTo(250,350);
    		contexto<?php echo $i?>.lineTo(350,0);	
    	    contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
    	    contexto<?php echo $i?>.fill();
            //SEGUNDO RECTANGULO DESVIADO
       	    contexto<?php echo $i?>.beginPath();
    		contexto<?php echo $i?>.moveTo(135,20);
    		contexto<?php echo $i?>.lineTo(30,330);
    		contexto<?php echo $i?>.lineTo(230,330);
    		contexto<?php echo $i?>.lineTo(325,20);	
    	    contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
    	    contexto<?php echo $i?>.fill();
    	    <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
            //CIRUCLO 3 SOBRE PUESTO
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,80, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
            contexto<?php echo $i?>.stroke();  
            <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
        	 //Tercer Cuadrado
         	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
        	 contexto<?php echo $i?>.fillRect (105,115, 140, 140);          		
       		 <?php } ?> 
    		   //TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
            contexto<?php echo $i?>.font = "bold 40px sans-serif"; 
            //contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",100,190); 
            <?php if(strlen($texto[0])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",130,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }else{ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",105,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }
            if(strlen($texto[1])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",130,210);
            contexto<?php echo $i?>.textAlign="start";            
            <?php }else{ ?>   
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",105,210);
            contexto<?php echo $i?>.textAlign="start";
            <?php } ?>
            
            var data = canvas<?php echo $i?>.toDataURL('image/png');
            var xhr = new XMLHttpRequest(); 
            xhr.onreadystatechange = function() {
              // request complete  
              if (xhr.readyState == 4) { 
               // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
              }   
            }   
            xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
            xhr.setRequestHeader('Content-Type', 'application/upload'); 
            xhr.send(data); 
            
    	
        <?php   
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break; 
        case 'Bi-diario':?>
            //CADA 2 DIAS FIGURA RECTANGULO ACOSTADO  CON CIRCULO
            var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');
            var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');
            //PRIMER RECTANGULO ACOSTADO
            contexto<?php echo $i?>.beginPath();
            contexto<?php echo $i?>.moveTo(70,0);
            contexto<?php echo $i?>.lineTo(280,0);
            contexto<?php echo $i?>.lineTo(350,350);
            contexto<?php echo $i?>.lineTo(0,350);
            contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
            contexto<?php echo $i?>.fill();
            //SEGUNDO RECTANGULO ACOSTADO
            contexto<?php echo $i?>.beginPath();
            contexto<?php echo $i?>.moveTo(90,30);
            contexto<?php echo $i?>.lineTo(260,30);
            contexto<?php echo $i?>.lineTo(320,320);
            contexto<?php echo $i?>.lineTo(30,320);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
            contexto<?php echo $i?>.fill();
            <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
      	    //CIRUCLO 3 SOBRE PUESTO
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,90, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
            contexto<?php echo $i?>.stroke();   
            <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
        	 //Tercer Cuadrado
         	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
        	 contexto<?php echo $i?>.fillRect (95,100, 160, 160);          		
       		 <?php } ?> 
		    //TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
            contexto<?php echo $i?>.font = "bold 45px sans-serif"; 
            //contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",100,190);
            <?php if(strlen($texto[0])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",130,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }else{ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",105,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }
            if(strlen($texto[1])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",130,210); 
            contexto<?php echo $i?>.textAlign="start";           
            <?php }else{ ?>   
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",105,210);
            contexto<?php echo $i?>.textAlign="start";
            <?php } ?>
            
            var data = canvas<?php echo $i?>.toDataURL('image/png');
            var xhr = new XMLHttpRequest(); 
            xhr.onreadystatechange = function() {
              // request complete  
              if (xhr.readyState == 4) { 
               // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
              }   
            }   
            xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
            xhr.setRequestHeader('Content-Type', 'application/upload'); 
            xhr.send(data); 
            
       <?php 
       $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
           $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
       
            break;
        case 'Ocho-horas':?>
            //CADA 8 HORAS FIGURA CUADRADO REDONDO CON CIRCULO		
            var canvas<?php echo $i?> = document.getElementById('miCanvas<?php echo $i?>');	
            var contexto<?php echo $i?> = canvas<?php echo $i?>.getContext('2d');              
			   //PRIMER CUADRADO REDONDO
       	   contexto<?php echo $i?>.beginPath();
 		   contexto<?php echo $i?>.moveTo(0,175);    		  
 		   contexto<?php echo $i?>.lineTo(0,350);
   		   contexto<?php echo $i?>.lineTo(350,350);
     	   contexto<?php echo $i?>.lineTo(350,175);
   	       contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
    	       contexto<?php echo $i?>.fill();
            //PRIMER CIRCULO CUADRADO REDONDO
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,175, 0,Math.PI+(Math.PI*0)/2,true);
            contexto<?php echo $i?>.fillStyle = '<?php echo $colorborde?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $colorborde?>'; 
            contexto<?php echo $i?>.stroke();    
            //SEGUNDO CUADRADO REDONDO
       	   contexto<?php echo $i?>.beginPath();
 		   contexto<?php echo $i?>.moveTo(25,175);    		  
 		   contexto<?php echo $i?>.lineTo(25,325);
   		   contexto<?php echo $i?>.lineTo(325,325);
     	   contexto<?php echo $i?>.lineTo(325,175);
   	       contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
    	       contexto<?php echo $i?>.fill();
            //SEGUNDO CIRCULO CUADRADO REDONDO
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,150, 0,Math.PI+(Math.PI*0)/2,true);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_ext']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_ext']?>'; 
            contexto<?php echo $i?>.stroke(); 
            <?php if($arr[$i]['Fig_Interna']=='Circulo'){?>
            //CIRUCLO 3 SOBRE PUESTO
            contexto<?php echo $i?>.beginPath();	
            contexto<?php echo $i?>.arc(175,175,90, radianes(0),radianes(360),false);
            contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
            contexto<?php echo $i?>.fill();
            contexto<?php echo $i?>.strokeStyle='<?php echo $arr[$i]['hexa_color_int']?>'; 
            contexto<?php echo $i?>.stroke();  
            <?php }if($arr[$i]['Fig_Interna']=='Cuadrado'){?>
        	 //Tercer Cuadrado
         	 contexto<?php echo $i?>.fillStyle = '<?php echo $arr[$i]['hexa_color_int']?>';
        	 contexto<?php echo $i?>.fillRect (95,100, 170, 170);          		
       		 <?php } ?> 
			   //TEXTO
            contexto<?php echo $i?>.fillStyle = '<?php echo ($arr[$i]['hexa_color_int']=='#ffffff' || $arr[$i]['hexa_color_int']=='#91cfd0' || $arr[$i]['hexa_color_int']=='#86cfe9' || $arr[$i]['hexa_color_int']=='#00b4dd')? '#000000':'#ffffff'?>';
            contexto<?php echo $i?>.font = "bold 50px sans-serif"; 
            //contexto<?php echo $i?>.fillText("<?php echo $arr[$i]['Texto_Fig_Interna']?>",100,190); 
            <?php if(strlen($texto[0])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",130,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }else{ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[0]?>",105,170);
            contexto<?php echo $i?>.textAlign="start";
            <?php }
            if(strlen($texto[1])<=3){ ?>
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",130,210); 
            contexto<?php echo $i?>.textAlign="start";           
            <?php }else{ ?>   
            contexto<?php echo $i?>.fillText("<?php echo $texto[1]?>",105,210);
            contexto<?php echo $i?>.textAlign="start";
            <?php } ?>
            
            var data = canvas<?php echo $i?>.toDataURL('image/png');
            var xhr = new XMLHttpRequest(); 
            xhr.onreadystatechange = function() { 
              // request complete  
              if (xhr.readyState == 4) { 
               // window.open('http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $directorio_empresa?>/imagenes/rotulos/'+xhr.responseText,'_blank');
              }   
            }   
            xhr.open('POST','snapshot.php?archivo=<?php echo $arr[$i]['Archivo']?>',true);
            xhr.setRequestHeader('Content-Type', 'application/upload'); 
            xhr.send(data);   
			
        <?php 
        $insertar = $dbgestion->insertar_rotulo_figuras($arr[$i]['id_frecuencias'],$arr[$i]['id_aplicacion'],
            $arr[$i]['cod_lubricante'],$arr[$i]['Archivo'],$directorio_empresa.'/imagenes/rotulos/',$_SESSION['id_usuario']);
        
            break;
        }  
    } ?> 
}
</script>
 <body onLoad="dibujarCanvas();"> 
<?php 
for($i=0;$i<count($arr);$i++){ 
    ?>
	<canvas id="miCanvas<?php echo $i?>" width="350" height="350"></canvas> 
<?php } ?>   
</body> 


      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="/resources/demos/style.css">
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script>
      $( function() {
        $( "#dialog-message" ).dialog({
          modal: true,
          buttons: {
            Ok: function() {
              $( this ).dialog( "close" );
              window.location = "rotulos.php";
            }
          }
        });
      } );
      </script>
    <div id="dialog-message" title="Download complete">
      <p>
        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;" >Generar Rotulos Automaticos</span>
       </p> 
    </div>    

<?php } ?>