<?php

require ('../../config_admin.inc');

db_query("
ALTER TABLE MENUITEMS ADD DIRECTORI int(11) default -1;
");
?>
