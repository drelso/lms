<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if( isset( $_POST['modo'] ) &&
	isset( $_POST['id'] ) ) {
	
	if( $_POST['modo'] == 'usuario' ) {
		
		require_once('../clases/usuario.class.php');
		$usuario = new Usuario( intval( $_POST['id'] ) );
		
		//var_dump($usuario);
		
		// Si existe el campo nombre,
		// no es una cadena vacía
		// y es diferente del nombre actual
		// modifica el nombre
		if( isset( $_POST['nombre'] ) ) {
			
			if( !empty( $_POST['nombre'] ) &&
				$_POST['nombre'] !== $usuario->getNombre() ) {
				
				$usuario->setNombre( $_POST['nombre'] );
				
				echo 'Cambió nombre<br>';
				
			} // if( !empty( $_POST['nombre'] ) && ...
			
		} // if( isset( $_POST['nombre'] ) {
		
		
		// Si existe el campo matrícula,
		// no es una cadena vacía
		// y es diferente de la matrícula actual
		// modifica la matrícula
		if( isset( $_POST['matricula'] ) ) {
			
			if( !empty( $_POST['matricula'] ) &&
				$_POST['matricula'] !== $usuario->getMatricula() ) {
				
				$usuario->setMatricula( $_POST['matricula'] );
				
				echo 'Cambió matrícula<br>';
				
			} // if( !empty( $_POST['matricula'] ) && ...
			
		} // if( isset( $_POST['matricula'] ) {
		
		
		// Si existe el campo correo,
		// no es una cadena vacía
		// y es diferente del correo actual
		// modifica el correo
		if( isset( $_POST['correo'] ) ) {
			
			if( !empty( $_POST['correo'] ) &&
				$_POST['correo'] !== $usuario->getCorreo() ) {
				
				$usuario->setCorreo( $_POST['correo'] );
				
				echo 'Cambió correo<br>';
				
			} // if( !empty( $_POST['correo'] ) &&
			
		} // if( isset( $_POST['correo'] ) {
		
		
		// Si existe el campo curriculum
		// y es diferente del curriculum actual
		// modifica el curriculum
		if( isset( $_POST['curriculum'] ) ) {
			
			if( $_POST['curriculum'] !== $usuario->getCurriculum() ) {
				
				$usuario->setCurriculum( $_POST['curriculum'] );
				
				echo 'Cambió CV<br>';
				
			} // if( $_POST['curriculum'] !== $usuario->getCurriculum() ) {
			
		} // if( isset( $_POST['curriculum'] ) {
		
		
		// Si existe el campo nivel de estudios
		// y es diferente del nivel de estudios actual
		// modifica el nivel de estudios
		if( isset( $_POST['nivelEstudios'] ) ) {
			
			if( !empty( $_POST['nivelEstudios'] ) &&
				$_POST['nivelEstudios'] !== $usuario->getNivelDeEstudios() ) {
				
				$usuario->setNivelDeEstudios( $_POST['nivelEstudios'] );
				
				echo 'Cambió nivel de estudios<br>';
				
			} // if( $_POST['nivel-estudios'] !== '' && ...
			
		} // if( isset( $_POST['nivel-estudios'] ) {
		
		
		// Si existe el campo contraseña,
		// no es una cadena vacía
		// y coincide con la confirmación
		// modifica la contraseña
		if( isset( $_POST['contrasena'] ) ) {
			
			if( !empty( $_POST['contrasena'] ) &&
				$_POST['contrasena'] === $_POST['confirmarContrasena'] ) {
				
				$usuario->setContrasena( $_POST['contrasena'] );
				
				echo 'Cambió contraseña';
				
			} // if( !empty( $_POST['contrasena'] ) && ...
			
		} // if( isset( $_POST['contrasena'] ) {
		
		
		// Si existe el campo tipo, tiene tipos
		// y los tipos son diferentes a los anteriores
		// modifica los tipos
		if( isset( $_POST['tipo'] ) ) {
			
			if( !empty( $_POST['tipo'] ) ) {
				
				$tiposActuales = $usuario->getTipo();
				
				$idTipos = array();
				
				foreach( $tiposActuales as $tipoActual ) {
					
					array_push( $idTipos, $tipoActual['id'] );
					
				} // foreach( $tiposActuales as $tipoActual ) {
				
				sort( $idTipos );
				sort( $_POST['tipo'] );
				
				if( $idTipos != $_POST['tipo'] ) {
					
					$usuario->setTipo( $_POST['tipo'] );
					
					echo '
					Los tipos cambiaron';
				} // if( $idTipos == $_POST['tipo'] ) {
				
			} // if( !empty( $_POST['tipo'] ) ) {
			
		} // if( isset( $_POST['tipo'] ) {
			
		
		// Si existe el campo departamento
		// y los departamentos son diferentes a los anteriores
		// modifica los departamentos
		if( isset( $_POST['departamento'] ) ) {
			
			$deptosActuales = $usuario->getDepartamentos();
			
			$idDeptos = array();
			
			foreach( $deptosActuales as $deptoActual ) {
				
				array_push( $idDeptos, $deptoActual['id'] );
				
			} // foreach( $deptosActuales as $deptoActual ) {
			
			sort( $idDeptos );
			sort( $_POST['departamento'] );
			
			if( $idDeptos != $_POST['departamento'] ) {
				
				$usuario->setDepartamentos( $_POST['departamento'] );
				
				echo '
				Los departamentos cambiaron';
			} // if( $idDeptos == $_POST['departamento'] ) {
			
		} // if( isset( $_POST['departamento'] ) {
		
		
	} // if( $_POST['modo'] == 'usuario' ) {
	
	
	if( $_POST['modo'] == 'eliminar-usuario' ) {
		
		echo 'Modo eliminar usuario';
		
		if( isset( $_SESSION['usuario_registrado'] ) ) {
			$idAdmin = intval( $_SESSION['usuario_registrado'] );
			
			echo 'Existe la variable de sesión';
			
			if( $idAdmin > 0 ) {
				require_once('../clases/administrador.class.php');
				$administrador = new Administrador( $idAdmin );
			} // if($id > 0) {
			
			if( isset( $administrador ) && !empty( $administrador ) ) {
				
				$id = intval( $_POST['id'] );
				
				echo 'A punto de eliminar al usuario ' . $id;
				$administrador->eliminarUsuario( $id );
				
			} // if( isset( $administrador ) && !empty( $administrador ) ) {
			
		} // if( isset( $_SESSION['usuario_registrado'] ) ) {
	} // if( $_POST['modo'] == 'eliminar-usuario' ) {
	
	
	if( $_POST['modo'] == 'grupo' ) {
		
		if( isset( $_SESSION['usuario_registrado'] ) ) {
			$idAdmin = intval( $_SESSION['usuario_registrado'] );
			
			echo 'Existe la variable de sesión';
			
			if( $idAdmin > 0 ) {
				require_once('../clases/administrador.class.php');
				$administrador = new Administrador( $idAdmin );
			} // if($id > 0) {
			
			if( isset( $administrador ) && !empty( $administrador ) ) {
				
				$id = intval( $_POST['id'] );
				
				require_once('../clases/grupo.class.php');
				$grupo = new Grupo( $id );
				
				if( !empty( $_POST['profesor'] ) &&
					$_POST['profesor'] !== $grupo->getIdProfesor() ) {
					
					$grupo->setIdProfesor( intval( $_POST['profesor'] ) );
					
					echo '
					Cambió profesor';
					
				} // if( !empty( $_POST['profesor'] ) && ...
				
				if( !empty( $_POST['materia'] ) &&
					$_POST['materia'] !== $grupo->getIdMateria() ) {
					
					$grupo->setIdMateria( intval( $_POST['materia'] ) );
					
					echo '
					Cambió materia';
					
				} // if( !empty( $_POST['materia'] ) && ...
				
				if( !empty( $_POST['periodo'] ) &&
					$_POST['periodo'] !== $grupo->getPeriodo() ) {
					
					$grupo->setPeriodo( $_POST['periodo'] );
					
					echo '
					Cambió periodo';
					
				} // if( !empty( $_POST['periodo'] ) && ...
				
				if( !empty( $_POST['numero'] ) &&
					$_POST['numero'] !== $grupo->getNumero() ) {
					
					$grupo->setNumero( intval( $_POST['numero'] ) );
					
					echo '
					Cambió número';
					
				} // if( !empty( $_POST['numero'] ) && ...
				
				echo '
				Edición del grupo ' . $id;
				
			} // if( isset( $administrador ) && !empty( $administrador ) ) {
			
		} // if( isset( $_SESSION['usuario_registrado'] ) ) {
	} // if( $_POST['modo'] == 'eliminar-usuario' ) {
	
} // if( isset( $_POST['modo'] ) && ...
?>