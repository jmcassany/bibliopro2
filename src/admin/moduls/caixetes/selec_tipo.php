<?php

require ('../../config_admin.inc');
accessGroupPermCheck('boxes');

require('caixetes.php');

include('variables.php');
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function doTemplate(myForm) {

  for (var i = 0; i < myForm.TIPO.length; i++) {
    if (myForm.TIPO[i].checked) {
      TIPO = myForm.TIPO[i].value
    }
  }
  ot1 = document.getElementById("t1")
  if (TIPO == "") {
    ot1.src = ""
  } else {
    ot1.src = "<?php echo $CONFIG_URLADMIN ?>/comu/caixetes/" + TIPO + '.jpg'
  }
}

</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >
<form action="nou.php" method="post" name="FORM" >

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="<?php echo $CONFIG_URLADMIN ?>/comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t('bannerstitle') ?></b></td>
	</tr>
	<tr>
		<td  style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="85%" class="text10"><img src="<?php echo $CONFIG_URLADMIN ?>/comu/icon_plana.gif" width="33" height="18" alt="<?php echo t('youarein') ?>" border="0" align="absmiddle"><?php echo t('youarein') ?>: <a href="<?php echo $CONFIG_URLADMIN ?>/index.php"><?php echo t('home') ?></a><img src="<?php echo $CONFIG_URLADMIN ?>/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="<?php echo $CONFIG_URLADMIN ?>/utilitats/index.php"><?php echo t('utils') ?></a><img src="<?php echo $CONFIG_URLADMIN ?>/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php"><?php echo t('bannerstitle') ?></a><img src="<?php echo $CONFIG_URLADMIN ?>/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t('bannersselect') ?></font></td>
					<td width="15%" class="vermell10b" align="right">

					<a href="javascript:history.back();" class="vermell10b"><img src="<?php echo $CONFIG_URLADMIN ?>/comu/icon_cancelar.gif" alt="<?php echo t('cancel') ?>" width="26" height="19" border="0" align="absmiddle"><?php echo t('cancel') ?></a>
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
						<img src="<?php echo $CONFIG_URLADMIN ?>/comu/icon_escull_plantilla.gif" alt="<?php echo t('bannersselect') ?>" width="28" vspace="5" height="22" border="0" align="absmiddle"><b><?php echo t('bannersselect') ?></b><br>
						<!-- PART CENTRAL DADES-->
						<div style="width:250px;background-color:#FFFFFF;padding:10px;border:dotted #C0CEE4 1px;">
     <?php
     foreach ($tipus_caixetes as $key => $value) {
       if (isset($value['defecte'])) {
         $defecte = 'checked';
       }
       else {
         $defecte = '';
       }
       echo '<input type="radio" name="TIPO" value="'.$key.'" onclick="doTemplate(this.form)" '.$defecte.'>'.$value['nom'].'<br>';
     }
     ?>
						</div>



						<br><br><input type="submit" name="Submit" value="<?php echo t('continue') ?>">	<br><br>
					</td>
					<td  valign="top"  class="text10" style="padding-top:18px;">
					<img src="<?php echo $CONFIG_URLADMIN ?>/comu/icon_plantilla.gif" alt="<?php echo t('bannersselectpreview') ?>" width="22" height="14" vspace="5" border="0" align="absmiddle"><b><?php echo t('bannersselectpreview') ?></b><br>
    				<iframe id=t1 src="<?php echo $CONFIG_URLADMIN ?>/comu/caixetes/0.jpg" border="1" style="width:200px;height:160px;background-color:#FFFFFF;text-align: center"></iframe>
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
