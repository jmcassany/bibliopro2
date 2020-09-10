<?php
include_once '../../selconfig.php';
include_once 'config.php';

if(!class_exists('Thumbnail')){
    include_once $CONFIG_PATHBASE . $CONFIG_NOMCARPETA . '/media/php/class.Thumbnail.inc';
}

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
$ID=$_POST['ID'];
$TITOL=addslashes($_POST['TITOL']);
$SUBTITOL=addslashes($_POST['SUBTITOL']);
$LLOC=addslashes($_POST['LLOC']);
$DATA_LLOC=addslashes($_POST['DATA_LLOC']);
$RESUM=addslashes($_POST['RESUM']);
$DESCRIPCIO=addslashes($_POST['DESCRIPCIO']);
$NOM=addslashes($_POST['NOM']);
$CARREC=addslashes($_POST['CARREC']);
$NOMAD1=addslashes($_POST['NOMAD1']);
$NOMAD2=addslashes($_POST['NOMAD2']);
$NOMAD3=addslashes($_POST['NOMAD3']);
$NOMAD4=addslashes($_POST['NOMAD4']);
$PIXELS_IMG=$_POST['IMATGE2'];
//$MODEL=$_POST['MODEL'];
$IMATGE3=addslashes($_POST['IMATGE3']);
$NOMAD5=addslashes($_POST['NOMAD5']);
$NOM_LINK=addslashes($_POST['NOM_LINK']);
$STATUS = $_POST['STATUS'];

$sql = "UPDATE " . TAULA_NOTICIESNEWSLETTER . " set STATUS='$STATUS',CATEGORY1='$CATEGORY1',CATEGORY2='$CATEGORY2',TITOL='$TITOL',RESUM='$RESUM',DESCRIPCIO='$DESCRIPCIO',NOMAD1='$NOMAD1',NOMAD2='$NOMAD2',NOMAD3='$NOMAD3',NOMAD4='$NOMAD4',NOMAD5='$NOMAD5',MESINFO='$MESINFO',LINK1='$LINK1',LINK2='$LINK2',NOM='$NOM',CARREC='$CARREC',LLOC='$LLOC',DATA_LLOC='$DATA_LLOC',SUBTITOL='$SUBTITOL',USUARI_HOUDINI='$USUARI_HOUDINI',IMATGE2='$PIXELS_IMG',IMATGE3='$IMATGE3',NOM_LINK='$NOM_LINK' where ID='$ID'";
$result = db_query($sql);

