<?php

include_once '../selconfig.php';

$ID = trim(stripslashes(obte_postget('id')));
$fmt = intval($_GET['fmt']);

$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

$result5 = $db->sql_query("SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam = '$IdCam'");
if ($db->sql_numrows($result5) == 0) {
    htmlNewsletterError('Campanya no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);

if ((($fmt==0)&&($row5['format']==3)) || ($fmt==2)) { //només text
    echo nl2br($row5['msg_text']);
} else {
    echo $row5['msg_html'];
}



?>
