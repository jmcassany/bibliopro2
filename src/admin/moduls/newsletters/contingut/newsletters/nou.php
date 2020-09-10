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

$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

//consulta titol newsletter ja introduit...
$sql = "SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam=".$IdCam;
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$titol_newsletter = $row['titol'];

setCurrent('butlletins');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
?>

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
		<?php echo _t("titol"); ?>: <strong><?php echo $titol_newsletter; ?></strong>
		<input type="hidden" name="TITOL" value="<?php echo $titol_newsletter; ?>" >
		<br /><br />
		<dl>
			<dt><span>1</span> <?php echo _t("model"); ?></dt>
			<dd>
			<select id="SKIN" name="SKIN" style="width:150px;" onChange="doTemplate(this.form);" class="required">
				<option value=""> </option>
				<?php
				foreach ($MODELS as $index => $model){
				    $selmodel = '';
				    if(isset($_GET['skin']) && $_GET['skin'] == $index){
				        $selmodel = 'selected';
				    }
				    if(is_dir($CONFIG_PATHBASE . $CONFIG_NOMCARPETA . '/media/plantilles/model' . $index . '/')){
				        echo "<option value=".$index." " . $selmodel . ">".$model['nom']."</option>";
				    }
				}
				?>
			</select>
			<?php if(isset($_GET['error']) && $_GET['error'] == '1' || $_GET['error'] == '3'){ echo '<p class="error">Heu de sel·leccionar un model</p>';} ?>
			</dd>
		</dl>
		<dl>
			<dt><span>2</span> Capçalera</dt>
			<dd>
			<select name="CAP" style="width:150px;" onChange="doTemplate2(this.form);" class="required">
			<option value=""> </option>
			<?php
			$sql_cap = "SELECT * FROM " . TAULA_CAPÇALERES . " WHERE STATUS=1";
			$consulta = db_query($sql_cap);
			while($resposta = db_fetch_array($consulta)){
			    $selcap = '';
			    if(isset($_GET['cap']) && $_GET['cap'] == $resposta['ID']){
			        $selcap = 'selected';
			    }
			    echo '<option value="'.$resposta['ID'].'" ' . $selcap . '>'.$resposta['TITOL'].'</option>';
			}
			?>
			</select>
			<?php if(isset($_GET['error']) && $_GET['error'] == '2' || $_GET['error'] == '3'){ echo '<p class="error">Heu de sel·leccionar una capçalera</p>';} ?>
			</dd>
		</dl>
	</td>
	<td style="padding:10px;" valign="top">
		<img src="../../../../../public/media/comu/icon_plantilla.gif" alt="" width="22" height="14" border="0" align="absmiddle">Visualitzar el model escollit:<br>
		<iframe id=t1 src="" border="1" style="width:250px;height:200px;background-color:#FFFFFF;border:solid #E6E6E6 10px;margin-top:5px;"></iframe>
		<br/><br/>
		<img src="../../../../../public/media/comu/icon_plantilla.gif" alt="" width="22" height="14" border="0" align="absmiddle">Visualitzar capçalera escollida:<br>
		<iframe id=t2 src="" border="1" style="width:250px;height:200px;background-color:#FFFFFF;border:solid #E6E6E6 10px;margin-top:5px;"></iframe>
	</td>
</tr>
<tr>
	<td colspan="2" style="padding:10px 40px 10px 40px;" valign="top">
	<div id="botons">
		<a href="../../campanyes/pas2b.php?IdCam=<?php echo $IdCam; ?>" class="boto anterior">Anterior</a>
		<input type="button"  value="<?php echo _t("continuar"); ?>" onclick="javascript:dades();" class="boto continuar" />
	</div>


	</td>
</tr>
</table>

<input type="hidden" name="COD" value="C">
<input type="hidden" name="STATUS" value="1">
<input type="hidden" name="CATEGORY1" value="1">
<input type="hidden" name="USUARI_HOUDINI" value="<?php echo $LOGIN; ?>">
<input type="hidden" name="idCam" value="<?php echo $IdCam; ?>">
</form>

<?php include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc'); ?>
