<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('pagaments');

	require('subllicencies.php');

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
	foreach ($CARDS_FIELDS as $name=>$field) {
	  list ($scope, $type, $style) = $field;
	  if (isset($_POST[$name]) || isset($_POST[$name.'_DAY'])) {
			if ($type=='NUMBER' || $type=='ITEM' ){
				$data[$name]=(int)trim($$name);
			}
			if ($type=='CHAR' || $type=='TEXT') {
				$data[$name]= trim($_POST[$name]);
			}
			if ($type=='FLAG') {
				$data[$name]='';
				for ($i=0; $i<strlen($$name); $i++) {
					if (isset(${$name.'_'.$i})) { $data[$name].='1'; }
					else { $data[$name].='0'; }
				}
			}
			if ($type=='DATE') {
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

	// ruta fitxer PDF
	$pdfFilePath = $CONFIG_PATHBASE . '/media/upload/pdf/sublicencias-atorgadas/' . $card['NUM_ALBARAN'] . '.pdf';

	// si es canvia l'estat a atorgada, canviem la data i generem pdf subllicència
	if ($_POST['OTORGADA'] == '2') {

		setlocale(LC_ALL, 'es_ES.UTF-8', 'es_ES', 'es');

		$data['FECHA_OTORGADA'] = date('Y-m-d H:m:i');

		if (!empty($card['FACTURACION_PAIS'])) {

			$countriesFacturacioSelect = ", `$COUNTRIES_TABLE`.PAIS AS PAIS_FACTURACIO";
			$countriesFacturacioTable = ", `$COUNTRIES_TABLE`";
			$countriesFacturacioWhere = "AND `$COUNTRIES_TABLE`.ID = $card[FACTURACION_PAIS]";

		}
		else {

			$countriesFacturacioSelect = $countriesFacturacioTable = $countriesFacturacioWhere = '';

		}



			$countriesSelect = ", PAISOS.PAIS AS PAIS";
			$countriesTable = ", `$COUNTRIES_TABLE` PAISOS";
			$countriesWhere = "AND PAISOS.ID = `$USERS_TABLE`.PAIS";



		if (!empty($card['ENFERMEDAD'])) {

			$illnessSelect = ", `$ILLNESS_TABLE`.VALOR AS ENFERMEDAD";
			$illnessTable = ", `$ILLNESS_TABLE`";
			$illnessWhere = "AND `$ILLNESS_TABLE`.ID = $card[ENFERMEDAD]";

		}
		else {

			$illnessSelect = $illnessTable = $illnessWhere = '';

		}

		// obtenim email usuari, nom qüestionari i pais
		$iQuery = db_query("
			SELECT
				`$USERS_TABLE`.NOMBRE AS NOMBRE,
				`$USERS_TABLE`.EMAIL AS EMAIL,

				`$QUESTIONNAIRES_TABLE`.NOM_CAST AS NOM_CAST
				$illnessSelect
				$countriesSelect
				$countriesFacturacioSelect
			FROM
				`$USERS_TABLE`,
				`$QUESTIONNAIRES_TABLE`
				$illnessTable
				$countriesTable
				$countriesFacturacioTable
			WHERE
				`$USERS_TABLE`.ID = $card[ID_USUARIO]
				AND `$QUESTIONNAIRES_TABLE`.ID = $card[ID_CUEST]
				$illnessWhere
				$countriesWhere
				$countriesFacturacioWhere
		");
		$iRow = db_fetch_array($iQuery);

		switch ($card['FINANCIACION_ENTIDAD']) {

			case 1: $finan = 'Con ánimo de lucro'; break;
			case 2: $finan = 'Sin ánimo de lucro'; break;
			case 3: $finan = 'Académica'; break;
			default: $finan = 'Desconocida'; break;

		}

		switch ($data['OTORGADA']) {

			case 0: $status = 'Pendiente de otorgación'; break;
			case 1: $status = 'Pendiente de terceros'; break;
			case 2: $status = 'Otorgada el ' . strftime('%e de %B de %Y a las %H:%M', strtotime($data['FECHA_OTORGADA'])); break;
			case 3: $status = 'Denegada'; $data['FECHA_VALIDEZ'] = 'Denegada'; break;
			default: $status = 'Desconocido'; break;

		}

		if (empty($data['FACTURA'])) {

			$billDate = 'No emitida';

		}
		else {

			$billDate = strftime('%e de %B de %Y a las %H:%M', strtotime($data['FECHA_FACTURA']));

		}

		// obtenim text acceptació subllicència
		$sublicenceInfoQuery = db_query("
			SELECT TEXTO_ACEPTACION FROM $SUBLICENCES_TABLE
			WHERE ID = '" . mysql_real_escape_string($card['ID_CUEST']) . "'
		");
		if (db_num_rows($sublicenceInfoQuery) > 0) {
			$sublicenceRow = db_fetch_array($sublicenceInfoQuery);
		}

		// generem markup pdf
		$markup = '
<page>
	<table width="100%" cellpadding="20px" cellspacing="0" bgcolor="#fb8e15">
		<tr>
			<td width="50%" align="left"><img src="' . $CONFIG_PATHBASE . '/media/css/img/bg_header.jpg" alt="BiblioPRO" /></td>
			<td width="50%" align="right"><img src="' . $CONFIG_PATHBASE . '/media/img/logo-fundacio-imim.jpg" alt="Fundación IMIM" /></td>
		</tr>
	</table>
	<h1>Sublicencia en BiblioPRO</h1>
	<hr />
	<h2>Se le ha otorgado la sublicencia de <em>' . $iRow['NOM_CAST'] . '</em></h2>
	<p><strong>Estado de la sublicencia:</strong> ' . $status . '</p>
	<p><strong>Válida hasta:</strong> ' . strftime('%e de %B de %Y a las %H:%M', strtotime($data['FECHA_VALIDEZ'])) . ' ' . ($data['OTORGADA'] != 2 ? '<em>(No definitiva)</em>' : '') . '</p>
	<h5>Información sobre el pago</h5>
	<ul>
		<li>
			<strong>Precio de la sublicencia:</strong>
			<ul>
				<li><strong>Base imponible:</strong> ' . $card['PRECIO'] . ' €</li>
				<li><strong>IVA:</strong> ' . $card['TIPO_IVA'] . '% (' . $card['IVA'] . ' €)</li>
				<li><strong>Total:</strong> ' . $card['TOTAL'] . ' €</li>
			</ul>
		</li>
		<li><strong>Número de la factura:</strong> ' . $data['FACTURA'] . '</li>
		<li><strong>Fecha de la factura:</strong> ' . $billDate . '</li>
		<li><strong>Número de albarán interno:</strong> ' . $card['NUM_ALBARAN'] . '</li>
		<li><strong>IBAN:</strong> ' . $card['IBAN'] . '</li>
		<li><strong>SWIFT:</strong> ' . $card['SWIFT'] . '</li>
	</ul>
	<h5>Información sobre la sublicencia</h5>
	<ul>
		<li><strong>Nombre:</strong> ' . htmlspecialchars($iRow['NOMBRE']) . '</li>
		<li><strong>Email:</strong> ' . htmlspecialchars($iRow['EMAIL']) . '</li>
		<li><strong>País:</strong> ' . htmlspecialchars($iRow['PAIS']) . '</li>
		<li><strong>Fecha de solicitud:</strong> ' . strftime('%e de %B de %Y a las %H:%M', strtotime($card['FECHA_SOLICITUD'])) . '</li>
		<li><strong>Número de administraciones:</strong> ' . htmlspecialchars($card['NUM_ADMINISTRACIONES']) . '</li>
		<li><strong>Financiación mayoritaria por una entidad:</strong> ' . $finan . '</li>
		<li><strong>Entidad desde la que solicita la sublicencia:</strong> ' . htmlspecialchars($card['ENTIDAD_SOLICITANTE']) . '</li>
		<li><strong>Promotor del proyecto:</strong> ' . htmlspecialchars($card['PROMOTOR']) . '</li>
	</ul>';
		if (!empty($card['PREGUNTAS'])) {

			$questions = unserialize($card['PREGUNTAS']);
			if (is_array($questions) and count($questions) > 0) {

				$markup .= '
	<h5>Información adicional</h5>';

				foreach ($questions as $questionID => $answers) {

					if (is_array($answers) and count($answers) > 0) {

						// get question text
						$questionQuery = db_query("
							SELECT PREGUNTA FROM `$QUESTIONS_TABLE`
							WHERE ID = '$questionID'
						");
						$questionRow = db_fetch_array($questionQuery);

						$markup .= '
	<p>' . htmlspecialchars($questionRow['PREGUNTA']) . '</p>
	<ul>';
						foreach ($answers as $answerID) {
							// get question text
							$answerQuery = db_query("
								SELECT RESPUESTA FROM `$ANSWERS_TABLE`
								WHERE ID = '$answerID'
							");
							$answerRow = db_fetch_array($answerQuery);
							$markup .= '
		<li>' . htmlspecialchars($answerRow['RESPUESTA']) . '</li>';
						}
						$markup .= '
	</ul>';

					}

				}

			}

		}
		$markup .= '
	<h5>Información sobre el estudio</h5>
	<ul>
		<li><strong>Nombre:</strong> ' . htmlspecialchars($card['TITULO']) . '</li>
		<li><strong>Uso:</strong> ' . htmlspecialchars($card['USO']) . '</li>
		<li><strong>Ojetivos:</strong> ' . htmlspecialchars($card['OBJETIVOS']) . '</li>
		<li><strong>Período:</strong> ' . htmlspecialchars($data['FECHA_INICIO']) . ' - ' . htmlspecialchars($data['FECHA_FINAL']) . '</li>
		<li><strong>Diseño:</strong> ' . htmlspecialchars($card['DISENO_ESTUDIO']) . '</li>
		<li><strong>Población:</strong> ' . htmlspecialchars($card['POBLACION']) . '</li>
		<li><strong>Enfermedad o síntoma:</strong> ' . (!empty($iRow['ENFERMEDAD']) ? htmlspecialchars($iRow['ENFERMEDAD']) : 'No indicado') . '</li>
		<li><strong>Modo de administración:</strong> ' . htmlspecialchars($card['MODO_ADMIN']) . '</li>
		<li><strong>Soporte técnico:</strong> ' . htmlspecialchars($card['SOPORTE_TECNICO']) . '</li>
	</ul>
	<h5>Datos de facturación</h5>
	<ul>
		<li><strong>Razón social:</strong> ' . (!empty($card['FACTURACION_NOMBRE']) ? htmlspecialchars($card['FACTURACION_NOMBRE']) : 'No indicado') . '</li>
		<li><strong>CIF:</strong> ' . (!empty($card['FACTURACION_CIF']) ? htmlspecialchars($card['FACTURACION_CIF']) : 'No indicado') . '</li>
		<li><strong>Dirección:</strong> ' . (!empty($card['FACTURACION_DIRECCION']) ? htmlspecialchars($card['FACTURACION_DIRECCION']) : 'No indicado') . '</li>
		<li><strong>Código postal:</strong> ' . (!empty($card['FACTURACION_CP']) ? htmlspecialchars($card['FACTURACION_CP']) : 'No indicado') . '</li>
		<li><strong>Población:</strong> ' . (!empty($card['FACTURACION_CIUDAD']) ? htmlspecialchars($card['FACTURACION_CIUDAD']) : 'No indicado') . '</li>
		<li><strong>País:</strong> ' . (!empty($iRow['PAIS_FACTURACIO']) ? htmlspecialchars($iRow['PAIS_FACTURACIO']) : 'No indicado') . '</li>
		<li><strong>Teléfono:</strong> ' . (!empty($card['FACTURACION_TELEFONO']) ? htmlspecialchars($card['FACTURACION_TELEFONO']) : 'No indicado') . '</li>
		<li><strong>Correo electrónico:</strong> ' . (!empty($card['FACTURACION_EMAIL']) ? htmlspecialchars($card['FACTURACION_EMAIL']) : 'No indicado') . '</li>
	</ul>
	<nobreak>
		<h5>Condiciones de la sublicencia</h5>
		' . $sublicenceRow['TEXTO_ACEPTACION'] . '
	</nobreak>
</page>';

		// generem i gravem el fitxer PDF
		require_once('html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','es');
		$html2pdf->WriteHTML($markup);
		$html2pdf->Output($pdfFilePath, 'F');

	}
	// si l'estat no és atorgada, esborrem el pdf en cas que existeixi
	else {

		if (is_file($pdfFilePath)) {

			@unlink($pdfFilePath);

		}

	}

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
		or $card['OTORGADA'] != $_POST['OTORGADA']
		or $card['FECHA_VALIDEZ'] != $_POST['FECHA_VALIDEZ']
	) {

		// obtenim email usuari, nom qüetionari i tipus descarregable
		$iQuery = db_query("
			SELECT
				`$USERS_TABLE`.EMAIL AS EMAIL,
				`$QUESTIONNAIRES_TABLE`.NOM_CAST AS NOM_CAST,
				`$QUESTIONNAIRES_TABLE`.EMAILS AS EMAILS
			FROM
				`$USERS_TABLE`,
				`$QUESTIONNAIRES_TABLE`
			WHERE
				`$USERS_TABLE`.ID = $card[ID_USUARIO]
				AND `$QUESTIONNAIRES_TABLE`.ID = $card[ID_CUEST]
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
		<h1>BiblioPRO: Estado de la sublicencia solicitada</h1>
		<hr />
		<h2>El estado de la sublicencia del cuestionario <em>' . $iRow['NOM_CAST'] . '</em> ha cambiado.</h2>
		<p>Cambios realizados:</p>
		<ul>
			' . (($card['OTORGADA'] != $_POST['OTORGADA']) ? '<li>Otorgamiento: <strong>' . $atorgada[$_POST['OTORGADA']] . '</strong></li>' : '') . '
			' . (($card['STATUS'] != $_POST['STATUS']) ? '<li>Estado: <strong>' . $status[$_POST['STATUS']] . '</strong></li>' : '') . '
			' . (($card['FECHA_VALIDEZ'] != $_POST['FECHA_VALIDEZ']) ? '<li>Fecha de validez: <strong>' . date('d-m-Y \a \l\a\s H:i:s', strtotime($_POST['FECHA_VALIDEZ'])) . '</strong></li>' : '') . '
		</ul>
		<p>Para más información, por favor, consulte <strong>Mi BiblioPRO</strong> en el apartado de <strong>Mis Sublicencias</strong></p>
	</body>
</html>';
		$destinatari = $iRow['EMAIL'];
		$from = '"BiblioPRO" <bibliopro@imim.es>';
		$assumpte = 'Modificación de sublicencia en BiblioPRO';
		if (is_file($pdfFilePath)) {
			$adjunt[0]['path'] = $pdfFilePath;
			$adjunt[0]['value'] = $card['NUM_ALBARAN'] . '.pdf';
		}
		else {
			$adjunt = null;
		}
		// enviem el correu a l'usuari
		@sendMail($destinatari, $assumpte, $cos, $from, $adjunt, true);
		// si l'adreça de facturació és diferent, també li enviem
		if ($card['FACTURACION_EMAIL'] != $destinatari and isValidEmail($card['FACTURACION_EMAIL'])) {
			@sendMail($card['FACTURACION_EMAIL'], $assumpte, $cos, $from, $adjunt, true);
		}
		// enviem correus addicionals a les adreces indicades al qüestionari
		if (!empty($iRow['EMAILS'])) {
			$emails = explode(',', $iRow['EMAILS']);
			if (count($emails) > 0) {
				foreach ($emails as $email) {
					$temail = trim($email);
					if (isValidEmail($temail)) {
						@sendMail($temail, $assumpte, $cos, $from, $adjunt, true);
					}
				}
			}
		}

	}

	// -----------
	// REDIRECTION
	// -----------
	// Return URL

	//insertar registre d'accions
	register_add("Subllicència actualitzada", $ID);
	//fi

	goto_url('index.php');

?>
