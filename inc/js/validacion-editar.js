// Validación de formularios de administrador


// Expresión regular para comprobar
// la validez del correo electrónico ingresado
//
var patron = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);


$('.agregar-usuario').submit(function(e) {
    "use strict";
	
	e.preventDefault();
	
	var error = false;
	
	var id					=	$(this).children('input[name="agregar-usuario"]').val();
	var nombre				=	$(this).children('input[name="nombre"]').val();
	var matricula			=	$(this).children('input[name="matricula"]').val();
	var correo				=	$(this).children('input[name="correo"]').val();
	var curriculum			=	$(this).children('textarea[name="curriculum"]').val();
	var nivelEstudios		=	$(this).children('input[name="nivel-estudios"]').val();
	var contrasena			=	$(this).children('input[name="contrasena"]').val();
	var confirmarContrasena	=	$(this).children('input[name="confirmar-contrasena"]').val();
	var tipo					=	$(this).find('input[name="tipo[]"]:checked');
	var departamento			=	$(this).find('input[name="departamento[]"]:checked');
	var mensajeError;
	
	var arregloTipos			=	[];
	var arregloDeptos		=	[];
	
	if( nombre.length < 1 || nombre.length > 255 ) {
		mensajeError = '';
		
		if( nombre.length < 1 ) { mensajeError = 'Campo requerido'; }
		
		if( nombre.length > 255 ) { mensajeError = 'El nombre debe contener menos de 255 caracteres'; }
		
		$(this).find('.error-nombre').html( mensajeError );
		
		error = true;
	} else {
		$(this).find('.error-nombre').html('');
	} // if( nombre.length < 1 || nombre.length > 255 ) { ... else ...
	
	
	if( correo.length < 1 || correo.length > 255 ) {
		mensajeError = '';
		
		if( correo.length < 1 ) { mensajeError = 'Campo requerido'; }
		
		if( correo.length > 255 ) { mensajeError = 'El correo debe contener menos de 255 caracteres'; }
		
		$(this).find('.error-correo').html( mensajeError );
		
		error = true;
	} else if( !patron.test( correo ) ) {
		$(this).find('.error-correo').html( 'Por favor ingrese un correo electrónico válido' );
		
		error = true;
	} else {
		$(this).find('.error-correo').html('');
	} // if( correo.length < 1 || correo.length > 255 ) { ... else if ... else ...
	
	
	if( ( contrasena.length > 0 && contrasena.length < 8 ) ||
			contrasena.length > 255 ) {
		mensajeError = 'La contraseña debe contener al menos 8 caracteres';
		
		$(this).find('.error-contrasena').html(mensajeError);
		
		error = true;
	} else if( contrasena !== confirmarContrasena ) {
		mensajeError = 'Las contraseñas no coinciden';
		
		$(this).find('.error-contrasena').html(mensajeError);
		
		error = true;
	} else {
		$(this).find('.error-contrasena').html('');
	} // if( contrasena.length < 8 || contrasena.length > 255 ) { ... else if ... else ...
	
	
	// Confirma que haya tipos definidos para el usuario
	var tipoVacio = true;
	
	if( tipo.length > 0 ) {
		tipo.each( function() {
			tipoVacio = false;
			
			arregloTipos.push( $(this).val() );
			
		}); // tipo.each(function() {
	} // if( tipo.length > 0 ) {
	
	if( tipoVacio ) {
		error = true;
		$(this).find('.error-tipo').html('Por favor seleccione al menos un tipo para el usuario');
	} else { $(this).find('.error-tipo').html(''); }
	
	
	// Llena el arreglo de departamentos
	if( departamento.length > 0 ) {
		departamento.each( function() {
			
			arregloDeptos.push( $(this).val() );
			
		}); // departamento.each(function() {
	} // if( departamento.length > 0 ) {
	
	
	if( !error ) {
		
		$.post( "inc/admin-func/actualizar-edicion.func.php",
			{
				modo:					'usuario',
				id:						id,
				nombre:					nombre,
				matricula:				matricula,
				correo:					correo,
				curriculum:				curriculum,
				nivelEstudios:			nivelEstudios,
				contrasena:				contrasena,
				confirmarContrasena:	confirmarContrasena,
				tipo:					arregloTipos,
				departamento:			arregloDeptos
			})
		.done(function( datos ) {
			
			
			console.log(id + ' ' + datos);
			
			var resultado = datos;
			var mensajeError = '';
			
		})
		.fail( function(xhr, textStatus, errorThrown ) {
			mensajeError = xhr.responseText;
			agregarMateria.find('.error-clave').html(mensajeError);
		});
	} // if( !error ) {*/
	
}); // $('.agregar-usuario').submit(function(e) {


var error = false;
var agregarGrupo = $('#agregar-grupo');

