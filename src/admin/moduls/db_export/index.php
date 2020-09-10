<?php
require_once('impex/exporter.php');

require ('../../config_admin.inc');
accessGroupPermCheck('backup_make');

require_once('impex/exp.config.inc.php');

if (! isset($_SESSION['db_exporter'])) {
  $_SESSION['db_exporter'] = new db_exporter;
  $_SESSION['db_exporter']->db_connect();
}

if (!isset($_GET['go']) || !$_GET['go']) {
  $go = 'ex_step1';
}
else {
  $go = $_GET['go'];
}
if (file_exists('impex/' . $go . '.php')) {
  if ($go == 'ex_step4') {
    include('impex/' . $go . '.php');
    exit;
  }
  else {
    ob_start();
    include('impex/' . $go . '.php');
    $content = ob_get_contents();
    ob_end_clean();
  }
} else {
  print('El fitxer no existeix!');
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
					<td  class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php"><?php echo t("utils"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("exportdata"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:15px;padding-top:0px;">
<?php
echo $content;
?>

		</td>
	</tr>

</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</form>
</div>
</body>
</html>