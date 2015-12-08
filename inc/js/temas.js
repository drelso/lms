// Script para agregar y acomodar temas

/* Segundo intento de impresión de información
$('#agregar-tema input[type="submit"]').click(function(e) {
	'use strict';
	
	e.preventDefault();
	
	var $this = $('#agregar-tema');
	
	var modulos = $this.children('fieldset');
	
	console.log(modulos);
	
}); // $('#agregar-tema input[type="submit"]').click(function(e) {
*/

$('#agregar-modulo').click(function() {
	'use strict';
	
            //$('#agregar-tema fieldset').append('<input type="text" name="modulo[]" placeholder="Módulo" />');
			//$('#modulos fieldset:first').clone(true).appendTo('#modulos');
			
	$('#campo-agregar-modulo fieldset').clone(true).appendTo('#modulos');
	
	$( "#modulos, #modulos .contenidos" ).sortable({
		revert: true,
		axis: 'y',
		//containment: '#modulos',
		cursor: 'move',
		delay: 150,
		forcePlaceholderSize: true,
		placeholder: "sortable-placeholder"
	}); // $( "#modulos, #modulos .contenidos" ).sortable({
	
	$( "fieldset, .contenido" ).disableSelection();
	
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
	
	
}); // $('#agregar-modulo').click(function() {


$('.agregar-contenido').click(function() {
	'use strict';
	
	$('#campo-agregar-contenido .contenido').clone(true).appendTo($(this).siblings('.contenidos'));
	
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
}); // $('.agregar-contenido').click(function() {


$('.agregar-evaluacion').click(function() {
	'use strict';
	
	var evaluacion = $('#campo-agregar-evaluacion .contenido').clone(true);
	var pregunta = $('#campo-agregar-pregunta .pregunta').clone(true);
	var respuesta = $('#campo-agregar-respuesta .respuesta').clone(true);
	
	pregunta.find('.respuestas').append( respuesta );
	
	evaluacion.find('.preguntas').append( pregunta );
	
	evaluacion.appendTo($(this).siblings('.contenidos'));
	
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
}); // $('.agregar-evaluacion').click(function() {


$('.agregar-pregunta').click(function() {
	'use strict';
	
	var pregunta = $('#campo-agregar-pregunta .pregunta').clone(true);
	var respuesta = $('#campo-agregar-respuesta .respuesta').clone(true);
	
	pregunta.find('.respuestas').append( respuesta );
	
	pregunta.appendTo($(this).siblings('.preguntas'));
	
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
}); // $('.agregar-pregunta').click(function() {


$('.agregar-respuesta').click(function() {
	'use strict';
	
	var respuestas = $(this).siblings('.respuestas');
	
	// Asegura que nunca se agreguen más de 8 respuestas
	// en una pregunta
	if( respuestas.children('.respuesta').length < 8 ) {
	
		$('#campo-agregar-respuesta .respuesta').clone(true).appendTo( respuestas );
		
	} else {
		alert('No pueden agregarse más de ocho (8) respuestas por preguntas');
	} // if( respuestas.children('.respuesta').length <= 8 ) {
	
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
}); // $('.agregar-respuesta').click(function() {


$('.eliminar-contenido').click(function() {
	'use strict';
	
	var $this = $(this);
	
	// Bloque para desplegar diálogo de confirmación
	$('#shadow-box h1').html('¿Quiere eliminar este contenido?');
	$('#shadow-box').fadeIn( 300 );
	$('#shadow-box .confirmar').focus();
	
	// Si el usuario confirma se elimina el contenido
	$('#shadow-box .confirmar').on('click', function() {
		$('#shadow-box').fadeOut( 300 );
		$this.parent('.contenido').remove();
		
		$('#shadow-box .confirmar').on('click', function() {});
	}); // $('#shadow-box .confirmar').on('click', function() {
	
	// Si el usuario rechaza desaparece el cuadro de diálogo
	$('#shadow-box .rechazar').on('click', function() {
		$('#shadow-box').fadeOut( 300 );
		
		$('#shadow-box .rechazar').on('click', function() {});
	}); // $('#shadow-box .rechazar').on('click', function() {
		
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
}); // $('.eliminar-contenido').click(function() {


