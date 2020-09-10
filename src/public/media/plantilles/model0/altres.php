<?php
include_once("config.php");

if(isset($_GET['opcio']) && $_GET['opcio'] != '' && isset($_GET['idCam']) && $_GET['idCam'] != ''){

    $idCam = $_GET['idCam'];
    $opcio = $_GET['opcio'];

    $queryButlleti = db_query('SELECT * FROM newsletter_newsletter WHERE IdCam = ' . $idCam);
    $dadesButlleti = db_fetch_array($queryButlleti);

    $queryCampanya = db_query('SELECT * FROM newsletter_campanyes WHERE IdCam = ' . $idCam);
    $dadesCampanya = db_fetch_array($queryCampanya);

    $queryCapçalera = db_query('SELECT * FROM newsletter_headers WHERE ID = ' . $dadesButlleti['CAP']);
    $dadesCapçalera = db_fetch_array($queryCapçalera);


    if($dadesButlleti && $dadesCampanya){
        $carpetaskin = $dadesButlleti['SKIN'] != '' ? 'model' . $dadesButlleti['SKIN'] : 'default';

        $fileModel = $pathBase . '/public/media/plantilles/' . $carpetaskin . '/base.tpl';
        $imatgeCapçalera = 'src="' . $CONFIG_URLUPLOADCAPS . $dadesCapçalera['IMATGE'] . '" alt="' . $dadesCampanya['titol'] . '"';



        $idioma = isset($MODELS[$dadesButlleti['SKIN']]['idioma']) ? $MODELS[$dadesButlleti['SKIN']]['idioma'] : 'ca';
        $modelButlleti = $dadesButlleti['SKIN'];

        if($MODELS[$modelButlleti]['idioma'] == 'ca'){
            setlocale(LC_ALL,'ca_ES.UTF-8');
        }
        if($MODELS[$modelButlleti]['idioma'] == 'es'){
            setlocale(LC_ALL,'es_ES.UTF-8');
        }
        if($MODELS[$modelButlleti]['idioma'] == 'en'){
            setlocale(LC_ALL,'en_EN.UTF-8');
        }
        if($MODELS[$modelButlleti]['idioma'] == 'fr'){
            setlocale(LC_ALL,'fr_FR.UTF-8');
        }

        include_once $CONFIG_PATHMEDIA . '/lang/lang_' . $MODELS[$modelButlleti]['idioma'] . '.php';

        switch($opcio){
            case 'amic':
                $titolApartat = $messages['titolamic'];
                $contingut = '<form action="' . $CONFIG_URLBASE . '/media/php/correu.php" method="post" id="formulari" name="formulari">
								<label for="correu_amic">
								<span>' . $messages['correudestinatari'] . ':</span><br />
								<input type="text" id="correu_amic" name="correu_amic" value="" size="30" maxlength="100" class="required email" />
							</label>
							<input type="hidden" name="idCam" value="' . $dadesButlleti['IdCam'] . '" />
							<input type="submit" name="accion" VALUE="' . $messages['enviar'] . '" />
						</form>';
                break;
            case 'amicok':
                $titolApartat = $messages['titol_amicok'];
                $contingut = $messages['amicok'];
                break;
            case 'amicerror':
                $titolApartat = $messages['titol_amicerror'];
                $contingut = $messages['amicerror'];
                break;
            case 'legal':
                $titolApartat = $messages['titollegal'];
                $contingut = $messages['avislegal'];
                $contingut = str_replace('|email_contacte|', 'comunicacio@sanitatintegral.org', $contingut);
                break;
            case 'alta':
                $titolApartat = $messages['titolalta'];
                $contingut = '<form action="' . $CONFIG_URLBASE . '/media/php/news_subscribe.php" method="post" id="formulari" name="formulari">
								<label for="email">
									<span>' . $messages['correuelectronic'] . '</span><br />
									<input type="text" id="email" name="email" class="required email" />
								</label>
								<br /><br />
								<label for="nom">
									<span>' . $messages['nom'] . '</span><br />
									<input type="text" id="nom" name="nom" class="required" />
								</label>
								<br /><br />
								<label for="cognoms">
									<span>' . $messages['cognoms'] . '</span><br />
									<input type="text" id="cognoms" name="cognoms" class="required" />
								</label>
								<br /><br />
								<input type="hidden" name="idLlista" value="' . $MODELS[$modelButlleti]['llistaNovesAltes'] . '" />
								<input type="hidden" name="idCam" value="' . $dadesButlleti['IdCam'] . '" />
								<input type="submit" name="accion" value="' . $messages['enviar'] . '" />
							</form>';
                break;
            case 'altaok':
                $titolApartat = $messages['titol_altaok'];
                $ok = isset($_GET['ok']) ? $_GET['ok'] : '';
                $contingut = $messages['altaok' . $ok];
                break;
            case 'altaerror':
                $titolApartat = $messages['titol_altaerror'];
                $error = isset($_GET['error']) ? $_GET['error'] : 1;
                $contingut = $messages['altaerror' . $error];
                break;
            case 'confirmaok':
                $titolApartat = $messages['titol_confirmaok'];
                $contingut = $messages['confirmaok'];
                break;
            case 'confirmaerror':
                $titolApartat = $messages['titol_confirmaerror'];
                $error = isset($_GET['error']) ? $_GET['error'] : 1;
                $contingut = $messages['confirmaerror' . $error];
                break;
            case 'anteriors':
                $titolApartat = $messages['titoledicionsanteriors'];
                $consultaAnteriors = db_query('SELECT * FROM ' . TAULA_CAMPANYES . ' WHERE estat >= 101');
                if(db_affected_rows($consultaAnteriors) > 0){
                    while($row = db_fetch_array($consultaAnteriors)){
                        $contingut .= '<li>' . $row['IDNL'] . ' | <a href="' . $CONFIG_URLBASE . '/view.php?id=' . $row['IdCam'] . '">' . $row['titol'] . '</a>';
                    }
                    if($contingut != ''){
                        $contingut = '<ul id="anteriors">' . $contingut . '</ul>';
                    }
                } else {
                    $contingut = '<p class="error">' . $messages['nobutlletins'] . '</p>';
                }
                break;
            case 'detall': //Només per notícies del newsletter agafem el model hotitzontal per defecte
                if(isset($_GET['idNot'])){
                    $noticiaModel = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/noticies_newsletters.tpl';
                    $Tplnoticia = new awTemplate('|');
                    $Tplnoticia->scanFile($noticiaModel);
                    if (!$Tplnoticia->Ok) {
                        return false;
                    }
                    $queryNoticia = db_query('SELECT * FROM ' . TAULA_NOTICIESNEWSLETTER . ' WHERE STATUS=1 AND ID = "' . $_GET['idNot'] . '" LIMIT 0,1');
                    if($queryNoticia){
                        $dadesNoticia = db_fetch_array($queryNoticia);
                        $regData['TITOL_REGISTRE'] = $dadesNoticia['TITOL'];
                        $regData['DESCRIPCIO_REGISTRE'] = $dadesNoticia['DESCRIPCIO'];
                        $regData['DATA_REGISTRE'] = strftime($MODELS[$modelButlleti]['format_data'], strtotime($dadesNoticia['CREATION']));
                        if($dadesNoticia['IMATGE1'] != ''){
                            $regData['WITH_TEXT'] = 'width: ' . $MODELS[$modelButlleti]['width_text_fitxa'] . ';';
                            $regData['IMATGE_REGISTRE'] = '<img style="float: left; padding: 10px 10px 10px 0; width:' . $MODELS[$modelButlleti]['width_imatges_fitxa'] . '" src="' . $CONFIG_URLUPLOADIM_NL . $dadesNoticia['IMATGE1'] . '" alt="' . $dadesNoticia['TITOL'] . '" />';
                        }

                        for($i=1;$i<5;$i++){
                            $filename = $CONFIG_PATHUPLOADAD . $dadesNoticia['ADJUNT' . $i];
                            $filenameurl = $CONFIG_URLUPLOADAD . $dadesNoticia['ADJUNT' . $i];
                            if( $dadesNoticia['ADJUNT' . $i] != '' && file_exists($filename)){
                                $dadesNoticia['TITOL_ADJUNT' . $i] = $dadesNoticia['TITOL_ADJUNT' . $i] == '' ? 'Adjunt' . $i : $dadesNoticia['TITOL_ADJUNT' . $i];
                                $regData['ADJUNTS'] .= '<li><a href="' . $filename . '">' . $dadesNoticia['TITOL_ADJUNT' . $i] . '</a></li>';
                            }
                        }
                        if($regData['ADJUNTS'] != ''){
                            $regData['ADJUNTS'] = '<ul id="docs">' . $regData['ADJUNTS'] . '</ul>';
                        }
                        $regData['CONFIG_URLMODEL'] = $CONFIG_URLBASE . '/media/plantilles/model' . $modelButlleti . '/';
                        $contingut = $Tplnoticia->mergeBlock('ROW2', $regData);
                        $data['DATA'] = $regData['DATA_REGISTRE'];
                    }

                }
                break;
            case 'baixa':

                if(isset($_GET['code'])){
                    $xurro = trim(stripslashes($_GET['code']));
                    $valors = explode($CRIPTO_SEPAR, decrypt($xurro, $CRIPTO_KEY));
                    if ((count($valors)==4)&&($valors[3]==$CRIPTO_CHECK)) {
                        $idcam = $valors[0];
                        $idusu = $valors[1];
                        $email = $valors[2];
                        //echo "Campanya: $idcam  ,Usuari: $idusu  ,Email: $email";  //proves
                        //die();

                        // Llegir registre a actualitzar
                        $result5 = db_query("SELECT estat,IdLli FROM " . TAULA_DESTINATARIS . " WHERE IdCam = '$idcam' AND email='$email'");
                        if (db_num_rows($result5) > 0) {
                            $row5 = db_fetch_array($result5);
                            if ($row5['estat'] == 0) {  //si encara no s'ha enviat és un test i no cal actualitzar
                                $MISSATGE = 'No es pot donar de baixa un correu de test!';
                            } else {
                                $camps = array();
                                $camps['estat'] = 21;
                                $camps['dh_recepcio'] = date("Y-m-d H:i:s");
                                if (fer_update(TAULA_DESTINATARIS, $camps, "IdCam = '$idcam' AND email='$email'", 0)) {
                                    if ($row5['IdLli'] == 0) { //afegit manualment!
                                        // Si consta a alguna llista, marcar-lo com unsubscrit perquè quedi constància !
                                        $result9 = db_queryd("SELECT estat FROM " . TAULA_SUBSCRIPTORS . " WHERE email='$email'");
                                        if (db_num_rows($result9) > 0) {
                                            $row9 = db_fetch_array($result9);
                                            if ($row9['estat'] != 3)  {
                                                $campsSub = array();
                                                $campsSub['estat'] = 3;
                                                $campsSub['dh_baixa'] = date("Y-m-d H:i:s");
                                                fer_update(TAULA_SUBSCRIPTORS, $campsSub, "email='$email'");
                                            }
                                        }

                                    } else {  //d'una llista
                                        $campsSub = array();
                                        $campsSub['estat'] = 3;
                                        $campsSub['dh_baixa'] = date("Y-m-d H:i:s");
                                        // unsubscriure d'una sola llista:
                                        fer_update(TAULA_SUBSCRIPTORS, $campsSub, "IdLli = '".$row5['IdLli']."' AND email='$email'");
                                        // a IdLli hi consta una llista, però podria ser que el mateix mail fós a varies llistes.
                                        // Fer update per les diferents llistes de l'usuari, per si de cas, i marcar-lo com unsubscrit
                                        //fer_update('newsletter_subscriptors', $campsSub, "email='$email' AND IdUsu='$idusu'");
                                    }

                                    $contingut = '<h4>' . $messages['baixaok'] . ' <strong>'.$email.'</strong></h4>';
                                } else $contingut = '<h4>' . $messages['errorparam'] . '</h4>';
                            }
                        } else $contingut = '<h4>' . $messages['errornotrobat'] . '</h4>';
                    } else $contingut = '<h4>' . $messages['errorparam'] . '</h4>';
                } else {
                    $contingut = '<h4>' . $messages['errorparam'] . '</h4>';
                }
        }

        $data['CAPÇALERA'] = $imatgeCapçalera;
        $data['TITOL_BUTLLETI'] = $titolApartat . ' - ' . $dadesCampanya['titol'];
        $data['TITOL_APARTAT'] = $titolApartat;
        $data['DESCRIPCIO_BUTLLETI'] = $dadesCampanya['subject'];
        $data['IDNL'] = $dadesCampanya['IDNL'];
        $data['CONFIG_URLMODEL'] = $CONFIG_URLBASE . '/media/plantilles/model' . $dadesButlleti['SKIN'] . '/';
        $data['URL_TORNAR'] = $CONFIG_URLBASE . '/view.php?id=' . $idCam;
        $data['URL_BASE'] = $CONFIG_URLBASE . '/';
        $data['URL_ANTERIORS'] = $CONFIG_URLBASE . 'altres.php?opcio=anteriors?idCam=' . $idCam;

    } else {
        echo $contingut = '<h4>' . $messages['errorparam'] . '</h4>';
    }
} else {
    echo $contingut = '<h4>' . $messages['errorparam'] . '</h4>';
}

$Tpl = new awTemplate('|');
$Tpl->scanFile($fileModel);
if (!$Tpl->Ok) {
    return false;
}

$data['CONTINGUT'] = $contingut;

$content = $Tpl->mergeBlock('ALL', $data);
echo $content;
exit();