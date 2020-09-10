<?php

require ('../../config_admin.inc');

$result=db_query("select ID from CARPETES Where CATEGORY1='1'");
$tablelist = array();
while($row = db_fetch_array($result)) {
  $tablelist[] = staticFolderTableName($row['ID']);
}

foreach ($tablelist as $table) {
  db_query("ALTER TABLE $table ADD CALENDAR_START_TIME DATETIME NOT NULL AFTER END_TIME, ADD CALENDAR_END_TIME DATETIME NOT NULL AFTER CALENDAR_START_TIME");
}


?>
