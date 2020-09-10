<?php

require ('../../config_admin.inc');




db_query("
alter table MENUS
  modify DESPLEGABLE varchar(100) not null default '';
");
db_query("
alter table MENUITEMSSUB
  CHANGE TEXT1 TEXT VARCHAR(100) NOT NULL default '',
  CHANGE LINKPAGE1 LINKPAGE varchar(100) NOT NULL default '',
  CHANGE FINESTRA1 FINESTRA tinyint(1) not null default 0,
  add column IMATGE varchar(255) default NULL,
  add column `SEPARATOR` tinyint(1) not null default 0
");

db_query("
alter table MENUITEMS
  modify FINESTRA tinyint(1) not null default 0,
  add column `SEPARATOR` tinyint(1) not null default 0
");

$result = db_query("select * from MENUITEMS where TEXT like '-'");
while ($row = db_fetch_array($result)) {
  db_query("update MENUITEMS set `SEPARATOR`=1 where ID=".$row['ID']);
}
$result = db_query("select * from MENUITEMSSUB where TEXT like '-'");
while ($row = db_fetch_array($result)) {
  db_query("update MENUITEMSSUB set `SEPARATOR`=1 where ID=".$row['ID']);
}

echo '<h2>Comprova que la conversió ha estat correcte</h2>';






?>
