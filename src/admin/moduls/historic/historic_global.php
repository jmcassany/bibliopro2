<?php

require ('../../config_admin.inc');
accessGroupPermCheck('historyall');

  $DATAINICI=$INICIANY."-".$INICIMES."-".$INICIDIA." 00:00:00";
  $DATAFI=$FIANY."-".$FIMES."-".$FIDIA." 23:59:59";
  if ($LOGIN =="%"){
    $LOGIN ="";
  	$USUARIBUSCAT="Tots";
  }else{
  	$USUARIBUSCAT="$LOGIN";
  }

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
					<td  class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php"><?php echo t("utils"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("registryhistoryviewall"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td  style="padding:15px;">
			<table border="0" cellpadding="0" cellspacing="0" width="600">

				<tr>
					<td colspan="4"  bgcolor="#0E449A"  >
						<table border="0" cellpadding="0" cellspacing="0"  >
							<tr>
								<td valign="top"  width="40"  bgcolor="#FFFFFF"><img src="../../comu/ico_historic2.gif" alt="Històric d'accions de tots els usuaris" width="40" height="18" border="0"></td>
								<td class="blanc11b" bgcolor="#0E449A" style="padding:5px;"><?php echo t("registryhistoryviewall"); ?>:  <b><?php echo $USUARIBUSCAT; ?></b></td>
							</tr>
						</table>
					</td>
				</tr>



				<?php
				register_list_print($LOGIN, $DATAINICI, $DATAFI, $ORDRE);
				?>
			</table>
		</td>
	</tr>







</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</div>
</body>
</html>
