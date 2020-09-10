<?php
include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('subscriptor_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(t("plantillanotrobada")); exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$IDSUB = trim(stripslashes(obte_postget('sub')));
$accio = trim(stripslashes(obte_post('accio')));

$result5 = $db->sql_query("SELECT * FROM newsletter_subscriptors WHERE IdLli = '$ID' AND IdSub='$IDSUB'");
if ($db->sql_numrows($result5) == 0) {
    htmlNewsletterError('Subscriptor no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);
$bl['ID'] = $row5['IdLli'];
$bl['IDSUB'] = $row5['IdSub'];

if ($accio == 'desar') {

    $numerr = tractar_formulari();
    if ($numerr == 0) {
        Header('Location: detalls.php?id='.$ID);
        die();
    }
    $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);

    $bl['EMAIL'] = filtreQuote(trim(stripslashes($_POST['EMAIL'])));
    $bl['NOM'] = filtreQuote(trim(stripslashes($_POST['NOM'])));
    $bl['COGNOMS'] = filtreQuote(trim(stripslashes($_POST['COGNOMS'])));
    $bl['CAMP1'] = filtreQuote(trim(stripslashes($_POST['CAMP1'])));
    $bl['CAMP2'] = filtreQuote(trim(stripslashes($_POST['CAMP2'])));
    $bl['CAMP3'] = filtreQuote(trim(stripslashes($_POST['CAMP3'])));
    $bl['CAMP4'] = filtreQuote(trim(stripslashes($_POST['CAMP4'])));
    $bl['CAMP5'] = filtreQuote(trim(stripslashes($_POST['CAMP5'])));
    $bl['LINK1'] = filtreQuote(trim(stripslashes($_POST['LINK1'])));
    $bl['LINK2'] = filtreQuote(trim(stripslashes($_POST['LINK2'])));
    $bl['LINK3'] = filtreQuote(trim(stripslashes($_POST['LINK3'])));
    $bl['ADJUNT1'] = filtreQuote(trim(stripslashes($_POST['ADJUNT1'])));
    $bl['ADJUNT2'] = filtreQuote(trim(stripslashes($_POST['ADJUNT2'])));
    $bl['ADJUNT3'] = filtreQuote(trim(stripslashes($_POST['ADJUNT3'])));
    $bl['PAIS'] = filtreQuote(trim(stripslashes($_POST['PAIS'])));
    $bl['CENTRE'] = filtreQuote(trim(stripslashes($_POST['CENTRE'])));
    $bl['BOUNCES'] = filtreQuote(trim(stripslashes($_POST['BOUNCES'])));

    foreach ($CFG_CAMPANYES['TIPUS_SUBSCRIPTOR'] as $k => $v) {
        $sel = ($_POST['TIPUS']==$k) ? ' selected="selected"' : '';
        $bl['OPTS_TIPUS'] .= '<option value="'.$k.'"'.$sel.'>'.$v.'</option>';
    }
    foreach ($CFG_CAMPANYES['ESTAT_SUBSCRIPTOR'] as $k => $v) {
        $sel = ($_POST['ESTAT']==$k) ? ' selected="selected"' : '';
        $bl['OPTS_ESTAT'] .= '<option value="'.$k.'"'.$sel.'>'.$v.'</option>';
    }

} else {

    $bl['EMAIL'] = filtreQuote($row5['email']);
    $bl['NOM'] = filtreQuote($row5['nom']);
    $bl['COGNOMS'] = filtreQuote($row5['cognoms']);
    $bl['CAMP1'] = filtreQuote($row5['camp1']);
    $bl['CAMP2'] = filtreQuote($row5['camp2']);
    $bl['CAMP3'] = filtreQuote($row5['camp3']);
    $bl['CAMP4'] = filtreQuote($row5['camp4']);
    $bl['CAMP5'] = filtreQuote($row5['camp5']);
    $bl['LINK1'] = filtreQuote($row5['link1']);
    $bl['LINK2'] = filtreQuote($row5['link2']);
    $bl['LINK3'] = filtreQuote($row5['link3']);
    $bl['ADJUNT1'] = filtreQuote($row5['adjunt1']);
    $bl['ADJUNT2'] = filtreQuote($row5['adjunt2']);
    $bl['ADJUNT3'] = filtreQuote($row5['adjunt3']);
    $bl['PAIS'] = filtreQuote($row5['pais']);
    $bl['CENTRE'] = filtreQuote($row5['centre']);
    $bl['BOUNCES'] = filtreQuote($row5['bounces']);

    //preparar adjunts
    for ($i = 1; $i <= 3; $i++) {
        $adjunt=$bl['ADJUNT'.$i];
        if ($bl['ADJUNT'.$i] != ""){
            $bl['ADJUNT'.$i]="<a href=\"$adjunt\" target=\"_blank\" class=\"text10\"><strong>Veure arxiu</strong></a>";
            $bl['ADJUNT'.$i].=" (<a href=\"eliminar_img.php?IDSUB=$IDSUB&file=$adjunt&categoria=1&ID=$ID&camptaula=adjunt$i\">Eliminar</a>)";
        }
    }
    foreach ($CFG_CAMPANYES['TIPUS_SUBSCRIPTOR'] as $k => $v) {
        $sel = ($row5['tipus']==$k) ? ' selected="selected"' : '';
        $bl['OPTS_TIPUS'] .= '<option value="'.$k.'"'.$sel.'>'.$v.'</option>';
    }
    foreach ($CFG_CAMPANYES['ESTAT_SUBSCRIPTOR'] as $k => $v) {
        $sel = ($row5['estat']==$k) ? ' selected="selected"' : '';
        $bl['OPTS_ESTAT'] .= '<option value="'.$k.'"'.$sel.'>'.$v.'</option>';
    }
}

setCurrent('subscriptors');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');

// Valida formulari. Si ok fa update, si nok retorna nºerror
function tractar_formulari() {
    global $db, $CFG_CAMPANYES, $ID,$IDSUB, $LOGIN;
    global $CONFIG_PATHUPLOADAD, $UPLOAD_filesize, $UPLOAD_filetype, $CONFIG_URLUPLOADAD;

    $camps = array();
    //$camps['IdUsu'] = $LOGIN;
    //$camps['dh_modif'] = date("Y-m-d H:i:s");

    $camps['email'] = trim(stripslashes($_POST['EMAIL']));
    if ($camps['email'] == '') return 1;
    if (!preg_match($CFG_CAMPANYES['EMAIL_VALID'],$camps['email'])) return 1;
    //list($username,$domain) = split("@",$camps['email']);
    //if (!getmxrr($domain,$mxrecords)) return 1;

    $result1 = $db->sql_query("SELECT * FROM newsletter_subscriptors WHERE IdLli='$ID' AND IdSub!='$IDSUB' AND email='".$camps['email']."' LIMIT 0,1");
    if ($db->sql_numrows($result1) > 0) return 2;


    $camps['tipus'] = intval($_POST['TIPUS']);
    if (!isset($CFG_CAMPANYES['TIPUS_SUBSCRIPTOR'][$camps['tipus']])) return 3;

    $camps['estat'] = intval($_POST['ESTAT']);
    if (!isset($CFG_CAMPANYES['ESTAT_SUBSCRIPTOR'][$camps['estat']])) return 4;

    $camps['nom'] = trim(stripslashes($_POST['NOM']));
    $camps['cognoms'] = trim(stripslashes($_POST['COGNOMS']));
    $camps['camp1'] = trim(stripslashes($_POST['CAMP1']));
    $camps['camp2'] = trim(stripslashes($_POST['CAMP2']));
    $camps['camp3'] = trim(stripslashes($_POST['CAMP3']));
    $camps['camp4'] = trim(stripslashes($_POST['CAMP4']));
    $camps['camp5'] = trim(stripslashes($_POST['CAMP5']));
    $camps['link1'] = trim(stripslashes($_POST['LINK1']));
    $camps['link2'] = trim(stripslashes($_POST['LINK2']));
    $camps['link3'] = trim(stripslashes($_POST['LINK3']));
    $camps['pais'] = trim(stripslashes($_POST['PAIS']));
    $camps['centre'] = trim(stripslashes($_POST['CENTRE']));

    //pujar adjunts
    $log2 = 0;
    for ($i = 1; $i <=3; $i++) {
        if($_FILES['file'.$i]['name'] != '') {
            $nom_fitxer = normalizeFileAndExtension($_FILES['file'.$i]['name']);
            $extensio = explode (".", $nom_fitxer);
            $destName = $extensio['0'].'_'.$ID.'_'.$IDSUB.'_'.$i.'.'.$extensio['1'];
            $destName = strtr($destName, '$', '_');

            // pugem el fitxer, i si tot va bé esborrem l'arxiu antic i actualitzem la taula
            $log2 = upload('file'.$i, $CONFIG_PATHUPLOADAD, $UPLOAD_filesize, $UPLOAD_filetype, $destName);
            if($log2 == 4) {
                // esborrem arxiu antic
                $old_query = db_query("SELECT adjunt$i FROM newsletter_subscriptors WHERE IdSub='$IDSUB'");
                $old_row = db_fetch_array($old_query);
                if(file_exists($CONFIG_PATHUPLOADAD.'/'.$old_row['adjunt'.$i]) and $old_row['adjunt'.$i]!='') unlink($CONFIG_PATHUPLOADAD.'/'.$old_row['adjunt'.$i]);

                // actualitzem taula
                $nom_fitxer_final = $CONFIG_URLUPLOADAD.$destName;
                db_query("UPDATE newsletter_subscriptors SET adjunt$i='$nom_fitxer_final' WHERE IdSub='$IDSUB'");
            }
        }
    }

    fer_update('newsletter_subscriptors', $camps, "IdLli = '$ID' AND IdSub='$IDSUB'");
    //register_add($T_LANG['adm_llistes'], 'modificat subscriptor id: '.$ID);

    return 0;
}

?>
