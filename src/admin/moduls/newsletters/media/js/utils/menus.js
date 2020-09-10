// afegim nou punt de menú
function add_field (hierarchy, parent_id) {

	if (hierarchy === undefined) { hierarchy = 0; }
	if (parent_id === undefined) { parent_id = false; }

	if (hierarchy == 0) {

		// obtenim id aleatori
		var rdm_str = (new Date).getTime(); rdm_str += ''; // forcem string
		var rdm_num = Math.floor(Math.random()*11); rdm_num += ''; // forcem string
		$('ul.menu_builder').append('<li id="'+rdm_str+'_'+rdm_num+'"><div class="line draggable clearfix"><ul class="actions"><li class="add"><a href="#"><img src="'+urlBase+'/media/img/add_element.png" alt="'+i18n_element_add+'" /></a></li><li class="edit"><a href="#"><img src="'+urlBase+'/media/img/editar.png" alt="'+i18n_element_edit+'" /></a></li><li class="delete"><a href="#"><img src="'+urlBase+'/media/img/delete.png" alt="'+i18n_element_remove+'" /></a></li></ul><div class="wrapper"><h5>'+i18n_link_default_name+'</h5><fieldset><label for="'+rdm_str+'_'+rdm_num+'_name"><span>'+i18n_label_name+':</span><input type="text" name="menu[][name]" id="'+rdm_str+'_'+rdm_num+'_name" value="'+i18n_link_default_name+'" /></label><label for="'+rdm_str+'_'+rdm_num+'_link"><span>'+i18n_label_link+':</span><input type="text" name="menu[][link]" id="'+rdm_str+'_'+rdm_num+'_link" value="'+i18n_link_default_url+'" /></label></fieldset></div></div><ul></ul></li>');
		apply_behaviour(rdm_str+'_'+rdm_num);
		sortables();
		return true;

	}
	else if (hierarchy == 1) {

		if (parent_id === false) { return false; }

		// obtenim id aleatori
		var rdm_str = (new Date).getTime(); rdm_str += ''; // forcem string
		var rdm_num = Math.floor(Math.random()*11); rdm_num += ''; // forcem string

		// comprovem que tingui contenidor pels fills
		if ($('#'+parent_id).children('ul').length == 0) { $('#'+parent_id).append('<ul></ul>'); alert('NOLIST!'); }

		$('#'+parent_id).children('ul').append('<li id="'+rdm_str+'_'+rdm_num+'"><div class="line draggable1 clearfix"><ul class="actions"><li class="add"><a href="#"><img src="'+urlBase+'/media/img/add_subelement.png" alt="'+i18n_element_add+'" /></a></li><li class="edit"><a href="#"><img src="'+urlBase+'/media/img/editar.png" alt="'+i18n_element_edit+'" /></a></li><li class="delete"><a href="#"><img src="'+urlBase+'/media/img/delete.png" alt="'+i18n_element_remove+'" /></a></li></ul><div class="wrapper"><h5>'+i18n_link_default_name+'</h5><fieldset><label for="'+rdm_str+'_'+rdm_num+'_name"><span>'+i18n_label_name+':</span><input type="text" name="menu[][name]" id="'+rdm_str+'_'+rdm_num+'_name" value="'+i18n_link_default_name+'" /></label><label for="'+rdm_str+'_'+rdm_num+'_link"><span>'+i18n_label_link+':</span><input type="text" name="menu[][link]" id="'+rdm_str+'_'+rdm_num+'_link" value="'+i18n_link_default_url+'" /></label></fieldset></div></div><ul></ul></li>');
		apply_behaviour(rdm_str+'_'+rdm_num);
		sortables();
		return true;

	}
	else if (hierarchy == 2) {

		if (parent_id === false) { return false; }

		// obtenim id aleatori
		var rdm_str = (new Date).getTime(); rdm_str += ''; // forcem string
		var rdm_num = Math.floor(Math.random()*11); rdm_num += ''; // forcem string

		// comprovem que tingui contenidor pels fills
		if ($('#'+parent_id).children('ul').length == 0) { $('#'+parent_id).append('<ul></ul>'); alert('NOLIST!'); }

		$('#'+parent_id).children('ul').append('<li id="'+rdm_str+'_'+rdm_num+'"><div class="line draggable2 clearfix"><ul class="actions"><li class="edit"><a href="#"><img src="'+urlBase+'/media/img/editar.png" alt="'+i18n_element_edit+'" /></a></li><li class="delete"><a href="#"><img src="'+urlBase+'/media/img/delete.png" alt="'+i18n_element_remove+'" /></a></li></ul><div class="wrapper"><h5>'+i18n_link_default_name+'</h5><fieldset><label for="'+rdm_str+'_'+rdm_num+'_name"><span>'+i18n_label_name+':</span><input type="text" name="menu[][name]" id="'+rdm_str+'_'+rdm_num+'_name" value="'+i18n_link_default_name+'" /></label><label for="'+rdm_str+'_'+rdm_num+'_link"><span>'+i18n_label_link+':</span><input type="text" name="menu[][link]" id="'+rdm_str+'_'+rdm_num+'_link" value="'+i18n_link_default_url+'" /></label></fieldset></div></div></li>');
		apply_behaviour(rdm_str+'_'+rdm_num);
		sortables();
		return true;

	}
	else { return false; }

}

