<?php

require ('../../config_admin.inc');

$result=db_query("ALTER TABLE ESTATICA DROP VIMPRIMIR");
$result=db_query("ALTER TABLE FORMULARIS DROP VIMPRIMIR");

?>
