<?php

require ('../../config_admin.inc');
accessGroupPermCheck('form_entrys');

foreach($_POST as $key => $value) {
  $_POST[$key] = addslashes($value);
}

  //MIRO L´ultim ordre entrat
$FORMULARI=$_POST['FORMULARI'];
  $result=db_query("select MAX(ORDRE) as ORDRE from FORMULARISITEMS where FORMULARI='$FORMULARI'");
		 $totalresultats=db_num_rows($result);
		 $row2 = db_fetch_array($result);
		 if ($totalresultats>0){
		 	$ORDRE=$row2['ORDRE']+1;
		}else{
			$ORDRE=1;
		}


 if (!isset($_POST['OBLIGATORI'])) {
   $_POST['OBLIGATORI'] = 0;
 }
 $sql = "insert into FORMULARISITEMS (TEXT,NOM,VALOR,TIPO,TAMANY,ORDRE,OBLIGATORI,FORMULARI) values ('".$_POST['TEXT']."','".$_POST['NOM']."','".$_POST['VALOR']."','".$_POST['TIPO']."','".$_POST['TAMANY']."','$ORDRE','".$_POST['OBLIGATORI']."','$FORMULARI')";
  $result = db_query($sql);
   if($result) {


	//////////////////////////////////////
	$result=db_query("select max(ID) as ID from FORMULARISITEMS");
	$row = db_fetch_array($result);
	goto_url('preview.php?ID='.$row['ID'].'&FORMULARI='.$FORMULARI);

   } else {
	echo ("<a href='javascript:history.back()'>".t("back")."</a>");
	echo db_error();
   }

?>
