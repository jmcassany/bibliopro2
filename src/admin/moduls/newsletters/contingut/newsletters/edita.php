<?php
include_once '../../selconfig.php';
include_once 'config.php';
include_once 'funcions.inc';


$idCam = isset($_POST['idCam']) ? $_POST['idCam'] : (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['IdCam']) ? $_GET['IdCam'] : ''));
accessCheckLevel(2, $CONFIG_PRE_NOMCARPETA.'/admin/');
function accessCheckLevel ($level,$url)
{
    global $level_user;

    $level_user = $_SESSION['access']['level'];

    if ($level_user >= $level) { return true; }
    else { header("Location: $url"); exit; }
}

if (isset($_GET['IdCam'])) { $id_campanya = $_GET['IdCam']; }

if ($idCam) {
    $query = db_query("SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE IdCam=".$idCam);
    $dades = db_fetch_array($query);
    $ID = $dades['ID'];
}

$dades['IDNL'] = $dades['IDNL'];
$dades['ID_CAMPANYA'] = $idCam;
$dades['getID'] = $idCam;

$newsletter = $dades['CONTINGUT'];
$newsletter = unserialize($newsletter);

if(unserialize($dades['CONTENT'])){
    $content = unserialize($dades['CONTENT']);
} else {
    $content = array();
}

ini_set('xdebug.var_display_max_children', '9999');
ini_set('xdebug.var_display_max_depth', '9999');
// 	var_dump($newsletter);

$SKIN = $dades['SKIN'];
if (empty($SKIN))  { $SKIN=0; }

// Create and define Template
$Tpl = new awTemplate();
$Tpl->scanFile("edita0.tpl");

// si hi ha cap problema -> Error
if (!$Tpl->Ok) { echo "<p><strong>Error al crear el TPL.</strong></p>\n"; exit; }


$tipusCaixa = isset($_POST['tipusCaixa']) ? $_POST['tipusCaixa'] : '';

//gestio origens
$origen = 0;
$tall = explode("_", $tipusCaixa);
if(is_array($tall)){
    if (isset($tall[1]) && $tall[1] != '') {
        $tipusCaixa = $tall[0];
        $origen = $tall[1];
    }
}

