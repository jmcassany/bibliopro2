$(document).ready(function() {

	// i18n
	var i18n_boxNameEmpty = 'Cal indicar el nom de la caixa';

	// objecte jQ del formulari del newsletter
	var nForm = $('#newsletterForm');
	// id del contenidor d'afegir caixes
	var addBoxContainerID = 'addBox';
	// id del formulari d'afegir caixa
	var addBoxFormID = 'newBoxForm';
	// classe del contenidor d'afegir ítems
	var addEntriesContainerClass = 'addEntries';
	// id del formulari d'afegir items
	var addItemsFormID = 'newItemsForm';
	// id del contenidor de controls
	var controlsContainerID = 'frontpage_controls';
	
	
	/* FUNCIONS NOVES DE LA VERSIÓ AMB TEMPLATES */
	
	function updateContent(idColumna, idCaixa, idNoticia, valor, accio){
		  $.ajax({
			  type: 'POST',
			  url: 'update.php',
			  data: {'accio' : accio, 'idColumna': idColumna, 'idCaixa' : idCaixa, 'idNoticia' : idNoticia, 'valor' : valor, 'IdCam' : campaignID},
			  success: function(result){
			  }
		});
	}
	
	/* FI FUNCIONS NOVES DE LA VERSIÓ AMB TEMPLATES */

	// obtenim l'índex indicat de l'array
	function getArrayIndex(arrayString, i) {
		var parts = arrayString.split('[');
		if (parts[i] != undefined) {
			return parts[i].replace(']', '');
		}
		else { return false; }

	}

	// establim l'índex indicat de l'array
	function setArrayIndex(arrayString, i, newIndexValue) {

		var parts = arrayString.split('[');
		if (parts[i] != undefined) {
			parts[i] = newIndexValue+']';
			return parts.join('[');
		}
		else { return false; }

	}
	
	// actualitzem el contenidor d'afegir ítems
	function updateAddEntriesContainer(box) {

		var addEntriesContainer = box.find('div.' + addEntriesContainerClass);
		if (addEntriesContainer.is(':visible')) {
			var items = box.find('input[name^=newsletter]');
			var boxArray = items.first().attr('name');
			var selectedItems = new Array();
			items.each(function(i) {
				selectedItems[i] = $(this).val();
			});
			addEntriesContainer.load(
				('afegir-items.php #' + addItemsFormID),
				{
					'idCam': campaignID,
					'tipusCaixa': getArrayIndex(boxArray, 4),
					'columna': getArrayIndex(boxArray, 2),
					'nomCaixa': getArrayIndex(boxArray, 3),
					'modeCaixa': nouEstil,
					'estilsLlistat': getArrayIndex(boxArray, 7),
					'selectedItems': selectedItems,
					'indexCaixa' : indexCaixeta
				},
				// efecte coloraines selecció/deselecció nous items
				function() {
					$(this).find('label').mouseup(function() {
						$(this).toggleClass('checked');
						return;
					});
				}
			);
		}
		return;

	}

	// actualitzem el contenidor d'afegir caixa amb les entrades corresponents
	function updateAddBoxContainer(boxType, column, boxName, newBox, idCam) {

		var addBoxContainer = $('#' + addBoxContainerID);
		if (addBoxContainer.is(':visible')) {
			addBoxContainer.load(
				('afegir-items.php #' + addItemsFormID),
				{
					'idCam': campaignID,
					'tipusCaixa': boxType,
					'columna': column,
					'nomCaixa': boxName,
					'novaCaixa' : newBox,
					'idCam' : idCam,
					'modeCaixa' : 0
				},
				// efecte coloraines selecció/deselecció nous items
				function() {
					$(this).find('label').mouseup(function() {
						$(this).toggleClass('checked');
						return;
					});
				}
			);
		}
		return;

	}

	// apliquem els comportaments a les caixes
	function applyBehaviours(element) {

		var elementObject = $(element);
		var elementIdCaixa = elementObject.find('input').val();
		// fem que la caixa es pugui plegar (només quedarà visible el settings.elements.headingContainer)
		$('li.box.collapsible', elementObject).makeCollapsible({'elements': { ignoredWhenCollapsing: 'div.addEntries' }});

		// fem que el títol de la caixa (settings.elements.title) es pugui canviar
		$('li.box.renamable', elementObject).makeRenamable({}, function(oldTitle, newTitle, box) {
			// si no està buit, canviem el nom de la caixa a l'array per cadascun dels elements i actualitzem
			newTitle = $.trim(newTitle);
			if (newTitle.length > 0) {
				var e = box.find('input[name^=newsletter]');
				e.each(function() {
					$(this).attr('name', setArrayIndex($(this).attr('name'), 3, newTitle));
				});
				// gravem els canvis
				nForm.ajaxSubmit();
				idColumna = elementObject.closest('div.boxes').attr('id');
				idCaixa = oldTitle;
				idNoticia = null;
				// si la caixa de selecció de nous items està visible, l'actualitzem
				updateContent(idColumna, idCaixa, idNoticia, newTitle, 'canviNomCaixa');
					
				updateAddEntriesContainer(box);
			}

		});

		// fem les caixes reordenables i connectem les que tinguin la classe indicada
		var sortableBoxesSettings = {
			idColumna: null,	
			connectWith: 'ul.connected-box',
			receive: function(event, ui) {
				// get new column index
				idColumna = ui.sender.context.parentElement.attributes[1].value;
				idCaixa = ui.item.find('h3').html();
				nouIndexCaixa = ui.item.index();
				nouIdColumna = ui.item.closest('div.boxes').attr('id');
				idNoticia = null;
				
				var arrayIndex = new Array();
				arrayIndex[0] = nouIndexCaixa; //Nou index de la caixa
				arrayIndex[1] = nouIdColumna; //Columna destí de la caixa
				
				var newColumnIndex = $('ul.boxes').index(ui.item.parent('ul.boxes'));
				var e = ui.item.find('input[name^=newsletter]');
				e.each(function() {
					$(this).attr('name', setArrayIndex($(this).attr('name'), 2, (newColumnIndex + 1)));
				});// si la caixa de selecció de nous items està visible, l'actualitzem
				updateAddEntriesContainer(ui.item);
				updateContent(idColumna, idCaixa, idNoticia, arrayIndex, 'moureCaixaColumna');
			},
			update: function(event, ui) {
				idCaixa = ui.item.find('h3').html();
				nouIndexCaixa = ui.item.index();
				idColumna = ui.item.closest('div.boxes').attr('id');
				idNoticia = null;
				updateContent(idColumna, idCaixa, idNoticia, nouIndexCaixa, 'moureCaixa');
				
				// si la caixa de selecció de nous items està visible, l'actualitzem
				updateAddEntriesContainer(ui.item);
				nForm.ajaxSubmit();
			}
		};
		elementObject.makeSortable(sortableBoxesSettings);

		// fem les notícies, les fem reordenables i els connectem
		var sortableEntriesSettings = {
			connectWith: 'ul.news',
			// si un element canvia de caixa, en modifiquem el nom de l'array
			receive: function(event, ui) {
				var sample = ui.item.parent().children(ui.item[0].tagName);
				// if example element is the same as the dragged one, get next
				if (sample.get(0) == ui.item.get(0)) { sample = sample.next(); }
				var newArray = sample.find('input[name^=newsletter]').attr('name');
				ui.item.find('input[name^=newsletter]').attr('name', newArray);
				// si la caixa de selecció de nous items està visible, l'actualitzem
				updateAddEntriesContainer(ui.item);
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
				
				
				idNoticia = ui.item.attr('id');
				nouIndexNoticia = ui.item.index();
				idColumna = ui.item.closest('div.boxes').attr('id');
				idCaixa = ui.item.parents('li.box').children('.heading').find('h3').html();
				
				updateContent(idColumna, idCaixa, idNoticia, nouIndexNoticia, 'moureNoticia');
				
				updateAddEntriesContainer(ui.item);
				nForm.ajaxSubmit();
			}
		};
		elementObject.find('ul.draggable').makeSortable(sortableEntriesSettings);

		// fem que les caixes es puguin eliminar
		elementObject.children('li.box.removable').makeRemovable(
			{
				'elements': { controlsContainer: 'div.heading' },
				'i18n': { remove: 'Eliminar' }
			},
			false,
			function(element) {
				idColumna = elementObject.closest('div.boxes').attr('id');
				idCaixa = element.find('h3').html();

				nForm.ajaxSubmit();
				updateContent(idColumna, idCaixa, null, null, 'eliminaCaixa');
				// si la caixa de selecció de nous items està visible, l'actualitzem
				//updateAddEntriesContainer(elementObject);
			}
		);
		elementObject.children('li.box.removable').find('li.box.removable').makeRemovable(
			{
				'elements': { controlsContainer: 'div.elementControls.clearfix' },
				'i18n': { remove: 'Eliminar' }
			},
			false,
			function(element, elementParent) {
				nForm.ajaxSubmit();
				idColumna = elementObject.closest('div.boxes').attr('id');
				idNoticia = element.attr('id');
				idCaixa = elementParent.closest('li.box').find('h3').html();
				updateContent(idColumna, idCaixa, idNoticia, null, 'deleteNoticia');
				
				// si la caixa de selecció de nous items està visible, l'actualitzem
				updateAddEntriesContainer(elementObject);
				
				if(elementParent.children('li').size() == 0){
					$(elementParent.closest('li.box')).remove();
				};
			}
		);

		/** tot seguit...
		/*
		/* CODI INDEPENDENT DEL PLUG-IN DE CAIXES (jquery.boxes.js)
		/*
		**/

		// permetem canviar l'estil (classe) a les caixes
		elementObject.children('li.box.stylable').each(function(i, stylableElement) {

			var jQsE = $(stylableElement);

			// estil actual
			var activeClass = getArrayIndex(jQsE.find('input[name^=newsletter]:eq(0)').attr('name'), 6);

			// llistat per seleccionar l'estil desitjat
			var stylingList = '<ul class="boxStylingControls clearfix">';
			stylingList += '<li>Tipus<br /> caixa:</li>';
			for (i in sortedBoxClasses) { stylingList += '<li class="'+(sortedBoxClasses[i] == activeClass ? ' current':'')+'"><a href="" class="'+sortedBoxClasses[i]+'">'+boxClasses[sortedBoxClasses[i]]+'</a></li>'; }
			stylingList += '</ul>';

			// posicionem el llistat de selecció d'estil
			var stylingControlsContainer = jQsE.find('div.stylingControls');
			if (stylingControlsContainer.length > 0) {
				stylingControlsContainer.prepend(stylingList);
			}
			else {
				jQsE.children('div.heading').after('<div class="stylingControls clearfix">' + stylingList + '</div>');
			}

			// canviem l'estil del llistat
			jQsE.find('ul.boxStylingControls').children('li').children('a').click(function() {

				var lnk = $(this);
				lnk.parent().parent().children('li').removeClass('current');
				lnk.parent().addClass('current');
				idColumna = jQsE.closest('div.boxes').attr('id');
				idCaixa = $('#' + idColumna).find('h3').html();
				var newClassName = lnk.attr('class');
				for (className in boxClasses) { jQsE.removeClass(className); }
				jQsE.addClass(newClassName);

				// canviem l'array amb l'índex del nou estil
				jQsE.find('ul.listing li.box').each(function(i, e) {

					var l = $(e).find('input[name^=newsletter]');
					for (var i = 0; i < sortedBoxClasses.length; i++) {
						if (sortedBoxClasses[i] == newClassName) { var newClassIndex = i; break; }
					}
					l.attr('name', setArrayIndex(l.attr('name'), 6, newClassIndex));

				});
				updateContent(idColumna, idCaixa, null, newClassName, 'destacarCaixa');
				updateAddEntriesContainer(jQsE);
				nForm.ajaxSubmit();
				return false;

			});

		});

		// permetem canviar l'estil (classe) dels llistats de les caixes
		$('li.box ul.stylable', element).each(function(i, stylableElement) {

			var jQsE = $(stylableElement);

			// caixa
			var box = jQsE.closest('li.box');
			// estil actual
			var activeClass = getArrayIndex(jQsE.children('li.box:eq(0)').find('input[name^=newsletter]').attr('name'), 7);

			// llistat per seleccionar l'estil desitjat
			var stylingList = '<ul class="listStylingControls clearfix">';
			stylingList += '<li>Tipus<br /> llistat:</li>';
			for (i in sortedListingClasses) { 
				stylingList += '<li class="'+(sortedListingClasses[i] == activeClass ? ' current':'')+'"><a href="" class="'+sortedListingClasses[i]+'">'+listingClasses[sortedListingClasses[i]]+'</a></li>'; 
			}
			stylingList += '</ul>';

			// posicionem el llistat de selecció d'estil
			var stylingControlsContainer = box.find('div.stylingControls');
			if (stylingControlsContainer.length > 0) {
				stylingControlsContainer.append(stylingList);
			}
			else {
				box.children('div.heading').after('<div class="stylingControls clearfix">' + stylingList + '</div>');
			}

			// canviem l'estil del llistat
			box.find('ul.listStylingControls').children('li').children('a').click(function() {

				var lnk = $(this);
				lnk.parent().parent().children('li').removeClass('current');
				lnk.parent().addClass('current');
				idColumna = box.closest('div.boxes').attr('id');
				idCaixa = box.find('h3').html();
				var newClassName = lnk.attr('class');
				for (className in listingClasses) { jQsE.removeClass(className); }
				jQsE.addClass(newClassName);
				
				// Canviem els estils de la caixeta (Files (normal) o Columnes (double)) dins l'array CONTENT del newsletter
				// El nou estil el proporciona la classe del botó (newClassName a js)
				// L'index (indexCaixeta) de la caixa ens el proporciona la X l'id de l'ul on hem fet clic caixaX
				
				jQsE.children('li.box').each(function(i, e) {
						
					var l = $(e).find('input[name^=newsletter]');
					
					for (var i = 0; i < sortedListingClasses.length; i++) {
						if (sortedListingClasses[i] == newClassName) { var newClassIndex = i; break; }
					}
					l.attr('name', setArrayIndex(l.attr('name'), 7, newClassIndex));

				});
				updateContent(idColumna, idCaixa, null, newClassName, 'canviModeCaixa');
				updateAddEntriesContainer(box);
				nForm.ajaxSubmit();
				return false;

			});

		});

		// permetem canviar l'estil (classe) als elements dels llistats de les caixes
		elementObject.children('li.box').find('li.box.stylable').each(function(i, stylableElement) {

			var element = $(this);
			var jQsE = $(stylableElement);

			// estil actual
			var activeClass = getArrayIndex(jQsE.find('input[name^=newsletter]').attr('name'), 8);

			// llistat per seleccionar l'estil desitjat
			var stylingList = '<ul class="elementStylingControls clearfix">';
			for (i in sortedElementClasses) { stylingList += '<li class="'+(i == activeClass ? ' current':'')+'"><a href="" class="'+sortedElementClasses[i]+'">'+elementClasses[sortedElementClasses[i]]+'</a></li>'; }
			stylingList += '</ul>';

			// posicionem el llistat de selecció d'estil
			var elementControls = jQsE.find('div.elementControls');
			if (elementControls.length > 0) {
				elementControls.prepend(stylingList);
			}
			else {
				jQsE.append('<div class="elementControls clearfix">' + stylingList + '</div>');
			}

			// canviem l'estil del llistat
			jQsE.find('ul.elementStylingControls').children('li').children('a').click(function() {

				var lnk = $(this);
				lnk.parent().parent().children('li').removeClass('current');
				lnk.parent().addClass('current');
				idColumna = elementObject.closest('div.boxes').attr('id');
				idNoticia = jQsE.attr('id');
				idCaixa = elementObject.closest('div').find('h3').html()
				var newClassName = lnk.attr('class');
				for (className in elementClasses) { jQsE.removeClass(className); }
				jQsE.addClass(newClassName);

				// canviem el nom de l'array amb l'índex del nou estil
				var l = jQsE.find('input[name^=newsletter]');
				
				for (var i = 0; i < sortedElementClasses.length; i++) {
					if (sortedElementClasses[i] == newClassName) { var newClassIndex = i; break; }
				}
				l.attr('name', setArrayIndex(l.attr('name'), 8, newClassIndex));
				
				nForm.ajaxSubmit();
				updateContent(idColumna, idCaixa, idNoticia, newClassName, 'destacarNoticia');
				return false;

			});

		});

	}

	// apliquem els comportaments de les caixes
	$('ul.boxes').each(function(i, element) { applyBehaviours(element); });

	// permetem afegir noves caixes
	$('a.addNewBox').click(function() {

		var lnk = $(this);

		var controlsContainer = lnk.closest('#' + controlsContainerID);
		var addBoxContainer = $('#' + addBoxContainerID);

		if (addBoxContainer.length == 0) {

			controlsContainer.after('<div id="' + addBoxContainerID + '" style="display: none;"></div>');
			addBoxContainer = $('#' + addBoxContainerID);

		}

		// carreguem el formulari al contenidor corresponent
		numCols = $('div.boxes > ul.boxes').length;
		addBoxContainer.load(
			('afegir-caixa.php #' + addBoxFormID),
			{
				'idCam': campaignID
			},
			function() {
				var c = $(this);
				c.slideToggle();
				lnk.parent().toggleClass('add_off');
			}
		);

		return false;

	});
	// a l'enviar la informació sobre la nova caixa, carreguem les entrades disponibles al mateix contenidor
	$('#' + addBoxFormID).live('submit', function() {
		if ($('#nomCaixa').val().length > 0) {
			updateAddBoxContainer(
				$('#tipusCaixa').val(),
				$('#columna').val(),
				$('#nomCaixa').val(),
				$('#novaCaixa').val(),
				$('#idCam').val()
			);
		}
		else { alert(i18n_boxNameEmpty); }
		return false;
	});

	// a l'afegir entrades a una caixa, informem de la columna, del nom i de l'estil de la caixa i del llistat
	$('a.addEntries').click(function() {

		var lnk = $(this);

		// limitem qualsevol operació a la caixa del botó utilitzat
		var box = lnk.closest('li.box');

		var headingContainer = box.find('div.heading');
		var addEntriesContainer = box.find('div.' + addEntriesContainerClass);

		if (addEntriesContainer.length == 0) {

			headingContainer.after('<div class="' + addEntriesContainerClass + '" style="display: none;"></div>');
			addEntriesContainer = box.find('div.' + addEntriesContainerClass);

		}

		var items = box.find('input[name^=newsletter]');
		var boxArray = items.first().attr('name');
		
		var selectedItems = new Array();
		items.each(function(i) {
			selectedItems[i] = $(this).val();
			//updateContent(idColumna, idCaixa, idNoticia, valor, 'afegirNoticiaCaixa');
		});
		// carreguem el formulari al contenidor corresponent
		addEntriesContainer.load(
			('afegir-items.php #' + addItemsFormID),
			{
				'idCam': campaignID,
				'tipusCaixa': getArrayIndex(boxArray, 4),
				'columna': getArrayIndex(boxArray, 2),
				'nomCaixa': getArrayIndex(boxArray, 3),
				'estilsCaixa': getArrayIndex(boxArray, 6),
				'estilsLlistat': getArrayIndex(boxArray, 7),
				'selectedItems': selectedItems
			},
			function() {
				var c = $(this);
				c.slideToggle();
				lnk.parent().toggleClass('add_off');
				// efecte coloraines selecció/deselecció nous items
				c.find('label').mouseup(function() {
					$(this).toggleClass('checked');
					return;
				});
			}
		);

		return false;

	});

});