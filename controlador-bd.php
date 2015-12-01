<?php
// Controlador de base de datos
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


$validado = false;
$administrador = NULL;

require_once( __DIR__ . '/inc/config/config.php');

if( isset( $_SESSION['usuario_registrado'] ) ) {
	
	require_once( __DIR__ . '/inc/clases/administrador.class.php');
	$id = intval( $_SESSION['usuario_registrado'] );
	
	if($id > 0) {
		$administrador = new Administrador( $id );
	} // if($id > 0) {
	
	if( isset( $_SESSION['tipo_usuario'] ) ) {
		
		if( in_array( '1', $_SESSION['tipo_usuario'] ) ) {
			$validado = true;
		} // if( in_array( '1', $_SESSION['tipo_usuario'] ) ) {
			
	} else {
		
		foreach( $administrador->getTipo() as $tipoUsuario ) {
			if( $tipoUsuario['id'] == 1 ) { $validado = true; }
		} // foreach( $usuario->getTipo() as $tipoUsuario ) {
		
	} // if( isset( $_SESSION['tipo_usuario'] ) ) {
	
	if( $validado ) {
		
		require_once( __DIR__ . '/inc/db/bd.class.php' );
		$bd = new BD();
		
		// Agrega una materia nueva
		if( isset( $_POST['agregar-materia'] ) ) {
			if( $_POST['agregar-materia'] == '1'
				&& isset( $_POST['clave'] )
				&& isset( $_POST['nombre'] ) ) {
				
				$insercion = $bd->query("INSERT INTO materia (id, nombre) VALUES (" . $bd->escapar( $_POST['clave'] ) . ", " . $bd->escapar( $_POST['nombre'] ) . ")");
				
				if( $insercion == false ) {
					$mensajeError = 'Hubo un error con la base de datos:' . $bd->error();
					
					// Redirige al usuario para agregar una materia
					header( 'Location: ' . BASEDIR . '?error=' . htmlentities( urlencode( $mensajeError ) ) );
					die();
					
				} else {
				
					// Redirige al usuario para agregar una materia
					header( 'Location: ' . BASEDIR . '/editar-materia.php?id=' . htmlentities( urlencode( $_POST['clave'] ) ) );
					die();
					
				} // if( $insercion == false ) {
			} // if( $_POST['agregar-materia'] == '1' ) {
		} // if( isset( $_POST['agregar-materia'] ) ) {
		
		
		// Agrega un departamento nuevo
		if( isset( $_POST['agregar-departamento'] ) ) {
			if( $_POST['agregar-departamento'] == '1'
				&& isset( $_POST['clave'] )
				&& isset( $_POST['nombre'] )
				&& isset( $_POST['director'] ) ) {
				
				$insercion = $bd->query("INSERT INTO departamento (id, nombre, director) VALUES (" . $bd->escapar( $_POST['clave'] ) . ", " . $bd->escapar( $_POST['nombre'] ) . ", " . $bd->escapar( $_POST['director'] ) . ")");
				
				if( $insercion == false ) {
					$mensajeError = 'Hubo un error con la base de datos:' . $bd->error();
					
					// Redirige al usuario para agregar una materia
					header( 'Location: ' . BASEDIR . '?error=' . htmlentities( urlencode( $mensajeError ) ) );
					die();
					
				} else {
				
					// Redirige al usuario para agregar una materia
					header( 'Location: ' . BASEDIR . '?mensaje=' . htmlentities( urlencode( 'El departamento ' . $_POST['nombre'] . ' se agregó exitosamente' ) ) );
					die();
					
				} // if( $insercion == false ) {
			} // if( $_POST['agregar-departamento'] == '1' ) {
		} // if( isset( $_POST['agregar-departamento'] ) ) {
		
		
		
		// Agrega un usuario nuevo
		if( isset( $_POST['agregar-usuario'] ) && $_POST['agregar-usuario'] == '1' ) {
			$errorFormulario = false;
			$mensajeError = 'Error al agregar usuario:<br>';
			
			if(	( trim($_POST['nombre'] ) === '' ) ) {
				$errorFormulario = true;
				$mensajeError .= 'El nombre es un campo requerido<br>';
			} // if(	( trim($_POST['nombre'] ) === '' ) ) {
			
			if( trim($_POST['correo'] ) === '' ) {
				$errorFormulario = true;
				$mensajeError .= 'El correo es un campo requerido<br>';
			} // if( trim($_POST['correo'] ) === '' ) {
			
			if( !preg_match( "/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,9}$/i",
							trim( $_POST['correo'] ) ) ) {
				$errorFormulario = true;
				$mensajeError .= 'El correo ingresado no es válido<br>';
			} // if( !preg_match( "/^[[:alnum:]][a-z0-9_...
			
			if( strlen( trim( $_POST['contrasena'] ) ) < 8 ) {
				$errorFormulario = true;
				$mensajeError .= 'La contraseña debe contener al menos 8 caracteres<br>';
			} // if( strlen( trim( $_POST['contrasena'] ) ) < 8 ) {
			
			if( strcmp( trim( $_POST['contrasena'] ), trim( $_POST['confirmar-contrasena'] ) ) !== 0 ) {
				$errorFormulario = true;
				$mensajeError .= 'Las contraseñas ingresadas no coinciden<br>';
			} // if( strcmp( trim( $_POST['contrasena'] ), trim( $_POST['confirmar-contrasena'] ) ) !== 0 ) {
			
			if( empty( $_POST['tipo'] ) ) {
				$errorFormulario = true;
				$mensajeError .= 'Es necesario ingresar al menos un tipo para el usuario<br>';
			} // if( empty( $_POST['tipo'] ) ) {
			
			
			if( !$errorFormulario ) {
				
				// Almacenamiento de nuevo usuario en base de datos
				$departamentos = isset( $_POST['departamento'] ) ? $_POST['departamento'] : '';
				
				$nuevoUsuario = $administrador->agregarUsuario( trim( $_POST['nombre'] ), trim( $_POST['correo'] ), trim( $_POST['contrasena'] ), trim( $_POST['matricula'] ), trim( $_POST['curriculum'] ), trim( $_POST['nivel-estudios'] ), $_POST['tipo'], $departamentos );
				
				
				// Redirige al usuario para agregar una materia
				header( 'Location: ' . BASEDIR . '?mensaje=' . htmlentities( urlencode( 'El usuario ' . $_POST['nombre'] . ' se agregó exitosamente' ) ) );
				die();
					
			} else {
				
				// Redirige al usuario para agregar una materia
				header( 'Location: ' . BASEDIR . '?error=' . htmlentities( urlencode( $mensajeError ) ) );
				die();
					
			} // if( !$errorFormulario ) { ... else ...
		} // if( isset( $_POST['agregar-usuario'] ) ) {
		
		
		// Validación de nuevo grupo
		if( isset( $_POST['agregar-grupo'] ) ) {
			$errorFormulario = false;
			$mensajeError = 'Error al agregar grupo:<br>';
			
			if(	!isset( $_POST['profesor'] ) || $_POST['profesor'] == '0' ) {
				$errorFormulario = true;
				$mensajeError .= 'Debe elegir un profesor<br>';
			} // if(	!isset( $_POST['profesor'] ) ) {
			
			if(	!isset( $_POST['materia'] ) || $_POST['materia'] == '0' ) {
				$errorFormulario = true;
				$mensajeError .= 'Debe elegir una materia<br>';
			} // if(	!isset( $_POST['materia'] ) ) {
			
			if(	!isset( $_POST['periodo'] ) || $_POST['periodo'] == '0' ) {
				$errorFormulario = true;
				$mensajeError .= 'Debe elegir un periodo<br>';
			} // if(	!isset( $_POST['periodo'] ) ) {
			
			if( !$errorFormulario ) {
				
				
				// Almacenamiento de nuevo grupo de base de datos
				$nuevoGrupo = $administrador->agregarGrupo( $_POST['materia'], $_POST['profesor'],  $_POST['periodo'], $_POST['numero'] );
				
				// Redirige al usuario tras agregar un grupo
				header( 'Location: ' . BASEDIR . '?mensaje=' . htmlentities( urlencode( 'El grupo se agregó exitosamente' ) ) );
				die();
				
			} else {
				
				// Redirige al usuario tras fallar al agregar un grupo
				header( 'Location: ' . BASEDIR . '?mensaje=' . htmlentities( urlencode( $mensajeError ) ) );
				die();
				
			} // if( !$errorFormulario ) { ... else ...
		} // if( isset( $_POST['agregar-grupo'] ) ) {
		
		
		// Validación de nuevo periodo
		if( isset( $_POST['agregar-periodo'] ) ) {
			$errorFormulario = false;
			$mensajeError = 'Error al agregar periodo:<br>';
			
			if(	!isset( $_POST['nombre'] ) ) {
				$errorFormulario = true;
				$mensajeError .= 'El campo de nombre es obligatorio<br>';
			} // if(	!isset( $_POST['profesor'] ) ) {
			
			if(	!isset( $_POST['descripcion'] ) ) {
				$errorFormulario = true;
				$mensajeError .= 'El campo de descripción es obligatorio<br>';
			} // if(	!isset( $_POST['materia'] ) ) {
			
			if( !$errorFormulario ) {
				
				// Almacenamiento de nuevo periodo de base de datos
				$nuevoPeriodo = $administrador->agregarPeriodo( trim( $_POST['nombre'] ), trim( $_POST['descripcion'] ) );
				
				// Redirige al usuario tras agregar un periodo
				header( 'Location: ' . BASEDIR . '?mensaje=' . htmlentities( urlencode( 'El periodo ' . trim( $_POST['nombre'] ) . ' se agregó exitosamente' ) ) );
				die();
				
			} else {
				
				// Redirige al usuario tras fallar al agregar un periodo
				header( 'Location: ' . BASEDIR . '?mensaje=' . htmlentities( urlencode( $mensajeError ) ) );
				die();
				
			} // if( !$errorFormulario ) { ... else ...
		} // if( isset( $_POST['agregar-grupo'] ) ) {
		
		
		
		// Edita una materia existente
		if( isset( $_POST['agregar-tema-enviado'] ) ) {
			
			
			
		} // if( isset( $_POST['agregar-tema-enviado'] ) ) {
		
	} // if( $validado ) {
} else {
	header( 'Location: ' . BASEDIR );
	die();
} // if( isset( $_SESSION['usuario_registrado'] ) ) {
?>