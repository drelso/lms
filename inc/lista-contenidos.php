<?php
// Listado de contenidos

//if(isset($_SESSION['usuario_registrado'])) { }

if(isset($usuario)) {
	
	require_once('inc/func/mostrargrupos.func.php');
	
	if(isset($tipo['id'])) {
		
		require_once('inc/db/bd.class.php');
		$bd = new BD();
		
		switch($tipo['id']) {
			case 1:
				include_once('inc/usuarios/panel-admin.php');
				echo mostrarGrupos($bd, 1);
				break;
			case 2:
				echo mostrarGrupos($bd, 2, 'WHERE id_profesor = ' . $usuario->getID());
				break;
			case 3:
				require_once('inc/clases/estudiante.class.php');
				
				$estudiante = new Estudiante($usuario->getID());
				
				$where = '';
				$primero = true;
				
				foreach( $estudiante->getIdGrupos() as $idGrupo) {
					if( $primero ) {
						$where .= 'WHERE id = ' . $idGrupo . ' ';
						$primero = false;
					} else {
						$where .= ' OR id = ' . $idGrupo . ' ';
					} // if( $primero ) { ... else ...
					
				} // foreach( $estudiante->getIdGrupos() as $idGrupo) {
				
				echo mostrarGrupos($bd, 3, $where);
				
				break;
			default:
				echo 'Tipo de usuario no registrado';
		} // switch($tipo['id']) {
	} // if(isset($_GET['tipo'])) {
	
	
	
} // if(isset($usuario)) {
?>