<?php
header("Expires: Mon, 6 Jan 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0


function ErrorPage($html, $id, $pare, $idiomes) {
  global $CONFIG_URLBASE, $CONFIG_URLABSADMIN, $CONFIG_idiomes, $CONFIG_IDIOMA;

  $html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca" lang="ca">
<head>
  <title>Houdini</title>
  <meta http-equiv="Content-Type" content="text/html;" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  '.$html.'
</body>
</html>
';
  return changePage($html, $id, $pare, $idiomes);
}


function changePage($html, $id, $pare, $idiomes) {
  global $CONFIG_URLBASE, $CONFIG_URLABSADMIN, $CONFIG_idiomes, $CONFIG_IDIOMA;

  $html = str_replace('</head>', '
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="expires" content="0" />
<base href="'.urlHost($CONFIG_URLBASE).'" />

<style type="text/css">
body {
  margin-top: 134px;
}
#admin-houdini-preview {
  background: #0E449A url('.$CONFIG_URLABSADMIN.'/comu/paisos/pict_areacontrol.jpg) no-repeat left top;
  position: absolute;
  top: 0;
  left:0;
  margin: 0;
  width: 100%;
  height: 134px;
  padding: 0;
  text-align: left;
  vertical-align: center;
  font-family: Verdana, Helvetica, Geneva, sans-serif;
  font-weight: bold;
}
#admin-houdini-preview a {
  color: #333333;
  text-decoration: none;
  font-size: 11px;
}
#admin-houdini-preview a {
  color: #333333;
  text-decoration: none;
  font-size: 11px;
}

#admin-houdini-preview-options {
  font-size: 10px;
  height: auto;
  margin: 5px;
  list-style: none;
  padding-left: 100px;
}
.admin-houdini-preview-option {
  float: left;
  background-color: #ffffff;
  margin: 3px 5px;

}
.admin-houdini-preview-option h1{
  position: relative;
  top: auto;
  left: auto;
  color: #FF9900;
  font-size: 12px;
  background-color: #152E6D;
  margin: 0;
  padding: 5px;
  height:auto;
  background-image:none;
  width:auto;
}
.admin-houdini-preview-option h1 span{
  color: #ffffff;
}
.admin-houdini-preview-option-desc{
  color: #B7BED5;
  background-color: #152E6D;
  margin: 0;
  padding: 5px;
}
.admin-houdini-preview-option-body {
  margin: 0;
  padding: 5px;
  text-align: center;
  vertical-align: middle;
  height: 30px;
}
.admin-houdini-preview-option-body label, .admin-houdini-preview-option-body input{
	display: inline;
	width: auto !important;
	border: 0;
	padding: 0;
  vertical-align: middle;
}

#admin-houdini-preview-foot {
  clear:both;
  padding-left: 100px;
}
#admin-houdini-preview-modify {
  padding: 5px 30px 5px 5px;
  background: #e9f2f8 url('.$CONFIG_URLABSADMIN.'/comu/ico_edit.gif) no-repeat 95% 50%;
}
#admin-houdini-preview-cancel {
  padding: 5px 30px 5px 5px;
  background: #e9f2f8 url('.$CONFIG_URLABSADMIN.'/comu/ico_cancel.gif) no-repeat 95% 50%;
}
#admin-houdini-preview-modify, #admin-houdini-preview-cancel {
  display: block;
  float: right;
  margin: 5px;
}
#admin-houdini-preview-modify:hover, #admin-houdini-preview-cancel:hover{
  background-color: #ffffff;
}

#admin-houdini-preview-lang {
  height: auto;
  margin: 5px;
  padding: 0;
  list-style: none;
}
#admin-houdini-preview-lang li{
  padding: 0;
  margin: 0;
  float: left;
}
#admin-houdini-preview-lang li a, #admin-houdini-preview-lang li span {
  color: #333333;
  font-size: 11px;
  background-color: #778DC3;
  display: block;
  padding: 5px 20px 5px 5px;
  float: left;
  margin: 5px;
}
#admin-houdini-preview-lang li span {
  background-color: #ffffff;
  margin: 5px;
}

.admin-houdini-preview-ca {
  padding-right: 20px;
  background: url('.$CONFIG_URLABSADMIN.'/comu/paisos/ca.gif) no-repeat right center;
}
.admin-houdini-preview-es {
  padding-right: 20px;
  background: url('.$CONFIG_URLABSADMIN.'/comu/paisos/es.gif) no-repeat right center;
}
.admin-houdini-preview-en {
  padding-right: 20px;
  background: url('.$CONFIG_URLABSADMIN.'/comu/paisos/en.gif) no-repeat right center;
}

