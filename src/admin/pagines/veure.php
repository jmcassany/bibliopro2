<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_read');

$pagina=$_GET['pagina'];

$targetfilename = $CONFIG_PATHBASE.'/'.$pagina;

if (file_exists($targetfilename)) {
	$vista_previa = $CONFIG_NOMCARPETA.'/'.$pagina;
	$vista_previa = str_replace("//", "/", $vista_previa);
	goto_url($vista_previa);
}else{
	echo ("<center><img src=\"../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Alert\" border=\"0\" align=\"absmiddle\"> <font class=\"grana\" hspace=\"5\"><B>".t("viewpagenotfound")." (<font color=\"#0E449A\">$pagina</font>)</B><br><a href=\"javascript:window.close();\"><b>".t("close")."</b></a></font></center>");
}
?>


