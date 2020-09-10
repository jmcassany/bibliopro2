<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_read');

include("check_moduls.php");
//<body onunload="top.opener.location.reload()">
?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>

<body>

<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0A2082 1px;padding-left:10px;padding-right:10px;padding-bottom:5px;" width="460" border="0">
	<tr>
		<td width="133" style="padding-right:0px;"><img src="../comu/houdini_popup.gif" alt="Houdini" width="133" height="44" vspace="5" border="0"></td>
		<td class="text"  style="padding-left:8px;" width="327">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td bgcolor="#FDDBCA" width="60">
						<?php
							$categoria=$_GET['categoria'];
							if ($categoria == 0){
								echo "<img src=\"../comu/elimina_imatges.gif\" width=\"60\" height=\"44\" alt=\"Eliminar imatges\" border=\"0\">";
							}
							if ($categoria == 1){

								echo "<img src=\"../comu/elimina_attach.gif\" width=\"60\" height=\"44\" alt=\"Eliminar arxius\" border=\"0\">";
							}
						 ?>
					</td>
					<td class="text" bgcolor="#FDDBCA"><b>
						<?php
							if ($categoria == 0){
								$TIPOARXIU=t("image");
								$pagina="imatges";
								echo t("delete")." ".t("images");
							}
							if ($categoria == 1){
								$TIPOARXIU=t("file");
								$pagina="adjunts";
								echo t("delete")." ".t("files");
							}

						 ?>
						</b>
					</td>
					<td align="right" valign="top" bgcolor="#C0CEE4" width="27" style="border-left:solid #FFFFFF 10px;"><a href="javascript:window.close();"><img src="../comu/icon_tanca.gif" alt="<?php echo t("close"); ?>" width="27" height="15"  vspace="6" border="0"></a>&nbsp;</td>
				</tr>
			</table>
		</td>


	</tr>
	<tr>
		<td colspan="2" class="text" >
		<div style="border:solid #000000 1px;padding:15px;">
<?php



   $ID=$_GET['ID'];
   $camptaula=$_GET['camptaula'];
   $file=$_GET['file'];
   $data="";
   $sql = "UPDATE ESTATICA SET $camptaula='$data' where ID='$ID'";
   $result = db_query($sql);
   if($result) {
   				$targetfilename = $CONFIG_PATHUPLOADIM."/$file";
				if ($categoria == 1)$targetfilename = $CONFIG_PATHUPLOADAD."/$file";
				if (file_exists($targetfilename)) {
					unlink($targetfilename);
					echo ("&#149;&nbsp;$TIPOARXIU $file ".t("staticpagesdeletefilesmessage1").".<br><br>");

				}else{
					echo ("&#149;&nbsp;$TIPOARXIU $file".t("staticpagesdeletefilesmessage2").".<br><br>");
				}

   } else {
 	  echo ("<a href='javascript:history.back()'>".t("back")."</a>");
 	  echo db_error();
   }
?>
<b><a href="<?php echo $pagina; ?>.php?ID=<?php echo $ID; ?>&eliminar=1&carpeta=<?php echo $carpeta; ?>" class="vinclenoticia"><?php echo t("back"); ?></a> | <a href="javascript:window.close();" class="vinclenoticia"><?php echo t("close"); ?></a></b>
		</div>
		</td>
	</tr>
</table>



</body>
</html>