.admin-houdini-preview-publish {
  padding: 4px 22px 4px 0px;
  background: url('.$CONFIG_URLABSADMIN.'/comu/ico_publish.gif) no-repeat right center;
}
.admin-houdini-preview-unpublish {
  padding: 4px 22px 4px 0px;
  background: url('.$CONFIG_URLABSADMIN.'/comu/ico_unpublish.gif) no-repeat right center;
}

</style>
</head>
  ', $html);





  $publishEntry = '';
  if (accessGroupPerm('page_publish')) {

    $selectLangs = '';

    foreach ($idiomes as $value) {
      $selectLangs .= '
<label class="admin-houdini-preview-'.$value['codi'].'" for="admin-houdini-preview-'.$value['codi'].'">'.$value['text'].'</label><input id="admin-houdini-preview-'.$value['codi'].'" type="checkbox" name="entrys[]" value="'.$value['id'].'" />
';
    }

    $publishEntry = '';
    $i = 1;
    if (count($idiomes) >1) {
      $publishEntry = '
<div class="admin-houdini-preview-option">
  <h1><span>Pas '.$i.'.</span> '.t("staticpagepreviewselect").'</h1>
  <div class="admin-houdini-preview-option-desc">'.t("staticpagepreviewselectlong").'</div>
  <div class="admin-houdini-preview-option-body">
    '.$selectLangs.'
  </div>
</div>
';
      $i++;
    }
    else {
      $publishEntry = '<input type="hidden" name="entrys[]" value="'.$idiomes[0]['id'].'" />';
    }



    $publishEntry = '
<form id="admin-houdini-preview-options" action="'.$CONFIG_URLABSADMIN.'/pagines/crearestatic_idiomes.php" method="post">

'.$publishEntry.'
<div class="admin-houdini-preview-option">
  <h1><span>Pas '.$i.'.</span> '.t("staticpagepreviewapply").'</h1>
  <div class="admin-houdini-preview-option-desc">'.t("staticpagepreviewapplylong").'</div>
  <div class="admin-houdini-preview-option-body">
    <label class="admin-houdini-preview-publish" for="admin-houdini-preview-publish">'.t("publish").'</label><input id="admin-houdini-preview-publish" type="radio" name="accio" value="publish" />
    <label class="admin-houdini-preview-unpublish" for="admin-houdini-preview-unpublish">'.t("unpublish").'</label><input id="admin-houdini-preview-unpublish" type="radio" name="accio" value="unpublish" />
  </div>
</div>

<div class="admin-houdini-preview-option">
  <h1><span>Pas '.($i+1).'.</span> '.t("staticpagepreviewaction").'</h1>
  <div class="admin-houdini-preview-option-desc">'.t("staticpagepreviewactionlong").'</div>
  <div class="admin-houdini-preview-option-body">
    <input type="hidden" name="carpeta"  value="'.$pare.'" />
    <input type="submit" name="go"  value="'.t('go').' »" />
  </div>
</div>


</form>
    ';
  }

  $editEntry = '';
  if (accessGroupPerm('page_edit')) {
    $editEntry = '<a id="admin-houdini-preview-modify" href="'.$CONFIG_URLABSADMIN.'/pagines/edita.php?ID='.$id.'&amp;carpeta='.$pare.'">'.t("modify").'</a>';
  }




  $lang = '';
  foreach ($idiomes as $value) {
    if ($value['actiu']){
      $lang .= '
<li>
  <span class="admin-houdini-preview-'.$value['codi'].'">
    '.$value['text'].'
  </span>
</li>
';
    }else{
      $lang .= '
<li>
  <a class="admin-houdini-preview-'.$value['codi'].'" href="'.$CONFIG_URLABSADMIN.'/pagines/preview.php?ID='.$value['id'].'&amp;carpeta='.$pare.'">
    '.$value['text'].'
  </a>
</li>
';
    }

  }



  $html = str_replace('</body>', '
<div id="admin-houdini-preview">
'.$publishEntry.'
<div id="admin-houdini-preview-foot">
<ul id="admin-houdini-preview-lang">
'.$lang.'
</ul>
'.$editEntry.'
<a href="'.$CONFIG_URLABSADMIN.'/pagines/index.php?carpeta='.$pare.'" id="admin-houdini-preview-cancel">'.t("cancel").'</a>
</div>
</div>
</body>
  ', $html);

  return $html;
}





