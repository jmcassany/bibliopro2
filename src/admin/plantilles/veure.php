<?php
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1'
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0'

require ('../config_admin.inc');
accessGroupPermCheck('template_read');
include_once("plantilles.php");


if(isset($_GET['plantilla']) && $_GET['plantilla'] != '') {
  $result = db_query("select * from PLANTILLA where ID=".$_GET['plantilla']);
  if(db_num_rows($result) > 0) {
    $row = db_fetch_array($result);
    $plantilla=$row['NOM'];
    $targetfilename = $CONFIG_PATHTEMPLATEEST.'/'.$plantilla;
  }


}



if (isset($targetfilename) && file_exists($targetfilename)) {
//  ob_start();
//  include($targetfilename);
//  $content = ob_get_contents();
//  ob_end_clean();
	$content = file_get_contents($targetfilename);






  /*eliminar comentaris*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/base/comentaris.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/base/comentaris.inc');
    $content = comments_pages($content);
  }

  /*afegir blocks de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/block/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/block/funcions.inc');
    $content = block_pages($content, null, null, true);
  }

  /*afegir menus estatics de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc');
    $content = menu_pages($content, null, null, true);
  }

  /*afegir menus estatics de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/composicions/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/composicions/funcions.inc');
    $content = composicio_pages($content, null, null, true);
  }

  /*afegir metas de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/metatags/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/metatags/funcions.inc');
    $content = metas_pages($content, null, null, true);
  }

  /*afegir idioma*/
  $content = str_replace('|IDIOMA_PAG|', 'ca', $content);
  $pageElements['IDIOMA_PAG'] = 'ca';

  /*crear fil d'ariadna*/
  $navegasituacio = fil_ariadna ('Previsualització', 0, 'ca');
  $content = str_replace('|SITUACIO|', $navegasituacio, $content);
  $pageElements['SITUACIO'] = $navegasituacio;


  /*arreglem camps problematics*/
//  $arrayBuscados = array('|METAS|','|CONFIG_NOMCARPETA|','|CONFIG_PATHPHP|','|CONFIG_PATHBASE|');
//  $arrayReemplazar = array('',$CONFIG_NOMCARPETA,$CONFIG_PATHPHP,$CONFIG_PATHBASE);
//  $content = str_replace($arrayBuscados, $arrayReemplazar, $content);
//  $arrayBuscados = array('|CONFIG_URLBASE|','|CONFIG_SITENAME|');
//  $arrayReemplazar = array($CONFIG_URLBASE,$CONFIG_SITENAME);
//  $content = str_replace($arrayBuscados, $arrayReemplazar, $content);



  /*afegir paths*/
  $content = str_replace('|CONFIG_NOMCARPETA|', $CONFIG_NOMCARPETA, $content);
  $content = str_replace('|CONFIG_PATHBASE|', $CONFIG_PATHBASE, $content);
  $content = str_replace('|CONFIG_PATHPHP|', $CONFIG_PATHPHP, $content);
  $content = str_replace('|CONFIG_URLBASE|', $CONFIG_URLBASE, $content);
  $content = str_replace('|CONFIG_SITENAME|', $CONFIG_SITENAME, $content);


  $content = pageFilter ($content);



  echo phpEval($content);

}else{
  echo ('<html><header></header><body>');
  echo ("<center><img src=\"../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Alert\" border=\"0\" align=\"absmiddle\"> <font class=\"grana\" hspace=\"5\"><B>".t("templatenotfound")."</B><br><a href=\"javascript:window.close();\"><b>".t("close")."</b></a></font></center>");
  echo ('</body></html>');
}
?>
