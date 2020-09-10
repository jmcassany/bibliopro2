<?php

require ('../../config_admin.inc');

$result=db_query("ALTER TABLE FORMULARIS DROP METALLENGUA");
$result=db_query("ALTER TABLE ESTATICA DROP METALLENGUA");
$result=db_query("ALTER TABLE CARPETES ADD METATITOL varchar(255) default NULL");
$result=db_query("ALTER TABLE CARPETES ADD METADESCRIPCIO text");
$result=db_query("ALTER TABLE CARPETES ADD METAKEYS text");

?>
