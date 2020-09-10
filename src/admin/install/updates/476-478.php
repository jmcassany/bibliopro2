<?php
require ('../../config_admin.inc');

db_query("
ALTER TABLE `CARPETES_IDIOMES` ADD `METAKEYS` TEXT NOT NULL default '';
");

?>
