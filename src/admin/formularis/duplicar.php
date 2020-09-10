<?php

require ('../config_admin.inc');
accessGroupPermCheck('form_create');

include_once("formularis.php");



if($_GET){
  $ID=$_GET['ID'];
}
if($_POST){
  $ID=$_POST['ID'];
  $NOMFORMULARI=$_POST['NOMFORMULARI'];
}
$result1=db_query("select * from FORMULARIS where ID = '$ID'");
$row = db_fetch_array($result1);
if (empty($row['ID'])){
  htmlPageError(t("errordbcardscodinotfound"));
}
if(!isset($contador)){ $contador="0"; }
if(!isset($NOMFORMULARI)){
  $NOMFORMULARI="copia_".$row['NOMFORMULARI'];
}
$data = date('Y-m-d H:i:s', time());
$sql = "
INSERT INTO FORMULARIS
(ECLASS, STATUS, VISIBILITY, CREATION, MODIFICAT, USUARICREAR, NOMFORMULARI, TITOLFORMULARI, DESCRIPCIO, PLANTILLA, MENU1, MENU2, MENU3, BANNER1, BANNER2, BANNER3, PARE, RECIPIENT, REDIRECT, IDIOMA) VALUES
('1', '0', '1', '$data', '$data', '".accessGetLogin()."', '".addslashes($NOMFORMULARI)."', 'copia de ".addslashes($row['TITOLFORMULARI'])."', '".addslashes($row['DESCRIPCIO'])."', '".$row['PLANTILLA']."', '".$row['MENU1']."', '".$row['MENU2']."', '".$row['MENU3']."', '".$row['BANNER1']."', '".$row['BANNER2']."', '".$row['BANNER3']."', '".$row['PARE']."', '".$row['RECIPIENT']."', '".$row['REDIRECT']."', '".$row['IDIOMA']."');";
$result = db_query($sql);



if($result) {

  $result=db_query("select MAX(ID) as ID from FORMULARIS");
  $row = db_fetch_array($result);
  $ultimcreat=$row['ID'];


  $result2 = db_query("SELECT * FROM FORMULARISITEMS WHERE FORMULARI='$ID'");

  while($row2 = db_fetch_array($result2)) {
    $sql2 = "INSERT INTO FORMULARISITEMS
             (TEXT, NOM, VALOR, TIPO, TAMANY, ORDRE, OBLIGATORI, FORMULARI) VALUES
             ('".addslashes($row2['TEXT'])."', '".addslashes($row2['NOM'])."', '".addslashes($row2['VALOR'])."','".$row2['TIPO']."','".$row2['TAMANY']."','".$row2['ORDRE']."','".$row2['OBLIGATORI']."', '$ultimcreat');";
    $result3 = db_query($sql2);


  }

  //insertar registre d'accions
  register_add(t("form").t("duplicated"), $NOMFORMULARI);
  //fi
  goto_url('edita.php?ID='.$ultimcreat);

} else {
  echo db_error();
  echo ("<a href='javascript:history.back()'>Tornar</a>");
}

?>
