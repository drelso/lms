<?php
// Clase PaletaDeColores

class PaletaDeColores {
	private $id;
	private $color1;
	private $color2;
	private $color3;
	private $color4;
	private $color5;
	
	function __construct($id) {
		$this->id = $id;
		
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM paleta_de_colores WHERE id = " . $this->bd->escapar($id));
		if($resultados == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			require_once('color.class.php');
		
			foreach($resultados as $resultado) {
				$this->color1		=	new Color($resultado['id_color_1']);
				$this->color2		=	new Color($resultado['id_color_2']);
				$this->color3		=	new Color($resultado['id_color_3']);
				$this->color4		=	new Color($resultado['id_color_4']);
				$this->color5		=	new Color($resultado['id_color_5']);
				break;
			} // foreach($resultados as $resultado) {
		} // if($resultados == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getColor($numero) {
		switch($numero) {
			case 1: return $this->color1; break;
			case 2: return $this->color2; break;
			case 3: return $this->color3; break;
			case 4: return $this->color4; break;
			case 5: return $this->color5; break;
			default: return 'Error: color inexistente en esta paleta.'; break;
		} // switch($numero) {
	} // public function getColor($numero) {
	
	
	public function setColor($numero,$nuevoId) {
		$this->bd->query('UPDATE paleta_de_colores SET id_color_' . $this->bd->escapar($numero) . ' = ' . $this->bd->escapar($nuevoId) . ' WHERE id = ' . $this->id);
		
		switch($numero) {
			case 1: $this->color1 = new Color($nuevoId); break;
			case 2: $this->color2 = new Color($nuevoId); break;
			case 3: $this->color3 = new Color($nuevoId); break;
			case 4: $this->color4 = new Color($nuevoId); break;
			case 5: $this->color5 = new Color($nuevoId); break;
			default: return 'Error: color inexistente en esta paleta.'; break;
		} // switch($numero) {
	} // public function setmatricula($matricula) {
} // class PaletaDeColores {
?>