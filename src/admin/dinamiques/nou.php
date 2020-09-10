<?php

require ('../config_admin.inc');
accessGroupPermCheck('dinamic_create');

include_once("dinamiques.php");
include_once('categories/funcions.inc');

//COMPROVEM SI TE ACCES A AQUEST MODUL
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL

$ITEMS['CARDS_CATEGORY2']['ESP'] =cat2items($DIN);
if (count($ITEMS['CARDS_CATEGORY2']['ESP']) == 0){
  $ITEMS['CARDS_CATEGORY2']['ESP'] =array('0_'.t("notcategoriesdefined"));
}

$numdecaracters=strlen($descripciocarpeta);
if($numdecaracters<58){
	$descripciocarpeta= $descripciocarpeta;
}else{
	$descripciocarpeta = substr ($descripciocarpeta, 0, 55);
	$descripciocarpeta= $descripciocarpeta."...";
}
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<?php echo editor_head($idiomaEditora); ?>
<script type="text/javascript" src="<?php echo $CONFIG_URLADMIN;?>/js/formularis/jquery.maskedinput-1.1.2.pack.js"></script>
<script type="text/javascript">
jQuery(function($){
   $("#CALENDAR_START_TIME").mask("99/99/9999");
   $("#CALENDAR_END_TIME").mask("99/99/9999");
   $("#START_TIME").mask("99/99/9999");
   $("#END_TIME").mask("99/99/9999");
});
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div id="contingut">
<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td class="text10" bgcolor="#FDDBCA" style="padding:6px;" colspan="2"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php t("dinamicstitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php?DIN=<?php echo $DIN; ?>"><?php echo $descripciocarpeta; ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("createregistry"); ?></font></td>
					<td align="right" style="padding-right:2px;"><a href="../mapaweb.php" onclick="obrir('../mapaweb.php',650,400); return false;" class="text9"><?php echo t("viewmapweb"); ?></a> <a href="javascript:obrir('../mapaweb.php',650,400)"><img src="../comu/ico_mapaweb.gif" alt="Veure mapa del web" width="36" height="18" border="0" align="absmiddle"></a></td>
				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("createregistry"); ?></td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="create.php" method="post" enctype="multipart/form-data">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="620" cellpadding="5" cellspacing="0">
			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("dinamicsformtitle"); ?>:</TD>
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="TITOL" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
			</TR>

			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("dinamicsformresum"); ?>:</TD>
			   <TD valign=top width="80%">
<?php echo editor_entry('RESUM', '','Antavianabasic'); ?>
				</TD>
			</TR>
			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("dinamicsformtext"); ?>:</TD>
			   <TD valign=top width="80%" class=text>
<?php echo editor_entry('DESCRIPCIO', '','Antaviana'); ?>
			  </TD>
			</TR>

			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("date"); ?>:</TD>
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="DATA" SIZE="50" MAXLENGTH="250"  class="formulari"></TD>
			</TR>

			<TR>
			   <TD  valign=top  class="text10" colspan=2><b><?php echo t("link"); ?>:</b>
			   		<!-- vincles -->
					<table cellpadding="0" cellspacing="0" border="0" width="558" style="border:solid #CCCCCC 1px;">
						<tr style="padding-top:5px;">
							<td></td>
							<td class="text10"><?php echo t("url"); ?></td>
							<td class="text10"><?php echo t("text"); ?></td>
							<td class="text10"><?php echo t("newwindow"); ?></td>
						</tr>
						<tr style="padding:5px;">
							<td class="text10">1</td>
							<td><INPUT TYPE="text" NAME="LINK1"   SIZE="50" MAXLENGTH="250" class="formulari" style="width:190;"></td>
							<td><INPUT TYPE="text" NAME="TEXTLINK1"   SIZE="50" MAXLENGTH="250" class="formulari" style="width:190;"></td>
							<td align="center"><select name='FINESTRA1'>
								<option value='0' selected><?php echo t("no"); ?></option>
								<option value='1'><?php echo t("yes"); ?></option>
							</select>
							</td>
						</tr>
						<tr style="padding:5px;">
							<td class="text10">2</td>
							<td><INPUT TYPE="text" NAME="LINK2"   SIZE="50" MAXLENGTH="250" class="formulari" style="width:190;"></td>
							<td><INPUT TYPE="text" NAME="TEXTLINK2"   SIZE="50" MAXLENGTH="250" class="formulari" style="width:190;"></td>
							<td align="center"><select name='FINESTRA2'>
								<option value='0' selected><?php echo t("no"); ?></option>
								<option value='1'><?php echo t("yes"); ?></option>
								</select>
							</td>
						</tr>
						<tr style="padding:5px;">
							<td class="text10">3</td>
							<td><INPUT TYPE="text" NAME="LINK3"   SIZE="50" MAXLENGTH="250" class="formulari" style="width:190;"></td>
							<td><INPUT TYPE="text" NAME="TEXTLINK3"   SIZE="50" MAXLENGTH="250" class="formulari" style="width:190;"></td>
							<td align="center"><select name='FINESTRA3'>
								<option value='0' selected><?php echo t("no"); ?></option>
								<option value='1'><?php echo t("yes"); ?></option>
								</select>
							</td>
						</tr>
					</table>
			   </TD>
			</TR>

			<TR>
			   <TD  valign=top  class="text10" colspan=2><b><?php echo t("image"); ?>:</b>
			   		<!-- imatges -->
					<table cellpadding="0" cellspacing="0" border="0" width="558" style="border:solid #CCCCCC 1px;">
						<tr style="padding-top:5px;">
							<td class="text10" style="padding:5px;" width="10%"><?php echo t("image"); ?></td>
							<td style="padding:5px;"><input type="file" name="img1" size=50 class="formulari" style="width:250px;"></td>
						</tr>
						<tr style="padding:5px;">
							<td class="text10" style="padding:5px;"><?php echo t("text"); ?></td>
							<td style="padding:5px;"><INPUT TYPE="text" NAME="PEU_IMATGE1"  SIZE="50" MAXLENGTH="250" class="formulari" style="width:160"></td>
						</tr>
<!--						<tr style="padding-top:5px;">
							<td class="text10" style="padding:5px;" width="10%"><?php echo t("image"); ?></td>
							<td style="padding:5px;"><input type="file" name="img2" size=50 class="formulari" style="width:250px;"></td>
						</tr>
						<tr style="padding:5px;">
							<td class="text10" style="padding:5px;"><?php echo t("text"); ?></td>
							<td style="padding:5px;"><INPUT TYPE="text" NAME="PEU_IMATGE2"  SIZE="50" MAXLENGTH="250" class="formulari" style="width:160"></td>
						</tr>
						<tr style="padding-top:5px;">
							<td class="text10" style="padding:5px;" width="10%"><?php echo t("image"); ?></td>
							<td style="padding:5px;"><input type="file" name="img3" size=50 class="formulari" style="width:250px;"></td>
						</tr>
						<tr style="padding:5px;">
							<td class="text10" style="padding:5px;"><?php echo t("text"); ?></td>
							<td style="padding:5px;"><INPUT TYPE="text" NAME="PEU_IMATGE3"  SIZE="50" MAXLENGTH="250" class="formulari" style="width:160"></td>
						</tr>-->
					</table>
			   </TD>
			</TR>
			<TR>
			   <TD  valign=top  class="text10" colspan=2><b><?php echo t("file"); ?>:</b>
			   		<!-- adjunts -->
					<table cellpadding="0" cellspacing="0" border="0" width="558" style="border:solid #CCCCCC 1px;">
						<tr>
							<td class="text10" style="padding:5px;"  width="10%"><?php echo t("file"); ?></td>
							<td style="padding:5px;"><input type="file" name="file1" size=50 class="formulari"></td>

						</tr>
						<tr >
							<td class="text10" style="padding:5px;"><?php echo t("text"); ?></td>
							<td style="padding:5px;"><INPUT TYPE="text" NAME="TEXT_ADJUNT1"  SIZE="50" MAXLENGTH="250" class="formulari" style="width:160"></td>
						</tr>
						<tr>
							<td class="text10" style="padding:5px;"  width="10%"><?php echo t("file"); ?></td>
							<td style="padding:5px;"><input type="file" name="file2" size=50 class="formulari"></td>

						</tr>
						<tr >
							<td class="text10" style="padding:5px;"><?php echo t("text"); ?></td>
							<td style="padding:5px;"><INPUT TYPE="text" NAME="TEXT_ADJUNT2"  SIZE="50" MAXLENGTH="250" class="formulari" style="width:160"></td>
						</tr>
						<tr>
							<td class="text10" style="padding:5px;"  width="10%"><?php echo t("file"); ?></td>
							<td style="padding:5px;"><input type="file" name="file3" size=50 class="formulari"></td>

						</tr>
						<tr >
							<td class="text10" style="padding:5px;"><?php echo t("text"); ?></td>
							<td style="padding:5px;"><INPUT TYPE="text" NAME="TEXT_ADJUNT3"  SIZE="50" MAXLENGTH="250" class="formulari" style="width:160"></td>
						</tr>
					</table>
			   </TD>
			</TR>


			<TR>
			   <TD  valign=top  class="text10" colspan=2><b><?php echo t("date")." ".t("publish"); ?>:</b>
			   		<!-- dates publicació -->
			   		<table cellpadding="0" cellspacing="0" border="0" width="558" style="border:solid #CCCCCC 1px;">
						<tr>
							<td class="text10" width="80" style="padding:5px;"><?php echo t("date")." ".t("start"); ?>: (<?php echo t("dateformat"); ?>)</td>
							<td class="text10" style="padding:5px;"><input type="text" id="START_TIME" name="START_TIME" value="01/01/0001" maxlength="10" class="formulari" style="width:80px;"> <button type="reset" id="START_TIME_BUTTON" class="boto_calendari" title="<?php echo t("dinamicsformselectdata"); ?>"><img src="../comu/bt_calendari.gif" alt="<?php echo t("dinamicsformselectdata"); ?>"  /></button>
							<input type="hidden" name="START_TIME_HOUR" value="00"><input type="hidden" name="START_TIME_MIN" value="00"><input type="hidden" name="START_TIME_SEC" value="00">
							</td>

							<td class="text10" width="80" style="padding:5px;"><?php echo t("date")." ".t("end"); ?>: (<?php echo t("dateformat"); ?>)</td>
							<td class="text10" style="padding:5px;"><input type="text" id="END_TIME" name="END_TIME" value="01/01/0001" maxlength="10" class="formulari" style="width:80px;"> <button type="reset" id="END_TIME_BUTTON" class="boto_calendari" title="<?php echo t("dinamicsformselectdata"); ?>"><img src="../comu/bt_calendari.gif" alt="<?php echo t("dinamicsformselectdata"); ?>"/></button>
							<input type="hidden" name="END_TIME_HOUR" value="23"><input type="hidden" name="END_TIME_MIN" value="59"><input type="hidden" name="END_TIME_SEC" value="59">
							</td>
						</tr>
						<tr style="padding:5px;">
							<td class="text10" colspan="4" style="padding:5px;"><?php echo t("activate"); ?> <input type="radio" name="VISIBILITY" value="2" ><?php echo t("yes"); ?> <input type="radio" name="VISIBILITY" value="1" checked><?php echo t("no"); ?></td>

						</tr>
					</table>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "START_TIME",      // id of the input field
        ifFormat       :    "%d/%m/%Y",       // format of the input field
        showsTime      :    false,            // will display a time selector
        button         :    "START_TIME_BUTTON",   // trigger for the calendar (button ID)
        singleClick    :    true,           // double-click mode
        step           :    1,            // show all years in drop-down boxes (instead of every other year as default)
        weekNumbers	   :    false
    });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "END_TIME",      // id of the input field
        ifFormat       :    "%d/%m/%Y",       // format of the input field
        showsTime      :    false,            // will display a time selector
        button         :    "END_TIME_BUTTON",   // trigger for the calendar (button ID)
        singleClick    :    true,           // double-click mode
        step           :    1,            // show all years in drop-down boxes (instead of every other year as default)
        weekNumbers	   :    false
    });
</script>

			   </TD>
			</TR>



			<TR>
			   <TD class=text valign=top colspan="2" style="padding-top:10px;">
<?php

$total= count($ITEMS['CARDS_CATEGORY2']['ESP']);
if ($total > 0){
	echo t("dinamicsselectcategory").": <select name='CATEGORY2'>";
	for($i=0;$i<$total;$i++){
		$apartat=explode ("_",$ITEMS['CARDS_CATEGORY2']['ESP'][$i]);
		echo ("<option value='$apartat[0]'>$apartat[1]</option>");
	 }
	 echo "</select>";
}
?>
			   </TD>
			</TR>

			<TR>
			   <TD valign=top align=center colspan=2>
			   <INPUT TYPE="hidden" NAME="DIN"  class="formulari" value="<?php echo $DIN; ?>">
			   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t('create'); ?>" class=boto>
			   </TD>
			</TR>

			</TABLE>
		</td>
		<!-- /FORMULARI ENTRADA -->

	</tr>


</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</form>
</div>
</body>
</html>
