<?php
// Clase Profesor

require_once('usuario.class.php');

class Profesor extends Usuario {
	private $idGrupos = array();
	
	function __construct($id) {
		parent::__construct($id);
		
		// Consulta a tabla de grupos de usuario
		$grupos = $this->bd->query("SELECT id_grupo FROM usuario_grupo WHERE id_usuario = " . $this->bd->escapar($id));
	
		if($grupos == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach($grupos as $grupo) {
				array_push($this->idGrupos, $grupo['id_grupo']);
			} // foreach($idUsuarios as $idUsuario) {
		} // if($idUsuarios == false) { ... else ...
		
	} // function __construct() {
	
	
	public function getIdGrupos() { return $this->idGrupos; }
	
	
	public function agregarIdGrupo($idGrupo) {
		$tieneGrupo = $this->bd->query("SELECT * FROM usuario_grupo WHERE id_usuario = " . $this->id . " AND id_grupo = " . $this->bd->escapar($idGrupo));
		if($tieneGrupo == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
		
		if(empty($tieneGrupo)) {
			$resultado = $bd->query("INSERT INTO usuario_grupo (id_usuario,id_grupo) VALUES (" . $this->id . "," . $this->bd->escapar($idGrupo) . ")");
			if($resultado == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
			
			array_push($this->idGrupos, $idGrupo);
		} // if(empty($tieneGrupo)) {
	} // public function agregarGrupo($grupo) {
	
	
	public function quitarIdGrupo($idGrupo) {
		$resultado = $this->bd->query("DELETE FROM usuario_grupo WHERE id_usuario = " . $this->id . " AND id_grupo = " . $this->bd->escapar($idGrupo));
		if($resultado == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
				
		$posicion = array_search($idGrupo, $this->idGrupos);
		
		if($posicion != false) { unset($this->idGrupos[$posicion]); }
	} // public function quitarIdGrupo($idGrupo) {
	
} // class Profesor extends Usuario {
?>