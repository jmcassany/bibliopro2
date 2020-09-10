$(document).ready(function() {

	/* amaguem els controls de configuració de les caixes de portada */
		$('div.conf').hide();

	/* permetem moure les caixes de portada */
		$("ul.boxes").sortable({
			connectWith: ["ul.boxes"],
			placeholder: "selected",
			delay: 10,
			distance: 0,
			scroll: true,
			revert: true
		});
		$("li.box h2").css('cursor', 'pointer');

	/* controls caixes portada */
		$("ul.boxes li.clip a").click(function() {

			$(this).parent().parent().parent().children().not('h2, ul.box-controls, div.conf').slideToggle('slow');
			// canviem el botó amunt/avall
			if($(this).is(':active')) $(this).css('background', 'background: url("../comu/icon_clip.jpg") no-repeat;');
			else $(this).css('background', 'background: url("../comu/icon_clip2.jpg") no-repeat;');
			// no seguir el link
			return false;

		});
		$("ul.boxes li.close a").click(function() {

			$(this).parent().parent().parent().slideOut('fast', $(this).parent().parent().parent().remove());
			// no seguir el link
			return false;

		});
		$("ul.boxes li.edit a").click(function() {

			$(this).parent().parent().parent().children('div.conf').slideToggle('slow');
			// no seguir el link
			return false;

		});

});