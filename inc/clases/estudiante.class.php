<?php
// Clase Estudiante

require_once('usuario.class.php');

class Estudiante extends Usuario {
	private $idGrupos = array();
	private $registros = array();
	
	function __construct($id) {
		parent::__construct($id);
		
		// Consulta a tabla de grupos de usuario
		$grupos = $this->bd->query("SELECT id_grupo FROM usuario_grupo WHERE id_usuario = " . $this->id);
	
		if($grupos == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach($grupos as $grupo) {
				array_push($this->idGrupos, $grupo['id_grupo']);
			} // foreach($idUsuarios as $idUsuario) {
		} // if($idUsuarios == false) { ... else ...
		
		
		// Consulta a tabla de registros de usuario
		$registros = $this->bd->query("SELECT * FROM registros WHERE id_usuario = " . $this->bd->escapar($id));
	
		if($registros == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			require_once('registro.class.php');
			foreach($registros as $registro) {
				array_push($this->registros, new Registro($registro['id_usuario'],$registro['id_grupo'],$registro['completado'],$registro['calificacion']));
			} // foreach($idUsuarios as $idUsuario) {
		} // if($idUsuarios == false) { ... else ...
		
	} // function __construct($id) {
	
	
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
	
	
	public function getRegistros() { return $this->registros; }
	
	
	public function agregarRegistro($idGrupo) {
		require_once('registro.class.php');
		
		foreach($this->registros as $registro) {
			if( $registro->getIdGrupo() == $idGrupo ) { return; }
		} // foreach($this->registros as $registro) {
		
		array_push($this->registros, new Registro($this->id,$idGrupo));
	} // public function agregarGrupo($grupo) {
	
	
	public function quitarRegistro($idGrupo) {
		$resultado = $this->bd->query("DELETE FROM registros WHERE id_usuario = " . $this->id . " AND id_grupo = " . $this->bd->escapar($idGrupo));
		if($resultado == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach($this->registros as $key => $registro) {
				if( $registro->getIdGrupo() == $idGrupo ) {
					unset($this->registros[$key]);
					break;
				} // if( $registro->getIdGrupo() == $idGrupo ) {
			} // foreach($this->registros as $registro) {
		} // if($resultado == false) { ... else ...
	} // public function quitarRegistro($idGrupo) {
	
} // class Estudiante extends Usuario {
?>