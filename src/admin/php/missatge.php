<?php

require ('../config_admin.inc');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<?php echo htmlMetas(); ?>
</head>

<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >
<table border="0" cellpadding="0" cellspacing="0" width="100%" >
	<tr>
		<td colspan="2">
			<img src="../comu/franja_popup.gif" width="200" height="30" alt="" border="0" usemap="#dalt" />
			<map name="dalt">
			<area alt="Tancar" coords="132,2,197,22" href="javascript:window.close();">
			</map>
		</td>
	</tr>
	<tr>

		<td style="padding:10px;" class="grana11" valign="top" align="center"><br />
		<img src="../comu/houdini_alerta.gif" width="19" height="31" alt="Alert" border="0" style="margin-bottom:5px;" /><br />
<?php
if (isset($_POST['missatge'])) {
  echo $_POST['missatge'];
}
elseif ($_GET['missatge']) {
  echo $_GET['missatge'];
}
elseif ($missatge) {
  echo $missatge;
}
?>
		</td>
	</tr>


</table>
</body>
</html>
