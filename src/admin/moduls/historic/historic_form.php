<?php

require ('../../config_admin.inc');
accessGroupPermCheck('houdinibasic');

?>
<html>
<head>
<?php echo htmlMetas(); ?>
<style>
	UL {margin: 0 0 0 20}
	LI {margin: 5 5 5 40}
</style>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"  onload="carregat();">
<form action="historic.php" method="post">
<?php echo htmlHeader(); ?>

<div id="carregant" style="width: 100%; height: 100%; text-align: center;"><br><br><?php echo t("loading"); ?></div>
<div id="contingut" style="display: none">
<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("utils"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php"><?php echo t("utils"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("registryhistoryviewmy"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:15px;">
			<table border="0" cellpadding="0" cellspacing="0" width="420" style="padding:3px;">

				<tr>
					<td valign="top" rowspan="3" width="40"><img src="../../comu/ico_historic1.gif" alt="<?php echo t("registryhistoryviewmy"); ?>" width="40" height="18" border="0"></td>
					<td class="blanc11b" bgcolor="#0E449A" style="padding:5px;"><?php echo t("registryhistoryviewmy"); ?></td>
				</tr>

				<tr>
					<td class="text10" style="padding:10px;" bgcolor="#E6E6E6">
                    <br><br>
					<?php echo t("from"); ?>&nbsp;<input type="text" name="INICIDIA" class="formulari" style="width:25px;" value="<?php echo date('d',time()-2678400); ?>"> /
					<input type="text" name="INICIMES" class="formulari" style="width:25px;" value="<?php echo date('m',time()-2678400); ?>"> /
					<input type="text" name="INICIANY" class="formulari" style="width:50px;" value="<?php echo date('Y',time()-2678400); ?>">
					&nbsp;&nbsp;<?php echo t("todate"); ?>&nbsp;
					<input type="text" name="FIDIA" class="formulari" style="width:25px;" value="<?php echo date('d'); ?>"> /
					<input type="text" name="FIMES" class="formulari" style="width:25px;" value="<?php echo date('m'); ?>"> /
					<input type="text" name="FIANY" class="formulari" style="width:50px;" value="<?php echo date('Y'); ?>"><br>


					</td>
				</tr>

				<tr>
					<td class="text10"  bgcolor="#E6E6E6" style="padding:10px;">
					<input type="submit" name="Enviar" value="<?php echo t("view"); ?>">
					</td>
				</tr>
			</table>
		</td>
	</tr>







</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</div>
</form>
</body>
</html>
