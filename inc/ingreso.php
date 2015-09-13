<?php
// Formulario de ingreso

$correoIngresado = (isset($_GET['correo'])) ? 'value="'.$_GET['correo'].'"' : '';
$mensajeError = (isset($_GET['ingreso']) && $_GET['ingreso'] == 'invalido') ? '<h4>Correo y/o contraseña inválidos.</h4>' : '';
?>

<h1>Bienvenido al módulo de aprendizaje adaptativo</h1>

<h2>Ingresa</h2>

<form action="inc/usuarios/validacion-usuarios.php" method="post">
	<?= $mensajeError; ?>
	<input type="text" name="correo" placeholder="Correo" <?= $correoIngresado; ?>/>
    <input type="password" name="contrasena" placeholder="Contraseña"/>
    <input type="hidden" name="envio" value="<?= $_SERVER['REMOTE_ADDR']; ?>"/>
    <input type="submit" value="Ingresar"/>
</form>