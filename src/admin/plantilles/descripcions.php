<?php


require ('../config_admin.inc');
accessGroupPermCheck(array('template_edit', 'template_create'));
include_once("plantilles.php");


	$eleccio=$_GET['eleccio'];
	//CONSULTA per saber el numero de camps de la plantilla
	$result=db_query("select * from PLANTILLA where ID = $eleccio");
	$row = db_fetch_array($result);
	$ID=$row['ID'];
	$nomplantilla=$row['NOM'];
	$quantstextcurts=$row['TEXTCURT'];
	$quantstextllargs=$row['TEXTLLARG'];
	$quantesimatges=$row['IMATGES'];
	$quantsadjunts=$row['ADJUNTS'];
	$quantsalts=$row['IMATGES'];
	$quantsop=$row['OP'];
	$iniciatextcurts=0;
	$iniciatextllargs=0;
	$iniciaimatges=0;
	$iniciaadjunts=0;
	$iniciaalts=0;
	$iniciaop=0;
	db_free_result($result);
?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text10" bgcolor="#C0CEE4" style="padding:6px;"><b><?php echo t("templatetitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php"><?php echo t("templatetitle"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="view.php?ID=<?php echo $eleccio; ?>"><?php echo $nomplantilla; ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("templatedefine"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("templatedefine"); ?></td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
			</table>
		</td>
	</tr>


	<tr>
		<form action="update_descrip.php" method="post" name="FORM">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding-left:10px;padding-right:10px;padding-bottom:10px;" valign="top">
				<table cellpadding="2" cellspacing="2" border="0" width="100%">
<?php

$result=db_query("select * from PLANTILLA_DESC where PLANTILLA = $ID");
	while($row = db_fetch_array($result)) {
		echo ("<input type=\"hidden\" name=\"ID\" value=\"".$row['ID']."\">");
		echo ("<input type=\"hidden\" name=\"eleccio\" value=\"$eleccio\">");
		if ($quantstextcurts>0){ echo ("<tr><td class=\"text10\" colspan=\"2\" ><br><b>".t("shorttext").":</b></td></tr>\n");}

		for($i=1;$i<=45;$i++){
			$camp="TEXTC".$i;
			if ($iniciatextcurts<$quantstextcurts){ echo ("<tr><td class=\"text10\" width=\"5%\" valign=\"top\">$i:</td><td width=\"80%\" valign=\"top\"><input type=\"text\" name=\"TEXTC$i\" value=\"".filtreQuote($row[$camp])."\" maxlength=\"255\" class=\"formulari\"></td></tr>");$iniciatextcurts++;}
		}






		//textllarg
		if ($quantstextllargs>0){ echo ("<tr><td class=\"text10\" colspan=\"2\" ><br><b>".t("largetext").":</b></td></tr>\n");}

		for($i=1;$i<=10;$i++){
			$camp="TEXTL".$i;
			if ($iniciatextllargs<$quantstextllargs){ echo ("<tr><td class=\"text10\" width=\"5%\" valign=\"top\">$i:</td><td width=\"80%\" valign=\"top\"><input type=\"text\" name=\"TEXTL$i\" value=\"".filtreQuote($row[$camp])."\" maxlength=\"255\" class=\"formulari\"></td></tr>");$iniciatextllargs++;}
		}





		//alts imatges
		if ($quantsalts>0){ echo ("<tr><td class=\"text10\" colspan=\"2\" ><br><b>".t("alts")." ".t("images")."</b></td></tr>\n");}
		for($i=1;$i<=20;$i++){
			$camp="ALT".$i;
			if ($iniciaalts<$quantsalts){ echo ("<tr><td class=\"text10\" width=\"5%\" valign=\"top\">$i:</td><td width=\"80%\" valign=\"top\"><input type=\"text\" name=\"ALT$i\" value=\"".filtreQuote($row[$camp])."\" maxlength=\"255\" class=\"formulari\"></td></tr>");$iniciaalts++;}
		}


		// imatges
		if ($quantesimatges>0){ echo ("<tr><td class=\"text10\" colspan=\"2\" ><br><b>".t("images").":</b></td></tr>\n");}
		for($i=1;$i<=20;$i++){
			$camp="IMATGE".$i;
			if ($iniciaimatges<$quantesimatges){ echo ("<tr><td class=\"text10\" width=\"5%\" valign=\"top\">$i:</td><td width=\"80%\" valign=\"top\"><input type=\"text\" name=\"IMATGE$i\" value=\"".filtreQuote($row[$camp])."\" maxlength=\"255\" class=\"formulari\"></td></tr>");$iniciaimatges++;}
		}


		// adjunts
		if ($quantsadjunts>0){ echo ("<tr><td class=\"text10\" colspan=\"2\" ><br><b>".t("files").":</b></td></tr>\n");}
		for($i=1;$i<=20;$i++){
			$camp="ADJUNT".$i;
			if ($iniciaadjunts<$quantsadjunts){ echo ("<tr><td class=\"text10\" width=\"5%\" valign=\"top\">$i:</td><td width=\"80%\" valign=\"top\"><input type=\"text\" name=\"ADJUNT$i\" value=\"".filtreQuote($row[$camp])."\" maxlength=\"255\" class=\"formulari\"></td></tr>");$iniciaadjunts++;}
		}

		// adjunts
		if ($quantsop>0){ echo ("<tr><td class=\"text10\" colspan=\"2\" ><br><b>Opcionals:</b></td></tr>\n");}
		for($i=1;$i<=20;$i++){
			$camp="OP".$i;
			if ($iniciaop<$quantsop){ echo ("<tr><td class=\"text10\" width=\"5%\" valign=\"top\">$i:</td><td width=\"80%\" valign=\"top\"><input type=\"text\" name=\"OP$i\" value=\"".filtreQuote($row[$camp])."\" maxlength=\"255\" class=\"formulari\"></td></tr>");$iniciaop++;}
		}



	}
   db_free_result($result);
?>
						<TR>
						   <TD valign=top align=center colspan=2>
						 	   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("save"); ?>" class=boto>
						   </TD>
						</TR>
				</table>
		</td>
		<!-- /FORMULARI ENTRADA -->

	</tr>


</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</form>
</body>
</html>
