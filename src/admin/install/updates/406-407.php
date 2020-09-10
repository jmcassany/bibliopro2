<?php

require ('../../config_admin.inc');

db_query("
ALTER TABLE MENUITEMS ADD CSSCLASS varchar(255) default NULL;
");
db_query("
ALTER TABLE MENUITEMSSUB ADD CSSCLASS varchar(255) default NULL;
");

?>
