(function($) {

	// box structure
	var boxStructure = {
		column: {
			element: 'ul.boxes.clearfix',
			childs: {
				box: {
					element: 'li.box.removable.renamable.collapsible',
					childs: {
						heading: {
							element: 'div.heading',
							html: '<h3>Canvia aquest títol fent-hi click</h3>'
						},
						content: {
							element: 'div.content'
						}
					}
				}
			}
		}
	}

	function getFirstClass (selector) { var parts = selector.split('.'); return ((parts.length > 1) ? parts[0]+'.'+parts[1] : selector); }

	// default settings
	var settings = {
		// translations
		i18n: {
			collapse: 'Plegar',
			push: 'Afegir un element',
			pop: 'Eliminar un element',
			remove: 'Tancar',
			removeConfirm: "Aquesta caixa serà eliminada. N'estàs segur?",
			removeElementConfirm: "Aquest element serà eliminat. N'estàs segur?",
			uiNotIncluded: 'És necessari incloure el guió jQuery UI (Core i Sortables) per a poder utilitzar la funció makeSortable(). Pots descarregar el codi de http://jqueryui.com/download'
		},
		// IMPORTANT: if only classes or an id is specified, element will be considered a DIV when creating a new box
		elements: {
			boxes: getFirstClass(boxStructure.column.childs.box.element), // box element (needs to match boxStructure.column.childs.box.element)
			controlsContainer: getFirstClass(boxStructure.column.childs.box.childs.heading.element), // controls container: controls' ul will be prepended here (needs to be a child of elements.boxes)
			headingContainer: getFirstClass(boxStructure.column.childs.box.childs.heading.element), // heading container (needs to be a child of elements.boxes)
			title: 'h3', // box's title (needs to be a child of elements.headingContainer)
			contentContainer: getFirstClass(boxStructure.column.childs.box.childs.content.element), // content container (needs to be a child of elements.boxes in boxStructure)
			collapsingButtonContainer: getFirstClass(boxStructure.column.childs.box.childs.heading.element), // collapsing button container; collapsing button will be prepended here (needs to be a child of elements.boxes in boxStructure). Also please note that if this element isn't placed inside the headingContainer element, user won't be able to "uncollapse" the box
			ignoredWhenCollapsing: ''
		},
		// controls' classes (IF YOU WANT TO STYLE BOXES' CONTROLS, CHECK THIS VALUES AND ADAPT TO YOUR NEEDS)
		classes: {
			controls: 'box-controls', // ul
			notConnected: 'not-connected', // ul
			collapse: 'collapse', // li
			collapsed: 'collapsed', // li
			push: 'push', // li
			pushOff: 'push-off', // li
			pop: 'pop', // li
			popOff: 'pop-off', // li
			remove: 'remove', // li
			// autodetection classes, only used if code at the end of the script is uncommented
			autoCollapsible: 'collapsible',
			autoRemovable: 'removable',
			autoRenamable: 'renamable',
			autoResizable: 'resizable',
			autoSortable: 'sortable'
		},
		// default non-hidden elements when resizing lists
		resizeLimit: 3
	};

	// create a new box inside each element matched by selector
	$.fn.createBox = function(callback) {

		return this.each(function() {

			var t = $(this);
			var newBoxHtml = buildHtml(boxStructure.column.childs);

			t.prepend(newBoxHtml);

			if ($.isFunction(callback)) { callback(t); }

		});

	}

	// make collapsible
	$.fn.makeCollapsible = function(options, callback) {

		// settings
		$.extend(true, settings, options);

		return this.each(function() {

			var t = $(this);

			// create collapsing button
			var collapsingContainer = t.find(settings.elements.collapsingButtonContainer);

			// check if collapse button already exists
			if (collapsingContainer.children('.'+settings.classes.collapse).length == 0) {
				collapsingContainer.prepend('<span class="'+settings.classes.collapse+'"><a href="" title="'+settings.i18n.collapse+'">'+settings.i18n.collapse+'</a></span>');
			}

			// collapse box when clicking the collapsing button
			t.find(settings.elements.collapsingButtonContainer).children('span.'+settings.classes.collapse).click(function() {
				var tsub = $(this);
				tsub.closest(settings.elements.boxes).children().not(settings.elements.headingContainer+','+settings.elements.ignoredWhenCollapsing).slideToggle();
				tsub.toggleClass(settings.classes.collapsed);
				return false;
			});

			if ($.isFunction(callback)) { callback(t); }

		});

	};

	// make removable
	$.fn.makeRemovable = function(options, callback, onRemoveCallback) {

		// settings
		$.extend(true, settings, options);

		return this.each(function() {

			var t = $(this);
			var parentT = $(this).parent();
			// create or add remove button to the controls list
			var controlsContainer = t.find(settings.elements.controlsContainer);
			// if specified controls container not found, create it and append to the removable element
			if (controlsContainer.length == 0) {
				t.append(function() {
					var parts = buildTag(settings.elements.controlsContainer);
					var htmlString = '';
					for (i in parts) { htmlString += parts[i]; }
					return htmlString;
				});
				controlsContainer = t.children(settings.elements.controlsContainer);
			}
			var controls = controlsContainer.find('ul.'+settings.classes.controls);
			// check if controls list already exists
			if (controls.length > 0) {
				// check if remove button already exists
				if (controls.children('li.'+settings.classes.remove).length == 0) {
					controls.append('<li class="'+settings.classes.remove+'"><a href="" title="'+settings.i18n.remove+'">'+settings.i18n.remove+'</a></li>');
				}
			}
			else {
				controlsContainer.prepend('<ul class="'+settings.classes.controls+'"><li class="'+settings.classes.remove+'"><a href="" title="'+settings.i18n.remove+'">'+settings.i18n.remove+'</a></li></ul>');
			}
			// reassing controls var in case it didnt exist
			var controls = controlsContainer.find('ul.'+settings.classes.controls);

			// delete box when clicking remove button
			controls.find('li.'+settings.classes.remove+' > a').click(function() {
				if (confirm(settings.i18n.removeConfirm)) {
					t.remove();
					// NOTE: this will be executed when the box is removed, so no arg for it
					if ($.isFunction(onRemoveCallback)) { onRemoveCallback(t,parentT); }
				}
				return false;
			});

			// NOTE: this will be executed when making the box removable, NOT when removing it
			if ($.isFunction(callback)) { callback(t); }

		});

	};

	// make renamable
	$.fn.makeRenamable = function(options, callback) {

		// settings
		$.extend(true, settings, options);

		return this.each(function() {

			var box = $(this);

			box.find(settings.elements.title).click(function() {

				var tit = $(this);
				var pretxt = tit.text();
				var randomNumber = Math.floor(Math.random()*9999);

				var inp = tit.parent().children('input[type="text"]');
				if (inp.length > 0) {
					tit.hide();
				}
				else {
					tit.after('<input type="text" name="title'+randomNumber+'" id="title'+randomNumber+'" value="'+pretxt+'">');
					tit.hide();
					var inp = tit.parent().children('#title'+randomNumber);
				}

				inp.show();
				inp.focus();
				inp.blur(function() {
					var newTitle = $.trim($(this).val());
					if (newTitle.length > 0) tit.text(newTitle);
					$(this).hide();
					tit.show();
					// execute callback function
					if ($.isFunction(callback)) { callback(pretxt, newTitle, box); }
				});
				inp.keydown(function(e) {
					// if ENTER was pressed, hide input and change title
					if (window.event) { var key = window.event.keyCode; } // ie
					else { var key = e.which; } // rest of non-terrible browsers
					if (key == 13) {
						$(this).blur();
						return false;
					}
				});

			});

		});

	};

	// make resizable
	$.fn.makeResizable = function(lmt, options, callback) {

		// settings
		$.extend(true, settings, options);

		var lmt = lmt || settings.resizeLimit;
		if (lmt < 1) lmt = 1;

		return this.each(function() {

			// the list
			var resizableList = $(this);
			resizableList.resizeList(lmt);
			var resizableListElementsCount = resizableList.children('li').length;

			// create/add more/less buttons to the controls' list
			var controlsContainer = resizableList.closest(settings.elements.boxes).find(settings.elements.controlsContainer);
			var controls = controlsContainer.find('ul.'+settings.classes.controls);
			var controlsLength = controls.length;
			// if showing more than one element, append active controls
			if (resizableListElementsCount > 1 && lmt > 1) {
				// if already showing the maximum number of elements permitted, push will be inactive
				if (resizableListElementsCount == lmt) {
					if (controlsLength > 0) {
						controls.append('<li class="'+settings.classes.push+' '+settings.classes.pushOff+'"><a href="" title="'+settings.i18n.push+'">'+settings.i18n.push+'</a></li><li class="'+settings.classes.pop+'"><a href="" title="'+settings.i18n.pop+'">'+settings.i18n.pop+'</a></li>');
					}
					else {
						controlsContainer.prepend('<ul class="'+settings.classes.controls+'"><li class="'+settings.classes.push+' '+settings.classes.pushOff+'"><a href="" title="'+settings.i18n.push+'">'+settings.i18n.push+'</a></li><li class="'+settings.classes.pop+'"><a href="" title="'+settings.i18n.pop+'">'+settings.i18n.pop+'</a></li></ul>');
					}
				}
				// if not showing maximum permitted, both buttons active
				else {
					if (controlsLength > 0) {
						controls.append('<li class="'+settings.classes.push+'"><a href="" title="'+settings.i18n.push+'">'+settings.i18n.push+'</a></li><li class="'+settings.classes.pop+'"><a href="" title="'+settings.i18n.pop+'">'+settings.i18n.pop+'</a></li>');
					}
					else {
						controlsContainer.prepend('<ul class="'+settings.classes.controls+'"><li class="'+settings.classes.push+'"><a href="" title="'+settings.i18n.push+'">'+settings.i18n.push+'</a></li><li class="'+settings.classes.pop+'"><a href="" title="'+settings.i18n.pop+'">'+settings.i18n.pop+'</a></li></ul>');
					}
				}
			}
			// if showing 1 element, append active push and inactive pop
			else if (resizableListElementsCount > 1 && lmt < 2) {
				if (controlsLength > 0) {
					controls.append('<li class="'+settings.classes.push+'"><a href="" title="'+settings.i18n.push+'">'+settings.i18n.push+'</a></li><li class="'+settings.classes.pop+' '+settings.classes.popOff+'"><a href="" title="'+settings.i18n.pop+'">'+settings.i18n.pop+'</a></li>');
				}
				else {
					controlsContainer.prepend('<ul class="'+settings.classes.controls+'"><li class="'+settings.classes.push+'"><a href="" title="'+settings.i18n.push+'">'+settings.i18n.push+'</a></li><li class="'+settings.classes.pop+' '+settings.classes.popOff+'"><a href="" title="'+settings.i18n.pop+'">'+settings.i18n.pop+'</a></li></ul>');
				}
			}
			// if there's only 1 element, append inactive controls
			else {
				if (controlsLength > 0) {
					controls.append('<li class="'+settings.classes.push+' '+settings.classes.pushOff+'"><a href="" title="'+settings.i18n.push+'">'+settings.i18n.push+'</a></li><li class="'+settings.classes.pop+' '+settings.classes.popOff+'"><a href="" title="'+settings.i18n.pop+'">'+settings.i18n.pop+'</a></li>');
				}
				else {
					controlsContainer.prepend('<ul class="'+settings.classes.controls+'"><li class="'+settings.classes.push+' '+settings.classes.pushOff+'"><a href="" title="'+settings.i18n.push+'">'+settings.i18n.push+'</a></li><li class="'+settings.classes.pop+' '+settings.classes.popOff+'"><a href="" title="'+settings.i18n.pop+'">'+settings.i18n.pop+'</a></li></ul>');
				}
			}
			// reassing controls var in case it didnt exist
			var controls = controlsContainer.find('ul.'+settings.classes.controls);

			// append the next element to the list
			controls.children('li.'+settings.classes.push).children('a').click(function() {
				var parnt = $(this).parent();
				var lis = resizableList.children('li');
				var last = lis.filter('li.last');
				var max = lis.length;
				var ind = lis.index(last);
				if (ind <= (max-2)) {
					last.next().addClass('last');
					last.next().slideDown('fast');
					last.removeClass('last');
					if (ind == (max-2)) {
						parnt.addClass(settings.classes.pushOff);
					}
					if (ind == 0) {
						var popLi = parnt.parent().children('li.'+settings.classes.pop);
						popLi.removeClass(settings.classes.popOff);
					}
				}
				return false;
			});

			// remove the last element from list
			controls.children('li.'+settings.classes.pop).children('a').click(function() {
				var parnt = $(this).parent();
				var lis = resizableList.children('li');
				var first = lis.filter('li:first');
				var last = lis.filter('li.last');
				var max = lis.length;
				var ind = lis.index(last);
				if (ind > 0) {
					last.removeClass('last');
					last.prev().addClass('last');
					last.slideUp('fast');
					if (ind == 1) {
						parnt.addClass(settings.classes.popOff);
					}
					if (ind == (max-1)) {
						var pushLi = parnt.parent().children('li.'+settings.classes.push);
						pushLi.removeClass(settings.classes.pushOff);
					}
				}
				return false;
			});

			if ($.isFunction(callback)) { callback(resizableList); }

		});

	};

	// make sortable
	$.fn.makeSortable = function(sortableOptions, options, callback) {

		// check if jQueryUI's sortable function exist
		if (typeof $().sortable != 'function') { alert(settings.i18n.uiNotIncluded); return false; }
		// sortable elements default settings (check documentantion @ http://jqueryui.com/demos/sortable/)
		var sortableSettings = {
			receive: function(event, ui) {
				if (ui.sender.hasClass(settings.classes.notConnected)) {
					$(ui.sender).sortable('cancel');
				}
				
			},
			cursor: 'move',
			delay: 150,
			dropOnEmpty: true, // when a column becomes empty, items can still be moved into it
			forceHelperSize: true, // helper inherits size from sender
			forcePlaceholderSize: true, // placeholder inherits size from sender
			opacity: 0.75,
			placeholder: 'placeholder',
			tolerance: 'pointer',
			revert: 250 // item gets into position with a smooth animation
		}

		// settings and sortableSettings
		$.extend(true, settings, options);
		$.extend(true, sortableSettings, sortableOptions);

		return this.each(function() {

			var t = $(this);

			// if not-connected class specified, disallow connection to other boxes (only disables "external" connections, from this box to other ones, not the other way)
			if (t.hasClass(settings.classes.notConnected)) { $.extend(true, sortableSettings, { connectWith: '' }); }
			else { $.extend(true, sortableSettings, sortableOptions); }

			t.sortable(sortableSettings); // you can add .disableSelection() to disable the selection of the boxes' content, making dragging easier
			if ($.isFunction(callback)) { callback(t); }

		});

	};

	// hide list elements exceeding specified limit, show the rest
	$.fn.resizeList = function(lmt, callback) {

		// non-hidden elements
		var lmt = lmt || settings.resizeLimit;
		if (lmt < 1) lmt = 1;

		return this.each(function() {

			var t = $(this);

			t.children('li:gt('+(lmt-1)+')').removeClass('last');
			t.children('li:gt('+(lmt-1)+')').hide();
			t.children('li:eq('+(lmt-1)+')').addClass('last');
			t.children('li:lt('+(lmt)+')').show();

			if ($.isFunction(callback)) { callback(t); }

		});

	};

	// build a 'content' tag for jquery append, prepend, etc... methods (returns 2 element array)
	function buildTag(selector, content) {

		content = content ? content : '';

		var html = new Array();

		// try to guess box's elements
		classesParts = selector.split('.');
		idParts = selector.split('#');
		if (classesParts.length >= 1) {

			var tag = classesParts[0];
			// get html class(es) attribute string
			for (i = 1; i < classesParts.length; i++) { classes = (i == 1) ? classesParts[i] : classes + ' ' + classesParts[i]; }

			if (!classes) {

				html[0] = tag ? '<'+tag+'>'+content : '<div>'+content;

			}
			else {

				html[0] = tag ? '<'+tag+(classes ? ' class="'+classes+'"' : '')+'>'+content : '<div'+(classes ? ' class="'+classes+'"' : '')+'>'+content;
				html[1] = tag ? '</'+tag+'>' : '</div>';

			}

		}
		else if (idParts.length >= 1) {

			var tag = idParts[0];
			// allow only 1 id
			var preId = idParts[1].split(' ');
			var id = preId[0];

			html[0] = tag ? '<'+tag+(id ? ' id="'+id+'"' : '')+'>'+content : '<div'+(id ? ' id="'+id+'"' : '')+'>'+content;
			html[1] = tag ? '</'+tag+'>' : '</div>';

		}
		else { return false; }

		return html;

	}

	// build a 'content' html string for jquery append, prepend, etc... methods (returns a string)
	function buildHtml (structure) {

		var ret = '';
		var end = '';

		for (var i in structure) {

			if ((typeof structure[i]) == 'string') {

				// if parameter is element selector, build tag
				if (i == 'element') {

					// if element got childs, don't close it till the end
					if (typeof(structure['childs']) == 'object') {

						// build with html content if specified
						pre = structure['html'] ? buildTag(structure[i], structure['html']) : buildTag(structure[i]);
						ret = pre[0] + ret;
						end = pre[1] + end;

					}
					else {

						// build with html content if specified
						pre = structure['html'] ? buildTag(structure[i], structure['html']) : buildTag(structure[i]);
						ret = (pre[0] + ret + pre[1]);

					}

				}

			}
			else {

				// continue checking only the box (initial) or childs maps
				ret = ret + buildHtml(structure[i]);
				ret = ret + end;

			}

		}

		return ret;

	}

})(jQuery);