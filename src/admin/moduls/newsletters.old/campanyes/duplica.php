<?php

$CONFIG_PATHPHP = '../../../../media/php';
require ('../../../config_admin.inc');
accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes

$CONFIG_PATHCAMPANYES = '../';
require_once($CONFIG_PATHCAMPANYES.'config.inc');

   tractament();


function tractament() {
	global $db, $CFG_CAMPANYES, $ID, $LOGIN;

	$ID = trim(stripslashes(obte_postget('id')));

	$wh_noadmin = " AND IdUsu='$LOGIN'";
	$result5 = $db->sql_query("SELECT * FROM news_CAMPANYES WHERE IdCam = '$ID'".$wh_noadmin);
	if ($db->sql_numrows($result5) == 0) {
		htmlPageError('Campanya no accessible 1!');
	}
	$row5 = $db->sql_fetchrow($result5);

	
	
	
	
	if (($row5['tipus'] == 3) or ($row5['tipus'] == 4)){ 
	  //selecció newsletter jamoros
	  $wh_noadmin = " AND USUARI_HOUDINI='$LOGIN'";
	  $result6 = $db->sql_query("SELECT * FROM NEWSLETTERS WHERE IdCam = '$ID'".$wh_noadmin);
	  if ($db->sql_numrows($result6) == 0) {
		htmlPageError('Campanya no accessible 2!');
	  }
	  $row6 = $db->sql_fetchrow($result6);
	  
	  //el newsletter HTML q serà copiat
	  $but_old = '../../../../public/plantilla'.$ID.'.html';
	}
	
	  
	

	$camps = array();
	$camps['IdCam'] = '';  //autonumèric
	$camps['IdUsu'] = $LOGIN;
	$camps['estat'] = 30;
	$camps['dh_alta'] = date("Y-m-d H:i:s");
	$camps['dh_modif'] = $camps['dh_alta'];
	
	$camps['tipus'] = $row5['tipus'];

	$camps['titol'] = $row5['titol'];
	$camps['subject'] = $row5['subject'];
	$camps['from_name'] = $row5['from_name'];
	$camps['from_email'] = $row5['from_email'];
	$camps['reply_to'] = $row5['reply_to'];
	$camps['format'] = $row5['format'];
	$camps['msg_text'] = $row5['msg_text'];
	$camps['msg_html'] = $row5['msg_html'];
	//$camps['desti_llista'] = $row5['desti_llista'];
	//$camps['desti_manual'] = $row5['desti_manual'];
	$camps['desti_llista'] = '';
	$camps['desti_manual'] = '';
	$camps['afegir_link'] = $row5['afegir_link'];
	$camps['email_notify'] = $row5['email_notify'];
	$camps['dh_inici'] = NULL;
	$camps['dh_final'] = NULL;
	$camps['notes'] = $row5['notes'];

	fer_insert('news_CAMPANYES', $camps);
	$ID = $db->sql_nextid();
	//register_add($T_LANG['adm_campanyes'], 'creada campanya id: '.$ID);

	
	if (($row5['tipus'] == 3) or ($row5['tipus'] == 4)){ 
	  //el nou newsletter HTML
	  $but_new = '../../../../public/plantilla'.$ID.'.html';
	
	
	  //insert newsletter jamoros
	  $dia = date('d');
	  $mes = date('m');
	  $any = date('Y');
	  $any_end = date('Y')+1;
	  $CREATION = $any.'-'.$mes.'-'.$dia;
	  $END = $any_end.'-'.$mes.'-'.$dia;
	
	  $sql7 = "INSERT INTO NEWSLETTERS (ID,CLASS,SKIN,CATEGORY1,CATEGORY2,STATUS,VISIBILITY,CREATION,START,END,TITOL,IDNL,COD,DESCRIPCIO,TITOL_DESCRIP,STAFF,CONTACTE,USUARI_HOUDINI,IdCam,VEURESUMARI,CAP) VALUES (NULL,".$row6['CLASS'].",".$row6['SKIN'].",1,".$row6['CATEGORY2'].",".$row6['STATUS'].",".$row6['VISIBILITY'].",'".$CREATION."','".$CREATION."','".$END."','".addslashes($row6['TITOL'])."','".$row6['IDNL']."','".$row6['COD']."','".addslashes($row6['DESCRIPCIO'])."','".addslashes($row6['TITOL_DESCRIP'])."','".addslashes($row6['STAFF'])."','".addslashes($row6['CONTACTE'])."','".$row6['USUARI_HOUDINI']."',".$ID.",".$row6['VEURESUMARI'].",".$row6['CAP'].")";
	  //echo $sql7;
	  $result7 = $db->sql_query($sql7);
	
	  
	  //ID de la propera newsletter jamoros  
	  $result10 = $db->sql_query("SELECT * FROM NEWSLETTERS WHERE IdCam = ".$ID);
	  if ($db->sql_numrows($result10) == 0) {
		htmlPageError('Campanya no accessible 3!');
	  }
	  $row10 = $db->sql_fetchrow($result10);  
	  
	  //selecció notícies-newsletter jamoros
	  $result8 = $db->sql_query("SELECT * FROM TE_NNL_NL WHERE ID_NL = ".$row6['ID']);
	  if ($db->sql_numrows($result8) > 0) {
			  
		  while($row8 = $db->sql_fetchrow($result8)){
		  	$sql9 = "INSERT INTO TE_NNL_NL (ID_NNL,ID_NL,ORDRE,SECCIO,COF) VALUES (".$row8['ID_NNL'].",".$row10['ID'].",".$row8['ORDRE'].",".$row8['SECCIO'].",'".$row8['COF']."')";
		  	$result9 = $db->sql_query($sql9);
		  }
	  }
	  
	  //selecció banners-newsletter jamoros
	  $result11 = $db->sql_query("SELECT * FROM TE_BAN_NL WHERE ID_NL = ".$row6['ID']);
	  if ($db->sql_numrows($result11) > 0) {
		  
	  	  while($row11 = $db->sql_fetchrow($result11)){
		  	$sql12 = "INSERT INTO TE_BAN_NL (ID_BAN,ID_NL,ORDRE) VALUES (".$row11['ID_BAN'].",".$row10['ID'].",".$row11['ORDRE'].")";
		  	$result12 = $db->sql_query($sql12);
		  }
	  }

	  
	  //duplico HTML newsletter
	  copy($but_old, $but_new); 
	  
	  //permisos d'escritura al butlletí nou 
	  chmod($but_new, 0666);  
	}  
	  
	  
	  
	  

	//Header('Location: index.php');
	//Header('Location: resum.php?id='.$ID.'&opcio=duplica');
	Header('Location: duplica_nl.php?id='.$ID);
	die();
}

?>