<?php
//****
//**** Formulari per apuntar-se a una llista
//****
$CONFIG_PATHBASE = $_SERVER['DOCUMENT_ROOT'];
require_once($CONFIG_PATHBASE . '/public/config.php');

// desencriptar paràmetres i validar k són ok.
//$xurro = urldecode(stripslashes(obte_get('id')));
$xurro = trim(stripslashes(obte_get('id')));
$valors = explode($CRIPTO_SEPAR, base64_decode($xurro));

if ((count($valors)==4)&&($valors[2]==$CRIPTO_CHECK)) {

    $idlli = $valors[0];
    $IdSub = $valors[1];
    $idioma = $valors[3];
    //$idCam = $valors[2];
    //echo "Llista: $idlli  ,Email: $email"; die();  //proves

    /*
    $queryButlleti = db_query('SELECT * FROM ' . TAULA_NEWSLETTERS . ' WHERE IdCam = ' . $idCam);
    $dadesButlleti = db_fetch_array($queryButlleti);

    $queryCampanya = db_query('SELECT * FROM ' . TAULA_CAMPANYES . ' WHERE IdCam = ' . $idCam);
    $dadesCampanya = db_fetch_array($queryCampanya);
*/
    $result7 = db_query("SELECT * FROM " . TAULA_LLISTES . " WHERE IdLli='$idlli'");
    if (db_num_rows($result7) == 0) {
        header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=confirmaerror&error=4&idCam=" . $idCam . '&idioma='.$idioma);
        exit();
    } else {
        $rowLli =db_fetch_array($result7);

        $result9 = db_query("SELECT IdSub,email FROM " . TAULA_SUBSCRIPTORS . " WHERE IdSub='$IdSub' AND IdLli='$idlli'");
        
        if (db_num_rows($result9) == 0) {
            header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=confirmaerror&error=3&idCam=0&idioma=".$idioma);
            exit();
        } else {
            $row9 = db_fetch_array($result9);
            $camps = array();
            $camps['estat'] = 1;
            $camps['dh_baixa'] = NULL;
            $email = $row9['email'];
            $sqlUpdate = 'UPDATE ' . TAULA_SUBSCRIPTORS . ' SET estat = 1 WHERE email ="' . $email . '" AND IdLli = ' . $idlli;
            $resultUpdate = db_query($sqlUpdate);
            if ($resultUpdate) {
                header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=confirmaok&idCam=0&idioma=".$idioma);
                exit();
            }
            header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=confirmaerror&error=2&idCam=0&idioma=".$idioma);
            exit();
        }
    }
} else {
    header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=confirmaerror&error=1&idCam=0&idioma=".$idioma);
    exit();
}

?>