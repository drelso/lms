<?php
// Panel de administrador

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
		
		require_once('inc/db/bd.class.php');
		$bd = new BD();
		
		require_once('inc/admin-func/func-admin-bd.php');
		?>
    
        <a href="<?= BASEDIR; ?>/editar.php?modo=1">Editar usuarios</a>
        
        <form action="<?= BASEDIR; ?>/controlador-bd.php" method="post" id="agregar-usuario">
        
        	<h2>Agregar usuarios</h2>
        	
            <input type="text" name="nombre" placeholder="Nombre" maxlength="255"/>
            <h6 class="error-nombre"></h6>
            
        	<input type="text" name="matricula" placeholder="Matrícula" maxlength="10"/>
        	<input type="text" name="correo" placeholder="Correo" maxlength="255"/>
            <h6 class="error-correo"></h6>
            
            <textarea name="curriculum" placeholder="Currículum" maxlength="10000"></textarea>
            
        	<!--<input type="number" name="nivel-estudios" placeholder="Nivel de estudios"/>-->
            <select name="nivel-estudios">
            	<option value="0">Nivel de estudios</option>
                <option value="1">Primaria</option>
				<option value="2">Secundaria</option>
                <option value="3">Preparatoria</option>
                <option value="4">Universidad (Parcial)</option>
                <option value="5">Universidad (Total)</option>
                <option value="6">Maestría</option>
                <option value="7">Doctorado</option>
                <option value="8">Posdoctorado</option>
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
				echo 'Hubo un error con la base de datos:' . $bd->error();
			} else {
				$output = '';
				
				foreach( $tiposUsuarios as $tipoUsuarios ) {
					$output .= '<label><input type="checkbox" name="tipo[]" value="' . $tipoUsuarios['id'] . '"/>' . $tipoUsuarios['nombre'] . '</label>';
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
                    echo 'Hubo un error con la base de datos:' . $bd->error();
                } else {
                    $output = '';
                    
                    foreach( $departamentos as $departamento ) {
                        $output .= '<label><input type="checkbox" name="departamento[]" value="' . $departamento['id'] . '"/>' . $departamento['nombre'] . '</label>';
                    } // foreach( $departamentos as $departamento ) {
                    
                    echo $output;
                } // if( $departamentos == false ) { ... else ...
                ?>
            </fieldset> <!-- /departamento-usuario -->
            
            <input type="submit" value="Agregar"/>
            <input type="hidden" name="agregar-usuario" value="1"/>
        </form> <!-- /agregar-usuario -->
    	
        
    
        <a href="<?= BASEDIR; ?>/editar.php?modo=2">Editar grupos</a>
        
        
        <form action="<?= BASEDIR; ?>/controlador-bd.php" method="post" id="agregar-grupo">
        	<h2>Agregar grupo</h2>
        	<?php
			// Consulta a join de tabla de tipo de usuario y usuario
			$tiposUsuarios = $bd->query("SELECT a.id, a.nombre
										FROM usuarios a, tipo_usuario b
										WHERE a.id = b.id_usuario AND b.id_tipo = 2");
			
			if($tiposUsuarios == false) {
				echo 'Hubo un error con la base de datos:' . $bd->error();
			} else {
				$output = '<select name="profesor">';
				$output .= '<option value="0">Elegir profesor</option>';
				
				foreach( $tiposUsuarios as $tipoUsuarios ) {
					$output .= '<option value="' . $tipoUsuarios['id'] . '"/>' . $tipoUsuarios['nombre'] . '</option>';
				} // foreach( $tiposUsuarios as $tipoUsuarios ) {
				
				$output .= '</select> <!-- /profesor -->';
				$output .= '<h6 class="error-profesor"></h6>';
				echo $output;
			} // if($tiposUsuarios == false) { ... else ...
			
			
			// Consulta a join de tabla de materia
			$materias = $bd->query("SELECT * FROM materia");
			
			if($materias == false) {
				echo 'Hubo un error con la base de datos:' . $bd->error();
			} else {
				$output = '<select name="materia">';
				$output .= '<option value="0">Elegir materia</option>';
				
				foreach( $materias as $materia ) {
					$output .= '<option name="materia" value="' . $materia['id'] . '"/>' . $materia['nombre'] . '</option>';
				} // foreach( $tiposUsuarios as $tipoUsuarios ) {
				
				$output .= '</select> <!-- /materia -->';
				$output .= '<h6 class="error-materia"></h6>';
				echo $output;
			} // if($tiposUsuarios == false) { ... else ...
			
			
			// Consulta a join de tabla de periodos
			$periodos = $bd->query("SELECT * FROM periodos");
			
			if($periodos == false) {
				echo 'Hubo un error con la base de datos:' . $bd->error();
			} else {
				$output = '<select name="periodo">';
				$output .= '<option value="0">Elegir periodo</option>';
				
				foreach( $periodos as $periodo ) {
					$output .= '<option value="' . $periodo['id'] . '"/>' . $periodo['nombre'] . ' – ' . $periodo['descripcion'] . '</option>';
				} // foreach( $tiposUsuarios as $tipoUsuarios ) {
				
				$output .= '</select> <!-- /periodo -->';
				$output .= '<h6 class="error-periodo"></h6>';
				echo $output;
			} // if($tiposUsuarios == false) { ... else ...
			?>
            
            <input type="number" name="numero" value="1" placeholder="Número" />
            <h6 class="error-numero"></h6>
            
            <input type="submit" value="Agregar"/>
            <input type="hidden" name="agregar-grupo" value="1"/>
        </form> <!-- /agregar-grupo -->
        
    
        <a href="<?= BASEDIR; ?>/editar.php?modo=3">Editar periodos</a>
        
        
        <form action="<?= BASEDIR; ?>/controlador-bd.php" method="post" id="agregar-periodo">
        	<h2>Agregar periodo</h2>
            
        	<input type="text" name="nombre" placeholder="Nombre" maxlength="255"/>
            <h6 class="error-nombre"></h6>
        	<input type="text" name="descripcion" placeholder="Descripción" maxlength="255"/>
            <h6 class="error-descripcion"></h6>
            
        	<input type="submit" value="Agregar"/>
        	<input type="hidden" name="agregar-periodo" value="1"/>
        </form> <!-- /agregar-grupo -->
        
    
        <a href="<?= BASEDIR; ?>/editar.php?modo=4">Editar materias</a>
        
        
        <form action="<?= BASEDIR; ?>/controlador-bd.php" method="post" id="agregar-materia">
        	<h2>Agregar materia</h2>
            
            <input type="text" name="clave" placeholder="Clave" maxlength="10"/>
            <h6 class="error-clave"></h6>
            
            <input type="text" name="nombre" placeholder="Nombre"/>
            <h6 class="error-nombre"></h6>
            
            <input type="submit" value="Agregar"/>
            <input type="hidden" name="agregar-materia" value="1"/>
        </form> <!-- /agregar-materia -->
        
    
        <a href="<?= BASEDIR; ?>/editar.php?modo=5">Editar departamentos</a>
        
        
        <form action="<?= BASEDIR; ?>/controlador-bd.php" method="post" id="agregar-departamento">
        	<h2>Agregar departamento</h2>
            
            <input type="text" name="clave" placeholder="Clave" maxlength="11"/>
            <h6 class="error-clave"></h6>
            
            <input type="text" name="nombre" placeholder="Nombre" maxlength="255"/>
            <h6 class="error-nombre"></h6>
            
            <input type="text" name="director" placeholder="Director"/>
            <h6 class="error-director"></h6>
            
            <input type="submit" value="Agregar"/>
            <input type="hidden" name="agregar-departamento" value="1"/>
        </form> <!-- /agregar-departamento -->
        
        
        <script type="text/javascript" src="inc/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="inc/js/validacion-admin.js"></script>
        
    <?php
	} // if( $validado ) {
} //if( isset( $usuario ) && !empty( $usuario ) ) {
?>

