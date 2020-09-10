<?php

require ('../../../config_admin.inc');

$CONF['sitename']=$CONFIG_SITENAME;

$db = db_url_parser($db_url);

$CONF['sql_dbname'] = $db['name'];
$CONF['sql_host']   = $db['host'];
$CONF['sql_usr']    = $db['user'];
$CONF['sql_pass']   = $db['passwd'];

$CONF['time_limit']="0";

$CONF['exclude_tables']=array('sessions');

$CONF['ftp_use']="0";
$CONF['ftp_user']="";
$CONF['ftp_pass']="";
$CONF['ftp_path']="";
$CONF['ftp_server']="";
$CONF['ftp_pasv']="1";

$CONF['del_after_days_local']="400";
$CONF['del_after_days_ftp']="500";

?>
