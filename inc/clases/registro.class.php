<?php
// Clase Registro

class Registro {
	private $idUsuario;
	private $idGrupo;
	private $completado;
	private $calificacion;
	private $bd;
	
	function __construct($idUsuario,$idGrupo,$completado = NULL,$calificacion = NULL) {
		$this->idUsuario		=	$idUsuario;
		$this->idGrupo			=	$idGrupo;
		
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		// Si estan definidos los datos
		if($completado !== NULL && $calificacion !== NULL) {
			$this->completado = $completado;
			$this->calificacion = $calficacion;
		} else {
			// Consulta a tabla de registros
			$registros = $this->bd->query("SELECT * FROM registros WHERE id_usuario = " . $idUsuario . " AND id_grupo = " . $idGrupo);
			
			if($registros == false) {
				echo 'Hubo un error con la base de datos:' . $this->bd->error();
			} else {
				if(!empty($registros)) {
					foreach($registros as $registro) {
						$this->completado	=	$registro['completado'];
						$this->calificacion	=	$registro['calificacion'];
						break;
					} // foreach($resultados as $resultado) {
				} else {
					$COMPLETADO_DEFAULT = 0;
					$CALIFICACION_DEFAULT = 100.0;
					
					$resultado = $bd->query("INSERT INTO registros (id_usuario,id_grupo,completado,calificacion) VALUES (" . $this->id . "," . $this->idGrupo . ", " . $COMPLETADO_DEFAULT . ", " . $CALIFICACION_DEFAULT . ")");
					if($resultado == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
					
					$this->completado = 0;
					$this->calificacion = 100.0;
				} // if(!empty($registros)) { ... else ...
			} // if($registros == false) { ... else ...
		} // if($completado !== NULL && $calificacion !== NULL) { ... else ...
	} // function __construct($idUsuario,$idGrupo) {
	
	
	public function getIdEstudiante() { return $this->idUsuario; }
	
	
	public function setIdEstudiante($id) {
		$this->bd->query('UPDATE registros SET id_usuario = ' . $this->bd->escapar($id) . ' WHERE id_usuario = ' . $this->idUsuario . ' AND id_grupo = ' . $this->idGrupo);
		$this->idUsuario = $id;
	} // public function setIdEstudiante($id) {
	
		
	public function getIdGrupo() { return $this->$idGrupo; }
	
	
	public function setIdGrupo($id) {
		$this->bd->query('UPDATE registros SET id_grupo = ' . $this->bd->escapar($id) . ' WHERE id_usuario = ' . $this->idUsuario . ' AND id_grupo = ' . $this->idGrupo);
		$this->idGrupo = $id;
	} // public function setIdGrupo($id) {
	
		
	public function getCompletado() { return $this->completado; }
	
	
	public function setCompletado($completado) {
		$this->bd->query('UPDATE registros SET completado = ' . $this->bd->escapar($completado) . ' WHERE id_usuario = ' . $this->idUsuario . ' AND id_grupo = ' . $this->idGrupo);
		$this->completado = $completado;
	} // public function setCompletado($completado) {
	
	
	public function calcularCompletado() {
		// POR IMPLEMENTAR
	} // public function calcularCompletado() {
	
	
	public function getCalificacion() { return $this->calificacion; }
	
	
	public function setCalificacion($calificacion) {
		$this->bd->query('UPDATE registros SET calificacion = ' . $this->bd->escapar($calificacion) . ' WHERE id_usuario = ' . $this->idUsuario . ' AND id_grupo = ' . $this->idGrupo);
		$this->calificacion = $calificacion;
	} // public function setIdEstudiante($id) {
	
	
	public function calcularCalificacion() {
		// POR IMPLEMENTAR
	} // public function calcularCalificacion() {
} // class Registro {
?>