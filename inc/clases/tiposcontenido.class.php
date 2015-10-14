<?php
// Clase Tipo de Contenido

class TipoDeContenido {
	private $id;
	private $nombre;
	private $bd;
	
	function __construct($id) {
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		$this->id = intval($id);
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT nombre FROM tipo_contenido WHERE id = " . $this->id);
		
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
		$this->bd->query('UPDATE tipo_contenido SET nombre = ' . $this->bd->escapar($nombre) . ' WHERE id = ' . $this->id);
		$this->nombre = $nombre;
	} // public function setNombre($nombre) {
	
} // class TipoDeContenido {
?>