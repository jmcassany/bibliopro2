<?php

require ('../config_admin.inc');
accessGroupPermCheck('folder_edit');

require ('variables.inc');

$nom = strtolower(normalizeFile($_POST['NOMCARPETA']));
$nomanterior = strtolower(normalizeFile($_POST['NOMANTERIOR']));

if ($nom != $nomanterior) {

  if (!folderIsValid(folderPath($_POST['PARE']), $nom)) {
    htmlPageError('<b>'.$nom.':</b> '.t("folderserrornovalid"));
  }

  /*buscar si el nou nom ja està usat*/
  $result = db_query("select ID from CARPETES where PARE=".$_POST['PARE']." and NOMCARPETA='".stripslashes($nom)."'");
  if (db_num_rows($result) > 0) {
    htmlPageError('<font class="grana"><b>'.$nom.':</b> '.t("folderserrornorepeat").'</font>');
  }
}

$_POST['INTRODUCCIO'] = htmlFilter($_POST['INTRODUCCIO']);

/*actualitzar carpeta*/
$result = db_query("UPDATE CARPETES SET NOMCARPETA='".addslashes($nom)."',MODIFICAT=sysdate(),USUARIMODI='".accessGetLogin()."',DESCRIPCIO='".addslashes($_POST['DESCRIPCIO'])."',TITOL='".addslashes($_POST['TITOL'])."',SUBTITOL='".addslashes($_POST['SUBTITOL'])."',APARTAT='".addslashes($_POST['APARTAT'])."', INTRODUCCIO='".addslashes($_POST['INTRODUCCIO'])."',CATEGORY2='".addslashes($_POST['CATEGORY2'])."',SKIN='".$_POST['SKIN']."',MENU1='".$_POST['MENU1']."',MENU2='".$_POST['MENU2']."',MENU3='".$_POST['MENU3']."',BANNER1='".$_POST['BANNER1']."',BANNER2='".$_POST['BANNER2']."',BANNER3='".$_POST['BANNER3']."', RSS='".$_POST['RSS']."', CARPETAINICI='".$_POST['CARPETAINICI']."', IDIOMA='".$_POST['IDIOMA']."',METATITOL='".addslashes($_POST['METATITOL'])."' ,METADESCRIPCIO='".addslashes($_POST['METADESCRIPCIO'])."', METAKEYS='".addslashes($_POST['METAKEYS'])."' where ID=".$_POST['ID']);
if ($result) {
  if ($nom != $nomanterior) {

    folderRename (folderPath($_POST['PARE']), $nomanterior, $nom);

  }
  else {
    folderGenerate(folderPath($_POST['PARE']), $nom);
  }



  $result = db_query("select * FROM CARPETES where ID = ".$_POST['ID']);
  $row = db_fetch_array($result);
  $missatge = dinFolderGenerateFiles ($row);
  if (!is_string($missatge)) {
    $missatge='<img src="../comu/ico_upodatedok.gif" width="13" height="14" hspace="5" border="0"><br>'.t('foldersregistrydinamicupdate').': <b>'.$nom.'</b><br><br><b><a href="index.php?carpeta='.$_POST['PARE'].'" class="botonavegacio">'.t('continue').'</a></b>';
  }

  //// Inserta al registre d'accions
  register_add(t('foldersregistrydinamicupdate'), $nom);
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
		<td class="text" align="center"><br><br>
			<?php echo $missatge; ?>
			<br><br>
		</td>
	</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
