<?php
// Clase Grupo

class Grupo {
	private $id;
	private $idMateria;
	private $estudiantes = array();
	private $idProfesor;
	private $idInterfaz;
	private $periodo;
	private $bd;
	
	function __construct($id) {
		$this->id = $id;
		
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM grupos WHERE id = " . $this->bd->escapar($id));
		if($resultados == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
		
		foreach($resultados as $resultado) {
			$this->idMateria	=	$resultado['id_materia'];
			$this->idProfesor	=	$resultado['id_profesor'];
			$this->idInterfaz	=	$resultado['id_interfaz'];
			
			require_once('periodo.class.php');
			$this->periodo		=	new Periodo($resultado['id_periodo']);
			
			break;
		} // foreach($resultados as $resultado) {
		
		// Consulta a tabla de grupos de usuario
		$idUsuarios = $this->bd->query("SELECT id_usuario FROM usuario_grupo WHERE id_grupo = " . $this->bd->escapar($id));
	
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
	
	
	public function getID() { return $this->id; }
	
	
	public function getIdMateria() { return $this->idMateria; }
	
	public function setIdMateria($idMateria) {
		$this->bd->query('UPDATE grupos SET id_materia = ' . $this->bd->escapar($idMateria) . ' WHERE id = ' . $this->id);
		$this->idMateria = $idMateria;
	} // public function setIdMateria($idMateria) {
	
	
	public function getIdProfesor() { return $this->idProfesor; }
	
	public function setIdProfesor($idProfesor) {
		$this->bd->query('UPDATE grupos SET id_profesor = ' . $this->bd->escapar($idProfesor) . ' WHERE id = ' . $this->id);
		$this->idProfesor = $idProfesor;
	} // public function setIdProfesor($idProfesor) {
	
	
	public function getIdInterfaz() { return $this->idInterfaz; }
	
	public function setIdInterfaz($idInterfaz) {
		$this->bd->query('UPDATE grupos SET id_interfaz = ' . $this->bd->escapar($idInterfaz) . ' WHERE id = ' . $this->id);
		$this->idInterfaz = $idInterfaz;
	} // public function setIdInterfaz($idInterfaz) {
	
	
	public function getPeriodo() { return $this->periodo; }
	
	public function setPeriodo($idPeriodo) {
		$this->bd->query('UPDATE grupos SET id_profesor = ' . $this->bd->escapar($idProfesor) . ' WHERE id = ' . $this->id);
		$this->idProfesor = $idProfesor;
	} // public function setIdMateria($idMateria) {
	
} // class Grupo {

?>