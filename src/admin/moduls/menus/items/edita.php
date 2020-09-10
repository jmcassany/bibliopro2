<?php

require ('../../../config_admin.inc');
accessGroupPermCheck('menu_entrys');

   $ID=$_GET['ID'];
   $result=db_query("select * from MENUITEMS Where ID=$ID");
   $row2 = db_fetch_array($result);
   // si el camp menu es buit no es pot continuar
   if(empty($row2['MENU'])){
    	htmlPageBasicError(t("errordbcardscodinotfound"));
   }
   //continuar..
   $result=db_query("select * from MENUS where ID = '".$row2['MENU']."'");
   $row = db_fetch_array($result);
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function eliminar(url){
  if (confirm('<?php echo t("formalertdeleteimage"); ?>')){
    location.href=url;
  }
}
function validar() {
  if (mainform.TEXT.value=='') {
    mainform.TEXT.focus();
    result = window.open("../../php/missatge.php?missatge=<?php echo t("formerrorname")." ".t("text"); ?>","missatge","left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width=200,height=200,directory=no,resize=no,scrollbars=no");
    return false;
  }
}

function MapaWeb()
{
	OpenFileBrowser( '../../../mapaweb.php' ) ;
}
function OpenFileBrowser( url )
{
	var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes,scrollbars=yes" ;
	sOptions += ",width=650";
	sOptions += ",height=400";

	window.open( url, 'MapaWeb', sOptions ) ;
}
function SetUrl( url )
{
	document.getElementById('txtUrl').value = url ;
}
</script>

</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;" colspan="2"><img src="../../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("menutitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../../index.php"><?php echo t("home"); ?></a><img src="../../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php"><?php echo t("menutitle"); ?></a><img src="../../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php?ID=<?php echo $row['ID']; ?>"><?php echo $row['NOM']; ?></a><img src="../../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("update"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../../../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("update"); ?></td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="update.php" method="post" enctype="multipart/form-data"  name="mainform" onsubmit="return validar();">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="100%" cellpadding="5" cellspacing="0">
			<TR>
			   <TD class=text valign=top width="10%"><?php echo t("text"); ?>:</TD>
			   <TD valign=top width="90%"><INPUT TYPE="text" NAME="TEXT" SIZE="50" MAXLENGTH="250" class="formulari" value="<?php echo filtreQuote($row2['TEXT']); ?>"></TD>
			</TR>


			<TR>
			   <TD class=text valign=top><?php echo t("url"); ?>:</TD>
			   <TD valign=top >
			   		<!--<INPUT TYPE="text" NAME="LINKPAGE" value="<?php echo filtreQuote($row2['LINKPAGE']); ?>" SIZE="50" MAXLENGTH="250" class="formulari" style="width:450">
			   		<a href="javascript:obrir('../../../mapaweb.php',650,400);"><?php echo t("viewmapweb"); ?></a>-->
			   		<input id="txtUrl" NAME="LINKPAGE" value="<?php echo filtreQuote($row2['LINKPAGE']); ?>" style="WIDTH: 70%" type="text" onkeyup="OnUrlChange();" onchange="OnUrlChange();" />
			   		<input type="button" value="Mapa Web" onclick="MapaWeb();" />
			   	</TD>
			</TR>

			<TR>
			   <TD class=text valign=top><?php echo t("newwindow"); ?>:</TD>
			   <TD valign=top>
			   		<select name='FINESTRA'>
					<?php
						if ($row2['FINESTRA']=='0'){
							echo("<option value=\"0\" selected>".t("no")."</option>
							<option value=\"1\">".t("yes")."</option>
							");
						}else{
							echo("<option value=\"0\">".t("no")."</option>
							<option value=\"1\" selected>".t("yes")."</option>
							");
						}

					?>

					</select>
			   </TD>
			</TR>
			<TR>
			   <TD class=text valign=top><?php echo t("separator"); ?>:</TD>
			   <TD valign=top>
			   		<select name='SEPARATOR'>
					<?php
						if ($row2['SEPARATOR']=='0'){
							echo("<option value=\"0\" selected>".t("no")."</option>
							<option value=\"1\">".t("yes")."</option>
							");
						}else{
							echo("<option value=\"0\">".t("no")."</option>
							<option value=\"1\" selected>".t("yes")."</option>
							");
						}

					?>

					</select>
			   </TD>
			</TR>

			<TR>
			   <TD class=text valign=top ><?php echo t("image"); ?>:</TD>
			   <TD valign=top ><input type="file" name="img" size=50 class="formulari">
			   </TD>
			</TR>
			<?php
			if($row2['IMATGE']!=""){
				echo ("<TR><TD class=text valign=top colspan=\"2\"><img src=\"".$CONFIG_URLMENU."/img/".$row2['IMATGE']."\"  border=\"0\">&nbsp;<a href=\"javascript:eliminar('eliminar_img.php?ID=".$row2['ID']."&file=".$row2['IMATGE']."');\"><img src=\"../../../comu/icon_borrar.gif\" width=\"22\" height=\"16\" alt=\"Eliminar imatge\" border=\"0\"></a></TD></TR>");
			}
			?>
			<TR>
			   <TD class=text valign=top ><?php echo t("class"); ?>:</TD>
			   <TD valign=top ><input type="text" name="CSSCLASS" size=50 class="formulari" value="<?php echo filtreQuote($row2['CSSCLASS']) ?>"></TD>
			</TR>
			<TR>
			   <TD class=text valign=top ><?php echo t("apartat"); ?>:</TD>
			   <TD valign=top >
					<select name="DIRECTORI">
					<option value="-1"></option>
					<?php
					echo staticFolderSelect($row2['DIRECTORI'], false);
					?>
					</select>


				</TD>
			</TR>
			<!-- editora -->
			<TR>
				<TD class=text valign=top >Editora:</TD>
				<TD valign=top >
					<select name="EDITORA">
					<option value="-1"></option>
					<?php
					echo dinamicFolderSelect($row2['EDITORA']);
					?>
					</select>
			   </TD>
			</TR>


		<TR>
			   <TD valign=top align=center colspan=2>
			   <INPUT TYPE="hidden" NAME="ID" VALUE="<?php echo $row2['ID']; ?>" >
			   <INPUT TYPE="hidden" NAME="MENU" VALUE="<?php echo $row2['MENU']; ?>" >
			   <INPUT TYPE="hidden" NAME="LINKPAGENOM" VALUE="<?php echo $row2['LINKPAGE']; ?>" >

			   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("update"); ?>" class=boto>
			   </TD>
			</TR>

			</TABLE>
		</td>
		<!-- /FORMULARI ENTRADA -->

	</tr>


</table>
<!-- /PART CENTRAL -->
<?php
echo htmlFoot();
?>
</form>
</body>
</html>
