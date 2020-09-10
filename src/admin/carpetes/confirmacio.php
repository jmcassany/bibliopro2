<?php

require ('../config_admin.inc');
accessGroupPermCheck('folder_delete');

$result = db_query('select * from CARPETES where ID = '.$_GET['ID']);
$row = db_fetch_array($result);
db_free_result($result);

if ($row['CATEGORY1'] == 1) {
  /*dinamica*/
  $missatge = t("folderconfirmdinamicdelete");
  $urlForm = 'eliminar_dinamic.php';
}
else {
  /*estatica*/
  $missatge = t("folderconfirmdelete");
  $urlForm = 'eliminar_estatic.php';
}

require $CONFIG_PATHADMIN."/php/lib/imatge_seguretat/securityImageClass.inc";
$si = new securityImage();
$si->setFontColor("000000");
$si->setFontSize(2);
$si->setCodeLength(5);
$si->inputParam = "style='color:#0E449A;width:65px;font-size: 10px;border:solid #0E449A 1px;'";
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
		<td class="grana" align="center" ><br><br>
			<table cellpadding="0" cellspacing="0" width="300">
				<tr>
					<td width="40">
					<img src="../comu/houdini_alerta.gif" alt="Alert" width="19" height="31" hspace="6" border="0" align="absmiddle">
					</td>
					<td class="grana">
					<?php echo $missatge; ?>
					</td>
				</tr>
			</table>
			<br>
		</td>
	</tr>
	<tr>
		<td class="text" align="center" style="padding-bottom:10px;" >
		<form action="<?php echo $urlForm; ?>" method="post">
			<table cellpadding="0" cellspacing="0" border="0" width="300">
				<tr>
					<td colspan="3" valign="top" bgcolor="#E6E6E6" style="padding:5px;" >
						<table>
							<tr>
								<td colspan="2" class="grana"><?php echo t("securitycode"); ?>:</td>
							</tr>
							<tr>
								<td colspan="2" class="text9"><?php echo t("folderconfirmdeleteconfirm"); ?></td>
							</tr>
							<tr>
								<td align="center"><?php echo $si->showFormImage(); ?></td>
								<td class="text9"><b><?php echo t("code"); ?>:</b> <?php echo $si->showFormInput(); ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<br />
			<table cellpadding="0" cellspacing="0" border="0" width="300">


				<tr>

					<td align="center" >

					<input type=hidden name='callback' value='1'>
					<input type="hidden" name="ID" value="<?php echo $_GET['ID']; ?>">
					<input type="hidden" name="carpeta" value="<?php echo $row['NOMCARPETA']; ?>">
					<input type="hidden" name="pare" value="<?php echo $row['PARE']; ?>">
					<INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("delete")." ".t("folder"); ?>"  class="blanc10b" style="border:solid #000000 1px;padding:5px;background-color:#990033;width:135px;height:30px;cursor:hand;">


					</td>

					<td width="50"><spacer type="block" height="1" width="50"></td>
					<td  align="center">
					<INPUT TYPE="buttom" NAME="accion" VALUE="<?php echo t("cancel"); ?>"  class="blanc10b" style="border:solid #000000 1px;padding:5px;padding-top:8px;background-color:#990033;width:95px;height:30px;cursor:hand;text-align:center;" onclick="javascript:history.back();">
					</td>
				</tr>



			</table>

			</form>
		</td>
	</tr>
<?php
  $llistacarpetes = implode(', ',folderListString($_GET['ID']));
?>
	<tr>
		<td class="text9" valign="top" style="padding-top:5px;padding-left:25px;padding-bottom:5px;padding-right:25px;background-color:#fafafa;">
		<img src="../comu/ico_info2.gif" width="12" height="12" alt="Info" align="left">&nbsp;<?php echo t("folderconfirmdeleteinfo"); ?>:
		<?php echo $llistacarpetes; ?>
		</td>
	</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>

