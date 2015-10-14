<?php
// Acciones de administrador
// – Alta de usuarios
// – Alta de materias
// – Alta de grupos


$mensajeError = '';

// Si el usuario está registrado
// instancia un objeto de clase usuario
//
if( $validado && isset( $_POST['agregar-usuario'] ) ) {
	
	if( !isset($bd) ) {
		require_once('inc/db/bd.class.php');
		$bd = new BD();
	} // if( !isset($bd) ) {
	
	$errorFormulario = false;
	
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
		
		$nuevoUsuario = $administrador->agregarUsuario(trim( $_POST['nombre'] ), trim( $_POST['correo'] ), trim( $_POST['contrasena'] ), trim( $_POST['matricula'] ), trim( $_POST['curriculum'] ), trim( $_POST['nivel-estudios'] ), $_POST['tipo'] );
		
	} else {
		echo 'ERROR: <br>' . $mensajeError;
	} // if( !$errorFormulario ) {
	
	/*
	// Inserta nuevo usuario
	$resultado = $this->bd->query("INSERT INTO tipo_usuario (id_usuario,id_tipo) VALUES (" . $this->id . "," . $bd->escapar($idTipo) . ")");
	
	// $resultado = $this->bd->query("INSERT INTO tipo_usuario (id_usuario,id_tipo) VALUES (" . $this->id . "," . $bd->escapar($idTipo) . ")");
	
	if( $resultado == false ) {
		echo 'Hubo un error con la base de datos:' . $this->bd->error();
	} else {
	} // if( $resultado == false ) { ... else ...
	*/
	
} // if( $validado && isset( $_POST['agregar-usuario'] ) ) {


?>