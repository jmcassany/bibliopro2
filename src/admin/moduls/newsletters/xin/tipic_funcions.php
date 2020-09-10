<?php

/*
	**** Funcions desactivades per estar a Houdini ****

//**** Control doble cometa
function filtreQuote($value) {
  return str_replace('"', '&quot;', $value);
}

//**** Busca la ip real de l'usuari
function checkIP() {
  $tmp = array();
  if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strpos($_SERVER['HTTP_X_FORWARDED_FOR'],','))  {
    $tmp += explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
  } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $tmp[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  $tmp[] = $_SERVER['REMOTE_ADDR'];

  $ipusuari = $tmp['0'];
  return $ipusuari;
}
*/

//**** Funcions per VALIDACIONS ****
function obte_postget($value,$defecte='') {
	return (isset($_POST[$value])) ? $_POST[$value] : ((isset($_GET[$value])) ? $_GET[$value] : $defecte);
}
function obte_post($value,$defecte='') {
	return (isset($_POST[$value])) ? $_POST[$value] : $defecte;
}
function obte_get($value,$defecte='') {
	return (isset($_GET[$value])) ? $_GET[$value] : $defecte;
}

//**** Funcions per FORMATEJAR (dates, imports, bytes, ...) ****
function datahora_bd2fmt($d='',$separ='.'){ 
	if ($d=='') return '';
  else return substr($d,8,2).$separ.substr($d,5,2).$separ.substr($d,0,4).substr($d,10);
}
function data_bd2fmt($d='',$separ='.'){ 
	if ($d=='') return '';
  else return substr($d,8,2).$separ.substr($d,5,2).$separ.substr($d,0,4);
}
function data_fmt2bd($d=''){ 
	if ($d=='') return NULL;
  else return substr($d,6,4).'-'.substr($d,3,2).'-'.substr($d,0,2);
}
function numero_num2fmt($impo, $decimals=0) {
	return number_format($impo, $decimals, ',', '.');
}
function import_num2fmt($impo) {
	if ($impo=='') return '&nbsp;';
	return number_format($impo, 2, ',', '.')." &euro;";
}
function bytes_num2fmt($size) {
    $mb = 1024*1024;
    if ( $size > $mb ) {
        $mysize = sprintf ("%01.1f",$size/$mb) . " MB";
    } elseif ( $size >= 1024 ) {
        $mysize = sprintf ("%01.0f",$size/1024) . " Kb";
    } else {
        $mysize = $size . " bytes";
    }
    return $mysize;
}
function segons_num2fmt($s, $tram = array('s'=>'\'\'', 'm'=>'\'', 'h'=>'h')) {
    if ($s=="") return "&nbsp;";
    elseif ($s < (60) ) { return $s.$tram['s'];}
    elseif ($s < (60*60) ) { $n1=floor($s / (60)); $n2=($s % (60)); return $n1.$tram['m'].sprintf("%02d", $n2).$tram['s']; }
    else { $n0=floor($s / (60*60)); $n1=floor(($s % (60*60)) / (60)); $n2=($s % (60)); return $n0.$tram['h'].sprintf("%02d", $n1).$tram['m'].sprintf("%02d", $n2).$tram['s']; }
}

//**** Funcions per DATES ****
function ultim_dia($anho, $mes){ 
	if ($mes == 1) return 31;
	elseif ($mes == 3) return 31;
	elseif ($mes == 4) return 30;
	elseif ($mes == 5) return 31;
	elseif ($mes == 6) return 30;
	elseif ($mes == 7) return 31;
	elseif ($mes == 8) return 31;
	elseif ($mes == 9) return 30;
	elseif ($mes == 10) return 31;
	elseif ($mes == 11) return 30;
	elseif ($mes == 12) return 31;
	elseif ($mes == 2) {
   if ( ((($anho % 4)==0) && (($anho % 100)!=0)) || (($anho % 400)==0)) return 29; 
   else return 28; 
	} 
}

//**** Calcula el nou id per autonumèrics manuals ****
function obtenir_proper_id($camp,$nomtaula,$where='') {
global $db;
	$result2 = $db->sql_query("SELECT MAX($camp) AS ultim_num FROM $nomtaula ".$where);
	if ($db->sql_numrows($result2)==0) {
		$aju = 1;
	} else {
		$row2 = $db->sql_fetchrow($result2);
		$aju = intval($row2['ultim_num'])+1;
	}
	return $aju;
}

//**** Funcions per insert,update,delete a les taules ****
function fer_insert($nomtaula,$camps,$petar=1) {
global $db;

	$aju_camps = ''; $aju_valors = '';
	foreach ($camps as $k => $v) {
		$aju_camps .= ", $k";
		if ($v===NULL) $aju_valors .= ", NULL";
		else $aju_valors .= ", '".addslashes($v)."'";
	}
	$aju_camps = substr($aju_camps, 2); $aju_valors = substr($aju_valors, 2);
	$result = $db->sql_query("INSERT INTO $nomtaula($aju_camps) VALUES ($aju_valors)");
	if ((!$result)&&($petar==1)) {
		$sql_error = $db->sql_error();
		$missat .= 'SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
		htmlPageError($missat);
	}
	return $result;
}

