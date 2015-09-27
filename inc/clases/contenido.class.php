<?php
// Clase Contenido

class Contenido {
	private $id;
	private $modulo;
	private $informacion;
	private $tipoDeAprendizaje;
	private $tipoDeContenido;
	private $bd;
	
	function __construct($id) {
		$this->id = $id;
		
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		// Consulta a tabla de contenidos
		$resultados = $this->bd->query("SELECT nombre FROM contenidos WHERE id = " . $this->bd->escapar($id));
		
		if($resultados == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			require_once('tiposcontenidos.class.php');
			
			foreach($resultados as $resultado) {
				$this->modulo				=	$resultado['modulo'];
				$this->informacion			=	$resultado['informacion'];
				$this->tipoDeAprendizaje	=	$resultado['tipo_de_aprendizaje'];
				$this->tipoDeContenido		=	new TipoDeContenido($resultado['tipoDeContenido']);
				break;
			} // foreach($resultados as $resultado) {
		} // if($resultados == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function getModulo() { return $this->modulo; }
	
	
	public function setModulo($modulo) {
		$this->bd->query('UPDATE contenidos SET modulo = ' . $this->bd->escapar($modulo) . ' WHERE id = ' . $this->id);
		$this->modulo = $modulo;
	} // public function setModulo($modulo) {
	
	
	public function getInformacion() { return $this->informacion; }
	
	
	public function setInformacion($informacion) {
		$this->bd->query('UPDATE contenidos SET informacion = ' . $this->bd->escapar($informacion) . ' WHERE id = ' . $this->id);
		$this->informacion = $informacion;
	} // public function setInformacion($informacion) {
	
	
	public function getTipoDeAprendizaje() { return $this->tipoDeAprendizaje; }
	
	
	public function setTipoDeAprendizaje($tipoDeAprendizaje) {
		$this->bd->query('UPDATE contenidos SET tipo_de_aprendizaje = ' . $this->bd->escapar($tipoDeAprendizaje) . ' WHERE id = ' . $this->id);
		$this->tipoDeAprendizaje = $tipoDeAprendizaje;
	} // public function setTipoDeAprendizaje($tipoDeAprendizaje) {
	
	
	public function getTipoDeContenido() { return $this->tipoDeContenido; }
	
	
	public function setTipoDeContenido($idTipoDeContenido) {
		$this->bd->query('UPDATE contenidos SET tipo_de_contenido = ' . $this->bd->escapar($idTipoDeContenido) . ' WHERE id = ' . $this->id);
		$this->tipoDeContenido		=	new TipoDeContenido($tipoDeAprendizaje);
	} // public function setTipoDeContenido($tipoDeContenido) {
	
} // class Contenido {
?>