require ('../config_admin.inc');
accessGroupPermCheck('page_read');

include_once("estatiques.php");

include("check_moduls.php");

include_once('variables.inc');

$ID=$_GET['ID'];

//crida base de dades

$result=db_query("select
 ID, ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START_TIME, END_TIME, MODIFICAT,
 USUARICREAR, USUARIMODI, NOMPAG, DESCRIPCIO,IDIOMA,REFERENCIA,METATITOL, METADESCRIPCIO, METAKEYS,
 PARE, PLANTILLAID, MENU1, MENU2, MENU3, BANNER1, BANNER2, BANNER3, TEXTC1, TEXTC2, TEXTC3, TEXTC4, TEXTC5, TEXTC6,
 TEXTC7, TEXTC8, TEXTC9, TEXTC10, TEXTC11, TEXTC12, TEXTC13, TEXTC14, TEXTC15, TEXTC16, TEXTC17, TEXTC18, TEXTC19,
 TEXTC20, TEXTC21, TEXTC22, TEXTC23, TEXTC24, TEXTC25, TEXTC26, TEXTC27, TEXTC28, TEXTC29, TEXTC30, TEXTC31, TEXTC32,
 TEXTC33, TEXTC34, TEXTC35, TEXTC36, TEXTC37, TEXTC38, TEXTC39, TEXTC40, TEXTC41, TEXTC42, TEXTC43, TEXTC44, TEXTC45,
 IMATGE1, IMATGE2, IMATGE3, IMATGE4, IMATGE5, IMATGE6, IMATGE7, IMATGE8, IMATGE9, IMATGE10, IMATGE11, IMATGE12,
 IMATGE13, IMATGE14, IMATGE15, IMATGE16, IMATGE17, IMATGE18, IMATGE19, IMATGE20, IMATGE21, IMATGE22, IMATGE23,
 IMATGE24, IMATGE25, ADJUNT1, ADJUNT2, ADJUNT3, ADJUNT4, ADJUNT5, ADJUNT6, ADJUNT7, ADJUNT8, ADJUNT9, ADJUNT10,
 ALT1, ALT2, ALT3, ALT4, ALT5, ALT6, ALT7, ALT8, ALT9, ALT10, CERCADOR,
 OP1, OP2, OP3, OP4, OP5
  from ESTATICA where ID=$ID");
$row = db_fetch_array($result);

for ($i = 1; $i <=$PAGE_max_textl; $i++) {
  $row['TEXTL'.$i] = db_select_text('ESTATICA', 'TEXTL'.$i, 'ID = '.$row['ID']);
}

$valors = generate_page ($row, true);


$text_idiomes = array();
foreach ($CONFIG_idiomes[$CONFIG_IDIOMA] as $value) {
  $trosos = explode ("_", $value);
  $text_idiomes[$trosos[2]] = $trosos[1];
}

if (!isset($_GET['single'])) {
  //crear pestanyes idiomes
  if ($row['REFERENCIA']!=0) {
    $referencia = $row['REFERENCIA'];
  }
  else {
    $referencia = $row['ID'];
  }
  $resultidioma=db_query("select ID,IDIOMA from ESTATICA where (ESTATICA.ID = '".$referencia."') OR (ESTATICA.REFERENCIA = '".$referencia."') ORDER BY ID ASC");
  $idiomes = array();
  while($rowidioma = db_fetch_array($resultidioma)) {
    $idioma = array('id' => $rowidioma['ID'], 'codi' => $rowidioma['IDIOMA'], 'text' => $text_idiomes[$rowidioma['IDIOMA']]);
    if ($row['ID'] == $rowidioma['ID']){
      $idioma['actiu'] = true;
    }else{
      $idioma['actiu'] = false;
    }
    $idiomes[] = $idioma;

  }
}
else {
  $idiomes = array(array('id' => $row['ID'], 'codi' => $row['IDIOMA'], 'text' => $text_idiomes[$row['IDIOMA']], 'actiu' => true));
}



if (!is_array($valors)) {
  echo ErrorPage($valors, $ID, $row['PARE'], $idiomes);
}
else {
  $valors['normal'] = phpEval($valors['normal']);
  echo changePage($valors['normal'], $ID, $row['PARE'], $idiomes);
}
db_free_result($result);


?>
