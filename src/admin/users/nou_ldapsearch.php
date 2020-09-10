<?php

require ('../config_admin.inc');
accessGroupPermCheck('users_create');

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;padding-left:10px;padding-right:10px;">
	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("userstitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td  class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php"><?php echo t("userstitle"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("userstitlenew"); ?></font></td>

				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->
	<tr>
		<td colspan="2" style="padding:5px;">

			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("userstitlenew"); ?></td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="text" style="padding-right:0px;padding-top:10px;" valign="top">
		<!-- PART CENTRAL DADES-->
		    <form action="nou_ldapsearch.php" method="post" name="FORM">
			<table cellpadding="2" cellspacing="2" border="0" width="98%"  class="text">
				<tr>
					<td colspan="2"><?php echo t("user") ?>:
                    <input type="text" name="LOGIN" maxlength="15" class="formulari" style="width:150px;">
                    <input type="submit" name="Submit" value="<?php echo t("search"); ?>">
					</td>
				</tr>
			</table>
            </form><br>
 		    <form action="nou.php" method="post" name="FORM">
			<table cellpadding="2" cellspacing="2" border="0" width="100%"  class="text">

<?php
if(isset($_POST['LOGIN'])) {
  $users = new dbUsers();
  $resultat = $users->ldap_searchUsers($_POST['LOGIN']);

  if (count($resultat) > 0){
    echo '
<tr>
<td style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">'.t("searchresults").'</td>
</tr>
    ';
  }

  foreach($resultat as $value) {
    echo '
<tr>
  <td>
  <input type="radio" name="LOGIN" value="'.$value['LOGIN'].'" checked>'.$value['LOGIN'].' -> '.$value['REALNAME'].'
  </td>
</tr>
';
  }
  if (count($resultat) > 0){
    echo '
<tr>
  <td style="text-align:center">
  <input type="submit" name="Submit" value="'.t("new").'">
  </td>
</tr>
    ';
  }
}
?>
			</table>
            </form><br>
		</td>
	</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
