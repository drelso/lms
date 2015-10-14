<?php
// Clase Tema

class Tema {
	private $idMateria;
	private $contenidos = array();
	private $bd;
	
	function __construct($idMateria) {
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		$this->idMateria = intval($idMateria);
		
		// Consulta a tabla de tema
		$resultados = $this->bd->query("SELECT * FROM tema WHERE id_materia = " . $this->idMateria);
		
		if( $resultados == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			require_once('contenido.class.php');
			
			foreach( $resultados as $resultado ) {
				array_push($this->contenidos, new Contenido($resultado['id_contenido']));
			} // foreach($resultados as $resultado) {
		} // if($resultados == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getIdMateria() { return $this->idMateria; }
	
	
	public function getContenidos() { return $this->contenidos; }
	
	
	public function agregarContenido($idContenido) {
		
		$resultados = $this->bd->query("SELECT * FROM tema WHERE id_materia = " . $this->bd->escapar($idMateria) . " AND id_contenido = " . $this->bd->escapar($idContenido));
		
		if( $resultados == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} elseif( empty( $resultados ) ) {
			$this->bd->query("INSERT INTO tema (id_materia,id_contenido) VALUES (" . $this->idMateria . "," . $this->bd->escapar($idContenido) . ")");
			
			array_push($this->contenidos, new Contenido($idContenido));
		} // if($resultados == false) { ... elseif ... else ...
		
	} // public function agregarContenido($idContenido) {
	
	
	public function quitarContenido($idContenido) {
		
		$eliminado = $this->bd->query("DELETE FROM tema WHERE id_materia = " . $this->id . " AND id_contenido = " . $this->bd->escapar($idContenido));
		
		if( $eliminado == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			$resultados = $this->bd->query("SELECT * FROM tema WHERE id_materia = " . $this->idMateria);
			
			if( $resultados == false ) {
				echo 'Hubo un error con la base de datos:' . $this->bd->error();
			} else {
				$this->contenidos = array();
				
				foreach( $resultados as $resultado ) {
					array_push($this->contenidos, new Contenido($resultado['id_contenido']));
				} // foreach($resultados as $resultado) {
			} // if($resultados == false) { ... else ...
		} // if($eliminado == false) { ... elseif ... else ...
		
	} // public function quitarContenido($idContenido) {
	
} // class TipoDeContenido {
?>