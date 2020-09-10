<?php

	/*
	Estils aplicables a la pàgina:
		.cerca-capcelera (p)
		.cerca_noresult (p)
		.cerca_suggeriment (ul)
		.cerca-categoria-element (h4)
		.cerca-element (div)
		.cerca-titol-element (h3)
		.cerca-ressaltat (span)
		.cerca-peu (div)
		.cerca-anterior (span)
		.cerca-seguent (span)
	*/

	// mida màxima del text llarg a mostrar
	$TEXTL_MAX_LEN = 200;
	// número màxim d'elements per pàgina
	$MAX_ELEM_PAGE = 12;

	require_once(dirname(__FILE__)."/config.php");
	require_once ("database/database.inc");
	require_once ("funcions_base.inc");

	// idioma de la plana
	if (!isset($idioma)) {
		$idioma = current($CONFIG_idiomes);
		$trosos = explode('_', $idioma[0]);
		$idioma = $trosos[2];
	}

	// obtenir el text a cercar
	if (isset($_POST['text-cerca'])) {
		$cerca = $_POST['text-cerca'];
	}
	else if (isset($_GET['text-cerca'])) {
		$cerca = $_GET['text-cerca'];
	}
	else {
		$cerca = '';
	}

	// obtenir pàgina
	if (isset($_POST['pag'])) {
		$pag = $_POST['pag'];
	}
	else if (isset($_GET['pag'])) {
		$pag = $_GET['pag'];
	}
	else {
		$pag = 1;
	}

	$numdecaracters = strlen($cerca);

	$cerca = str_replace(' + ','',$cerca);
	$cerca = str_replace(' - ','',$cerca);

	function cmp($a, $b)
	{

		if ($a[0] == $b[0]) { return 0; }
		return ($a[0] < $b[0]) ? -1 : 1;

	}

	// nombre de vegades que es troba una paraula
	function str_incounter($match, $string)
	{

		$count_match = 0;
		$resultats = array();

		$string = strtolower($string);
		$match = strtolower($match);
		/*aparicions del text complert*/
		if (preg_match('/^"(.*)"$/', $match, $trosos)) {
			$count_match += substr_count ($string, $trosos[1]);
		}
		else {
			/*aparicions dels trossos de text*/
			$trosos = explode(' ', $match);
			foreach ($trosos as $value) {
				if (preg_match('/^\+(.*)$/', $value, $trosos2)) {
					$count_match += substr_count ($string, $trosos2[1]);
				}
				else if (preg_match('/^-(.*)$/', $value, $trosos2)) {
					$count_match -= substr_count ($string, $trosos2[1]);
				}
				else {
					$count_match += substr_count ($string, $value);
				}
			}
		}
		return $count_match;

	}

	// marcar paraules rellevants
	function str_marcar($match,$string)
	{

		if (preg_match('/^"(.*)"$/', $match, $trosos)) {
			$string = eregi_replace ($trosos[1], '<span class="cerca-ressaltat">'.$trosos[1].'</span>', $string);
		}
		else {
			$orig = array();
			$trosos = explode(' ', $match);
			foreach ($trosos as $value) {
				if (preg_match('/^\+(.*)$/', $value, $trosos2)) {
					$orig[] = $trosos2[1];
				}
				else if (preg_match('/^-(.*)$/', $value, $trosos2)) {
				}
				else {
					$orig[] = $value;
				}
			}
			if (count($orig) > 0) {
				$string = eregi_replace ('('.implode('|',$orig).')', '<span class="cerca-ressaltat">\1</span>', $string);
			}
		}
		return $string;

	}

	// escriure capçalera
	function escriu_capcelera($num_resultats, $cerca, $inici = 0, $fi = 0)
	{

		global $text_resultats, $text_total, $text_utilitzant;

		if (!isset($text_resultats) || $text_resultats == '') {
			$text_resultats = 'Resultados';
		}
		if (!isset($text_total) || $text_total == '') {
			$text_total = 'Encontrados un total de';
		}
		if (!isset($text_utilitzant) || $text_utilitzant == '') {
			$text_utilitzant = 'documentos que utilizan la palabra';
		}

		$mostrat = '';
		if ($num_resultats > 0) {
			$mostrat = $text_resultats.' <strong>'.($inici+1).'-'.$fi.'</strong>. ';
		}

		return '<p class="showing">'.$mostrat.$text_total.' <strong>'.$num_resultats.'</strong> '.$text_utilitzant.' <strong>"<span class="cerca-ressaltat">'.$cerca.'</span>"</strong></p>';
	}

	// text quan no hi ha resultats
	function no_result($cerca) {

		if (function_exists('text_no_result')) {
			ob_start();
			text_no_result();
			$text_no_result = ob_get_contents();
			ob_end_clean();
			if ($text_no_result != '') {
				return $text_no_result;
			}
		}
		return '
			<p class="cerca_noresult"><strong>No se ha encontrado ningún documento que coincida con la búsqueda introducida.</strong></p>
			<p>Por favor comprueba que:</p>
			<ul class="cerca_suggeriment">
				<li>la búsqueda continene al menos 3 carácteres.</li>
				<li>has escrito correctamente los términos que querías buscar.</li>
				<li>pruebas otra búsqueda utilitzando términos similares.</li>
			</ul>
	';

	}

	// mostra element individual de la cerca
	function element_cerca($textcurt, $textllarg, $adresa, $idioma_entrada)
	{

		global $idioma, $CONFIG_idiomes;
		$text_idioma = '';
		if ($idioma_entrada != $idioma) {
			foreach($CONFIG_idiomes[$idioma] as $value) {
				$trosos = explode('_', $value);
				if ($trosos[2] == $idioma_entrada) {
					$text_idioma = ' - <small class="cerca_idioma">'.$trosos[1].'</small>';
				}
			}
		}
		return '
			<div class="cerca-element">
				<!-- <h4 class="cerca-categoria-element"></h4> -->
				<h3 class="cerca-titol-element"><a href="'.$adresa.'" lang="'.$idioma_entrada.'">'.$textcurt.'</a>'.$text_idioma.'</h3>
				'.$textllarg.'
			</div>
		';

	}

	// filtra cerques no factibles
	if ($cerca == '' || $numdecaracters < 3) {
		echo escriu_capcelera(0, $cerca);
		echo no_result($cerca);
		return;
	}

	// codi útil vvv
	db_connect($db_url_web);
	$dirs = array();

	// cercar a planes estàtiques
	$result = db_query("select * from ESTATICA WHERE (STATUS=1  AND CERCADOR='0') AND MATCH (METAKEYS,TEXTC1,TEXTC2,TEXTC3,TEXTC4,TEXTC5,TEXTL1,TEXTL2,TEXTL3) AGAINST ('".addslashes($cerca)."' IN BOOLEAN MODE);");
	$resultats = db_num_rows($result);
	while ($row = db_fetch_array($result)) {

		$total = 0;

		// cercar camps de text llarg
		for ($i=1; $i<4; $i++) {
			$count_some = str_incounter($cerca, strip_tags($row['TEXTL'.$i]));
			$total = $count_some + $total;
		}
		// cercar camps de text curt
		for ($i=1; $i<6; $i++) {
			$count_some = str_incounter($cerca, strip_tags($row['TEXTC'.$i]));
			$total = $count_some + $total;
		}

		// obtenir enllaç a la plana
		$adresa = $CONFIG_NOMCARPETA."/".folderPath($row['PARE'])."/".$row['NOMPAG'];

		if ($row['METATITOL']=='' || $row['METATITOL']=='Houdini' || $row['METATITOL']==$CONFIG_SITENAME) {
			$row['METATITOL']=$row['DESCRIPCIO'];
		}
		if ($row['METATITOL']=='') {
			$row['METATITOL']=$row['NOMPAG'];
		}
		if ($row['TEXTC1']=='') {
			$row['TEXTC1']=$row['METATITOL'];
		}

		$textllarg = strip_tags($row['TEXTL1']);
		$textllarg = str_replace('&nbsp;' ,' ', $textllarg);
		$textllarg = ereg_replace("[\n\t\r ]+" ,' ', $textllarg);

		// escapar text llarg
		if (strlen($textllarg) > $TEXTL_MAX_LEN) {
			$textllarg = substr ($textllarg, 0, $TEXTL_MAX_LEN);
			$textllarg .= '...';
		}

		$row['alternatiu'] = $row['TEXTC1'];
		// marcar rellevants
		$row['TEXTC1'] = str_marcar($cerca,$row['TEXTC1']);
		$textllarg = str_marcar($cerca,$textllarg);

		$file = element_cerca($row['TEXTC1'], $textllarg, $adresa, $row['IDIOMA']);
		$dirs[] = array( $total,$file);

	}

	// cerca a les planes dinàmiques (editores)
	$result = db_query('SELECT ID, NOMCARPETA, PARE, TITOL, DESCRIPCIO, IDIOMA FROM CARPETES WHERE CATEGORY1=1');
	$editores = array();
	while ($row = db_fetch_array($result)) {
		$nomdb = staticFolderTableName($row['ID']);
		if ($row['DESCRIPCIO'] == '') {
			$row['DESCRIPCIO'] = $row['TITOL'];
		}
		$editores[] = array('titol' => $row['DESCRIPCIO'], 'db' => $nomdb, 'nom' => $row['NOMCARPETA'], 'ruta' => folderPath($row['ID']), 'idioma' => $row['IDIOMA']);
	}

	// passar per cada editora
	foreach($editores as $value) {

		$result = db_query("select TITOL, RESUM, DESCRIPCIO, ID from ".$value['db']." WHERE (STATUS=1) AND MATCH (TITOL,RESUM,DESCRIPCIO) AGAINST ('".addslashes($cerca)."' IN BOOLEAN MODE);");
		$resultats += db_num_rows($result);

		/*tractar cada coincidencia*/
		while($row = db_fetch_array($result)) {

			// cercar coincidències
			$total = str_incounter($cerca,strip_tags($row['TITOL']));
			$total += str_incounter($cerca,strip_tags($row['RESUM']));
			$total += str_incounter($cerca,strip_tags($row['DESCRIPCIO']));

			if (strlen($row['RESUM']) > $TEXTL_MAX_LEN) {
				$row['RESUM'] = substr ($row['RESUM'], 0, $TEXTL_MAX_LEN);
				$row['RESUM'] .= '...';
			}

			/*marcar coincidencies*/
			$row['TITOL'] = str_marcar($cerca,$row['TITOL']);
			$row['RESUM'] = str_marcar($cerca,$row['RESUM']);

			$file = element_cerca($row['TITOL'], $row['RESUM'], $CONFIG_NOMCARPETA.'/'.$value['ruta'].'/view.php?ID='.$row['ID'], $value['idioma']);
			$dirs[] = array($total,$file);

		}

	}

	if (count($dirs) == 0) {
		echo escriu_capcelera(0, $cerca);
		echo no_result($cerca);
		return;
	}

	// ordenar resultats
	usort($dirs, "cmp");

	$num_resultats = count($dirs);
	$numpages = (int)ceil($num_resultats / $MAX_ELEM_PAGE);
	$inici = ($pag - 1) * $MAX_ELEM_PAGE;
	$fi = $inici + $MAX_ELEM_PAGE;
	if ($fi > $num_resultats) {
		$fi = $inici + ($num_resultats % $MAX_ELEM_PAGE);
	}

	// capçalera
	$resultat = escriu_capcelera($num_resultats, $cerca, $inici, $fi);

	// cos
	for($i = $inici; $i < $fi; $i++) {
		$resultat .= $dirs[$i][1];
	}

	if (!isset($text_anterior) || $text_anterior == '') {
		$text_anterior = 'Anterior';
	}
	$anterior = '&nbsp;';
	if ($pag > 1) {
		$anterior = '<a href="'.$_SERVER['PHP_SELF'].'?text-cerca='.$cerca.'&amp;pag='.($pag-1).'">'.$text_anterior.'</a>';
	}

	if (!isset($text_seguent) || $text_seguent == '') {
		$text_seguent = 'Siguiente';
	}
	$seguent = '&nbsp;';
	if ($pag < $numpages) {
		$seguent = '<a href="'.$_SERVER['PHP_SELF'].'?text-cerca='.$cerca.'&amp;pag='.($pag+1).'">'.$text_seguent.'</a>';
	}
	$links = array();
	for($i = 1; $i <= $numpages; $i++) {
		if ($i == $pag) {
			$links[] = '<strong>'.$i.'</strong>';
		}
		else {
			$links[] = '<li><a href="'.$_SERVER['PHP_SELF'].'?text-cerca='.$cerca.'&amp;pag='.$i.'">'.$i.'</a></li>';
		}
	}
	$llista_pag = implode('', $links);

	// peu
	$resultat .= '
			<div class="cerca-peu">
				<span class="cerca-anterior">'.$anterior.'</span>
				<span class="cerca-seguent">'.$seguent.'</span>
				<ul>'.$llista_pag.'</ul>
			</div>
	';

	echo $resultat;

?>