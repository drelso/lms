<?php
// Registrar nuevo usuario

if(isset($_POST['envio'])) {
	require_once('inc/db/bd.class.php');
	
	$bd = new BD();
	
	$nombre = $bd->escapar('Diego Ramírez Echavarría');
	$correo = $bd->escapar('diegoraech@gmail.com');
	
	$curriculum = $bd->escapar('Licenciado en Producción Electrónica y Diseño de Audio. Candidato a Maestro en Ciencias de la Computación.');
	$contrasena = "'".password_hash('prueba', PASSWORD_BCRYPT)."'";
	
	echo '<br><br><br>';
	echo 'Datos: '.$nombre.' '.$correo.' '.$curriculum.' '.$contrasena;
	
	//$resultado = $bd->query("INSERT INTO `usuarios` (`nombre`,`correo`,`curriculum`,`contrasena`) VALUES (" . $nombre . "," . $correo . "," . $curriculum . "," . $contrasena . ")");
	
	//if($resultado == false) { echo 'Hubo un error con la base de datos.'; }
	
	/*
	$hash = '$2y$10$BrFTUqcx8HAzDNQfEOjw4O8U7Uq8W2.S47lNQ2wKycf6.mqo3uawu';
	
	if (password_verify('prueba', $hash)) {
		echo '¡La contraseña es válida!';
	} else {
		echo 'La contraseña no es válida.';
	}
	*/
} // if(isset($_POST['envio'])) {

?>