<?php
require_once('/var/www/html/config.php');
$id = '7';
$idioma = 'es';
$pare = '3';
$filAriadnaArray = array(0 => array('link' => '//index.html' , 'title' => 'Portada' , 'nom' => 'Portada') , 1 => array('link' => '/servicios/index.html' , 'title' => 'Servicios' , 'nom' => 'Servicios') , 2 => array('link' => '' , 'title' => 'Noticias' , 'nom' => 'Noticias'));
$folderArray = array(3 => 'servicios');
$folderIds = array(0 => 3);
$folderUrl = '/servicios';
$pageUrl = '/servicios';

$nomTaula = 'editora_7'; $pageUrl = $_SERVER["REQUEST_URI"]
?><?php

	$LANG = "ESP";
	$CONFIG_PATHBASE = '/var/www/html';
	include_once ($CONFIG_PATHBASE . "/config.php"); // Global Configuration

	include_once ("aw/awtemplate.php");
	include_once ("aw/awtools.php");
	include_once ("aw/awitems.php");
	include_once ("aw/dbcards.php");
	include_once ("funcions_base.inc");
	include_once ("funcions_cat.inc");
// 	include_once ($CONFIG_PATHBASE.'/media/php/sociable.php');
	db_connect($db_url_web);

	$urlFriendly = true;

	// =========================
	// CARDS Basic Configuration
	// =========================
	// list definitions

	$CARDS_LISTSORTBY = 'ID desc, TITOL asc, START_TIME desc';
	$CARDS_LISTFILTER = "(STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME < NOW() and NOW() < END_TIME))";
	$CARDS_LISTLENGTH = 8;
	$CARDS_LISTSKIP = 8;
	$CARDS_LISTPAGENEXT = 'Siguiente';
	$CARDS_LISTPAGEPREV = 'Anterior';

	// ========================
	// CARDS ITEMS Definition
	// ========================
	// Field Values

	$ITEMS['CARDS_ECLASS']['ESP'] = array(
		 '1_Actualidad',
		 '2_Agenda',
		 '3_Protagonistas',
		 '4_Eventos'
	);
	$ITEMS['CARDS_SKIN']['ESP'] = array(
		 '0_?'
	);
	$ITEMS['CARDS_STATUS']['ESP'] = array(
		 '0_Inactiu',
		 '1_Actiu',
		 '2_En espera'
	);
	$ITEMS['CARDS_VISIBILITY']['ESP'] = array(
		 '0_Mai',
		 '1_Sempre',
		 '2_Autom&agrave;tica'
	);
	$ITEMS['CARDS_CATEGORY1']['ESP'] = array(
		 '0_Si',
		 '1_No'
	);
	$ITEMS['CARDS_CATEGORY2']['ESP'] = array(
		 '0_'
	);

	// ============================
	// CARDS DEFAULTS Definitions
	// ============================
	$DEFAULT_LANG = 'ESP'; // Espanyol
	$DEFAULT_ECLASS = '1'; // Actualidad
	$DEFAULT_SKIN = '0';
	$DEFAULT_CATEGORY1 = '0';
	$DEFAULT_CATEGORY2 = '1';
	$DEFAULT_STATUS = '1';
	$DEFAULT_VISIBILITY = '1';

	// ============================
	// CARDS DATABASE Configuration
	// ============================
	$CARDS_TABLE = 'editora_7';
	$ID_CARPETA = '7';
	$arraySituacio = array(0 => array('link' => '//index.html' , 'title' => 'Portada' , 'nom' => 'Portada') , 1 => array('link' => '/servicios/index.html' , 'title' => 'Servicios' , 'nom' => 'Servicios') , 2 => array('link' => '' , 'title' => 'Noticias' , 'nom' => 'Noticias'));

	//camps configurables
	$ORDENAPER = '0';

	$pathEditora = $CONFIG_NOMCARPETA.'/'.folderPath($ID_CARPETA).'/';
	$pathEditoraAbs = $CONFIG_URLBASE.'/'.folderPath($ID_CARPETA).'/';

	// funcions paginació
	function getPageLink($page) {

		global $CATEGORY1, $CATEGORY2, $SKIN, $PAGE, $keywords;
		// tenim en compte la cerca
		if (isset($keywords) and !empty($keywords)) {
			return 'index.php?CATEGORY2=' . $CATEGORY2 . '&amp;PAGE=' . $page . '&amp;keywords=' . urlencode($keywords);
		}
		else {
			return 'index.php?CATEGORY2=' . $CATEGORY2 . '&amp;PAGE=' . $page;
		}

	}

	function pager ($pages) {

		global $PAGE, $CARDS_LISTLENGTH, $CARDS_LISTSKIP, $CARDS_LISTPAGENEXT, $CARDS_LISTPAGEPREV;

		// Acotem $PAGE
		$pagemin = 1;
		$pagemax = $pages;

		if ($PAGE < $pagemin) { $PAGE = $pagemin; }
		if ($PAGE > $pagemax) { $PAGE = $pagemax; }

		// Next page link
		$pagenext = $PAGE + 1;

		if ($pagenext > $pagemax) {
			$pagenext = '';
		}
		else {
			$pagenext = '<span class="next"><a href="' . getPageLink($pagenext) . '">' . $CARDS_LISTPAGENEXT . '</a></span>';
		}

		// Previous page link
		$pageprev = $PAGE-1;

		if ($pageprev < $pagemin) {
			$pageprev = '';
		}
		else {
			$pageprev = '<span class="previous"><a href="' . getPageLink($pageprev) . '">' . $CARDS_LISTPAGEPREV . '</a></span>';
		}

		// List Page links
		$dec = floor(($PAGE - 1) / $CARDS_LISTSKIP);
		$decmax = floor(($pagemax-1) / $CARDS_LISTSKIP);
		$min = 1 + ($dec * $CARDS_LISTSKIP);
		$max = $min + $CARDS_LISTSKIP-1;

		if ($max > $pagemax) {
			$max = $pagemax;
		}
		$skipright = $PAGE + $CARDS_LISTSKIP;

		if ($skipright > $pagemax) {
			$skipright = $pagemax;
		}
		$skipleft = $PAGE-$CARDS_LISTSKIP;

		if ($skipleft < 1) {
			$skipleft = 1;
		}
		$pagelist = $pagenext . $pageprev . '<ul>';

		if ($dec > 0) {
			$pagelist .= '<li class="transparent"><a href="' . getPageLink($skipleft) . '">...</a></li>';
		}
		for ($i = $min;$i <= $max;$i++) {

			if ($i == $PAGE) {
				$pagelist .= '<li class="current"><a href="' . getPageLink($i) . '"><strong>' . $i . '</strong></a></li>';
			}
			else {
				$pagelist .= '<li><a href="' . getPageLink($i) . '">' . $i . '</a></li>';
			}

		}
		if ($dec < $decmax) {
			$pagelist .= '<li class="transparent"><a href="' . getPageLink($skipright) . '">...</a></li>';
		}
		$pagelist .= '</ul>';

		return $pagelist;

	}

?>