<?php
error_reporting(E_ALL);
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.php';
// Echo the image - timestamp appended to prevent caching
//	echo '<a href="index.php" onclick="refreshimg(); return false;" title="Click to refresh image"><img src="'.$CONFIG_NOMCARPETA.'/media/js/captcha/images/image.jpg?' . time() . '" width="132" height="46" alt="Captcha" /></a>';

echo '<img src="'.$CONFIG_NOMCARPETA.'/media/js/captcha/images/image.jpg?' . time() . '" width="132" height="46" alt="Captcha" />
	  <a href="'.$_SERVER['PHP_SELF'].'" onclick="refreshimg(); return false;" title="Click to refresh image"><img src="'.$CONFIG_NOMCARPETA.'/media/js/captcha/images/bt_actualitza.gif" alt="Refresh" /></a>';

?>