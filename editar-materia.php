<?php
// Agregar materia

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once( 'inc/config/config.php' );

echo 'Editar materia';

if( isset( $_GET['error'] ) ) {
	echo '<h1 class="mensaje-error">' . urldecode( $_GET['error'] ) . '</h1>';
} else {

	if( isset( $_GET['id'] ) ) {
		
		require_once( 'inc/db/bd.class.php' );
		$bd = new BD();
		
		// Consulta a tabla de usuarios
		$resultados = $bd->query("SELECT * FROM materia WHERE id = " . $bd->escapar( urldecode( $_GET['id'] ) ) );
		
		if( $resultados == false ) {
			echo 'Hubo un error con la base de datos:' . $bd->error();
		} else {
			
			if( $resultados->num_rows > 0 ) {
				
				// Formulario para modificar el nombre de la materia
				$output = '<form action="" method="post" id="modificar-nombre-materia">';
				
				foreach( $resultados as $resultado ) {
					$output .= '<input type="text" name="nombre" value="' . $resultado['nombre'] . '" placeholder="Nombre de la materia" />';
					break;
				} // foreach($resultados as $resultado) {
				
				$output .= '<input type="submit" value="Actualizar" />';
				$output .= '<input type="hidden" name="modificar-nombre-materia" value="1" />';
				$output .= '</form>';
				
				
				
				echo $output;
			} // if( $resultados->num_rows > 0 ) {
		} // if( $resultados == false ) { ... else ...
		
		echo 'Materia agregada exitosamente: ' . $_GET['id'];
	} // if( isset( $_GET['id'] ) ) {
	
	
} // if( isset( $_GET['error'] ) ) { ... else ...
?>