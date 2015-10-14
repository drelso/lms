// Validación de formularios de administrador


// Expresión regular para comprobar
// la validez del correo electrónico ingresado
//
var patron = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);

$('#agregar-usuario').submit(function(e) {
    "use strict";
	
	var error = false;
	
	var nombre					=	$(this).children('input[name="nombre"]').val();
	var correo					=	$(this).children('input[name="correo"]').val();
	var contrasena				=	$(this).children('input[name="contrasena"]').val();
	var confirmarContrasena		=	$(this).children('input[name="confirmar-contrasena"]').val();
	var tipo						=	$(this).find('input[name="tipo[]"]:checked');
	var mensajeError;
	
	if( nombre.length < 1 || nombre.length > 255 ) {
		mensajeError = '';
		
		if( nombre.length < 1 ) { mensajeError = 'Campo requerido'; }
		
		if( nombre.length > 255 ) { mensajeError = 'El nombre debe contener menos de 255 caracteres'; }
		
		$('#error-nombre-agregar').html( mensajeError );
		
		error = true;
	} else {
		$('#error-nombre-agregar').html('');
	} // if( nombre.length < 1 || nombre.length > 255 ) { ... else ...
	
	
	if( correo.length < 1 || correo.length > 255 ) {
		mensajeError = '';
		
		if( correo.length < 1 ) { mensajeError = 'Campo requerido'; }
		
		if( correo.length > 255 ) { mensajeError = 'El correo debe contener menos de 255 caracteres'; }
		
		$('#error-correo-agregar').html( mensajeError );
		
		error = true;
	} else if( !patron.test( correo ) ) {
		$('#error-correo-agregar').html( 'Por favor ingrese un correo electrónico válido' );
		
		error = true;
	} else {
		$('#error-correo-agregar').html('');
	} // if( correo.length < 1 || correo.length > 255 ) { ... else if ... else ...
	
	
	if( contrasena.length < 8 || contrasena.length > 255 ) {
		mensajeError = 'La contraseña debe contener al menos 8 caracteres';
		
		$('#error-contrasena-agregar').html(mensajeError);
	} else if( contrasena !== confirmarContrasena ) {
		mensajeError = 'Las contraseñas no coinciden';
		
		$('#error-contrasena-agregar').html(mensajeError);
	} else {
		$('#error-contrasena-agregar').html('');
	} // if( contrasena.length < 8 || contrasena.length > 255 ) { ... else if ... else ...
	
	
	// Confirma que haya tipos definidos para el usuario
	var tipoVacio = true;
	
	if( tipo.length > 0 ) {
		tipo.each( function() {
			tipoVacio = false;
		}); // tipo.each(function(index, element) {
	} // if( tipo.length > 0 ) {
	
	if( tipoVacio ) {
		error = true;
		$('#error-tipo-agregar').html('Por favor seleccione al menos un tipo para el usuario');
	} else { $('#error-tipo-agregar').html(''); }
	
	if( error ) { e.preventDefault(); }
}); // $('#agregar-usuario').submit(function(e) {