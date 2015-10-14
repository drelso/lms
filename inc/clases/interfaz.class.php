<?php
// Clase Interfaz

class Interfaz {
	private $id;
	private $paletaDeColor;
	private $estructura;
	private $bd;
	
	function __construct($id) {
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		$this->id = intval($id);
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM interfaz WHERE id = " . $this->id);
		
		if($resultados == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			require_once('paleta.class.php');
			require_once('estructura.class.php');
			
			foreach($resultados as $resultado) {
				$this->paletaDeColor	=	new PaletaDeColores($resultado['id_paleta']);
				$this->estructura		=	new Estructura($resultado['id_estructura']);
				break;
			} // foreach($resultados as $resultado) {
		} // if($resultados == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function getPaletaDeColor() { return $this->paletaDeColor; }
	
	
	public function setPaletaDeColor($idPaletaDeColor) {
		$actualizado = $this->bd->query('UPDATE interfaz SET id_paleta = ' . $this->bd->escapar($idPaletaDeColor) . ' WHERE id = ' . $this->id);
		
		if( $actualizado == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			$this->paletaDeColor	=	new PaletaDeColores($idPaletaDeColor);
		} // if( $actualizado == false ) { ... else ...
	} // public function setPaletaDeColor($idPaletaDeColor) {
	
	
	public function getEstructura() { return $this->estructura; }
	
	
	public function setEstructura($idEstructura) {
		$actualizado = $this->bd->query('UPDATE interfaz SET id_estructura = ' . $this->bd->escapar($idEstructura) . ' WHERE id = ' . $this->id);
		
		if( $actualizado == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			$this->estructura	=	new Estructura($idEstructura);
		} // if( $actualizado == false ) { ... else ...
	} // public function setPaletaDeColor($idPaletaDeColor) {
	
	
	public function calcularInterfaz($estudiante) {
		// POR IMPLEMENTAR
	} // public function calcularInterfaz() {
} // class TipoDeContenido {
?>