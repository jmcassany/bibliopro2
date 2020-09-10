<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_edit');

include_once("estatiques.php");

include("check_moduls.php");

   $ID=$_GET['ID'];
   //capçelera de situacio
$situacio ="<a href='index.php?carpeta=".$carpeta."'>".$nomcarpeta."</a><img src=\"../comu/kland_etsa.gif\" width=\"19\" height=\"5\" border=\"0\">";
	//fi capçelera de situacio


?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function doTemplate(myForm) {
  PLANTILLA = myForm.PLANTILLA.value
  ot1 = document.getElementById("t1")
  if (PLANTILLA == "") {
          ot1.src = ""
  } else {
          ot1.src = "../plantilles/veure.php?plantilla=" + PLANTILLA
  }
}

function doPreview(myForm) {
  if (myForm.PLANTILLA.value == "") {
          alert("<?php echo t("staticpagesdopreviewerror"); ?>")
  } else {
          javascript:window.open('../plantilles/veure.php?plantilla=' + myForm.PLANTILLA.value)
  }

}
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form action="update_plantilla.php" method="post" name="FORM" >

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;padding:5px;">
	<!-- situacio Sou a -->
	<tr>
		<td class="text10" bgcolor="#FDDBCA" style="padding:6px;" colspan="2"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("staticpagestitle"); ?></b></td>
	</tr>
	<tr>
		<td  style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="80%" class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><?php echo $situacio.t("change")." ".t("template"); ?><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("staticpagesselecttemplate"); ?></font></td>
					<td width="20%" class="vermell10b" align="right">

					<a href="javascript:history.back();" class="vermell10b"><img src="../comu/icon_cancelar.gif" alt="<?php echo t("cancel"); ?>" width="26" height="19" border="0" align="absmiddle"><?php echo t("cancel"); ?></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->
	<tr>
		<td class="text" >

			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:10px;border:solid #CCCCCC 1px;" >
				<td   valign="top" ><img src="../comu/ico_info2.gif" width="12" height="12" alt="Info"></td>
				<td class="#99ff66" valign="top" style="padding-left:0px;" class="text10" >
				<?php
					if ($missatge==1){
						echo "Heu mogut la plana a una carpeta on no es pot utilitzar la plantilla que ara té assignada.<br>Si us plau, escolliu una nova plantilla per a la plana.<br><br>";
					}
				?>
				És possible que si feu un canvi de plantilla, alguns camps de text no siguin visibles.<br>
				Això no significa que els hàgiu perdut, sinó que la nova plantilla té menys camps per mostrar els continguts de la plana a que voleu assignar-la.
				</td>
			</table>
			<br>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:10px;" bgcolor="#F0F0F0">
				<tr>
					<td class="text10"  valign="top" >
						<img src="../comu/icon_escull_plantilla.gif" alt="<?php echo t("staticpagesselecttemplate"); ?>" width="28" vspace="5" height="22" border="0" align="absmiddle"><b><?php echo t("staticpagesselecttemplate"); ?></b><br>
						<!-- PART CENTRAL DADES-->
						<select name="PLANTILLA" class="formulari" style="width:400px;margin-bottom:8px;" onChange="doTemplate(this.form)" size="13" >
						<option value="" title=""><?php echo t("none"); ?></option>
						<?php

$result=db_query("select ID, NOM, DESCRIPCIO,PARE, ECLASS from PLANTILLA");
while($row = db_fetch_array($result)) {
  if (($row['ECLASS'] == 2 && $row['PARE'] == $carpeta) || ($row['ECLASS'] == 1 && preg_match('#^'.folderPath($row['PARE']) . '#',folderPath($carpeta)))) {
    echo('<option value="'.$row['ID'].'">'.$row['DESCRIPCIO'].'</option>');
  }
}

							db_free_result($result);
						?>
						<!-- /PART CENTRAL DADES-->
						</select>
						<br>

						<input type="hidden" name="USUARIMODI" value="<?php echo accessGetLogin(); ?>">
						<INPUT TYPE="hidden" NAME="ID"  class="formulari" value="<?php echo $ID; ?>">
						<INPUT TYPE="hidden" NAME="PARE"  class="formulari" value="<?php echo $carpeta; ?>">
						<input type="submit" name="Submit" value="Aplicar el canvi">	<br><br>
					</td>
					<td  valign="top"  class="text10" style="padding-top:18px;">
					<img src="../comu/icon_plantilla.gif" alt="<?php echo t("staticpagespreviewtemplate"); ?>" width="22" height="14" vspace="5" border="0" align="absmiddle"><b><?php echo t("staticpagespreviewtemplate"); ?></b><br>

						<SCRIPT language="JavaScript">
						<!--
						var browserName=navigator.appName;
						//Detect IE5.0+
						version=0
						if (navigator.appVersion.indexOf("MSIE")!=-1){
							temp=navigator.appVersion.split("MSIE")
							version=parseFloat(temp[1])
						}

						if (version>=5.0 && browserName=="Microsoft Internet Explorer"){ //NON IE browser will return 0
						document.write('<iframe id=t1 src="" border="1" style="width:800px;height:580px;zoom:30%;"></iframe>')

						}
						else
						{
							document.write('<iframe id=t1 src="" border="1" style="width:240px;height:174px;"></iframe>')

						}
						//-->
						</SCRIPT>
						<br><br>


						 <input type="button"  name="Preview" value="<?php echo t("staticpageszoomtemplate"); ?>" class="Text50" onClick="doPreview(this.form)" style="border:solid #000000 1px;font-size: 9px;background-color:#FFFFFF;">

					</td>
				</tr>
			</table>
		</td>

	</tr>
</table>
<?php echo htmlFoot(); ?>
</form>
</body>
</html>