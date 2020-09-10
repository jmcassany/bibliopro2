<?php
include_once '../selconfig.php';
//require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'html2text.inc');
require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'class.html2text.inc');

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_post('accio')));

$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

$result5 = $db->sql_query("SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam = '$IdCam'");
if ($db->sql_numrows($result5) == 0) {
    htmlNewsletterError('Campanya no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);

$Tpl_modul = new awTemplate();
if ($row5['format']==3) $Tpl_modul->scanFile('pas2b_text_ca.tpl');
else $Tpl_modul->scanFile('pas2b_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada")); exit; }

$bl['ID'] = $row5['IdCam'];
$bl['HTML_TEXT'] = ($row5['format']==3) ? 'Text pla' : 'HTML';


$bl['WEBSITE'] = 'http://'.$_SERVER['SERVER_NAME'].$CONFIG_NOMCARPETA;

if ($accio == 'desar') {
    $numerr = tractar_formulari($row5);
    if ($numerr == 0) {
        //header('Location: index.php');
        header('Location: pas2c.php?IdCam='.$IdCam);
        die();
    }else if ($numerr == 1000) {
        //header('Location: index.php');
        header('Location: ../contingut/newsletters/nou.php?IdCam=' . $IdCam);
        die();
    }else if ($numerr == 2000) {
        //header('Location: index.php');
        header('Location: ../contingut/newsletters/edita.php?IdCam=' . $IdCam);
        die();
    }
    $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);

    //$bl['FITXER'] = filtreQuote(trim(stripslashes($_POST['FITXER'])));
    $bl['NOTES'] = filtreQuote(trim(stripslashes($_POST['NOTES'])));
    $bl['TIPUS_1'] = ($_POST['TIPUS']==1) ? 'checked="checked"' : '';
    $bl['TIPUS_2'] = ($_POST['TIPUS']==2) ? 'checked="checked"' : '';
    $bl['TIPUS_3'] = ($_POST['TIPUS']==3) ? 'checked="checked"' : '';
    $bl['TIPUS_4'] = ($_POST['TIPUS']==4) ? 'checked="checked"' : '';
    //$bl['AFEGIR1'] = ($_POST['AFEGIR1']) ? 'checked="checked"' : '';
    //$bl['AFEGIR2'] = ($_POST['AFEGIR2']) ? 'checked="checked"' : '';
    $bl['AFEGIR1'] = ($_POST['AFEGIR1']) ? '' : '';
    $bl['AFEGIR2'] = ($_POST['AFEGIR2']) ? '' : '';

} else {

    //per saber si cal marcant algun
    //$bl['TIPUS_1'] = ($row5['tipus']==1 ) ? 'checked="checked"' : '';
    $bl['TIPUS_2'] = ($row5['tipus']==2 || $row5['tipus']==1) ? 'checked="checked"' : '';
    $bl['TIPUS_3'] = ($row5['tipus']==3 || $row5['tipus']==0) ? 'checked="checked"' : '';
    $bl['TIPUS_4'] = ($row5['tipus']==4 || $row5['tipus']==3) ? 'checked="checked"' : '';

    if($row5['tipus']==1 || $row5['tipus']==2)$bl['MOSTRARALTRESOPCIONS']="<script type=\"text/javascript\">toggleLayer('capaOpcions');</script>";
    //$bl['TIPUS_3'] = 'checked="checked"';

    //$bl['AFEGIR1'] = 'checked="checked"';
    $bl['AFEGIR1'] = '';

    if ($row5['format'] == 3) {
        $bl['NOTES'] = filtreQuote($row5['msg_text']);
    } else {
        $bl['NOTES'] = filtreQuote($row5['msg_html']);
        //$bl['AFEGIR2'] = 'checked="checked"';
        $bl['AFEGIR2'] = '';
    }

}

//per saber si han creat un butlleti amb l'eina

$result6 = db_query("SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam = '$IdCam'");
$row6 = db_fetch_array($result6);
if (db_num_rows($result6) == 0 || ($row6['tipus'] != 3 && $row6['tipus'] != 4)) {
    $bl['TITOLCONFIGURARBUTLLETI']="Crear";
    $bl['DESCRIPCONFIGURARBUTLLETI']="Escolliu aquesta opció per definir la maquetació d’un nou butlletí i començar a afegir contingut.";
    $bl['RADIOCONFIGURARBUTLLETI']="<input type=\"radio\" id=\"butlleti_new\" name=\"TIPUS\" value=\"3\" ".$bl['TIPUS_3']." />";
}else{
    $bl['TITOLCONFIGURARBUTLLETI']="Editar";
    $bl['DESCRIPCONFIGURARBUTLLETI']="Escolliu aquesta opció per editar i modificar un butlletí que ja havíeu creat.";
    $bl['RADIOCONFIGURARBUTLLETI']="<input type=\"radio\" id=\"butlleti_edit\" name=\"TIPUS\" value=\"4\" ".$bl['TIPUS_4']." />";
}
//

setCurrent('butlletins');
include_once ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include_once ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');



// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari($rowCam) {
    global $db, $CFG_CAMPANYES, $IdCam, $LOGIN, $ruta_web, $CONFIG_NOMCARPETA;
    //global $HTTP_POST_FILES;

    $ruta_web = 'http://'.$_SERVER['SERVER_NAME'].$CONFIG_NOMCARPETA;

    $camps = array();
    $TIPUS = intval($_POST['TIPUS']);
    if (($TIPUS!=1)&&($TIPUS!=2)&&($TIPUS!=3)&&($TIPUS!=4)) return 1;

    if ($TIPUS == 1) {  //llegir de fitxer
        //$tmp_name = $HTTP_POST_FILES['FITXER']['tmp_name'];
        $tmp_name = $_FILES['FITXER']['tmp_name'];
        if ((!$tmp_name)||($tmp_name=='')) {
            return 2;
        } else {
            //if ($HTTP_POST_FILES['FITXER']['size']==0) return 2;
            if ($_FILES['FITXER']['size']==0) return 2;
            if (!$fp = fopen($tmp_name, 'r')) return 2;
            $FITXER = fread($fp, filesize($tmp_name));
            fclose($fp);
            $queryCampanya = db_query('SELECT * FROM ' . TAULA_CAMPANYES . ' WHERE IdCam = ' . $IdCam);
            $dadesCampanya = db_fetch_array($queryCampanya);
             
            if(db_num_rows($result) > 0) {
                fer_update(TAULA_NEWSLETTERS, array('CONTENT'=>$FITXER,'CATEGORY1'=>1,'TITOL'=>$dadesCampanya['titol']),'IdCam=' . $IdCam);
            } else {
                fer_insert(TAULA_NEWSLETTERS, array('CONTENT'=>$FITXER,'IdCam' => $IdCam,'CATEGORY1'=>1,'TITOL'=>$dadesCampanya['titol']));
            }

        }

    } elseif ($TIPUS == 2) {
        $FITXER = trim(stripslashes($_POST['NOTES']));
        $queryCampanya = db_query('SELECT * FROM ' . TAULA_CAMPANYES . ' WHERE IdCam = ' . $IdCam);
        $dadesCampanya = db_fetch_array($queryCampanya);
        $result = db_query('SELECT * FROM ' . TAULA_NEWSLETTERS . ' WHERE IdCam = ' . $IdCam);
        if(db_num_rows($result) > 0) {
            fer_update(TAULA_NEWSLETTERS, array('CONTENT'=>$FITXER,'CATEGORY1'=>1,'TITOL'=>$dadesCampanya['titol']),'IdCam=' . $IdCam);
        } else {
            fer_insert(TAULA_NEWSLETTERS, array('CONTENT'=>$FITXER,'IdCam' => $IdCam,'CATEGORY1'=>1,'TITOL'=>$dadesCampanya['titol']));
        }
    } elseif ($TIPUS == 3) {
        fer_update(TAULA_CAMPANYES, array('tipus'=>$TIPUS), "IdCam = '$IdCam'");
        $FITXER = "new";

    } elseif ($TIPUS == 4) {
        fer_update(TAULA_CAMPANYES, array('tipus'=>$TIPUS), "IdCam = '$IdCam'");
        $FITXER = "edit";

    } else {
        return 1;
    }
    //echo $TIPUS;
    //exit;
    $camps['tipus'] = $TIPUS;//afegit

    if ($FITXER == '') return 3;
    elseif ($FITXER == 'new') return 1000;
    elseif ($FITXER == 'edit') return 2000;

    if ($rowCam['estat'] < 21) $camps['estat'] = 21;
    $camps['dh_modif'] = date("Y-m-d H:i:s");

    $AUTOMATIC = array(
		'UNSUB_HTML' => '<br /><br />Aquest correu s\'envia a [[email]]. Si no vol rebre més correus podeu <a href="'.$ruta_web.'/news_unsubscribe.php?id=[[codi]]">donar-vos de baixa de la llista</a>.',
		'UNSUB_TEXT' => "\n\nAquest correu s'envia a [[email]]. Si no vol rebre més correus podeu donar-vos de baixa de la llista fent clic a:\n".$ruta_web."/news_unsubscribe.php?id=[[codi]]",

		'LECTURA_HTML' => '<img src="'.$ruta_web.'/news_imatge.php?id=[[codi]]" alt="lectura" />',
		'LECTURA_TEXT' => '',
    );

    if ($rowCam['format'] == 1) {
        $camps['msg_text'] = '';

        if (($_POST['AFEGIR1'])||($_POST['AFEGIR2'])) {
            $afegit = '';
            if (($_POST['AFEGIR1'])&&(!preg_match('@news_unsubscribe.php@', $FITXER))) $afegit .= $AUTOMATIC['UNSUB_HTML'];
            if (($_POST['AFEGIR2'])&&(!preg_match('@news_imatge.php@', $FITXER))) $afegit .= $AUTOMATIC['LECTURA_HTML'];
            if ($afegit!='') {
                if (!preg_match('@</body>/i@', $FITXER)) $FITXER .= $afegit;
                else $FITXER = preg_replace('@</body>/i@', $afegit.'</body>', $FITXER);  // insertar davant del </body>
            }
        }
        $camps['msg_html'] = $FITXER;

    } elseif ($rowCam['format'] == 2) {
        //$camps['msg_text'] = html2text($FITXER);
        $h2t =& new html2text($FITXER);
        $aux = $h2t->get_text();
        if (($_POST['AFEGIR1'])&&(!preg_match('@news_unsubscribe.php@', $aux))) $aux .= $AUTOMATIC['UNSUB_TEXT'];
        $camps['msg_text'] = $aux;

        if (($_POST['AFEGIR1'])||($_POST['AFEGIR2'])) {
            $afegit = '';
            if (($_POST['AFEGIR1'])&&(!preg_match('@news_unsubscribe.php@', $FITXER))) $afegit .= $AUTOMATIC['UNSUB_HTML'];
            if (($_POST['AFEGIR2'])&&(!preg_match('@news_imatge.php@', $FITXER))) $afegit .= $AUTOMATIC['LECTURA_HTML'];
            if ($afegit!='') {
                if (!preg_match('@</body>@', $FITXER)) $FITXER .= $afegit;
                else $FITXER = preg_replace('@</body>/i@', $afegit.'</body>', $FITXER);  // insertar davant del </body>
            }
        }
        $camps['msg_html'] = $FITXER;

    } elseif ($rowCam['format'] == 3) {
        if (($_POST['AFEGIR1'])&&(!preg_match('@news_unsubscribe.php@', $FITXER))) $FITXER .= $AUTOMATIC['UNSUB_TEXT'];
        $camps['msg_text'] = $FITXER;

        $camps['msg_html'] = '';
    }


    fer_update(TAULA_CAMPANYES, $camps, "IdCam = '$IdCam'");
    //register_add($T_LANG['adm_campanyes'], 'modificat contingut campanya id: '.$ID);

    return 0;
}

?>
