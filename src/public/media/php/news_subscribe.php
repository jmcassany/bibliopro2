<?php
//****
//**** Formulari per apuntar-se a una llista
//****

$CONFIG_PATHBASE = $_SERVER['DOCUMENT_ROOT'];
require_once($CONFIG_PATHBASE . '/public/config.php');
require_once("class.phpmailer.php");

$DEBUG_NOMAILS = 0;

$CONFIG_URLBASE = 'http://'.$_SERVER['SERVER_NAME'].$CONFIG_NOMCARPETA;

if(isset($_POST['IdLlista'])){
    $idLli = $_POST['IdLlista'];
    $idioma = $_POST['idioma'];
} else {
    $idCam = $_POST['idCam'];
    $queryButlleti = db_query('SELECT * FROM ' . TAULA_NEWSLETTERS . ' WHERE IdCam = ' . $idCam);
    $dadesButlleti = db_fetch_array($queryButlleti);
    $queryCampanya = db_query('SELECT * FROM ' . TAULA_CAMPANYES . ' WHERE IdCam = ' . $idCam);
    $dadesCampanya = db_fetch_array($queryCampanya);
    $idLli = isset($MODELS[$dadesButlleti['SKIN']]['llistaSubscriptorsNovesAltes']) ? $MODELS[$dadesButlleti['SKIN']]['llistaSubscriptorsNovesAltes'] : null;
    $idioma = $MODELS[$dadesButlleti['SKIN']]['idioma'];
}
$email = isset($_POST['email']) ? $_POST['email'] : null;
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$cognoms = isset($_POST['cognoms']) ? $_POST['cognoms'] : '';

$prefix = '';
if($idioma != 'ca'){
    $prefix = $idioma . '_';
}
include_once $CONFIG_PATHMEDIA . '/lang/lang_' . $idioma  . '.php';

