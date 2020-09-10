<?php
//****
//**** Retorna la imatge demanada i actualitza com a llegit per la Campanya+Correu donats.
//****
include_once("config.php");

$imatge = trim(stripslashes(obte_get('img')));
//if ($imatge=='') $imatge = 'admin/comu/hlogo.gif';
if ($imatge=='') $imatge = $CONFIG_URLBASE . '/media/comu/pix.gif';

// desencriptar paràmetres i validar k són ok.
//$xurro = urldecode(stripslashes(obte_get('id')));
$xurro = trim(stripslashes(obte_get('id')));
$valors = explode($CRIPTO_SEPAR, decrypt($xurro, $CRIPTO_KEY));

if ((count($valors)==4)&&($valors[3]==$CRIPTO_CHECK)) {
    $idcam = $valors[0];
    $idusu = $valors[1];
    $email = $valors[2];
    //echo "Campanya: $idcam  ,Usuari: $idusu  ,Email: $email";  //proves
    //die();

    // Llegir registre a actualitzar
    $result5 = db_query("SELECT estat FROM " . TAULA_DESTINATARIS . " WHERE IdCam = '$idcam' AND email='$email'");
    if (db_num_rows($result5) > 0) {
        $row5 = db_fetch_array($result5);
        if ($row5['estat'] == 1) {  //si consta com enviat, marcar com llegit, però no fer-ho si consta com a unsubscrit o encara no s'ha enviat!
            $camps = array();
            $camps['estat'] = 10;
            $camps['dh_recepcio'] = date("Y-m-d H:i:s");
            fer_update(TAULA_DESTINATARIS, $camps, "IdCam = '$idcam' AND email='$email' AND IdUsu='$idusu'");
        }
    }
}

// retorna $imatge
header("Location: $imatge");
die();