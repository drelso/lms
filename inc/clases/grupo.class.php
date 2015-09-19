<?php
// Clase Grupo

class Grupo {
	private $id;
	private $idMateria;
	private $estudiantes = array();
	private $idProfesor;
	private $idInterfaz;
	private $idPeriodo;
	private $bd;
	
	function __construct($id) {
		$this->id = $id;
		
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM grupos WHERE id = " . $id);
		if($resultados == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
		
		foreach($resultados as $resultado) {
			$this->idMateria	=	$resultado['id_materia'];
			$this->idProfesor	=	$resultado['id_profesor'];
			$this->curriculum	=	$resultado['id_interfaz'];
			$this->matricula	=	$resultado['id_periodo'];
			break;
		} // foreach($resultados as $resultado) {
		
		// Consulta a tabla de grupos de usuario
		$idUsuarios = $this->bd->query("SELECT id_usuario FROM usuario_grupo WHERE id_grupo = " . $id);
	
		if($idUsuarios == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			require_once('estudiante.class.php');
			
			foreach($idUsuarios as $idUsuario) {
				$usuario = $this->bd->query("SELECT * FROM usuarios WHERE id = " . $idUsuario['id_usuario']);
				$idEstudiante = 0;
				
				foreach($usuario as $estudiante) {
					$idEstudiante = $estudiante['id'];
					break;
				} // foreach($resultados as $resultado) {
				
				array_push($this->estudiantes, new Estudiante($idEstudiante));
			} // foreach($idUsuarios as $idUsuario) {
		} // if($idUsuarios == false) { ... else ...
	} // public __construct($id) {
} // class Grupo {

?>