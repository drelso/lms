<?php
// Clase Materia

class Materia {
	private $id;
	private $nombre;
	private $tema;
	private $bd;
	
	function __construct($id) {
		$this->id = $this->bd->escapar($id);
		
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		require_once('tema.class.php');
		
		$this->tema = new Tema($this->id);
		
		// Consulta a tabla de materia
		$resultados = $this->bd->query("SELECT nombre FROM tipo_contenido WHERE id = " . $this->$id);
		
		if($resultados == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach($resultados as $resultado) {
				$this->nombre	=	$resultado['nombre'];
				break;
			} // foreach($resultados as $resultado) {
		} // if($resultados == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function getNombre() { return $this->nombre; }
	
	
	public function setNombre($nombre) {
		$this->bd->query('UPDATE materia SET nombre = ' . $this->bd->escapar($nombre) . ' WHERE id = ' . $this->id);
		$this->nombre = $nombre;
	} // public function setNombre($nombre) {
	
	
	public function getTema() { return $this->tema; }
	
} // class Materia {
?>