if($email && $idLli){
    $queryLlista = db_query('SELECT * FROM ' . TAULA_LLISTES . ' WHERE IdLli=' . $idLli);
    if (db_num_rows($queryLlista) == 0) {
        if(isset($idCam)){
            header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=altaerror&error=5&idCam=" . $idCam);
            exit();
        } elseif(isset($idLli)) {
            header("Location:" . $CONFIG_URLSITE_ . "/subscripcio-butlleti/" . $prefix . "no-subscripcio.html");
            exit();
        } else {
            header("Location:" . $CONFIG_URLSITE_ . "/404.html");
            exit();
        }
    }

    $dadesLlista = db_fetch_array($queryLlista);

    if ($email == '') {
        mostrar_formulari($rowLli, $nl);

    } else {
        if (!preg_match($CFG_CAMPANYES['EMAIL_VALID'], $email)) {
            if(isset($idCam)){
                header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=altaerror&&error=3&idCam=" . $idCam);
                exit();
            } elseif(isset($idLli)) {
                header("Location:" . $CONFIG_URLSITE_ . "/subscripcio-butlleti/" . $prefix . "no-subscripcio.html");
                exit();
            } else {
                header("Location:" . $CONFIG_URLSITE_ . "/404.html");
                exit();
            }
        }

        $resultSubscriptors = db_query('SELECT IdSub FROM ' . TAULA_SUBSCRIPTORS . ' WHERE email="' . $email . '" AND IdLli=' . $idLli);
        if (db_num_rows($resultSubscriptors) > 0) {
            //$row9 = $db->sql_fetchrow($result9);
            $camps = array();
            $camps['estat'] = ($dadesLlista['tipus'] == 2) ? 4 : 1;  //1:actiu  4:pendent confirmació
            $camps['dh_baixa'] = NULL;  //per si de cas s'havia donat de baixa prèviament
            $es_ok = db_query('UPDATE ' . TAULA_SUBSCRIPTORS . ' SET estat = ' . $camps['estat'] . ', tipus = 3, dh_baixa = null, nom = "' . $nom . '", cognoms = "' . $cognoms . '" WHERE email = "' . $email . '" AND IdLli = ' . $idLli);

            if(isset($idCam)){
                header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=altaerror&&error=6&idCam=" . $idCam);
                exit();
            } elseif(isset($idLli)) {
                header("Location:" . $CONFIG_URLSITE_ . "/subscripcio-butlleti/" . $prefix . "ja-existeix.html");
                exit();
            } else {
                header("Location:" . $CONFIG_URLSITE_ . "/404.html");
                exit();
            }
             
        } else {
            $camps = array();
            $camps['IdSub'] = '';  //autonumèric
            $camps['IdUsu'] = $dadesLlista['IdUsu'];
            $camps['IdLli'] = $idLli;
            $camps['estat'] = ($dadesLlista['tipus']==2) ? 4 : 1;  //1:actiu  4:pendent confirmació
            $camps['dh_alta'] = date("Y-m-d H:i:s");
            $camps['dh_baixa'] = NULL;
            $camps['email'] = $email;
            $camps['nom'] = $nom;
            $camps['cognoms'] = $cognoms;
            $es_ok = db_query('INSERT INTO ' . TAULA_SUBSCRIPTORS . '(IdUsu, IdLli, estat,tipus,dh_alta,dh_baixa,email,nom,cognoms) VALUES ("' . $dadesLlista['IdUsu'] . '","' . $camps['IdLli'] . '","' . $camps['estat'] . '",3,"' . $camps['dh_alta'] . '",null,"' . $email . '","' . $nom . '","' . $cognoms . '")');
            //$es_ok = fer_insert(TAULA_SUBSCRIPTORS, $camps, 0);
        }
        if ($es_ok) {
            $querySubscriptor = db_query('SELECT IdSub FROM ' . TAULA_SUBSCRIPTORS . ' WHERE email = "' . $email . '" AND IdLli = ' . $idLli);
            $dadesSubscriptor = db_fetch_array($querySubscriptor);

            if ($dadesLlista['tipus'] == 2 ) { // Necessita confirmació
                $string = $idLli . $CRIPTO_SEPAR . $dadesSubscriptor['IdSub'] . $CRIPTO_SEPAR . $CRIPTO_CHECK . $CRIPTO_SEPAR . $idioma;
                 
                $criptat = urlencode(base64_encode($string));
                $link_confirma = 'http://'.$_SERVER['SERVER_NAME'].$CONFIG_NOMCARPETA.'/media/php/news_confirm.php?id='.$criptat;


                if ($DEBUG_NOMAILS==1) { // Per proves en local sense mail!!!!:
                    $MISSATGE = '(debug) Confirmació pel correu '.$email.'<br /><br />Link: <a href="'.$link_confirma.'">'.$link_confirma.'</a>';
                } else {
                    $mail = new phpmailer();  //creem un objecte de la clase phpmailer al que anomenem mail
                    $mail->PluginDir = $CFG_CAMPANYES['PATH_MAILER'];  //PluginDir li indicamem a la clase phpmailer on es troba la clase smtp
                    $mail->CharSet = "UTF-8";

                    if ($mail_sendtype == 'smtp') {
                        $mail->Mailer = 'smtp';

                        if ($mail_port != null) {
                            $mail->Port = $mail_port;
                        }

                        if ($mail_host != null) {
                            $mail->Host = $mail_host;
                            if ($mail_SMTPAuth) {
                                $mail->SMTPAuth = true;
                                if ($mail_username != null && $mail_password != null) {
                                    $mail->Username = $mail_username;
                                    $mail->Password = $mail_password;
                                }
                            }
                        } else {
                            $mail->Mailer = 'mail';
                        }
                    }
                    elseif ($mail_sendtype == 'sendmail') {
                        $mail->Mailer = 'sendmail';
                    }
                    else {
                        $mail->Mailer = 'mail';
                    }

                    $mail->Timeout=30;  //el valor per defecte es 10, posem 30 per donar-li una mica més de marge
                    if(isset($dadesCampanya['from_email'])){
                        $mail->From = $dadesCampanya['from_email'];  //Indiquem quina és la nostra adreça de correu i el nom q volem q vegi l'usuari
                        $mail->FromName = $dadesCampanya['from_name'];
                    } else {
                        $mail->From = $default['email'];  //Indiquem quina és la nostra adreça de correu i el nom q volem q vegi l'usuari
                        $mail->FromName = $default['from_name_' . $idioma];
                    }
                    $mail->Subject = $messages['confirmaok'];  //Assignem l'Assumpte del Missatge
                    $mail->AddAddress($email);  //Indiquem l'adreça del destinatari
                    $mail->Body = '<p>' . $messages['confirmalink'] . '<br />'
                    .'<a href="'.$link_confirma.'">'.$link_confirma.'</a></p>';
                    $mail->AltBody = $messages['confirmatit'] . "\n\n" . $link_confirma . "\n\n";
                    $es_ok = $mail->Send();
                    if ($es_ok){
                        if(isset($idCam)){
                            header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=altaok&ok=2&idCam=" . $idCam);
                            exit();
                        } elseif(isset($idLli)) {
                            header("Location:" . $CONFIG_URLSITE_ . "/subscripcio-butlleti/" . $prefix . "confirmacio.html");
                            exit();
                        } else {
                            header("Location:" . $CONFIG_URLSITE_ . "/404.html");
                            exit();
                        }
                    } else {
                        if(isset($idCam)){
                            header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=altaerror&error=4&idCam=" . $idCam);
                            exit();
                        } elseif(isset($idLli)) {
                            header("Location:" . $CONFIG_URLSITE_ . "/subscripcio-butlleti/" . $prefix . "confirmacio.html");
                            exit();
                        } else {
                            header("Location:" . $CONFIG_URLSITE_ . "/404.html");
                            exit();
                        }
                    }
                }

            } else {
                if(isset($idCam)){
                    header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=altaok&idCam=" . $idCam);
                    exit();
                } elseif(isset($idLli)) {
                    header("Location:" . $CONFIG_URLSITE_ . "/subscripcio-butlleti/" . $prefix . "confirmacio.html");
                    exit();
                } else {
                    header("Location:" . $CONFIG_URLSITE_ . "/404.html");
                    exit();
                }

            }
        } else {
            if(isset($idCam)){
                header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=altaerror&error=1&idCam=" . $idCam);
                exit();
            } elseif(isset($idLli)) {
                header("Location:" . $CONFIG_URLSITE_ . "/subscripcio-butlleti/" . $prefix . "no-subscripcio.html");
                exit();
            } else {
                header("Location:" . $CONFIG_URLSITE_ . "/404.html");
                exit();
            }
        }
    }
} else {
    if(isset($idCam)){
        header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=altaerror&&error=1&idCam=" . $idCam);
        exit();
    } elseif(isset($idLli)) {
        header("Location:" . $CONFIG_URLSITE_ . "/subscripcio-butlleti/" . $prefix . "no-subscripcio.html");
        exit();
    } else {
        header("Location:" . $CONFIG_URLSITE_ . "/404.html");
        exit();
    }

}
?>
