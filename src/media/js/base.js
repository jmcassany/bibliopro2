$(document).ready(function() {

	// ocultem i permetem mostrar contenidor identificació
	var loginContainer = $('#loginContainer');
	loginContainer.hide();
	$('a.toggleLoginContainer').click(function() { loginContainer.slideToggle(); });

	// enllaços externs en finestra nova
	$('a[rel=external], a[rel=document], a[rel=window]').attr('target', '_blank');
	$('a[rel=external]').addClass('external');

	// evitem spam als correus
	$("a[href*='(ELIMINAR)']").each(function(i){
		var t = $(this);
		omg = t.attr('href');
		omg2 = t.text();
		t.attr('href', omg.split('(ELIMINAR)').join(''));
		t.text(omg2.split('(ELIMINAR)').join(''));
	});
	$('td.emails').each(function(i){
		omg2 = $(this).text();
		$(this).text(omg2.split('(ELIMINAR)').join(''));
	});

	// identifiquem el primer i l'últim element de les llistes
	$('ul, ol').each(function(){
		$(this).children('li:first').addClass('first');
		$(this).children('li:last').addClass('last');
	});

	// tractament de llistes
	$('ul.double, ul.duesCol, #frontpageBoxes').addClass('clearfix');
	$('ul.double, ul.duesCol').each(function(){
		$(this).children('li:nth-child(2n)').addClass('nomargin');
		$(this).children('li:nth-child(2n+1)').addClass('clear');
	});
	$('#frontpageBoxes').each(function(){
		$(this).children('li:nth-child(3n)').addClass('nomargin');
		$(this).children('li:nth-child(3n+1)').addClass('clear');
	});

	// afegim span per estils p.destacat, ul.background i th.header
	$('ul.nav > li, p.destacat, ul.llista_fons li').wrapInner('<span />');

	// mostrar/ocultar preguntes freqüents
	var hiddenAnswers = $('ul.faqs > li:not(".visible")', '#content');
	var visibleAnswers = $('ul.faqs > li.visible', '#content');
	hiddenAnswers.children('div.answer').children().hide();
	hiddenAnswers.each(function() {
		var a = $(this);
		var question = a.children('h4');
		question.prepend('<span class="show"><a href="">Mostrar respuesta</a></span>');
		question.children('span.show').children('a').click(function() {
			a.children('div.answer').children().slideToggle('fast');
			tC = $(this).parent();
			tC.toggleClass('show');
			tC.toggleClass('hide');
			a.toggleClass('visible');
			if (tC.hasClass('show')) { $(this).text('Mostrar respuesta'); }
			else { $(this).text('Ocultar respuesta'); }
			return false;
		});
	});
	visibleAnswers.each(function() {
		var a = $(this);
		var question = a.children('h4');
		question.prepend('<span class="hide"><a href="">Ocultar respuesta</a></span>');
		question.children('span.hide').children('a').click(function() {
			a.children('div.answer').children().slideToggle('fast');
			tC = $(this).parent();
			tC.toggleClass('show');
			tC.toggleClass('hide');
			a.toggleClass('visible');
			if (tC.hasClass('show')) { $(this).text('Mostrar respuesta'); }
			else { $(this).text('Ocultar respuesta'); }
			return false;
		});
	});

	// per estilitzar menús
	$('ul.frontpageInfo > li, ul.information > li').wrapInner('<span></span>');

	// ocultar/mostrar canaries, ceuta, melilla (form registre usuaris)
	var countrySelect = $('#PAIS');
	var countryAltLabel = $('label[for="OTRO_PAIS"]');
	if (countrySelect.val() != '73') { countryAltLabel.hide(); }
	countrySelect.change(function() {
		if ($(this).val() == '73') {
			countryAltLabel.show('fast');
		}
		else {
			countryAltLabel.hide('fast');
		}
	});

	// ocultar/mostrar camp canaries, ceuta, melilla (forms pagament)
	var fcountrySelect = $('#FACTURACION_PAIS');
	var fcountryAltLabel = $('label[for="FACTURACION_OTRO_PAIS"]');
	if (fcountrySelect.val() != '73') { fcountryAltLabel.hide(); }
	fcountrySelect.change(function() {
		if ($(this).val() == '73') {
			fcountryAltLabel.show('fast');
		}
		else {
			fcountryAltLabel.hide('fast');
		}
	});

	// ocultar/mostrar camp usos estudis (form subllicència)
	var usageSelect = $('#USO');
	var usageAltLabel = $('label[for="USO_OTROS"]');
	if (usageSelect.val() != 'Otros') { usageAltLabel.hide(); }
	usageSelect.change(function() {
		if ($(this).val() == 'Otros') {
			usageAltLabel.show('fast');
		}
		else {
			usageAltLabel.hide('fast');
		}
	});

	// ocultar/mostrar camp diseny estudis (form subllicència)
	var designSelect = $('#DISENO_ESTUDIO');
	var designAltLabel = $('label[for="DISENO_ESTUDIO_OTROS"]');
	if (designSelect.val() != 'Otros') { designAltLabel.hide(); }
	designSelect.change(function() {
		if ($(this).val() == 'Otros') {
			designAltLabel.show('fast');
		}
		else {
			designAltLabel.hide('fast');
		}
	});

	// igualem alçada caixes portada
	var maxHeight = 0;
	$('#frontpageBoxes > li.box').each(function() {
		h = $(this).innerHeight();
		if (h > maxHeight) { maxHeight = h; }
	});
	$('#frontpageBoxes > li.box').each(function() {
		$(this).height(maxHeight);
	});

});