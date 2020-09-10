$(document).ready(function() {

	function applyBehaviours(element) {

		// fem que el llistat de la caixa es pugui redimensionar
		$('li.box.resizable ul.listing', element).makeResizable(2);

		// fem que la caixa es pugui eliminar
		$('li.box.removable', element).makeRemovable();

		// fem que la caixa es pugui plegar (només quedarà visible el settings.elements.headingContainer)
		$('li.box.collapsible', element).makeCollapsible();

		// fem que el títol de la caixa (settings.elements.title) es pugui canviar
		$('li.box.renamable', element).makeRenamable({}, function(newTitle, box) {

			// canviem el nom de la caixa al nom de l'array
			var inputName = box.find('input[type=hidden]:eq(0)').attr('name');
			var parts = inputName.split('[');
			parts[3] = newTitle+']'; // si l'array amb la info del newsletter creix o disminueix, s'ha de modificar l'índex de l'assignació
			box.find('input[type=hidden]').attr('name', parts.join('['));

		});

		// fem les caixes reordenables i connectem les que tinguin la classe indicada
		var sortableBoxesSettings = {
			connectWith: 'ul.connected-box',
			receive: function(event, ui) {
				// get new column index
				var newIndex = $('ul.boxes').index(ui.item.parent('ul.boxes'));
				var parts = ui.item.find('input[type=hidden]').attr('name').split('[');
				parts[2] = (newIndex + 1)+']';
				ui.item.find('input[type=hidden]').attr('name', parts.join('['));
			}
		};
		$(element).makeSortable(sortableBoxesSettings);

		// fem els llistats de les caixes de notícies i els connectem
		var sortableEntriesSettings = {
			connectWith: 'ul.news',
			// si un element canvia de caixa, en modifiquem el nom de l'array
			receive: function(event, ui) {
				var sample = ui.item.parent().children(ui.item[0].tagName);
				// if example element is the same as the dragged one, get next
				if (sample.get(0) == ui.item.get(0)) { sample = sample.next(); }
				var parts = sample.find('input[type=hidden]').attr('name');
				ui.item.find('input[type=hidden]').attr('name', parts);
			},
			// quan el DOM ha canviat, actualitzem classes
			update: function(event, ui) {
				if (ui.sender != null) {
					ui.sender.children(ui.item[0].tagName).removeClass('first').removeClass('last');
					ui.sender.children(ui.item[0].tagName + ':first').addClass('first');
					ui.sender.children(ui.item[0].tagName + ':last').addClass('last');
				}
				var prnt = ui.item.parent();
				prnt.children(ui.item[0].tagName).removeClass('first').removeClass('last');
				prnt.children(ui.item[0].tagName + ':first').addClass('first');
				prnt.children(ui.item[0].tagName + ':last').addClass('last');
			}
		};
		$(element).find('ul.draggable').makeSortable(sortableEntriesSettings);

		// -- CODI INDEPENDENT DEL PLUG-IN DE CAIXES (jquery.boxes.js)

		// permetem canviar l'estil (classe) a les caixes
		$(element).children('li.box.stylable').each(function(i, stylableElement) {

			var jQsE = $(stylableElement);
			var parts = jQsE.find('input[type=hidden]:eq(0)').attr('name').split('[');

			// estils seleccionables { classe: 'Text de l'enllaç', ... }
			var boxClasses = { normal: 'Normal', highlighted: 'Destacat', extra: 'Extra', superextra: 'Super extra' };
			// llistat necessari per assegurar que l'ordre de les classes és sempre el mateix
			var sortedBoxClasses = ['normal', 'highlighted', 'extra', 'superextra'];
			var activeClass = parts[6].replace(']', ''); // si l'array amb la info del newsletter creix o disminueix, s'ha de modificar l'índex de parts

			// llistat per seleccionar l'estil desitjat
			var stylingList = '<ul class="boxStylingControls clearfix">';
			for (i in sortedBoxClasses) { stylingList += '<li class="'+(i == activeClass ? ' current':'')+'"><a href="#" class="'+sortedBoxClasses[i]+'">'+boxClasses[sortedBoxClasses[i]]+'</a></li>'; }
			stylingList += '</ul>';
			jQsE.prepend(stylingList);

			// canviem l'estil del llistat
			jQsE.children('ul.boxStylingControls').children('li').children('a').click(function() {

				$(this).parent().parent().children('li').removeClass('current');
				$(this).parent().addClass('current');

				var newClassName = $(this).attr('class');
				for (className in boxClasses) { jQsE.removeClass(className); }
				jQsE.addClass(newClassName);

				// canviem el nom de l'array amb l'índex del nou estil
				jQsE.find('ul.listing li.box').each(function(i, e) {

					parts = $(e).find('input[type=hidden]').attr('name').split('[');
					parts[6] = sortedBoxClasses.indexOf(newClassName)+']'; // si l'array amb la info del newsletter creix o disminueix, s'ha de modificar l'índex de parts
					$(e).find('input[type=hidden]').attr('name', parts.join('['));

				});

				return false;

			});

		});

		// permetem canviar l'estil (classe) dels llistats de les caixes
		$('li.box ul.stylable', element).each(function(i, stylableElement) {

			var jQsE = $(stylableElement);
			var parts = jQsE.children('li.box:eq(0)').find('input[type=hidden]').attr('name').split('[');

			var box = jQsE.closest('li.box');
			// estils seleccionables { classe: 'Text de l'enllaç', ... }
			var listingClasses = { normal: 'Files', double: 'Columnes', noir: 'Negre' };
			// llistat necessari per assegurar que l'ordre de les classes és sempre el mateix
			var sortedListingClasses = ['normal', 'double', 'noir'];
			var activeClass = parts[7].replace(']', ''); // si l'array amb la info del newsletter creix o disminueix, s'ha de modificar l'índex de parts

			// llistat per seleccionar l'estil desitjat
			var stylingList = '<ul class="listStylingControls clearfix">';
			for (i in sortedListingClasses) { stylingList += '<li class="'+(i == activeClass ? ' current':'')+'"><a href="#" class="'+sortedListingClasses[i]+'">'+listingClasses[sortedListingClasses[i]]+'</a></li>'; }
			stylingList += '</ul>';
			box.append(stylingList);

			// canviem l'estil del llistat
			box.children('ul.listStylingControls').children('li').children('a').click(function() {

				$(this).parent().parent().children('li').removeClass('current');
				$(this).parent().addClass('current');

				var newClassName = $(this).attr('class');
				for (className in listingClasses) { jQsE.removeClass(className); }
				jQsE.addClass(newClassName);

				// canviem el nom de l'array amb l'índex del nou estil per cada element
				jQsE.children('li.box').each(function(i, e) {

					parts = $(e).find('input[type=hidden]').attr('name').split('[');
					parts[7] = sortedListingClasses.indexOf(newClassName)+']'; // si l'array amb la info del newsletter creix o disminueix, s'ha de modificar l'índex de parts
					$(e).find('input[type=hidden]').attr('name', parts.join('['));

				});

				return false;

			});

		});

		// permetem canviar l'estil (classe) als elements dels llistats de les caixes
		$(element).children('li.box').find('li.box.stylable').each(function(i, stylableElement) {

			var jQsE = $(stylableElement);
			var parts = jQsE.find('input[type=hidden]').attr('name').split('[');

			// estils seleccionables { classe: 'Text de l'enllaç', ... }
			var elementClasses = { normal: 'N', highlighted: 'D', extra: 'E' };
			// llistat necessari per assegurar que l'ordre de les classes és sempre el mateix
			var sortedElementClasses = ['normal', 'highlighted', 'extra'];
			var activeClass = parts[8].replace(']', ''); // si l'array amb la info del newsletter creix o disminueix, s'ha de modificar l'índex de parts

			// llistat per seleccionar l'estil desitjat
			var stylingList = '<ul class="elementStylingControls clearfix">';
			for (i in sortedElementClasses) { stylingList += '<li class="'+(i == activeClass ? ' current':'')+'"><a href="#" class="'+sortedElementClasses[i]+'">'+elementClasses[sortedElementClasses[i]]+'</a></li>'; }
			stylingList += '</ul>';
			jQsE.prepend(stylingList);

			// canviem l'estil del llistat
			jQsE.children('ul.elementStylingControls').children('li').children('a').click(function() {

				$(this).parent().parent().children('li').removeClass('current');
				$(this).parent().addClass('current');

				var newClassName = $(this).attr('class');
				for (className in elementClasses) { jQsE.removeClass(className); }
				jQsE.addClass(newClassName);

				// canviem el nom de l'array amb l'índex del nou estil
				parts = jQsE.find('input[type=hidden]').attr('name').split('[');
				parts[8] = sortedElementClasses.indexOf(newClassName)+']'; // si l'array amb la info del newsletter creix o disminueix, s'ha de modificar l'índex de parts
				jQsE.find('input[type=hidden]').attr('name', parts.join('['));

				return false;

			});

		});

	}

	// apply boxes' behaviours
	$('ul.boxes').each(function(i, element) { applyBehaviours(element); });

	// create new box
	$('#add_box').click(function() {

		newBoxes = $('ul.boxes:first').createBox();
		newBoxes.each(function(i, element) { applyBehaviours(element); });

		return false;

	});

	// muntem array per emmagatzemar les propietats (estils) de cada caixa
// 	$('#boxes').submit(function() {
//
// 		$('ul.boxes > li.box').find('ul.listing > li.box').each(function(i) {
//
// 			// array info
// 			var columnClasses = $(this).closest('ul.boxes').attr('class');
// 			var boxClasses = $(this).closest('li.box').attr('class');
// 			var listingClasses = $(this).closest('ul.listing').attr('class');
// 			var newsletterArray = $('input[name*=newsletter]:first', this).attr('name');
// 			var model = newsletterArray.split('[')[1].replace(']', '');
// 			var columnPosition = newsletterArray.split('[')[2].replace(']', '');
// 			var boxName = newsletterArray.split('[')[3].replace(']', '');
//
// 			$(this).append('<input type="hidden" name="boxes['+model+']['+columnPosition+']['+columnClasses+']['+boxName+']['+boxClasses+']['+listingClasses+'][]" value="'+$(this).attr('class')+'" />');
//
// 		});
//
// 	});

});