function fer_update($nomtaula,$camps,$where,$petar=1) {
global $db;

	$aju_camps = '';
	foreach ($camps as $k => $v) {
		if ($v===NULL) $aju_camps .= ", $k = NULL";
		else $aju_camps .= ", $k = '".addslashes($v)."'";
	}
	$aju_camps = substr($aju_camps, 2);
	$result = db_query("UPDATE $nomtaula SET $aju_camps WHERE $where");
	
	if ((!$result)&&($petar==1)) {
		$sql_error = db_error();
		$missat .= 'SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
		htmlNewsletterError($missat);
	}
	return $result;
}

function fer_delete($nomtaula,$where,$petar=1) {
global $db;
	$result = $db->sql_query("DELETE FROM $nomtaula WHERE $where");
	if ((!$result)&&($petar==1)) {
		$sql_error = $db->sql_error();
		$missat .= 'SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
		htmlPageError($missat);
	}
	return $result;
}

//**** Calcular paginacions
function calcul_paginacions($PAGE, $n_regs, $link_base, $lim_nombre=10, $max_trams=10) {

	$T_LANG['previous'] = 'Mostrar els '.$lim_nombre.' anteriors';
	$T_LANG['next'] = 'Mostrar els '.$lim_nombre.' següents';
	
    $n_pags = ceil($n_regs / $lim_nombre); 
    if ($n_regs==0) {
	    $PAGE = 0; $lim_desde = 0; $reg_primer = 0; $reg_ultim = 0;
    } else {
	    if ($PAGE < 1) $PAGE = 1;
	    if ($PAGE > $n_pags) $PAGE = $n_pags;
	    $lim_desde = ($PAGE - 1) * $lim_nombre;
	
	    $reg_primer = $lim_desde + 1;
	    $reg_ultim = ($PAGE < $n_pags) ? ($lim_desde+$lim_nombre) : $n_regs;
    }   

				if ($n_pags > 1) {
					if ($n_pags <= $max_trams) { $pag_ini=1; $pag_fin=$n_pags; }
					else {
						$tram_act = floor(($PAGE-1) / $max_trams);
						$pag_ini = ($tram_act*$max_trams)+1;
						$pag_fin = (($tram_act+1) *$max_trams);
						if ($pag_fin > $n_pags) $pag_fin = $n_pags;
					}
					$linkspag = '';
					if ($pag_ini >= $max_trams) $linkspag .= '<li class="ultim"><a href="'.$link_base.'&amp;pag='.($pag_ini - $max_trams).'">...</a></li>';
					for ($i=$pag_ini;$i<=$pag_fin;$i++) {
						$cl = ($i==$pag_fin) ? ' class="ultim"' : '';
						$linkspag .= '<li'.$cl.'>';
						$linkspag .= ($i==$PAGE)? $i : '<a href="'.$link_base.'&amp;pag='.$i.'">'.$i.'</a>';
						$linkspag .= '</li>';
					}
					if (($pag_fin+1) <= $n_pags) $linkspag .= '<li class="ultim"><a href="'.$link_base.'&amp;pag='.($pag_fin + 1).'">...</a></li>';
				} else {
					$linkspag = '';
				}

	// **** Omplir retorn
	$reto = array();
	$reto['NUM_PAGS'] = $n_pags; //nombre de pàgines
	$reto['PAG_ACTUAL'] = $PAGE; //pàgina actual
	$reto['WH_LIMIT'] = " LIMIT $lim_desde, $lim_nombre"; //per la clàusula where
	$reto['NUM_REGS'] = $n_regs; //nombre de registres
	$reto['REG_PRIMER'] = $reg_primer; //primer registre de la pàgina actual
	$reto['REG_ULTIM'] = $reg_ultim; //últim registre de la pàgina actual
	$reto['LINKS_PAGS'] = $linkspag; //links a les pàgines properes
	//$reto['LINK_ANT'] = ; //link a la pàgina anterior
	//$reto['LINK_SEG'] = ; //link a la pàgina següent
	
		if ($PAGE > 1) $reto['LINK_ANT'] = '<a href="'.$link_base.'&amp;pag='.($PAGE-1).'">'.$T_LANG['previous'].'</a>';
		else $reto['LINK_ANT'] = $T_LANG['previous']; //'&nbsp;';
		if ($PAGE < $n_pags) $reto['LINK_SEG'] = '<a href="'.$link_base.'&amp;pag='.($PAGE+1).'">'.$T_LANG['next'].'</a>';
		else $reto['LINK_SEG'] = $T_LANG['next']; //'&nbsp;';

	return $reto;
}

?>