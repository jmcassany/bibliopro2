<?php
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1'
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0'

require ('../../config_admin.inc');
accessGroupPermCheck('rss');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca" lang="ca">
  <link rel="STYLESHEET" type="text/css" href="<?php echo $CONFIG_URLCSS ?>estils.css" />
  <base href="<?php echo urlHost($CONFIG_URLBASE) ?>">
</head>
<body>

<?php

$targetfilename = $CONFIG_PATHRSS."/".$rss.'.inc';
$targeturl = $CONFIG_URLRSS."/".$rss.'.inc';
if (file_exists($targetfilename)) {
  include ($targetfilename);
}else{
  echo ("<center><img src=\"../../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Alerta\" border=\"0\" align=\"absmiddle\"> <font class=\"grana\" hspace=\"5\"><B>".t('viewrssviewerror')."</B><br><a href=\"javascript:window.close();\"><b>".t('close')."</b></a></font></center>");
}
?>
</body></html>
