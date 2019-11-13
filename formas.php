<!DOCTYPE HTML>
<html>
  <head>
    <style>
      body {
        margin: 0px;
        padding: 0px;
      }
    </style>
  </head>
  <body>
    <canvas id="myCanvas" width="578" height="200" style="display:none;"></canvas>
    <img id="canvasImg" alt="Right click to save me!">
    <canvas id="lienzo" width="578" height="200" style="display:none;"></canvas>
    <img id="canvasImg2" alt="Right click to save me!">
    <script>
      var canvas = document.getElementById('myCanvas');
      var context = canvas.getContext('2d');

      // draw cloud
      context.beginPath();
      context.moveTo(170, 80);
      context.bezierCurveTo(130, 100, 130, 150, 230, 150);
      context.bezierCurveTo(250, 180, 320, 180, 340, 150);
      context.bezierCurveTo(420, 150, 420, 120, 390, 100);
      context.bezierCurveTo(430, 40, 370, 30, 340, 50);
      context.bezierCurveTo(320, 5, 250, 20, 250, 50);
      context.bezierCurveTo(200, 5, 150, 20, 170, 80);
      context.closePath();
      context.lineWidth = 5;
      context.fillStyle = '#8ED6FF';
      context.fill();
      context.strokeStyle = '#0000ff';
      context.stroke();

      // save canvas image as data url (png format by default)
      var dataURL = canvas.toDataURL();

      // set canvasImg image src to dataURL
      // so it can be saved as an image
      document.getElementById('canvasImg2').src = dataURL;
var canvas = document.getElementById("lienzo");
		if (canvas && canvas.getContext) {
		var ctx = canvas.getContext("2d");
			if (ctx) {var R = 100;
					  var X = canvas.width/2;
					  var Y = canvas.height/2;
					  ctx.fillStyle = "#6ab150";
					  // un angulo de 60deg.
					  var rad = ( Math.PI / 180 ) * 60;
					  ctx.beginPath();
					  for( var i = 0; i<6; i++ ){
					  x = X + R * Math.cos( rad*i );
					  y = Y + R * Math.sin( rad*i );
					  ctx.lineTo(x, y);
					  }
					  ctx.closePath();
					  ctx.fill();
			}
		}
    </script>
  </body>
</html>      