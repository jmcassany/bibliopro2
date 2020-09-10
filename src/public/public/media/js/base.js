$(document).ready(function() {

	$('#formulari').validate({});
	
	// enllaços externs en finestra nova
	$('a[rel=external]').attr('target', '_blank');
	$('a[rel=external]').addClass('external');

	// evitem spam als correus
	$("a[href*='(ELIMINAR)']").each(function(i){
		omg = $(this).attr('href');
		omg2 = $(this).text();
		$(this).attr('href', omg.split('(ELIMINAR)').join(''));
		$(this).text(omg2.split('(ELIMINAR)').join(''));
	});

	// identifiquem el primer i l'últim element de les llistes
	$('ul, ol').each(function(){
		$(this).children('li:first').addClass('first');
		$(this).children('li:last').addClass('last');
	});

	// tractament de llistes
	$('ul.banners_triple, ul.double, ul.triple').addClass('clearfix');
	$('ul.double').each(function(){
		$(this).children('li:nth-child(2n)').addClass('nomargin');
		$(this).children('li:nth-child(2n+1)').addClass('clear');
		$(this).children('li:nth-child(2n)').after('<div class="clearfix"></div>');
	});
	$('ul.banners_triple, ul.triple').each(function(){
		$(this).children('li:nth-child(3n)').addClass('nomargin');
		$(this).children('li:nth-child(3n+1)').addClass('clear');
		$(this).children('li:nth-child(3n)').after('<div class="clearfix"></div>');
	});

	// arrodoniments
// 	$('head').append('<link rel="stylesheet" href="'+urlBase+'/media/css/curves.css" type="text/css" media="all" />');

});