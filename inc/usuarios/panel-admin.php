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
		
		require_once('inc/db/bd.class.php');
		$bd = new BD();
		
		require_once('inc/admin-func/func-admin-bd.php');
		
		?>
		
        <form action="" method="post" id="agregar-usuario">
        	<h2>Agregar usuarios</h2>
        	<input type="text" name="nombre" placeholder="Nombre" maxlength="255"/>
            <h6 class="error-agregar-usuario" id="error-nombre-agregar"></h6>
        	<input type="text" name="matricula" placeholder="Matrícula" maxlength="10"/>
        	<input type="text" name="correo" placeholder="Correo" maxlength="255"/>
            <h6 class="error-agregar-usuario" id="error-correo-agregar"></h6>
            <textarea name="curriculum" placeholder="Currículum" maxlength="10000"></textarea>
        	<input type="number" name="nivel-estudios" placeholder="Nivel de estudios"/>
        	<input type="password" name="contrasena" placeholder="Contraseña"/>
        	<input type="password" name="confirmar-contrasena" placeholder="Confirmar contraseña"/>
            <h6 class="error-agregar-usuario" id="error-contrasena-agregar"></h6>
            
            <h4>Seleccione el tipo de usuario:</h4>
            <h6 class="error-agregar-usuario" id="error-tipo-agregar"></h6>
            
			<?php
			// Consulta a tabla de tipos de usuarios
			$tiposUsuarios = $bd->query("SELECT * FROM tipos_usuarios");
			
			if($tiposUsuarios == false) {
				return 'Hubo un error con la base de datos:' . $bd->error();
			} else {
				$output = '';
				
				foreach( $tiposUsuarios as $tipoUsuarios ) {
					$output .= '<label><input type="checkbox" name="tipo[]" value="' . $tipoUsuarios['id'] . '"/>' . $tipoUsuarios['nombre'] . '</label>';
				} // foreach( $tiposUsuarios as $tipoUsuarios ) {
				
				echo $output;
			} // if($tiposUsuarios == false) { ... else ...
			?>
            <h6 class="error-agregar-usuario" id="error-tipo-agregar"></h6>
            
            <input type="submit" value="Agregar"/>
            <input type="hidden" name="agregar-usuario" value="1"/>
        </form> <!-- /agregar-usuario -->
    	
        
        <form action="" method="post" id="agregar-grupo">
        	<?php
			// Consulta a join de tabla de tipo de usuario y usuario
			$tiposUsuarios = $bd->query("SELECT a.id, a.nombre
										FROM a.usuarios, b.tipo_usuario
										WHERE a.id = b.id_usuario AND b.id_tipo = 2");
			
			if($tiposUsuarios == false) {
				return 'Hubo un error con la base de datos:' . $bd->error();
			} else {
				$output = '';
				
				foreach( $tiposUsuarios as $tipoUsuarios ) {
					$output .= '<label><input type="checkbox" name="tipo[]" value="' . $tipoUsuarios['id'] . '"/>' . $tipoUsuarios['nombre'] . '</label>';
				} // foreach( $tiposUsuarios as $tipoUsuarios ) {
				
				echo $output;
			} // if($tiposUsuarios == false) { ... else ...
			?>
        </form> <!-- /agregar-grupo -->
        
        
        <form action="" method="post" id="agregar-materia">
        </form> <!-- /agregar-grupo -->
        
        
        <form action="" method="post" id="agregar-periodo">
        </form> <!-- /agregar-grupo -->
        
        <script type="text/javascript" src="inc/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="inc/js/validacion-admin.js"></script>
        
    <?php
	} // if( $validado ) {
} //if( isset( $usuario ) && !empty( $usuario ) ) {
?>

