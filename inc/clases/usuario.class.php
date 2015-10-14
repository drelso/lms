<?php
// Clase Usuario

class Usuario {
	protected $id;
	protected $nombre;
	protected $correo;
	protected $curriculum;
	protected $matricula;
	protected $tipo = array();
	protected $nivelDeEstudios;
	protected $bd;
	
	function __construct($id) {
		require_once('inc/db/bd.class.php');
		$this->bd = new BD();
		
		$this->id = intval($id);
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM usuarios WHERE id = " . $this->id);
		
		if($resultados == false) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
		
			foreach($resultados as $resultado) {
				$this->nombre				=	$resultado['nombre'];
				$this->correo				=	$resultado['correo'];
				$this->curriculum			=	$resultado['curriculum'];
				$this->matricula			=	$resultado['matricula'];
				$this->nivelDeEstudios		=	$resultado['nivel_estudios'];
				break;
			} // foreach($resultados as $resultado) {
			
			// Consulta a tabla de tipo de usuario
			$resultadosTipo = $this->bd->query("SELECT * FROM tipo_usuario WHERE id_usuario = " . $this->id);
			if($resultadosTipo == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
			
			foreach($resultadosTipo as $resultadoTipo) {
				$nombresTipo = $this->bd->query("SELECT * FROM tipos_usuarios WHERE id = " . $resultadoTipo['id_tipo']);
				$nombreDeTipo;
				
				foreach($nombresTipo as $nombreTipo) {
					$nombreDeTipo = $nombreTipo['nombre'];
					break;
				} // foreach($resultados as $resultado) {
				
				$tipo = array(
					'id'			=>	$resultadoTipo['id_tipo'],
					'nombre'		=>	$nombreDeTipo
				);
				
				array_push($this->tipo, $tipo);
			} // foreach($resultadosTipo as $resultadoTipo) {
		} // if($resultados == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function getNombre() { return $this->nombre; }
	
	
	public function setNombre($nombre) {
		$this->bd->query('UPDATE usuarios SET nombre = ' . $this->bd->escapar($nombre) . ' WHERE id = ' . $this->id);
		$this->nombre = $nombre;
	} // public function setNombre($nombre) {
	
	
	public function getCorreo() { return $this->correo; }
	
	
	public function setCorreo($correo) {
		$this->bd->query('UPDATE usuarios SET correo = ' . $this->bd->escapar($correo) . ' WHERE id = ' . $this->id);
		$this->correo = $correo;
	} // public function setNombre($nombre) {
		
	
	public function getCurriculum() { return $this->curriculum; }
	
	
	public function setCurriculum($curriculum) {
		$this->bd->query('UPDATE usuarios SET curriculum = ' . $this->bd->escapar($curriculum) . ' WHERE id = ' . $this->id);
		$this->curriculum = $curriculum;
	} // public function setcurriculum($curriculum) {
		
	
	public function getMatricula() { return $this->matricula; }
	
	
	public function setMatricula($matricula) {
		$this->bd->query('UPDATE usuarios SET matricula = ' . $this->bd->escapar($matricula) . ' WHERE id = ' . $this->id);
		$this->matricula = $matricula;
	} // public function setmatricula($matricula) {
		
	
	public function getNivelDeEstudios() { return $this->nivelDeEstudios; }
	
	
	public function setNivelDeEstudios($nivelDeEstudios) {
		$this->bd->query('UPDATE usuarios SET nivel_estudios = ' . $this->bd->escapar($nivelDeEstudios) . ' WHERE id = ' . $this->id);
		$this->nivelDeEstudios = $nivelDeEstudios;
	} // public function setNivelDeEstudios($nivelDeEstudios) {
		
	
	public function getContrasena() {
		$resultados = $this->bd->query("SELECT contrasena FROM usuarios WHERE id = " . $this->id);
		$contrasena = '';
		
		foreach($resultados as $resultado) {
			$contrasena		=	$resultado['contrasena'];
			break;
		} // foreach($resultados as $resultado) {
		
		return $contrasena;
	} // public function getContrasena() {
	
	public function setContrasena($contrasena) {
		$hash = password_hash($contrasena, PASSWORD_BCRYPT);
		$this->bd->query('UPDATE usuarios SET contrasena = ' . $hash . ' WHERE id = ' . $this->id);
	} // public function setmatricula($matricula) {
	
	
	public function getTipo() { return $this->tipo; }
	
	
	public function agregarTipo( $idTipo ) {
		$tieneTipo = $this->bd->query("SELECT * FROM tipo_usuario WHERE id_usuario = " . $this->id . " AND id_tipo = " . $this->bd->escapar($idTipo));
		
		if( $tieneTipo == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
		
			if( $tieneTipo->num_rows == 0 ) {
				
				$resultado = $this->bd->query("INSERT INTO tipo_usuario (id_usuario,id_tipo) VALUES (" . $this->id . "," . $this->bd->escapar( $idTipo ) . ")");
				
				if( $resultado == false ) {
					echo 'Hubo un error con la base de datos:' . $this->bd->error();
				} else {
					$nombresTipo = $this->bd->query("SELECT nombre FROM tipos_usuarios WHERE id = " . $this->bd->escapar($idTipo));
					$nombreDeTipo;
					
					foreach( $nombresTipo as $nombreTipo ) {
						$nombreDeTipo = $nombreTipo['nombre'];
						break;
					} // foreach($resultados as $resultado) {
					
					$tipo = array(
						'id'			=>	$idTipo,
						'nombre'		=>	$nombreDeTipo
					);
					
					array_push($this->tipo, $tipo);
				} // if( $resultado == false ) { ... else ...
				
			} // if(empty($tieneTipo)) {
			
		} // if($tieneTipo == false) { ... else ...
	} // public function agregarTipo($tipo) {
	
	
	public function quitarTipo($idTipo) {
		$resultado = $this->bd->query("DELETE FROM tipo_usuario WHERE id_usuario = " . $this->id . " AND id_tipo = " . $this->bd->escapar($idTipo));
		if($resultado == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
				
		foreach($this->tipo as $key => $tipo) {
			if($tipo['id'] == $idTipo) {
				unset($this->tipo[$key]);
				break;
			} // if($tipo['id'] == $idTipo) {
		} // foreach($this->tipo as $key => $tipo) {
	} // public function quitarTipo($idTipo) {
} // class Usuario {
?>