// implementem funcionalitats
function apply_behaviour(id) {

	// div.line
	var e = $('#'+id).children('div.line');
	// element (li (this))
	var element = $('#'+id);
	// fieldset (inputs nom i adreça enllaç)
	var fieldset = e.children('div.wrapper').children('fieldset');
		var txt = fieldset.children('label:eq(0)').children('input');
		var lnk = fieldset.children('label:eq(1)').children('input');
	// capçalera (nom enllaç)
	var h5 = e.children('div.wrapper').children('h5');
	// llistat accions
	var actions = e.children('ul.actions');
		var add = actions.children('li.add').children('a');
		var del = actions.children('li.delete').children('a');
		var edit = actions.children('li.edit').children('a');

	// ocultem el formulari de modificació
	fieldset.hide();

	// al fer click sobre el botó d'afegir, creem un nou fill (no malpensar)
	add.click(function(){

		// comprovem a quin nivell de la jerarquia estem
		if (element.parent('ul').parent('li').parent('ul').length != 0) { add_field(2, element.attr('id')); }
		else { add_field(1, element.attr('id')); }
		return false; // anul·lem l'acció del click

	});

	// al fer click sobre el botó d'eliminar, eliminem l'element
	del.click(function(){

		// demanem confirmació a l'usuari
		var conf = confirm(i18n_confirm_message);
		if (conf) { element.slideUp('fast', element.remove()); }
		return false; // anul·lem l'acció del click

	});

	// al fer click sobre el botó de modificar, ocultem el nom actual i mostrem el formulari de modificació
	edit.click(function(){

		// amaguem botons i nom enllaç
		actions.slideUp('fast');
		h5.slideUp('fast');
		// mostrem caixa acceptar/cancel·lar i formulari
		var a = e.prepend('<ul class="alert"><li class="cancel"><a href="#">'+i18n_cancel+'</a></li><li class="accept"><a href="#">'+i18n_accept+'</a></li></ul>');
		// donem funcionalitat a la caixa d'acceptar/cancel·lar
		// botó acceptar
		a.children('ul').children('li.accept').children('a').click(function(){
			$(this).parent().parent().slideUp('fast');
			fieldset.slideUp('fast');
			actions.show('fast');
			h5.text(txt.val());
			h5.slideDown('fast');
		});
		// botó cancel·lar
		a.children('ul').children('li.cancel').children('a').click(function(){
			// retornem el valor dels inputs a l'original
			fieldset.children('label').each(function(){
				$(this).children('input').each(function(){
					original = $(this)[0].defaultValue;
					$(this).val(original);
				});
			});
			$(this).parent().parent().slideUp('fast');
			fieldset.slideUp('fast');
			actions.slideDown('fast');
			h5.text(txt.val());
			h5.slideDown('fast');
		});
		fieldset.slideDown('fast');
		return false; // anul·lem l'acció del click

	});

}

// reordenació elements
function sortables() {

	// fem els elements reordenables
	$('ul.menu_builder > li > ul > li > ul').sortable({
		placeholder: 'placeholder',
		handle: 'div.draggable2',
		delay: 300,
		cursorAt: { bottom: 0 },
		opacity: 0.7, helper: 'clone',
		connectWith: 'ul.menu_builder > li > ul > li > ul'
	});
	$('ul.menu_builder > li > ul > li > ul').disableSelection();
	$('ul.menu_builder > li > ul').sortable({
		placeholder: 'placeholder',
		handle: 'div.draggable1',
		delay: 300,
		cursorAt: { bottom: 0 },
		opacity: 0.7, helper: 'clone',
		connectWith: 'ul.menu_builder > li > ul'
	});
	$('ul.menu_builder > li > ul').disableSelection();
	$('ul.menu_builder').sortable({
		placeholder: 'placeholder',
		handle: 'div.draggable',
		delay: 300,
		cursorAt: { bottom: 0 },
		opacity: 0.7, helper: 'clone',
		connectWith: 'ul.menu_builder'
	});
	$('ul.menu_builder').disableSelection();

}

$(document).ready(function(){

	// IMPORTANT: s'ha de carregar nivell a nivell, ja que sino el firefox es fa la pitxa un lio amb els selectors i acaba petant
	// per cada element del primer nivell, activem funcionalitats
	$('ul.menu_builder > li > div.line').each(function(){ apply_behaviour($(this).parent().attr('id')); });
	// per cada element del segon nivell, activem funcionalitats
	$('ul.menu_builder > li > ul > li > div.line').each(function(){ apply_behaviour($(this).parent().attr('id')); });
	// per cada element del tercer nivell, activem funcionalitats
	$('ul.menu_builder > li > ul > li > ul > li >div.line').each(function(){ apply_behaviour($(this).parent().attr('id')); });

	// si fem click al botó d'afegir nou element, l'afegim al final del menú
	$('#add_field').click(function(){ add_field(); return false; });

	// permetem reordenar els punts del menú
	sortables();

});