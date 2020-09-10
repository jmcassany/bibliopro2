<?php

require ('../../config_admin.inc');
accessGroupPermCheck('composition');

require('compositions.php');

?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function doTemplate(myForm) {
  select = document.getElementById('CAIXETA['+myForm+']');
  ot1 = document.getElementById("t1");
  for (i = 0; i < select.length; i++) {
    if (select[i].selected) {
      ot1.src = "veure_caixeta.php?ID=" + select[i].value;
    }
  }
}

</script>

</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >
<form action="preview.php?ID=<?php echo $ID ?>" method="post" name="FORM" >

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t('bannersgrouptitle') ?></b></td>
	</tr>
	<tr>
		<td  style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="80%" class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t('youarein') ?>" border="0" align="absmiddle"><?php echo t('youarein') ?>: <a href="../../index.php"><?php echo t('home') ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php"><?php echo t('utils') ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php"><?php echo t('bannersgrouptitle') ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t('bannersgroupselect') ?></font></td>
					<td width="20%" class="vermell10b" align="right">

					<a href="javascript:history.back();" class="vermell10b"><img src="../../comu/icon_cancelar.gif" alt="<?php echo t('cancel') ?>" width="26" height="19" border="0" align="absmiddle"><?php echo t('cancel') ?></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->
	<tr>
		<td class="text" style="padding:5px;"  bgcolor="#FFFFFF">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:10px;"  bgcolor="#F0F0F0">
				<tr>
					<td class="text10"  valign="top"    style="padding:20px;">
						<img src="../../comu/icon_escull_plantilla.gif" alt="<?php echo t('bannersgroupselect') ?>" width="28" vspace="5" height="22" border="0" align="absmiddle"><b><?php echo t('bannersgroupselect') ?></b><br>
						<!-- PART CENTRAL DADES-->




<?php

$resultat = db_query('SELECT TEXT FROM BANNERS WHERE ID='.$ID);
$row = db_fetch_array($resultat);
$caixetes = explode('|',$row['TEXT']);


include('variables.php');
$where = '';
if (isset($tipus_banners[$TIPO]['max_width'])) {
   $where = 'WHERE WIDTH <= '.$tipus_banners[$TIPO]['max_width'];
}

for ($i=0; $i < $CAIXETES; $i++) {
?>
			   <?php echo t('banner') ?> <?php echo $i+1 ?>:
               <select name="CAIXETA[<?php echo $i ?>]" id="CAIXETA[<?php echo $i ?>]" onchange="doTemplate('<?php echo $i ?>')" onfocus="doTemplate('<?php echo $i ?>')">
<?php
foreach ($fonts_caixetes as $value) {
  $resultat = db_query('SELECT * FROM '.$value['taula']);

  if (db_num_rows($resultat) > 0) {
    echo '<option value="" disabled="disabled">-- '.$value['nom'].' --</option>'."\n";
    while ($row = db_fetch_array($resultat)) {
      if (empty ($row['DESCRIPCIO'])) {
        $descripcio = $row['NOM'];
      }
      else {
        $descripcio = $row['DESCRIPCIO'];
      }

      if ($row['ID'].'_'.$value['sufix'] == $caixetes[$i]) {
        $selected = 'selected';
      }
      else {
        $selected = '';
      }
      echo '<option value="'.$row['ID'].'_'.$value['sufix'].'" '.$selected.'>'.$descripcio.'</option>'."\n";
    }
  }
}


?>
			   </select><br><br>

<?php
}
?>

                        <INPUT TYPE="hidden" NAME="ID" VALUE="<?php echo $ID ?>" class=boto>
                        <INPUT TYPE="hidden" NAME="TIPO" VALUE="<?php echo $TIPO ?>" class=boto>
						<br><input type="submit" name="Submit" value="<?php echo t('continue') ?>">
                        <br><br>
					</td>
					<td  valign="top"  class="text10" style="padding-top:18px;">
					<img src="../../comu/icon_plantilla.gif" alt="<?php echo t('bannersselectpreview') ?>" width="22" height="14" vspace="5" border="0" align="absmiddle"><b><?php echo t('bannersselectpreview') ?></b><br>
						<iframe id=t1 src="" border="1" style="width:240px;height:194px;background-color:#FFFFFF"></iframe>
						<br><br>
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