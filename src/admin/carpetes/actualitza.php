<?php

require ('../config_admin.inc');
accessGroupPermCheck('folder_edit');

require ('variables.inc');

$nom = normalizeFile($_POST['NOMCARPETA']);
$nomanterior = normalizeFile($_POST['NOMANTERIOR']);

if ($nom != $nomanterior) {

  if (!folderIsValid(folderPath($_POST['PARE']), $nom)) {
    htmlPageError('<b>'.$nom.':</b> '.t("folderserrornovalid"));
  }

  /*buscar si el nou nom ja està usat*/
  $result = db_query("select ID from CARPETES where PARE=".$_POST['PARE']." and NOMCARPETA='".stripslashes($nom)."'");
  if (db_num_rows($result) > 0) {
    htmlPageError('<b>'.$nom.':</b> '.t("folderserrornorepeat"));
  }
}

/*actualitzar carpeta*/
$result = db_query("UPDATE CARPETES SET NOMCARPETA='".addslashes($nom)."',MODIFICAT=sysdate(),USUARIMODI='".accessGetLogin()."',DESCRIPCIO='".addslashes($_POST['DESCRIPCIO'])."',CARPETAINICI='".$_POST['CARPETAINICI']."' where ID='".$_POST['ID']."'");
if ($result) {
  for($i=0;$i<count($CONFIG_idiomes[$CONFIG_IDIOMA]);$i++){
    $trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA][$i]);
    $numerocategoria=$trozos['0'];
    $idioma=$trozos['1'];
    $codiidioma=$trozos['2'];
    $variable_titol = "TITOL_".$codiidioma;
    $variable_metakeys = "METAKEYS_".$codiidioma;    
    staticFolderLangSet($_POST['ID'], $codiidioma, $_POST[$variable_titol], $_POST[$variable_metakeys]);
  }

  if ($nom != $nomanterior) {
    folderRename (folderPath($_POST['PARE']), $nomanterior, $nom);
  }
  else {
    folderGenerate(folderPath($_POST['PARE']), $nom);
  }

  $missatge='<img src="../comu/ico_upodatedok.gif" width="13" height="14" hspace="5" border="0"><br>'.t('foldersregistryupdate').': <b>'.$nom.'</b><br><br><b><a href="'.$_POST['urlnavegacio'].'" class="botonavegacio">'.t('continue').'</a></b>';
  //// Inserta al registre d'accions
  register_add(t('foldersregistryupdate'), $nom);
  // fi inserta

}
else {
  htmlPageError(t('folderserrorupdate').' <b>'.$nom.'</b>');
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
		<td class="text" align="center"><br /><br />
			<?php echo $missatge; ?>
			<br><br>
		</td>
	</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
