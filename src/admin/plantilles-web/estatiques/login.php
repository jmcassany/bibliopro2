<?php

	function login ($error, $url) {

		global $CONFIG_SITENAME, $CONFIG_URLADMIN;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="|IDIOMA_PAG|" lang="|IDIOMA_PAG|">

	<head>

|block-static-metas_css|

		<script src="|CONFIG_NOMCARPETA|/media/js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="|CONFIG_NOMCARPETA|/media/js/jquery.validate.messages_es.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#loginForm').validate();
			});
		</script>

	</head>

	<body>

|block-static-header|

		<div id="menu">
|block-static-mbp|
|MENUSUPERIOR|
		</div>
		<!-- /menu -->

		<div id="page">

			<div id="content" class="clearfx">

				<h2>|Titol|</h2>

<?php

	// si l'usuari no està identificat, mostrem formulari
	if (!is_callable('accessGetLogin') or accessGetLogin() == '') {

		if ($error) {

?>
					<div class="error">
						<h4>Error en los datos</h4>
						<p>El correo electrónico o la contraseña introducidos no son válidos.</p>
					</div>
<?php

		}

?>

				<form action="|CONFIG_NOMCARPETA|/login.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="loginForm">
					<fieldset>
						 <label for="login"><span>Correo electrónico</span>
							<input type="text" name="LOGIN" id="login" value="" class="formulari normal required"  />
						 </label>
						 <label for="passwd"><span>Contraseña</span>
							<input type="password" name="PASSWD" id="passwd" value="" class="formulari required"  />
						 </label>
					</fieldset>
					<input type="hidden" name="url" id="url" value="<?php echo $url ?>" />
					<input type="submit" name="action" id="action" value="Entrar" class="send" />
				</form>

<?php

	}
	// si l'usuari ja està identificat, l'informem
	else {

?>
				<div class="ok">
					<h4>Ya identificado</h4>
					<p>Ya estás identificado en BiblioPRO como <strong><?php echo accessGetValue('USER_NAME'); ?></strong>.</p>
				</div>
<?php

	}

?>

			</div>
			<!-- /content -->

		</div>
		<!-- /page -->

|block-static-footer|

|block-static-supporters|

	</body>

</html>
<?php

	}

	/*incloure configuració global*/
	require_once ('|CONFIG_PATHBASE|/media/php/config.php');
	/*incloure llibreria de base de dades*/
	require_once ("database/database.inc");
	/*connectar amb la db*/
	db_connect($db_url_web);
	/*incloure gestio de permissos*/
	require_once ('aw/awaccess.php');
	/*incloure gestio d'usuaris*/
	require_once("aw/dbusers.php");
	/*altres*/
	require_once("aw/awtools.php");
	require_once("aw/awitems.php");

	/*obte els parametres*/

	$url = '';
	if (!empty($_POST['url'])) {
		$url = $_POST['url'];
	}
	else if (!empty($_GET['url'])) {
		$url = $_GET['url'];
	}

	$action = '';
	if (!empty($_POST['action'])) {
		$action = $_POST['action'];
	}
	else if (!empty($_GET['action'])) {
		$action = $_GET['action'];
	}

	/*sortir de sistema*/
	if ($action == 'logout') {
		accessLogout();
		login(0,'');
		exit;
	}

	/*cap acció, mostrar fromulari d'entrada*/
	if ($action != 'Entrar') {
		login(0, $url);
		exit;
	}

	/*no hi ha login o password, mostrar formulari*/
	if ((empty($_POST['LOGIN'])) || (empty($_POST['PASSWD'])) ) {
		login(1, $url);
		exit;
	}

	$LOGIN = $_POST['LOGIN'];
	$PASSWD = $_POST['PASSWD'];

	/*començar validació*/
	$Users = new dbUsers();
	if (!$Users->Ok) {
		exit;
	}

	/*obtenir les dades de l'usuari*/
	$user = $Users->readUser($LOGIN);
	if (!$user) {
		/*usuari no existeix*/
		login(1, $url);
		exit;
	}
	if ($ldap_active) {
		$value = $user['cn'];
	}
	else {
		$value = $LOGIN;
	}

	if (!$Users->validateUser($value, $PASSWD)) {
		/*usuari no existeix*/
		login(1, $url);
		exit;
	}

	$group = strip_tags($user['USERLEVEL']);
	// $PASSWDOK = strip_tags($user['PASSWD']);
	$STATUS = strip_tags($user['STATUS']);
	$EXPIRATION = strip_tags($user['EXPIRATION']);
	$LOGIN = strip_tags($user['LOGIN']);
	$EMAIL = strip_tags($user['EMAIL']);
	$REALNAME = strip_tags($user['REALNAME']);
	/* Si està inactiu el fem fora, si està actiu o en espera pot entrar. */
	if ($STATUS=='1') {
		accessLogout(); // per si un cas no era ell
		login(1, $url);
		exit;
	}
	/* Si està caducat el fem fora */
	$limit=TOOLS_TimestampToInt($EXPIRATION);
	$now=TOOLS_TimestampToInt(TOOLS_GetTimestamp());
	if ($limit!=0 && $now>$limit) {
		accessLogout(); // per si un cas no era ell
		login(1, $url);
		exit;
	}

	// validem l'usuari i n'indiquem la informació
	accessLogin($group, $LOGIN);
	accessSetValue('USER_EMAIL', $EMAIL);
	accessSetValue('USER_NAME', $REALNAME);

	if (!empty($url) and strpos($url, 'login.php') === false) {
		header('Location: ' . str_replace('?logout', '', str_replace('&logout', '', $url)));
	}
	else {
		header('Location: |CONFIG_NOMCARPETA|/mbp');
	}

?>