<?php

if($_GET){
  $ID=$_GET['ID'];
  $carpeta=$_GET['carpeta'];
}
if($_POST){
  $ID=$_POST['ID'];
  $carpeta=$_POST['carpeta'];
}


require ('../config_admin.inc');
accessGroupPermCheck('page_create');

include_once("estatiques.php");


include("check_moduls.php");

$result = db_query("select REFERENCIA, IDIOMA from ESTATICA where ID=".$ID);
if (db_num_rows($result) != 1) {
  exit();
}
$row = db_fetch_array($result);
if ($row['REFERENCIA'] == 0) {
  exit();
}
$referencia = $row['REFERENCIA'];
$idioma = $row['IDIOMA'];
$result = db_query("select * from ESTATICA where ID=".$row['REFERENCIA']);
if (db_num_rows($result) != 1) {
  exit();
}
$row = db_fetch_array($result);
for ($i = 1; $i <=$PAGE_max_textl; $i++) {
  $row['TEXTL'.$i] = db_select_text('ESTATICA', 'TEXTL'.$i, 'ID = '.$row['ID']);
}


if (isset($_POST['copy'])) {

/*actualitzar pàgina*/
  if (isset($_POST['general']) && $_POST['general']) {
    db_query("update ESTATICA SET
      NOMPAG='".$idioma.'_'.addslashes($row['NOMPAG'])."', DESCRIPCIO='".addslashes($row['DESCRIPCIO'])."',METATITOL='".addslashes($row['METATITOL'])."', METADESCRIPCIO='".addslashes($row['METADESCRIPCIO'])."', METAKEYS='".addslashes($row['METAKEYS'])."', PLANTILLAID='".addslashes($row['PLANTILLAID'])."'
      where ID=".$ID);
  }

//  if (isset($_POST['menu']) && $_POST['menu']) {
//    db_query("update ESTATICA SET MENU1='".addslashes($row['MENU1'])."', MENU2='".addslashes($row['MENU2'])."', MENU3='".addslashes($row['MENU3'])."' where ID=".$ID);
//  }
  if (isset($_POST['banner']) && $_POST['banner']) {
    db_query("update ESTATICA SET BANNER1='".addslashes($row['BANNER1'])."', BANNER2='".addslashes($row['BANNER2'])."', BANNER3='".addslashes($row['BANNER3'])."' where ID=".$ID);
  }
  if (isset($_POST['text']) && $_POST['text']) {
    db_query("update ESTATICA SET
    TEXTC1='".addslashes($row['TEXTC1'])."'  , TEXTC2='".addslashes($row['TEXTC2'])."',   TEXTC3='".addslashes($row['TEXTC3'])."',   TEXTC4='".addslashes($row['TEXTC4'])."',   TEXTC5='".addslashes($row['TEXTC5'])."',   TEXTC6='".addslashes($row['TEXTC6'])."',  TEXTC7='".addslashes($row['TEXTC7'])."',    TEXTC8='".addslashes($row['TEXTC8'])."',   TEXTC9='".addslashes($row['TEXTC9'])."',   TEXTC10='".addslashes($row['TEXTC10'])."',
    TEXTC11='".addslashes($row['TEXTC11'])."', TEXTC12='".addslashes($row['TEXTC12'])."', TEXTC13='".addslashes($row['TEXTC13'])."', TEXTC14='".addslashes($row['TEXTC14'])."', TEXTC15='".addslashes($row['TEXTC15'])."', TEXTC16='".addslashes($row['TEXTC16'])."', TEXTC17='".addslashes($row['TEXTC17'])."', TEXTC18='".addslashes($row['TEXTC18'])."', TEXTC19='".addslashes($row['TEXTC19'])."', TEXTC20='".addslashes($row['TEXTC20'])."',
    TEXTC21='".addslashes($row['TEXTC21'])."', TEXTC22='".addslashes($row['TEXTC22'])."', TEXTC23='".addslashes($row['TEXTC23'])."', TEXTC24='".addslashes($row['TEXTC24'])."', TEXTC25='".addslashes($row['TEXTC25'])."', TEXTC26='".addslashes($row['TEXTC26'])."', TEXTC27='".addslashes($row['TEXTC27'])."', TEXTC28='".addslashes($row['TEXTC28'])."', TEXTC29='".addslashes($row['TEXTC29'])."', TEXTC30='".addslashes($row['TEXTC30'])."',
    TEXTC31='".addslashes($row['TEXTC31'])."', TEXTC32='".addslashes($row['TEXTC32'])."', TEXTC33='".addslashes($row['TEXTC33'])."', TEXTC34='".addslashes($row['TEXTC34'])."', TEXTC35='".addslashes($row['TEXTC35'])."', TEXTC36='".addslashes($row['TEXTC36'])."', TEXTC37='".addslashes($row['TEXTC37'])."', TEXTC38='".addslashes($row['TEXTC38'])."', TEXTC39='".addslashes($row['TEXTC39'])."', TEXTC40='".addslashes($row['TEXTC40'])."',
    TEXTC41='".addslashes($row['TEXTC41'])."', TEXTC42='".addslashes($row['TEXTC42'])."', TEXTC43='".addslashes($row['TEXTC43'])."', TEXTC44='".addslashes($row['TEXTC44'])."', TEXTC45='".addslashes($row['TEXTC45'])."'
    where ID=".$ID);
    for ($i = 1; $i <=$PAGE_max_textl; $i++) {
      db_update_text('ESTATICA', 'TEXTL'.$i, $row['TEXTL'.$i], 'ID = '.$ID);
    }
  }

  if (isset($_POST['images']) && $_POST['images']) {
    for ($i=1; $i <= 10 ; $i++) { 
      $imatge = preg_replace('@(.*?)_pag_'.$referencia.'_'.$i.'(.*?)@si', '\\1_pag_'.$ID.'_'.$i.'\\2', $row['IMATGE'.$i]);
      if ($imatge != '') {
        copy($CONFIG_PATHUPLOADIM.'/'.$row['IMATGE'.$i], $CONFIG_PATHUPLOADIM.'/'.$imatge);
        $row['IMATGE'.$i] = $imatge;
      }
      else {
        $row['IMATGE'.$i] = '';
      }
    }
  
    db_query("update ESTATICA SET
    IMATGE1='".addslashes($row['IMATGE1'])."', IMATGE2='".addslashes($row['IMATGE2'])."', IMATGE3='".addslashes($row['IMATGE3'])."', IMATGE4='".addslashes($row['IMATGE4'])."', IMATGE5='".addslashes($row['IMATGE5'])."', IMATGE6='".addslashes($row['IMATGE6'])."', IMATGE7='".addslashes($row['IMATGE7'])."', IMATGE8='".addslashes($row['IMATGE8'])."', IMATGE9='".addslashes($row['IMATGE9'])."', IMATGE10='".addslashes($row['IMATGE10'])."',
    ALT1='".addslashes($row['ALT1'])."', ALT2='".addslashes($row['ALT2'])."', ALT3='".addslashes($row['ALT3'])."', ALT4='".addslashes($row['ALT4'])."', ALT5='".addslashes($row['ALT5'])."', ALT6='".addslashes($row['ALT6'])."', ALT7='".addslashes($row['ALT7'])."', ALT8='".addslashes($row['ALT8'])."', ALT9='".addslashes($row['ALT9'])."', ALT10='".addslashes($row['ALT10'])."'
    where ID=".$ID);
    
    /*falta*/
    
  }

  if (isset($_POST['adjunt']) && $_POST['adjunt']) {

    for ($i=1; $i <= 10 ; $i++) { 
      $adjunt = preg_replace('@(.*?)_pag_'.$referencia.'_'.$i.'(.*?)@si', '\\1_pag_'.$ID.'_'.$i.'\\2', $row['ADJUNT'.$i]);
      if ($adjunt != '') {
        copy($CONFIG_PATHUPLOADAD.'/'.$row['ADJUNT'.$i], $CONFIG_PATHUPLOADAD.'/'.$adjunt);
        $row['ADJUNT'.$i] = $adjunt;
      }
      else {
        $row['ADJUNT'.$i] = '';
      }
    }

    db_query("update ESTATICA SET
    ADJUNT1='".addslashes($row['ADJUNT1'])."', ADJUNT2='".addslashes($row['ADJUNT2'])."', ADJUNT3='".addslashes($row['ADJUNT3'])."', ADJUNT4='".addslashes($row['ADJUNT4'])."', ADJUNT5='".addslashes($row['ADJUNT5'])."', ADJUNT6='".addslashes($row['ADJUNT6'])."', ADJUNT7='".addslashes($row['ADJUNT7'])."', ADJUNT8='".addslashes($row['ADJUNT8'])."', ADJUNT9='".addslashes($row['ADJUNT9'])."', ADJUNT10='".addslashes($row['ADJUNT10'])."'
    where ID=".$ID);
    /*falta*/
    
  }
  
  
  goto_url('edita.php?ID='.$ID.'&carpeta='.$carpeta);
 
}










?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>
<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("staticpagestitle"); ?></b></td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td class="text"  style="padding:20px;" valign="top" width="70%">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
			<tr>
				<td bgcolor="#0E449A" class="blanc11b" style="padding:5px;height:30px;">
				<?php echo t("staticpagesareacontrolduplicatelang"); ?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;" class="text">
					<table cellpadding="0" cellspacing="0" bgcolor="#f8f8f8" style="border:solid #CCCCCC 1px;padding:5px; margin:20px;" >
						<tr>
							<td valign="top"><img src="../comu/ico_info.gif" width="11" height="11" alt="Info" border="0" style="margin-right:5px;" /> </td>
							<td class="text9" valign="top" style="color:#8B1F30;font-weight:bold">
								<?php echo t("staticpagesduplicatelangmessage"); ?>
								</font>
							</td>
						</tr>
					</table>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" accept-charset="utf-8" style="margin: 0 20px 0 20px">
  <p><input type="checkbox" name="general" value="1"><label><?php echo t('staticpagesduplicatelanggeneral') ?></label></p>
<!--  <p><input type="checkbox" name="menu" value="1"><?php echo t('staticpagesduplicatelangmenu') ?></label></p> -->
  <p><input type="checkbox" name="banner" value="1"><?php echo t('staticpagesduplicatelangbanner') ?></label></p>
  <p><input type="checkbox" name="text" value="1"><?php echo t('staticpagesduplicatelangtext') ?></label></p>
  <p><input type="checkbox" name="images" value="1"><?php echo t('staticpagesduplicatelangimages') ?></label></p>
  <p><input type="checkbox" name="adjunt" value="1"><?php echo t('staticpagesduplicatelangadjunts') ?></label></p>
  <input type="hidden" name="ID" value="<?php echo $ID ?>">
  <input type="hidden" name="carpeta" value="<?php echo $carpeta ?>">
  <p><input type="submit" name="copy" value="<?php echo t("import"); ?>"></p>
</form>


				</td>
			</tr>
		</table>

</td>
</tr>
</table>
</div>
<?php echo htmlFoot(); ?>
</body>
</html>

