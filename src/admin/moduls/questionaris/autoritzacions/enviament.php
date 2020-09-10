<?php
require_once (dirname(dirname(dirname(dirname(__FILE__)))) . '/config_admin.inc');
include_once 'mail.php';
include_once 'ajax.php';

accessGroupPermCheck('questionaris');

if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['textCorreu']) && isset($_POST['autors']) && isset($_POST['instrument'])){

	$dadesInstrument = getInfoQuest($_POST['instrument']);
	$autoritzacio = array('idInstrument' => $dadesInstrument['ID_CUEST'], 'idAutor' => $_POST['autors'], 'data' => time());
	
	//substituim les variables del text pels varlos bons
	$textCorreu = str_replace('#instrumento#', $dadesInstrument['NOM_ORIGINAL'], $_POST['textCorreu']);
	$textCorreu = str_replace('#doctor#', $_POST['nom'], $textCorreu);
	if(getenv('testserver')){
		$textCorreu = str_replace('#linkAutoritzacion#', '<a href="http://bibliopro.imim.antaviana.net/cuestionarios/autorizar_quest.html?auth=' . base64_encode(json_encode($autoritzacio)) . '">http://bibliopro.imim.antaviana.net/cuestionarios/autorizar_quest.html?auth=' . base64_encode(json_encode($autoritzacio)) . '</a>', $textCorreu);
	} else {
		$textCorreu = str_replace('#linkAutoritzacion#', '<a href="http://www.bibliopro.org/cuestionarios/autorizar_quest.html?auth=' . base64_encode(json_encode($autoritzacio)) . '">http://www.bibliopro.org/cuestionarios/autorizar_quest.html?auth=' . base64_encode(json_encode($autoritzacio)) . '</a>', $textCorreu);
	}


	$motiu = 'Autorizacion para BiblioPRO del instrumento ' . $dadesInstrument['NOM_ORIGINAL'];

	$adjunts['autoritzacio']['path'] = $CONFIG_PATHBASE . '/media/comu/questionarios/autorizacion.pdf';
	$adjunts['autoritzacio']['name'] = 'autorizacion.pdf';
	$sended = sendMail('bibliopro@imim.es', $motiu, $textCorreu, '', $adjunts, true);
	//$sended = sendMail('josep.roig@antaviana.cat', $motiu, $textCorreu, 'autorizaciones@bibliopro.org', $adjunts, true);
}
header('Location:index.php');
exit;