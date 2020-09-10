<?php

include_once('../selconfig.php');

setCurrent('configuracio');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');

$mis = '';
$host = '';
$user = '';
$pass = '';
$id = 0;

if ($_POST['enviar']) {

	if ($_POST['host'] AND $_POST['user'] AND $_POST['pass']) {

		$sql = "SELECT * FROM " . TAULA_BOUNCES;
		$result = db_query($sql);
		$num_rows = db_num_rows($result);
		if ($num_rows > 0) {
			$sql_update = "UPDATE " . TAULA_BOUNCES . " SET host='".$_POST['host']."',user='".$_POST['user']."',pass='".$_POST['pass']."' WHERE id=".$_POST['id'];
			$result_update = db_query($sql_update);
		}
		else {
			$sql_insert = "INSERT INTO " . TAULA_BOUNCES . " (host,user,pass) VALUES ('".$_POST['host']."','".$_POST['user']."','".$_POST['pass']."')";
			$result_insert = db_query($sql_insert);
		}

		$mis = 'Dades actualitzades!';
	}
	else {
		$mis = 'No heu omplert tots els camps!';
	}
}

$sql = "SELECT * FROM " . TAULA_BOUNCES;
$result = db_query($sql);
$row = db_fetch_array($result);
if ($row) {
	$host = $row['host'];
	$user = $row['user'];
	$pass = $row['pass'];
	$id = $row['id'];
}

?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 30px 20px 30px">
<tr>
	<td>
		<h2>Configuració de l'eina</h2>
	</td>
</tr>
<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" >
		<tr>
			<td colspan="2" valign="top" style="padding-right:10px;">

				<p><strong>Configuració del compte correu POP3 x gestionar enviaments rebotats (Bounces)</strong></p>

				<p style="color: red"><?php echo $mis; ?></p>

				<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<p>
					<label for="host">Host:<br /><input type="text" name="host" id="host" value="<?php echo $host; ?>" class="formulari" /></label>
				</p>
				<p>
					<label for="user">User:<br /><input type="text" name="user" id="user" value="<?php echo $user; ?>" class="formulari" /></label>
				</p>
				<p>
					<label for="pass">Passwd:<br /><input type="text" name="pass" id="pass" value="<?php echo $pass; ?>" class="formulari" /></label>
				</p>
				<p>
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
					<input type="submit" name="enviar" value="Enviar" class="formulari" style="width: 100px; background-color: #ccc" />
				</p>
				</form>

			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<?php include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc'); ?>
