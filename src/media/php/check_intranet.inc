<?php
/*incloure configuració global*/
require_once (dirname(__FILE__).'/config.php');
/*incloure gestio de permissos*/
require_once ('aw/awaccess.php');
if (!isset($login_page)) {
  $login_page = $CONFIG_NOMCARPETA.'/intranet/login.php';
}
accessGroupPermCheck('intranet', $login_page);
?>