<?php

require ('../../config_admin.inc');

$result=db_queryd("ALTER TABLE DIN_CATEGORIES ADD URL_NOM VARCHAR(50) NOT NULL DEFAULT ''");
$result=db_queryd("select * from DIN_CATEGORIES");
while($row = db_fetch_array($result)) {
	$nom = sanitize_title($row['NOM']);
	db_queryd("update DIN_CATEGORIES set URL_NOM='".$nom."' where ID=".$row['ID']);
}


$result=db_query("select ID from CARPETES Where CATEGORY1='1'");
$tablelist = array();
while($row = db_fetch_array($result)) {
  $tablelist[] = staticFolderTableName($row['ID']);
}
foreach ($tablelist as $table) {
	$result=db_queryd("ALTER TABLE ".$table." ADD URL_TITOL  varchar(250) default NULL");
	$result=db_queryd("select * from ".$table);
	while($row = db_fetch_array($result)) {
		$nom = sanitize_title($row['TITOL']);
		db_queryd("update ".$table." set URL_TITOL='".$nom."' where ID=".$row['ID']);
	}

}

?>
