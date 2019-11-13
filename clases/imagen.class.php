<?php
/**
 * imagenRotulos
 * 
 * @package carLub
 * @author Javier Ardila david.ardila@gmail.com
 * @copyright 2017
 * @version 0.1
 * @access public
 */
class imagenRotulos{
	
    /**
     * imagenRotulos::imImage
     * 
     * @return resource ID imagecreate
     */    
    public $imImage = false;
    
    public $imFondo;
    public $imRelleno;
    

    /**
     * imagenRotulos::crearImagen()
     * 
     * @param integer $ancho
     * @param integer $alto
     * @return
     */
    public function crearImagen($ancho = 60, $alto = 60){
        $this->imImage = imagecreate(  $ancho , $alto);
        return true;
    }
    
	/**
	 * imagenRotulos::defineColorFondo()
	 * 
	 * @param integer $rojo
	 * @param integer $verde
	 * @param integer $azul
	 * @return void
	 */
	public function defineColorFondo($rojo = 255, $verde = 0, $azul = 0){
       $this->imFondo  = imagecolorallocate( $this->imImage, $rojo, $verde, $azul );
    }
    
	/**
	 * imagenRotulos::defineColorRelleno()
	 * 
	 * @param integer $rojo
	 * @param integer $verde
	 * @param integer $azul
	 * @return void
	 */
	public function defineColorRelleno($rojo = 255, $verde = 0, $azul = 0){
       $this->imRelleno  = imagecolorallocate( $this->imImage, $rojo, $verde, $azul );
    }
    
    /**
     * imagenRotulos::crearCirculo()
     * 
     * @return void
     */
    public function crearCirculo(){
        $this->crearImagen();
        $this->defineColorFondo(255,255,255);
        $this->defineColorRelleno(255);
        imagefilledellipse( $this->imImage, 25, 25, 50, 50, $this->imRelleno );
    }
    
    public function crearCuadrado(){
        $this->crearImagen();
        $this->defineColorFondo(255,255,255);
        $this->defineColorRelleno(255);
        imagefilledrectangle( $this->imImage, 0, 0, 300, 50, $this->imRelleno );
    }
    
    public function crearTriangulo(){
        $triangle = array(60, 500, 100);
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
        $this->crearImagen();
        $this->defineColorFondo(255,255,255);
        $this->defineColorRelleno(255);
        imagefilledpolygon($this->imImage, $points, 3, $this->imRelleno);


    }
    
    /**
     * imagenRotulos::pintarImagen()
     * 
     * @return void
     */
    public function pintarImagen(){
        imagepng( $this->imImage );
        imagedestroy( $this->imImage );
    }
    
}


?>