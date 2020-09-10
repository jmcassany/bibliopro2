<?php

require ('../../config_admin.inc');

$result=db_query("select ID from CARPETES Where CATEGORY1='1'");
$tablelist = array();
while($row = db_fetch_array($result)) {
  $tablelist[] = staticFolderTableName($row['ID']);
}

foreach ($tablelist as $table) {
  db_query("ALTER TABLE ".$table." CHANGE ADJUNT ADJUNT1 varchar(255) default NULL");
  db_query("ALTER TABLE ".$table." CHANGE TEXT_ADJUNT TEXT_ADJUNT1 varchar(255) NOT NULL default ''");
  db_query("ALTER TABLE ".$table." ADD ADJUNT2 varchar(255) default NULL;");
  db_query("ALTER TABLE ".$table." ADD TEXT_ADJUNT2 varchar(255) NOT NULL default '';");
  db_query("ALTER TABLE ".$table." ADD ADJUNT3 varchar(255) default NULL;");
  db_query("ALTER TABLE ".$table." ADD TEXT_ADJUNT3 varchar(255) NOT NULL default '';");
}


?>
