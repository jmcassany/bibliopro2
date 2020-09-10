<?php

require ('../config_admin.inc');
accessGroupPermCheck('houdinibasic');

?>
<html>
<head>
<?php echo htmlMetas(); ?>
<style>
  UL {margin: 0 0 0 20}
  LI {margin: 5 5 5 40;list-style-image : url(../comu/miniico_carpeta.gif);}
</style>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"  onload="carregat();">

<?php echo htmlHeader(); ?>

<div id="carregant" style="width: 100%; height: 100%; text-align: center;"><br><br><?php echo t("loading"); ?></div>
<div id="contingut" style="display: none">
<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("utils"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("utils"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->
<!-- moduls -->
	<tr>
		<td colspan="2" style="padding:15px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:5px;" >

				<tr>
					<td valign="top" style="padding-right:10px;" colspan="2">
						<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#EFEFEF">
							<tr>
								<td bgcolor="#0E449A" class="blanc10b" style="padding:5px;" colspan="2"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><b><?php echo t("plugins"); ?></b></td>
							</tr>


						</table>
					</td>
				</tr>
<?php
if (accessGroupPerm('composition') && file_exists($CONFIG_PATHADMIN.'/moduls/composicions') ||
accessGroupPerm('rss') && file_exists($CONFIG_PATHADMIN.'/moduls/view-rss')){
?>
                <tr>
					<td valign="top" style="padding-right:10px;width:50%">
<?php
if (accessGroupPerm('composition') && file_exists($CONFIG_PATHADMIN.'/moduls/composicions')){
?>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">

							<tr>
								<td style="padding:5px;padding-left:15px;padding-right:15px;border-bottom:solid #ccc 1px;" width="22" bgcolor="#D9DFEA"><img src="../comu/icones_moduls/ico_banners.gif" width="22" height="15" alt="<?php echo t('bannersgrouptitle'); ?>" align="absmiddle"></td>
								<td style="padding:5px;border-bottom:solid #ccc 1px;"><a href="../moduls/composicions/index.php" class="blau10b"><?php echo t('bannersgrouptitle'); ?></a></td>
							</tr>
						</table>
<?php
}
?>
					</td>
					<td valign="top" style="padding-right:10px;width:50%">
<?php
if (accessGroupPerm('rss') && file_exists($CONFIG_PATHADMIN.'/moduls/view-rss')){
?>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td style="padding:5px;padding-left:15px;padding-right:15px;border-bottom:solid #ccc 1px;" width="22" bgcolor="#D9DFEA"><img src="../comu/icones_moduls/ico_banners.gif" alt="<?php echo t('viewrsstitle'); ?>" align="absmiddle"></td>
								<td style="padding:5px;border-bottom:solid #ccc 1px;"><a href="../moduls/view-rss/index.php" class="blau10b"><?php echo t('viewrsstitle'); ?></a></td>
							</tr>
						</table>
<?php
}
?>
					</td>
				</tr>
<?php
}
?>
                <tr>
					<td valign="top" style="padding-right:10px;width:50%">
<?php
if (accessGroupPerm('poll') && file_exists($CONFIG_PATHADMIN.'/moduls/enquesta')){
?>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td style="padding:5px;padding-left:15px;padding-right:15px;border-bottom:solid #ccc 1px;" width="22" bgcolor="#D9DFEA"><img src="../comu/icones_moduls/icon_continguts.gif" alt="<?php echo t('polltitle'); ?>" align="absmiddle"></td>
								<td style="padding:5px;border-bottom:solid #ccc 1px;"><a href="../moduls/enquesta/index.php" class="blau10b"><?php echo t('polltitle'); ?></a></td>
							</tr>
						</table>
<?php
}
?>
					</td>
					<td valign="top" style="padding-right:10px;width:50%">
<?php
if (accessGroupPerm('devel_file_browser') && file_exists($CONFIG_PATHADMIN.'/moduls/pfb')){
?>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td style="padding:5px;padding-left:15px;padding-right:9px;border-bottom:solid #ccc 1px;" width="22" bgcolor="#D9DFEA"><img src="../comu/icones_moduls/ico_upload.gif" alt="<?php echo t("devel_file_browser"); ?>" align="absmiddle"></td>
								<td style="padding:5px;border-bottom:solid #ccc 1px;"><a href="../moduls/pfb/index.php" class="blau10b"><?php echo t("devel_file_browser"); ?></a></td>
							</tr>
						</table>
<?php
}
?>

					</td>

				</tr>
				<tr>
					<td valign="top" style="padding-right:10px;width:50%">
<?php
if (accessGroupPerm('questionaris') && file_exists($CONFIG_PATHADMIN.'/moduls/questionaris')){
?>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td style="padding:5px;padding-left:15px;padding-right:15px;border-bottom:solid #ccc 1px;" width="22" bgcolor="#D9DFEA"><img src="../comu/questionaris/icon-houdini-gestio-formularis.gif" alt="<?php echo t('polltitle'); ?>" align="absmiddle"></td>
								<td style="padding:5px;border-bottom:solid #ccc 1px;"><a href="../moduls/questionaris/index.php" class="blau10b">Gestió de qüestionaris</a></td>
							</tr>
						</table>
<?php
}
?>
					</td>
					<td valign="top" style="padding-right:10px;width:50%">
<?php
if (accessGroupPerm('newsletter') && file_exists($CONFIG_PATHADMIN.'/moduls/newsletters')){
?>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td style="padding:5px;padding-left:15px;padding-right:15px;border-bottom:solid #ccc 1px;" width="22" bgcolor="#D9DFEA"><img src="../comu/icones_moduls/icon_newsletter_houdini.gif" alt="" align="absmiddle"></td>
								<td style="padding:5px;border-bottom:solid #ccc 1px;"><a href="../moduls/newsletters/" class="blau10b">Gestió de butlletins digitals</a></td>
							</tr>
						</table>
<?php
}
?>
					</td>
				</tr>
				<tr>
					<td valign="top" style="padding-right:10px;width:50%">
<?php
if (accessGroupPerm('pagaments') && file_exists($CONFIG_PATHADMIN.'/moduls/pagaments')){
?>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td style="padding:5px;padding-left:15px;padding-right:15px;border-bottom:solid #ccc 1px;" width="22" bgcolor="#D9DFEA"><img src="../comu/questionaris/icona-pagaments.gif" alt="" align="absmiddle"></td>
								<td style="padding:5px;border-bottom:solid #ccc 1px;"><a href="../moduls/pagaments/index.php" class="blau10b">Gestió de pagaments</a></td>
							</tr>
						</table>
<?php
}
?>
					</td>
					<td valign="top" style="padding-right:10px;width:50%">
<?php
if (accessGroupPerm('questionaris') && file_exists($CONFIG_PATHADMIN.'/moduls/variables')){
?>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td style="padding:5px;padding-left:15px;padding-right:15px;border-bottom:solid #ccc 1px;" width="22" bgcolor="#D9DFEA"><img src="../comu/ico_opcionsavansades.png" alt="" align="absmiddle"></td>
								<td style="padding:5px;border-bottom:solid #ccc 1px;"><a href="../moduls/variables/index.php" class="blau10b">Gestió de variables</a></td>
							</tr>
						</table>
<?php
}
?>
					</td>
				</tr>
			</table>
<!-- /moduls -->

			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:5px;" >
				<tr>
<?php
if (file_exists($CONFIG_PATHADMIN.'/moduls/historic')) {
?>
					<td valign="top" style="padding-right:10px;width:50%">
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td bgcolor="#0E449A" class="blanc10b" style="padding:5px;"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><b><?php echo t("registryhistory"); ?></b></td>
							</tr>
							<tr>
								<td style="padding:5px;padding-left:30px;border-bottom:solid #ccc 1px;"><img src="../comu/ico_historic1.gif" width="40" height="18" alt="Veure el meu històric" border="0" align="absmiddle"><a href="../moduls/historic/historic_form.php" class="text10"><?php echo t("registryhistoryviewmy"); ?></a></td>
							</tr>
<?php
if (accessGroupPerm('historyall')){
?>
							<tr>
								<td style="padding:5px;padding-left:30px;"><img src="../comu/ico_historic2.gif" width="40" height="18" alt="Veure històric d'accions de tots els usuaris" border="0" align="absmiddle"><a href="../moduls/historic/historic_global_form.php" class="text10"><?php echo t("registryhistoryviewall") ?></a></td>
							</tr>
<?php
}
?>
						</table>
<?php
}
?>
					</td>
					<td valign="top" style="padding-right:10px;width:50%">
<?php
if (file_exists($CONFIG_PATHADMIN.'/moduls/db_backup') && accessGroupPerm('backup_make') && substr($db_url, 0, strpos($db_url, '://')) == 'mysql') {
?>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td bgcolor="#0E449A" class="blanc10b" style="padding:5px;"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><b><?php echo t("databasebackup"); ?></b></td>
							</tr>
							<tr>
								<td style="padding:5px;padding-left:30px;border-bottom:solid #ccc 1px;"><img src="../comu/ico_copia1.gif" width="36" height="18" alt="<?php echo t("dobackup"); ?>" border="0" align="absmiddle"><a href="../moduls/db_backup/index.php" class="text10"><?php echo t("dobackup"); ?></a></td>
							</tr>
<?php
if (accessGroupPerm('backup_restore')) {
?>
							<tr>
								<td style="padding:5px;padding-left:30px;"><img src="../comu/ico_copia2.gif" width="36" height="18" alt="<?php echo t("restorebackup"); ?>" border="0" align="absmiddle"><a href="../moduls/db_backup/index.php?backup_acction=import" class="text10"><?php echo t("restorebackup"); ?></a></td>
							</tr>
<?php
}
?>
						</table>
<?php
}
?>
					</td>
				</tr>












				<tr>
					<td valign="top" style="padding-right:10px;padding-top:10px;">
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td bgcolor="#0E449A" class="blanc10b" style="padding:5px;"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><b>Publicació per blocs</b></td>
							</tr>
							<tr>
								<td style="padding:5px;">
<ul style="padding-left:0">

<?php
if (accessGroupPerm('folder_create')) {
	$result = db_query("SELECT count(*) as count FROM CARPETES where CATEGORY1='0' and !(PARE is NULL)");
	$row = db_fetch_array($result);
	if ($row['count'] > 0){
	?>
		<li><a href="../carpetes/crearestatic_grup.php">Publicar carpetes <small>(<?php echo $row['count'] ?>)</small></a></li>
	<?php
	}
}
if (accessGroupPerm('folder_create')) {
	$result = db_query("SELECT count(*) as count FROM CARPETES where CATEGORY1='1'");
	$row = db_fetch_array($result);
	if ($row['count'] > 0){
	?>
		<li><a href="../carpetes/creardinamic_grup.php">Publicar carpetes dinàmiques <small>(<?php echo $row['count'] ?>)</small></a></li>
	<?php
	}
}
if (accessGroupPerm('rss')) {
	$result = db_query("SELECT count(*) as count FROM VIEWRSS");
	$row = db_fetch_array($result);
	if ($row['count'] > 0){
	?>
		<li><a href="../moduls/view-rss/crearestatic_grup.php">Publicar RSS <small>(<?php echo $row['count'] ?>)</small></a></li>
	<?php
	}
}
if (accessGroupPerm('boxes')) {
	$result = db_query("SELECT count(*) as count FROM CAIXETES");
	$row = db_fetch_array($result);
	if ($row['count'] > 0){
	?>
		<li><a href="../moduls/caixetes/crearestatic_grup.php">Publicar Caixetes <small>(<?php echo $row['count'] ?>)</small></a></li>
	<?php
	}
}
if (accessGroupPerm('composition')) {
	$result = db_query("SELECT count(*) as count FROM BANNERS");
	$row = db_fetch_array($result);
	if ($row['count'] > 0){
	?>
		<li><a href="../moduls/composicions/crearestatic_grup.php">Publicar Composicions <small>(<?php echo $row['count'] ?>)</small></a></li>
	<?php
	}
}
if (accessGroupPerm('poll')) {
	$result = db_query("SELECT count(*) as count FROM ENQUESTA");
	$row = db_fetch_array($result);
	if ($row['count'] > 0){
	?>
		<li><a href="../moduls/enquesta/crearestatic_grup.php">Publicar Enquestes <small>(<?php echo $row['count'] ?>)</small></a></li>
	<?php
	}
}
if (accessGroupPerm('menu')) {
	$result = db_query("SELECT count(*) as count FROM MENUS where STATUS=1");
	$row = db_fetch_array($result);
	if ($row['count'] > 0){
	?>
		<li><a href="../moduls/menus/crearestatic_grup.php">Publicar Menús <small>(<?php echo $row['count'] ?>)</small></a></li>
	<?php
	}
}
if (accessGroupPerm('form_publish')) {
	$result = db_query("SELECT count(*) as count FROM FORMULARIS where STATUS=1");
	$row = db_fetch_array($result);
	if ($row['count'] > 0){
	?>
		<li><a href="../formularis/crearestatic_grup.php">Publicar Formularis <small>(<?php echo $row['count'] ?>)</small></a></li>
	<?php
	}
}
?>




<?php
if (accessGroupPerm('page_publish')) {
if (accessGetLogin()==$USERS_admin) {
	$numResult = db_query("select count(ID) as count from ESTATICA where REFERENCIA=0");
	$numRow = db_fetch_array($numResult);
    echo("<li><a href=\"../pagines/crearestatic_grup.php\">".t("generateallpages")." <small>(".$numRow['count']." pàgines)</a><ul style=\"padding-left:3px\">");
}
$result=db_query("select * from CARPETES Where CATEGORY1='0' ORDER BY NOMCARPETA");

$users = new dbUsers();
$trozos = $users->getComments(accessGetLogin());

while($row = db_fetch_array($result)) {
  //provamoduls
  if (in_array($row['ID'], $trozos)) {
    $text = $row['NOMCARPETA'];
    if ($row['DESCRIPCIO'] != '') {
      $text = $row['DESCRIPCIO'];
    }
	$numResult = db_query("select count(ID) as count from ESTATICA where REFERENCIA=0 and PARE=".$row['ID']);
	$numRow = db_fetch_array($numResult);
    echo("<li><a href=\"../pagines/crearestatic_grup.php?carpeta=".$row['ID']."\">".$text." <small>(".$numRow['count']." pàgines)</small></a></li>");
  }
}
echo ("</ul></li>");
db_free_result($result);
}
?>


</ul>



							</td>
						</tr>
					</table>
					</td>








					<td valign="top" style="padding-right:10px;padding-top:10px;">
						<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:solid #ccc 1px;" bgcolor="#EFEFEF">
							<tr>
								<td bgcolor="#0E449A" class="blanc10b" style="padding:5px;"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><b><?php echo t("others"); ?></b></td>
							</tr>
<?php
if (accessGroupPerm('template_upload')){
?>
							<tr>
								<td style="padding:5px;padding-left:30px;border-bottom:solid #ccc 1px;"><img src="../comu/ico_upload.gif" alt="<?php echo t("upload")." ".t("template"); ?>" width="36" height="18" border="0" align="absmiddle"><a href="javascript:obrir('../plantilles/upload.php',500,200)" class="text10"><?php echo t("upload")." ".t("template"); ?></a></td>
							</tr>
<?php
}
if (file_exists($CONFIG_PATHADMIN.'/moduls/uploads/') && accessGroupPerm('upload_files')){
?>
							<tr>
								<td style="padding:5px;padding-left:30px;border-bottom:solid #ccc 1px;"><img src="../comu/ico_upload.gif" alt="<?php echo t("uploadmanager"); ?>" width="36" height="18" border="0" align="absmiddle"><a href="javascript:obrir('../moduls/uploads/gestor_uploads/browser.php?Type=arxius&Connector=connectors/php/connector.php',650,400)" class="text10"><?php echo t("uploadmanager"); ?></a></td>
							</tr>
<?php
}
?>
							<tr>
								<td style="padding:5px;padding-left:30px;border-bottom:solid #ccc 1px;"><img src="../comu/ico_mapaweb.gif" alt="<?php echo t("viewmapweb"); ?>" width="36" height="18" border="0" align="absmiddle"><a href="javascript:obrir('../mapaweb.php?nocopy',650,400)" class="text10"><?php echo t("viewmapweb"); ?></a></td>
							</tr>
<?php
if (file_exists($CONFIG_PATHADMIN.'/moduls/db_export') && accessGroupPerm('backup_make') && (substr($db_url, 0, strpos($db_url, '://')) == 'mysql')){
?>
							<tr>
								<td style="padding:5px;padding-left:30px;padding-bottom:5px;border-bottom:solid #ccc 1px;"><img src="../comu/ico_export_dades.gif" width="26" height="17" alt="<?php echo t("exportdata"); ?>" align="absmiddle" style="margin-right:10px;"><a href="../moduls/db_export/index.php" class="text10"><?php echo t("exportdata"); ?></a></td>
							</tr>
<?php
}
if (file_exists($CONFIG_PATHADMIN.'/moduls/uploads/') && accessGroupPerm('users_read')){
?>
							<tr>
								<td style="padding:5px;padding-left:30px;padding-bottom:5px;"><img src="../comu/ico_metatags.gif" alt="<?php echo t("utilsmetas"); ?>" width="36" height="18" border="0" align="absmiddle"><a href="../moduls/uploads/index.php" class="text10"><?php echo t("uploadgrouptitle"); ?></a></td>
							</tr>
<?php
}

?>
						</table>
					</td>

				</tr>
			</table>
		</td>
	</tr>







</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</form>
</div>
</body>
</html>
