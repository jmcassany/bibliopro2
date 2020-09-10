<?php

	require('../../config_admin.inc');
	accessGroupPermCheck('pagaments');

	require('pagaments.php');

	// cerca
	if (!empty($cerca)) {
		$cerca = addslashes($cerca);
		$CARDS_LISTFILTER .= " AND (
			FACTURACION_EMAIL LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_NOMBRE LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_CIF LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_DIRECCION LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_CIUDAD LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_OTRO_PAIS LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_TELEFONO LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR TOTAL LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR NUM_ALBARAN LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FECHA_SOLICITUD LIKE '%" . mysql_real_escape_string($cerca) . "%'
		)";
	}
	// usuari
	if (!empty($user)) {
		$user = addslashes($user);
		$CARDS_LISTFILTER .= " AND ID_USUARIO = '$user'";
	}
	// forma pagament
	if (!empty($pagament)) {
		$pagament = addslashes($pagament);
		$CARDS_LISTFILTER .= " AND METODO_PAGO = '$pagament'";
	}
	// facturat?
	if (isset($facturat)) {
		$facturat = addslashes($facturat);
		if ($facturat == '1') {
			$CARDS_LISTFILTER .= " AND FACTURA != ''";
		}
		if ($facturat == '0') {
			$CARDS_LISTFILTER .= " AND FACTURA = ''";
		}
	}

	// --------------------
	// PARAMETERS FILTERING
	// --------------------
	if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
	if (empty($ECLASS)) { $ECLASS = $DEFAULT_ECLASS; }
	$SKIN = $DEFAULT_SKIN;

	if (empty($PAGE))      { $PAGE = '1'; } // Primera pagina
	if (empty($MODE))      { $MODE = '0'; } // Mode[0]='Zebra', Mode[1]='Skin'
	if (empty($CATEGORY1)) { $CATEGORY1 = ''; } // No filtre CATEGORY1
	if (empty($CATEGORY2)) { $CATEGORY2 = ''; } // No filtre CATEGORY2

	// ------------------
	// CARDS INSTANTATION
	// ------------------
	$downloadsCards = new dbCards($DOWNLOADS_TABLE);
	$sublicencesCards = new dbCards($SUBLICENCES_TABLE);
	$subscriptionsCards = new dbCards($SUBSCRIPTIONS_TABLE);
	$donationsCards = new dbCards($DONATIONS_TABLE);
	if (
		!$downloadsCards->Ok
		or !$sublicencesCards->Ok
		or !$subscriptionsCards->Ok
		or !$donationsCards->Ok
	) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }

	// -----------------
	// TEMPLATE SCANNING
	// -----------------
	// Create and define Template
	$Tpl = new awTemplate();
	$Tpl->scanFile("index.tpl");

	// Si hi ha cap problema -> Error
	if (!$Tpl->Ok) { echo "<B>Error: No se ha encontrado la plantilla 'list.tpl'.</B><br>\n"; exit; }

	// ------------------
	// CONTENT MERGING
	// ------------------
	unset($data);

	// ORDRE
	$ordenar = '';
	if (isset($_GET['ordenar'])) {
		$ordenar = $_GET['ordenar'];
	}
	$ordre = 'ASC';
	if (isset($_GET['ordre'])) {
	  $ordre = $_GET['ordre'];
	}
	if ($ordenar == ""){
		$data['COLOR1']="#DEDEDE";
		$data['ICO1']="<img src=\"../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "data"){
		$CARDS_LISTSORTBY = "FECHA_SOLICITUD $ordre, ID_USUARIO ASC";
		$data['COLOR1']="#DEDEDE";
		$data['ICO1']="<img src=\"../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "usuario"){
		$CARDS_LISTSORTBY = "ID_USUARIO $ordre, FECHA_SOLICITUD ASC";
		$data['COLOR2']="#DEDEDE";
		$data['ICO2']="<img src=\"../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "tipus"){
		//$CARDS_LISTSORTBY = "TIPO $ordre, ID_USUARIO ASC";
		$data['COLOR3']="#DEDEDE";
		$data['ICO3']="<img src=\"../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "import"){
		$CARDS_LISTSORTBY = "TOTAL $ordre, ID_USUARIO ASC";
		$data['COLOR4']="#DEDEDE";
		$data['ICO4']="<img src=\"../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "albara"){
		$CARDS_LISTSORTBY = "NUM_ALBARAN $ordre, ID_USUARIO ASC";
		$data['COLOR51']="#DEDEDE";
		$data['ICO5']="<img src=\"../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "estat"){
		$CARDS_LISTSORTBY = "STATUS $ordre, ID_USUARIO ASC";
		$data['COLOR6']="#DEDEDE";
		$data['ICO6']="<img src=\"../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "cobrament"){
		$CARDS_LISTSORTBY = "FECHA_COBRO $ordre, ID_USUARIO ASC";
		$data['COLOR7']="#DEDEDE";
		$data['ICO7']="<img src=\"../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "facturat"){
		$CARDS_LISTSORTBY = "FACTURA $ordre, ID_USUARIO ASC";
		$data['COLOR8']="#DEDEDE";
		$data['ICO8']="<img src=\"../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	$data['ORDRE'] = $ordre;
	//fi ordenar dades

	$data['METAS'] = htmlMetas();

	// GENERAL DATA HEAD =================================================
	$data['LANG'] = $LANG;
	$data['ECLASS'] = $ECLASS;
	$data['ECLASS_X'] = ITEMS_GetValue( 'CARDS_ECLASS', $ECLASS, $LANG );

	$data['CATEGORY1'] = $CATEGORY1;
	$data['CATEGORY1_X'] = ITEMS_GetValue( 'CARDS_CATEGORY1', $CATEGORY1, $LANG );

	$data['CATEGORY2'] = $CATEGORY2;
	$data['CATEGORY2_X'] = ITEMS_GetValue( 'CARDS_CATEGORY2', $CATEGORY2, $LANG );

	$data['CATEGORY'] = ''; $data['CATEGORY_X'] = '';
	if (($CATEGORY1=='') && ($CATEGORY2!='')) {
		$data['CATEGORY']   = $data['CATEGORY2'];
		$data['CATEGORY_X'] = $data['CATEGORY2_X'];
	}
	if (($CATEGORY1!='') && ($CATEGORY2=='')) {
		$data['CATEGORY']   = $data['CATEGORY1'];
		$data['CATEGORY_X'] = $data['CATEGORY1_X'];
	}

  $data['CONFIG_URLADMIN'] = $CONFIG_URLADMIN;

	$data['SELECT_USUARIS'] = '<select name="user" id="user"><option value="">Seleccionar usuari</option>';
	$usersQuery = db_query("SELECT NOMBRE, ID FROM `$USERS_TABLE` ORDER BY NOMBRE ASC");
	while ($userRow = db_fetch_array($usersQuery)) {
		$data['SELECT_USUARIS'] .= '<option value="' . htmlspecialchars($userRow['ID']) . '">' . htmlspecialchars($userRow['NOMBRE']) . '</option>';
	}
	$data['SELECT_USUARIS'] .= '</select>';

	// OUTPUT HEAD =====================================================
	// subscriptions
	$filter = $CARDS_LISTFILTER;
	if (!empty($data_cobrament_desde) and !empty($data_cobrament_fins)) {
		$CARDS_LISTFILTER .= " AND (
			FECHA_ACTIVACION >= '" . mysql_real_escape_string($data_cobrament_desde) . "'
			AND FECHA_ACTIVACION <= '" . mysql_real_escape_string($data_cobrament_fins) . "'
		)";
	}
	$subscriptions = $subscriptionsCards->listCards();
	// downloads
	if (!empty($data_cobrament_desde) and !empty($data_cobrament_fins)) {
		$CARDS_LISTFILTER = $filter . " AND (
			FECHA_COBRO >= '" . mysql_real_escape_string($data_cobrament_desde) . "'
			AND FECHA_COBRO <= '" . mysql_real_escape_string($data_cobrament_fins) . "'
		)";
	}
	$downloads = $downloadsCards->listCards();
	// sublicences
	$sublicences = $sublicencesCards->listCards();
	// donations
	$donations = $donationsCards->listCards();
	// afegim índex per indicar el tipus de pagament
	if (is_array($downloads) and count($downloads) > 0) {
		for ($j = 0; $j < count($downloads); $j++) {

			$downloads[$j]['TIPO'] = 'Descàrrega';
			$downloads[$j]['LINK_TO_VIEW'] = $CONFIG_URLADMIN . '/moduls/pagaments/descarregues/view.php?ID=';

		}
	}
	if (is_array($sublicences) and count($sublicences) > 0) {
		for ($j = 0; $j < count($sublicences); $j++) {

			$sublicences[$j]['TIPO'] = 'Subllicència';
			$sublicences[$j]['LINK_TO_VIEW'] = $CONFIG_URLADMIN . '/moduls/pagaments/subllicencies/view.php?ID=';

		}
	}
	if (is_array($subscriptions) and count($subscriptions) > 0) {
		for ($j = 0; $j < count($subscriptions); $j++) {

			$subscriptions[$j]['TIPO'] = 'Subscripció';
			$subscriptions[$j]['LINK_TO_VIEW'] = $CONFIG_URLADMIN . '/moduls/questionaris/usuaris/subscripcions/view.php?ID=';

		}
	}
	if (is_array($donations) and count($donations) > 0) {
		for ($j = 0; $j < count($donations); $j++) {

			$donations[$j]['TIPO'] = 'Donació';
			$donations[$j]['LINK_TO_VIEW'] = $CONFIG_URLADMIN . '/moduls/pagaments/donacions/view.php?ID=';

		}
	}
	$cards = array_merge($downloads, $sublicences, $subscriptions, $donations); // llegim el total de registres

	$data['N'] = 0;
	$total = count($cards);
	$data['TOTAL'] = $total;

	//CODI HTML CAPCELERA
	$data['CAPCELERA'] = htmlHeader();

	if (
		!empty($cerca)
		or !empty($user)
		or !empty($pagament)
		or (
			isset($facturat)
			and (
				$facturat == '0'
				or $facturat == '1'
			)
		)
		or (
			!empty($data_cobrament_desde)
			and !empty($data_cobrament_fins)
		)
	) {
		$c = '<ul>';
		if (!empty($cerca)) { $c .= "<li>Text: <strong>$cerca</strong></li>"; }
		if (!empty($user)) { $c .= "<li>Usuari: <strong>$user</strong></li>"; }
		if (!empty($pagament)) { $c .= "<li>Mètode pagament: <strong>$pagament</strong></li>"; }
		if (isset($facturat)) {
			if ($facturat == '0') {
				$c .= "<li>Facturat: <strong>No</strong></li>";
			}
			if ($facturat == '1') {
				$c .= "<li>Facturat: <strong>Sí</strong></li>";
			}
		}
		if (!empty($data_cobrament_desde) and !empty($data_cobrament_fins)) {
			$c .= "<li>Cobrat entre: <strong>$data_cobrament_desde</strong> - <strong>$data_cobrament_fins</strong></li>";
		}
		$c .= '</ul>';
		if ($total == 0) {
			$data['RESULTAT'] = "<tr>
					<td class=\"text10\" colspan=\"2\" style=\"padding: 5px 10px;\">Cercant: $c</td>
				</tr>
				<tr>
					<td class=\"grana\" colspan=\"2\" style=\"padding: 5px 10px;\">
						<img src=\"".$CONFIG_URLADMIN."/comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Error\" border=\"0\" align=\"absmiddle\">&nbsp;<strong>No s'ha trobat cap coincidència</strong><br><br><a href=\"javascript:history.back();\" ><b><< Tornar</b></a>
					</td>
				</tr>";
		}
		else {
			$data['RESULTAT']="<tr>
					<td class=\"text10\" colspan=\"2\" style=\"padding: 5px\">Cercant: $c</td>
				</tr>";
		}
	}

	// link subscripcions
	if (accessGroupPerm('questionaris')) {
		$data['LINK_SUBSCRIPCIONS'] = '<a href="../questionaris/usuaris/subscripcions/index.php"><img src="' . $CONFIG_URLADMIN . '/comu/questionaris/icona-subscripcions.gif" alt="Subscripcions" border="0" align="absmiddle" /></a> <a href="../questionaris/usuaris/subscripcions/index.php">Subscripcions</a>&nbsp;&nbsp;&nbsp;';
	}
	else {
		$data['LINK_SUBSCRIPCIONS'] = '';
	}

	echo $Tpl->mergeBlock('HEAD',$data);

	// per les entrades no pendents, que es mostren al final
	$rest = array();

	// READ DATA =======================================================
	for ($i = 0; $i < $total; $i++) {

		// assegurem que el camps no estiguin on no cal
		unset($data['OTORGADA']);
		unset($data['TOTAL']);
		foreach ($cards[$i] as $name => $value) {


			// Les dades en brut de tots els camps
			$data[$name] = strip_tags($value);

			// Filtrem només els camps definits
			if (!isset($CARDS_FIELDS[$name])) { continue; }
			$type = $CARDS_FIELDS[$name][1];

			// Generem les ampliades dels tipus necesaris
			if ($type=='NUMBER') { $data = $downloadsCards->GenerateData($data, $name, $value); }
			else if ($type=='DATE')   { $data = $downloadsCards->GenerateData($data, $name, $value); }
			else if ($type=='FLAG')   { $data = $downloadsCards->GenerateData($data, $name, $value); }
			else if ($type=='ITEM')   { $data = $downloadsCards->GenerateData($data, $name, $value); }
			else if ($type=='CHAR')   { $data = $downloadsCards->GenerateData($data, $name, $value); }
			else if ($type=='TEXT')   { $data = $downloadsCards->GenerateData($data, $name, $value); }
			else if ($type=='FILE')   { $data = $downloadsCards->GenerateData($data, $name, $value); }
			else if ($type=='IMAGE')  { $data = $downloadsCards->GenerateData($data, $name, $value); }

		}

		// obtenim nom usuari
		$infoQuery = db_query("
			SELECT
				NOMBRE AS USUARIO
			FROM
				`$USERS_TABLE`
			WHERE
				ID = $data[ID_USUARIO]
		");
		$infoRow = db_fetch_array($infoQuery);

		$data['USUARIO'] = $infoRow['USUARIO'];

// 		if (isset($data['OTORGADA'])) {
//
// 			switch($data['OTORGADA']) {
// 				case 0:
// 					$data['STATUS_LABEL'] = 'Pendent';
// 					$data['COLOR'] = 'e0dfc2';
// 					break;
// 				case 1:
// 					$data['STATUS_LABEL'] = 'Pendent tercers';
// 					$data['COLOR'] = 'e0d7c2';
// 					break;
// 				case 2:
// 					$data['STATUS_LABEL'] = 'Otorgada';
// 					$data['COLOR'] = 'c6e0c2';
// 					break;
// 				case 3:
// 					$data['STATUS_LABEL'] = 'Denegada';
// 					$data['COLOR'] = 'e0c2c2';
// 					break;
// 				default:
// 					$data['STATUS_LABEL'] = 'Desconegut';
// 					$data['COLOR'] = 'fff';
// 					break;
// 			}
//
// 		}
// 		else {

			if ($data['STATUS'] == 1) {
				$data['STATUS_LABEL'] = 'Activa';
				$data['COLOR'] = 'c6e0c2';
			}
			else {
				$data['STATUS_LABEL'] = 'Inactiva';
				$data['COLOR'] = 'e0dfc2';
			}

// 		}

		if (!isset($data['FECHA_COBRO'])) {

			if (!empty($data['FECHA_ACTIVACION']) and $data['FECHA_ACTIVACION'] != '0000-00-00 00:00:00') {

				$data['FECHA_COBRO'] = $data['FECHA_ACTIVACION'];

			}
			else {

				$data['FECHA_COBRO'] = '-';

			}

		}
		else {

			if ($data['FECHA_COBRO'] == '0000-00-00 00:00:00') {

				$data['FECHA_COBRO'] = '-';

			}

		}

		if (!empty($data['SOLICITA_FACTURA'])) {

			$data['SOLICITA_FACTURA'] = 'Sí';

		}
		else {

			$data['SOLICITA_FACTURA'] = 'No';

		}

		if (!empty($data['FACTURA'])) {

			$data['FACTURAT'] = 'Sí';

		}
		else {

			$data['FACTURAT'] = 'No';

		}

		if (isset($data['TOTAL'])) {
			$data['IMPORT'] = htmlspecialchars($data['TOTAL']);
		}
		else {
			$data['IMPORT'] = 'Desconegut';
		}

		// OUTPUT ROW =====================================================
		// mostrem primer les pendents
		if (isset($data['OTORGADA'])) {

			if ($data['OTORGADA'] == 0 or $data['OTORGADA'] == 1) {

				echo $Tpl->mergeBlock('ROW',$data);

			}
			else {

				$rest[] = $data;

			}

		}
		else {

			if ($data['STATUS'] == 0) {

				echo $Tpl->mergeBlock('ROW',$data);

			}
			else {

				$rest[] = $data;

			}

		}

	}

	if (count($rest) > 0) {

		foreach ($rest as $restData) {

			echo $Tpl->mergeBlock('ROW',$restData);

		}

	}

	// OUTPUT FOOT =====================================================
	//CODI HTML PEU
	$data['PEU'] = htmlFoot();
	echo $Tpl->mergeBlock('FOOT', $data);

?>