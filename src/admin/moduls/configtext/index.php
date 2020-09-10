<?php

require ('../../config_admin.inc');
accessGroupPermCheck('configtext');


require_once ('p_vars.inc');
include('entrades.php');


if (isset($_POST['guardar']) && $_POST['guardar'] == t('save')) {
  /*guardar variables*/
  $error = false;
  foreach ($entrades as $valor_entrada) {
    if (!setvar ('configtext_'.$valor_entrada['camp'], $_POST[$valor_entrada['camp']])) {
      $error = true;
    }
    $$valor_entrada['camp'] = $_POST[$valor_entrada['camp']];
  }
  if ($error) {
    $missatge = '<p style="text-align:center;margin:10px;padding:10px;border:1px solid #999999;background-color:#ffffff"><b><img src="../../comu/ico_alerta.gif" align="absmiddle"> '.t('configtexterror').'</b></p>';
  }
  else {
    $missatge = '<p style="text-align:center;margin:10px;padding:10px;border:1px solid #999999;background-color:#ffffff"><b>'.t('configtextok').'</b></p>';
  }

}
else {
  foreach ($entrades as $valor_entrada) {
    $$valor_entrada['camp'] = getvar ('configtext_'.$valor_entrada['camp']);
  }
}


?>
<html>
<head>
<?php echo htmlMetas() ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >

<?php echo htmlHeader(); ?>

<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td class="text10" bgcolor="#FDDBCA" style="padding:6px;" colspan="2"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t('configtexttitle') ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="80%" class="text10">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td valign="top" width="33"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle"></td>
								<td class="text10"><?php echo t('youarein') ?>: <a href="../../index.php"><?php echo t('home') ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php"><?php echo t('utils') ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t('configtexttitle') ?></font></td>
							</tr>
						</table>

					</td>
					<td width="20%" class="vermell10b" align="right">

					</td>
				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->
	<tr>
		<td class="text" style="padding:5px;"  bgcolor="#FFFFFF">
<form action="index.php" method="post" name="FORM" >
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:10px;"  bgcolor="#F0F0F0">

						<!-- PART CENTRAL DADES-->

<?php

if (isset($missatge)) {
echo '
<tr><td class="text10"  valign="top" style="padding:5px;" colspan="2">
';

   echo $missatge;

echo '
</td></tr>
';
}

foreach ($entrades as $valor_entrada) {

echo '
<tr><td class="text10"  valign="top" style="padding:5px;">
';

    echo $valor_entrada['titol'].': ';

echo '
</td>
<td class="text10"  valign="top" style="padding:5px;">
';

    if (!isset($$valor_entrada['camp'])) {
      $$valor_entrada['camp'] = '';
    }
    if (empty($valor_entrada['mida'])) {
       echo '<textarea cols="5" rows="6" name="'.$valor_entrada['camp'].'" class="formulari" virtual="wrap" style="width:450px;">'.$$valor_entrada['camp'].'</textarea>
       ';
    }
    else {
       echo '<INPUT TYPE="text" NAME="'.$valor_entrada['camp'].'" SIZE="50" MAXLENGTH="'.$valor_entrada['mida'].'" class="formulari" value="'.$$valor_entrada['camp'].'" />';

    }
    echo '
    <br \><br \>
    ';

echo '
</td></tr>
';

}


?>

				<tr>
					<td class="text10"  valign="top" style="padding:5px;" colspan="2">
<input type="submit" name="guardar" value="<?php echo t('save') ?>">
					</td>

				</tr>
			</table>
</form>
		</td>



	</tr>
</table>
<?php echo htmlFoot(); ?>

</body>
</html>
