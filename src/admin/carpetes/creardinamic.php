<?php

require ('../config_admin.inc');
accessGroupPermCheck('folder_create');

require ('variables.inc');

$nom = strtolower(normalizeFile($_POST['NOMCARPETA']));

if (!folderIsValid(folderPath($_POST['PARE']), $nom)) {
  htmlPageError('<b>'.$nom.':</b> '.t("folderserrornovalid"));
}

$result = db_query("select ID from CARPETES where PARE=".$_POST['PARE']." and NOMCARPETA='".stripslashes($nom)."'");
if (db_num_rows($result) > 0) {
  htmlPageError('<b>'.$nom.':</b> '.t("folderserrornorepeat"));
}


$_POST['INTRODUCCIO'] = htmlFilter($_POST['INTRODUCCIO']);

$result = db_query("insert into CARPETES (NOMCARPETA,PARE,CREATION,DESCRIPCIO,USUARICREAR,CATEGORY1,TITOL,SUBTITOL,APARTAT,INTRODUCCIO,CATEGORY2,SKIN,MENU1,MENU2,MENU3,BANNER1,BANNER2,BANNER3,RSS,CARPETAINICI,IDIOMA,METATITOL,METADESCRIPCIO,METAKEYS) values ('".addslashes($nom)."',".$_POST['PARE'].",sysdate(),'".addslashes($_POST['DESCRIPCIO'])."','".accessGetLogin()."','1','".addslashes($_POST['TITOL'])."','".addslashes($_POST['SUBTITOL'])."','".addslashes($_POST['APARTAT'])."','".addslashes($_POST['INTRODUCCIO'])."','".$_POST['CATEGORY2']."','".$_POST['SKIN']."','".$_POST['MENU1']."','".$_POST['MENU2']."','".$_POST['MENU3']."','".$_POST['BANNER1']."','".$_POST['BANNER2']."','".$_POST['BANNER3']."','".$_POST['RSS']."','".$_POST['CARPETAINICI']."','".$_POST['IDIOMA']."','".addslashes($_POST['METATITOL'])."','".addslashes($_POST['METADESCRIPCIO'])."','".addslashes($_POST['METAKEYS'])."')");
if ($result) {
  $result = db_query("select MAX(ID) as ID FROM CARPETES");
  $row = db_fetch_array($result);
  $id = $row['ID'];
  addPerm($row['ID']);

  /*crear la taula per l'editora*/
  $dbengine = substr($db_url, 0, strpos($db_url, '://'));
  if (file_exists('sql/'.$dbengine.'.sql')) {
    $dbfile = 'sql/'.$dbengine.'.sql';
  }
  else {
    $dbfile = 'sql/mysql.sql';
  }
  $fd = fopen($dbfile, 'r');
  $sql = fread($fd, filesize($dbfile));
  fclose($fd);

  $sql = str_replace('|nomtaula|', staticFolderTableName($id), $sql);
  $result = db_query($sql);

  /*crear carpeta*/
  folderGenerate(folderPath($_POST['PARE']), $nom);


  $result = db_query("select * FROM CARPETES where ID = ".$id);
  $row = db_fetch_array($result);
  $missatge = dinFolderGenerateFiles ($row);
  if (!is_string($missatge)) {
    $missatge='<img src="../comu/ico_upodatedok.gif" width="13" height="14" hspace="5" border="0"><br>'.t('foldersregistrydinamiccreated').': <b>'.$nom.'</b><br><br><b><a href="index.php?carpeta='.$_POST['PARE'].'" class="botonavegacio">'.t('continue').'</a></b>';
  }

  //// Inserta al registre d'accions
  register_add(t('foldersregistrydinamiccreated'), $nom);
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
