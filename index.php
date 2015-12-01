<?php
// Agrega el encabezado global
include('inc/header.php');

if( isset( $_GET['error'] ) ) {
	echo '<h1 class="mensaje-error">' . urldecode( $_GET['error'] ) . '</h1>';
}

if( isset( $_GET['mensaje'] ) ) {
	echo '<h1 class="mensaje-general">' . urldecode( $_GET['mensaje'] ) . '</h1>';
}

// Lee el mensaje de Logout
if( isset( $_GET['logout'] ) ) {
	session_unset();
} // if( isset( $_GET['logout'] ) ) {

// Si el usuario está registrado
// llama la sección de cuenta de usuario
// si no llama el formulario de ingreso
//
if(isset($_SESSION['usuario_registrado'])) {
	include('inc/usuarios/cuenta-usuario.php');
} else {
	include('inc/ingreso.php');
} // if(!isset($_SESSION['usuario_registrado'])) {

// Agrega el pie de página global
include('inc/footer.php');
?>