<?php
	require ('../../../config_admin.inc');
	include_once("../../../../public/media/lang/lang_ca.php");
	accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes

	$CONFIG_PATHCAMPANYES = '../';
	require_once($CONFIG_PATHCAMPANYES.'config.inc');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca">
<head>
	<title><?php echo $messages["website"]; ?></title>
	<link rel="STYLESHEET" type="text/css" href="../../../../public/media/css/estils.css">
	<link rel="STYLESHEET" type="text/css" href="../../../css/estils.css">
	<link rel="STYLESHEET" type="text/css" href="../media/css/estils-newsletter.css" />
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" media="all" href="../media/css/estils-newsletter-ie.css" />
	<![endif]-->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;">

	<tr>
		<td colspan="2" style="padding-left:10px;padding-top:10px;padding-right:10px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td class="text10"><img src="../../../../public/media/comu/admin/icon_plana.gif" alt="" width="33" height="18" border="0" align="absmiddle"><?php echo $messages["soua"]; ?>: <font class="blau10b"><?php echo $messages["newsletters"]; ?></font></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<div id="contenidor" class="butlletins">
				<div id="cap">
					<h1>Houdini butlletins</h1>
					<ul id="principal">
						<li><a href="../campanyes/index.php" class="crear">Gestionar butlletins</a></li>
						<li><a href="index.php" class="butlletins actiu">Gestionar contingut</a></li>
						<li><a href="../llistes/index.php" class="llistes">Llistes de subscriptors</a></li>
						<li><a href="../informes/index.php" class="informes">Informes</a></li>
					</ul>
				</div>
			</div>
		</td>
	</tr>

	<tr>
		<td colspan="2" style="padding:0 30px 15px 30px;">
			<table border="0" cellpadding="0" cellspacing="5" width="100%">
			<tr>
				<td class="items_butlleti">
					<a href="noticies_newsletter/list.php"><img src="../../../../public/media/comu/admin/ico_editora_noticies.jpg" alt="Notícies Butlletí" border="0" style="vertical-align:middle;" /> <?php echo $messages["editoranoticies"]; ?></a>
				</td>
				<td class="items_butlleti">
					<a href="categories_noticies/list.php"><img src="../../../../public/media/comu/admin/ico_editora_categories.jpg" alt="Categories Notícies" border="0" style="vertical-align:middle;" /> <?php echo $messages["editoracategories"]; ?></a>
				</td>
			<tr>
			</tr>
				<td class="items_butlleti">
					<a href="banners_newsletter/list.php"><img src="../../../../public/media/comu/admin/ico_editora_banners.jpg" alt="Banners Butlletí" border="0" style="vertical-align:middle;" /> <?php echo $messages["editorabanners"]; ?></a>
				</td>
				<td class="items_butlleti">
					<!--<a href="caps_newsletter/list.php"><img src="../../../../public/media/comu/admin/ico_editora_banners.jpg" alt="Banners Butlletí" border="0" style="vertical-align:middle;" /> Editora de capçaleres</a>-->&nbsp;
				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>

<table class="peuadmin" cellpadding="0" cellspacing="0" summary="peu pàgina">
  <tr>
    <td class="top">
      <a href="#top"><img src="../../../../public/media/comu/admin/pujar_houdini.gif" alt="<?php echo $messages["pujar"]; ?>" /></a>
    </td>
    <td class="credits">
      <a href="http://houdini.antaviana.net/" target="_blank"><img src="../../../../public/media/comu/admin/peu_houdini.gif" alt="Houdini" /></a>
      <?php echo $messages["foodproduct"]; ?>
      <a href="http://www.antaviana.net" target="_blank"><img src="../../../../public/media/comu/admin/peu_antaviana.gif" alt="Can Antaviana" /></a>
      &copy; 2003-<?php echo date('Y') ?>
    </td>
  </tr>
</table>

</body>
</html>
