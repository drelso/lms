<?php
include('inc/header.php');

if(isset($_SESSION['usuario_registrado'])) {
	include('inc/usuarios/cuenta-usuario.php');
} else {
	include('inc/ingreso.php');
} // if(!isset($_SESSION['usuario_registrado'])) {

include('inc/footer.php'); ?>