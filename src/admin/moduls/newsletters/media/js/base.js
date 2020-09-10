$(document).ready(function(){

	// identifiquem el primer i l'últim element dels llistats
	$('ul, ol').each(function(){
		$(this).children('li:first').addClass('first');
		$(this).children('li:last').addClass('last');
	});

	// menú de carpetes desplegable
	$('div.list ul ul').hide();
	$('div.list ul li a').click(function(){
		$(this).parent().children('ul').slideToggle('fast');
		$(this).toggleClass('open');
		return false;
	});

	// arrodonim punts menú caixa controls
// 	$('div.tabs ul li, div.greentabs ul li').nifty('transparent top');

	// afegim la classe 'odd' a les files imparelles de les taules
	$('table tr:odd').addClass('odd');

});


function obrir(nom,amplada,baixada){
	  pitekandemor="left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width="+amplada+",height="+baixada+",directory=no,resize=no,scrollbars=yes";
	  result = window.open(nom,"",pitekandemor);
	}

	function missatge(nom){
	  pitekandemor="left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width=200,height=200,directory=no,resize=no,scrollbars=no";
	  result = window.open(nom,"missatge",pitekandemor);
	}

	function carregat(){
	  document.getElementById('carregant').style.display='none';
	  document.getElementById('contingut').style.display='inline';
	}