<?php

require ('../config_admin.inc');
accessGroupPermCheck('folder_read');


if (!isset($_GET['carpeta']) || $_GET['carpeta']=="") {
  $result = db_query("SELECT * FROM CARPETES where CATEGORY1=0 and PARE is NULL");
  if(db_num_rows($result) < 1){
    htmlPageError(t("folderserrornotexist"));
  }
  $row = db_fetch_array($result);
  $carpeta=$row['ID'];
}
else {
  $carpeta=$_GET['carpeta'];
  $result = db_query("SELECT * FROM CARPETES where CATEGORY1=0 and ID=".$carpeta);
  if(db_num_rows($result) != 1){
    htmlPageError(t("folderserrornotexist"));
  }
  $row = db_fetch_array($result);
}

  //capçelera de situacio
  $path = folderPathArray($carpeta);
  $situacio = '';
  foreach($path as $key => $value) {
    $situacio .="<img src=\"../comu/kland_etsa.gif\" border=\"0\"><a href='index.php?carpeta=$key' class='text10'>".$value."</a>";
  }
  $situacio="<img src=\"../comu/kland_etsa.gif\" width=\"19\" height=\"5\"  border=\"0\" ><a href='index.php' class='text10'>".t("folderstitle")."</a>".$situacio;

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- CAPÇELERA -->
<?php echo htmlHeader(); ?>
<!-- /CAPÇELERA -->


<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="80%" class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php" class="text10"><?php echo t("home"); ?></a><?php echo $situacio; ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:5px;" bgcolor="#0E449A" class="blanc10b" valign="middle">
					<img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("userformstatics"); ?>

					</td>
					<td width="50%" style="padding:5px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0"><?php echo t("userformdinamics"); ?></td>
				</tr>
			</table>
		</td>
	</tr>



	<tr>
		<!-- LLISTAT ESTATIQUES -->
		<td width="50%" style="padding:10px;border-right:solid #CCCCCC 1px;padding-top:0px;" valign="top">
			<!-- Crear planes carpetes -->
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td valign="top" style="padding-bottom:3px;border-bottom:solid #CCCCCC 1px;">
					<?php
						if ($row['PARE'] != null)echo ("<a href=\"index.php?carpeta=".$row['PARE']."\">".t("levelup")."</a>");
					?>
					</td>

					<td align="right" valign="top" style="padding-bottom:3px;;border-bottom:solid #CCCCCC 1px;">
<?php
if (accessGroupPerm('folder_create')) {
?>
<form action="nou.php" method="post" name="FormCrearcarpeta" style="display:inline">
  <input type="hidden" name="PARE" value="<?php echo $carpeta; ?>">
  <button type="submit" class="vermell10b" style="background-color:transparent;cursor:pointer;border:none;text-decoration: none;">
    <img src="../comu/icon_afegir_carpeta.gif" alt="<?php echo t("create")." ".t("foldersstatictitle"); ?>" align="absmiddle" style="margin-right:5px;" /><?php echo t("create")." ".t("foldersstatictitle"); ?>
  </button>
</form>
<?php
}
?>
					</td>
				</tr>

			</table>
			<!-- Crear planes carpetes -->

			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:3px;">
			<?php

$static = staticFolderList($carpeta, false);

foreach($static as $value) {
  echo '
<tr>
  <td class="gris11b" valign="top" style="padding-top:3px;padding-bottom:8px;">
';
  if($value['desc'] == ''){
    $value['desc'] = $value['nom'];
  }
  $icona = '';
  if ($value['pare'] ==null) {
    $icona = 'icon_home.gif';
  }

  if (accessGroupPerm('page_read')) {
    echo '
<a href="index.php?carpeta='.$value['id'].'" class="gris11b" title="'.$value['ruta'].'">
<img src="../comu/icon_estatica.gif" width="29" height="16" alt="'.$value['ruta'].'" border="0">
'.$value['desc'].'
</a>
';
  }
  else {
    echo '
<img src="../comu/icon_estatica.gif" width="29" height="16" alt="'.$value['ruta'].$value['nom'].'" border="0">
'.$value['desc'].'
';
  }
  echo '
  </td>
  <td align="right">
';
  if (accessGroupPerm('folder_edit')) {
    echo '<a href="edita.php?ID='.$value['id'].'"><img src="../comu/icon_modifica.gif" alt="Editar" width="23" height="16" border="0" align="absmiddle"></a>';
  }
  if (accessGroupPerm('folder_delete')) {
    echo '<a href="confirmacio.php?ID='.$value['id'].'"><img src="../comu/icon_borrar.gif" alt="Eliminar" width="22" height="16" border="0" align="absmiddle"></a>';
  }
  echo '
  </td>
</tr>
';
}

?>


			</table>
		</td>
		<!-- /LLISTAT ESTATIQUES -->

		<!-- LLISTAT DINAMIQUES -->
		<td width="50%" style="padding:10px;padding-top:0px;" valign="top">
			<!-- Crear planes carpetes -->
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="right" valign="top" style="padding-bottom:3px;;border-bottom:solid #CCCCCC 1px;">
<?php
if (accessGroupPerm('folder_create')) {
?>
<form action="din_nou.php" method="post" name="FormCrearcarpetaDinamica"  style="display:inline">
  <input type="hidden" name="PARE" value="<?php echo $carpeta; ?>">
  <button type="submit" class="vermell10b" style="background-color:transparent;cursor:pointer;border:none;text-decoration: none;">
    <img src="../comu/carpeta_dinamica.gif" alt="<?php echo t("create")." ".t("foldersdinamictitle"); ?>" align="absmiddle" style="margin-right:5px;" /><?php echo t("create")." ".t("foldersdinamictitle"); ?>
  </button>
</form>
<?php
}
?>
					</td>
				</tr>

			</table>
			<!-- Crear planes carpetes -->
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:3px;">

			<?php

$static = dinamicFolderList($carpeta, false);

foreach($static as $value) {
  echo '
<tr>
  <td class="gris11b" valign="top" style="padding-top:3px;padding-bottom:8px;">
';
  if($value['desc'] == ''){
    $value['desc'] = $value['nom'];
  }

    echo '
<img src="../comu/icon_dinamica.gif" width="29" height="16" alt="'.$value['ruta'].'" border="0">
'.$value['desc'].'
';

  echo '
  </td>
  <td align="right">
';
if (accessGroupPerm('folder_edit')) {
  echo '<a href="edita_din.php?ID='.$value['id'].'"><img src="../comu/icon_modifica.gif" alt="Editar" width="23" height="16" border="0" align="absmiddle"></a>';
}
if (accessGroupPerm('dinamic_category')) {
  echo '<a href="../dinamiques/categories/index.php?DINAMICA='.$value['id'].'"><img src="../comu/ico_categoria_mapa.png" alt="'.t('dincategoryedit').'" width="18" height="16" border="0" align="absmiddle"></a>';
}
if (accessGroupPerm('folder_delete')) {
  echo '<a href="confirmacio.php?ID='.$value['id'].'"><img src="../comu/icon_borrar.gif" alt="Eliminar" width="22" height="16" border="0" align="absmiddle"></a>';
}
  echo '
  </td>
</tr>
';
}
?>

			</table>
		</td>
		<!-- /LLISTAT DINAMIQUES -->
	</tr>
</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</body>
</html>
