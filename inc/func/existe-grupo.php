<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if( isset( $_POST['materia'] )
	&& isset( $_POST['profesor'] )
	&& isset( $_POST['periodo'] )
	&& isset( $_POST['numero'] ) ) {
	
	require_once('../db/bd.class.php');
	$bd = new BD();
	
	// Consulta a tabla de tipos de materia
	$existeGrupo = $bd->query("SELECT * FROM grupos WHERE id_materia = " . $bd->escapar( $_POST['materia'] ) . " AND id_profesor = " . $bd->escapar( $_POST['profesor'] ) . " AND id_periodo = " . $bd->escapar( $_POST['periodo'] ) . " AND numero = " . $bd->escapar( $_POST['numero'] ) );
	
	if( $existeGrupo == false ) {
		echo 'Hubo un error con la base de datos:' . $bd->error();
	} else {
		
		if( $existeGrupo->num_rows == 0 ) {
			
			echo '0';
			
		} else {
			
			echo '1';
			
		} // if( $existeClave->num_rows == 0 ) {
		
	} // if($existeClave == false) { ... else ...
	
} // if( isset( $_POST['confirmar-clave'] ) ) {

?>