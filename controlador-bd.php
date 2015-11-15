<?php
// Controlador de base de datos

session_start();

$validado = false;

require_once( __DIR__ . '/inc/config/config.php');

if( isset( $_SESSION['usuario_registrado'] ) ) {
	if( isset( $_SESSION['tipo_usuario'] ) ) {
		if( in_array( '1', $_SESSION['tipo_usuario'] ) ) {
			$validado = true;
		} // if( in_array( '1', $_SESSION['tipo_usuario'] ) ) {
	} else {
		
		require_once( __DIR__ . '/inc/clases/administrador.class.php');
		
		$id = intval( $_SESSION['usuario_registrado'] );
		
		if($id > 0) {
			$administrador = new Administrador( $id );
		} // if($id > 0) {
		
		foreach( $administrador->getTipo() as $tipoUsuario ) {
			if( $tipoUsuario['id'] == 1 ) { $validado = true; }
		} // foreach( $usuario->getTipo() as $tipoUsuario ) {
		
	} // if( isset( $_SESSION['tipo_usuario'] ) ) {
	
	if( $validado ) {
		
		require_once( __DIR__ . '/inc/db/bd.class.php' );
		$bd = new BD();
		
		if( isset( $_POST['agregar-materia'] ) ) {
			if( $_POST['agregar-materia'] == '1' ) {
				
				$insercion = $bd->query("INSERT INTO materia (nombre) VALUES (" . $bd->escapar( $_POST['nombre'] ) . ")");
				
				if( $insercion == false ) {
					$mensajeError = 'Hubo un error con la base de datos:' . $bd->error();
					
					// Redirige al usuario para agregar una materia
					header( 'Location: ' . BASEDIR . '/agregar-materia.php?error=' . htmlentities( urlencode( $mensajeError ) ) );
					die();
					
				} else {
				
					// Redirige al usuario para agregar una materia
					header( 'Location: ' . BASEDIR . '/editar-materia.php?id=' . intval( $bd->idInsertado() ) );
					die();
					
				} // if( $insercion == false ) {
			} // if( $_POST['agregar-materia'] == '1' ) {
		} // if( isset( $_POST['agregar-materia'] ) ) {
	} // if( $validado ) {
} else {
	header( 'Location: ' . BASEDIR );
	die();
} // if( isset( $_SESSION['usuario_registrado'] ) ) {
?>