$('#agregar-grupo input[type="submit"]').click(function(e) {
    "use strict";
	
	e.preventDefault();
	
	var $this = $('#agregar-grupo');
	var error = false;
	
	var profesor		=	$this.find('select[name="profesor"]').val();
	var materia		=	$this.find('select[name="materia"]').val();
	var periodo		=	$this.find('select[name="periodo"]').val();
	var numero		=	$this.find('input[name="numero"]').val();
	
	if( numero == '' ) { numero = '1'; }
	
	var mensajeError = '';
	
	if( profesor == '0' ) {
		mensajeError = 'Por favor elija un profesor para el grupo';
		
		$this.find('.error-profesor').html(mensajeError);
		error = true;
	} else {
		$this.find('.error-profesor').html('');
	} // if( profesor == null ) { ... else ...
	
	if( materia == '0' ) {
		mensajeError = 'Por favor elija una materia para el grupo';
		
		$this.find('.error-materia').html(mensajeError);
		error = true;
	} else {
		$this.find('.error-materia').html('');
	} // if( profesor == null ) { ... else ...
	
	if( periodo == '0' ) {
		mensajeError = 'Por favor elija un periodo para el grupo';
		
		$this.find('.error-periodo').html(mensajeError);
		error = true;
	} else {
		$this.find('.error-periodo').html('');
	} // if( profesor == null ) { ... else ...
	
	//if( error ) { e.preventDefault(); }
	if( !error ) {
		$.post( "inc/func/existe-grupo.php",
			{
				profesor:	profesor,
				materia:		materia,
				periodo:		periodo,
				numero:		numero
			})
		.done(function( datos ) {
			
			var resultado = parseInt( datos );
			var mensajeError = '';
			
			if( resultado == 1 ) {
				
				mensajeError = 'El grupo ingresado ya existe';
				
				agregarGrupo.find('.error-numero').html(mensajeError);
				error = true;
				
			} else if( resultado != 0 ) {
				
				mensajeError = 'Error con la base de datos 1: ' + datos;
				
				agregarGrupo.find('.error-numero').html(mensajeError);
				error = true;
				
			} // if( resultado == 1 ) {
			
			//if( error ) { e.preventDefault(); }
			
			if( !error ) { agregarGrupo.submit(); }
			
		})
		.fail( function(xhr, textStatus, errorThrown ) {
			mensajeError = xhr.responseText;
			agregarMateria.find('.error-clave').html(mensajeError);
		});
	} // if( !error ) {
	
}); // $('#agregar-grupo').submit(function(e) {


$('#agregar-periodo').submit(function(e) {
	"use strict";
	
	var error = false;
	
	var nombre			=	$(this).children('input[name="nombre"]').val();
	var descripcion		=	$(this).children('input[name="descripcion"]').val();
	
	var mensajeError = '';
	
	if( nombre == '' ) {
		mensajeError = 'Por favor ingrese el nombre del periodo';
		
		$(this).find('.error-nombre').html(mensajeError);
		error = true;
	} else if( nombre.length > 255 ) {
		mensajeError = 'El nombre debe contener menos de 255 caracteres';
		
		$(this).find('.error-nombre').html(mensajeError);
		error = true;
	} else {
		$(this).find('.error-nombre').html('');
	} // if( nombre == null ) { ... else if ... else ...
	
	if( descripcion == '' ) {
		mensajeError = 'Por favor ingrese la descripción del periodo';
		
		$(this).find('.error-descripcion').html(mensajeError);
		error = true;
	} else if( descripcion.length > 255 ) {
		mensajeError = 'La descripción debe contener menos de 255 caracteres';
		
		$(this).find('.error-nombre').html(mensajeError);
		error = true;
	} else {
		$(this).find('.error-descripcion').html('');
	} // if( descripcion == null ) { ... else if ... else ...
	
	if( error ) { e.preventDefault(); }
}); // $('#agregar-periodo').submit(function(e) {


var error = false;
var agregarMateria = $('#agregar-materia');