if($result) {

    ///////Pujar arxius al servidor

    $abpath = $CONFIG_PATHUPLOADAD_NL; //ruta absoluta on es puja l'arxiu
    $sizelim = "yes"; //Limit de tamany si/no
    $size = "9000000"; //tamant limit
    $campbbdd = "ADJUNT";
    $number_of_uploads = 5;  //Nombre d'uploads
    $imatgeinicial = 1;

    //tipus d'arxius
    $cert1 = "application/pdf";
    $cert2 = "application/x-mspowerpoint";
    $cert3 = "application/msword";
    $cert4 = "application/x-zip-compressed";
    $cert5 = "application/x-msexcel";
    $cert6 = "application/excel";
    $cert7 = "application/x-excel";
    $cert8 = "application/vnd.ms-excel";
    $cert9 = "application/mspowerpoint";
    $cert10 = "application/powerpoint";
    $cert11 = "application/vnd.ms-powerpoint";

    $log20 = "";
    $log21 = "";
    $log22 = "";
    $log23 = "";
    $log24 = "";


    for ($i=0; $i<$number_of_uploads; $i++) {

        $extensio = explode (".", $_FILES['file'.$i]['name']);

        //mirem si existeix
        if($_FILES['file'.$i]['name'] == '') {

            switch($i){
                case '0': $log20 .= "1";break;
                case '1': $log21 .= "1";break;
                case '2': $log22 .= "1";break;
                case '3': $log23 .= "1";break;
                case '4': $log24 .= "1";break;
            }
            $imatgeinicial++;
        }

        if ($_FILES['file'.$i]['name'] != "") {

            //mirem tamany de l'arxiu
            if (($sizelim == "yes") && ($_FILES['file'.$i]['size'] > $size)) {

                switch($i){
                    case '0': $log20 .= "2";break;
                    case '1': $log21 .= "2";break;
                    case '2': $log22 .= "2";break;
                    case '3': $log23 .= "2";break;
                    case '4': $log24 .= "2";break;
                }
                $imatgeinicial++;

            } else {

                //mirem si es un arxiu valid
                //if (($file_type[$i] == $cert1) or ($file_type[$i] == $cert2) or ($file_type[$i] == $cert3) or ($file_type[$i] == $cert4) or ($file_type[$i] == $cert5) or ($file_type[$i] == $cert6) or ($file_type[$i] == $cert7) or ($file_type[$i] == $cert8) or ($file_type[$i] == $cert9) or ($file_type[$i] == $cert10) or ($file_type[$i] == $cert11)) {

                if($NOMADJUNTEXIS==""){

                    $rand1 = (microtime()*1234567);//fer un random per generar codi aleatori
                    $md1 = md5($rand1);
                    $posanom = $extensio[0]."_$md1$ID.$extensio[1]";

                }else{

                    $posanom = $NOMADJUNTEXIS;
                }

                //@copy($file[$i], "$abpath/$posanom");// or $log2[$i] .= "3";
                move_uploaded_file($_FILES['file'.$i]['tmp_name'], $abpath.'/'.$posanom);
                if (file_exists("$abpath/$posanom")) {

                    $filex ="$abpath/$posanom";
                    chmod ($filex, 0666);

                    $sql = "UPDATE newsletter_noticies SET ADJUNT$imatgeinicial='$posanom'  where ID='$ID'";
                    $result = mysql_query($sql);

                    switch($i){
                        case '0': $log20 .= "4";break;
                        case '1': $log21 .= "4";break;
                        case '2': $log22 .= "4";break;
                        case '3': $log23 .= "4";break;
                        case '4': $log24 .= "4";break;
                    }
                    $imatgeinicial++;

                }else{

                    switch($i){
                        case '0': $log20 .= "3";break;
                        case '1': $log21 .= "3";break;
                        case '2': $log22 .= "3";break;
                        case '3': $log23 .= "3";break;
                        case '4': $log24 .= "3";break;
                    }

                }

                /*} else {

                switch($i){
                case '0': $log20 .= "5";break;
                case '1': $log21 .= "5";break;
                case '2': $log22 .= "5";break;
                case '3': $log23 .= "5";break;
                case '4': $log24 .= "5";break;
                }
                $imatgeinicial++;
                }*/
            }
        }
    }
    
    ///////////////////////Pujar imatge al servidor

    $abpath = $CONFIG_PATHUPLOADIM_NL; //ruta absoluta on es puja la imatge
    $sizelim = "yes"; //limita tamany si/no
    $size = "500000"; //tamany imatge
    $campbbdd = "IMATGE";
    $number_of_uploads = 1;  //Nombre d'uploads
    $imatgeinicial = 1;

    //all image types to upload
    $cert1 = "image/png"; //Png type
    $cert2 = "image/jpeg"; //Jpeg type 2
    $cert3 = "image/gif"; //Gif type
    $cert4 = "image/pjpeg"; //Jpeg tipo 1

    $log10 = "";
    $log11 = "";
    $log12 = "";

    for ($i=0; $i<1; $i++) {

        $img = $_FILES['img'];
        $extensio = explode (".", $img['name'][0]);
        //checks if file exists
        if ($img['name'][0] == "") {

            switch($i){
                case '0': $log10 .= "1";break;
                case '1': $log11 .= "1";break;
                case '2': $log12 .= "1";break;
            }
            $imatgeinicial++;
        }

        if ($img['name'][0] != "") {

            //mira pes de la imatge

            if (($sizelim == "yes") && ($img['size'][0] > $size)) {

                switch($i){
                    case '0': $log10 .= "2";break;
                    case '1': $log11 .= "2";break;
                    case '2': $log12 .= "2";break;
                }
                $imatgeinicial++;

            } else {

                //mirem si es imatge
                if (($img['type'][0] == $cert1) or ($img['type'][0] == $cert2) or ($img['type'][0] == $cert3)  or ($img['type'][0] == $cert4)) {

                    if($NOMIMATGEEXIS==""){

                        $rand1 = (microtime()*1234567);//fer un random per generar codi aleatori
                        $md1 = md5($rand1);
                        $posanom = $campbbdd."_$md1$ID.$extensio[1]";
                        $posanom = str_replace("$", "_", $posanom);

                    }else{

                        $posanom = $NOMIMATGEEXIS;
                        $posanom = str_replace("$", "_", $posanom);
                    }

                    @copy($img['tmp_name'][0], "$abpath/$posanom"); //or $log = "3";

                    
                    if (file_exists("$abpath/$posanom")) {

                        $filex = "$abpath/$posanom";
                        chmod ($filex, 0666);

                        $sql = "UPDATE " . TAULA_NOTICIESNEWSLETTER . " SET IMATGE$imatgeinicial='$posanom'  where ID='$ID'";
                        $result = db_query($sql);

                        //copio l'imatge amb tamany petit
                        $ruta = $abpath."/".$posanom;
                        $ruta2 = $abpath."/p".$posanom;
                        $mides=getimagesize($ruta);
                        if ($mides['0'] > $PIXELS_IMG) {
                            $tn_image = new Thumbnail($ruta, $PIXELS_IMG, 0, 0);
                            $tn_image->save($ruta2);
                            if ($tn_image->error) {
                                echo "error!";
                            }
                        }

                        //copio l'imatge amb tamany destacat
                        $ruta = $abpath."/".$posanom;
                        $ruta2 = $abpath."/d".$posanom;
                        $mides=getimagesize($ruta);
                        if ($mides['0'] > 400) {
                            $tn_image = new Thumbnail($ruta, 400, 0, 0);
                            $tn_image->save($ruta2);
                            if ($tn_image->error) {
                                echo "error img destacada!";
                            }
                        }

                        switch($i){
                            case '0': $log10 .= "4";break;
                            case '1': $log11 .= "4";break;
                            case '2': $log12 .= "4";break;
                        }
                        $imatgeinicial++;

                    }else{

                        switch($i){
                            case '0': $log10 .= "3";break;
                            case '1': $log11 .= "3";break;
                            case '2': $log12 .= "3";break;
                        }
                    }

                } else {

                    switch($i){
                        case '0': $log10 .= "5";break;
                        case '1': $log11 .= "5";break;
                        case '2': $log12 .= "5";break;
                    }
                    $imatgeinicial++;
                }
            }
        }
    }

    mysql_close();
    header("Location: list.php");

}else{
    htmlNewsletterError(mysql_error());
}

?>
