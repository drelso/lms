<?php
// Clase Grupo

class Grupo {
	private $id;
	private $idMateria;
	private $estudiantes = array();
	private $idProfesor;
	private $idInterfaz;
	private $numero;
	private $periodo;
	private $bd;
	
	function __construct($id) {
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		$this->id = intval($id);
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM grupos WHERE id = " . $this->id);
		
		if($resultados == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			foreach($resultados as $resultado) {
				$this->idMateria	=	$resultado['id_materia'];
				$this->idProfesor	=	$resultado['id_profesor'];
				$this->idInterfaz	=	$resultado['id_interfaz'];
				$this->numero		=	$resultado['numero'];
				
				require_once('periodo.class.php');
				$this->periodo		=	new Periodo($resultado['id_periodo']);
				
				break;
			} // foreach($resultados as $resultado) {
		} // if($resultados == false) { ... else ...
		
		// Consulta a tabla de grupos de usuario
		$idUsuarios = $this->bd->query("SELECT id_usuario FROM usuario_grupo WHERE id_grupo = " . $this->id);
	
		if($idUsuarios == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
			require_once('estudiante.class.php');
			
			foreach($idUsuarios as $idUsuario) {
				array_push($this->estudiantes, new Estudiante($idUsuario['id_usuario']));
			} // foreach($idUsuarios as $idUsuario) {
		} // if($idUsuarios == false) { ... else ...
	} // public __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function getIdMateria() { return $this->idMateria; }
	
	
	public function setIdMateria($idMateria) {
		$this->bd->query('UPDATE grupos SET id_materia = ' . $this->bd->escapar($idMateria) . ' WHERE id = ' . $this->id);
		$this->idMateria = $idMateria;
	} // public function setIdMateria($idMateria) {
	
	
	public function getEstudiantes() { return $this->estudiantes; }
	
	
	public function setEstudiantes($idEstudiantes) {
		if(!empty($idEstudiantes)) {
			$this->bd->query('DELETE FROM usuario_grupo WHERE id_grupo = ' . $this->id);
			
			$this->estudiantes = array();
			
			foreach($idEstudiantes as $idEstudiante) {
				$this->bd->query("INSERT INTO usuario_grupo (id_usuario,id_grupo) VALUES (" . $this->bd->escapar($idEstudiante) . "," . $this->id . ")");
				
				require_once('estudiante.class.php');
				
				array_push($this->estudiantes, new Estudiante($idEstudiante));
			} // foreach($idEstudiantes as $idEstudiante) {
		} // if(!empty($estudiantes)) {
	} // public function setEstudiantes($estudiantes) {
	
	
	public function agregarEstudiante($idEstudiante) {
		$resultados = $this->bd->query('SELECT * FROM usuario_grupo WHERE id_grupo = ' . $this->id . ' AND id_usuario = ' . $this->bd->escapar($idEstudiante));
		
		if($resultados == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} elseif(empty($resultados)) {
			$this->bd->query("INSERT INTO usuario_grupo (id_usuario,id_grupo) VALUES (" . $this->bd->escapar($idEstudiante) . "," . $this->id . ")");
			
			array_push($this->estudiantes, new Estudiante($idEstudiante));
		} // if($resultados == false) { ... else ...
		
	} // public function setIdMateria($idMateria) {
		
	
	public function quitarEstudiante($idEstudiante) {
		$resultados = $this->bd->query('SELECT * FROM usuario_grupo WHERE id_grupo = ' . $this->id . ' AND id_usuario = ' . $this->bd->escapar($idEstudiante));
		
		if($resultados == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} elseif(!empty($resultados)) {
			$this->bd->query( "DELETE FROM usuario_grupo WHERE id_usuario = " . $this->bd->escapar($idEstudiante) . " AND id_grupo = " . $this->id );
			
			// Consulta a tabla de grupos de usuario
			$idUsuarios = $this->bd->query("SELECT id_usuario FROM usuario_grupo WHERE id_grupo = " . $this->id);
		
			if($idUsuarios == false) {
				echo 'Hubo un error con la base de datos:' . $this->bd->error();
			} else {
				$this->estudiantes = array();
				
				foreach($idUsuarios as $idUsuario) {
					array_push($this->estudiantes, new Estudiante($idUsuario['id_usuario']));
				} // foreach($idUsuarios as $idUsuario) {
			} // if($idUsuarios == false) { ... else ...
			
			array_push($this->estudiantes, new Estudiante($idEstudiante));
		} // if($resultados == false) { ... else ...
		
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
	
	
	public function getNumero() { return $this->numero; }
	
	
	public function setNumero( $numero ) {
		$this->bd->query('UPDATE grupos SET numero = ' . $this->bd->escapar($numero) . ' WHERE id = ' . $this->id);
		$this->numero = $numero;
	} // public function setNumero($numero) {
	
	
	public function getPeriodo() { return $this->periodo; }
	
	
	public function setPeriodo($idPeriodo) {
		$this->bd->query('UPDATE grupos SET id_profesor = ' . $this->bd->escapar($idProfesor) . ' WHERE id = ' . $this->id);
		$this->idProfesor = $idProfesor;
	} // public function setIdMateria($idMateria) {
	
} // class Grupo {

?>