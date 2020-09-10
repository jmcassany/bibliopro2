<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_read');

//COMPROVEM SI TE ACCES A AQUEST MODUL
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL

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
  ID, NOMPAG, IMATGE1, IMATGE2, IMATGE3, IMATGE4, IMATGE5, IMATGE6, IMATGE7, IMATGE8, IMATGE9, IMATGE10, IMATGE11, IMATGE12,
 IMATGE13, IMATGE14, IMATGE15, IMATGE16, IMATGE17, IMATGE18, IMATGE19, IMATGE20, IMATGE21, IMATGE22, IMATGE23,
 IMATGE24, IMATGE25
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
						 	echo ("<img src=\"../comu/elimina_imatges.gif\" alt=\"".t("delete")." ".t("images")."\" width=\"60\" height=\"44\" border=\"0\">");
						}else{
							echo ("<img src=\"../comu/veure_imatge.gif\" alt=\"".t("images")."\" width=\"52\" height=\"44\" border=\"0\">");
						}
					?>

					</td>
					<td class="text" bgcolor="#FDDBCA"><b><?php echo t("images"); ?>:</b> <?php echo $row['NOMPAG']; ?></td>
					<td align="right" valign="top" bgcolor="#C0CEE4" width="27" style="border-left:solid #FFFFFF 10px;"><a href="javascript:window.close();"><img src="../comu/icon_tanca.gif" alt="<?php echo t("close"); ?>" width="27" height="15"  vspace="6" border="0"></a>&nbsp;</td>
				</tr>
			</table>
		</td>


	</tr>
	<tr>
		<td colspan="2" class="text" >
		<div style="border:solid #000000 1px;padding:15px;">
			<table cellpadding="8" cellspacing="8"  border="0">

<?php
for($i = 1; $i <= 19; $i++) {

  if ($i%3 == 1) {
    echo '<tr>';
  }

  echo '<td style="border:solid #CCCCCC 1px;">';

  if ($row['IMATGE'.$i] != "") {
    $tipusimg=explode(".",$row['IMATGE'.$i]);
    if ($tipusimg['1']=="swf") {
      echo ('
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
WIDTH="80" HEIGHT="80" id="flashhoudini" ALIGN="">
<PARAM NAME="movie" VALUE="'.$CONFIG_URLUPLOADIM.'/'.$row['IMATGE'.$i].'">
<PARAM NAME="quality" VALUE="high>
<PARAM NAME=bgcolor VALUE=#000000>
<EMBED src="'.$CONFIG_URLUPLOADIM.'/'.$row['IMATGE'.$i].'" quality="high" bgcolor="#000000"  WIDTH="80" HEIGHT="80" NAME="flashhoudini" ALIGN=""
TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
</OBJECT>
');
    }
    else {
      echo ('<img src="'.$CONFIG_URLUPLOADIM.'/'.$row['IMATGE'.$i].'" width="80" height="80" border="0" hspace="5">');
    }
    if ($eliminar == '1') {
      echo ('
<br><center>
<a href="eliminar_img.php?ID='.$row['ID'].'&camptaula=IMATGE'.$i.'&file='.$row['IMATGE'.$i].'&carpeta='.$carpeta.'" class="text10">
<b>'.t('delete').'</b>
<img src="../comu/bt_eliminar.gif" width="19" height="18" align="absmiddle" border="0" hspace="4" vspace="3"></a></center>
');
    }
  }

  echo '</td>';
  if ($i%3 == 0) {
    echo '</tr>';
  }

}
?>

			</table>
		</div>
		</td>
	</tr>
</table>



</body>
</html>
