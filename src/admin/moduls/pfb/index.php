<?php

require ('../../config_admin.inc');
accessGroupPermCheck('devel_file_browser');


if (isset($_GET['dir']) && isset($pfb_dirs[$_GET['dir']])) {
  $directori = $_GET['dir'];
  $_SESSION['pfb_directori'] = $directori;
}
else if (isset($_SESSION['pfb_directori'])) {
  $directori = $_SESSION['pfb_directori'];
}
else {
  $directori = 'plantilles';
}



if (isset($pfb_dirs[$directori])) {
  require_once( './pfb/pfb.php' );
  $content = pfb ($pfb_dirs[$directori]['path'], $pfb_dirs[$directori]['url'], $CONFIG_PERMFILES, $CONFIG_PERMFOLDERS);
}

?>
<html>
<head>
<?php echo htmlMetas(); ?>
<style type="text/css">
    @import "./pfb/css/main.css";
</style>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"">
<?php echo htmlHeader(); ?>

<div id="contingut">
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
					<td width="50%" class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?> <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php"><?php echo t("utils"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("devel_file_browser"); ?></font></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->
	<tr>
		<td colspan="2" style="padding:15px;padding-top:0px;">
<div style="padding: 10px;">
<strong><?php echo t('devel_file_browser_select') ?></strong>
<ul style="padding: 0px;">
<?php
foreach ($pfb_dirs as $key => $value) {
  if ($key != $directori) {
    echo '<li><a href="'.$_SERVER['PHP_SELF'].'?dir='.$key.'">'.$value['desc'].'</a></li>';
  }
  else {
    echo '<li><a href="'.$_SERVER['PHP_SELF'].'?dir='.$key.'"><strong>'.$value['desc'].'</strong></a></li>';
  }
}
?>
</ul>
</div>
<?php
echo $content;

?>

		</td>
	</tr>
</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</div>
</body>
</html>

