<?php

if( isset( $_POST['clave'] )
	&& isset( $_POST['tabla'] ) ) {
	
	require_once('../db/bd.class.php');
	$bd = new BD();
	
	// Consulta a tabla de tipos de materia
	$existeClave = $bd->query("SELECT * FROM  " . $_POST['tabla'] . " WHERE id = " . $bd->escapar( $_POST['clave'] ) );
	
	if( $existeClave == false ) {
		echo 'Hubo un error con la base de datos:' . $bd->error();
	} else {
		
		if( $existeClave->num_rows == 0 ) {
			
			echo '0';
			
		} else {
			
			echo '1';
			
		} // if( $existeClave->num_rows == 0 ) {
		
	} // if($existeClave == false) { ... else ...
	
} // if( isset( $_POST['confirmar-clave'] ) ) {

?>