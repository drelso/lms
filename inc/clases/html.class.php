<?php
// Clase HTML

class HTML {
	private $id;
	private $idTipoDeContenido;
	private $contenidoHTML;
	private $bd;
	
	function __construct($id) {
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		$this->id = intval($id);
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM html WHERE id = " . $this->id);
		
		if($resultados == false) {
			
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
			
		} else {
		
			foreach($resultados as $resultado) {
				$this->idTipoDeContenido	=	$resultado['id_tipo_contenido'];
				$this->contenidoHTML		=	$resultado['html'];
				break;
			} // foreach($resultados as $resultado) {
			
		} // if($resultados == false) {
	} // function __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function getIdTipoDeContenido() { return $this->idTipoDeContenido; }
	
	
	public function setIdTipoDeContenido($idTipoDeContenido) {
		$this->bd->query('UPDATE html SET id_tipo_contenido = ' . $this->bd->escapar($idTipoDeContenido) . ' WHERE id = ' . $this->id);
		$this->idTipoDeContenido = $idTipoDeContenido;
	} // public function setIdTipoDeContenido($idTipoDeContenido) {
	
	
	public function getContenidoHTML() { return $this->contenidoHTML; }
	
	
	public function setContenidoHTML($contenidoHTML) {
		$this->bd->query('UPDATE html SET html = ' . $this->bd->escapar($contenidoHTML) . ' WHERE id = ' . $this->id);
		$this->contenidoHTML = $contenidoHTML;
	} // public function setContenidoHTML($contenidoHTML) {
	
} // class HTML {
?>