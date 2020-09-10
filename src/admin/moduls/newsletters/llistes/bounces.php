<?php
include_once '../selconfig.php';

$result_bounce = $db->sql_query("SELECT * FROM newsletter_bounces");
$row_bounce = $db->sql_fetchrow($result_bounce);
$bounce_mailbox_host = $row_bounce['host'];
$bounce_mailbox_user = $row_bounce['user'];
$bounce_mailbox_password = $row_bounce['pass'];

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('bounces_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada")); exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));

$result5 = $db->sql_query("SELECT * FROM newsletter_llistes WHERE IdLli = '$ID'");
if ($db->sql_numrows($result5) == 0) {
    htmlNewsletterError('Llista no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);
$bl['ID'] = $row5['IdLli'];
$bl['NOM'] = filtreQuote($row5['titol']);

$download_report = processPop ($bounce_mailbox_host,$bounce_mailbox_user,$bounce_mailbox_password);
if(!$download_report){
    htmlNewsletterError('La configuració dels rebots no es correcta');
    exit;
}
if (!empty($download_report))
{
    foreach ($download_report as $key => $value)
    {
        $key++;

        $wh_filtre = " WHERE IdLli='$ID' AND email = '$value'";
        $result4 = $db->sql_query("SELECT * FROM newsletter_subscriptors ".$wh_filtre);
        if ($db->sql_numrows($result4) == 0) $existeix = '';
        else {
            $existeix = 'OK';

            //augmento el bounce
            $row4 = $db->sql_fetchrow($result4);
            $row4['bounces']++;

            //marco a l'usuari de la llista
            $wh_filtre = " WHERE IdLli='$ID' AND email = '$value'";
            $result3 = $db->sql_query("UPDATE newsletter_subscriptors SET bounces=".$row4['bounces']."".$wh_filtre);
            $row3 = $db->sql_fetchrow($result3);
        }

        $bl['EMAILS'] .= '<tr>
                    <td><a href="mailto:'.$value.'">'.$value.'</a></td>
                    <td>'.$existeix.'</td>
                    </tr>';
    }
}

$bl['LLISTAT'] = $Tpl_modul->mergeBlock('LLISTAT', $bl);

setCurrent('subscriptors');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');

function processBounce ($link, $num, $header)
{
    global $db, $LOGIN, $ID;

    $body = imap_body ($link, $num);

    $user = 0;
    $msgid = 0;

    preg_match ("/X-MessageId: (.*)/i",$body,$match);
    if (is_array($match) && isset($match[1])) {
        $msgid = trim($match[1]);
    }
    if (!$msgid) {
        # older versions use X-Message
        preg_match ("/X-Message: (.*)/i",$body,$match);
        if (is_array($match) && isset($match[1])) {
            $msgid = trim($match[1]);
        }
    }

    if ($msgid != 0)
    {
        preg_match ("/To: (.*)/i", $body, $match);
        if (is_array($match) && isset($match[1])) {
            $user_tmp = trim($match[1]);
        }

        if ($msgid == $ID) {
            $wh_filtre = " WHERE IdLli='$ID' AND email = '$user_tmp'";
            $result2 = $db->sql_query("SELECT * FROM newsletter_subscriptors ".$wh_filtre);
            if ($db->sql_numrows($result2) != 0) $user = $user_tmp;
        }
    }

    return $user;
}

function processMessages($link, $max = 3000)
{
    $num = imap_num_msg($link);

    //$report = $num . " bounces";
    $report = array();

    if ($num > $max) {
        //$report .= $num . " bounces-max";
        $num = $max;
    }

    $nberror = 0;

    for($x=1; $x <= $num; $x++) {

        set_time_limit(60);

        $header = imap_fetchheader($link, $x);

        flush();

        $report[$x] = processBounce($link, $x, $header);

        if ($report[$x] != '') {
            imap_delete($link, $x);
        }

        flush();
    }

    flush();

    set_time_limit(60 * $num);

    imap_expunge($link);

    imap_close($link);

    if ($num)
    return $report;
}

function processPop ($server,$user,$password)
{
    
    //TODO: Carregar informació de la connexió de la configuració
    return false;
    $port = '110/pop3/notls';

    set_time_limit(6000);

    $link = imap_open("{".$server.":".$port."}INBOX",$user,$password);

    if (!$link) {
        echo imap_last_error();
        return;
    }
    
    

    return processMessages($link, 100000);
}

 
?>
