<?php
header("Expires: Mon, 6 Jan 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0


require ('../config_admin.inc');
accessGroupPermCheck('page_read');

include_once("estatiques.php");
//include("check_moduls.php");
include_once('variables.inc');

$ID=$_POST['ID'];

//crida base de dades

$result=db_query("select
 ID, ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START_TIME, END_TIME, MODIFICAT,
 USUARICREAR, USUARIMODI, NOMPAG, DESCRIPCIO,IDIOMA,REFERENCIA,METATITOL, METADESCRIPCIO, METAKEYS,
 PARE, PLANTILLAID, MENU1, MENU2, MENU3, BANNER1, BANNER2, BANNER3, TEXTC1, TEXTC2, TEXTC3, TEXTC4, TEXTC5, TEXTC6,
 TEXTC7, TEXTC8, TEXTC9, TEXTC10, TEXTC11, TEXTC12, TEXTC13, TEXTC14, TEXTC15, TEXTC16, TEXTC17, TEXTC18, TEXTC19,
 TEXTC20, TEXTC21, TEXTC22, TEXTC23, TEXTC24, TEXTC25, TEXTC26, TEXTC27, TEXTC28, TEXTC29, TEXTC30, TEXTC31, TEXTC32,
 TEXTC33, TEXTC34, TEXTC35, TEXTC36, TEXTC37, TEXTC38, TEXTC39, TEXTC40, TEXTC41, TEXTC42, TEXTC43, TEXTC44, TEXTC45,
 IMATGE1, IMATGE2, IMATGE3, IMATGE4, IMATGE5, IMATGE6, IMATGE7, IMATGE8, IMATGE9, IMATGE10, IMATGE11, IMATGE12,
 IMATGE13, IMATGE14, IMATGE15, IMATGE16, IMATGE17, IMATGE18, IMATGE19, IMATGE20, IMATGE21, IMATGE22, IMATGE23,
 IMATGE24, IMATGE25, ADJUNT1, ADJUNT2, ADJUNT3, ADJUNT4, ADJUNT5, ADJUNT6, ADJUNT7, ADJUNT8, ADJUNT9, ADJUNT10,
 ALT1, ALT2, ALT3, ALT4, ALT5, ALT6, ALT7, ALT8, ALT9, ALT10, CERCADOR,
 OP1, OP2, OP3, OP4, OP5
  from ESTATICA where ID=$ID");
$row = db_fetch_array($result);

for ($i = 1; $i <=$PAGE_max_textl; $i++) {
  $row['TEXTL'.$i] = db_select_text('ESTATICA', 'TEXTL'.$i, 'ID = '.$row['ID']);
}

unset($_POST['ID']);
foreach ($_POST as $key => $value) {
	$row[$key] = $value;
}



$valors = generate_page ($row, true);

if (!is_array($valors)) {
  echo '';
}
else {
  $valors['normal'] = phpEval($valors['normal']);
  echo $valors['normal'];
}
db_free_result($result);
?>
