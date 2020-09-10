<?php

include_once '../selconfig.php';
$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('importa_csv_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada"));exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];


$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_post('accio')));

if ($accio == 'desar') {
    $numerr = tractar_formulari();
    if ($numerr == 0) {
        $bl['NUM_EMAILS'] = array_sum($compta);
        $bl['NUM_OK'] = intval($compta['ok']);
        $bl['NUM_NOK_DUPLI'] = intval($compta['nok_duplicat']);
        $bl['NUM_NOK_ERROR'] = intval($compta['nok_error']);
        $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('INFO1', $bl);
        $bl['EMAILS'] = '';
    } else {
        $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);
        $bl['EMAILS'] = filtreQuote(trim(stripslashes($_POST['EMAILS'])));
    }
}

$result5 = $db->sql_query("SELECT * FROM newsletter_llistes WHERE IdLli = '$ID'");
if ($db->sql_numrows($result5) == 0) {
    htmlNewsletterError('Llista no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);
$bl['ID'] = $row5['IdLli'];
$bl['NOM'] = filtreQuote($row5['titol']);
$bl['NOTES'] = nl2br($row5['notes']);
$bl['TIPUS'] = $CFG_CAMPANYES['TIPUS_LLISTA'][$row5['tipus']];
$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM newsletter_subscriptors WHERE IdLli = '$ID'") );
$bl['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));

if (isset($_GET['id']) or $numerr != 0) {
    $bl['IMPORTAR'] = '<input type="submit" value="Importar" class="boto continuar" />';
}
else {
    $bl['IMPORTAR'] = '';
}

setCurrent('subscriptors');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');

// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari() {
    global $db, $CFG_CAMPANYES, $ID, $LOGIN, $compta;

    $compta = array();

    if (!isset($_POST['CONFIRMA'])) return 2;

    $tmp_name = $_FILES['EMAILS']['tmp_name'];
    if ( (!$tmp_name)||($tmp_name=='') ) {
        return 1;
    }
    if ($_FILES['EMAILS']['size']==0) return 1;
    if (!$fp = fopen($tmp_name, 'r')) return 1;

    $CAMPS_FITXER = array('EMAIL', 'NOM', 'CAMP1', 'CAMP2', 'CAMP3', 'CAMP4', 'CAMP5', 'LINK1', 'LINK2', 'LINK3', 'PAIS', 'CENTRE', 'COGNOMS');

    //**** Llegir capçalera i comprobar que quadra amb el format esperat
    $aju = trim(fgets($fp));
    $camps = explode(";", $aju);
    if (count($camps) != count($CAMPS_FITXER)) {
        return 3;	//echo "No coincideixen els camps del fitxer amb el format esperat!";
    }

    //fer_delete('newsletter_subscriptors', "IdLli='$ID'");

    $insertar = array();
    $insertar['IdSub'] = '';  //autonumèric
    $insertar['IdUsu'] = $LOGIN;
    $insertar['IdLli'] = $ID;
    $insertar['estat'] = 1;
    $insertar['tipus'] = 2;
    $insertar['dh_alta'] = date("Y-m-d H:i:s");
    $insertar['dh_baixa'] = NULL;

    // INSERTAR registres
    while(!feof($fp)) {
        $aju = trim(fgets($fp));
        if(strlen($aju)>0) {
            $aju = preg_replace('@""@', 'ARAETCANVIAREPERCOMETA', $aju);
            $aju = preg_replace('@"@', '', $aju);
            $aju = preg_replace('@ARAETCANVIAREPERCOMETA@', '"', $aju);
            $valors = explode(";", $aju);

            $insertar['email'] = trim($valors[0]);
            if (preg_match($CFG_CAMPANYES['EMAIL_VALID'],$insertar['email'])) {

                $insertar['nom'] = trim($valors[1]);
                //$insertar['nom'] = utf8_encode($insertar['nom']);
                if ($insertar['nom']=='"') $insertar['nom']='';

                for($i=1;$i<6;$i++){
                    $j=$i+1;
                    $insertar['camp'.$i] = trim($valors[$j]);
                    //$insertar['camp'.$i] = utf8_encode($insertar['camp'.$i]);
                    if ($insertar['camp'.$i]=='"') $insertar['camp'.$i]='';
                }

                for($i=1;$i<4;$i++){
                    $j=5+$i+1;
                    $insertar['link'.$i] = trim($valors[$j]);
                    //$insertar['link'.$i] = utf8_encode($insertar['link'.$i]);
                    if ($insertar['link'.$i]=='"') $insertar['link'.$i]='';
                }

                $insertar['pais'] = trim($valors[10]);
                //$insertar['pais'] = utf8_encode($insertar['pais']);
                if ($insertar['pais']=='"') $insertar['pais']='';

                $insertar['centre'] = trim($valors[11]);
                //$insertar['centre'] = utf8_encode($insertar['centre']);
                if ($insertar['centre']=='"') $insertar['centre']='';

                $insertar['cognoms'] = trim($valors[12]);
                //$insertar['centre'] = utf8_encode($insertar['centre']);
                if ($insertar['cognoms']=='"') $insertar['cognoms']='';

                $result1 = $db->sql_query("SELECT email FROM newsletter_subscriptors WHERE IdLli='$ID' AND email='".$insertar['email']."' LIMIT 0,1");
                if ($db->sql_numrows($result1) > 0) {
                    //$row1 = $db->sql_fetchrow($result1);
                    $compta['nok_duplicat']++;
                } else {
                    if (fer_insert('newsletter_subscriptors', $insertar, 0)) $compta['ok']++;
                    else $compta['nok_error']++;
                }
            }
        }
    }
    fclose($fp);

    return 0;
}

?>