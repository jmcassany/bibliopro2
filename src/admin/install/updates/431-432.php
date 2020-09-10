<?php

require ('../../config_admin.inc');

$result=db_query("ALTER TABLE FORMULARIS CHANGE DESCRIPCIO DESCRIPCIO TEXT NULL DEFAULT NULL ");

?>
