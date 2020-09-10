<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('pagaments');

	require('descarregues.php');

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

	$card = $dbCards->readCard($ID);

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

	// si s'ha introduït, pugem el fitxer de la factura
	$normalizedName = '';
	if(isset($_FILES['FICHERO_FACTURA']) and $_FILES['FICHERO_FACTURA']['name'] != '') {

		$log = 1;
		$normalizedName = normalizeFile($_FILES['FICHERO_FACTURA']['name']);
		$log = upload('FICHERO_FACTURA', $CONFIG_PATHUPLOADAD.'/facturas', $UPLOAD_filesize, $UPLOAD_filetype, $normalizedName);

		// si no s'ha pogut pujar el fitxer correctament
		if ($log != 4) {
			htmlPageBasicError('S\'ha produït un error al gravar el fitxer introduït. Assegureu-vos que el fitxer està en un format suportat i no supera els límits de tamany establerts a l\'aplicació');
		}

	}
	// si s'ha pujat un nou fitxe de la factura, n'actualitzem el camp
	if (!empty($normalizedName)) { $data['FICHERO_FACTURA'] = $normalizedName; }

	// actualitzem les dades
	$dbCards->updateCard( $ID, $data );
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido actualizar el registro.</B><br>".$Cards->Error."\n"; exit; }

	// si hi ha algun canvi, notifiquem l'usuari
	if (
		$card['STATUS'] != $_POST['STATUS']
		or $card['FECHA_VALIDEZ'] != $_POST['FECHA_VALIDEZ']
	) {

		// obtenim email usuari, nom qüetionari i tipus descarregable
		$iQuery = db_query("
			SELECT
				`$USERS_TABLE`.EMAIL AS EMAIL,
				`$QUESTIONNAIRES_TABLE`.NOM_CAST AS NOM_CAST,
				`$DOWNLOADS_TABLE`.TIPO AS TIPO_DESC
			FROM
				`$USERS_TABLE`,
				`$QUESTIONNAIRES_TABLE`,
				`$DOWNLOADS_TABLE`
			WHERE
				`$USERS_TABLE`.ID = $card[ID_USUARIO]
				AND `$QUESTIONNAIRES_TABLE`.ID = $card[ID_CUEST]
				AND `$DOWNLOADS_TABLE`.ID = $card[ID_DESCARGABLE]
		");
		$iRow = db_fetch_array($iQuery);

		include_once ("mail.php");
		$cos = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<h1>BiblioPRO: Estado de la descarga solicitada</h1>
		<hr />
		<h2>El estado de la descarga <em>' . $TIPOS[$iRow['TIPO_DESC']] . ' del cuestionario ' . $iRow['NOM_CAST'] . '</em> ha cambiado.</h2>
		<p>Cambios realizados:</p>
		<ul>
			' . (($card['STATUS'] != $_POST['STATUS']) ? '<li>Estado: <strong>' . $status[$_POST['STATUS']] . '</strong></li>' : '') . '
			' . (($card['FECHA_VALIDEZ'] != $_POST['FECHA_VALIDEZ']) ? '<li>Fecha de validez: <strong>' . date('d-m-Y \a \l\a\s H:i:s', strtotime($_POST['FECHA_VALIDEZ'])) . '</strong></li>' : '') . '
		</ul>
		<p>Para más información, por favor, consulte <strong>Mi BiblioPRO</strong> en el apartado de <strong>Mis Sublicencias</strong></p>
	</body>
</html>';
		$destinatari = $iRow['EMAIL'];
		$from = '"BiblioPRO" <bibliopro@imim.es>';
		$assumpte = 'Modificación de descarga en BiblioPRO';
		// $cos = utf8_decode($cos);
		// $assumpte = utf8_decode($assumpte);
		// enviem el correu
		@sendMail($destinatari, $assumpte, $cos, $from, null, true);

	}

	// -----------
	// REDIRECTION
	// -----------
	// Return URL

	//insertar registre d'accions
	register_add("Descàrrega actualitzada", $ID);
	//fi

	goto_url('index.php');

?>
