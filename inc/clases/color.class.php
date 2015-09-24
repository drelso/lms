<?php
// Clase Color

class Color {
	private $id;
	private $rgb;
	private $hex;
	private $bd;
	
	function __construct($id) {
		$this->id = $id;
		
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM colores WHERE id = " . $id);
		if($resultados == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
		
		foreach($resultados as $resultado) {
			$this->rgb		=	$resultado['rgb'];
			$this->hex		=	$resultado['hex'];
			break;
		} // foreach($resultados as $resultado) {
		
	} // function __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function getRGB() { return $this->rgb; }
	
	
	public function setRGB($rgb) {
		$rgbArreglo = explode(',',$rgb);
		$rgbValidado;
		$primerValor = true;
		
		foreach ($rgbArreglo as $valor) {
			$valorEntero = intval($valor);
			
			if($valorEntero >= 0 && $valorEntero <= 255) {
				if($primerValor) {
					$rgbValidado = $valorEntero;
					$primerValor = false;
				} else {
					$rgbValidado .= ','.$valorEntero;
				} // if($primerValor) { ... else ...
			} else {
				$rgbValidado = false;
				break;
			}// if(intval($valor) >= 0 || intval($valor) <= 255) { ... else ...
		} // foreach ($rgbArreglo as $valor) {
		
		if(!$rgbValidado) {
			echo ' ERROR EN EL RGB ';
		} else {
			$this->bd->query('UPDATE colores SET rgb = ' . $rgbValidado . ' WHERE id = ' . $this->id);
			$this->rgb = $rgbValidado;
		}
	} // public function setRGB($rgb) {
	
	
	public function getHex() { return $this->hex; }
	
	
	public function setHex($hex) {
		
		if(substr($hex, 0, 1 ) != '#') { $hex = '#'.$hex; }
		
		if(preg_match('/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $hex) != 1) {
			echo ' ERROR EN EL RGB ';
		} else {
			$this->bd->query('UPDATE colores SET hex = ' . $hex . ' WHERE id = ' . $this->id);
			$this->rgb = $rgbValidado;
		}
	} // public function setRGB($rgb) {
	
	
	public function hexToRGB($hex) {
		
		// Código de http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
		
		$hex = str_replace("#", "", $hex);
		
		if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
		}
		$rgb = $r . ',' . $g . ',' . $b;
		return $rgb;
	} // public function hexToRGB($hex) {
	
	
	public function rgbToHex($rgb) {
		
		// Código de http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
		
		$rgb = explode(',',$rgb);
		
		$hex = "#";
		$hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
		
		return $hex;
	} // public function rgbToHex($rgb) {
} // class Color {
?>