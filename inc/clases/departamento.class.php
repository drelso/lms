<?php
// Clase Departamento

class Departamento {
	private $id;
	private $nombre;
	private $director;
	private $bd;
	
	function __construct($id) {
		require_once( __DIR__ . '/../db/bd.class.php' );
		$this->bd = new BD();
		
		$this->id = $this->bd->escapar( $id );
		
		// Consulta a tabla de departamento
		$resultados = $this->bd->query("SELECT * FROM departamento WHERE id = " . $this->id);
		
		if( $resultados == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach( $resultados as $resultado ) {
				$this->nombre	=	$resultado['nombre'];
				$this->director	=	$resultado['director'];
				break;
			} // foreach($resultados as $resultado) {
		} // if($resultados == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function setID( $id ) {
		
		$nuevoID = $this->bd->escapar( $id );
		
		$existeID = $this->bd->query("SELECT * FROM departamento WHERE id = " . $nuevoID );
		
		if( $existeID == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
		
			if( $existeID->num_rows == 0 ) {
				
				$this->bd->query('UPDATE departamento SET id = ' . $nuevoID . ' WHERE id = ' . $this->id);
				$this->id = $nuevoID;
				
			} else {
				
				echo 'El ID ingresado ya existe';
				
			} // if( $existeID->num_rows == 0 ) {
		} // if( $existeID == false ) { ... else ...
		
	} // public function setID( $id ) {
	
	
	public function getNombre() { return $this->nombre; }
	
	
	public function setNombre( $nombre ) {
		$this->bd->query( 'UPDATE departamento SET nombre = ' . $this->bd->escapar( $nombre ) . ' WHERE id = ' . $this->id );
		$this->nombre = $nombre;
	} // public function setNombre($nombre) {
	
	
	public function getDirector() { return $this->director; }
	
	
	public function setDirector( $director ) {
		$this->bd->query( 'UPDATE departamento SET director = ' . $this->bd->escapar( $director ) . ' WHERE id = ' . $this->id );
		$this->director = $director;
	} // public function setDirector( $director ) {
	
} // class Departamento {
?>