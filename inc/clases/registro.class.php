<?php
// Clase Registro

class Registro {
	private $idUsuario;
	private $idGrupo;
	private $completado;
	private $calificacion;
	private $bd;
	
	function __construct($idUsuario,$idGrupo) {
		$this->idUsuario		=	$idUsuario;
		$this->idGrupo			=	$idGrupo;
		
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		// Consulta a tabla de registros
		$registros = $this->bd->query("SELECT * FROM registros WHERE id_usuario = " . $idUsuario . " AND id_grupo = " . $idGrupo);
		
		if($registros == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach($registros as $registro) {
				$this->completado	=	$registro['completado'];
				$this->calificacion	=	$registro['calificacion'];
				break;
			} // foreach($resultados as $resultado) {
		} // if($registros == false) { ... else ...
	} // function __construct($idUsuario,$idGrupo) {
} // class Registro {
?>