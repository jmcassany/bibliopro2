<?php

$CONFIG_PATHPHP = '../../../../media/php';
require ('../../../config_admin.inc');
accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes

$CONFIG_PATHCAMPANYES = '../';
require_once($CONFIG_PATHCAMPANYES.'config.inc');

	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'cripto.inc');

   tractament();


function tractament() {
	global $db, $CFG_CAMPANYES, $ID, $LOGIN;
	global $CRIPTO_KEY,	$CRIPTO_SEPAR, $CRIPTO_CHECK;

	$Tpl_modul = new awTemplate();
	$Tpl_modul->scanFile('destinataris_ca.tpl');
	if (!$Tpl_modul->Ok) { htmlPageBasicError(t("plantillanotrobada")); }
	
	unset($bl);
  $bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
  $bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

	$ID = trim(stripslashes(obte_postget('id')));
	$accio = trim(stripslashes(obte_postget('accio')));

	$wh_noadmin = " AND IdUsu='$LOGIN'";
	$result5 = $db->sql_query("SELECT * FROM news_CAMPANYES WHERE IdCam = '$ID'".$wh_noadmin);
	if ($db->sql_numrows($result5) == 0) {
		htmlPageError('Campanya no accessible!');
	}
	$row5 = $db->sql_fetchrow($result5);
	$bl['ID'] = $row5['IdCam'];

		$bl['TITOL'] = filtreQuote($row5['titol']);
		$bl['SUBJECT'] = filtreQuote($row5['subject']);
		$bl['NOM'] = filtreQuote($row5['from_name']);
		$bl['EMAIL'] = filtreQuote($row5['from_email']);
		$bl['EMAIL_REPLY'] = filtreQuote($row5['reply_to']);
		$bl['REPLY_TO'] = ($row5['reply_to']=='') ? '' : ' ('.filtreQuote($row5['reply_to']).')';
  	$bl['D_ENVIAMENT'] = data_bd2fmt($row5['dh_inici']);


	// LLISTAT DELS SUBSCRIPTORS
		$estat = intval(obte_postget('estat', -1));
		$cerca = trim(stripslashes(obte_postget('cerca')));
		$ordenar = trim(stripslashes(obte_postget('ordenar')));
		$ordre = trim(stripslashes(obte_postget('ordre', 'ASC')));
		$pag = intval(obte_postget('pag', 1));
	
    	$sel = ($estat==-1) ? ' selected="selected"' : '';
			$bl['OPTS_ESTAT'] = '<option value="-1"'.$sel.'>(tots)</option>';
		foreach ($CFG_CAMPANYES['ESTAT_DESTINATARI'] as $k => $v) {
    	$sel = ($estat==$k) ? ' selected="selected"' : '';
    	$bl['OPTS_ESTAT'] .= '<option value="'.$k.'"'.$sel.'>'.$v.'</option>';
		}

		//**** Filtres, Recerques
		$wh_filtre = " WHERE IdCam='$ID' AND IdUsu = '$LOGIN'";
		$bl['CERCA'] = filtrequote($cerca);
		$bl['FLT_ESTAT'] = filtrequote($estat);
		if ($cerca != '') {
			$cerca_bd = addslashes($cerca);
			$wh_filtre .= " AND (email LIKE '%$cerca_bd%' OR nom LIKE '%$cerca_bd%')";
		}
		if (isset($CFG_CAMPANYES['ESTAT_DESTINATARI'][$estat])) {
			$wh_filtre .= " AND (estat = '$estat')";
		}

		// **** Ordenacions
		$parms_aux = "id=$ID";
		//if ($pag!=1) $parms_aux .= "&amp;pag=$pag";
		if ($cerca!="") $parms_aux .= "&amp;cerca=$cerca";
		if ($estat!=1) $parms_aux .= "&amp;estat=$estat";
		$colu = array(  //num => array(id, camptaula, ordreperdefecte)
			1 => array('e', 'email', 'ASC'),
			2 => array('n', 'nom', 'ASC'),
			3 => array('d', 'dh_enviament', 'DESC'),
			4 => array('r', 'dh_recepcio', 'DESC'),
			5 => array('t', 'estat', 'ASC'),
		);
		foreach ($colu as $k => $v) {
			if (($ordenar == '')&&($k==1)) {  //ordre per defecte si no n'hi ha
				$wh_ordre = ' ORDER BY '.$v[1].' '.$v[2];
				$aju_ord1 = ($v[2] == "DESC") ? "ASC" : "DESC";
				$bl['LINK_'.$k] = 'destinataris.php?'.$parms_aux.'&amp;ordenar='.$v[0].'&amp;ordre='.$aju_ord1;
				$bl['ICO_'.$k] = '';
			} elseif ($ordenar == $v[0]){
				$wh_ordre = ' ORDER BY '.$v[1].' '.$ordre;
				$aju_ord1 = ($ordre == "DESC") ? "ASC" : "DESC";
				$bl['LINK_'.$k] = 'destinataris.php?'.$parms_aux.'&amp;ordenar='.$v[0].'&amp;ordre='.$aju_ord1;
				$bl['ICO_'.$k] = '<img src="'.$CFG_CAMPANYES['PATH_IMG'].$ordre.'.gif" width="10" height="10" alt="'.$ordre.'" border="0" hspace="5" align="left" />&nbsp;';
			} else {
				$aju_ord1 = $v[2];
				$bl['LINK_'.$k] = 'destinataris.php?'.$parms_aux.'&amp;ordenar='.$v[0].'&amp;ordre='.$aju_ord1;
				$bl['ICO_'.$k] = '';
			}
		}
		//$wh_ordre .= ', dh_alta DESC'; //ordre secundari
		$bl['ORDENAR'] = $ordenar;
		$bl['ORDRE'] = $ordre;

		//**** Paginacions
    $row5 = $db->sql_fetchrow( $db->sql_query("SELECT COUNT(*) AS nombre FROM news_DESTINATARIS ".$wh_filtre) );
    $n_regs = intval($row5['nombre']);
		$parms_aux = "id=$ID";
		if ($ordenar!='') $parms_aux .= "&amp;ordenar=$ordenar&amp;ordre=$ordre";
		if ($cerca!="") $parms_aux .= "&amp;cerca=$cerca";
		if ($estat!=1) $parms_aux .= "&amp;estat=$estat";
		$pagi = calcul_paginacions($pag, $n_regs, 'destinataris.php?'.$parms_aux);
		$wh_limit = $pagi['WH_LIMIT'];
	 	$bl['NUM_REGS'] = $pagi['NUM_REGS'];
	 	$bl['NUM_PAGS'] = $pagi['NUM_PAGS'];
	 	$bl['PAG_ACTUAL'] = $pagi['PAG_ACTUAL'];
	 	$bl['REG_PRIMER'] = $pagi['REG_PRIMER'];
	 	$bl['REG_ULTIM'] = $pagi['REG_ULTIM'];
	 	$bl['LINKS_PAGS'] = $pagi['LINKS_PAGS'];
	 	$bl['LINK_ANT'] = $pagi['LINK_ANT'];
	 	$bl['LINK_SEG'] = $pagi['LINK_SEG'];

		//**** Bucle principal
	$det = array();
  $det['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

 	$bl['LLISTAT'] = $Tpl_modul->mergeBlock('LLISTAT_CAP', $bl);
  $result5 = $db->sql_query("SELECT * FROM news_DESTINATARIS ".$wh_filtre.$wh_ordre.$wh_limit);
  while ($row5 = $db->sql_fetchrow($result5)) {
  	$det['EMAIL'] = $row5['email'];
  	$det['NOM'] = $row5['nom'];
  	$det['D_ENVIA'] = data_bd2fmt($row5['dh_enviament']);
  	$det['D_REP'] = ($row5['dh_recepcio']=='') ? '&nbsp;' : data_bd2fmt($row5['dh_recepcio']);
  	$det['ESTAT'] = $CFG_CAMPANYES['ESTAT_DESTINATARI'][$row5['estat']];

		$string = $ID.$CRIPTO_SEPAR.$LOGIN.$CRIPTO_SEPAR.$row5['email'].$CRIPTO_SEPAR.$CRIPTO_CHECK;
		$det['CRIPTO'] = urlencode(encrypt($string, $CRIPTO_KEY));

  	$bl['LLISTAT'] .= $Tpl_modul->mergeBlock('LLISTAT_LIN', $det);
	}
 	$bl['LLISTAT'] .= $Tpl_modul->mergeBlock('LLISTAT_PEU', $bl);


	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

?>