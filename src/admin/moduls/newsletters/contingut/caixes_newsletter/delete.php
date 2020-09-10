<?php
include_once '../../selconfig.php';
include_once 'config.php';

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

$CONFIRM = $_POST['CONFIRM'];
// --------------------
// PARAMETERS DEFAULT
// --------------------

if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
if (empty($CLASS))      { $CLASS=$DEFAULT_CLASS; }

if (empty($CONFIRM)) { htmlNewsletterError('No s\'ha especificat el codi de confirmació'); exit; }

// ------------------
// CARDS INSTANTATION
// ------------------

$dbCards = new dbCards($CARDS_TABLE);
if (!$dbCards->Ok) { htmlNewsletterError('Registre no trobat');  exit; }

// ----------------
// CARDS DELETION
// ----------------

if ($CONFIRM!='TRUE'){

    htmlNewsletterError(_t("activarconfirmacio")); 
    exit;

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
            $result = mysql_query("SELECT * FROM newsletter_caixes WHERE ID='$n'");
            $row = mysql_fetch_array($result);

            $img = $row['IMATGE'];
            $imgname = $CONFIG_PATHBASE."public/media/upload/caixes/$img";
            //echo $imgname;
            if ((file_exists($imgname)) AND ($img != "")) {
                unlink($imgname);
            }

            mysql_close();
            //fi eliminar imatges i arxius associats

            //elimino la noticia
            $dbCards->deleteCard($n);
        }
    } // end while

} // end else

header('Location:list.php');
?>
