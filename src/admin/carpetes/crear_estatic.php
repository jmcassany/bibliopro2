<?php

require ('../config_admin.inc');
accessGroupPermCheck('folder_create');

error_reporting(E_ALL);
ini_set ('display_errors', 1);

require ('variables.inc');

$nom = normalizeFile($_POST['NOMCARPETA']);

if (!folderIsValid(folderPath($_POST['PARE']), $nom)) {
  htmlPageError('<b>'.$nom.':</b> '.t("folderserrornovalid"));
}

$result = db_query("select ID from CARPETES where PARE=".$_POST['PARE']." and NOMCARPETA='".stripslashes($nom)."'");
if (db_num_rows($result) > 0) {
  htmlPageError('<b>'.$nom.':</b> '.t("folderserrornorepeat"));
}


$result = db_query("insert into CARPETES (NOMCARPETA,PARE,CREATION,DESCRIPCIO,USUARICREAR, CARPETAINICI) values ('".addslashes($nom)."','".$_POST['PARE']."',sysdate(),'".addslashes($_POST['DESCRIPCIO'])."','".accessGetLogin()."','".$_POST['CARPETAINICI']."')");
if ($result) {
  $result = db_query("select MAX(ID) as ID FROM CARPETES");
  $row = db_fetch_array($result);
  $id = $row['ID'];
  addPerm($row['ID']);

  for($i=0;$i<count($CONFIG_idiomes[$CONFIG_IDIOMA]);$i++){
    $trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA][$i]);
    $numerocategoria=$trozos['0'];
    $idioma=$trozos['1'];
    $codiidioma=$trozos['2'];
    $variable_titol = "TITOL_".$codiidioma;
    $variable_metakeys = "METAKEYS_".$codiidioma;
    staticFolderLangSet($id, $codiidioma, $_POST[$variable_titol], $_POST[$variable_metakeys]);
  }

  folderGenerate(folderPath($_POST['PARE']), $nom);

  $missatge='<img src="../comu/ico_upodatedok.gif" width="13" height="14" hspace="5" border="0"><br>'.t('foldersregistrycreated').': <b>'.$nom.'</b><br><br><b><a href="index.php?carpeta='.$_POST['PARE'].'" class="botonavegacio">'.t('continue').'</a></b>';
  //// Inserta al registre d'accions
  register_add(t('foldersregistrycreated'), $nom);
  // fi inserta

}
else {
  htmlPageError(t('folderserrorcreate').' <b>'.$nom.'</b>');
}

?>

<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">
	<tr>
		<td class="text" align="center"><br><br>
			<?php echo $missatge; ?>
			<br><br>
		</td>
	</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>