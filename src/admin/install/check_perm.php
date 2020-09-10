<?php

define('path','../');
include_once(path.'/config_admin.inc');

$elements = array(
$CONFIG_PATHBASE,

$CONFIG_PATHMENU,
$CONFIG_PATHMENU.'/img',

$CONFIG_PATHUPLOAD,
$CONFIG_PATHUPLOADIM,
$CONFIG_PATHUPLOADAD,
$CONFIG_PATHUPLOAD.'/imatges',
$CONFIG_PATHUPLOAD.'/arxius',
//$CONFIG_PATHUPLOAD.'/multimedia',
//$CONFIG_PATHUPLOAD.'/flash',

$CONFIG_PATHTITLES,

$CONFIG_PATHTEMPLATE,
$CONFIG_PATHTEMPLATE.'/plantilla.html',
$CONFIG_PATHTEMPLATEEST,
$CONFIG_PATHTEMPLATEDIN,
$CONFIG_PATHTEMPLATEFORM,
//$CONFIG_PATHMETAS,

);

if (file_exists($CONFIG_PATHADMIN.'moduls/composicions')
    || file_exists($CONFIG_PATHADMIN.'moduls/banners')) {
  $elements[] = $CONFIG_PATHBANNER;
  $elements[] = $CONFIG_PATHBANNER.'/selector/';
}
if (file_exists($CONFIG_PATHADMIN.'moduls/caixetes')) {
  $elements[] = $CONFIG_PATHBOX;
  $elements[] = $CONFIG_PATHBOX.'/img/';
  $elements[] = $CONFIG_PATHBOX.'/logs/';
}
if (file_exists($CONFIG_PATHADMIN.'/moduls/view-rss')) {
  $elements[] = $CONFIG_PATHRSS;
  $elements[] = $CONFIG_PATHTEMPLATERSS;
}
if (file_exists($CONFIG_PATHADMIN.'/moduls/enquesta')) {
  $elements[] = $CONFIG_PATHPOLL;
  $elements[] = $CONFIG_PATHTEMPLATEPOLL;
}
if (file_exists($CONFIG_PATHADMIN.'/moduls/block')) {
  $elements[] = $CONFIG_PATHTEMPLATEBLOCK;
}
if (file_exists($CONFIG_PATHADMIN.'/moduls/db_backup/backup')) {
  $elements[] = $CONFIG_PATHADMIN.'/moduls/db_backup/backup/export/';
}
if (file_exists($CONFIG_PATHBASE.'public')) {
  $elements[] = $CONFIG_PATHBASE.'public';
  $elements[] = $CONFIG_PATHBASE.'public/media/upload/anuncis_newsletter';
  $elements[] = $CONFIG_PATHBASE.'public/media/upload/banners_newsletter';
  $elements[] = $CONFIG_PATHBASE.'public/media/upload/noticies_newsletter/files';
  $elements[] = $CONFIG_PATHBASE.'public/media/upload/noticies_newsletter/imgs';
}

?>
<!-- Web by: Can Antaviana SL. www.antaviana.com. 2005 -->
<!-- Antaviana és una empresa especialitzada en el desenvolupament de projectes web i edicio de continguts digitals. -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca" lang="ca">
<head>
  <title>Houdini permissos</title>
  <link rel="stylesheet" href="install.css" type="text/css" />
  <meta http-equiv="Content-Type" content="text/html;charset=utf8" />
</head>
<body>

<div class="border">
<h2 >Houdini&nbsp; |&nbsp; Version 2.0 Comprovació de permissos</h2>
<h3>Copyright &#169; 2004 - Can Antaviana</h3>
</div>

<h4>
En els següents fitxers i directoris el servidor apache ha de poder accedir-hi
per escriptura, comprova que els permissos són els correctes.
</h4>

<table id="taula-permissos" summary="taula permissos">
  <tr>
    <th>
      Fitxer / Dir
    </th>
    <th>
      Existeix
    </th>
    <th>
      Lectura
    </th>
    <th>
      Escriptura
    </th>
  </tr>
<?php

foreach ($elements as $value) {
echo ('  <tr>
');
echo ('    <td class="name">
');
echo $value;
echo ('    </td>
');
echo ('    <td>
');
if (file_exists($value)) {
echo ('      <img src="../comu/ico_simbol_ok.gif" alt="Si" />
');
}
else {
echo ('      <img src="../comu/ico_creueta.gif" alt="No" />
');
}
echo ('    </td>
');
echo ('    <td>
');
if (is_readable($value)) {
echo ('      <img src="../comu/ico_simbol_ok.gif" alt="Si" />
');
}
else {
echo ('      <img src="../comu/ico_creueta.gif" alt="No" />
');
}
echo ('    </td>
');
echo ('    <td>
');
if (is_writable($value)) {
echo ('      <img src="../comu/ico_simbol_ok.gif" alt="Si" />
');
}
else {
echo ('      <img src="../comu/ico_creueta.gif" alt="No" />
');
}
echo ('    </td>
');
echo ('  </tr>
');
}

?>
</table>


</body>
</html>
