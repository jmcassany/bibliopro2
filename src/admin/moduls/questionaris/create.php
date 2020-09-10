<?php

	require ('../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('questionaris.php');

	if (empty($_POST['NOM_ORIGINAL']) or empty($_POST['NOM_CAST'])) {
		htmlPageBasicError('Tant el nom original com el nom de la versió castellana han d\'estar indicats');
	}

	// --------------------
	// PARAMETERS DEFAULT
	// --------------------
	if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
	if (empty($ECLASS))      { $ECLASS=$DEFAULT_ECLASS; }

	if (empty($SKIN))       { $SKIN=$DEFAULT_SKIN; }
	if (empty($STATUS))     { $STATUS=$DEFAULT_STATUS; }

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

	// Omplim els camps CUSTOM
	foreach ($CARDS_FIELDS as $name=>$field)
	{
	  list ($scope, $type, $style) = $field;
	  if ($scope=='CUSTOM' && (isset($_POST[$name]) || isset($_POST[$name.'_DAY'])))
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

	if (isset($_POST['IDENTIFICADO'])) { $data['IDENTIFICADO'] = 1; }
	else { $data['IDENTIFICADO'] = 0; }

	if (isset($_POST['DISPONIBLE'])) { $data['DISPONIBLE'] = 1; }
	else { $data['DISPONIBLE'] = 0; }

	if (isset($_POST['EVALUADO'])) { $data['EVALUADO'] = 1; }
	else { $data['EVALUADO'] = 0; }

	// id autors original a camp text
	if (is_array($_POST['IDAUTORES_ORIGINAL']) and count($_POST['IDAUTORES_ORIGINAL']) > 0) {
		$authors = array();
		foreach ($_POST['IDAUTORES_ORIGINAL'] as $authorID) {
			$authorQuery = db_query("
				SELECT `NOM`
				FROM `$AUTHORS_TABLE`
				WHERE `ID` = '$authorID'
			");
			if (db_num_rows($authorQuery) > 0) {
				$authorRow = db_fetch_array($authorQuery);
				$authors[] = $authorRow['NOM'];
			}
		}
		$data['AUTORES_ORIGINAL_NOMBRES'] = implode(', ', $authors);
	}
	else {
		$data['AUTORES_ORIGINAL_NOMBRES'] = '';
	}

	// id autors adaptació a camp text
	if (is_array($_POST['IDAUTORES_CAST']) and count($_POST['IDAUTORES_CAST']) > 0) {
		$authors = array();
		foreach ($_POST['IDAUTORES_CAST'] as $authorID) {
			$authorQuery = db_query("
				SELECT `NOM`
				FROM `$AUTHORS_TABLE`
				WHERE `ID` = '$authorID'
			");
			if (db_num_rows($authorQuery) > 0) {
				$authorRow = db_fetch_array($authorQuery);
				$authors[] = $authorRow['NOM'];
			}
		}
		$data['AUTORES_CAST_NOMBRES'] = implode(', ', $authors);
	}
	else {
		$data['AUTORES_CAST_NOMBRES'] = '';
	}

	// --------------
	// DATA INSERTION
	// --------------
	$data['MODIFICAT'] = $data['CREATION'];

	// obtenim l'ID_CUEST següent disponible i indiquem la primera versió
	$idCuestQuery = db_query ("SELECT ID_CUEST FROM $CARDS_TABLE ORDER BY ID_CUEST DESC LIMIT 1");
	$idCuestRow = db_fetch_array($idCuestQuery);

	$data['ID_CUEST'] = $idCuestRow['ID_CUEST'] + 1;
	$data['VERSION'] = 1;

	$id = $dbCards->newCard($data);
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear nueva ficha.</B><br>\n"; exit; }

	// -----------
	// REDIRECTION
	// -----------
	// Return URL

	//insertar registre d'accions
	register_add("Qüestionari creat", "$data[ID_CUEST] ($VERSION)");
	//fi

	goto_url('index.php');

?>
