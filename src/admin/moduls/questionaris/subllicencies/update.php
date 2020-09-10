<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('subllicencies.php');

	// si no s'indica el qüestionari per als descarregables, mostrem error
	if (empty($_POST['ID'])) {
		htmlPageBasicError('No s\'ha indicat cap qüestionari per a gestionar-ne la informació legal.');
	}

	// --------------------
	// PARAMETERS DEFAULT
	// --------------------
	if (empty($ID))     { echo "<B>Error: No se ha recibido el codigo de card.</B><br>\n"; exit; }
	if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
	if (empty($ECLASS))      { $ECLASS=$DEFAULT_ECLASS; }

	// ------------------
	// CARDS INSTANTATION
	// ------------------
	$dbCards = new dbCards($CARDS_TABLE);
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }

	// -------------
	// DATA UPDATING
	// -------------
	// DATA PREPARATION
	unset($data);

	$avui = date('Y-m-d H:i:s', time());
	$data['MODIFICAT']=$avui;

	$_POST['USUARIMODI'] = $_POST['USUARI'];

	// si s'ha introduït, pugem el fitxer del contracte
	$contractNormalizedName = '';
	if(isset($_FILES['FICHERO_CONTRATO']) and $_FILES['FICHERO_CONTRATO']['name'] != '') {

		$log = 1;
		$contractNormalizedName = normalizeFile($_FILES['FICHERO_CONTRATO']['name']);
		$log = upload('FICHERO_CONTRATO', $CONFIG_PATHUPLOADAD.'/contratos', $UPLOAD_filesize, $UPLOAD_filetype, $contractNormalizedName);

		// si no s'ha pogut pujar el fitxer correctament
		if ($log != 4) {
			htmlPageBasicError('S\'ha produït un error al gravar el fitxer del conracte introduït. Assegureu-vos que el fitxer està en un format suportat i no supera els límits de tamany establerts a l\'aplicació');
		}

	}

	// si s'ha introduït, pugem el fitxer de la subllicència
	$sublicenceNormalizedName = '';
	if(isset($_FILES['FICHERO_SUBLICENCIA']) and $_FILES['FICHERO_SUBLICENCIA']['name'] != '') {

		$log = 1;
		$sublicenceNormalizedName = normalizeFile($_FILES['FICHERO_SUBLICENCIA']['name']);
		$log = upload('FICHERO_SUBLICENCIA', $CONFIG_PATHUPLOADAD.'/sublicencias', $UPLOAD_filesize, $UPLOAD_filetype, $sublicenceNormalizedName);

		// si no s'ha pogut pujar el fitxer correctament
		if ($log != 4) {
			htmlPageBasicError('S\'ha produït un error al gravar el fitxer de la subllicència introduït. Assegureu-vos que el fitxer està en un format suportat i no supera els límits de tamany establerts a l\'aplicació');
		}

	}

	// Passem llista als camps i mirem quins em rebut per POST METHOD
	foreach ($CARDS_FIELDS as $name=>$field)
	{
	  list ($scope, $type, $style) = $field;

	  if (isset($_POST[$name]) || isset($_POST[$name.'_DAY']))
	  {
			if ($type=='NUMBER' || $type=='ITEM' )
			{ $data[$name]=(int)trim($$name); }

			if (($type=='CHAR' || $type=='TEXT')) {
				// si és un array, el gravem serialitzat
				if (is_array($_POST[$name])) {
					$data[$name]= serialize($_POST[$name]);
				}
				else {
					$data[$name]= trim($_POST[$name]);
				}
			}

			if ($type=='FLAG')
			{
				$data[$name]='';
				for ($i=0; $i<strlen($$name); $i++)
				{
					 if (isset(${$name.'_'.$i}))
					 { $data[$name].='1'; }
					 else
					 { $data[$name].='0'; }
				}
			}

			if ($type=='DATE')
			{
			  $year  = trim(${$name.'_YEAR'});
			  $month = trim(${$name.'_MONTH'});
			  $day   = trim(${$name.'_DAY'});
			  $hour  = trim(${$name.'_HOUR'});
			  $min   = trim(${$name.'_MIN'});
			  $sec   = trim(${$name.'_SEC'});
			  $data[$name]="$year-$month-$day $hour:$min:$sec";
			}
	  } // end if
	} // end foreach

	if (isset($_POST['SUBLICENCIA_BIBLIOPRO'])) { $data['SUBLICENCIA_BIBLIOPRO'] = 1; }
	else { $data['SUBLICENCIA_BIBLIOPRO'] = 0; }

	if (isset($_POST['VISIBLE_WEB'])) { $data['VISIBLE_WEB'] = 1; }
	else { $data['VISIBLE_WEB'] = 0; }

	// si s'ha pujat un nou fitxer de contracte, n'actualitzem el camp
	if (!empty($contractNormalizedName)) { $data['FICHERO_CONTRATO'] = $contractNormalizedName; }

	// si s'ha pujat un nou fitxer de subllicència, n'actualitzem el camp
	if (!empty($sublicenceNormalizedName)) { $data['FICHERO_SUBLICENCIA'] = $sublicenceNormalizedName; }

	if (isset($_POST['FICHERO_CONTRATO_ELIMINAR'])) {
		@unlink($CONFIG_PATHUPLOADAD . '/contratos/ ' . $data['FICHERO_CONTRATO'] );
		$data['FICHERO_CONTRATO'] = '';
	}
	if (isset($_POST['FICHERO_SUBLICENCIA_ELIMINAR'])) {
		@unlink($CONFIG_PATHUPLOADAD . '/sublicencias/ ' . $data['FICHERO_SUBLICENCIA'] );
		$data['FICHERO_SUBLICENCIA'] = '';
	}

	// actualitzem les dades
	$dbCards->updateCard( $ID, $data );
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido actualizar el registro.</B><br>".$Cards->Error."\n"; exit; }

	// -----------
	// REDIRECTION
	// -----------
	//insertar registre d'accions
	register_add("Subllicència de qüestionari actualitzada", "$ID");
	//fi

	goto_url('../view.php?ID=' . $ID);

?>
