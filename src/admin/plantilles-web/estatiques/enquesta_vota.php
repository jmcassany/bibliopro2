<?php

	
	/*incloure configuració global*/
	require_once ('|CONFIG_PATHBASE|/media/php/config.php');
	/*incloure llibreria de base de dades*/
	require_once ("database/database.inc");
	/*connectar amb la db*/
	db_connect($db_url_web);
	
	$CONFIG_NOMCARPETA = '|CONFIG_NOMCARPETA|';
	
	
	
	
if(isset($_POST['ENQUESTA'])){	
	
	//CONTROL CAPTCHA
	include "media/enquesta/crypt/functions.php";
	
	//ACTIVAR si es posa el CAPTCHA
	if (chk_crypt($_POST['code'])) {
		
		//ACTIVAR si es posa el CAPTCHA
		$enquesta = $_POST['ENQUESTA'];
		$pregunta = $_POST['PREGUNTA'];
		
		//ACTIVAR si es posa la COOKIE (i DESACTIVAR tot lo del CAPTCHA!!!!)
		//$enquesta = $_POST['ENQUESTA'];
		//$pregunta = $_POST['PREGUNTA'.$_POST['ENQUESTA']];

		
		$sql2 = 'select VOTS from ENQUESTA_PREG where ID='.$pregunta;
		$result = db_query($sql2); 
		$row = db_fetch_array($result);
		$VOT = $row['VOTS'];
		
		//CONTROL x COOKIE
		if((isset($_COOKIE['enquestav'.$enquesta])) AND ($_COOKIE['enquestav'.$enquesta]) ){ 
			//header("Location: ".$CONFIG_NOMCARPETA."/enquesta.html?ENQUESTA=".$enquesta);
			echo '<SCRIPT LANGUAGE="javascript">
		      alert("Ho sentim, no es pot votar dos cops la mateixa enquesta.");
		      location.href = "enquesta.html?ENQUESTA='.$enquesta.'";
		    </SCRIPT>';
		}else{
			$user = "invitat";
			setcookie('enquestav'.$enquesta,$user,time()+86400,'/','',0);
		   	$VOT = $VOT+1;			   
		   	$sql = 'UPDATE ENQUESTA_PREG SET VOTS='.$VOT.' where ID='.$pregunta.' AND ENQUESTA='.$enquesta;
		   	$result = db_query($sql);
		   	if($result) {
				header("Location: enquesta.html?ENQUESTA=".$enquesta);
		   	} else {
				echo ("<a href='javascript:history.back()'>Tornar</a>");
		   	}
		}

	//ACTIVAR si es posa el CAPTCHA
	}else{
		$enquesta = $_POST['ENQUESTA'];
		$pregunta = $_POST['PREGUNTA'.$_POST['ENQUESTA']];
	}
	
}	
?>		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="|IDIOMA_PAG|" lang="|IDIOMA_PAG|">
<head>

	|block-static-metas_css|

</head>
<body>
<div id="marc"><a name="dalt" id="dalt"></a>

	|block-static-capsalera|

	|block-static-etsa|
	<div id="cos">
		<div id="barraLateral-1">
			<div id="navPrincipal">
				|MENUESQUERRA|
			</div>
		</div>
		<div id="caixaContingut">
		<div id="contingut">
			<div class="subTitol clearfix">
				<span class="dreta"><a href="index.html">&lt;&lt; Tornar</a></span>
				<h2>|Titol|</h2>
			</div>

			|Contingut|
			
			<form action="enquesta_vota.php" class="formulari-enquesta" method="post"  style="margin:0;">
			<p class="captcha-enquesta">
			<?php 
				if(isset($_POST['ENQUESTA'])){
					dsp_crypt(0,1); 
				}
			?>
			<br />Reescriviu el codi de la imatge per fer efectiu el vot:<br /><input type="text" name="code" size="14">
			</p>
			<input type="hidden" name="PREGUNTA" value="<?php echo $pregunta ?>" />
			<input type="hidden" name="ENQUESTA" value="<?php echo $enquesta ?>" />
			<button type="submit" name="action" id="boto<?php echo $enquesta ?>" value="vota"><img src="media/gif/bt_votar.gif" width="72" height="15" alt="Votar" /></button>
			</form>

			<div class="pujar"><a href="#dalt">Pujar</a></div>
		</div>
		</div>
		<div class="clear"></div>
	</div>

	|block-static-peu|

</div>
</body>
</html>
