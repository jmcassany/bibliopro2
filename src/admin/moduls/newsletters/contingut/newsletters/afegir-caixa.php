<?php
include_once '../../selconfig.php';
include_once 'config.php';

$idCam = isset($_POST['idCam']) ? $_POST['idCam'] : (isset($_POST['id']) ? $_POST['id'] : null);
if (isset($idCam)) {
    $query = db_queryd("SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE IdCam = '" . $idCam . "'");
    $dades = db_fetch_array($query);
}

$SKIN = $dades['SKIN'];
$numCols = $MODELS[$SKIN]['num_apartats'];
$editores = '';
foreach ($CONFIG_editoresNL as $key => $value) {
    $origen_id = '';
    if (isset($value['id']) and $value['id'] != '') {
        $origen_id = '_'.$value['id'];
    }
    $editores .= '<option value="'.$value['valor'].$origen_id.'">'.htmlspecialchars($value['nom']).'</option>';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca" lang="ca">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>Afegir caixa al newsletter - Can Antaviana</title>
<meta name="description" content="Demostració del sistema de caixes configurables" />
<meta name="keywords" content="caixes, configurables, mòbils, antaviana, javascript, jquery" />
<link rel="shortcut icon" href="media/css/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="/admin/moduls/newsletters/media/css/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/admin/moduls/newsletters/media/css/print.css" type="text/css" media="print" />
<script type="text/javascript" src="/admin/moduls/newsletters/media/js/jquery.js"></script>
</head>

<body id="popup">

<form method="post" action="afegir-items.php" id="newBoxForm">
    <fieldset>
        <legend>Afegir nova caixa</legend>
        <label for="nomCaixa">
            <span>Títol de la caixa:</span>
            <input type="text" name="nomCaixa" id="nomCaixa" />
       </label>
       <label for="tipusCaixa">
            <span>Tipus de caixa:</span>
            <select name="tipusCaixa" id="tipusCaixa">
	           <?php echo $editores; ?>
	        </select>
	   </label>
<?php
if (is_numeric($numCols) and $numCols >= 1) {

    ?> <label for="columna">
        <span>Ubicació de la caixa:</span> 
        <select name="columna" id="columna">
	<?php
	for ($i = 0; $i < $numCols; $i++) {

	    ?>
	       <option value="<?php echo $i; ?>">Caixa <?php echo $i+1; ?></option>
	<?php
	}
	?>
        </select>
    </label>
<?php
}
?>

<div>
    <input type="submit" name="Enviar" value="Escollir entrades" class="chooseEntries" />
</div>
    <label><input type="hidden" name="idCam" id="idCam" value="<?php echo htmlspecialchars($idCam); ?>" /></label>
    <label><input type="hidden" name="novaCaixa"  id="novaCaixa" value="1" /></label>
</fieldset>
</form>

</body>

</html>
