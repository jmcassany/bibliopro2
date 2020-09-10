<?php

$db = db_url_parser($db_url, 1);

$CFG['dbname'] = $db['name'];
$CFG['dbhost'] = $db['host'];
if (isset($db['port'])) {
  $CFG['dbport'] = $db['port'];
}
else {
  $CFG['dbport'] = '3306';
}
$CFG['dbuser'] = $db['user'];
$CFG['dbpass'] = $db['passwd'];

?>
