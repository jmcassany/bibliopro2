<?php

require ('../../config_admin.inc');
accessGroupPermCheck('form_entrys');

   $ID=$_GET['ID'];
   $result=db_query("select * from FORMULARIS where ID = $ID");
   $row = db_fetch_array($result);
   //si no troba res error
	if (empty($row['ID'])){
	 htmlPageBasicError(t("errordbcardscodinotfound"));
	}

   $nomformulari=$row['NOMFORMULARI'];
?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("formstitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
		    <table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="60%" class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php"><?php echo t("formstitle"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Items</font></td>
					<td  class="vermell10b" align="right">
<form action="nou.php" method="post" name="FormCrearpagina"  style="display:inline">
  <input type="hidden" name="ID" value="<?php echo $ID; ?>">
  <button type="submit" class="vermell10b" style="background-color:transparent;cursor:pointer;border:none;text-decoration: none;">
    <img src="../../comu/inserta_c_form.gif" alt="<?php echo t("formcreatefield"); ?>" align="absmiddle" style="margin-right:5px;" /><?php echo t("formcreatefield"); ?>
  </button>
</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td  style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Items <?php echo t("form")." ".$nomformulari; ?></td>
					<td   bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
				<!-- llegendes -->
				<tr>
					<td  bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">


						<img src="../../comu/icon_modifica.gif" alt="<?php echo t("edit"); ?>" width="23" height="16" border="0" align="absmiddle" ><?php echo t("edit"); ?>&nbsp;&nbsp;&nbsp;
						<img src="../../comu/icon_borrar.gif" alt="<?php echo t("delete"); ?>" width="22" height="16" border="0" align="absmiddle"><?php echo t("delete"); ?>
					</td>

					<td  bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10" align="right">
					<a href="../preview.php?ID=<?php echo $ID; ?>" style="text-decoration:none;"><img src="../../comu/icon_generar.gif" alt="<?php echo t("generate")." ".t("form"); ?>" width="23" height="16" border="0" align="absmiddle"><?php echo t("generate")." ".t("form"); ?></a>&nbsp;
					</td>

				</tr>
				<!-- /navegacio pag -->
			</table>
		</td>
	</tr>




	<tr>
		<form action="delete.php" method="post">
		<input type="hidden" name="FORMULARI" value="<?php echo $ID; ?>">
		<input type="hidden" name="nomformulari" value="<?php echo $nomformulari; ?>">
		<!-- LLISTAT PAGINES -->
		<td colspan="2" style="padding:10px;" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">


<!-- CONEXIO BBDD -->
<?php


  $result = db_query("SELECT * FROM FORMULARISITEMS WHERE FORMULARI='$ID' ORDER BY ORDRE ASC");


   while($row = db_fetch_array($result)) {

        	echo("<tr>
					<td width=\"20%\" style=\"border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;\">

						<a href=\"edita.php?ID=$row[ID]\"><img src=\"../../comu/icon_modifica.gif\" alt=\"Editar\" width=\"23\" height=\"16\" border=\"0\" align=\"absmiddle\" ></a>
						<a href=\"moure.php?ID=$row[ID]&accio=up\"><img src=\"../../comu/icon_pujaform.gif\" alt=\"Pujar\" width=\"13\" height=\"14\" border=\"0\" align=\"absmiddle\" style=\"margin-right:4px;\"></a>
						<a href=\"moure.php?ID=$row[ID]&accio=down\"><img src=\"../../comu/icon_baixaform.gif\" alt=\"Baixar\" width=\"13\" height=\"14\" border=\"0\" align=\"absmiddle\" ></a>
						&#149;&nbsp;
						<img src=\"../../comu/icon_borrar.gif\" alt=\"Eliminar\" width=\"22\" height=\"16\" border=\"0\" align=\"absmiddle\"><input type=\"checkbox\" name=\"CHECK[".$row['ID']."]\" value=\"TRUE\" >
					</td>
					<td class=\"gris10\" width=\"80%\" valign=\"top\" style=\"border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;\"><a href=\"edita.php?ID=$row[ID]\"><img src=\"../../comu/ico_c_form.gif\" width=\"29\" height=\"17\"  border=\"0\" align=\"absmiddle\"></a><a href=\"edita.php?ID=$row[ID]\" class=\"nompagina\" >$row[TEXT]</a></td>
				</tr>
			");
   }


   db_free_result($result);
?>
<!-- /CONEXIO BBDD -->






			</table>
		</td>
		<!-- LLISTAT PAGINES -->

	</tr>

	<tr>
		<td colspan="2" style="padding:5px;">

		<!-- CONFIRMACIO BORRAR -->
			<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#ECECEC" height="33" style="border-top:solid #000000 1px;">
				<tr>
					<td  class="text">&nbsp;<?php echo t("confirmdelete"); ?>&nbsp;<img src="../../comu/icon_borrar.gif" alt="Eliminar" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CONFIRM" value="TRUE"><input type="image" src="../../comu/confirma_elimina.gif" name="accio" value="Borrar" class="text10" align="absmiddle"></td>
				</tr>
			</table>
		<!-- /CONFIRMACIO BORRAR -->
		</td>
	</tr>
</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</form>
</body>
</html>
