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
	if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
	if (empty($ECLASS))      { $ECLASS=$DEFAULT_ECLASS; }

	if (empty($SKIN))       { $SKIN=$DEFAULT_SKIN; }
	if (empty($CATEGORY1))  { $CATEGORY1=$DEFAULT_CATEGORY1; }
	if (empty($CATEGORY2))  { $CATEGORY2=$DEFAULT_CATEGORY2; }
	if (empty($STATUS))     { $STATUS=$DEFAULT_STATUS; }
	if (empty($VISIBILITY)) { $VISIBILITY=$DEFAULT_VISIBILITY; }

	// ------------------
	// CARDS INSTANTATION
	// ------------------
	$dbCards = new dbCards($CARDS_TABLE);
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }

	// --------------------
	// DATA PREPARATION
	// --------------------
	unset($data);

	$data['ECLASS']      = (int)trim($ECLASS);
	$data['SKIN']       = (int)trim($SKIN);
	$data['STATUS']     = (int)trim($STATUS);

	$data['CREATION'] = date('Y-m-d H:i:s', time());
	$_POST['USUARICREAR'] = $_POST['USUARI'];
	$_POST['USUARIMODI'] = $_POST['USUARI'];
	$MODIFICAT = $data['CREATION'];

	// si s'ha introduït, pugem el fitxer del contracte
	$contractNormalizedName = '';
	if(isset($_FILES['FICHERO_CONTRATO']) and $_FILES['FICHERO_CONTRATO']['name'] != '') {

		$log = 1;
		$contractNormalizedName = normalizeFile($_FILES['FICHERO_CONTRATO']['name']);
		$log = upload('FICHERO_CONTRATO', $CONFIG_PATHUPLOADAD.'/contratos', $UPLOAD_filesize, $UPLOAD_filetype, $contractNormalizedName);

		// si no s'ha pogut pujar el fitxer correctament
		if ($log != 4) {
			htmlPageBasicError('S\'ha produït un error al gravar el fitxer del contracte introduït. Assegureu-vos que el fitxer està en un format suportat i no supera els límits de tamany establerts a l\'aplicació');
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

	// Omplim els camps CUSTOM
	foreach ($CARDS_FIELDS as $name=>$field)
	{
	  list ($scope, $type, $style) = $field;
	  if ($scope=='CUSTOM' && (isset($_POST[$name]) || isset($_POST[$name.'_DAY'])))
	  {
			if ($type=='NUMBER' || $type=='ITEM' )
			{ $data[$name]=(int)trim($$name); }

			if ($type=='CHAR' || $type=='TEXT')
			{ $data[$name]= trim($_POST[$name]); }

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

			if ($type=='DATE') {
				$year=trim(${$name.'_YEAR'});
				$month=trim(${$name.'_MONTH'});
				$day=trim(${$name.'_DAY'});
				$hour=trim(${$name.'_HOUR'});
				$min=trim(${$name.'_MIN'});
				$sec=trim(${$name.'_SEC'});
				$data[$name]="$year-$month-$day hour:min:sec";
			}
	  } // end if
	} // end foreach

	// --------------
	// DATA INSERTION
	// --------------
	$data['MODIFICAT'] = $data['CREATION'];

	if (isset($_POST['SUBLICENCIA_BIBLIOPRO'])) { $data['SUBLICENCIA_BIBLIOPRO'] = 1; }
	else { $data['SUBLICENCIA_BIBLIOPRO'] = 0; }

	$data['FICHERO_CONTRATO'] = $contractNormalizedName;
	$data['FICHERO_SUBLICENCIA'] = $sublicenceNormalizedName;

	if (isset($_POST['FICHERO_CONTRATO_ELIMINAR'])) {
		@unlink($CONFIG_PATHUPLOADAD . '/contratos/ ' . $data['FICHERO_CONTRATO'] );
		$data['FICHERO_CONTRATO'] = '';
	}
	if (isset($_POST['FICHERO_SUBLICENCIA_ELIMINAR'])) {
		@unlink($CONFIG_PATHUPLOADAD . '/sublicencias/ ' . $data['FICHERO_SUBLICENCIA'] );
		$data['FICHERO_SUBLICENCIA'] = '';
	}

	$data['ID'] = $_POST['ID'];

	$id = $dbCards->newCard($data);
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear nueva ficha.</B><br>\n"; exit; }

	// -----------
	// REDIRECTION
	// -----------
	// Return URL

	//insertar registre d'accions
	register_add("Subllicència de qüestionaris creada", "$ID");
	//fi

	// tornem al llistat d'autors
	goto_url('../view.php?ID=' . $_POST['ID']);

?>
