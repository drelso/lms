<?php
// Editar

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once( 'inc/config/config.php' );

if( !isset( $_GET['modo'] ) ) {
	
	// Redirige al usuario si no se seleccionó un modo
	$mensajeError = 'Debe elegir una categoría para editar';
	header( 'Location: ' . BASEDIR . '?error=' . htmlentities( urlencode( $mensajeError ) ) );
	die();
	
} // if( !isset( $_GET['modo'] ) ) {

// Checa si la sesión ya existe
if( session_id() == '' || !isset( $_SESSION ) ) {
    session_start();
} // if( session_id() == '' || !isset( $_SESSION ) ) {

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
	
	if( isset( $_SESSION['tipo_usuario'] ) ) {
		if( in_array( '1', $_SESSION['tipo_usuario'] ) ) {
			$validado = true;
		} // if( in_array( '1', $_SESSION['tipo_usuario'] ) ) {
	} else {
		foreach( $administrador->getTipo() as $tipoUsuario ) {
			if( $tipoUsuario['id'] == 1 ) { $validado = true; }
		} // foreach( $usuario->getTipo() as $tipoUsuario ) {
	} // if( isset( $_SESSION['tipo_usuario'] ) ) {
	
	if( $validado ) {
		
		$tabla;
		$nombre;
		
		switch( $_GET['modo'] ) {
			case '1':
				$tabla	= 'usuarios';
				$nombre	= 'usuarios';
				break;
			case '2':
				$tabla	= 'grupos';
				$nombre	= 'grupos';
				break;
			case '3':
				$tabla	= 'periodos';
				$nombre	= 'periodos';
				break;
			case '4':
				$tabla	= 'materia';
				$nombre	= 'materias';
				break;
			case '5':
				$tabla	= 'departamento';
				$nombre	= 'departamentos';
				break;
			default:
				// Redirige al usuario si no se seleccionó un modo
				$mensajeError = 'El modo que eligió no es válido';
				header( 'Location: ' . BASEDIR . '?error=' . htmlentities( urlencode( $mensajeError ) ) );
				die();
		} // switch( $_GET['modo'] ) {
		
		echo 'Editar ' . $nombre;
		
		require_once( 'inc/db/bd.class.php' );
		$bd = new BD();
		
		// Consulta a tabla de usuarios
		$resultados = $bd->query("SELECT * FROM " . $tabla );
		
		if( $resultados == false ) {
			echo 'Hubo un error con la base de datos:' . $bd->error();
		} else {
			
			if( $resultados->num_rows > 0 ) {
				
				if( $tabla == 'usuarios' ) {
					foreach( $resultados as $resultado ) {
						
						// Formulario para editar usuarios ?>
						
                        <form action="<?= BASEDIR; ?>/controlador-bd.php" method="post" class="agregar-usuario" id="agregar-usuario-<?= $resultado['id']; ?>">
        
                            <h2>Usuario <?= $resultado['id']; ?></h2>
                            
                            <input type="text" name="nombre" placeholder="Nombre" value="<?= $resultado['nombre']; ?>" maxlength="255"/>
                            <h6 class="error-nombre"></h6>
                            
                            <input type="text" name="matricula" placeholder="Matrícula" value="<?= $resultado['matricula']; ?>" maxlength="10"/>
                            
                            <input type="text" name="correo" placeholder="Correo" value="<?= $resultado['correo']; ?>" maxlength="255"/>
                            <h6 class="error-correo"></h6>
                            
                            <textarea name="curriculum" placeholder="Currículum" maxlength="10000"><?= $resultado['curriculum']; ?></textarea>
                            
                            
                            <select name="nivel-estudios">
                                <option value="0">Nivel de estudios</option>
                                <option value="1" <?php if( $resultado['nivel_estudios'] == '1' ) { echo 'selected="selected"'; } ?>>Primaria</option>
                                <option value="2" <?php if( $resultado['nivel_estudios'] == '2' ) { echo 'selected="selected"'; } ?>>Secundaria</option>
                                <option value="3" <?php if( $resultado['nivel_estudios'] == '3' ) { echo 'selected="selected"'; } ?>>Preparatoria</option>
                                <option value="4" <?php if( $resultado['nivel_estudios'] == '4' ) { echo 'selected="selected"'; } ?>>Universidad (Parcial)</option>
                                <option value="5" <?php if( $resultado['nivel_estudios'] == '5' ) { echo 'selected="selected"'; } ?>>Universidad (Total)</option>
                                <option value="6" <?php if( $resultado['nivel_estudios'] == '6' ) { echo 'selected="selected"'; } ?>>Maestría</option>
                                <option value="7" <?php if( $resultado['nivel_estudios'] == '7' ) { echo 'selected="selected"'; } ?>>Doctorado</option>
                                <option value="8" <?php if( $resultado['nivel_estudios'] == '8' ) { echo 'selected="selected"'; } ?>>Posdoctorado</option>
                            </select> <!-- /nivel-estudios -->
                            
                            
                            <input type="password" name="contrasena" placeholder="Contraseña"/>
                            <input type="password" name="confirmar-contrasena" placeholder="Confirmar contraseña"/>
                            <h6 class="error-contrasena"></h6>
                            
                            <h4>Seleccione el tipo de usuario:</h4>
                            <h6 class="error-agregar-usuario" id="error-tipo-agregar"></h6>
                            
                            <?php
                            // Consulta a tabla de tipos de usuarios
                            $tiposUsuarios = $bd->query("SELECT * FROM tipos_usuarios");
                            
                            if($tiposUsuarios == false) {
                                return 'Hubo un error con la base de datos: ' . $bd->error();
                            } else {
								
								$idTipos = array();
								
								$tipos = $bd->query("SELECT * FROM tipo_usuario WHERE id_usuario = " . $resultado['id']);
								
								if( $tipos == false ) {
									echo 'Hubo un error con la base de datos: ' . $bd->error();
								} else {
									foreach( $tipos as $tipo ) {
										array_push( $idTipos, $tipo['id_tipo'] );
									} // foreach( $tipos as $tipo ) {
								} // if( $tipos == false ) { ... else ...
								
								$output = '';
								
								foreach( $tiposUsuarios as $tipoUsuarios ) {
									$tieneTipo = ( in_array( $tipoUsuarios['id'], $idTipos ) ) ? 'checked' : '';
									
									$output .= '<label><input type="checkbox" name="tipo[]" value="' . $tipoUsuarios['id'] . '" ' . $tieneTipo . '/>' . $tipoUsuarios['nombre'] . '</label>';
								} // foreach( $tiposUsuarios as $tipoUsuarios ) {
								
								echo $output;
                            } // if($tiposUsuarios == false) { ... else ...
                            ?>
                            <h6 class="error-tipo"></h6>
                            
                            
                            <fieldset class="departamento-usuario">
                                <h4>Seleccione el departamento al que pertenece el usuario:</h4>
                                
                                <?php
                                // Consulta a tabla de departamento
                                $departamentos = $bd->query("SELECT * FROM departamento");
                                
                                if( $departamentos == false ) {
                                    return 'Hubo un error con la base de datos:' . $bd->error();
                                } else {
									$idDeptos = array();
								
									$deptos = $bd->query("SELECT * FROM usuario_departamento WHERE id_usuario = " . $resultado['id']);
									
									if( $deptos == false ) {
										echo 'Hubo un error con la base de datos: ' . $bd->error();
									} else {
										foreach( $deptos as $depto ) {
											array_push( $idDeptos, $depto['id_departamento'] );
										} // foreach( $deptos as $depto ) {
									} // if( $deptos == false ) { ... else ...
									
                                    $output = '';
                                    
                                    foreach( $departamentos as $departamento ) {
										$tieneDepto = ( in_array( $departamento['id'], $idDeptos ) ) ? 'checked' : '';
										
                                        $output .= '<label><input type="checkbox" name="departamento[]" value="' . $departamento['id'] . '" ' . $tieneDepto . '/>' . $departamento['nombre'] . '</label>';
                                    } // foreach( $departamentos as $departamento ) {
                                    
                                    echo $output;
                                } // if( $departamentos == false ) { ... else ...
                                ?>
                            </fieldset> <!-- /departamento-usuario -->
                            
                            <input type="submit" value="Actualizar"/>
                            <input type="hidden" name="agregar-usuario" value="<?= $resultado['id']; ?>"/>
                            
                            <img class="loading" style="display: none;" src="inc/img/loading.gif" width="30" height="30"/>
                        </form> <!-- /agregar-usuario-<?= $resultado['id']; ?> -->
                        
                        <button class="eliminar-usuario" data-id="<?= $resultado['id']; ?>">Eliminar usuario</button>
                        <img class="loading loading-eliminar-usuario" id="loading-eliminar-usuario-<?= $resultado['id']; ?>" style="display: none;" src="inc/img/loading.gif" width="30" height="30"/>
                        
                        <?php
					} // foreach($resultados as $resultado) {
				} // if( $tabla == 'usuarios' ) {
				
				
				
				if( $tabla == 'grupos' ) {
					// Consulta a join de tabla de tipo de usuario y usuario
					$tiposUsuarios = $bd->query("SELECT a.id, a.nombre
												FROM usuarios a, tipo_usuario b
												WHERE a.id = b.id_usuario AND b.id_tipo = 2");
					
					// Consulta a join de tabla de materia
					$materias = $bd->query("SELECT * FROM materia");
					
					// Consulta a join de tabla de periodos
					$periodos = $bd->query("SELECT * FROM periodos");
					
					
					foreach( $resultados as $resultado ) {
						
						// Formulario para editar grupos ?>
						
                        <form action="<?= BASEDIR; ?>/controlador-bd.php" method="post" class="agregar-grupo" id="agregar-grupo-<?= $resultado['id']; ?>">
                            <h2>Grupo <?= $resultado['id']; ?></h2>
                            <?php
                            
                            if( $tiposUsuarios == false ) {
                                echo 'Hubo un error con la base de datos:' . $bd->error();
                            } else {
                                $output = '<select name="profesor">';
                                $output .= '<option value="0">Elegir profesor</option>';
                                
                                foreach( $tiposUsuarios as $tipoUsuarios ) {
									$selected = ( $resultado['id_profesor'] == $tipoUsuarios['id'] ) ? 'selected' : '';
                                    $output .= '<option value="' . $tipoUsuarios['id'] . '" ' . $selected . '>' . $tipoUsuarios['nombre'] . '</option>';
                                } // foreach( $tiposUsuarios as $tipoUsuarios ) {
                                
                                $output .= '</select> <!-- /profesor -->';
                                $output .= '<h6 class="error-profesor"></h6>';
                                echo $output;
                            } // if($tiposUsuarios == false) { ... else ...
                            
                            
                            if( $materias == false ) {
                                echo 'Hubo un error con la base de datos:' . $bd->error();
                            } else {
                                $output = '<select name="materia">';
                                $output .= '<option value="0">Elegir materia</option>';
                                
                                foreach( $materias as $materia ) {
									$selected = ( $resultado['id_materia'] == $materia['id'] ) ? 'selected' : '';
                                    $output .= '<option name="materia" value="' . $materia['id'] . '" ' . $selected . '>' . $materia['nombre'] . '</option>';
                                } // foreach( $tiposUsuarios as $tipoUsuarios ) {
                                
                                $output .= '</select> <!-- /materia -->';
                                $output .= '<h6 class="error-materia"></h6>';
                                echo $output;
                            } // if($tiposUsuarios == false) { ... else ...
                            
                            
                            if( $periodos == false ) {
                                echo 'Hubo un error con la base de datos:' . $bd->error();
                            } else {
                                $output = '<select name="periodo">';
                                $output .= '<option value="0">Elegir periodo</option>';
                                
                                foreach( $periodos as $periodo ) {
									$selected = ( $resultado['id_periodo'] == $periodo['id'] ) ? 'selected' : '';
                                    $output .= '<option value="' . $periodo['id'] . '" ' . $selected . '>' . $periodo['nombre'] . ' – ' . $periodo['descripcion'] . '</option>';
                                } // foreach( $tiposUsuarios as $tipoUsuarios ) {
                                
                                $output .= '</select> <!-- /periodo -->';
                                $output .= '<h6 class="error-periodo"></h6>';
                                echo $output;
                            } // if($tiposUsuarios == false) { ... else ...
                            ?>
                            
                            <input type="number" name="numero" value="<?= $resultado['numero']; ?>" placeholder="Número" />
                            <h6 class="error-numero"></h6>
                            
                            <input type="submit" value="Actualizar"/>
                            <input type="hidden" name="agregar-grupo" value="1"/>
                            
                            
                        </form> <!-- /agregar-grupo-<?= $resultado['id']; ?> -->
                    	<?php
                    } // foreach( $resultados as $resultado ) {
				} // if( $tabla == 'grupos' ) {
				
			} // if( $resultados->num_rows > 0 ) {
		} // if( $resultados == false ) { ... else ...
		
		
    	include_once( 'inc/shadowbox.php' );
		
		echo '<script type="text/javascript" src="' . BASEDIR . '/inc/js/jquery-1.11.3.min.js"></script>';
		
		echo '<script type="text/javascript" src="' . BASEDIR . '/inc/js/validacion-editar.js"></script>';
		
	} else {
		
		// Redirige al usuario si no está validado como administrador
		$mensajeError = 'Error: no tiene permiso para editar contenido';
		header( 'Location: ' . BASEDIR . '?error=' . htmlentities( urlencode( $mensajeError ) ) );
		die();
		
	} // if( $validado ) { ... else ...
} // if( isset( $_SESSION['usuario_registrado'] ) ) {
?>