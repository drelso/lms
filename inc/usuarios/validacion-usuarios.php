<?php
// Validación de usuarios

require_once( __DIR__ . '/../config/config.php' );

if( isset( $_POST['envio'] ) ) {
	if( isset( $_POST['correo'] ) && isset( $_POST['contrasena'] ) ) {
		if( $_POST['correo'] !== '' && $_POST['contrasena'] !== '' ) {
			require_once( __DIR__ . '/../db/bd.class.php' );
			
			$bd = new BD();
			
			$correo = $bd->escapar( $_POST['correo'] );
			$contrasena = $bd->escapar( $_POST['contrasena'] );
			
			$resultados = $bd->query("SELECT * FROM usuarios WHERE correo = " . $correo);
			
			if($resultados == false) {
				echo 'Hubo un error con la base de datos:' . $bd->error();
			} else {
			
				foreach($resultados as $resultado) {
					if( password_verify( $_POST['contrasena'], $resultado['contrasena'] ) ) {
						// La contraseña es válida
						session_start();
						$_SESSION['usuario_registrado'] = $resultado['id'];
						
						require_once( __DIR__ . '/../clases/usuario.class.php' );
		
						$id = intval( $resultado['id'] );
						
						$usuario;
						
						if( $id > 0 ) {
							$usuario = new Usuario( $id );
						} // if($id > 0) {
						
						$_SESSION['tipo_usuario'] = array();
						
						if( isset( $usuario ) && !empty( $usuario ) ) {
							foreach( $usuario->getTipo() as $tipoUsuario ) {
								array_push( $_SESSION['tipo_usuario'], $tipoUsuario['id'] );
							} // foreach( $usuario->getTipo() as $tipoUsuario ) {
						} // if( isset( $usuario ) && !empty( $usuario ) ) {
						
					} else {
						// La contraseña es inválida
						session_unset();
					} // if (password_verify($_POST['contrasena'], $resultado['contrasena'])) {
					
				} // foreach($resultados as $resultado) {
				
			} // if($resultados == false) {
		} // if($_POST['usuario'] !== '' && $_POST['contrasena'] !== '') {
	} // if(isset($_POST['usuario']) && isset($_POST['contrasena'])) {
} // if(isset($_POST['envio'])) {

$variables = '';

if( !isset( $_SESSION['usuario_registrado'] ) ) {
	$variables = ( isset( $_POST['correo'] ) ) ? '?ingreso=invalido&correo=' . $_POST['correo'] : '';
} // if(!isset($_SESSION['usuario_registrado'])) {

header('Location: ' . BASEDIR . $variables);
die();
?>