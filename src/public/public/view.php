<?php

include_once("config.php");

if($_GET['id']) {
    $query = db_query("SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE IdCam='".$_GET['id']."'");
    $data = db_fetch_array($query);
    $ID = $data['ID'];
    $id_campanya = $_GET['id'];
} elseif($_GET['ID']) {
    $ID = $_GET['ID'];
    $query = db_query("SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE ID=".$ID);
    $data = db_fetch_array($query);
    $id_campanya = $data['IdCam'];
}

$SKIN = $data['SKIN'];
if (empty($SKIN))  { $SKIN=0; }

if (empty($ID)) { echo "<B>".$messages["error1"]."</B><br>\n"; exit; }

$idioma = 'ca';
$content = file_get_contents($CONFIG_PATHBUTLLETINS . '/butlleti' . $data['ID'] . '.html');

if($content){
    echo $content;
} else {
    echo "<p><strong>".$messages["error3"]."</strong></p>";
    exit;
}

?>