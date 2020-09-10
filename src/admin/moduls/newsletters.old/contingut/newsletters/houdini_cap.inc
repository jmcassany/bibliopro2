
<table cellpadding="0" cellspacing="0" class="capadmin" summary="cap&ccedil;elera">
  <tr>
    <td rowspan="2" class="logo">
      <img src="../../../../../public/media/comu/admin/logo.gif" alt="" />
    </td>
    <td class="info">
      <img src="../../../../../public/media/comu/admin/icon_user_blanc.gif" alt="Usuari" border="0" align="absmiddle" /><?php echo $LOGIN; ?>
    </td>
    <td class="info" style="text-align: right">
    	<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>" class="blanc10" target="_blank">Vés al web</a>
      	&nbsp;|&nbsp;
      	<a href="../../../../login.php?action=logout" class="blanc10" title="Continguts">Surt<img src="../../../../../public/media/comu/admin/icon_tanca.gif" alt="Surt de la sessi&oacute;" border="0" align="absmiddle" /></a>
    </td>
  </tr>
  <tr>
    <td class="links" colspan="2">
      
      	<a href="../../../../index.php" class="negre10b" title="Continguts"><img src="../../../../comu/icon_continguts.gif" alt="Continguts" align="absmiddle" />Continguts</a>
		<?php if($_SESSION['access']['level'] == 5){ ?>
      		<a href="../../../../users/index.php" class="negre10b" title="Usuaris"><img src="../../../../../public/media/comu/admin/icon_gestio_usu.gif" alt="Usuaris" align="absmiddle" />Usuaris</a>
      		<a href="../../../../carpetes/index.php" class="negre10b" title="Carpetes"><img src="../../../../comu/icon_carpeta.gif"  alt="Carpetes" align="absmiddle" />Carpetes</a>
      		<a href="../../../../plantilles/index.php" class="negre10b" title="Plantilles"><img src="../../../../comu/icon_gest_plantilles.gif"  alt="Plantilles"  align="absmiddle" />Plantilles</a>
      		<a href="../../../../moduls/menus/index.php" class="negre10b"  title="Menus" ><img src="../../../../comu/icon_menus.gif" alt="Menu" align="absmiddle" />Menu</a>
      		<a href="../../../../formularis/index.php" class="negre10b" title="Formularis"><img src="../../../../comu/icon_formularis.gif" alt="Formularis" align="absmiddle" />Formularis</a>
      	<?php } ?>
       <a href="../../../../utilitats/index.php" class="negre10b"><img src="../../../../comu/icon_utilitats.gif" alt="Utilitats" align="absmiddle" />Utilitats</a>
      
    </td>
  </tr>
</table>
<a name="top"></a>