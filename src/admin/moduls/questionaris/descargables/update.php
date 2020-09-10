<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('descargables.php');

	// si no s'indica el qüestionari per als descarregables, mostrem error
	if (empty($_POST['ID_CUEST'])) {
		htmlPageBasicError('No s\'ha indicat cap qüestionari per a gestionar-ne els descarregables.');
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

	// si s'ha introduït, pugem el fitxer
	$normalizedName = '';
	if(isset($_FILES['FICHERO']) and $_FILES['FICHERO']['name'] != '') {

		$log = 1;
		$normalizedName = normalizeFile($_FILES['FICHERO']['name']);
		$log = upload('FICHERO', $CONFIG_PATHUPLOADAD.'/descargables', $UPLOAD_filesize, $UPLOAD_filetype, $normalizedName);

		// si no s'ha pogut pujar el fitxer correctament
		if ($log != 4) {
			htmlPageBasicError('S\'ha produït un error al gravar el fitxer introduït. Assegureu-vos que el fitxer està en un format suportat i no supera els límits de tamany establerts a l\'aplicació');
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

	if (isset($_POST['VISIBLE'])) { $data['VISIBLE'] = 1; }
	else { $data['VISIBLE'] = 0; }

	if (isset($_POST['PROTEGIDO_LOGIN'])) { $data['PROTEGIDO_LOGIN'] = 1; }
	else { $data['PROTEGIDO_LOGIN'] = 0; }

	if (isset($_POST['SUBLICENCIA'])) { $data['SUBLICENCIA'] = 1; }
	else { $data['SUBLICENCIA'] = 0; }

	// si s'ha pujat un nou fitxer, n'actualitzem el camp
	if (!empty($normalizedName)) { $data['FICHERO'] = $normalizedName; }

	// actualitzem les dades
	$dbCards->updateCard( $ID, $data );
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido actualizar el registro.</B><br>".$Cards->Error."\n"; exit; }

	// -----------
	// REDIRECTION
	// -----------
	// Return URL

	//insertar registre d'accions
	register_add("Descarregable de qüestionaris actualitzat", "$TIPO ($_POST[ID_CUEST])");
	//fi

	goto_url('index.php?ID_CUEST='.$_POST['ID_CUEST']);

?>
