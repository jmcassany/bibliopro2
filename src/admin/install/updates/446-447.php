<?php

require ('../../config_admin.inc');

db_query("
ALTER TABLE MENUITEMS ADD EDITORA int(11) default -1;
");
?>
