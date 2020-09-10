<?php

require ('../config_admin.inc');
accessGroupPermCheck('form_read');


$pagina=$_GET['pagina'];

$targetfilename = $CONFIG_PATHBASE.'/'.$pagina;
if (file_exists("$targetfilename")) {
  goto_url($CONFIG_URLBASE.'/'.$pagina);
}else{
echo ("<center><img src=\"../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Alert\" border=\"0\" align=\"absmiddle\"> <font class=\"grana\" hspace=\"5\"><B>".t("viewpagenotfound")." (<font color=\"#0E449A\">$pagina</font>)</B><br><a href=\"javascript:window.close();\"><b>".t("close")."</b></a></font></center>");
}
?>
