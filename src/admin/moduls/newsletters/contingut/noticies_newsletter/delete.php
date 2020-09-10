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

if (empty($CONFIRM)) { htmlNewsletterError(_t("error1")); exit; }

// ------------------
// CARDS INSTANTATION
// ------------------

$dbCards = new dbCards($CARDS_TABLE);
if (!$dbCards->Ok) { htmlNewsletterError(_t("error2")); exit;}

// ----------------
// CARDS DELETION
// ----------------
if ($CONFIRM!='TRUE'){

    header('Location:list.php');
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
            $result = mysql_query("SELECT * FROM " . TAULA_NOTICIESNEWSLETTER . " WHERE ID='$n'");
            $row = mysql_fetch_array($result);

            $img1 = $row['IMATGE1'];
            $imgname1 = $CONFIG_PATHUPLOADIM.$img1;
            $pimgname1 = $CONFIG_PATHUPLOADIM."p".$img1;
            //echo $imgname1."<br/>";
            if ((file_exists($imgname1)) AND ($img1 != "")) {
                unlink($imgname1);
                unlink($pimgname1);
            }
            /*
             $img2 = $row['IMATGE2'];
             $imgname2 = $CONFIG_PATHUPLOADIM."$img2";
             $pimgname2 = $CONFIG_PATHUPLOADIM."p$img2";
             if ((file_exists($imgname2)) AND ($img2 != "")) {
             unlink($imgname2);
             unlink($pimgname2);
             }

             $img3 = $row['IMATGE3'];
             $imgname3 = $CONFIG_PATHUPLOADIM."$img3";
             $pimgname3 = $CONFIG_PATHUPLOADIM."p$img3";
             if ((file_exists($imgname3)) AND ($img3 != "")) {
             unlink($imgname3);
             unlink($pimgname3);
             }
             */
            $adjunt1 = $row['ADJUNT1'];
            $filename1 = $CONFIG_PATHUPLOADAD."$adjunt1";
            //echo $filename1."<br/>";
            if ((file_exists($filename1)) AND ($adjunt1 != "")) {
                unlink($filename1);
            }

            $adjunt2 = $row['ADJUNT2'];
            $filename2 = $CONFIG_PATHUPLOADAD."$adjunt2";
            if ((file_exists($filename2)) AND ($adjunt2 != "")) {
                unlink($filename2);
            }

            $adjunt3 = $row['ADJUNT3'];
            $filename3 = $CONFIG_PATHUPLOADAD."$adjunt3";
            if ((file_exists($filename3)) AND ($adjunt3 != "")) {
                unlink($filename3);
            }

            $adjunt4 = $row['ADJUNT4'];
            $filename4 = $CONFIG_PATHUPLOADAD."$adjunt4";
            if ((file_exists($filename4)) AND ($adjunt4 != "")) {
                unlink($filename4);
            }

            $adjunt5 = $row['ADJUNT5'];
            $filename5 = $CONFIG_PATHUPLOADAD."$adjunt5";
            if ((file_exists($filename5)) AND ($adjunt5 != "")) {
                unlink($filename5);
            }

            mysql_close();
            //fi eliminar imatges i arxius associats

            //elimino la noticia
            $dbCards->deleteCard($n);
        }
    } // end while

} // end else

header('Location:list.php');
exit;
?>
