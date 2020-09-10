<?php
//comprovar permis
require ('../../config_admin.inc');
accessGroupPermCheck('composition');

require('compositions.php');
require_once ('p_vars.inc');



$tit_banners = array ('exemple1','exemple2');
$tipo_banners = array ('1','0','0','0','0','0','0','0','0','0','0');
$file_banners = array ('exemple1.inc','exemple2.inc');




if (isset ($_POST['accion']) && $_POST['accion'] == t("create")) {
   /*generar fitxer amb valors.php*/
   setvar ('composicion_selec_banners', $_POST['BANNER']);

   foreach ($_POST['BANNER'] as $key => $value) {
      if (empty($value)) {
        $targetfilename = $CONFIG_PATHBANNER.'/selector/'.$file_banners[$key];
        if (file_exists ($targetfilename)) {
          @unlink ($targetfilename);
        }
      }
      else {
        $targetfilename = $CONFIG_PATHBANNER.'/selector/'.$file_banners[$key];
        $targetfilename2 = $CONFIG_PATHBANNER.'/'.$value.'.inc';
        if (file_exists ($targetfilename2)) {
          @unlink ($targetfilename);
          link ($targetfilename2, $targetfilename);
        }
      }
   }

   $banner = $_POST['BANNER'];
   $missatge = '<p style="text-align:center;margin:10px;padding:10px;border:1px solid #999999;background-color:#ffffff"><b>'.t('bannersselecok').'</b></p>';
}
else {
  $banner = getvar ('composicion_selec_banners');
}

?>

<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function validar() {
  if (mainform.NOM.value=='') {
    mainform.NOM.focus();
    result = window.open("../../php/missatge.php?missatge=Introduïu un Nom al banner que voleu crear.","missatge","left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width=200,height=200,directory=no,resize=no,scrollbars=no");
    return false;
  }else{
    if (mainform.DESCRIPCIO.value=='') {
      mainform.DESCRIPCIO.focus();
      result = window.open("../../php/missatge.php?missatge=Introduïu una Descripció al banner que voleu crear.","missatge","left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width=200,height=200,directory=no,resize=no,scrollbars=no");
      return false;
    }
  }
}
</script>

</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t('bannersselectitle') ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="80%" class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein") ?>" border="0" align="absmiddle"><?php echo t("youarein") ?>: <a href="../../index.php"><?php echo t("home") ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php"><?php echo t("utils") ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t('bannersselectitle') ?></font></td>
					<td width="20%" class="vermell10b" align="right">

					<a href="javascript:history.back();" class="vermell10b"><img src="../../comu/icon_cancelar.gif" alt="<?php echo t("cancel") ?>" width="26" height="19" border="0" align="absmiddle">Cancel·lar</a>
					</td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td class="text" style="padding:5px;"  bgcolor="#FFFFFF">
<form action="selec_banners.php" method="post"  name="mainform" enctype="multipart/form-data">

			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:10px;"  bgcolor="#F0F0F0">
	<tr>
      <td colspan="2">
<?php

if (isset($missatge)) {
   echo $missatge;
}
?>
      </td>
    </tr>

<?php

foreach ($tit_banners as $key => $value) {
?>

	<tr>




<td style="width: 40%">
<?php echo $value; echo ' :' ?>
</td>
<td style="text-align: left; width: 60%; padding: 5px">



<select name="BANNER[<?php echo $key ?>]" id="BANNER[<?php echo $key ?>]" class="formulari">
<option value="">Cap</option>
<?php

$resultat = db_query('SELECT * FROM BANNERS WHERE TIPO = \''.$tipo_banners[$key].'\';');

while ($row = db_fetch_array($resultat)) {

    if (empty ($row['DESCRIPCIO'])) {
       $descripcio = $row['NOM'];
    }
    else {
       $descripcio = $row['DESCRIPCIO'];
    }

    if ($row['NOM'] == $banner[$key]) {
       $selected = 'selected';
    }
    else {
       $selected = '';
    }
    echo '<option value="'.$row['NOM'].'" '.$selected.'>'.$descripcio.'</option>';
}
?>
			   </select>

</td>
     </tr>
<?php
}
?>
<tr>
  <td>
<INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("create") ?>" class=boto>
  </td>
  <td>
  </td>
</tr>


     </table>
</form>


		</td>
	</tr>



</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>

</body>
</html>

