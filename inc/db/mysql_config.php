<?php

// Accesos a la base de datos
$config = parse_ini_file('config.ini');

// Conexión a base de datos
$conexion = new mysqli('localhost', $config['usuario'], $confi['contrasena'], $config['nombre_bd']);

// Prueba de conexión
if ($conexion->connect_error) {
	die('Error de Conexión (' . $conexion->connect_errno . ') ' . $conexion->connect_error);
} // if ($conexion->connect_error) {




?>