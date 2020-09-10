<?php

require ('../../config_admin.inc');

$result=db_query("ALTER TABLE `CAIXETES` ADD `IMATGE_ALTERNATIVA` VARCHAR( 255 ) NOT NULL AFTER `IMATGE`");

?>
