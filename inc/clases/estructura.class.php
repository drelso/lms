<?php
// Clase Estructura

class Estructura {
	private $id;
	private $estilos;
	private $html_1;
	private $html_2;
	private $html_3;
	private $html_4;
	private $html_5;
	private $bd;
	
	function __construct($id) {
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		$this->id = intval($id);
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM estructuras WHERE id = " . $this->id);
		
		if($resultados == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			require_once('html.class.php');
			
			foreach($resultados as $resultado) {
				$this->estilos		=	$resultado['estilos'];
				$this->html_1		=	new HTML($resultado['id_html_1']);
				$this->html_2		=	new HTML($resultado['id_html_2']);
				$this->html_3		=	new HTML($resultado['id_html_3']);
				$this->html_4		=	new HTML($resultado['id_html_4']);
				$this->html_5		=	new HTML($resultado['id_html_5']);
				break;
			} // foreach($resultados as $resultado) {
		} // if($resultados == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function getEstilos() { return $this->estilos; }
	
	
	public function setEstilos($estilos) {
		$this->bd->query('UPDATE estructuras SET estilos = ' . $this->bd->escapar($estilos) . ' WHERE id = ' . $this->id);
		$this->estilos = $estilos;
	} // public function setEstilos($estilos) {
	
	
	public function getHTML($numero) {
		switch(intval($numero)) {
			case 1: return $this->html_1; break;
			case 2: return $this->html_2; break;
			case 3: return $this->html_3; break;
			case 4: return $this->html_4; break;
			case 5: return $this->html_5; break;
			default: return 'Error: HTML inexistente en esta estructura';
		} // switch(intval($numero)) {
	} // public function getHTML($numero) {
	
	
	public function setHTML($numero,$idHTML) {
		$numeroEntero = intval($numero);
		
		if($numeroEntero > 0 && $numeroEntero < 6) {
			$this->bd->query('UPDATE estructuras SET id_html_' . $numeroEntero . ' = ' . $this->bd->escapar($idHTML) . ' WHERE id = ' . $this->id);
			
			switch(intval($numero)) {
				case 1: $this->html_1	=	new HTML($idHTML); break;
				case 1: $this->html_2	=	new HTML($idHTML); break;
				case 1: $this->html_3	=	new HTML($idHTML); break;
				case 1: $this->html_4	=	new HTML($idHTML); break;
				case 1: $this->html_5	=	new HTML($idHTML); break;
				default: return 'Error: HTML inexistente en esta estructura';
			} // switch(intval($numero)) {
		} else {
			echo 'Error: HTML inexistente en esta estructura';
		} // if($numeroEntero > 0 && $numeroEntero < 6) {
	} // public function setHTML($numero,$idHTML) {
} // class Estructura {