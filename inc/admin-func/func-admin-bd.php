<?php
// Acciones de administrador
// – Alta de usuarios
// – Alta de grupos
// – Alta de periodos


// Si el usuario está registrado
// instancia un objeto de clase usuario
//
if( $validado ) {
	
	if( !isset($bd) ) {
		require_once('inc/db/bd.class.php');
		$bd = new BD();
	} // if( !isset($bd) ) {
	
	
	// Validación para agregar usuario
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
			$output = 'Nuevo usuario agregado:<br>';
			$output .= trim( $_POST['nombre'] ) . '<br>';
			$output .= trim( $_POST['matricula'] ) . '<br>';
			$output .= trim( $_POST['correo'] ) . '<br>';
			$output .= trim( $_POST['curriculum'] ) . '<br>';
			$output .= trim( $_POST['nivel-estudios'] ) . '<br>';
			$output .= trim( $_POST['contrasena'] ) . '<br>';
			$output .= trim( $_POST['confirmar-contrasena'] ) . '<br>';
			
			if( !empty( $_POST['tipo'] ) ) {
				foreach( $_POST['tipo'] as $tipo ) {
					$output .= $tipo . '<br>';
				} // foreach( $_POST['tipo'] as $tipo ) {
			} // if( !empty( $_POST['tipo'] ) ) {
			
			echo $output;
			
			// Almacenamiento de nuevo usuario en base de datos
			$nuevoUsuario = $administrador->agregarUsuario(trim( $_POST['nombre'] ), trim( $_POST['correo'] ), trim( $_POST['contrasena'] ), trim( $_POST['matricula'] ), trim( $_POST['curriculum'] ), trim( $_POST['nivel-estudios'] ), $_POST['tipo'] );
			
		} else {
			echo $mensajeError;
		} // if( !$errorFormulario ) {
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
			$output = 'Nuevo grupo agregado:<br>';
			$output .= trim( $_POST['profesor'] ) . '<br>';
			$output .= trim( $_POST['materia'] ) . '<br>';
			$output .= trim( $_POST['periodo'] ) . '<br>';
			
			echo $output;
			
			// Almacenamiento de nuevo grupo de base de datos
			$nuevoGrupo = $administrador->agregarGrupo( intval( $_POST['materia'] ), intval( $_POST['profesor'] ), intval( $_POST['periodo'] ) );
			
		} else {
			echo $mensajeError;
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
			$output = 'Nuevo periodo agregado:<br>';
			$output .= trim( $_POST['nombre'] ) . '<br>';
			$output .= trim( $_POST['descripcion'] ) . '<br>';
			
			echo $output;
			
			// Almacenamiento de nuevo periodo de base de datos
			$nuevoPeriodo = $administrador->agregarPeriodo( trim( $_POST['nombre'] ), trim( $_POST['descripcion'] ) );
			
		} else {
			echo $mensajeError;
		} // if( !$errorFormulario ) { ... else ...
	} // if( isset( $_POST['agregar-grupo'] ) ) {
	
} // if( $validado && isset( $_POST['agregar-usuario'] ) ) {


?>