<?php
// Clase Estudiante

require_once('usuario.class.php');

class Estudiante extends Usuario {
	private $idGrupos = array();
	private $registros = array();
	
	function __construct($id) {
		parent::__construct($id);
		
		// Consulta a tabla de grupos de usuario
		$grupos = $this->bd->query("SELECT id_grupo FROM usuario_grupo WHERE id_usuario = " . $id);
	
		if($grupos == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach($grupos as $grupo) {
				array_push($this->idGrupos, $grupo['id_grupo']);
			} // foreach($idUsuarios as $idUsuario) {
		} // if($idUsuarios == false) { ... else ...
		
		
		// Consulta a tabla de registros de usuario
		$registros = $this->bd->query("SELECT * FROM registros WHERE id_usuario = " . $id);
	
		if($registros == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach($registros as $registro) {
				array_push($this->idGrupos, $grupo['id_grupo']);
			} // foreach($idUsuarios as $idUsuario) {
		} // if($idUsuarios == false) { ... else ...
		
	} // function __construct($id) {
} // class Estudiante extends Usuario {
?>