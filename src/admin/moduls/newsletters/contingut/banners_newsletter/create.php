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

$avui = date('Y-m-d H:i:s', time());

$any = date('Y');
$mes = date('m');
$dia = date('d');
$anymes = $any + 1;

$start = $any."-".$mes."-".$dia." 00:00:00";
$end = $anymes."-".$mes."-".$dia." 00:00:00";

$TITOL = addslashes($_POST['TITOL']);
$LINK = addslashes($_POST['LINK']);
$USUARI_HOUDINI = addslashes($_POST['USUARI_HOUDINI']);
$STATUS = $_POST['STATUS'];

$sql = "insert into " . TAULA_BANNERS . " (CLASS,SKIN,CATEGORY1,CATEGORY2,STATUS,VISIBILITY,CREATION,START,END,TITOL,LINK,USUARI_HOUDINI) values ('1','0','$CATEGORY1','$CATEGORY2','$STATUS','1','$avui','$start','$end','$TITOL','$LINK','$USUARI_HOUDINI')";
$result = db_query($sql);

if($result) {

    $result = mysql_query("SELECT ID FROM " . TAULA_BANNERS . " ORDER BY ID DESC LIMIT 1");
    $row = mysql_fetch_array($result);
    $ID = $row['ID'];

    if($result) {

        if(isset($_FILES['img']) && $_FILES['img']['name'][0] != ''){
            ///////////////////////Pujar imatge al servidor
            $abpath = $CONFIG_PATHUPLOADBANNER; //ruta absoluta on es puja la imatge
            $sizelim = "yes"; //limita tamany si/no
            $size = "500000"; //tamany imatge
            $campbbdd = "IMATGE";

            //all image types to upload
            $allowed = array('image/png','image/jpeg','image/gif','image/pjpeg');
            $log = "";
            $extensio = explode (".", $img_name[0]);
            $img = $_FILES['img'];

            //checks if file exists
            if ($img['name'][0] == "") {

                $log .= "1";
            }

            if ($img['name'][0] != "") {

                //mira pes de la imatge
                if (($sizelim == "yes") && ($img['size'][0] > $size)) {

                    $log .= "2";

                } else {


                    //mirem si es imatge
                    if (in_array($img['type'][0],$allowed)) {

                        if($NOMIMATGEEXIS==""){

                            /*$rand1 = (microtime()*1234567);//fer un random per generar codi aleatori
                             $md1 = md5($rand1);
                             $posanom = $campbbdd."_$md1$ID.$extensio[1]";
                             $posanom = str_replace("$", "_", $posanom);*/
                            $posanom = 'banner_'.$ID.'.'.$extensio[1];

                        }else{

                            $posanom = $NOMIMATGEEXIS;
                            $posanom = str_replace("$", "_", $posanom);
                            $posanom .= $extensio[1];
                        }

                        copy($img['tmp_name'][0], $abpath . $posanom); //or $log = "3";

                        if (file_exists($abpath . $posanom)) {

                            $filex = $abpath . $posanom;
                            @chmod ($filex, 0666);

                            $sql = "UPDATE " . TAULA_BANNERS . "  SET IMATGE='$posanom'  where ID='$ID'";
                            $result = db_query($sql);

                            $log .= "4";

                        }else{

                            $log .= "3";
                        }

                    } else {

                        $log .= "5";
                    }
                }
            }

            if($log != '' && $log != 4){
                htmlNewsletterError('Error en l\'upload d\'imatges:' . $log);
                exit;
            }
        }
        mysql_close();
        header("Location: list.php");

    } else {
        htmlNewsletterError(mysql_errno());
    }

}else{

    htmlNewsletterError(mysql_errno());
}

?>
