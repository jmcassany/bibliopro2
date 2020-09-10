<?php
 
include_once '../../selconfig.php';
include_once 'config.php';

accessCheckLevel(2, $CONFIG_PRE_NOMCARPETA.'/admin/');
function accessCheckLevel($level,$url){
    global $level_user;

    $level_user = $_SESSION['access']['level'];

    if($level_user >= $level){
        return true;
    }else{
        header("Location: $url");
        exit;
    }
}

$descripciocarpeta = 'RSS Notícies';

setCurrent('contingut');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
?>


<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td colspan="2">
		<div id="contingut">
		<ul id="submenu">
			<li><a href="../noticies_newsletter/list.php">Notícies</a></li>
			<li><a href="../banners_newsletter/list.php">Banners</a></li>
			<li><a href="../caps_newsletter/list.php">Capçaleres</a></li>
			<li><a href="../caixes_newsletter/list.php">Caixes</a></li>
			<li>Origens RSS</li>
		</ul>
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right" style="padding: 0 40px 10px 0"><img
			src="../../../../../public/media/comu/admin/bot_enrera_blau.gif"
			border="0" style="vertical-align: middle;" /> <a href="index.php">Tornar</a>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<table border="0" cellpadding="0" cellspacing="0" width="93%">
			<tr>
				<td align="left" style="padding: 8px;" bgcolor="#0E449A"
					class="blanc10b" valign="middle"><img
					src="../../../../../public/media/comu/admin/kland_flexa.gif"
					width="21" height="13" border="0" align="bottom">Crear origen RSS</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<form action="create.php" method="post" name="env_dades"
			enctype="multipart/form-data">
		<td colspan="2" align="center">
		<table border="0" cellpadding="5" cellspacing="5" width="93%">
			<tr>
				<td align="left" class=text valign=top width="20%">Estat:</td>
				<td align="left" valign=top width="80%"><?php echo ITEMS_HTMLSelect( 'STATUS', 'CARDS_STATUS', $DEFAULT_STATUS, $LANG);?></td>
			</tr>
			<tr>
				<td align="left" class=text valign=top width="20%">Títol:</td>
				<td align="left" valign=top width="80%"><input type="text"
					name="TITOL" maxlength="250" class="formulari"
					style="width: 500px;"></td>
				</td>
			</tr>
			<tr>
				<td align="left" class=text valign=top width="20%">Vincle RSS:</td>
				<td align="left" valign=top width="80%"><input type="text"
					name="LINK1" maxlength="250" class="formulari"
					style="width: 500px;"></td>
				</td>
			</tr>
			<tr>
				<td align="left" class=text valign=top width="20%">Número de
				notícies a mostrar:</td>
				<td align="left" valign=top width="80%"><input type="text"
					name="MAX_ITEMS" maxlength="250" class="formulari"
					style="width: 500px;"></td>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" style="border-top: solid #0E449A 1px;"
					align="center"><br />
				<INPUT TYPE="submit" NAME="accion" VALUE="Crear origen RSS" style="padding: 5px"></td>
			</tr>
		</TABLE>
		</td>
	
	</tr>
</table>

</form>

<?php 
 include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');
?>