<?php

	require ('../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('questionaris.php');

	// si existeix un qüestionari amb el mateix id i versió no permetem modificar-lo
	$result=db_query("
		select *
		from $CARDS_TABLE
		where ID_CUEST = '$ID_CUEST' AND VERSION = '$VERSION' AND ID != $ID
	");
	$trobats = db_num_rows($result);

	if($trobats > 0){
	  htmlPageBasicError('Ja existeix un qüestionari amb la mateixa ID i versió.');
	}
	else if (empty($_POST['NOM_ORIGINAL']) or empty($_POST['NOM_CAST'])) {
	  htmlPageBasicError('Tant el nom original com el nom de la versió castellana han d\'estar indicats');
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

	// actualitzem les dades
	$dbCards->updateCard( $ID, $data );
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido actualizar el registro.</B><br>".$Cards->Error."\n"; exit; }

	// -----------
	// REDIRECTION
	// -----------
	//insertar registre d'accions
	register_add("Qüestionari actualitzat", "$NOM_CAST ($VERSION)");
	//fi

	goto_url('index.php');

?>