$('.eliminar-pregunta').click(function() {
	'use strict';
	
	
	var $this = $(this);
	
	// Bloque para desplegar diálogo de confirmación
	$('#shadow-box h1').html('¿Quiere eliminar esta pregunta?');
	$('#shadow-box').fadeIn( 300 );
	$('#shadow-box .confirmar').focus();
	
	// Si el usuario confirma se elimina el contenido
	$('#shadow-box .confirmar').on('click', function() {
		$('#shadow-box').fadeOut( 300 );
		$this.parent('.pregunta').remove();
		
		$('#shadow-box .confirmar').on('click', function() {});
	}); // $('#shadow-box .confirmar').on('click', function() {
	
	// Si el usuario rechaza desaparece el cuadro de diálogo
	$('#shadow-box .rechazar').on('click', function() {
		$('#shadow-box').fadeOut( 300 );
		
		$('#shadow-box .rechazar').on('click', function() {});
	}); // $('#shadow-box .rechazar').on('click', function() {
	
	
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
}); // $('.eliminar-contenido').click(function() {


$('.eliminar-respuesta').click(function() {
	'use strict';
	
	
	var $this = $(this);
	
	// Bloque para desplegar diálogo de confirmación
	$('#shadow-box h1').html('¿Quiere eliminar esta respuesta?');
	$('#shadow-box').fadeIn( 300 );
	$('#shadow-box .confirmar').focus();
	
	// Si el usuario confirma se elimina el contenido
	$('#shadow-box .confirmar').on('click', function() {
		$('#shadow-box').fadeOut( 300 );
		$this.parent('.respuesta').remove();
		
		$('#shadow-box .confirmar').on('click', function() {});
	}); // $('#shadow-box .confirmar').on('click', function() {
	
	// Si el usuario rechaza desaparece el cuadro de diálogo
	$('#shadow-box .rechazar').on('click', function() {
		$('#shadow-box').fadeOut( 300 );
		
		$('#shadow-box .rechazar').on('click', function() {});
	}); // $('#shadow-box .rechazar').on('click', function() {
	
	
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
}); // $('.eliminar-contenido').click(function() {


$(function() {
	'use strict';
	
	// Inicia el módulo 'sortable' para mover
	// y reacomodar los módulos y contenidos
	$( "#modulos, #modulos .contenidos" ).sortable({
		revert: true,
		axis: 'y',
		//containment: '#modulos',
		cursor: 'move',
		delay: 150,
		forcePlaceholderSize: true,
		placeholder: "sortable-placeholder"
	}); // $( "#modulos, #modulos .contenidos" ).sortable({
	
	$( "fieldset, .contenido" ).disableSelection();
}); // $(function() {


$('#agregar-tema').submit(function(e) {
	'use strict';
	
    e.preventDefault();
	
	var modulos = $(this).find('fieldset.modulo');
	
	modulos.each(function(index, element) {
		var modulo = modulos.eq( index );
        //console.log( modulo.find('input[name="modulo[]"]').val() );
		
		console.log( 'MODULO ' + modulo.children('input[name="modulo[]"]')[0].value );
		
		//console.log('DUMP ' + dump(modulo.children('input[name="modulo[]"]')[0].value));
		
		var contenidos = modulo.find('.contenidos .contenido');
		
		contenidos.each(function(i, el) {
            
			var contenido = contenidos.eq( i );
			
			console.log( 'Contenido: ' + contenido.find('input[name="nombre-contenido"]')[0].value );
			
        }); // contenidos.each(function(i, el) {
    }); // modulos.each(function(index, element) {
	
}); // $('#agregar-tema').submit(function(e) {


$('#agregar-tema').submit(function(e) {
	'use strict';
	
	e.preventDefault();
	
}); // $('#agregar-tema').submit(function(e) {


function dump(obj) {
	'use strict';
	
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }
	
	return out;
}