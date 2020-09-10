<?php

require ('config_admin.inc');
accessGroupPermCheck('houdinibasic');

$users = new dbUsers();
$trozos = $users->getComments(accessGetLogin());
?>

<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<!-- CAPÇELERA -->
<?php echo htmlHeader(); ?>
<!-- /CAPÇELERA -->

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="50%" class="text10"><img src="comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <font class="blau10b"><?php echo t("home"); ?></font></td>
				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

<?php
if ($CONFIG_tipusIndex == 'arbre') {
?>
	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:5px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("userformstatics").'/'.t("userformdinamics"); ?></td>
					</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td colspan="2" style="padding:10px;" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
  <td  class="gris11b" valign="top" style="padding-top:3px;padding-bottom:8px;">

<?php
$static = folderList();


/*function showFolder($folders, $desp = 0) {

  foreach($folders as $value) {
    if($value['desc'] == ''){
      $value['desc'] = $value['nom'];
    }

    if ($value['tipus'] == 0) {
      $icona = 'icon_estatica.gif';
      if ($value['pare'] == null) {
        $icona = 'icon_home.gif';
      }
      $perm = 'page_read';
      $url = 'pagines/index.php?carpeta='.$value['id'];
    }
    else {
      $icona = 'paisos/ico_carpeta_'.$value['idioma'].'.gif';
      $perm = 'dinamic_read';
      $url = 'dinamiques/index.php?DIN='.$value['id'];
    }


    for ($i = 0; $i < $desp; $i++) {
      if ($i == $desp-1) {
        echo '<img src="comu/ico_liniescarpetes_L.gif" alt="" border="0">';
      }
      else {
        echo '<img src="comu/ico_liniescarpetes_blnc.gif" alt="" border="0">';
      }

    }

    if (accessGroupPerm($perm) && $value['access']) {
      echo '
<a href="'.$url.'" class="gris11b" title="'.$value['ruta'].'">
<img src="comu/'.$icona.'" alt="'.$value['ruta'].'" border="0">
'.$value['desc'].'
</a>
';
    }
    else {
      echo '
<img src="comu/'.$icona.'" alt="'.$value['ruta'].$value['nom'].'" border="0">
'.$value['desc'].' <img src="comu/ico_candau.gif" alt="No editable" border="0">
';
    }
    echo '<br>';
    if (isset($value['fills'])) {
      showFolder($value['fills'], $desp +1);
    }
  }
}
showFolder($static);
*/


function showFolder($value, $string = array()) {

  if($value['desc'] == ''){
    $value['desc'] = $value['nom'];
  }

  if ($value['tipus'] == 0) {
    $icona = 'icon_estatica.gif';
    if ($value['pare'] == null) {
      $icona = 'icon_home.gif';
    }
    $perm = 'page_read';
    $url = 'pagines/index.php?carpeta='.$value['id'];
  }
  else {
    $icona = 'paisos/ico_carpeta_'.$value['idioma'].'.gif';
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
    $tmp[count($tmp)-1] = '<img src="comu/ico_liniescarpetes_L.gif" alt="" border="0">';
    echo implode('', $tmp);
  }

  if (accessGroupPerm($perm) && $value['access']) {
    echo '
<a href="'.$url.'" class="gris11b" title="'.$value['ruta'].'">
<img src="comu/'.$icona.'" alt="'.$value['ruta'].'" border="0">
'.$value['desc'].'
</a>
';
  }
  else {
    echo '
<img src="comu/'.$icona.'" alt="'.$value['ruta'].$value['nom'].'" border="0">
'.$value['desc'].' <img src="comu/ico_candau.gif" alt="No editable" border="0">
';
  }
  echo '<br>';
  if (isset($value['fills'])) {
    for ($i = 0; $i < count($value['fills']); $i ++) {
      $tmp = $string;
      if ($i == count($value['fills']) -1) {
        $tmp[] = '<img src="comu/ico_liniescarpetes_blnc.gif" alt="" border="0">';
      }
      else {
        $tmp[] = '<img src="comu/ico_liniescarpetes_I.gif" alt="" border="0">';
      }
      showFolder($value['fills'][$i], $tmp);


    }
  }
}


foreach ($static as $value) {
  showFolder($value);
}


?>
  </td>
</tr>

			</table>
		</td>
	</tr>












<?php
}
else {
?>
	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:5px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("userformstatics"); ?></td>
					<td width="50%" style="padding:5px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="comu/kland_flexa.gif" width="21" height="13" border="0"><?php echo t("userformdinamics"); ?></td>
				</tr>
			</table>
		</td>
	</tr>


	<tr>
		<!-- LLISTAT ESTATIQUES -->
		<td width="50%" style="padding:10px;border-right:solid #CCCCCC 1px;" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
<?php
$static = staticFolderList();

foreach($static as $value) {
  echo '
<tr>
  <td  class="gris11b" valign="top" style="padding-top:3px;padding-bottom:8px;">
';

  if($value['desc'] == ''){
    $value['desc'] = $value['nom'];
  }
  $icona = 'icon_estatica.gif';
  if ($value['pare'] == null) {
    $icona = 'icon_home.gif';
  }

  if (accessGroupPerm('page_read')) {
    echo '
<a href="pagines/index.php?carpeta='.$value['id'].'" class="gris11b" title="'.$value['ruta'].'">
<img src="comu/'.$icona.'" width="29" height="16" alt="'.$value['ruta'].'" border="0">
'.$value['desc'].'
</a>
';
  }
  else {
    echo '
<img src="comu/'.$icona.'" width="29" height="16" alt="'.$value['ruta'].$value['nom'].'" border="0">
'.$value['desc'].'
';
  }

  echo '
  </td>
</tr>
';
}
?>

			</table>
		</td>
		<!-- /LLISTAT ESTATIQUES -->

		<!-- LLISTAT DINAMIQUES -->
		<td width="50%" style="padding:10px;" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">


			<?php
$static = dinamicFolderList();

foreach($static as $value) {
  echo '
<tr>
  <td class="gris11b" valign="top" style="padding-top:3px;padding-bottom:8px;">
';
  if($value['desc'] == ''){
    $value['desc'] = $value['nom'];
  }
  $icona = $CONFIG_URLBASE.'/admin/comu/paisos/ico_carpeta_'.$value['idioma'].'.gif';

  if (accessGroupPerm('dinamic_read')) {
    echo '
<a href="dinamiques/index.php?DIN='.$value['id'].'" class="gris11b" title="'.$value['ruta'].'">
<img src="'.$icona.'" width="29" height="16" alt="'.$value['ruta'].$value['nom'].'" border="0">
'.$value['desc'].'
</a>
';
  }
  else {
    echo '
<img src="'.$icona.'" width="29" height="16" alt="'.$value['ruta'].$value['nom'].'" border="0">
'.$value['desc'].'
';
  }

  echo '
  </td>
</tr>
';
}
?>



<?php
}
?>



  		</table>
		</td>
		<!-- /LLISTAT DINAMIQUES -->
	</tr>
</table>
<!-- /PART CENTRAL -->

<?php
echo register_last_print(1,accessGetLogin());

echo htmlFoot();
?>

</body>
</html>
