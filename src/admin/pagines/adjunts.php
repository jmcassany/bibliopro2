<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_read');

include("check_moduls.php");

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body>
<?php
  $ID=$_GET['ID'];
  $eliminar=$_GET['eliminar'];
  $result=db_query("select
  ID, ADJUNT1, ADJUNT2, ADJUNT3, ADJUNT4, ADJUNT5, ADJUNT6, ADJUNT7, ADJUNT8, ADJUNT9, ADJUNT10
  from ESTATICA where ID='$ID'");
  $row = db_fetch_array($result);
?>


<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0A2082 1px;padding-left:10px;padding-right:10px;padding-bottom:5px;" width="460" border="0">
	<tr>
		<td width="133" style="padding-right:0px;"><img src="../comu/houdini_popup.gif" alt="Houdini" width="133" height="44" vspace="5" border="0"></td>
		<td class="text"  style="padding-left:8px;" width="327">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td bgcolor="#FDDBCA" width="60">
					<?php
						 if ($eliminar == '1'){
						 	echo ("<img src=\"../comu/elimina_attach.gif\" alt=\"".t("delete")." ".t("files")."\" width=\"60\" height=\"44\" border=\"0\">");
						}else{
							echo ("<img src=\"../comu/veure_attach.gif\" alt=\"".t("files")."\" width=\"52\" height=\"44\" border=\"0\">");
						}
					?>

					</td>
					<td class="text" bgcolor="#FDDBCA"><b><?php echo t("files"); ?>:</b> <?php echo $row['NOMPAG']; ?></td>
					<td align="right" valign="top" bgcolor="#C0CEE4" width="27" style="border-left:solid #FFFFFF 10px;"><a href="javascript:window.close();"><img src="../comu/icon_tanca.gif" alt="<?php echo t("delete"); ?>" width="27" height="15"  vspace="6" border="0"></a>&nbsp;</td>
				</tr>
			</table>
		</td>


	</tr>
	<tr>
		<td colspan="2" class="text"  >
		<div style="border:solid #000000 1px;padding:15px;">
			<table cellpadding="8" cellspacing="8"  border="0">
				<tr>
					<td style="border:solid #CCCCCC 1px;">
						<?php
							 if ($row['ADJUNT1'] != ""){
							  $extensio = explode (".",$row['ADJUNT1']);
							  $nom = explode ("_",$row['ADJUNT1']);
							  $icoimatge="../comu/ico_".$extensio['1'].".gif";
							  if (!file_exists($icoimatge)){
							  	$icoimatge="../comu/ico_pingu.gif";
							  }
							  echo ("<center><img src=\"$icoimatge\" width=\"22\" height=\"24\" alt=\"".$extensio['1']."\" border=\"0\" vspace=\"2\">");
							  echo ("<br><a href=\"$CONFIG_URLUPLOAD/pdf/".$row['ADJUNT1']."\" target=\"_blank\">".$nom['0']."</a></center>") ;
							  if ($eliminar == '1') echo ("<br><center><a href=\"eliminar_img.php?ID=".$row['ID']."&carpeta=".$carpeta."&camptaula=ADJUNT1&file=".$row['ADJUNT1']."&categoria=1\" class=\"text10\"><b>".t('delete')."</b><img src=\"../comu/bt_eliminar.gif\" width=\"19\" height=\"18\" align=\"absmiddle\" border=\"0\" hspace=\"4\" vspace=\"3\"></a></center>");
							 }
						?>
					</td>
					<td style="border:solid #CCCCCC 1px;">
						<?php
							 if ($row['ADJUNT2'] != ""){
							  $extensio = explode (".",$row['ADJUNT2']);
							  $nom = explode ("_",$row['ADJUNT2']);
							  $icoimatge="../comu/ico_".$extensio['1'].".gif";
							  if (!file_exists($icoimatge)){
							  	$icoimatge="../comu/ico_pingu.gif";
							  }
							  echo ("<center><img src=\"$icoimatge\" width=\"22\" height=\"24\" alt=\"".$extensio['1']."\" border=\"0\" vspace=\"2\">");
							  echo ("<br><a href=\"$CONFIG_URLUPLOAD/pdf/".$row['ADJUNT2']."\" target=\"_blank\">".$nom['0']."</a></center>") ;
							  if ($eliminar == '1') echo ("<br><center><a href=\"eliminar_img.php?ID=".$row['ID']."&carpeta=".$carpeta."&camptaula=ADJUNT2&file=".$row['ADJUNT2']."&categoria=1\" class=\"text10\"><b>".t('delete')."</b><img src=\"../comu/bt_eliminar.gif\" width=\"19\" height=\"18\" align=\"absmiddle\" border=\"0\" hspace=\"4\" vspace=\"3\"></a></center>");
							 }
						?>
					</td>
					<td style="border:solid #CCCCCC 1px;">
						<?php
							 if ($row['ADJUNT3'] != ""){
							  $extensio = explode (".",$row['ADJUNT3']);
							  $nom = explode ("_",$row['ADJUNT3']);
							  $icoimatge="../comu/ico_".$extensio['1'].".gif";
							  if (!file_exists($icoimatge)){
							  	$icoimatge="../comu/ico_pingu.gif";
							  }
							  echo ("<center><img src=\"$icoimatge\" width=\"22\" height=\"24\" alt=\"".$extensio['1']."\" border=\"0\" vspace=\"2\">");
							  echo ("<br><a href=\"$CONFIG_URLUPLOAD/pdf/".$row['ADJUNT3']."\" target=\"_blank\">".$nom['0']."</a></center>") ;
							  if ($eliminar == '1') echo ("<br><center><a href=\"eliminar_img.php?ID=".$row['ID']."&carpeta=".$carpeta."&camptaula=ADJUNT3&file=".$row['ADJUNT3']."&categoria=1\" class=\"text10\"><b>".t('delete')."</b><img src=\"../comu/bt_eliminar.gif\" width=\"19\" height=\"18\" align=\"absmiddle\" border=\"0\" hspace=\"4\" vspace=\"3\"></a></center>");
							 }
						?>
					</td>


				</tr>
				<tr>
					<td style="border:solid #CCCCCC 1px;">
						<?php
							 if ($row['ADJUNT4'] != ""){
							  $extensio = explode (".",$row['ADJUNT4']);
							  $nom = explode ("_",$row['ADJUNT4']);
							  $icoimatge="../comu/ico_".$extensio['1'].".gif";
							  if (!file_exists($icoimatge)){
							  	$icoimatge="../comu/ico_pingu.gif";
							  }
							  echo ("<center><img src=\"$icoimatge\" width=\"22\" height=\"24\" alt=\"".$extensio['1']."\" border=\"0\" vspace=\"2\">");
							  echo ("<br><a href=\"$CONFIG_URLUPLOAD/pdf/".$row['ADJUNT4']."\" target=\"_blank\">".$nom['0']."</a></center>") ;
							  if ($eliminar == '1') echo ("<br><center><a href=\"eliminar_img.php?ID=".$row['ID']."&carpeta=".$carpeta."&camptaula=ADJUNT4&file=".$row['ADJUNT4']."&categoria=1\" class=\"text10\"><b>".t('delete')."</b><img src=\"../comu/bt_eliminar.gif\" width=\"19\" height=\"18\" align=\"absmiddle\" border=\"0\" hspace=\"4\" vspace=\"3\"></a></center>");
							 }
						?>
					</td>

					<td style="border:solid #CCCCCC 1px;">
						<?php
							 if ($row['ADJUNT5'] != ""){
							  $extensio = explode (".",$row['ADJUNT5']);
							  $nom = explode ("_",$row['ADJUNT5']);
							  $icoimatge="../comu/ico_".$extensio['1'].".gif";
							  if (!file_exists($icoimatge)){
							  	$icoimatge="../comu/ico_pingu.gif";
							  }
							  echo ("<center><img src=\"$icoimatge\" width=\"22\" height=\"24\" alt=\"".$extensio['1']."\" border=\"0\" vspace=\"2\">");
							  echo ("<br><a href=\"$CONFIG_URLUPLOAD/pdf/".$row['ADJUNT5']."\" target=\"_blank\">".$nom['0']."</a></center>") ;
							  if ($eliminar == '1') echo ("<br><center><a href=\"eliminar_img.php?ID=".$row['ID']."&carpeta=".$carpeta."&camptaula=ADJUNT5&file=".$row['ADJUNT5']."&categoria=1\" class=\"text10\"><b>".t('delete')."</b><img src=\"../comu/bt_eliminar.gif\" width=\"19\" height=\"18\" align=\"absmiddle\" border=\"0\" hspace=\"4\" vspace=\"3\"></a></center>");
							 }
						?>
					</td>
					<td style="border:solid #CCCCCC 1px;">
						<?php
							 if ($row['ADJUNT6'] != ""){
							  $extensio = explode (".",$row['ADJUNT6']);
							  $nom = explode ("_",$row['ADJUNT6']);
							  $icoimatge="../comu/ico_".$extensio['1'].".gif";
							  if (!file_exists($icoimatge)){
							  	$icoimatge="../comu/ico_pingu.gif";
							  }
							  echo ("<center><img src=\"$icoimatge\" width=\"22\" height=\"24\" alt=\"".$extensio['1']."\" border=\"0\" vspace=\"2\">");
							  echo ("<br><a href=\"$CONFIG_URLUPLOAD/pdf/".$row['ADJUNT6']."\" target=\"_blank\">".$nom['0']."</a></center>") ;
							  if ($eliminar == '1') echo ("<br><center><a href=\"eliminar_img.php?ID=".$row['ID']."&carpeta=".$carpeta."&camptaula=ADJUNT6&file=".$row['ADJUNT6']."&categoria=1\" class=\"text10\"><b>".t('delete')."</b><img src=\"../comu/bt_eliminar.gif\" width=\"19\" height=\"18\" align=\"absmiddle\" border=\"0\" hspace=\"4\" vspace=\"3\"></a></center>");
							 }
						?>
					</td>

				</tr>
				<tr>
					<td style="border:solid #CCCCCC 1px;">
						<?php
							 if ($row['ADJUNT7'] != ""){
							  $extensio = explode (".",$row['ADJUNT7']);
							  $nom = explode ("_",$row['ADJUNT7']);
							  $icoimatge="../comu/ico_".$extensio['1'].".gif";
							  if (!file_exists($icoimatge)){
							  	$icoimatge="../comu/ico_pingu.gif";
							  }
							  echo ("<center><img src=\"$icoimatge\" width=\"22\" height=\"24\" alt=\"".$extensio['1']."\" border=\"0\" vspace=\"2\">");
							  echo ("<br><a href=\"$CONFIG_URLUPLOAD/pdf/".$row['ADJUNT7']."\" target=\"_blank\">".$nom['0']."</a></center>") ;
							  if ($eliminar == '1') echo ("<br><center><a href=\"eliminar_img.php?ID=".$row['ID']."&carpeta=".$carpeta."&camptaula=ADJUNT7&file=".$row['ADJUNT7']."&categoria=1\" class=\"text10\"><b>".t('delete')."</b><img src=\"../comu/bt_eliminar.gif\" width=\"19\" height=\"18\" align=\"absmiddle\" border=\"0\" hspace=\"4\" vspace=\"3\"></a></center>");
							 }
						?>
					</td>
					<td style="border:solid #CCCCCC 1px;">
						<?php
							 if ($row['ADJUNT8'] != ""){
							  $extensio = explode (".",$row['ADJUNT8']);
							  $nom = explode ("_",$row['ADJUNT8']);
							  $icoimatge="../comu/ico_".$extensio['1'].".gif";
							  if (!file_exists($icoimatge)){
							  	$icoimatge="../comu/ico_pingu.gif";
							  }
							  echo ("<center><img src=\"$icoimatge\" width=\"22\" height=\"24\" alt=\"".$extensio['1']."\" border=\"0\" vspace=\"2\">");
							  echo ("<br><a href=\"$CONFIG_URLUPLOAD/pdf/".$row['ADJUNT8']."\" target=\"_blank\">".$nom['0']."</a></center>") ;
							  if ($eliminar == '1') echo ("<br><center><a href=\"eliminar_img.php?ID=".$row['ID']."&carpeta=".$carpeta."&camptaula=ADJUNT8&file=".$row['ADJUNT8']."&categoria=1\" class=\"text10\"><b>".t('delete')."</b><img src=\"../comu/bt_eliminar.gif\" width=\"19\" height=\"18\" align=\"absmiddle\" border=\"0\" hspace=\"4\" vspace=\"3\"></a></center>");
							 }
						?>
					</td>

					<td style="border:solid #CCCCCC 1px;">
						<?php
							 if ($row['ADJUNT9'] != ""){
							  $extensio = explode (".",$row['ADJUNT9']);
							  $nom = explode ("_",$row['ADJUNT9']);
							  $icoimatge="../comu/ico_".$extensio['1'].".gif";
							  if (!file_exists($icoimatge)){
							  	$icoimatge="../comu/ico_pingu.gif";
							  }
							  echo ("<center><img src=\"$icoimatge\" width=\"22\" height=\"24\" alt=\"".$extensio['1']."\" border=\"0\" vspace=\"2\">");
							  echo ("<br><a href=\"$CONFIG_URLUPLOAD/pdf/".$row['ADJUNT9']."\" target=\"_blank\">".$nom['0']."</a></center>") ;
							  if ($eliminar == '1') echo ("<br><center><a href=\"eliminar_img.php?ID=".$row['ID']."&carpeta=".$carpeta."&camptaula=ADJUNT9&file=".$row['ADJUNT9']."&categoria=1\" class=\"text10\"><b>".t('delete')."</b><img src=\"../comu/bt_eliminar.gif\" width=\"19\" height=\"18\" align=\"absmiddle\" border=\"0\" hspace=\"4\" vspace=\"3\"></a></center>");
							 }
						?>
					</td>

				</tr>
				<tr>
					<td style="border:solid #CCCCCC 1px;">
						<?php
							 if ($row['ADJUNT10'] != ""){
							  $extensio = explode (".",$row['ADJUNT10']);
							  $nom = explode ("_",$row['ADJUNT10']);
							  $icoimatge="../comu/ico_".$extensio['1'].".gif";
							  if (!file_exists($icoimatge)){
							  	$icoimatge="../comu/ico_pingu.gif";
							  }
							  echo ("<center><img src=\"$icoimatge\" width=\"22\" height=\"24\" alt=\"".$extensio['1']."\" border=\"0\" vspace=\"2\">");
							  echo ("<br><a href=\"$CONFIG_URLUPLOAD/pdf/".$row['ADJUNT10']."\" target=\"_blank\">".$nom['0']."</a></center>") ;
							  if ($eliminar == '1') echo ("<br><center><a href=\"eliminar_img.php?ID=".$row['ID']."&carpeta=".$carpeta."&camptaula=ADJUNT10&file=".$row['ADJUNT10']."&categoria=1\" class=\"text10\"><b>".t('delete')."</b><img src=\"../comu/bt_eliminar.gif\" width=\"19\" height=\"18\" align=\"absmiddle\" border=\"0\" hspace=\"4\" vspace=\"3\"></a></center>");
							 }
						?>
					</td>
					<td></td>
					<td></td>
				</tr>

			</table>
		</div>
		</td>
	</tr>
</table>


</body>
</html>



