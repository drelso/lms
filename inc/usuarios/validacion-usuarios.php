<?php
// Validación de usuarios

require_once('../config/config.php');

if(isset($_POST['envio'])) {
	if(isset($_POST['correo']) && isset($_POST['contrasena'])) {
		if($_POST['correo'] !== '' && $_POST['contrasena'] !== '') {
			require_once('../db/bd.class.php');
			
			$bd = new BD();
			
			$correo = $bd->escapar($_POST['correo']);
			$contrasena = $bd->escapar($_POST['contrasena']);
			
			$resultados = $bd->query("SELECT * FROM usuarios WHERE correo = " . $correo);
			
			if($resultados == false) { echo 'Hubo un error con la base de datos:' . $bd->error(); }
			
			foreach($resultados as $resultado) {
				if (password_verify($_POST['contrasena'], $resultado['contrasena'])) {
					// La contraseña es válida
					session_start();
					$_SESSION['usuario_registrado'] = $resultado['id'];
				} else {
					// La contraseña es inválida
					session_destroy();
				} // if (password_verify($_POST['contrasena'], $resultado['contrasena'])) {
				
			} // foreach($resultados as $resultado) {
		} // if($_POST['usuario'] !== '' && $_POST['contrasena'] !== '') {
	} // if(isset($_POST['usuario']) && isset($_POST['contrasena'])) {
} // if(isset($_POST['envio'])) {

if(!isset($_SESSION['usuario_registrado'])) {
	$variables = (isset($_POST['correo'])) ? '?ingreso=invalido&correo=' . $_POST['correo'] : '';
} // if(!isset($_SESSION['usuario_registrado'])) {

header('Location: ' . BASEDIR . $variables);
die();
?>