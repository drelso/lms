// Script para agregar y acomodar temas

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
	});
	
	$( "fieldset, .contenido" ).disableSelection();
	
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
	
	
});

$('.agregar-contenido').click(function() {
	'use strict';
	
	//$('.contenido:first').clone(true).appendTo($(this).parent().parent());
	$('#campo-agregar-contenido .contenido').clone(true).appendTo($(this).siblings('.contenidos'));
	
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
});

$('.eliminar-contenido').click(function() {
	'use strict';
	
	$(this).parent('.contenido').remove();
	
	$( "#modulos, #modulos .contenidos" ).sortable('refresh');
});

$(function() {
	'use strict';
	
	$( "#modulos, #modulos .contenidos" ).sortable({
		revert: true,
		axis: 'y',
		//containment: '#modulos',
		cursor: 'move',
		delay: 150,
		forcePlaceholderSize: true,
		placeholder: "sortable-placeholder"
	});
	
	$( "fieldset, .contenido" ).disableSelection();
});


$('#agregar-tema').submit(function(e) {
	'use strict';
	
    e.preventDefault();
	
	var modulos = $(this).find('fieldset');
	
	modulos.each(function(index, element) {
		var modulo = modulos.eq( index );
        //console.log( modulo.find('input[name="modulo[]"]').val() );
		
		console.log( 'MODULO ' + modulo.children('input[name="modulo[]"]')[0].value );
		
		//console.log('DUMP ' + dump(modulo.children('input[name="modulo[]"]')[0].value));
		
		var contenidos = modulo.find('.contenidos .contenido');
		
		contenidos.each(function(i, el) {
            
			var contenido = contenidos.eq( i );
			
			console.log( 'Contenido: ' + contenido.find('input[name="nombre-contenido"]')[0].value );
			
        });
    });
	
});


function dump(obj) {
	'use strict';
	
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }
	
	return out;
    //alert(out);

    // or, if you wanted to avoid alerts...

    //var pre = document.createElement('pre');
    //pre.innerHTML = out;
    //document.body.appendChild(pre);
}