// si s'està afegint una nova caixa, la posem al final de la primera columna (es pot modificar la posició modificant els dos primers índex de la variable $newsletter)
if (isset($_POST['novaCaixa'])) {
    // ens assegurem que l'usuari hagi seleccionat com a mínim una entrada per a la caixa
    if (count($_POST['nousItemsCaixa']) > 0) {

        $idColumna = $_POST['columna'];
        $ordreCaixa = count($content[$idColumna]['caixes']);

        $nomCaixa = !empty($_POST['nomCaixa']) ? $_POST['nomCaixa'] : 'box'.$_POST['tipusCaixa'].$ordreCaixa;
        $idCaixa = sanitize_title($nomCaixa);
        $content[$idColumna]['caixes'][$idCaixa]['tipusCaixa'] = $tipusCaixa;
        $content[$idColumna]['caixes'][$idCaixa]['nomCaixa'] = $nomCaixa;
        $content[$idColumna]['caixes'][$idCaixa]['modeCaixa'] = 0; //Per defecte mode Files
        $content[$idColumna]['caixes'][$idCaixa]['estilCaixa'] = 0; //Per defecte estil normal
        $content[$idColumna]['caixes'][$idCaixa]['ordreCaixa'] = $ordreCaixa; //Posició de la caixa
        $content[$idColumna]['caixes'][$idCaixa]['idEditora'] = $origen;

        // NOTA: Per permetre seleccionar la columna on s'afegirà la nova caixa, només cal afegir un <select> al formulari del fitxer afegir-caixa.php amb name="columna" i els valors de les possibles columnes on pot anar la caixa.

        // afegim els nous ítems seleccionats (amb estils per defecte)
        $i = 0;
        foreach ($_POST['nousItemsCaixa'] as $nouItemID) {
            $newsletter[0][$_POST['columna']][$nomCaixa][$tipusCaixa][][0][0][0] = $nouItemID;
            $content[$idColumna]['caixes'][$idCaixa]['items'][$nouItemID]['id'] = $nouItemID;
            $content[$idColumna]['caixes'][$idCaixa]['items'][$nouItemID]['estil'] = 0; //Estil per defecte Normal (1 destacat)
            $content[$idColumna]['caixes'][$idCaixa]['items'][$nouItemID]['ordre'] = $i; //Posició de la notícia
            $i++;
            // fer insert de les noticies/banners pel control de clics
            if ($tipusCaixa == 'noticies') {
                $result_insert = db_query("INSERT INTO " . TAULA_NLTONOTICIES . " (ID_NNL, ID_NL) VALUES($nouItemID, $ID)");
            }
            elseif ($tipusCaixa == 'galeries') {
                $result_insert = db_query("INSERT INTO " . TAULA_NLTOBANNERS . " (ID_BAN, ID_NL) VALUES($nouItemID, $ID)");
            }
        }

        // fer update
        ksort($content);
        $CONTINGUT_newsletter = serialize($newsletter);
        $result_update = db_query("update " . TAULA_NEWSLETTERS . " set CONTENT='" . serialize($content) . "', CONTINGUT='".$CONTINGUT_newsletter."' where IdCam=".$idCam);
    }
    // si s'estan afegint/eliminant noves entrades a una caixa, les posem a continuació de les que ja hi ha
} elseif ( count($_POST['nousItemsCaixa']) > 0 && isset($_POST['columna']) && isset($_POST['nomCaixa']) and !empty($tipusCaixa)) {
    $idColumna = $_POST['columna'];
    $idCaixa = sanitize_title($_POST['nomCaixa']);
    // afegim els nous ítems seleccionats (amb estils de caixa i llistat indicats)
    foreach ($_POST['nousItemsCaixa'] as $nouItemID) {

        $i = count( $content[$idColumna]['caixes'][$idCaixa]['items']);

        $content[$idColumna]['caixes'][$idCaixa]['items'][$nouItemID]['id'] = $nouItemID;
        $content[$idColumna]['caixes'][$idCaixa]['items'][$nouItemID]['estil'] = 0; //Estil per defecte Normal (1 destacat)
        $content[$idColumna]['caixes'][$idCaixa]['items'][$nouItemID]['ordre'] = $i;

        // fer insert de les noticies/banners pel control de clics
        if ($tipusCaixa == 'noticies') {
            $result_insert = db_query("INSERT INTO " . TAULA_NLTONOTICIES . " (ID_NNL, ID_NL) VALUES($nouItemID, $ID)");
        }
        elseif ($tipusCaixa == 'galeries') {
            $result_insert = db_query("INSERT INTO " . TAULA_NLTOBANNERS . " (ID_BAN, ID_NL) VALUES($nouItemID, $ID)");
        }
    }

    // fer update
    ksort($content);
    $CONTINGUT_newsletter = serialize($newsletter);
    $result_update = db_query("update " . TAULA_NEWSLETTERS . " set CONTENT='" . serialize($content) . "', CONTINGUT='".$CONTINGUT_newsletter."' where IdCam=".$idCam);
} elseif (isset($_POST['autoUpdate'])) {
    // fer update
    $CONTINGUT_newsletter = serialize($newsletter);
    $result_update = db_query("update " . TAULA_NEWSLETTERS . " set CONTENT='" . serialize($content) . "', CONTINGUT='".$CONTINGUT_newsletter."' where IdCam=".$id_campanya);

}

/* A la configuració del model definim quants apartats hi ha i en funció d'això montem els blocs a houdini */
$numero_apartats = $MODELS[$SKIN]['num_apartats'];
for($i=0; $i<$numero_apartats; $i++){
    $estil_capsa = isset($MODELS[$SKIN]['configuracio_apartats'][$i]) && $MODELS[$SKIN]['configuracio_apartats'][$i] != '' ? 'column_' . $MODELS[$SKIN]['configuracio_apartats'][$i] : '';
    $dades['BLOC' . $i] =
	                   '<div id="columna' . $i . '" class="boxes ' . $estil_capsa . ' clearfix">
	                        <span>Caixa ' . intval($i+1) . ' per a: ' . $MODELS[$SKIN]['continguts_apartats'][$i] . '</span>   
                            <ul class="boxes bigboxes connected-box">
                                ' . getDadesBloc($newsletter, $ID, $id_campanya, $SKIN, $i) . '
                            </ul>
                        </div>';
    $dades['BLOCS'] .= $dades['BLOC' . $i];
}

//CAP HOUDINI
setCurrent('butlletins');
setJsVars();
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
// OUTPUT ALL
echo $Tpl->mergeBlock('ALL',$dades);
//PEU HOUDINI
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');

?>