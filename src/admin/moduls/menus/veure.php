<?php
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1'
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0'

require ('../../config_admin.inc');
accessGroupPermCheck('menu_read');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca" lang="ca">
  <link rel="STYLESHEET" type="text/css" href="<?php echo $CONFIG_URLCSS ?>/estils.css">
</head>
<body style="text-align:left">

<?php

$menu=$_GET['menu'];
$targetfilename = $CONFIG_PATHMENU.'/'.$menu.'.inc';

if (file_exists("$targetfilename")) {
  include($targetfilename);
}else{
  echo ("<center><img src=\"../../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Alert\" border=\"0\" align=\"absmiddle\"> <font class=\"grana\" hspace=\"5\"><B>".t("menunotfound")."</B><br><a href=\"javascript:window.close();\"><b>".t("close")."</b></a></font></center>");
}
?>

</body></html>
