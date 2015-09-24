<?php
// Cuenta de usuario autenticado

session_start();

$id = 0;
$usuario;

if(isset($_SESSION['usuario_registrado'])) {
	require_once('inc/clases/usuario.class.php');
	
	$id = intval($_SESSION['usuario_registrado']);
	
	if($id > 0) {
		$usuario = new Usuario($id);
	} // if($id > 0) {
	
} // if(isset($_SESSION['usuario_registrado'])) {

if(isset($usuario) && !empty($usuario)) {
?>
    <header>
        <nav class="primario">
            <h1><?= $usuario->getNombre(); ?></h1>
            <h2><?= $usuario->getMatricula(); ?></h2>
            
            <a href="#">Perfil</a>
            <a href="#">Cerrar sesión</a>
        </nav> <!-- /primario -->
        
        <nav class="secundario">
        </nav> <!-- /secundario -->
    </header>
    
    <div class="main">
    	<?php
		include_once('inc/lista-contenidos.php');
		?>
        <?php var_dump($usuario->getTipo()); ?>
    </div> <!-- /main -->
<?php
} // if(isset($usuario) && !empty($usuario)) {
?>