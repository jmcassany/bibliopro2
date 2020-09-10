<?php

if($_GET){
  $ID=$_GET['ID'];
}
if($_POST){
  $ID=$_POST['ID'];
}


require ('../config_admin.inc');
accessGroupPermCheck('page_create');

include_once("estatiques.php");


include("check_moduls.php");

 $result1=db_query("select
 ID, ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START_TIME, END_TIME, MODIFICAT,
 USUARICREAR, USUARIMODI, NOMPAG, DESCRIPCIO,IDIOMA,REFERENCIA,METATITOL, METADESCRIPCIO, METAKEYS,
 PARE, PLANTILLAID, MENU1, MENU2, MENU3, BANNER1, BANNER2, BANNER3, TEXTC1, TEXTC2, TEXTC3, TEXTC4, TEXTC5, TEXTC6,
 TEXTC7, TEXTC8, TEXTC9, TEXTC10, TEXTC11, TEXTC12, TEXTC13, TEXTC14, TEXTC15, TEXTC16, TEXTC17, TEXTC18, TEXTC19,
 TEXTC20, TEXTC21, TEXTC22, TEXTC23, TEXTC24, TEXTC25, TEXTC26, TEXTC27, TEXTC28, TEXTC29, TEXTC30, TEXTC31, TEXTC32,
 TEXTC33, TEXTC34, TEXTC35, TEXTC36, TEXTC37, TEXTC38, TEXTC39, TEXTC40, TEXTC41, TEXTC42, TEXTC43, TEXTC44, TEXTC45,
 CERCADOR
 from ESTATICA where ID = '$ID'");

 $row = db_fetch_array($result1);
 if (empty($row['ID'])){
   htmlPageBasicError(t("errordbcardscodinotfound"));
 }

  for ($i = 1; $i <=$PAGE_max_textl; $i++) {
    $row['TEXTL'.$i] = db_select_text('ESTATICA', 'TEXTL'.$i, 'ID = '.$row['ID']);
  }

 if(!isset($contador)){ $contador="0"; }
 if(empty($NOMPAG)){
 	$NOMPAG="copia de ".$row['NOMPAG'];
 }
 $NOMPAGPRINCIPAL=$NOMPAG;










  // comprovem si existeixeixen les pàgines
// $ruta_pagina = db_select_text('ESTATICA', 'RUTA', 'ID = '.$row['ID']);
 $ruta_pagina = $row['PARE'];
 $error = 0;
 $error_message = '';
 foreach($CONFIG_idiomes as $key => $value){
 	if($key == $CONFIG_IDIOMA){
	 	$nom_pag_nova = $NOMPAGPRINCIPAL;
	}
	else{
		$nom_pag_nova = $key."_".$NOMPAGPRINCIPAL;
	}
 	$res_pagina = db_query("select * from ESTATICA WHERE PARE='$ruta_pagina' AND NOMPAG='$nom_pag_nova'");

	// si hi ha alguna pàgina amb el mateix nom li renombrem amb el nom que hi hagi a l'idioma principal
	if( db_num_rows($res_pagina) != 0){
	  $error = 1;

	  $row_pagina = db_fetch_array($res_pagina);
	  //$nom_pagina_principal = db_select_text('ESTATICA','NOMPAG', 'ID='.$row_pagina['REFERENCIA']);
    $orig = db_query("select NOMPAG from ESTATICA where ID='".$row_pagina['REFERENCIA']."'");
    $orig_row = db_fetch_array($orig);
    $nom_pagina_principal = $orig_row['NOMPAG'];

	  $renombrat = $key."_".$nom_pagina_principal;
	  // actualitzem el nom de la pàgina duplicada anteriorment
//	  if(db_update_text('ESTATICA', 'NOMPAG', $renombrat, 'ID='.$row_pagina['ID']) ){
	  if(db_query("update ESTATICA set NOMPAG='$renombrat' where ID='".$row_pagina['ID']."'") ){
	  		$error_message .= t('staticpagesduplicateerrormessage1').'<span class="vermell10b">'.$row_pagina['NOMPAG'].'</span> '.t('staticpagesduplicateerrormessage2').' <span class="vermell10b">'.$renombrat.'</span>.<br /><br />';
	  }
	}
 }

if($error_message != ''){
	$error_message .= t('staticpagesduplicateexplainmessage1').'<span class="vermell10b">'.$row['NOMPAG'].'</span>'.t('staticpagesduplicateexplainmessage2').' <span class="vermell10b">'.$nom_pagina_principal.'</span>';
}
















 $data = date('Y-m-d H:i:s', time());

 // controlem apostrofs a l'idioma principal
 foreach($row as $key => $value)
 {
 	$row[$key] = addslashes($value);
 }

 $sql = "INSERT INTO ESTATICA
 (ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START_TIME, END_TIME, MODIFICAT,
 USUARICREAR, USUARIMODI, NOMPAG, DESCRIPCIO,IDIOMA,REFERENCIA,METATITOL, METADESCRIPCIO, METAKEYS,
 PARE, PLANTILLAID, MENU1, MENU2, MENU3, BANNER1, BANNER2, BANNER3, TEXTC1, TEXTC2, TEXTC3, TEXTC4, TEXTC5, TEXTC6,
 TEXTC7, TEXTC8, TEXTC9, TEXTC10, TEXTC11, TEXTC12, TEXTC13, TEXTC14, TEXTC15, TEXTC16, TEXTC17, TEXTC18, TEXTC19,
 TEXTC20, TEXTC21, TEXTC22, TEXTC23, TEXTC24, TEXTC25, TEXTC26, TEXTC27, TEXTC28, TEXTC29, TEXTC30, TEXTC31, TEXTC32,
 TEXTC33, TEXTC34, TEXTC35, TEXTC36, TEXTC37, TEXTC38, TEXTC39, TEXTC40, TEXTC41, TEXTC42, TEXTC43, TEXTC44, TEXTC45,
  CERCADOR)   VALUES
 ('1', '0', '".$row['CATEGORY1']."', '0', '0', '0', '$data', '$row[START_TIME]', '$row[END_TIME]', '$data', '".accessGetLogin()."', '', '$NOMPAG','".$row['DESCRIPCIO']."','".$row['IDIOMA']."','0', '".$row['METATITOL']."', '".$row['METADESCRIPCIO']."', '".$row['METAKEYS']."', '".$row['PARE']."', '".$row['PLANTILLAID']."', '".$row['MENU1']."', '".$row['MENU2']."', '".$row['MENU3']."', '".$row['BANNER1']."', '".$row['BANNER2']."', '".$row['BANNER3']."', '".$row['TEXTC1']."','".$row['TEXTC2']."', '".$row['TEXTC3']."', '".$row['TEXTC4']."', '".$row['TEXTC5']."', '".$row['TEXTC6']."', '".$row['TEXTC7']."', '".$row['TEXTC8']."', '".$row['TEXTC9']."', '".$row['TEXTC10']."', '".$row['TEXTC11']."', '".$row['TEXTC12']."', '".$row['TEXTC13']."', '".$row['TEXTC14']."', '".$row['TEXTC15']."', '".$row['TEXTC16']."', '".$row['TEXTC17']."', '".$row['TEXTC18']."', '".$row['TEXTC19']."', '".$row['TEXTC20']."', '".$row['TEXTC21']."', '".$row['TEXTC22']."', '".$row['TEXTC23']."', '".$row['TEXTC24']."', '".$row['TEXTC25']."', '".$row['TEXTC26']."', '".$row['TEXTC27']."', '".$row['TEXTC28']."', '".$row['TEXTC29']."', '".$row['TEXTC30']."', '".$row['TEXTC31']."', '".$row['TEXTC32']."', '".$row['TEXTC33']."', '".$row['TEXTC34']."', '".$row['TEXTC35']."', '".$row['TEXTC36']."', '".$row['TEXTC37']."', '".$row['TEXTC38']."', '".$row['TEXTC39']."', '".$row['TEXTC40']."', '".$row['TEXTC41']."', '".$row['TEXTC42']."', '".$row['TEXTC43']."', '".$row['TEXTC44']."', '".$row['TEXTC45']."', '".$row['CERCADOR']."')";




  $result = db_query($sql);
  $result1=db_query("select MAX(ID) as ID from ESTATICA");
  $rowid = db_fetch_array($result1);

  $insert_id = $rowid['ID'];


  for ($i = 1; $i <=$PAGE_max_textl; $i++) {
    db_update_text('ESTATICA', 'TEXTL'.$i, stripslashes($row['TEXTL'.$i]), 'ID = '.$insert_id);
  }




  //dupliquem els idiomes

   if($result) {

   	//insertar registre d'accions
    register_add(t("staticpagesregistryduplicatedok"), $NOMPAG);
	//fi



	//finalment dupliquem les pagines
	$result1=db_query("select
 ID, ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START_TIME, END_TIME, MODIFICAT,
 USUARICREAR, USUARIMODI, NOMPAG, DESCRIPCIO,IDIOMA,REFERENCIA,METATITOL, METADESCRIPCIO, METAKEYS,
 PARE, PLANTILLAID, MENU1, MENU2, MENU3, BANNER1, BANNER2, BANNER3, TEXTC1, TEXTC2, TEXTC3, TEXTC4, TEXTC5, TEXTC6,
 TEXTC7, TEXTC8, TEXTC9, TEXTC10, TEXTC11, TEXTC12, TEXTC13, TEXTC14, TEXTC15, TEXTC16, TEXTC17, TEXTC18, TEXTC19,
 TEXTC20, TEXTC21, TEXTC22, TEXTC23, TEXTC24, TEXTC25, TEXTC26, TEXTC27, TEXTC28, TEXTC29, TEXTC30, TEXTC31, TEXTC32,
 TEXTC33, TEXTC34, TEXTC35, TEXTC36, TEXTC37, TEXTC38, TEXTC39, TEXTC40, TEXTC41, TEXTC42, TEXTC43, TEXTC44, TEXTC45, CERCADOR
    from ESTATICA where REFERENCIA = '$ID' ORDER BY ID ASC");

  while($row = db_fetch_array($result1)) {

	// controlem apostrofs als idiomes secundaris
	foreach($row as $key => $value)
	{
		$row[$key] = addslashes($value);
	}

    for ($i = 1; $i <=$PAGE_max_textl; $i++) {
      $row['TEXTL'.$i] = db_select_text('ESTATICA', 'TEXTL'.$i, 'ID = '.$row['ID']);
    }

    $NOMPAG=$row['IDIOMA']."_".$NOMPAGPRINCIPAL;
    $sql2 = "INSERT INTO ESTATICA
    (ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START_TIME, END_TIME, MODIFICAT, USUARICREAR,
    USUARIMODI, NOMPAG, DESCRIPCIO,IDIOMA,REFERENCIA,METATITOL, METADESCRIPCIO, METAKEYS, PARE, PLANTILLAID,
    MENU1, MENU2, MENU3, BANNER1, BANNER2, BANNER3, TEXTC1, TEXTC2, TEXTC3, TEXTC4, TEXTC5, TEXTC6, TEXTC7, TEXTC8,
    TEXTC9, TEXTC10, TEXTC11, TEXTC12, TEXTC13, TEXTC14, TEXTC15, TEXTC16, TEXTC17, TEXTC18, TEXTC19, TEXTC20, TEXTC21,
    TEXTC22, TEXTC23, TEXTC24, TEXTC25, TEXTC26, TEXTC27, TEXTC28, TEXTC29, TEXTC30, TEXTC31, TEXTC32, TEXTC33, TEXTC34,
    TEXTC35, TEXTC36, TEXTC37, TEXTC38, TEXTC39, TEXTC40, TEXTC41, TEXTC42, TEXTC43, TEXTC44, TEXTC45, CERCADOR)   VALUES
    ('1', '0', '".$row['CATEGORY1']."', '0', '0', '0', '$data', '$row[START_TIME]', '$row[END_TIME]', '$data', '".accessGetLogin()."', '', '$NOMPAG','".$row['DESCRIPCIO']."','".$row['IDIOMA']."','$insert_id', '".$row['METATITOL']."', '".$row['METADESCRIPCIO']."', '".$row['METAKEYS']."', '".$row['PARE']."', '".$row['PLANTILLAID']."', '".$row['MENU1']."', '".$row['MENU2']."', '".$row['MENU3']."', '".$row['BANNER1']."', '".$row['BANNER2']."', '".$row['BANNER3']."', '".$row['TEXTC1']."','".$row['TEXTC2']."', '".$row['TEXTC3']."', '".$row['TEXTC4']."', '".$row['TEXTC5']."', '".$row['TEXTC6']."', '".$row['TEXTC7']."', '".$row['TEXTC8']."', '".$row['TEXTC9']."', '".$row['TEXTC10']."', '".$row['TEXTC11']."', '".$row['TEXTC12']."', '".$row['TEXTC13']."', '".$row['TEXTC14']."', '".$row['TEXTC15']."', '".$row['TEXTC16']."', '".$row['TEXTC17']."', '".$row['TEXTC18']."', '".$row['TEXTC19']."', '".$row['TEXTC20']."', '".$row['TEXTC21']."', '".$row['TEXTC22']."', '".$row['TEXTC23']."', '".$row['TEXTC24']."', '".$row['TEXTC25']."', '".$row['TEXTC26']."', '".$row['TEXTC27']."', '".$row['TEXTC28']."', '".$row['TEXTC29']."', '".$row['TEXTC30']."', '".$row['TEXTC31']."', '".$row['TEXTC32']."', '".$row['TEXTC33']."', '".$row['TEXTC34']."', '".$row['TEXTC35']."', '".$row['TEXTC36']."', '".$row['TEXTC37']."', '".$row['TEXTC38']."', '".$row['TEXTC39']."', '".$row['TEXTC40']."', '".$row['TEXTC41']."', '".$row['TEXTC42']."', '".$row['TEXTC43']."', '".$row['TEXTC44']."', '".$row['TEXTC45']."', '".$row['CERCADOR']."')";
    $result5 = db_query($sql2);



    $result6=db_query("select MAX(ID) as ID from ESTATICA");
    $rowid = db_fetch_array($result6);

    $insert_id2 = $rowid['ID'];

    for ($i = 1; $i <=$PAGE_max_textl; $i++) {
      db_update_text('ESTATICA', 'TEXTL'.$i, stripslashes($row['TEXTL'.$i]), 'ID = '.$insert_id2);
    }


  }


	//fi

//  goto_url('edita.php?ID='.$insert_id.'&carpeta='.$carpeta.'&accio=1');
}
else {
  echo db_error();
  echo ("<a href='javascript:history.back()'>".t("back")."</a>");
}
?>

<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="carregat();">

<?php echo htmlHeader(); ?>
<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("staticpagestitle"); ?></b></td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td class="text"  style="padding:20px;" valign="top" width="70%">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
			<tr>
				<td bgcolor="#0E449A" class="blanc11b" style="padding:5px;height:30px;">
				<?php echo t("staticpagesareacontrolduplicate"); ?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;" class="text">
					<table cellpadding="0" cellspacing="0" bgcolor="#f8f8f8" style="border:solid #CCCCCC 1px;padding:5px; margin:20px;" >
						<tr>
							<td valign="top"><img src="../comu/ico_info.gif" width="11" height="11" alt="Info" border="0" style="margin-right:5px;" /> </td>
							<td class="text9" valign="top">
								<font color="#999999">
								<?php echo t("staticpagesduplicatemessage"); ?>
								</font>
							</td>
						</tr>
					</table>

					<?php echo $error_message;	?>
				</td>
			</tr>
		</table>

<?php

$result=db_query('select
 ID, ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START_TIME, END_TIME, MODIFICAT,
 USUARICREAR, USUARIMODI, NOMPAG, DESCRIPCIO,IDIOMA,REFERENCIA,METATITOL, METADESCRIPCIO, METAKEYS,
 PARE
 from ESTATICA where ID=\''.$insert_id.'\' OR REFERENCIA=\''.$insert_id.'\'');


$menuopcionsedita = '';
$missatge = '';
while($row = db_fetch_array($result)) {

  /*menu*/
  $codiidioma=$row['IDIOMA'];
  for($i=0;$i<count($CONFIG_idiomes[$CONFIG_IDIOMA]);$i++){
    $trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA][$i]);
    if($codiidioma==$trozos['2']) {
      $nomidioma=$trozos['1'];
    }
  }
  $menuopcionsedita .="<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"margin-bottom:5px;\"><tr><td width=\"60%\" class=\"text9\"><img src=\"../comu/paisos/".$codiidioma.".gif\" width=\"18\" height=\"14\" border=\"0\" alt=\"".$nomidioma."\" align=\"absmiddle\">&nbsp;".$nomidioma."</td><td><a href=\"edita.php?ID=".$row['ID']."&carpeta=".$row['PARE']."\"><img src=\"../comu/icon_modifica.gif\" alt=\"Editar\" width=\"23\" height=\"16\" border=\"0\" align=\"absmiddle\"></a> </td></tr></table>";

  // mirem si esta seleccionat l'idioma
  if (!isset($_POST[$codiidioma]) || $_POST[$codiidioma]!='1')
  {
    continue;
  }

}


echo $missatge;

db_free_result($result);



?>
</td>
<td style="padding:20px;" valign="top" >
<?php
echo ("<a href=\"index.php?carpeta=".$_GET['carpeta']."\" class=\"botonavegacio\" style=\"width: 150px;text-align:center\">".t("backtolist")."</a>");
?>
<br /><br />
<fieldset style="width: 150px;padding:10px;">
<legend align="left" class="blau11b">&nbsp;<?php echo t("options"); ?>&nbsp;</legend>
<br />
<?php
echo $menuopcionsedita;
?>
<br />
</fieldset>
</td>
</tr>
</table>
</div>
<?php echo htmlFoot(); ?>
</body>
</html>
