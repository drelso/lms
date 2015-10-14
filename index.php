<?php
// Agrega el encabezado global
include('inc/header.php');

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