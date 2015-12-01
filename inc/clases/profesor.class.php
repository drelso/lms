<?php
// Clase Profesor

require_once('usuario.class.php');

class Profesor extends Usuario {
	private $idGrupos = array();
	
	function __construct( $id ) {
		parent::__construct( $id );
		
		// Consulta a tabla de grupos de usuario
		$grupos = $this->bd->query("SELECT id_grupo FROM usuario_grupo WHERE id_usuario = " . $this->bd->escapar( $id ));
	
		if( $grupos == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach( $grupos as $grupo ) {
				array_push($this->idGrupos, $grupo['id_grupo']);
			} // foreach( $grupos as $grupo ) {
		} // if( $grupos == false ) {
		
		// Consulta a tabla de departamentos de usuario
		$departamentos = $this->bd->query("SELECT id_departamento FROM usuario_departamento WHERE id_usuario = " . $this->bd->escapar($id));
	
		if( $departamentos == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach( $departamentos as $departamento ) {
				array_push($this->departamentos, $departamento['id_departamento']);
			} // foreach( $departamentos as $departamento ) {
		} // if($departamentos == false) {
		
	} // function __construct() {
	
	
	public function getIdGrupos() { return $this->idGrupos; }
	
	
	public function agregarIdGrupo( $idGrupo ) {
		$tieneGrupo = $this->bd->query("SELECT * FROM usuario_grupo WHERE id_usuario = " . $this->id . " AND id_grupo = " . $this->bd->escapar($idGrupo));
		
		if( $tieneGrupo == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
		
			if( $tieneGrupo->num_rows == 0 ) {
				$resultado = $this->bd->query("INSERT INTO usuario_grupo (id_usuario,id_grupo) VALUES (" . $this->id . "," . $this->bd->escapar($idGrupo) . ")");
				if($resultado == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
				
				array_push($this->idGrupos, $idGrupo);
			} // if(empty($tieneGrupo)) {
			
		} // if($tieneGrupo == false) { ... else ...
	} // public function agregarGrupo($grupo) {
	
	
	public function quitarIdGrupo( $idGrupo ) {
		$resultado = $this->bd->query("DELETE FROM usuario_grupo WHERE id_usuario = " . $this->id . " AND id_grupo = " . $this->bd->escapar($idGrupo));
		
		if($resultado == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
				
			$posicion = array_search($idGrupo, $this->idGrupos);
			
			if($posicion != false) { unset($this->idGrupos[$posicion]); }
			
		}
	} // public function quitarIdGrupo($idGrupo) {
	
		
} // class Profesor extends Usuario {
?>