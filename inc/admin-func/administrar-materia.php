<?php
// Formulario de administración de materias
error_reporting(E_ALL);
ini_set('display_errors', 1);

//if( isset( $nombreMateria ) && isset( $idMateria ) ) {
	
	$tiposDeContenido = '';
	
	if( !isset( $bd ) ) {
		require_once( __DIR__ . '/../db/bd.class.php');
		$bd = new BD();
	} // if( !isset($bd) ) {
	
	$resultados = $bd->query("SELECT * FROM tipo_contenido" );
	var_dump($resultados);
	
	if( $resultados == false ) {
		echo 'Hubo un error con la base de datos:' . $this->bd->error();
	} else {
		
		if( $resultados->num_rows > 0 ) {
			
			// Formulario para modificar el nombre de la materia
			$tiposDeContenido = '<select name="tipo-contenido">';
			
			$tiposDeContenido .= '<option value="0">Elija el tipo de contenido</option>';
			
			foreach( $resultados as $resultado ) {
				$tiposDeContenido .= '<option value="' . $resultado['id'] . '">' . $resultado['nombre'] . '</option>';
			} // foreach($resultados as $resultado) {
			
			$tiposDeContenido .= '</form> <!-- /tipo-contenido -->';
			
		} // if( $resultados->num_rows > 0 ) {
	} // if( $resultados == false ) {
?>


    <div id="campo-agregar-modulo">
    	<fieldset>
            <input type="text" name="modulo[]" placeholder="Módulo" />
            
            <div class="contenidos"></div>
            
            <a class="agregar-contenido">Agregar otro contenido</a>
        </fieldset>
    </div> <!-- /campo-agregar-modulo -->
	
	
	<div id="campo-agregar-contenido">
    	<div class="contenido">
			<?= $tiposDeContenido; ?>
            
            <input type="text" name="nombre-contenido" placeholder="Nombre del contenido"/>
            <input type="file" name="contenido" />
            <textarea name="contenido-texto" placeholder="Contenido en texto"></textarea>
            <a class="eliminar-contenido">&times;</a>
        </div> <!-- /contenido -->
    </div> <!-- /campo-agregar-contenido -->
    

	<form action="" method="post" id="modificar-nombre-materia">
		<input type="text" name="nombre" value="<?= $nombreMateria; ?>" placeholder="Nombre de la materia" />
		<input type="submit" value="Actualizar" />
		<input type="hidden" name="id" value="<?= $idMateria; ?>" />
	</form> <!-- /modificar-nombre-materia -->
    
    <form action="" method="post" id="agregar-tema" enctype="multipart/form-data">
    	<div id="modulos">
            <fieldset>
                <input type="text" name="modulo[]" placeholder="Módulo" />
                
                <div class="contenidos"></div>
                
            	<a class="agregar-contenido">Agregar otro contenido</a>
            </fieldset>
        </div> <!-- /modulos -->
        <a id="agregar-modulo">Agregar otro módulo</a>
		
        <input type="submit" value="Actualizar" />
		<input type="hidden" name="id" value="<?= $idMateria; ?>" />
        <input type="hidden" name="agregar-tema-enviado" />
    </form> <!-- /agregar-tema -->
    
    <style>
	.contenido { display: block; background: gray; margin-bottom: 20px; }
	
	.sortable-placeholder { background: blue; margin-bottom: 20px; }
	</style>
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    
	<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
    
	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
  	
	<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
  
    <script type="text/javascript" src="../js/temas.js"></script>
<?php
//} else { echo 'No tienes permisos'; } // if( isset( $nombreMateria ) && isset( $idMateria ) ) {
?>

