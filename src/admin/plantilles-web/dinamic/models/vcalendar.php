<?php
include_once ("config.inc"); // Cards Configuration
require_once ('iCalcreator/iCalcreator.class.php');

/*paràmetre identificador*/
if (isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	header("HTTP/1.0 404 Not Found");
	exit;
}

/*iniciar dbcard*/
$dbCards = new dbCards($CARDS_TABLE);

if (!$dbCards->Ok) {
	header("HTTP/1.0 404 Not Found");
	exit;
}

/*llegeix l'entrada*/
$card = $dbCards->readCard($id);

/*comprova si l'entrada és vàlida*/
if ($card['VISIBILITY'] == '2' &&
	(strtotime($card['START_TIME']) > time() || strtotime($card['END_TIME']) < time())) {

	header("HTTP/1.0 404 Not Found");
	exit;
}

$calendar = new vcalendar();

$v = new vevent();

$start = strtotime($card['CALENDAR_START_TIME']);
$v->setDtstart(date('Y',$start), date('m',$start), date('d',$start), date('H',$start), date('i',$start), date('s',$start));
$end = strtotime($card['CALENDAR_END_TIME']);
if ($end != false) {
	$v->setDtend(date('Y',$end), date('m',$end), date('d',$end), date('H',$end), date('i',$end), date('s',$end));
}

$v->setSummary($card['TITOL']);

if ($card['RESUM'] != '') {
	$v->setDescription($card['RESUM']);
}

/*info categories*/
if ($card['CATEGORY2'] != 0) {
	$infocat = getInfoCategoria($card['CATEGORY2']);
	$v->setCategories($infocat['URL_NOM']);
}

$calendar->addComponent($v);

$calendar->setFormat('ics');
$output = $calendar->createCalendar();

if ($output == '') {
	die();
}

$filename = 'calendari.ics';
Header('Content-Type: text/calendar; charset=utf-8');
Header('Content-Disposition: attachment; filename=' . basename($filename));
echo $output;
die();
