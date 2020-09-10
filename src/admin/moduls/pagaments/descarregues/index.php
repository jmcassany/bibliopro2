<?php

	require('../../../config_admin.inc');
	accessGroupPermCheck('pagaments');

	require('descarregues.php');

	// cerca
	if (!empty($cerca)) {
		$cerca = addslashes($cerca);
		$CARDS_LISTFILTER .= " AND (
			NOM_ORIGINAL_CUEST LIKE '%$nom%'
			OR NOM_CAST_CUEST LIKE '%$nom%'
			OR SIGLAS_CUEST LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_EMAIL LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_NOMBRE LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_CIF LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_DIRECCION LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_CP LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_CIUDAD LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_OTRO_PAIS LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_TELEFONO LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_FAX LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR ID_TPV LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR NUM_ALBARAN LIKE '%" . mysql_real_escape_string($cerca) . "%'
		)";
	}
	// autor
	if (!empty($autor)) {
		$autor = addslashes($autor);
		$CARDS_LISTFILTER .= " AND (IDAUTORES_ORIGINAL_CUEST LIKE '%\"$autor\"%' OR IDAUTORES_CAST_CUEST LIKE '%\"$autor\"%')";
	}
	// usuari
	if (!empty($user)) {
		$user = addslashes($user);
		$CARDS_LISTFILTER .= " AND ID_USUARIO = '$user'";
	}
	// estat
	if ($estat != '') {
		$estat = addslashes($estat);
		$CARDS_LISTFILTER .= " AND STATUS = '$estat'";
	}
	// forma pagament
	if (!empty($pagament)) {
		$pagament = addslashes($pagament);
		$CARDS_LISTFILTER .= " AND METODO_PAGO = '$pagament'";
	}
	// interval data validesa
	if (!empty($data_subl_desde) and !empty($data_subl_fins)) {
		$CARDS_LISTFILTER .= " AND (
			FECHA_COBRO != '0000-00-00 00:00:00'
			AND FECHA_COBRO <= '$data_subl_desde'
			AND FECHA_VALIDEZ >= '$data_subl_fins'
		)";
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
	$dbCards = new dbCards($CARDS_TABLE);
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }

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

	// NAVEGATION DATA ==================================================
	function getPageLink($page)
	{

		global
			$ordenar,
			$cerca,
			$autor,
			$user,
			$estat,
			$pagament,
			$data_subl_desde,
			$data_subl_fins,
			$facturat,
			$PAGE;

		$urlcerca = $urlautor = $urluser = $urlestat = $urlpagament = '';
		if (!empty($cerca)) { $urlcerca = '&cerca='.$cerca; }
		if (!empty($autor)) { $urlautor = '&autor='.$autor; }
		if (!empty($user)) { $urluser = '&user='.$user; }
		if ($estat != '') { $urlestat = '&estat='.urlencode($estat); }
		if (!empty($pagament)) { $urlpagament = '&pagament='.$pagament; }
		if (!empty($data_subl_desde) and !empty($data_subl_fins)) {
			$urldates = '&data_subl_desde='.urlencode($data_subl_desde).'&data_subl_fins='.urlencode($data_subl_fins);
		}
		if ($facturat != '') { $urlfacturat = '&facturat='.urlencode($facturat); }

		return "index.php?ordenar=$ordenar&PAGE=$page"
			. $urlcerca
			. $urlautor
			. $urluser
			. $urlestat
			. $urlpagament
			. $urlfacturat
			. $urldates;

	}

	// Acotem $PAGE
	$pagemin=1;
	if ($PAGE<$pagemin){ $PAGE=$pagemin; }

	$pagemax=$dbCards->countCardPages($CATEGORY1,$CATEGORY2);
	if ($PAGE>$pagemax) { $PAGE=$pagemax; }

	$data['PAGE']=$PAGE;
	$data['PMAX']=$pagemax;

	// Next page link
	$pagenext=$PAGE+1;
	if ($pagenext>$pagemax) { $data['PAGENEXT']=$CARDS_LISTPAGENEXT; }
	else { $data['PAGENEXT']="<A HREF='".getPageLink($pagenext)."'>$CARDS_LISTPAGENEXT</A>"; }

	// Previous page link
	$pageprev=$PAGE-1;
	if ($pageprev<$pagemin) { $data['PAGEPREV']=$CARDS_LISTPAGEPREV; }
	else { $data['PAGEPREV']="<A HREF='".getPageLink($pageprev)."'>$CARDS_LISTPAGEPREV</A>"; }

	// List Page links
	$dec=floor(($PAGE-1)/$CARDS_LISTSKIP);
	$decmax=floor(($pagemax-1)/$CARDS_LISTSKIP);
	$min=1+($dec*$CARDS_LISTSKIP);
	$max=$min+$CARDS_LISTSKIP-1;      if ($max>$pagemax)       { $max=$pagemax; }
	$skipright=$PAGE+$CARDS_LISTSKIP; if ($skipright>$pagemax) { $skipright=$pagemax; }
	$skipleft=$PAGE-$CARDS_LISTSKIP;  if ($skipleft<1)         { $skipleft=1; }

	$pagelist=' ';

	if ($dec>0) { $pagelist.="<A HREF='".getPageLink($skipleft)."'>...</A> "; }
	for ($i=$min; $i<=$max; $i++)
	{
		 if ($i==$PAGE) { $pagelist.=" <b>$i</b>"; }
		 else           { $pagelist.=" <A HREF='".getPageLink($i)."'>$i</A>"; }
	}
	if ($dec<$decmax) { $pagelist.=" <A HREF='".getPageLink($skipright)."'>...</A>"; }

	$data['PAGELIST']=$pagelist.' ';

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
		$data['COLOR2']="#DEDEDE";
		$data['ICO2']="<img src=\"../../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "data"){
		$CARDS_LISTSORTBY = "FECHA_SOLICITUD $ordre, STATUS ASC";
		$data['COLOR1']="#DEDEDE";
		$data['ICO1']="<img src=\"../../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "status"){
		$CARDS_LISTSORTBY = "STATUS $ordre, FECHA_SOLICITUD ASC";
		$data['COLOR2']="#DEDEDE";
		$data['ICO2']="<img src=\"../../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") { $ordre = "ASC"; }
		else { $ordre = "DESC"; }
	}
	if ($ordenar == "usuario"){
		$CARDS_LISTSORTBY = "ID_USUARIO $ordre, STATUS ASC, FECHA_SOLICITUD ASC";
		$data['COLOR3']="#DEDEDE";
		$data['ICO3']="<img src=\"../../../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
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

	$data['CERCA_PARAMS'] = 'e=1';
	if (!empty($cerca)) { $data['CERCA_PARAMS'] .= '&cerca='.urlencode($cerca); }
	if (!empty($autor)) { $data['CERCA_PARAMS'] .= '&autor='.urlencode($autor); }
	if (!empty($user)) { $data['CERCA_PARAMS'] .= '&user='.urlencode($user); }
	if (!empty($estat)) { $data['CERCA_PARAMS'] .= '&estat='.urlencode($estat); }
	if (!empty($pagament)) { $data['CERCA_PARAMS'] .= '&pagament='.urlencode($pagament); }
	if (!empty($data_subl_desde) and !empty($data_subl_fins)) {
		$data['CERCA_PARAMS'] .= '&data_subl_desde='.urlencode($data_subl_desde).'&data_subl_fins='.urlencode($data_subl_fins);
	}

	$data['SELECT_AUTORS'] = '<select name="autor" id="autor"><option value="">Seleccionar autor</option>';
	$authorsQuery = db_query("SELECT NOM, ID FROM `$AUTHORS_TABLE` ORDER BY NOM ASC");
	while ($authorRow = db_fetch_array($authorsQuery)) {
		$data['SELECT_AUTORS'] .= '<option value="' . htmlspecialchars($authorRow['ID']) . '">' . htmlspecialchars($authorRow['NOM']) . '</option>';
	}
	$data['SELECT_AUTORS'] .= '</select>';

	$data['SELECT_USUARIS'] = '<select name="user" id="user"><option value="">Seleccionar usuari</option>';
	$usersQuery = db_query("SELECT NOMBRE, ID FROM `$USERS_TABLE` ORDER BY NOMBRE ASC");
	while ($userRow = db_fetch_array($usersQuery)) {
		$data['SELECT_USUARIS'] .= '<option value="' . htmlspecialchars($userRow['ID']) . '">' . htmlspecialchars($userRow['NOMBRE']) . '</option>';
	}
	$data['SELECT_USUARIS'] .= '</select>';

	// OUTPUT HEAD =====================================================
	$cards = $dbCards->listCards();//llegim el total de registres sense paginar
	$data['N']=0;
	$total = count($cards);
	$data['TOTAL'] = $total;

	//CODI HTML CAPCELERA
	$data['CAPCELERA'] = htmlHeader();

	if (
		!empty($cerca) or
		!empty($autor) or
		!empty($user) or
		!empty($pagament) or
		(!empty($data_subl_desde) and !empty($data_subl_fins)) or
		(
			isset($facturat)
			and (
				$facturat == '0'
				or $facturat == '1'
			)
		) or
		$estat != ''
	) {
		$c = '<ul>';
		if (!empty($cerca)) { $c .= "<li>Text: <strong>$cerca</strong></li>"; }
		if (!empty($autor)) { $c .= "<li>Autor: <strong>$autor</strong></li>"; }
		if (!empty($user)) { $c .= "<li>Usuari: <strong>$user</strong></li>"; }
		if (!empty($pagament)) { $c .= "<li>Mètode pagament: <strong>$pagament</strong></li>"; }
		if (!empty($data_subl_desde) and !empty($data_subl_fins)) {
			$c .= "<li>Data validesa: Del <strong>$data_subl_desde</strong> al <strong>$data_subl_fins</strong></li>";
		}
		if (isset($facturat)) {
			if ($facturat == '0') {
				$c .= "<li>Facturat: <strong>No</strong></li>";
			}
			if ($facturat == '1') {
				$c .= "<li>Facturat: <strong>Sí</strong></li>";
			}
		}
		if ($estat != '') { $c .= "<li>Estat: <strong>$estat</strong></li>"; }
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

	echo $Tpl->mergeBlock('HEAD',$data);

	// READ DATA =======================================================

	for ($i=0; $i<$total; $i++)
	{
		$data['N'] = 1 + $i + ($PAGE-1)*$CARDS_LISTLENGTH;

		foreach ($cards[$i] as $name=>$value)
		{
			 // Les dades en brut de tots els camps
			 $data[$name] = strip_tags($value);

			 // Filtrem només els camps definits
			 if (!isset($CARDS_FIELDS[$name])) { continue; }
			 $type = $CARDS_FIELDS[$name][1];

			 // Generem les ampliades dels tipus necesaris
					if ($type=='NUMBER') { $data = $dbCards->GenerateData($data, $name, $value); }
			 else if ($type=='DATE')   { $data = $dbCards->GenerateData($data, $name, $value); }
			 else if ($type=='FLAG')   { $data = $dbCards->GenerateData($data, $name, $value); }
			 else if ($type=='ITEM')   { $data = $dbCards->GenerateData($data, $name, $value); }
			 else if ($type=='CHAR')   { $data = $dbCards->GenerateData($data, $name, $value); }
			 else if ($type=='TEXT')   { $data = $dbCards->GenerateData($data, $name, $value); }
			 else if ($type=='FILE')   { $data = $dbCards->GenerateData($data, $name, $value); }
			 else if ($type=='IMAGE')  { $data = $dbCards->GenerateData($data, $name, $value); }
		}

		// obtenim nom usuari, tipus descarregable i nom qüestionari
		$infoQuery = db_query("
			SELECT
				`$USERS_TABLE`.NOMBRE AS USUARIO,
				`$QUESTIONNAIRES_TABLE`.NOM_CAST AS NOM_CAST,
				`$DOWNLOADS_TABLE`.TIPO AS TIPO_DESC
			FROM
				`$USERS_TABLE`,
				`$QUESTIONNAIRES_TABLE`,
				`$DOWNLOADS_TABLE`
			WHERE
				`$USERS_TABLE`.ID = $data[ID_USUARIO]
				AND `$QUESTIONNAIRES_TABLE`.ID = $data[ID_CUEST]
				AND `$DOWNLOADS_TABLE`.ID = $data[ID_DESCARGABLE]
		");
		$infoRow = db_fetch_array($infoQuery);

		$data['USUARIO'] = $infoRow['USUARIO'];
		$data['DESCARGABLE'] = $TIPOS[$infoRow['TIPO_DESC']] . ' de ' . htmlspecialchars($infoRow['NOM_CAST']);

		if ($data['STATUS'] == 1) {
			$data['STATUS'] = 'Activa';
			$data['COLOR'] = 'c6e0c2';
		}
		else {
			$data['STATUS'] = 'Inactiva';
			$data['COLOR'] = 'e0dfc2';
		}

		if (isset($data['TOTAL'])) {
			$data['IMPORT'] = htmlspecialchars($data['TOTAL']);
		}
		else {
			$data['IMPORT'] = 'Desconegut';
		}

		// OUTPUT ROW =====================================================

		echo $Tpl->mergeBlock('ROW',$data);
	}

	$data['CATEGORY1'] = $CATEGORY1;
	$data['CATEGORY1_X'] = ITEMS_GetValue( 'CARDS_CATEGORY1', $CATEGORY1, $LANG );

	$data['CATEGORY2'] = $CATEGORY2;
	$data['CATEGORY2_X'] = ITEMS_GetValue( 'CARDS_CATEGORY2', $CATEGORY2, $LANG );

	// OUTPUT FOOT =====================================================
	//CODI HTML PEU
	$data['PEU'] = htmlFoot();
	echo $Tpl->mergeBlock('FOOT',$data);

?>