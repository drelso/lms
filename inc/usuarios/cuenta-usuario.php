<?php
// Cuenta de usuario autenticado

session_start();

$id = 0;
$usuario;

// Si el usuario está registrado
// instancia un objeto de clase usuario
//
if(isset($_SESSION['usuario_registrado'])) {
	require_once('inc/clases/usuario.class.php');
	
	$id = intval($_SESSION['usuario_registrado']);
	
	if($id > 0) {
		$usuario = new Usuario($id);
	} // if($id > 0) {
	
} // if(isset($_SESSION['usuario_registrado'])) {

// Si existe el objeto de clase usuario
// genera la estructura del perfil
//
if(isset($usuario) && !empty($usuario)) {
?>

    <header>
        <nav class="primario">
            <h1><?= $usuario->getNombre(); ?></h1>
            <h2><?= $usuario->getMatricula(); ?></h2>
            
            <a href="#">Perfil</a>
            <a href="<?= BASEDIR; ?>?logout=1">Cerrar sesión</a>
        </nav> <!-- /primario -->
        
        <nav class="secundario">
        </nav> <!-- /secundario -->
    </header>
    
    <div class="main">
    	<?php
		
		foreach( $usuario->getTipo() as $tipo) {
			
			echo '<h1>' . $tipo['nombre'] . '</h1>';
			
			include('inc/lista-contenidos.php');
			
		} // foreach( $usuario->getTipo() as $tipo) {
		?>
    </div> <!-- /main -->
    
<?php
} // if(isset($usuario) && !empty($usuario)) {
?>