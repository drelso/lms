<?php
// Clase Periodo

class Periodo {
	private $id;
	private $nombre;
	private $descripcion;
	
	function __construct($id) {
		$this->id = $id;
		
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		$periodos = $this->bd->query("SELECT * FROM periodos WHERE id = " . $id);
			
		if($periodos == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			if(!empty($periodos)) {
				foreach($periodos as $periodo) {
					$this->nombre	=	$periodo['nombre'];
					$this->descripcion	=	$periodo['descripcion'];
					break;
				} // foreach($periodos as $periodo) {
			} // if(!empty($periodos)) {
		} // if($periodos == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function getNombre() { return $this->nombre; }
	
	
	public function setNombre($nombre) {
		$this->bd->query('UPDATE periodos SET nombre = ' . $bd->escapar($nombre) . ' WHERE id = ' . $this->id);
		$this->nombre = $nombre;
	} // public function setIdEstudiante($id) {
	
	
	public function getDescripcion() { return $this->descripcion; }
	
	
	public function setDescripcion($descripcion) {
		$this->bd->query('UPDATE periodos SET descripcion = ' . $bd->escapar($descripcion) . ' WHERE id = ' . $this->id);
		$this->descripcion = $descripcion;
	} // public function setIdEstudiante($id) {
		
} // class Periodo

?>