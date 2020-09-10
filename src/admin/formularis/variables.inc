<?php

function _form_text ($nom, $valor, $text, $obligatori, $tamany = 0, $tabindex = null) {
	if ($tamany == '0')$amplada=" petit";
	if ($tamany == '1')$amplada=" normal";
	if ($tamany == '2')$amplada=" gran";
	$marcarobligatori = '';
	if ($obligatori==1)$marcarobligatori=" {required:true}";
	if ($obligatori==1 && $nom=="email")$marcarobligatori=" {required:true,email:true}";

	$tabindexText = '';
	if ($tabindex != null) {
		$tabindexText = ' tabindex="'.$tabindex.'"';
	}
	return '
		<label for="'.$nom.'">
			<span>'.$text.'</span>
			<input type="text" name="'.$nom.'" id="'.$nom.'" value="'.$valor.'" class="formulari'.$amplada.$marcarobligatori.'" '.$tabindexText.'  />
		</label>
';
}

function _form_textarea ($nom, $valor, $text, $obligatori, $tamany = 0, $tabindex = null) {
	if ($tamany == '0')$llarg="3";
	if ($tamany == '1')$llarg="8";
	if ($tamany == '2')$llarg="12";
	$marcarobligatori = '';
	if ($obligatori==1)$marcarobligatori="{required:true}";

	$tabindexText = '';
	if ($tabindex != null) {
		$tabindexText = ' tabindex="'.$tabindex.'"';
	}

	return '
		<div class="textarea">
			<label for="'.$nom.'"><span>'.$text.'</span></label>
			<textarea cols="40" rows="'.$llarg.'" name="'.$nom.'" id="'.$nom.'" class="'.$marcarobligatori.'"  '.$tabindexText.'>'.$valor.'</textarea>
		</div>
';
}

function _form_checkbox ($nom, $valor, $text, $obligatori, $tamany = 0, $tabindex = null) {
	$marcarobligatori = '';
	if ($obligatori==1)$marcarobligatori=" {required:true}";

	$tabindexText = '';
	if ($tabindex != null) {
		$tabindexText = ' tabindex="'.$tabindex.'"';
	}

	return '
		<label for="'.$nom.'_'.$valor.'" class="checkbox">
			<input type="checkbox" name="'.$nom.'" id="'.$nom.'" value="'.$valor.'" class="check'.$marcarobligatori.'"  '.$tabindexText.' />
			<span>'.$text.$numero.'</span>
		</label>
';
}

function _form_radio ($nom, $valor, $text, $obligatori, $tamany = 0, $tabindex = null) {
	$marcarobligatori = '';
	if ($obligatori==1)$marcarobligatori=" {required:true}";

	$tabindexText = '';
	if ($tabindex != null) {
		$tabindexText = ' tabindex="'.$tabindex.'"';
	}

	return '
		<label for="'.$nom.'_'.$valor.'" class="radio">
			<input type="radio" name="'.$nom.'" id="'.$nom.'_'.$valor.'" value="'.$valor.'" class="radio'.$marcarobligatori.'"  '.$tabindexText.' />
			<span>'.$text.'</span>
		</label>
';
}

function _form_select ($nom, $valor, $text, $tamany = 0, $tabindex = null) {

	$trozos = explode (",", $valor);
	$contingutselect = '';
	for($i=0;$i<count($trozos);$i++){
		$contingutselect .= '
			<option value="'.$trozos[$i].'">'.$trozos[$i].'</option>';
	}

	$tabindexText = '';
	if ($tabindex != null) {
		$tabindexText = ' tabindex="'.$tabindex.'"';
	}

	return '
		<label for="'.$nom.'"><span>'.$text.'</span>
			<select name="'.$nom.'" id="'.$nom.'"  '.$tabindexText.'>
'.$contingutselect.'
			</select>
		</label>
';
}

function _form_hidden ($nom, $valor, $text, $tamany = 0) {
	return '
		<input type="hidden" name="'.$nom.'" value="'.$valor.'" />';

}

