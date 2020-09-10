<?php
	//****
	//**** Formulari per apuntar-se a una llista
	//****
	include_once('config.php');
	include_once('database/database.inc');

	$CONFIG_PATHCAMPANYES = 'admin/moduls/newsletters/';
	$CFG_CAMPANYES['PATH_FUNCIONS'] = $CONFIG_PATHCAMPANYES.'xin/';
	require_once($CONFIG_PATHCAMPANYES.'config_bd.inc');
	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'tipic_db.php');
	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'tipic_funcions.php');

	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'cripto.inc');


	// desencriptar paràmetres i validar k són ok.
	//$xurro = urldecode(stripslashes(obte_get('id')));
	$xurro = trim(stripslashes(obte_get('id')));
	$valors = explode($CRIPTO_SEPAR, decrypt($xurro, $CRIPTO_KEY));
	
	$nl = trim(stripslashes(obte_postget('ID')));
	
	if ((count($valors)==3)&&($valors[2]==$CRIPTO_CHECK)) {
		$idlli = $valors[0];
		$email = $valors[1];
		//echo "Llista: $idlli  ,Email: $email"; die();  //proves

		$result7 = $db->sql_query("SELECT * FROM news_LLISTES WHERE IdLli='$idlli'");
		if ($db->sql_numrows($result7) == 0) {
			$MISSATGE = "No se encuentra el ID de la lista!";
		} else {
			$rowLli = $db->sql_fetchrow($result7);

			$result9 = $db->sql_query("SELECT IdSub FROM news_SUBSCRIPTORS WHERE email='$email' AND IdLli='$idlli'");
			if ($db->sql_numrows($result9) == 0) {
				$MISSATGE = "No se encuentra el correo de la lista!";
			} else {
				$camps = array();
				$camps['estat'] = 1;
				$camps['dh_baixa'] = NULL;
				if (fer_update('news_SUBSCRIPTORS', $camps, "email='$email' AND IdLli='$idlli'",0)) $MISSATGE = 'Confirmada la suscripción para el correo <strong>'.$email.'</strong>';
				else $MISSATGE = "NO se ha podido confirmar la suscripción para el correo <strong>$email<strong>";
			}
		}

	} else $MISSATGE = 'Parámetros erroneos!';


// retorna html amb el missatge de l'acció

include_once("public/config.php");

$sql = "select * from NEWSLETTERS where ID=".$nl;
$query = mysql_query($sql);
$row = mysql_fetch_array($query);

$CAP = $row['CAP'];
$SKIN = $row['SKIN'];
$tornar = 'public/view.php?ID='.$nl;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca" lang="ca">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>El boletín electrónico de BiblioPRO. Acción de soporte a la investigación y de transferencia del CIBER en Epidemiología y Salud Pública (CIBERESP)</title>
</head>
<body style="background:#fff; font-family:Arial, Verdana, sans-serif; font-size:100%; color:#333; text-align:left" link="#007f00" vlink="#007f00" id="top">
	<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width:571px; margin:0 auto; background:#fff; border:14px solid #fff; border-width:0 14px">
		<!-- Capçalera -->
		<thead>
			<tr style="height: 2.5em">
				<td style="font-size:.75em;">&nbsp;</td>
				<td style="width:19px"></td>
				<td style="font-size:.75em; text-align:right">
					<a href="<?php echo $tornar; ?>" style="text-decoration:none"><img src="public/media/comu/bot_enrera_blau.gif" alt="" border="0"> Volver</a>
				</td>
			</tr>
			<tr>
				<th colspan="3">
					<h1 style="margin:0"><img src="public/media/upload/caps/capsal_newsletter<?php echo $CAP; ?>.jpg" width="571" alt="" usemap="#m_capsalera_bibliopro" border="0" /></h1>
				</th>
			<tr>
				<td colspan="3" style="background:#fcad56">
					<p style="font-weight:normal; color:#333; font-size:.75em; margin: 8px 0 6px 20px">
						<strong>Confirmación de suscripción</strong>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
		</thead>
		<!-- /Capçalera -->
		<!-- Peu -->
		<tfoot>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3">
					<table cellspacing="0" cellpadding="0" border="0" width="571" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;color: #333;background-color:#fdc17f">
					<tr>
						<td style="padding:5px;text-align:center">
							<p>
							<?php echo $messages["peu"]; ?>
							</p>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
		</tfoot>
		<!-- /Peu -->
		<!-- Contingut -->
		<tbody>
			<tr>
				<td colspan="3">
					<table border="0" cellspacing="0" cellpadding="0" style="width:571px; border-collapse:collapse;">
						<tr>
							<!-- Contingut principal -->
							<td width="556" valign="top" style="font-size:.75em;">
								<?php echo $MISSATGE; ?>
							</td>
							<!-- /Contingut principal -->
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
		<!-- /Contingut -->
	</table>
	<!-- mapa imatge capçalera -->
	<map name="m_capsalera_bibliopro">
		<area shape="rect" coords="465,50,570,72" href="http://www.imim.es/infocorporativa/es_fundacio.html" title="Fundació IMIM" alt="Fundació IMIM" >
		<area shape="rect" coords="471,11,566,45" href="http://www.ciberesp.es/" title="Ciberesp" alt="Ciberesp" >
		<area shape="poly" coords="24,9,191,9,197,12,200,18,200,46,197,52,191,55,24,55,18,52,15,46,15,18,18,12,24,9,24,9" href="http://bibliopro.imim.es" title="BiblioPRO" alt="BiblioPRO" >
	</map>
</body>
</html>
