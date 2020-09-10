<?php
header("Expires: Mon, 6 Jan 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0

require ('../config_admin.inc');
accessGroupPermCheck('form_read');

include_once("formularis.php");
require_once('variables.inc');

$ID=$_GET['ID'];
$result=db_query("select * from FORMULARIS where ID=$ID");
$row = db_fetch_array($result);
if (empty($row['ID'])){
  htmlPageBasicError(t("errordbcardscodinotfound"));
}

$valors = generate_page ($row, true);
if (!is_array($valors)) {
  $content = $valors;
}
else {
  $content = $valors['normal'];
}
$content = phpEval($content);
echo changePage($content, $ID);


function changePage($html, $id) {
  global $CONFIG_URLBASE, $CONFIG_URLABSADMIN;

  $html = str_replace('</head>', '
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="expires" content="0" />
<base href="'.urlHost($CONFIG_URLBASE).'" />

<style type="text/css">
  body {
    margin-top: 100px;
  }
  #houdini-admin {
    position: absolute;
    top: 0;
    left:0;
    margin: 0;
    width: 100%;
    height: 100px;
    padding: 0;
    text-align: left;
    vertical-align: center;
    font-family: Verdana, Helvetica, Geneva, sans-serif;
    font-weight: bold;
  }
  #houdini-admin table {
    width: 100%;
  }
  .titblanc {color: #FFFFFF; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 12px; text-decoration: none; font-weight: bold; }
  .menupreview {color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 10px; text-decoration: none; font-weight: bold; }
  .menupreview:hover { text-decoration: underline;color: #333333;}

</style>
</head>
  ', $html);




  $editEntry = '';
  if (accessGroupPerm('form_edit')) {
    $editEntry = '
		<td style="padding-right:10px;">
        <a href="'.$CONFIG_URLABSADMIN.'/formularis/edita.php?ID='.$id.'" class="menupreview">
        <img src="'.$CONFIG_URLABSADMIN.'/comu/bot_edita.gif" alt="'.t("modify").'" width="28" height="19"  border="0" align="absmiddle" />
        '.t("modify").'
        </a>
        </td>';
  }

  $publishEntry = '';
  if (accessGroupPerm('form_publish')) {
    $publishEntry = '
		<td style="padding-right:10px;">
        <a href="'.$CONFIG_URLABSADMIN.'/formularis/crearestatic.php?ID='.$id.'" class="menupreview">
        <img src="'.$CONFIG_URLABSADMIN.'/comu/bot_generar.gif" alt="'.t("generate").'" width="28" height="19" border="0" align="absmiddle" />
        '.t("generate").'
        </a>
        </td>';
  }

  $html = str_replace('</body>', '

<div id="houdini-admin">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="width:132px"><img src="'.$CONFIG_URLABSADMIN.'/comu/logo.gif" width="132" height="52" alt="" border="0" /></td>
		<td class="titblanc" style="padding-left:10px;background-color:#0E449A;height:53px">
			'.t("preview").'
		</td>
	</tr>

</table>
<!-- /CAPÇELERA -->
<table cellpadding="0" cellspacing="0" border="0" style="background-color:#D6D6D6">
	<tr>
'.$publishEntry.'
'.$editEntry.'
		<td style="padding-left:10px;padding-right:40px;width:90px;height:27px;text-align:right" >
        <a href="'.$CONFIG_URLABSADMIN.'/formularis/index.php" class="menupreview">
        <img src="'.$CONFIG_URLABSADMIN.'/comu/bot_cancela.gif" alt="'.t("cancel").'" width="28" height="19" border="0" align="absmiddle" />
        '.t("cancel").'
        </a>
        </td>
	</tr>
</table>
</div>
</body>
  ', $html);

  return $html;
}
?>