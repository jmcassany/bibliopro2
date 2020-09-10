<?php

require ('../../config_admin.inc');

$result=db_query("ALTER TABLE `DIN_CATEGORIES` ADD `ORDRE` INT( 11 ) NOT NULL ");
$result=db_query("UPDATE `DIN_CATEGORIES` SET ORDRE = ID WHERE 1");

?>
