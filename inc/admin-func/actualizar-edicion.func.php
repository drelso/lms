<?php
echo 'Actualizando usuario\n';

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
				
				echo 'Cambió nombre';
				
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
				
				echo 'Cambió matrícula';
				
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
				
				echo 'Cambió correo';
				
			} // if( !empty( $_POST['correo'] ) &&
			
		} // if( isset( $_POST['correo'] ) {
		
		
		// Si existe el campo curriculum
		// y es diferente del curriculum actual
		// modifica el curriculum
		if( isset( $_POST['curriculum'] ) ) {
			
			if( $_POST['curriculum'] !== $usuario->getCurriculum() ) {
				
				$usuario->setCurriculum( $_POST['curriculum'] );
				
				echo 'Cambió cv';
				
			} // if( $_POST['curriculum'] !== $usuario->getCurriculum() ) {
			
		} // if( isset( $_POST['curriculum'] ) {
		
		
		// Si existe el campo nivel de estudios
		// y es diferente del nivel de estudios actual
		// modifica el nivel de estudios
		if( isset( $_POST['nivelEstudios'] ) ) {
			
			if( !empty( $_POST['nivelEstudios'] ) &&
				$_POST['nivelEstudios'] !== $usuario->getNivelDeEstudios() ) {
				
				$usuario->setNivelDeEstudios( $_POST['nivel-estudios'] );
				
				echo 'Cambió nivel de estudios';
				
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
					
					echo 'Los arreglos son diferentes';
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
				
				echo 'Los arreglos son diferentes';
			} // if( $idDeptos == $_POST['departamento'] ) {
			
		} // if( isset( $_POST['departamento'] ) {
		
		
	} // if( $_POST['modo'] == 'usuario' ) {
	
} // if( isset( $_POST['modo'] ) ) {
?>