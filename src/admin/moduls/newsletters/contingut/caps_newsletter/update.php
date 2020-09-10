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


$TITOL = $_POST['TITOL'];
$USUARI_HOUDINI = $_POST['USUARI_HOUDINI'];
$ID = $_POST['ID'];
$STATUS = $_POST['STATUS'];

$sql = "update newsletter_headers set STATUS='$STATUS',CATEGORY1='$CATEGORY1',CATEGORY2='$CATEGORY2',TITOL='$TITOL',USUARI_HOUDINI='$USUARI_HOUDINI' where ID='$ID'";
$result = db_query($sql);

if($result) {

    if(isset($_FILES['img']) && $_FILES['img']['name'][0] != ''){

        ///////////////////////Pujar imatge al servidor

        $abpath = $CONFIG_PATHUPLOADCAPS; //ruta absoluta on es puja la imatge
        $sizelim = "yes"; //limita tamany si/no
        $size = "500000"; //tamany imatge
        $campbbdd = "IMATGE";

        //all image types to upload

        $allowed = array('image/png','image/jpeg','image/gif','image/pjpeg');
        $log = "";
        $img = $_FILES['img'];
        $extensio = explode (".", $img['name'][0]);

       
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
                        $posanom = 'capsal_newsletter'.$ID.'.'.$extensio[1];

                    }else{

                        $posanom = $NOMIMATGEEXIS;
                        $posanom = str_replace("$", "_", $posanom);
                        $posanom .= $extensio[1];
                    }

                    copy($img['tmp_name'][0], $abpath . $posanom); //or $log = "3";

                    if (file_exists($abpath . $posanom)) {

                        $filex = $abpath . $posanom;
                        @chmod ($filex, 0666);

                        $sql = "UPDATE " . TAULA_CAPÇALERES . "  SET IMATGE='$posanom'  where ID='$ID'";
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

}else{
    htmlNewsletterError(mysql_errno());
}

?>
