<?php
include_once '../../selconfig.php';
include 'config.php';

accessCheckLevel(2, $CONFIG_PRE_NOMCARPETA.'/admin/');
function accessCheckLevel($level,$url){
    global $level_user;

    $level_user = $_SESSION['access']['level'];

    if($level_user >= $level){
        return true;
    }else{
        header("Location: $url");
        exit;
    }
}

// --------------------
// PARAMETERS DEFAULT
// --------------------
$CONFIRM = $_POST['CONFIRM'];

if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
if (empty($CLASS))      { $CLASS=$DEFAULT_CLASS; }

if (empty($CONFIRM)) { htmlNewsletterError(_t("error1")); exit; }

// ------------------
// CARDS INSTANTATION
// ------------------

$dbCards = new dbCards($CARDS_TABLE);
if (!$dbCards->Ok) { htmlNewsletterError(_t("error2")); exit; }

// ----------------
// CARDS DELETION
// ----------------

if ($CONFIRM!='TRUE'){
    htmlNewsletterError(_t("activarconfirmacio")); exit;
}else{

    // fem un loop per les variables POST per detectar les CHECK_?
    while ( list($key, $value)=each($_POST) )
    {
        if (strpos($key,'CHECK_')===false){
            // no fem res
        }else{
            // esborrem el thread N del forum F
            $n=substr($key,6,4);

            //busco les imatges i arxius per eliminar-los
            $result = mysql_query("SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE ID='$n'");
            $row = mysql_fetch_array($result);

            $img = $row['IMATGE'];
            $imgname = $CONFIG_PATHUPLOADBANNER.$img;
            //echo $imgname;
            if ((file_exists($imgname)) AND ($img != "")) {
                unlink($imgname);
            }

            mysql_close();
            //fi eliminar imatges i arxius associats

            //elimino la noticia
            $dbCards->deleteCard($n);
            //echo t("bannereliminat")."<br>";
        }
    } // end while

} // end else
header('Location:list.php');
exit;
?>