$('#agregar-materia input[type="submit"]').click( function( e ) {
	"use strict";
	
	e.preventDefault();
	
	error = false;
	var clave		=	agregarMateria.find('input[name="clave"]').val();
	var nombre		=	agregarMateria.find('input[name="nombre"]').val();
	var mensajeError = '';
	
	
	if( clave == '' ) {
		mensajeError = 'Por favor ingrese la clave de la materia';
		
		agregarMateria.find('.error-clave').html(mensajeError);
		error = true;
	} else if( clave.length > 10 ) {
		mensajeError = 'La clave debe contener 10 caracteres o menos';
		
		agregarMateria.find('.error-clave').html(mensajeError);
		error = true;
	} else {
		agregarMateria.find('.error-clave').html('');
	} // if( clave == '' ) { ... else if ... else ...
	
	
	if( nombre == '' ) {
		mensajeError = 'Por favor ingrese el nombre de la materia';
		
		agregarMateria.find('.error-nombre').html(mensajeError);
		error = true;
	} else if( nombre.length > 255 ) {
		mensajeError = 'El nombre debe contener menos de 255 caracteres';
		
		agregarMateria.find('.error-nombre').html(mensajeError);
		error = true;
	} else {
		agregarMateria.find('.error-nombre').html('');
	} // if( nombre == '' ) { ... else if ... else ...
	
	
	if( !error ) {
		
		$.post( "inc/func/existe-clave.php", { tabla: 'materia', clave: clave } )
		.done(function( datos ) {
			
			var resultado = parseInt( datos );
			var mensajeError = '';
			
			console.log(e);
			
			if( resultado == 1 ) {
				
				mensajeError = 'La clave ingresada ya existe';
				
				agregarMateria.find('.error-clave').html(mensajeError);
				error = true;
				
			} else if( resultado != 0 ) {
				
				mensajeError = 'Error con la base de datos: ' + datos;
				
				agregarMateria.find('.error-clave').html(mensajeError);
				error = true;
				
			} // if( resultado == 1 ) {
			
			//if( error ) { e.preventDefault(); }
			
			if( !error ) { agregarMateria.submit(); }
			
		})
		.fail( function(xhr, textStatus, errorThrown ) {
			mensajeError = xhr.responseText;
			agregarMateria.find('.error-clave').html(mensajeError);
		});
	
	} // if( !error ) {
	
	
	// e.preventDefault();
	 
}); // $('#agregar-materia').submit(function(e) {


var error = false;
var agregarDepartamento = $('#agregar-departamento');


$('#agregar-departamento input[type="submit"]').click( function( e ) {
	"use strict";
	
	e.preventDefault();
	
	error = false;
	var clave		=	agregarDepartamento.find('input[name="clave"]').val();
	var nombre		=	agregarDepartamento.find('input[name="nombre"]').val();
	var director		=	agregarDepartamento.find('input[name="director"]').val();
	var mensajeError = '';
	
	
	if( clave == '' ) {
		mensajeError = 'Por favor ingrese la clave del departamento';
		
		agregarDepartamento.find('.error-clave').html(mensajeError);
		error = true;
	} else if( clave.length > 10 ) {
		mensajeError = 'La clave debe contener 10 caracteres o menos';
		
		agregarDepartamento.find('.error-clave').html(mensajeError);
		error = true;
	} else {
		agregarDepartamento.find('.error-clave').html('');
	} // if( clave == '' ) { ... else if ... else ...
	
	
	if( nombre == '' ) {
		mensajeError = 'Por favor ingrese el nombre del departamento';
		
		agregarDepartamento.find('.error-nombre').html(mensajeError);
		error = true;
	} else if( nombre.length > 255 ) {
		mensajeError = 'El nombre debe contener menos de 255 caracteres';
		
		agregarDepartamento.find('.error-nombre').html(mensajeError);
		error = true;
	} else {
		agregarDepartamento.find('.error-nombre').html('');
	} // if( nombre == '' ) { ... else if ... else ...
	
	
	if( director == '' ) {
		mensajeError = 'Por favor ingrese el nombre del director del departamento';
		
		agregarDepartamento.find('.error-director').html(mensajeError);
		error = true;
	} else if( nombre.length > 255 ) {
		mensajeError = 'El nombre del director debe contener menos de 255 caracteres';
		
		agregarDepartamento.find('.error-director').html(mensajeError);
		error = true;
	} else {
		agregarDepartamento.find('.error-director').html('');
	} // if( director == '' ) { ... else if ... else ...
	
	
	if( !error ) {
		
		$.post( "inc/func/existe-clave.php", { tabla: 'departamento', clave: clave } )
		.done(function( datos ) {
			
			var resultado = parseInt( datos );
			var mensajeError = '';
			
			console.log(e);
			
			if( resultado == 1 ) {
				
				mensajeError = 'La clave ingresada ya existe';
				
				agregarDepartamento.find('.error-clave').html(mensajeError);
				error = true;
				
			} else if( resultado != 0 ) {
				
				mensajeError = 'Error con la base de datos: ' + datos;
				
				agregarDepartamento.find('.error-clave').html(mensajeError);
				error = true;
				
			} // if( resultado == 1 ) {
			
			//if( error ) { e.preventDefault(); }
			
			if( !error ) { agregarDepartamento.submit(); }
			
		})
		.fail( function(xhr, textStatus, errorThrown ) {
			mensajeError = xhr.responseText;
			agregarDepartamento.find('.error-clave').html(mensajeError);
		});
	
	} // if( !error ) {
	
	
	// e.preventDefault();
	 
}); // $('#agregar-departamento').submit(function(e) {

