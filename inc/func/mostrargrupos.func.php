<?php
// Funcion mostrarGrupos
// @param conexion: objeto de clase BD() para conexión con base de datos
// @param tipoUsuario: ID numérico para definir capacidades de edición de grupo
// @param where: discriminante para la base de datos
// @return: cadena con la lista de grupos
//

function mostrarGrupos($conexion, $tipoUsuario, $where = '') {
	
	// Consulta a tabla de grupos
	$grupos = $conexion->query("SELECT * FROM grupos " . $where);
	
	if($grupos == false) {
		return 'Hubo un error con la base de datos:' . $conexion->error();
	} else {
		
		$contenidoGrupos = '<ul class="grupos">';
		
		foreach( $grupos as $grupo ) {
			$contenidoGrupos .= '<li>';
			$contenidoGrupos .= '<h3>Grupo: ' . $grupo['id'] . '</h3>';
			
			// Consulta a tabla de materias
			$materias = $conexion->query("SELECT * FROM materia WHERE id = " . $grupo['id_materia']);
			if($materias == false) {
				return 'Hubo un error con la base de datos:' . $conexion->error();
			} else {
				
				foreach( $materias as $materia ) {
					$contenidoGrupos .= '<h1>' . $materia['nombre'] . '</h1>';
				} // foreach( $materias as $materia ) {
				
			} //  if($materias == false) { ... else ...
			
			// Consulta a tabla de usuarios
			$profesores = $conexion->query("SELECT * FROM usuarios WHERE id = " . $grupo['id_profesor']);
			
			if($profesores == false) {
				return 'Hubo un error con la base de datos:' . $conexion->error();
			} else {
				
				foreach( $profesores as $profesor ) {
					$contenidoGrupos .= '<h4>Profesor: ' . $profesor['nombre'] . '</h4>';
				} // foreach( $profesores as $profesor ) {
				
			} //  if($profesores == false) { ... else ...
			
			if($tipoUsuario == 1 || $tipoUsuario == 2) {
				$contenidoGrupos .= '<a href="#">Editar</a>';
			} // if($tipoUsuario == 1 || $tipoUsuario == 2) {
			
			$contenidoGrupos .= '</li> <!-- /grupo-' . $grupo['id'] . ' -->';
		} // foreach( $grupos as $grupo ) {
		
		$contenidoGrupos .= '</ul> <!-- /grupos -->';
		
		return $contenidoGrupos;
	} // if($resultados == false) { ... else ...
	
} // function mostrarGrupos($tipo, $where = NULL) {

?>