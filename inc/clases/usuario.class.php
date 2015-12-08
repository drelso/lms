<?php
// Clase Usuario
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Usuario {
	protected $id;
	protected $nombre;
	protected $correo;
	protected $curriculum;
	protected $matricula;
	protected $tipo = array();
	protected $nivelDeEstudios;
	protected $departamentos = array();
	protected $bd;
	
	function __construct( $id ) {
		require_once( __DIR__ . '/../db/bd.class.php' );
		$this->bd = new BD();
		
		$this->id = intval($id);
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM usuarios WHERE id = " . $this->id);
		
		if( $resultados == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
		
			foreach( $resultados as $resultado ) {
				$this->nombre				=	$resultado['nombre'];
				$this->correo				=	$resultado['correo'];
				$this->curriculum			=	$resultado['curriculum'];
				$this->matricula			=	$resultado['matricula'];
				$this->nivelDeEstudios		=	$resultado['nivel_estudios'];
				break;
			} // foreach($resultados as $resultado) {
			
			// Consulta a tabla de tipo de usuario
			$resultadosTipo = $this->bd->query("SELECT * FROM tipo_usuario WHERE id_usuario = " . $this->id);
			
			if( $resultadosTipo == false ) {
				echo 'Hubo un error con la base de datos:' . $this->bd->error();
			} else {
			
				foreach( $resultadosTipo as $resultadoTipo ) {
					$nombresTipo = $this->bd->query("SELECT * FROM tipos_usuarios WHERE id = " . $resultadoTipo['id_tipo']);
					$nombreDeTipo;
					
					foreach( $nombresTipo as $nombreTipo ) {
						$nombreDeTipo = $nombreTipo['nombre'];
						break;
					} // foreach($resultados as $resultado) {
					
					$tipo = array(
						'id'			=>	$resultadoTipo['id_tipo'],
						'nombre'		=>	$nombreDeTipo
					);
					
					array_push( $this->tipo, $tipo );
				} // foreach($resultadosTipo as $resultadoTipo) {
				
			} // if( $resultadosTipo == false ) {
			
			
			// Consulta a tabla de departamentos de usuario
			$resultadosDepto = $this->bd->query("SELECT * FROM usuario_departamento WHERE id_usuario = " . $this->id);
			
			if( $resultadosDepto == false ) {
				echo 'Hubo un error con la base de datos:' . $this->bd->error();
			} else {
				
				if( $resultadosDepto->num_rows > 0 ) {
					foreach( $resultadosDepto as $resultadoDepto ) {
						$nombresDepto = $this->bd->query("SELECT * FROM departamento WHERE id = '" . $resultadoDepto['id_departamento'] . "'");
						$nombreDeDepto;
						
						if( $nombresDepto == false ) {
							echo 'Hubo un error con la base de datos:' . $this->bd->error();
						} else {
							if( $nombresDepto->num_rows > 0 ) {
								foreach( $nombresDepto as $nombreDepto ) {
									$nombreDeDepto = $nombreDepto['nombre'];
									break;
								} // foreach($resultados as $resultado) {
								
								$depto = array(
									'id'			=>	$resultadoDepto['id_departamento'],
									'nombre'		=>	$nombreDeDepto
								);
								
								array_push( $this->departamentos, $depto );
							} // if( $nombresDepto->num_rows > 0 ) {
						} // if( $nombresDepto == false ) { ... else ...
					} // foreach($resultadosDepto as $resultadoDepto) {
				} // if( $resultadosDepto->num_rows > 0 ) {
			} // if( $resultadosDepto == false ) {
			
		} // if($resultados == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getID() { return $this->id; }
	
	
	public function getNombre() { return $this->nombre; }
	
	
	public function setNombre( $nombre ) {
		$this->bd->query('UPDATE usuarios SET nombre = ' . $this->bd->escapar($nombre) . ' WHERE id = ' . $this->id);
		$this->nombre = $nombre;
	} // public function setNombre($nombre) {
	
	
	public function getCorreo() { return $this->correo; }
	
	
	public function setCorreo( $correo ) {
		$this->bd->query('UPDATE usuarios SET correo = ' . $this->bd->escapar($correo) . ' WHERE id = ' . $this->id);
		$this->correo = $correo;
	} // public function setNombre($nombre) {
		
	
	public function getCurriculum() { return $this->curriculum; }
	
	
	public function setCurriculum( $curriculum ) {
		$this->bd->query('UPDATE usuarios SET curriculum = ' . $this->bd->escapar($curriculum) . ' WHERE id = ' . $this->id);
		$this->curriculum = $curriculum;
	} // public function setcurriculum($curriculum) {
		
	
	public function getMatricula() { return $this->matricula; }
	
	
	public function setMatricula( $matricula ) {
		$this->bd->query('UPDATE usuarios SET matricula = ' . $this->bd->escapar($matricula) . ' WHERE id = ' . $this->id);
		$this->matricula = $matricula;
	} // public function setmatricula($matricula) {
		
	
	public function getNivelDeEstudios() { return $this->nivelDeEstudios; }
	
	
	public function setNivelDeEstudios( $nivelDeEstudios ) {
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
	
	
	public function setContrasena( $contrasena ) {
		
		echo 'Contraseña: ' . $contrasena;
		
		$hash = password_hash($contrasena, PASSWORD_BCRYPT);
		
		echo 'USUARIO ' . $this->id;
		
		$actualizacion = $this->bd->query('UPDATE usuarios SET contrasena = "' . $hash . '" WHERE id = ' . $this->id);
		
		if( $actualizacion == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		}
		
	} // public function setContrasena($contrasena) {
	
	
	public function getTipo() { return $this->tipo; }
	
	
	public function setTipo( $idTipos ) {
		$tiposActuales = $this->bd->query( "SELECT * FROM tipo_usuario WHERE id_usuario = " . $this->id );
		
		$tiposAnteriores = array();
		
		if( $tiposActuales == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
		
			if( $tiposActuales->num_rows != 0 ) {
				
				$eliminacion = $this->bd->query( "DELETE FROM tipo_usuario WHERE id_usuario = " . $this->id );
				
				if( $eliminacion == false ) {
					echo 'Hubo un error con la base de datos:' . $this->bd->error();
				} // if( $eliminacion == false ) {
				
			} // if( $tiposActuales->num_rows != 0 ) {
			
			foreach( $idTipos as $idTipo ) {
				
				$insercion = $this->bd->query("INSERT INTO tipo_usuario (id_usuario,id_tipo) VALUES (" . $this->id . "," . $this->bd->escapar( $idTipo ) . ")");
				
				if( $insercion == false ) {
					
					echo 'Hubo un error con la base de datos:' . $this->bd->error();
					
					foreach( $tiposActuales as $tipoActual ) {
				
						$insercion = $this->bd->query("INSERT INTO tipo_usuario (id_usuario,id_tipo) VALUES (" . $this->id . "," . $tipoActual['id_tipo'] . ")");
						
					} // foreach( $idTipos as $idTipo ) {
					
				} // if( $insercion == false ) {
				
			} // foreach( $idTipos as $idTipo ) {
			
		} // if( $tiposActuales == false ) {
				
	} // public function setTipo( $idTipos ) {
	
	
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
	
	
	public function quitarTipo( $idTipo ) {
		$resultado = $this->bd->query("DELETE FROM tipo_usuario WHERE id_usuario = " . $this->id . " AND id_tipo = " . $this->bd->escapar( $idTipo ));
		if( $resultado == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
				
			foreach($this->tipo as $key => $tipo) {
				if($tipo['id'] == $idTipo) {
					unset($this->tipo[$key]);
					break;
				} // if($tipo['id'] == $idTipo) {
			} // foreach($this->tipo as $key => $tipo) {
			
		} // if( $resultado == false ) {
	} // public function quitarTipo($idTipo) {
	
	
	public function getDepartamentos() { return $this->departamentos; }
	
	
	public function setDepartamentos( $idDeptos ) {
		$deptosActuales = $this->bd->query( "SELECT * FROM usuario_departamento WHERE id_usuario = " . $this->id );
		
		$deptosAnteriores = array();
		
		if( $deptosActuales == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
		
			if( $deptosActuales->num_rows != 0 ) {
				
				$eliminacion = $this->bd->query( "DELETE FROM usuario_departamento WHERE id_usuario = " . $this->id );
				
				if( $eliminacion == false ) {
					echo 'Hubo un error con la base de datos:' . $this->bd->error();
				} // if( $eliminacion == false ) {
				
			} // if( $deptosActuales->num_rows != 0 ) {
			
			foreach( $idDeptos as $idDepto ) {
				
				$insercion = $this->bd->query("INSERT INTO usuario_departamento (id_usuario,id_departamento) VALUES (" . $this->id . "," . $this->bd->escapar( $idDepto ) . ")");
				
				if( $insercion == false ) {
					
					echo 'Hubo un error con la base de datos:' . $this->bd->error();
					
					foreach( $deptosActuales as $deptoActual ) {
				
						$insercion = $this->bd->query("INSERT INTO tipo_usuario (id_usuario,id_departamento) VALUES (" . $this->id . "," . $deptoActual['id_departamento'] . ")");
						
					} // foreach( $idDeptos as $idDepto ) {
					
				} // if( $insercion == false ) {
				
			} // foreach( $idDeptos as $idDepto ) {
			
		} // if( $deptosActuales == false ) {
				
	} // public function setDepartamento( $idDeptos ) {
	
	
	public function agregarDepartamento( $idDepartamento ) {
		$tieneDepto = $this->bd->query("SELECT * FROM usuario_departamento WHERE id_usuario = " . $this->id . " AND id_departamento = " . $this->bd->escapar( $idDepartamento ));
		
		if( $tieneDepto == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} else {
		
			if( $tieneDepto->num_rows == 0 ) {
				$resultado = $this->bd->query("INSERT INTO usuario_departamento (id_usuario,id_departamento) VALUES (" . $this->id . ", " . $this->bd->escapar( $idDepartamento ) . ")" );
				if($resultado == false) {
					echo 'Hubo un error con la base de datos:' . $this->bd->error();
				} else { array_push($this->departamentos, $idDepartamento); }
				
			} // if( empty( $tieneDepto ) ) {
			
		} // if( $tieneDepto == false ) { ... else ...
	} // public function agregarDepartamento( $idDepartamento ) {
	
	
	public function quitarDepartamento( $idDepartamento ) {
		$resultado = $this->bd->query("DELETE FROM usuario_departamento WHERE id_usuario = " . $this->id . " AND id_departamento = '" . $this->bd->escapar( $idDepartamento ) . "'" );
		
		if($resultado == false) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
				
		$posicion = array_search( $idDepartamento, $this->departamentos );
		
		if( $posicion != false ) { unset( $this->departamentos[$posicion] ); }
	} // public function quitarDepartamento( $idDepartamento ) {
} // class Usuario {
?>