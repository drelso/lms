<?php
// Clase Administrador

require_once('usuario.class.php');

class Administrador extends Usuario {
	
	public function agregarUsuario($nombre, $correo, $contrasena, $matricula, $curriculum, $nivelDeEstudios, $tipos = NULL) {
		
		// Consulta a tabla de usuarios
		$resultados = $this->bd->query("SELECT * FROM usuarios WHERE nombre = " . $this->bd->escapar($nombre) . " AND correo = " . $this->bd->escapar($correo));
		
		if( $resultados == false ) {
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
		} elseif( $resultados->num_rows > 0 ) {
			require_once('usuario.class.php');
			
			foreach( $resultados as $resultado ) {
				$nuevoUsuario = new Usuario($resultado['id']);
				
				var_dump($nuevoUsuario);
				
				if( isset($tipos) ) {
					
					foreach( $tipos as $tipoUsuario ) {
						$nuevoUsuario->agregarTipo( intval( $tipoUsuario ) );
					} // foreach( $tipos as $tipoUsuario ) {
				} // if( isset($tipos) ) {
				
				return $nuevoUsuario;
				
				break;
			} // foreach( $resultados as $resultado ) {
		} else {
			
			$hash = password_hash($contrasena, PASSWORD_BCRYPT);
			
			$insercion = $this->bd->query("INSERT INTO usuarios (nombre, correo, contrasena, matricula, curriculum, nivel_estudios) VALUES (" . $this->bd->escapar($nombre) . "," . $this->bd->escapar($correo) . ",'" . $hash . "'," . $this->bd->escapar($matricula) . "," . $this->bd->escapar(curriculum) . "," . $this->bd->escapar($nivelDeEstudios) . ")");
			
			if( $insercion == false ) {
				echo 'Hubo un error con la base de datos:' . $this->bd->error();
			} else {
			
				// Consulta a tabla de usuarios
				$usuarioNuevo = $this->bd->query("SELECT * FROM usuarios WHERE nombre = " . $this->bd->escapar($nombre) . " AND correo = " . $this->bd->escapar($correo));
				
				if( $usuarioNuevo == false ) {
					echo 'Hubo un error con la base de datos:' . $this->bd->error();
				} elseif( $usuarioNuevo->num_rows > 0 ) {
					require_once('usuario.class.php');
					
					foreach( $usuarioNuevo as $usuario ) {
						$nuevoUsuario = new Usuario( $usuario['id'] );
						
						if( isset($tipos) ) {
							foreach( $tipos as $tipoUsuario ) {
								$nuevoUsuario->agregarTipo( intval( $tipoUsuario ) );
							} // foreach( $tipos as $tipoUsuario ) {
						} // if( isset($tipos) ) {
					
						return $nuevoUsuario;
						
						break;
					} // foreach( $usuarioNuevo as $usuario ) {
				} // if( $usuarioNuevo == false ) { ... elseif ...
			} // if( $insercion == false ) { ... else ...
		} // if( $resultados == false ) { ... elseif ... else ...
		
	} // public function agregarUsuario($nombre,$correo,$curriculum,$matricula,$nivelDeEstudios, $tipos = NULL) {
	
	
	public function agregarGrupo($idMateria, $idProfesor, $idPeriodo) {
		
		// Consulta a tabla de grupos
		$resultados = $this->bd->query("SELECT * FROM grupos WHERE id_materia = " . $this->bd->escapar($idMateria) . " AND id_profesor = " . $this->bd->escapar($idProfesor) . " AND id_periodo = " . $this->bd->escapar($idPeriodo));
		
		if( $resultados == false ) {
			
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
			
		} elseif( $resultados->num_rows > 0 ) {
			require_once('grupo.class.php');
			
			foreach( $resultados as $resultado ) {
				return new Grupo($resultado['id']);
				break;
			} // foreach( $resultados as $resultado ) {
			
		} else {
			
			$insercion = $this->bd->query("INSERT INTO grupos (id_materia,id_profesor,id_periodo) VALUES (" . $this->bd->escapar($idMateria) . "," . $this->bd->escapar($idProfesor) . "," . $this->bd->escapar($idPeriodo) . ")");
			
			if( $insercion == false ) { echo 'Hubo un error con la base de datos:' . $this->bd->error(); }
			
			$grupos = $this->bd->query("SELECT * FROM grupos WHERE id_materia = " . $this->bd->escapar($idMateria) . " AND id_profesor = " . $this->bd->escapar($idProfesor) . " AND id_periodo = " . $this->bd->escapar($idPeriodo));
			
			require_once('grupo.class.php');
			
			foreach( $grupos as $grupo ) {
				return new Grupo($grupo['id']);
				break;
			} // foreach( $resultados as $resultado ) {
			
		} // if( $resultados == false ) { ... elseif ... else ...
	} // public function agregarGrupo($idMateria, $idProfesor, $periodo, $estudiantes = NULL) {
	
	
	public function agregarMateria($nombre,$contenidos = NULL) {
		$resultados = $this->bd->query("SELECT * FROM materia WHERE nombre = " . $this->bd->escapar($nombre));
		
		if( $resultados == false ) {
			
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
			
		} elseif( empty( $resultados ) ) {
			$this->bd->query("INSERT INTO materia (nombre) VALUES (" . $this->bd->escapar($nombre));
			
			$idMateria = $this->bd->idInsertado();
			
			if( !empty($contenidos) ) {
				$materias = $this->bd->query("SELECT * FROM materia WHERE nombre = " . $this->bd->escapar($nombre));
				
				foreach( $materias as $materia ) {
					foreach( $contenidos as $contenido ) {
						if( count($contenido) == 4 ) {
							$modulo				=	$this->bd->escapar($contenido['modulo']);
							$informacion		=	$this->bd->escapar($contenido['informacion']);
							$tipoDeAprendizaje	=	$this->bd->escapar($contenido['tipo_de_aprendizaje']);
							$tipoDeContenido	=	$this->bd->escapar($contenido['tipo_de_contenido']);
							
							$this->bd->query("INSERT INTO contenidos (modulo, informacion, tipo_de_aprendizaje, tipo_de_contenido) VALUES (" . $modulo . ", " . $informacion . ", " . $tipoDeAprendizaje . ", " . $tipoDeContenido);
							
							$idContenido = $this->bd->idInsertado();
							
							$this->bd->query("INSERT INTO tema (id_materia, id_contenido) VALUES (" . $idMateria . ", " . $idContenido . ")");
						} // if( count($contenido) == 4 ) {
					} // foreach( $contenidos as $contenido ) {
					
					break;
				} // foreach( $materias as $materia ) {
			} // if( !empty($contenidos) ) {
		} else {
			echo 'La materia "' . $nombre . '" ya existe.';
		} // if( $resultados == false ) { ... elseif ... else ...
	} // public function agregarMateria($nombre,$tema) {
	
	
	public function agregarPeriodo($nombre, $descripcion) {
		$resultados = $this->bd->query("SELECT * FROM periodos WHERE nombre = " . $this->bd->escapar($nombre));
		
		if( $resultados == false ) {
			
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
			
		} elseif( $resultados->num_rows == 0 ) {
			
			$this->bd->query("INSERT INTO periodos (nombre, descripcion) VALUES (" . $this->bd->escapar($nombre) . ", " . $this->bd->escapar($descripcion) . ")");
			
		} else {
			
			echo 'El periodo ya existe.';
			
		} // if( $resultados == false ) { ... elseif ... else ...
	} // public function agregarPeriodo($nombre, $descripcion) {
	
	
	public function asignarProfesor($idProfesor, $idGrupo) {
		require_once('grupo.class.php');
		
		$grupo = new Grupo($idGrupo);
		
		$grupo->setIdProfesor($idProfesor);
	} // public function asignarProfesor() {
} // class Administrador extends Usuario {
?>