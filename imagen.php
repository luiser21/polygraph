<?php
session_start();
//header("Content-type: image/png");
if(!$_SESSION['id_usuario'])
    header('Location: ./login.php');
include './clases/packege.php';
include('./clases/imagen.class.php');
 
$obIm = new imagenRotulos;
    
    if($_GET['im'] == 'circulo'){
        $obIm->crearCirculo();
    }
    if($_GET['im'] == 'cuadrado'){
        $obIm->crearCuadrado();        
        }
        
    if($_GET['im'] == 'triangulo'){
        $obIm->crearTriangulo();        
        }        
        
$obIm->pintarImagen();
die();

// set up array of points for polygon



$triangle = array(60, 80, 100);
sort($triangle);

$c = $triangle[2]; // base
$b = $triangle[1]; // sides
$a = $triangle[0];

// calcular ángulo, regla de coseno
$alpha = acos((pow($b,2) + pow($c,2) - pow($a,2)) / (2 * $b * $c));

// calc altura y distancia
$height = abs(sin($alpha)) * $b;
$width = abs(cos($alpha)) * $b;

$x = 10; // punto de inicio
$y = 58;

$points = array(
	$x, $y,				// inicio
	$x+$c, $y,				// base
	$x+$width, $y-$height 	// apendice
	);

// draw
$image = imagecreate(120,120);
$blanco =imagecolorallocate($image, 255, 255, 255);
$rojo = imagecolorallocate($image, 255, 0, 0);
imagefilledpolygon($image, $points, 3, $rojo);

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);





?>
?>