function _form_desc ($nom, $valor, $text, $tamany = 0) {
	if($nom=="inici"){
		 return '
		<fieldset>
			<legend>'.$text.'</legend>
		';
	}elseif ($nom=="fi"){
		return '
		</fieldset>
		';
	}else {
		return '
		<p class="textFormulari">'.$text.'</p>
		';
	}

}
function _form_upload ($nom, $valor, $text, $tamany = 0) {
	return '
		<label for="'.$nom.'"><span>'.$text.'</span> <input type="file" name="'.$nom.'" id="'.$nom.'" value="'.$valor.'" /></label>
';
}

function makeForm($row) {
	global $CONFIG_NOMCARPETA, $CONFIG_PATHBASE;

	$actionformulari=$row['ACTION'];
	if ($actionformulari=="") {
		$actionformulari=$CONFIG_NOMCARPETA.'/media/php/formmail.php';
	}

	$result=db_query("select * from FORMULARISITEMS where FORMULARI=".$row['ID']." ORDER BY ORDRE ASC,ID ASC");
	$campsobligatoris = array();
	$contingutform = '';
	$i = 1;
	while($entrada = db_fetch_array($result)) {
		if ($entrada['OBLIGATORI'] == '1'){
			$campsobligatoris[] = $entrada['NOM'];
		}

		//tipos 0=text normal -- 1=textarea -- 2=checkbox -- 3=radio
		//-- 4=combo -- 5=ocult -- 6=titol text no formulari
		switch ($entrada['TIPO']) {
			case '0':
				$contingutform .= _form_text ($entrada['NOM'], $entrada['VALOR'], $entrada['TEXT'],$entrada['OBLIGATORI'], $entrada['TAMANY'], $i);
				$i++;
				break;
			case '1':
				$contingutform .= _form_textarea ($entrada['NOM'], $entrada['VALOR'], $entrada['TEXT'],$entrada['OBLIGATORI'], $entrada['TAMANY'], $i);
				$i++;
				break;
			case '2':
				$contingutform .= _form_checkbox ($entrada['NOM'], $entrada['VALOR'], $entrada['TEXT'],$entrada['OBLIGATORI'], $entrada['TAMANY'], $i);
				$i++;
				break;
			case '3':
				$contingutform .= _form_radio ($entrada['NOM'], $entrada['VALOR'], $entrada['TEXT'],$entrada['OBLIGATORI'], $entrada['TAMANY'], $i);
				$i++;
				break;
			case '4':
				$contingutform .= _form_select ($entrada['NOM'], $entrada['VALOR'], $entrada['TEXT'], $entrada['TAMANY'], $i);
				$i++;
				break;
			case '5':
				$contingutform .= _form_hidden ($entrada['NOM'], $entrada['VALOR'], $entrada['TEXT'], $entrada['TAMANY']);
				break;
			case '6':
				$contingutform .= _form_desc ($entrada['NOM'], $entrada['VALOR'], $entrada['TEXT'], $entrada['TAMANY']);
				break;
			case '7':
				$contingutform .= _form_upload ($entrada['NOM'], $entrada['VALOR'], $entrada['TEXT'], $entrada['TAMANY']);
				break;
		}
	}

	$return['formphp'] = '<?php
require_once("'.$CONFIG_PATHBASE.'/media/php/formmail.php");
gestionaFormulari("'.$row['TITOLFORMULARI'].'", "'.$row['RECIPIENT'].'", "'.$row['REDIRECT'].'");
?>';



	$return['formbody'] = $contingutform;
	$return['formheader'] = 'action="'.$row['NOMFORMULARI'].'" method="post" id="form1" enctype="multipart/form-data"';

	$return['formscript'] = '';
	if (count($campsobligatoris)>0) {
		$return['formscript'] = '
		<script src="|CONFIG_NOMCARPETA|/media/js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="|CONFIG_NOMCARPETA|/media/js/jquery.metadata.min.js" type="text/javascript"></script>
';
		if($row['IDIOMA'] != 'en') {
		$return['formscript'] .= '
		<script src="|CONFIG_NOMCARPETA|/media/js/jquery.validate.messages_'.$row['IDIOMA'].'.js" type="text/javascript"></script>
';
	 }
		$return['formscript'] .= '
		<script type="text/javascript">
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#form1").validate();
		});
		</script>
';
	}
	db_free_result($result);
	return $return;
}




require_once($CONFIG_PATHADMIN.'/php/graphic-title.inc');


