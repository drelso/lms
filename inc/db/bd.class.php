<?php

class BD {
	// Conexión a la base de datos
	protected static $conexion;
	
	// Conectar a base de datos
	// @return Error de MySQL / conexión a base de datos
	//
	public function conectar() {
		if(!isset(self::$conexion)) {
			// Accesos a la base de datos como arreglo
			$config = parse_ini_file('config.ini');
			
			if($config == false) { echo 'Error con el archivo de inicialización.'; }
			
			// Conexión a base de datos
			self::$conexion = new mysqli($config['hostname'], $config['username'], $config['password'], $config['dbname']);
			
			mysqli_set_charset(self::$conexion, "utf8");
			
			// Prueba de conexión
			if (self::$conexion === false) {
				$errorNumero = $conexion->connect_errno;
				$errorNombre = $conexion->connect_error;
				
				echo ('Error de Conexión (' . $errorNumero . ') ' . $errorNombre);
				
				unset(self::$conexion);
				return false;
				//('Error de Conexión (' . $errorNumero . ') ' . $errorNombre);
			} // if ($conexion->connect_error) {
		} // if(!isset($conexion)) {
		
		return self::$conexion;
	} // public conectar() {
	
	// Query a la base de datos
	// @param $query La cadena del query
	// @return mixto El resultado de mysqli::query()
	//
	public function query($query) {
		$conexion = $this->conectar();
		
		$resultado = $conexion->query($query);
		
		return $resultado;
	} // public function bd_query() {
	
	// Último error de la base de datos
	// @return string Mensaje de error de la base de datos
	public function error() {
        $conexion = $this->conectar();
        return $conexion->error;
    } // public function error() {
	
	// Escapa los valores de las variables para usar en un query
	// @param string $valor Valor a escapar
	// @return string La cadena escapada
	//
	public function escapar($valor) {
		$conexion = $this->conectar();
		return ("'" . $conexion->real_escape_string($valor) . "'");
    } // public function escapar($valor) {
	
} // class conexionDB {


?>