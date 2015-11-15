<?php
// Panel de administrador

session_start();

$id = 0;
$usuario;
$validado = false;

// Si el usuario está registrado
// instancia un objeto de clase Administrador
//
if( isset( $_SESSION['usuario_registrado'] ) ) {
	require_once('inc/clases/administrador.class.php');
	
	$id = intval( $_SESSION['usuario_registrado'] );
	
	if($id > 0) {
		$administrador = new Administrador( $id );
	} // if($id > 0) {
	
} // if(isset($_SESSION['usuario_registrado'])) {


// Si existe el objeto de clase usuario
// genera la estructura del perfil
//
if( isset( $administrador ) && !empty( $administrador ) ) {
	
	foreach( $administrador->getTipo() as $tipoUsuario ) {
		if( $tipoUsuario['id'] == 1 ) { $validado = true; }
	} // foreach( $usuario->getTipo() as $tipoUsuario ) {
	
	if( $validado ) {
	} // if( $validado ) {
} // if( isset( $administrador ) && !empty( $administrador ) ) {