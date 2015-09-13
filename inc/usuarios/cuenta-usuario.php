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
        <h1><?= $usuario->getNombre(); ?></h1>
        <h2><?= $usuario->getMatricula(); ?></h2>
        
        <a href="#">Perfil</a>
        <a href="#">Cerrar sesión</a>
    </header>
    
    <div class="main">
        <?php var_dump($usuario->getTipo()); ?>
    </div> <!-- /main -->
<?php
} // if(isset($usuario) && !empty($usuario)) {
?>