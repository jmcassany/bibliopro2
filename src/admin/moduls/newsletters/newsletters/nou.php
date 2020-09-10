<?php
$pathBase = $_SERVER['DOCUMENT_ROOT'];
include($pathBase . '/admin/moduls/newsletters/config.inc');
    var_dump($_SESSION);
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

	//consulta titol newsletter ja introduit...
	$sql = "SELECT * FROM newsletter_campanyes WHERE IdCam=".$_GET['id'];
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$titol_newsletter = $row['titol'];
?>

<?php include ('houdini_cap.inc'); ?>

<form action="create.php" method="post" name="env_dades">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td colspan="2">

			<div id="contingut">
				<ul id="submenu">
					<li><a href="../../campanyes/index.php">Butlletins pendents d'enviar</a></li>
					<li>Crear nou Butlletí</li>
					<li><a href="../../campanyes/index_enviades.php">Veure els butlletins enviats</a></li>

				</ul>
			</div>

		<h2 style="margin-left:40px;"><span>Segon pas.</span> Crear butlletí</h2>
	</td>
</tr>
<tr>
	<td style="padding:10px 10px 10px 40px;" valign="top">
		<?php echo t("titol"); ?>: <strong><?php echo $titol_newsletter; ?></strong>
		<input type="hidden" name="TITOL" value="<?php echo $titol_newsletter; ?>" >
		<br /><br />
		<dl>
			<dt><span>1</span> <?php echo t("model"); ?></dt>
			<dd>
			<select id="SKIN" name="SKIN" style="width:150px;" onChange="doTemplate(this.form);">
				<option value=""> </option>
				<?php
					foreach ($MODELS as $index => $model){
						echo "<option value=".$index.">".$model['nom']."</option>";
					}
				?>
			</select>
			</dd>
		</dl>
		 <input type="hidden" name="SKIN" value="0" >
		<dl>
			<dt><span>1</span> Capçalera</dt>
			<dd>
			<select name="CAP" style="width:150px;" onChange="doTemplate2(this.form);">
			<option value=""> </option>
			<?php
				$sql_cap = "select * from newsletter_headers where STATUS=1 and USUARI_HOUDINI='".$LOGIN."'";
				$consulta = db_query($sql_cap);
				while($resposta = db_fetch_array($consulta)){
					echo '<option value="'.$resposta['ID'].'">'.$resposta['TITOL'].'</option>';
				}
			?>
			</select>
			</dd>
		</dl>
	</td>
	<td style="padding:10px;" valign="top">
		<img src="../../../../../public/media/comu/icon_plantilla.gif" alt="" width="22" height="14" border="0" align="absmiddle"><?php echo t("visualitzarmodel"); ?>:<br>
		<iframe id=t1 src="" border="1" style="width:250px;height:200px;background-color:#FFFFFF;border:solid #E6E6E6 10px;margin-top:5px;"></iframe>
		<br/><br/>
		<img src="../../../../../public/media/comu/icon_plantilla.gif" alt="" width="22" height="14" border="0" align="absmiddle">Visualitzar capçalera escollida:<br>
		<iframe id=t2 src="" border="1" style="width:250px;height:200px;background-color:#FFFFFF;border:solid #E6E6E6 10px;margin-top:5px;"></iframe>
	</td>
</tr>
<tr>
	<td colspan="2" style="padding:10px 40px 10px 40px;" valign="top">
	<div id="botons">
		<a href="../../../campanyes/pas2b.php?id=<?php echo $_GET['id']; ?>" class="boto anterior">Anterior</a>
		<input type="button"  value="<?php echo t("continuar"); ?>" onclick="javascript:dades();" class="boto continuar" />
	</div>


	</td>
</tr>
</table>

<input type="hidden" name="COD" value="C">
<input type="hidden" name="STATUS" value="1">
<input type="hidden" name="CATEGORY1" value="1">
<input type="hidden" name="USUARI_HOUDINI" value="<?php echo $LOGIN; ?>">
<input type="hidden" name="IdCam" value="<?php echo $_GET['id']; ?>">
</form>

<?php include ('houdini_peu.inc'); ?>
