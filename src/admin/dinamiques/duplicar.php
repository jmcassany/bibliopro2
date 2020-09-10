<?php

require ('../config_admin.inc');
accessGroupPermCheck('dinamic_create');

include_once("dinamiques.php");
include_once('categories/funcions.inc');

 $ID=$_GET['ID'];
 //COMPROVEM SI TE ACCES A AQUEST MODUL
 include("check_moduls.php");
 //FI COMPROVEM SI TE ACCES A AQUEST MODUL



 $result1=db_query("select * from $TAULA where ID = '$ID'");
 $row = db_fetch_array($result1);
 $row['DESCRIPCIO'] = db_select_text($TAULA, 'DESCRIPCIO', 'ID = '.$row['ID']);
 $row['RESUM'] = db_select_text($TAULA, 'RESUM', 'ID = '.$row['ID']);

 // controlem apostrofs
 foreach($row as $key => $value)
 {
 	$row[$key] = addslashes($value);
 	$row[$key] = str_replace('\"','"',$row[$key]);
 }

 if(!isset($contador)){ $contador="0"; }
 if(!isset($_GET['TITOL'])){
 	$TITOL="copia de ".$row['TITOL'];
 }
$data = date('Y-m-d H:i:s', time());
 //busca  ordre q toca
 $ordreres1=db_query_range("select * from $TAULA ORDER BY ORDRE DESC",0,1);
 $roword = db_fetch_array($ordreres1);
 $ORDRE=$roword['ORDRE']+1;




 //
 $sql = "INSERT INTO $TAULA (ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START_TIME, END_TIME, MODIFICAT, USUARICREAR, USUARIMODI, TITOL, SUBTITOL,RESUM, DESCRIPCIO, LINK1, TEXTLINK1,  FINESTRA1, LINK2, TEXTLINK2, FINESTRA2, LINK3, TEXTLINK3,FINESTRA3,DATA,ORDRE)  VALUES ('1', '0', '".$row['CATEGORY1']."', '0', '0', '0', '$data', '".$row['START_TIME']."', '".$row['END_TIME']."', '$data', '".accessGetLogin()."', '', '$TITOL','".$row['SUBTITOL']."', '".$row['RESUM']."', '".$row['DESCRIPCIO']."', '".$row['LINK1']."', '".$row['TEXTLINK1']."' , '".$row['FINESTRA1']."', '".$row['LINK2']."', '".$row['TEXTLINK2']."', '".$row['FINESTRA2']."', '".$row['LINK3']."', '".$row['TEXTLINK3']."','".$row['FINESTRA3']."', '".$row['DATA']."', '$ORDRE')";

  $result = db_query($sql);
   if($result) {
     $result1=db_query("select MAX(ID) as ID from $TAULA");
     $rowid = db_fetch_array($result1);
     $insert_id = $rowid['ID'];

     db_update_text($TAULA, 'DESCRIPCIO', $row['DESCRIPCIO'], 'ID = '.$insert_id);
     db_update_text($TAULA, 'RESUM', $row['RESUM'], 'ID = '.$insert_id);

   	//insertar registre d'accions
    register_add(t("dinamicsregistryduplicate"), $TAULA);
	//fi

  goto_url('index.php?DIN='.$DIN.'&PAGE='.$pagina);
} else {
  echo db_error();
  echo ("<a href='javascript:history.back()'>".t('back')."</a>");
}
?>
