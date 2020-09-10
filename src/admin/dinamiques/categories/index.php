<?php

require ('../../config_admin.inc');
accessGroupPermCheck('dinamic_category');

include_once('funcions.inc');

if(isset($_POST['ID'])){
  $ID = $_POST['ID'];
}
else if (isset($_GET['ID'])){
  $ID = $_GET['ID'];
}
if(isset($_POST['DINAMICA'])){
  $DINAMICA = $_POST['DINAMICA'];
}
else if (isset($_GET['DINAMICA'])){
  $DINAMICA = $_GET['DINAMICA'];
}

//COMPROVEM SI TE ACCES A AQUEST MODUL
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL

if (isset($ID)) {
  $result = db_query('select * from DIN_CATEGORIES where PARE = '.$ID.' AND DINAMICA = '.$DINAMICA.' ORDER BY ORDRE desc, NOM asc');
  $anteriors = cat_anteriors($DINAMICA,$ID);
}
else {
  $result = db_query('select * from DIN_CATEGORIES where PARE is null AND DINAMICA = '.$DINAMICA.' ORDER BY ORDRE desc, NOM asc');
  $anteriors = cat_anteriors($DINAMICA);
}

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<div id="contingut">
<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

  <!-- situacio Sou a -->
  <tr>
    <td  class="text" bgcolor="#C0CEE4" style="padding:6px;" colspan="2"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t('dincategorytitle'); ?></b></td>

  </tr>
  <tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td  class="text10" width="60%"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><?php echo $anteriors['editora'] ?><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("categories"); ?></font></td>
					<td  class="vermell10b" align="right">

					</td>

				</tr>
			</table>
    </td>
  </tr>


	<!-- /situacio Sou a -->
<tr>
<td colspan="2" style="padding:5px;">
<fieldset style="padding:5px;" >
<legend  style="padding:10px;"><?php echo t("treecategories"); ?></legend>
<?php echo $anteriors['etsa'] ?>
</fieldset>

</td>
</tr>
	<tr>
		<td colspan="2" style="padding:5px;">
		<!-- INICI taula cat i docs -->
		<div style="background-color:#0E449A;padding: 10px 5px 10px 10px;font-weight:bold; font-size:12px;color:#FFFFFF">

			<?php echo $anteriors['ultim']; ?>

			</div>
		<table style="border:solid #0E449A 2px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="77%" style="padding:8px;border-right:solid #FFFFFF 3px;" bgcolor="#D7EB9A" class="blau10" valign="middle"><img src="../../comu/ico_categoria.gif" width="21" height="16" alt="Categoria" align="absmiddle" style="margin-right:5px;"><?php echo t("categories").' ('.db_num_rows($result).')'; ?></td>
					<form action="nou.php" method="post">
					<td width="23%"  bgcolor="#D7EB9A" class="blanc10b" valign="middle" align="center" style="padding-right:8px;border:solid #0E449A 1px;">
						<input type="hidden" name="ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="DINAMICA" value="<?php echo $DINAMICA; ?>">
                        <?php
                        if (isset($ID)) {
                          echo '<input type="hidden" name="PARE" value="'.$ID.'">';
                        }
                        ?>
						<button type="submit"  style="background-color:transparent;cursor:pointer;border:none;width:145px;color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 10px; text-decoration: none;font-weight:bold;">
						<img src="../../comu/ico_afegir_categoria.gif" alt="" align="absmiddle" style="margin-right:5px;" /><?php echo t('dincategorynewcat') ?>
						</button>
					</td>
					 </form>
				</tr>

			</table>
		</td>
	</tr>




	<tr>
		<form action="delete.php" method="post">
		<input type="hidden" name="DINAMICA" value="<?php echo $DINAMICA; ?>">
<?php
if (isset($ID)) {
    echo '<input type="hidden" name="PARE" value="'.$ID.'">';
}
?>

		<!-- LLISTAT PAGINES -->
		<td colspan="2" style="padding:10px;" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">


<!-- CONEXIO BBDD -->
<?php
   while($row = db_fetch_array($result)) {
?>
<tr>
	<td width="15%" style="border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;">

	<a href="edita.php?ID=<?php echo $row['ID'] ?>&amp;DINAMICA=<?php echo $DINAMICA ?>"><img src="../../comu/icon_modifica.gif" alt="Editar" width="23" height="16" border="0" align="absmiddle" ></a>
	<a href="moure.php?ID=<?php echo $row['ID'] ?>&DINAMICA=<?php echo $DINAMICA ?>&accio=up"><img src="../../comu/icon_pujaform.gif" alt="Pujar" width="13" height="14" border="0" align="absmiddle"   style="margin-right:4px;"></a>
	<a href="moure.php?ID=<?php echo $row['ID'] ?>&DINAMICA=<?php echo $DINAMICA ?>&accio=down" ><img src="../../comu/icon_baixaform.gif" alt="Baixar" width="13" height="14" border="0" align="absmiddle" ></a>	
	&#149;&nbsp;
	<img src="../../comu/icon_borrar.gif" alt="Eliminar" width="22" height="16" border="0" align="absmiddle">
  <input type="checkbox" name="CHECK[<?php echo $row['ID'] ?>]" value="TRUE" >
	</td>
  <td class="gris10" width="60%" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">
  <a href="index.php?ID=<?php echo $row['ID'] ?>&amp;DINAMICA=<?php echo $DINAMICA ?>" class="nompagina">
  <?php echo $row['NOM'] ?></a></td>
  </tr>
<?php
   }

   db_free_result($result);
?>
<!-- /CONEXIO BBDD -->
			</table>


			</td></tr></table>
		</td>
		<!-- LLISTAT PAGINES -->

	</tr>

	<tr>
		<td colspan="2" style="padding:5px;">

		<!-- CONFIRMACIO BORRAR -->
			<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#ECECEC" height="33" style="border-top:solid #000000 1px;">
				<tr>
					<td  class="text">
                    <?php echo t("confirmdelete"); ?>
                    <img src="../../comu/icon_borrar.gif" alt="Eliminar" width="22" height="16" border="0" align="absmiddle">
                    <input type="checkbox" name="CONFIRM" value="TRUE">
                    <input type="image" src="../../comu/confirma_elimina.gif" name="accio" value="Borrar" class="text10" align="absmiddle"></td>
				</tr>
			</table>
		<!-- /CONFIRMACIO BORRAR -->
		</td>
	</tr>
</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</form>
</div>
</body>
</html>
