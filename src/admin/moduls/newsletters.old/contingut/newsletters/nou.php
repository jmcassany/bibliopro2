<?php 
	include("config.php");
	
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca">
<head>
	<title>Houdini v2.0</title>
	<link rel="STYLESHEET" type="text/css" href="../../../../../public/media/css/estils.css">
	<link rel="STYLESHEET" type="text/css" href="../../../../css/estils.css">
	<link rel="STYLESHEET" type="text/css" href="../../media/css/estils-newsletter.css" />
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" media="all" href="../../../../../public/media/css/estils-newsletter-ie.css" />
	<![endif]-->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script language="javascript">
		//Testeig camps de text 
		function dades(){
			if (checkit_ins(document.env_dades)==0)
				return;
				
			document.env_dades.submit();
		}
		
		function checkit_ins(form){
			if(form.TITOL.value == ""){
				alert("<?php echo t("titolobligatori"); ?>");
				return (0);
			}else if(form.SKIN.value == ""){
				alert("<?php echo t("modelobligatori"); ?>");
				return (0);
			}else if(form.CAP.value == ""){
				alert("No heu escollit cap capçalera!");
                		return (0);
			}else{
				return (1);
			}
		}
		
		//Visualitzar plantilles 
		function doTemplate(myForm) {
		  SKIN = myForm.SKIN.value
		  ot1 = document.getElementById("t1")
		  if (SKIN == "") {
		          ot1.src = ""
		  } else {
		          ot1.src = "../../../../../public/media/models/model" + SKIN + ".jpg"
		  }
		}
		function doTemplate2(myForm) {
		  CAP = myForm.CAP.value
		  ot1 = document.getElementById("t2")
		  if (CAP == "") {
		          ot1.src = ""
		  } else {
		          ot1.src = "../../../../../public/media/upload/caps/capsal_newsletter" + CAP + ".jpg"
		  }
		}
</script>
<?php 
	//consulta titol newsletter ja introduit...
	$sql = "SELECT * FROM news_CAMPANYES WHERE IdCam=".$_GET['id'];
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$titol_newsletter = $row['titol'];
?>
</head>

<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php include ('houdini_cap.inc'); ?>

<form action="create.php" method="post" name="env_dades">	

<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;">			
<tr>
	<td colspan="2" style="padding-left:10px;padding-top:10px;padding-right:10px;">	
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="text10"><img src="../../../../../public/media/comu/admin/icon_plana.gif" alt="" width="33" height="18" border="0" align="absmiddle"><?php echo t("soua"); ?>: <font class="blau10b"><?php echo t("newsletters"); ?></font></td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td colspan="2">
		<div id="contenidor" class="crear pas2">
			<div id="cap">
				<h1>Houdini butlletins</h1>
					<ul id="principal">
						<li><a href="../../campanyes/index.php" class="crear">Gestionar butlletins</a></li>
						<li><a href="../index.php" class="butlletins">Gestionar contingut</a></li>
						<li><a href="../../llistes/index.php" class="llistes">Llistes de subscriptors</a></li>
						<li><a href="../../informes/index.php" class="informes">Informes</a></li>
					</ul>
			</div>
			<div id="contingut">
				<ul id="submenu">
					<li><a href="../../campanyes/index.php">Butlletins pendents d'enviar</a></li>
					<li>Crear nou Butlletí</li>
					<li><a href="../../campanyes/index_enviades.php">Veure els butlletins enviats</a></li>
				
				</ul>
				<ol id="passos">
					<li class="pas1"><span>Pas 1</span> Definir Newsletter</li>
					<li class="pas2 actiu"><span>Pas 2</span> Contingut</li>
					<li class="pas3"><span>Pas 3</span> Destinataris</li>
					<li class="pas4"><span>Pas 4</span> Testeig final</li>
				</ol>
			</div>
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
			<select name="SKIN" style="width:150px;" onChange="doTemplate(this.form);">
				<option value=""> </option>
				<?php
					foreach ($ITEMS['CARDS_SKIN']['ESP'] as $index => $valor){
						
						$tall = explode("_", $valor);
						$id_model = $tall[0];
						$nom_model = $tall[1];
						
						echo "<option value=".$id_model.">".$nom_model."</option>";
					}
				?>
			</select>
			</dd>	
		</dl>
<!--
		<dl>
			<dt><span>2</span> Capçalera</dt>
			<dd>
			<select name="CAP" style="width:150px;" onChange="doTemplate2(this.form);">
			<option value=""> </option>
			<?php
				$consulta = db_query("select * from CAPS_NEWSLETTER where STATUS=1 and USUARI_HOUDINI='".$_SESSION['access']['login']."'");
				while($resposta = db_fetch_array($consulta)){
					echo '<option value="'.$resposta['ID'].'">'.$resposta['TITOL'].'</option>';
				}
			?>
			</select>
			</dd>	
		</dl>
-->
<INPUT TYPE="HIDDEN" NAME="CAP" VALUE="0" />

	</td>
	<td style="padding:10px;" valign="top">
		<img src="../../../../../public/media/comu/icon_plantilla.gif" alt="" width="22" height="14" border="0" align="absmiddle"><?php echo t("visualitzarmodel"); ?>:<br>
		<iframe id=t1 src="" border="1" style="width:250px;height:200px;background-color:#FFFFFF;border:solid #E6E6E6 10px;margin-top:5px;"></iframe>
		<!--<br/><br/>
		<img src="../../../../../public/media/comu/icon_plantilla.gif" alt="" width="22" height="14" border="0" align="absmiddle">Visualitzar capçalera escollida:<br>
		<iframe id=t2 src="" border="1" style="width:250px;height:200px;background-color:#FFFFFF;border:solid #E6E6E6 10px;margin-top:5px;"></iframe>-->
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
<input type="hidden" name="USUARI_HOUDINI" value="<?php echo $_SESSION['access']['login']; ?>">
<input type="hidden" name="IdCam" value="<?php echo $_GET['id']; ?>">
</form>

<?php include ('houdini_peu.inc'); ?>

</body>
</html>