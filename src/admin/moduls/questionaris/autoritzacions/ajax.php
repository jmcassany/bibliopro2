<?php
require (dirname(dirname(dirname(dirname(__FILE__)))) . '/config_admin.inc');
include_once 'autoritzacions.php';

if(isset($_POST['function'])){
	$funcio = $_POST['function'];
	echo $funcio($_POST['params']);
	exit;
}



function getOptionsAutors($idQuestionari){
	$autors = '<option value="">-</option>';
	$result = db_query('SELECT * FROM ' . TAULA_CUESTIONARIS . ' WHERE ID_CUEST = ' . $idQuestionari);

	if($result){
		$dadesQuestionari = db_fetch_array($result);
		if(isset($dadesQuestionari['IDAUTORES_ORIGINAL']) && unserialize($dadesQuestionari['IDAUTORES_ORIGINAL'])){
			$arrayAutors = unserialize($dadesQuestionari['IDAUTORES_ORIGINAL']);
			$arrayAutors_trad = unserialize($dadesQuestionari['IDAUTORES_CAST']);

			if(is_array($arrayAutors) || is_array($arrayAutors_trad)){
				$arrayAutors = array_merge((array)$arrayAutors, (array)$arrayAutors_trad);
				foreach ($arrayAutors as $idAutor) {
					$resultAutor = db_query('SELECT * FROM ' . TAULA_AUTORS . ' WHERE ID = ' . $idAutor);
					if($resultAutor){
						$dadesAutor = db_fetch_array($resultAutor);
						if($dadesAutor['NOM'] == ''){
							$autors .= '<option value="' . $idAutor . '">ID: ' . $idAutor . ' Sense dades</option>';	
						} else {
							$autors .= '<option value="' . $idAutor . '">' . $dadesAutor['NOM'] . '</option>';
						}
						
					}
				}
			}
		}
	}
	return $autors;
}

function getInfoQuest($id){
	$result = db_query('SELECT * FROM ' . TAULA_CUESTIONARIS . ' WHERE ID_CUEST = ' . $id);
	if($result){
		$dadesQuestionari = db_fetch_array($result);
		return $dadesQuestionari;
	}
	return null;
}

function getInfoAutor($idAutor){
	$result = db_query('SELECT * FROM ' . TAULA_AUTORS . ' WHERE ID = ' . $idAutor);
	if($result){
		$dadesAutor = db_fetch_array($result);
		return json_encode($dadesAutor);
	}
	return null;
}