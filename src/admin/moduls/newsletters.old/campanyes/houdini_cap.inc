<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html>
<head>

<title>Houdini v2.0</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<link rel="STYLESHEET" type="text/css" href="../../../css/estils.css" />
<link rel="STYLESHEET" type="text/css" href="../media/css/estils-newsletter.css" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" media="all" href="../media/css/estils-newsletter-ie.css" />
<![endif]-->

<link rel="shortcut icon" href="comu/favicon.gif" type="text/gif" />
<meta name="lang" content="" />

<meta name="author" content="Can Antaviana SL. www.antaviana.com" />

<script type="text/javascript" src="../../../js/basic-tools.js"></script>
<script type="text/javascript" src="../media/js/newsletters-tools.js"></script>
</head>

<?php
/*
if(isset($_GET['opcio']) and ($_GET['opcio']=='duplica')){
	echo '<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="javascript:return launchPreview(\'mostra.php?id='.$_GET['id'].'&amp;fmt=1\')"">';
}
else{
	echo '<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">';
}
*/
?>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- CAP&Ccedil;ELERA -->
<table cellpadding="0" cellspacing="0" class="capadmin" summary="cap&ccedil;elera">
  <tr>
    <td rowspan="2" class="logo">
      <img src="../../../comu/logo.gif" alt="" />
    </td>

    <td class="info">
      <img src="../../../comu/icon_user_blanc.gif" alt="Usuari" border="0" align="absmiddle" /><?php echo $LOGIN; ?>
    </td>
    <td class="info" style="text-align: right">
    	<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>" class="blanc10" target="_blank">Vés al web</a>
      	&nbsp;|&nbsp;
      	<a href="../../../login.php?action=logout" class="blanc10" title="Continguts">Surt<img src="../../../comu/icon_tanca.gif" alt="Surt de la sessi&oacute;" border="0" align="absmiddle" /></a>
    </td>

  </tr>
  <tr>
    <td class="links" colspan="2">
    
      <a href="../../../index.php" class="negre10b" title="Continguts"><img src="../../../comu/icon_continguts.gif" alt="Continguts" align="absmiddle" />Continguts</a>
      <?php if($_SESSION['access']['level'] == 5){ ?>
      		<a href="../../../users/index.php" class="negre10b" title="Usuaris"><img src="../../../comu/icon_gestio_usu.gif" alt="Usuaris" align="absmiddle" />Usuaris</a>
      		<a href="../../../carpetes/index.php" class="negre10b" title="Carpetes"><img src="../../../comu/icon_carpeta.gif"  alt="Carpetes" align="absmiddle" />Carpetes</a>
      		<a href="../../../plantilles/index.php" class="negre10b" title="Plantilles"><img src="../../../comu/icon_gest_plantilles.gif"  alt="Plantilles"  align="absmiddle" />Plantilles</a>
      		<a href="../../../moduls/menus/index.php" class="negre10b"  title="Menus" ><img src="../../../comu/icon_menus.gif" alt="Menu" align="absmiddle" />Menu</a>
      		<a href="../../../formularis/index.php" class="negre10b" title="Formularis"><img src="../../../comu/icon_formularis.gif" alt="Formularis" align="absmiddle" />Formularis</a>
      <?php } ?>
       <a href="../../../utilitats/index.php" class="negre10b"><img src="../../../comu/icon_utilitats.gif" alt="Utilitats" align="absmiddle" />Utilitats</a>
      
    </td>
  </tr>
</table>
<!-- /CAP&Ccedil;ELERA -->

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="50%" class="text10"><img src="../../../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle">Sou a: <font class="blau10b">Gestió de Butlletins digitals</font></td>
				</tr>

			</table>
		</td>
	</tr>

	<!-- /situacio Sou a -->

	<tr>
		<td>

