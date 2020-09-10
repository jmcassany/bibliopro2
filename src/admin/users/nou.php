<?php

require ('../config_admin.inc');
accessGroupPermCheck('users_create');

include_once('../moduls/uploads/funcions.php');
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function refrescar(){
  location.reload();
}
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form action="create.php" method="post" name="FORM">
<input type="hidden" name="EXP_DAY" size="3" maxlength="2" value="10">
<input type="hidden" name="EXP_MONTH" size="3" maxlength="2" value="10">
<input type="hidden" name="EXP_YEAR" size="6" maxlength="4" value="2065">
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
			<table cellpadding="2" cellspacing="2" border="0" width="98%"  class="text">

<?php
if ($ldap_active) {

  $users = new dbUsers();
  $user = $users->ldap_readUser($_POST['LOGIN']);
  echo ("<tr><td>".t("userformlogin").":</td><td>".$user['LOGIN']."
  <input type=\"hidden\" name=\"LOGIN\" value=\"".$user['LOGIN']."\">
  </td></tr>\n");
  echo ("<tr><td>".t("userformemail").":</td><td>".$user['EMAIL']."</td></tr>\n");
  echo ("<tr><td>".t("userformname").":</td><td>".$user['REALNAME']."</td></tr>\n");
  echo ("<tr><td>".t("userformtelephon").":</td><td>".$user['TELEPHONE']."</td></tr>\n");
}
else {
?>
				<tr>
					<td><?php echo t("userformlogin"); ?>:</td><td><input type="text" name="LOGIN" maxlength="255" class="formulari" style="width:150px;"></td>
				</tr>
				<tr>
					<td><?php echo t("userformpassword"); ?>:</td><td><input type="password" name="PASSWD" maxlength="32" class="formulari" style="width:150px;"><br></td>
				</tr>
				<tr>
					<td><?php echo t("userformpasswordrepeat"); ?>:</td><td><input type="password" name="PASSWD_BIS" maxlength="15" class="formulari" style="width:150px;"><br></td>
				</tr>
				<tr>
					<td><?php echo t("userformemail"); ?>:</td><td><input type="text" name="EMAIL" maxlength="80" class="formulari" style="width:250px;"><br></td>
				</tr>
				<tr>
					<td><?php echo t("userformname"); ?>:</td><td><input type="text" name="REALNAME" maxlength="80" class="formulari" style="width:250px;"><br></td>
				</tr>
				<tr>
					<td><?php echo t("userformtelephon"); ?>:</td><td><input type="text" name="TELEPHONE" maxlength="15" class="formulari" style="width:150px;"><br></td>
				</tr>
<?php
}
?>


				<tr>
					<td><?php echo t("userformlevel"); ?>:</td><td>
						<select name="USERLEVEL" class="formulari" style="width:150px;">
<?php
$groups = accessGetGroupList();
foreach ($groups as $key => $valor) {
  echo '<option value="'.$key.'">'.$valor.'</option>';
}

?>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo t("userformstat"); ?>:</td><td>
						<select name="STATUS" class="formulari" style="width:150px;">
							<option value="0"><?php echo t("active"); ?></option>
							<option value="1"><?php echo t("inactive"); ?></option>
						</select>
					</td>
				</tr>

				<!-- GRUP -->
				<tr>
					<td><?php echo t("uploadgroupgroup"); ?>:</td>
					<td>
<?php
	echo getGroupSelect();
?>

					</td>
				</tr>




<?php


		echo ("<tr><td valign=\"top\">".t("userformdata")."</td><td>\n");


		echo ("<table><tr><td  class=\"text\"  valign=\"top\">\n");
	   /*carpetes*/

$static = folderList(null, false);




function showFolder($value,$string = array()) {
global $num1, $trozos;

 $num1=$num1+1;

  if($value['desc'] == ''){
    $value['desc'] = $value['nom'];
  }

  if ($value['tipus'] == 0) {
    $icona = 'icon_estatica.gif';
    if ($value['pare'] == null) {
      $icona = 'icon_home.gif';
    }
    $perm = 'page_read';
    $url = '../pagines/index.php?carpeta='.$value['id'];
  }
  else {
    $icona = '../comu/paisos/ico_carpeta_'.$value['idioma'].'.gif';
    $perm = 'dinamic_read';
    $url = 'dinamiques/index.php?DIN='.$value['id'];
  }


//  for ($i = 0; $i < $desp; $i++) {
//    if ($i == $desp-1) {
//      echo '<img src="comu/ico_liniescarpetes_L.gif" alt="" border="0">';
//    }
//    else {
//      echo '<img src="comu/ico_liniescarpetes_blnc.gif" alt="" border="0">';
//    }

//  }

  if (count($string) > 0) {
    $tmp = $string;
    $tmp[count($tmp)-1] = '<img src="../comu/ico_liniescarpetes_L.gif" alt="" border="0">';
    echo implode('', $tmp);
  }
  $trobat = '';
 if (in_array($value['id'],$trozos)) {
              $trobat = "checked";
            }



    echo '
<input type="checkbox" style="margin-left:10px;" name="COMMENTS['.$num1.']" value="'.$value['id'].'" '.$trobat.'>
<img src="../comu/'.$icona.'" alt="'.$value['ruta'].'" border="0">
'.$value['desc'].'

';

  //echo '<div style="border-bottom:dotted #ccc 1px;width:450px;margin:5px 0;_margin:0 0 10px 0;"></div>';
  echo '<br />';
  if (isset($value['fills'])) {
    for ($i = 0; $i < count($value['fills']); $i ++) {
      $tmp = $string;
      if ($i == count($value['fills']) -1) {
        $tmp[] = '<img src="../comu/ico_liniescarpetes_blnc.gif" alt="" border="0">';
      }
      else {
        $tmp[] = '<img src="../comu/ico_liniescarpetes_I.gif" alt="" border="0">';
      }
      showFolder($value['fills'][$i], $tmp);


    }
  }
  if (count($string) == 1) {
 	echo '<div style="border-bottom:dotted #ccc 1px;width:450px;margin:5px 0;_margin:0 0 10px 0;"></div>';
 }
}

$num1=0;
foreach ($static as $value) {


  showFolder($value);

}

$num = $num1+1;
?>


<?php
if ($CONFIG_MENUACCES) {
?>
							<tr>
                              <td colspan="2"  class="text" valign="top"><b><?php echo t("userformmenu"); ?></b><br>
<?php
  $result=db_query("select ID,NOM,DESCRIPCIO,IDIOMA from MENUS ORDER BY  NOM ASC");
  while($row = db_fetch_array($result)) {

    if (isset($limit_permissos) && !in_array($row['ID'].'_menu',$limit_permissos)) {
      continue;
    }

    if ($row['DESCRIPCIO'] == ''){
      $row['DESCRIPCIO'] = $row['NOM'];
    }
    echo ("<img src=\"../comu/paisos/".$row['IDIOMA'].".gif\" alt=\"\" border=\"0\"> <input type=\"checkbox\" name=\"COMMENTS[$num]\" value=\"".$row['ID']."_menu\">".$row['DESCRIPCIO']."<br>");
    $num++;
  }
?>
                              </td>
							</tr>
<?php
}
?>
<?php
if ($CONFIG_BANNERACCES) {
?>
							<tr>
                              <td colspan="2"  class="text" valign="top"><b><?php echo t("bannersgroup"); ?></b><br>
<?php
  $result=db_query("select ID,NOM,DESCRIPCIO from BANNERS ORDER BY  NOM ASC");
  while($row = db_fetch_array($result)) {

    if (isset($limit_permissos) && !in_array($row['ID'].'_banner',$limit_permissos)) {
      continue;
    }

    if ($row['DESCRIPCIO'] == ''){
      $row['DESCRIPCIO'] = $row['NOM'];
    }
    echo ("<input type=\"checkbox\" name=\"COMMENTS[$num]\" value=\"".$row['ID']."_banner\">".$row['DESCRIPCIO']."<br>");
    $num++;
  }
?>
                              </td>
							</tr>
<?php
}
?>

						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><br>
					<input type="submit" name="Submit" value="<?php echo t("create"); ?>">

					</td>
				</tr>
			</table><br>
		</td>
	</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