function generate_page ($row, $preview = false) {
	global $CONFIG_NOMCARPETA, $CONFIG_PATHBASE, $CONFIG_PATHADMIN,$CONFIG_PATHPHP;
	global $CONFIG_URLBASE, $CONFIG_SITENAME;
	global $CONFIG_PATHBANNER, $CONFIG_URLBANNER, $CONFIG_TITOLGRAFIC;
	global $CONFIG_URLUPLOADIM, $CONFIG_URLUPLOADAD, $CONFIG_PATHTEMPLATEFORM;

	if($preview) {
		$error = t('formerrorpreview');
	}
	else {
		$error = t('formerrorcreate');
	}

	/*comprovar que hi ha plantilla assignada*/
	if (!isset($row['PLANTILLA']) || $row['PLANTILLA'] == '') {
		return ($error);
	}


	/*llegir plantilla*/
	$filename = $CONFIG_PATHTEMPLATEFORM.'/'.$row['PLANTILLA'];
	if (!file_exists($filename)) {
		return ($error);
	}
	//$dynamic_source = file_get_contents($filename);
	$fd = fopen($filename, 'r');
	$dynamic_source = fread($fd, filesize($filename));

	if (!$dynamic_source) {
		return ($error);
	}


	/*eliminar comentaris*/
	if (file_exists($CONFIG_PATHADMIN.'/moduls/base/comentaris.inc')) {
		require_once($CONFIG_PATHADMIN.'/moduls/base/comentaris.inc');
		$dynamic_source = comments_pages($dynamic_source);
	}

	/*afegir blocks de la pàgina*/
	if (file_exists($CONFIG_PATHADMIN.'/moduls/block/funcions.inc')) {
		require_once($CONFIG_PATHADMIN.'/moduls/block/funcions.inc');
		$dynamic_source = block_pages($dynamic_source, $row['ID'], 'FORMULARIS', $preview);
	}

	/*afegir menus de la pàgina*/
	if (file_exists($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc')) {
		require_once($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc');
		$dynamic_source = menu_pages($dynamic_source, $row['ID'], 'FORMULARIS', $preview);
	}


	$carpetes = folderPathArray($row['PARE']);
	$carpetes = array_keys($carpetes);
	$dynamic_source = str_replace('|IDSDIRECTORIS|', implode(',',$carpetes), $dynamic_source);


	$page_url = folderPath($row['PARE']);
	if ($page_url == '') {
		$page_url = $row['NOMFORMULARI'];
	}
	else {
		$page_url = $page_url.'/'.$row['NOMFORMULARI'];
	}
	$page_url = str_replace('//', '/',$CONFIG_NOMCARPETA.'/'.$page_url);
	$dynamic_source = str_replace('|PAGE_URL|', $page_url, $dynamic_source);



	/*afegir menus de la pàgina*/
	if (file_exists($CONFIG_PATHADMIN.'/moduls/composicions/funcions.inc')) {
		require_once($CONFIG_PATHADMIN.'/moduls/composicions/funcions.inc');
		$dynamic_source = composicio_pages($dynamic_source, $row['ID'], 'FORMULARIS', $preview);
	}



	/*afegir metas de la pàgina*/
	if (file_exists($CONFIG_PATHADMIN.'/moduls/metatags/funcions.inc')) {
		require_once($CONFIG_PATHADMIN.'/moduls/metatags/funcions.inc');
		$dynamic_source = metas_pages($dynamic_source, $row['ID'], 'FORMULARIS', $preview);
	}


	/*afegir idioma*/
	$dynamic_source = str_replace('|IDIOMA_PAG|', $row['IDIOMA'], $dynamic_source);

	/*crear fil d'ariadna*/
	$navegasituacio = fil_ariadna ($row['TITOLFORMULARI'], $row['PARE'], $row['IDIOMA']);
	$dynamic_source = str_replace('|SITUACIO|', $navegasituacio, $dynamic_source);


	/*crear ruta de aparatat*/
	$navegarutaapartat = ruta_apartat ($row['TITOLFORMULARI'], $row['PARE'], $row['IDIOMA']);
	$dynamic_source = str_replace('|APARTAT|', $navegarutaapartat, $dynamic_source);


	$folders = folderPathArray($row['PARE']);
	$folderKeys = array_keys($folders);
	for($i = 0; $i < 10; $i++) {
		$folderName = array_shift($folders);
		$folderKey = array_shift($folderKeys);
		if ($folderName == null) {
			$folderName = '';
			$folderKey = '';
		}
		$dynamic_source = str_replace('|CARPETA_NOM_'.$i.'|', $folderName, $dynamic_source);
		$dynamic_source = str_replace('|CARPETA_ID_'.$i.'|', $folderKey, $dynamic_source);
	}


	/*crear titol imatge utilitzo la variable predeterminada |Titol Grafic| */
	if($row['TITOLFORMULARI'] != '' && $CONFIG_TITOLGRAFIC=='1') {
		$text = 'form-title-'.$row['ID'];
		$dynamic_source = graphic_title_insert($row['TITOLFORMULARI'], $text, '|TITOL|', $dynamic_source, $preview);
	}

	/*afegir formulari*/
	$values = makeForm($row);

	$dynamic_source = str_replace('</head>', $values['formscript'].'</head>', $dynamic_source);


	$descripcio = textareaFilter($row['DESCRIPCIO']);
	$arrayBuscados = array('|CONFIGFORMULARI|','|TITOL|','|DESCRIPCIOFORMULARI|','|CAMPSFORMULARI|');
	$arrayReemplazar = array($values['formheader'],$row['TITOLFORMULARI'],$descripcio,$values['formbody']);
	$dynamic_source = str_replace($arrayBuscados, $arrayReemplazar, $dynamic_source);


	/*afegir paths*/
	$dynamic_source = str_replace('|CONFIG_NOMCARPETA|', $CONFIG_NOMCARPETA, $dynamic_source);
	$dynamic_source = str_replace('|CONFIG_PATHBASE|', $CONFIG_PATHBASE, $dynamic_source);
	$dynamic_source = str_replace('|CONFIG_PATHPHP|', $CONFIG_PATHPHP, $dynamic_source);
	$dynamic_source = str_replace('|CONFIG_URLBASE|', $CONFIG_URLBASE, $dynamic_source);
	$dynamic_source = str_replace('|CONFIG_SITENAME|', $CONFIG_SITENAME, $dynamic_source);


	$dynamic_source = pageFilter($dynamic_source);

	$dynamic_source = $values['formphp'].$dynamic_source;

	/*afegir codi analytics*/
	if (file_exists($CONFIG_PATHADMIN.'/moduls/base/analytics.inc')) {
		require_once($CONFIG_PATHADMIN.'/moduls/base/analytics.inc');
		$dynamic_source = analytics_pages($dynamic_source);
	}

	/*afegir variables php de la pàgina*/
	if (file_exists($CONFIG_PATHADMIN.'/moduls/base/php_vars.inc')) {
		require_once($CONFIG_PATHADMIN.'/moduls/base/php_vars.inc');
		$dynamic_source = phpVars_pages($dynamic_source, $row['ID'], 'FORMULARIS', $preview);
	}


	if ($preview) {
		/*desavilitar els links*/
		$dynamic_source = str_replace('<a href="', '<a href="#', $dynamic_source);
	}


	return (array('normal' => $dynamic_source));

}



/*funcio que guarda les pàgines*/
function create_page($nom, $pare, $content) {
	global $CONFIG_PATHTEMPLATE, $CONFIG_PATHBASE;
	global $CONFIG_PERMFILES;

	$path = folderPath ($pare);

	$tempfilename = $CONFIG_PATHTEMPLATE.'/plantilla.html';
	$targetfilename = $CONFIG_PATHBASE.'/'.$path.'/'.$nom;

	/*crear fitxer amb la pagina*/
	$tempfile = fopen($tempfilename, 'w');
	if (!$tempfile) {
		return(t("formerrornoopen")); //impossible obrir la plantilla
	}
	fwrite($tempfile, $content);
	fclose($tempfile);

	/*copiar pagina al desti final*/
	copy($tempfilename, $targetfilename);
	if (!empty($CONFIG_PERMFILES)) {
		chmod($targetfilename, $CONFIG_PERMFILES);
	}
//  unlink ($tempfilename);
	return ('');
}


?>
