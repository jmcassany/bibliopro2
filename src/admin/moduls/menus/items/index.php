<?php

require ('../../../config_admin.inc');
accessGroupPermCheck('menu_entrys');

   $ID=$_GET['ID'];
   $result=db_query("select * from MENUS where ID = $ID");
   $row = db_fetch_array($result);
   $nommenu=$row['NOM'];
   $tipomenu=$row['DESPLEGABLE'];
   if(empty($row['NOM'])){
   	htmlPageBasicError(t("errordbcardscodinotfound"));
   }
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function ordenar(){
  var url= document.fapartats.apartat.options[document.fapartats.apartat.selectedIndex].value;
  if ((document.fapartats.apartat.options[document.fapartats.apartat.selectedIndex].value)!=0){result = location.href(url);}
}
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"  onload="carregat();">

<?php echo htmlHeader(); ?>

<div id="carregant" style="width: 100%; height: 100%; text-align: center;"><br><br>Carregant...</div>
<div id="contingut" style="display: none">
<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;" colspan="2"><img src="../../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("menutitle"); ?></b></td>

	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td  class="text10" width="60%"><img src="../../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../../index.php"><?php echo t("home"); ?></a><img src="../../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php"><?php echo t("menutitle"); ?></a><img src="../../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo $row['NOM']; ?></font></td>
					<td  class="vermell10b" align="right">
<form action="nou.php" method="post" name="FormCrearpagina"  style="display:inline">
<input type="hidden" name="ID" value="<?php echo $ID; ?>">
<button type="submit" class="vermell10b" style="background-color:transparent;cursor:pointer;border:none;text-decoration: none;">
  <img src="../../../comu/inserta_c_menu.gif" alt="Crear entrada menú" align="absmiddle" style="margin-right:5px;" />Crear entrada menú
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
					<td  style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../../../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("list"); ?></td>
					<td   bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
				<!-- llegendes -->
				<tr>
					<td  bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">

						<img src="../../../comu/icon_modifica.gif" alt="Editar" width="23" height="16" border="0" align="absmiddle" ><?php echo t("edit"); ?>&nbsp;&nbsp;&nbsp;
						<img src="../../../comu/icon_borrar.gif" alt="Eliminar" width="22" height="16" border="0" align="absmiddle"><?php echo t("delete"); ?>
					</td>

					<td  bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10" align="right">
					&nbsp;
					</td>

				</tr>
				<!-- /navegacio pag -->
			</table>
		</td>
	</tr>




	<tr>
		<form action="delete.php" method="post">
		<input type="hidden" name="MENU" value="<?php echo $ID; ?>">
		<input type="hidden" name="NOM" value="<?php echo $nommenu; ?>">
		<!-- LLISTAT PAGINES -->
		<td colspan="2" style="padding:10px;" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">


<!-- CONEXIO BBDD -->
<?php


  $result = db_query("SELECT * FROM MENUITEMS WHERE MENU='$ID' ORDER BY ORDRE ASC,ID DESC");


   while($row = db_fetch_array($result)) {
        	echo("<tr>
					<td width=\"20%\" style=\"border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;\">

						<a href=\"edita.php?ID=".$row['ID']."\"><img src=\"../../../comu/icon_modifica.gif\" alt=\"Editar\" width=\"23\" height=\"16\" border=\"0\" align=\"absmiddle\" ></a>
						<a href=\"moure.php?ID=".$row['ID']."&accio=up\"><img src=\"../../../comu/icon_pujaform.gif\" alt=\"Pujar\" width=\"13\" height=\"14\" border=\"0\" align=\"absmiddle\" style=\"margin-right:4px;\"></a>
						<a href=\"moure.php?ID=".$row['ID']."&accio=down\"><img src=\"../../../comu/icon_baixaform.gif\" alt=\"Baixar\" width=\"13\" height=\"14\" border=\"0\" align=\"absmiddle\" ></a>
						&#149;&nbsp;
						<img src=\"../../../comu/icon_borrar.gif\" alt=\"Eliminar\" width=\"22\" height=\"16\" border=\"0\" align=\"absmiddle\"><input type=\"checkbox\" name=\"CHECK[".$row['ID']."]\" value=\"TRUE\" >
					</td>
					<td class=\"gris10\" width=\20%\" valign=\"top\" style=\"border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;\"><a href=\"edita.php?ID=".$row['ID']."\"><img src=\"../../../comu/ico_c_menu.gif\" width=\"29\" height=\"17\"  border=\"0\" align=\"absmiddle\"></a><a href=\"index_desp.php?ID=".$row['ID']."\" class=\"nompagina\" title=\"vincle:".$row['LINKPAGE']."\">".$row['TEXT']."</a></td>
					<td class=\"gris10\"  valign=\"top\" style=\"border-bottom:solid #cccccc 1px;padding-left:2px;padding-top:5px;padding-bottom:5px;\"><a href=\"".$row['LINKPAGE']."\" class=\"gris10\" target=\"_blank\"><img src=\"../../../comu/ico_mon.gif\" width=\"19\" height=\"13\"  border=\"0\" align=\"absmiddle\">".t("view")."</a></td>
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
					<td  class="text">&nbsp;<?php echo t("confirmdelete"); ?>&nbsp;<img src="../../../comu/icon_borrar.gif" alt="Eliminar" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CONFIRM" value="TRUE"><input type="image" src="../../../comu/confirma_elimina.gif" name="accio" value="Borrar" class="text10" align="absmiddle"></td>
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



