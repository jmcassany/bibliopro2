<?php

require ('../../config_admin.inc');
accessGroupPermCheck('menu_edit');

include_once("menus.php");


include("variables.php");

$ID=$_GET['ID'];
$result=db_query("select * from MENUS where ID = $ID");


$row = db_fetch_array($result);
if (empty($row['ID'])){
 htmlPageError(t("errordbcardscodinotfound"));
}
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function validar() {
  if (mainform.NOM.value=='') {
    mainform.NOM.focus();
    result = window.open("../php/missatge.php?missatge=<?php echo t("menuerrorformname"); ?>","missatge","left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width=200,height=200,directory=no,resize=no,scrollbars=no");
    return false;
  }else{
    if (mainform.DESCRIPCIO.value=='') {
      mainform.DESCRIPCIO.focus();
      result = window.open("../php/missatge.php?missatge=<?php echo t("menuerrorformdescription"); ?>","missatge","left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width=200,height=200,directory=no,resize=no,scrollbars=no");
      return false;
    }
  }
}
</script>
</head>
<body>

<?php echo htmlHeader(); ?>


<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("menutitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>

					<td  class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php"><?php echo t("menutitle"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("update")." ".t("menujavascript"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("update")." ".$row['NOM'] ?></td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="update.php" method="post"  name="mainform" onsubmit="return validar();">
		<INPUT TYPE="hidden" NAME="ID" VALUE="<?php echo $row['ID']; ?>" class=boto>
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="620" cellpadding="5" cellspacing="0">
			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("name"); ?>:</TD>
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="NOM" SIZE="50" MAXLENGTH="250" class="formulari" value="<?php echo $row['NOM']; ?>"></TD>
			</TR>
			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("description"); ?>:</TD>
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="DESCRIPCIO" SIZE="50" value="<?php echo filtreQuote($row['DESCRIPCIO']); ?>" MAXLENGTH="250" class="formulari"></TD>
			</TR>
			<TR>
				<TD class="text" valign=top width="20%"><?php echo t("language"); ?>:</TD>
				<TD valign=top width="80%">
				 <select class="formulari" name="IDIOMA" style="width:250px;">
			   <?php

					for($i=0;$i<count($CONFIG_idiomes[$CONFIG_IDIOMA]);$i++){
						$trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA][$i]);
						$numerocategoria=$trozos['0'];
						$idioma=$trozos['1'];
						$codiidioma=$trozos['2'];
						if ($row['IDIOMA']==$codiidioma){
							$marca="selected";
						}else{
							$marca="";
						}
						echo"<option value=\"".$codiidioma."\" $marca />".$idioma."</br>";
					}

				?>
			    </select>
				</TD>
			</TR>
 			<TR>
			   <TD class=text valign=top ><?php echo t("type")." ".t("menu"); ?>:</TD>
			   <TD valign=top >
			   		<select name='DESPLEGABLE'>
<?php
foreach ($MENU_tipus as $key => $value) {
  $select = '';
  if ($value == $row['DESPLEGABLE']) {
    $select = ' selected="selected"';
  }
  if (!is_string($key)) {
    $key = $value;
  }
  echo '<option value="'.$value.'" '.$select.'>'.$key.'</option>
  ';
}
?>
					</select>
			   </TD>
			</TR>
			<TR>
			   <TD class=text valign=top ><?php echo t("model")." ".t("menu"); ?>:</TD>
			   <TD valign=top >
			   		<select name='TIPO'>
			   		<?php
							if ($row['TIPO'] == '1'){
								echo("<option value='0'>".t("vertical")."</option>\n
									  <option value='1' selected>".t("horizontal")."</option>
								");

						 	 }else{
						  		echo("<option value='0' selected>".t("vertical")."</option>\n
									  <option value='1'>".t("horizontal")."</option>
								");
						 	 }
						?>

					</select>
			   </TD>
			</TR>
			<TR>
			   <TD class=text valign=top ><?php echo t("style"); ?>:</TD>
			   <TD valign=top >
			   		<select name='ESTIL'>
<?php
foreach ($MENU_estiltext as $key => $value) {
  $select = '';
  if ($value == $row['ESTIL']) {
    $select = ' selected="selected"';
  }
  if (!is_string($key)) {
    $key = $value;
  }
  echo '<option value="'.$value.'" '.$select.'>'.$key.'</option>
  ';
}
?>
					</select>
			   </TD>
			</TR>

			<TR>

			</TR>




<tr>
	<td colspan="2">
		<?php echo t("menuformforothers"); ?><br>
		<input type="radio" name="ACCESSUBCARP" value="0" <?php if($row['ACCESSUBCARP']==0) echo 'checked' ?>><?php echo t("no"); ?>&nbsp;&nbsp;&nbsp;
		<input type="radio" name="ACCESSUBCARP" value="1" <?php if($row['ACCESSUBCARP']==1) echo 'checked' ?>><?php echo t("yes"); ?>
	</td>
</tr>
<TR>
   <TD class=text valign=top ><?php echo t("templateformdata"); ?>:</TD>
   <TD valign=top >
   <select class="formulari"  name="PARE" style="width:250px;">
<?php
echo staticFolderSelect($row['PARE'],true);
?>
   </select>
   </TD>
</TR>




			<TR>
			   <TD valign=top align=center colspan=2>
			   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("update"); ?>" class=boto>
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
</body>
</html>

