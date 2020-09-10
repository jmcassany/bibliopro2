<?php
require_once '../../selconfig.php';
require_once 'config.php';

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

function ordenaNoticies($a, $b){
    if ($a['ordre'] == $b['ordre']) {
        return 0;
    }
    return ($a['ordre'] < $b['ordre']) ? -1 : 1;
}

function ordenaCaixes($a, $b){
    if ($a['ordreCaixa'] == $b['ordreCaixa']) {
        return 0;
    }
    return ($a['ordreCaixa'] < $b['ordreCaixa']) ? -1 : 1;
}

if(isset($_POST['IdCam'])){
    $tipus = '';
    $idCam = $_POST['IdCam'];
    $sql = 'SELECT * FROM ' . TAULA_NEWSLETTERS . ' WHERE IdCam=' . $idCam;
    $result = db_query($sql);
    $row = db_fetch_array($result);
    $content = unserialize($row['CONTENT']);

    if(isset($_POST['idColumna']) && isset($_POST['accio'])){
        $idColumna = str_replace('columna', '', $_POST['idColumna']);

        if(isset($_POST['idCaixa']) && $_POST['idCaixa'] != null){
            $idCaixa = sanitize_title($_POST['idCaixa']);
        }

        if(isset($_POST['idNoticia'])  && $_POST['idNoticia'] != null){
            $idNoticia = explode('_',$_POST['idNoticia']);
            if($idNoticia[0] == 'RSS'){$tipus = 'rss';}
            $idNoticia = $idNoticia[count($idNoticia) - 1];
            $idNoticia = str_replace('reg', '', $idNoticia);
        }

        switch ($accio){
            case 'canviModeCaixa':
                if(isset($_POST['valor']) && isset($idCaixa)){
                    $mode = $_POST['valor'] == 'double' ? 1 : 0;
                    $content[$idColumna]['caixes'][$idCaixa]['modeCaixa'] = $mode;
                }
                break;

            case 'canviNomCaixa':
                if(isset($_POST['valor']) && isset($idCaixa)){
                    $nouNom = $_POST['valor'];
                    $nouId = sanitize_title($nouNom);
                    if($nouId != $idCaixa){
                        if(isset($content[$idColumna]['caixes'][$idCaixa])){
                            $content[$idColumna]['caixes'][$nouId] = $content[$idColumna]['caixes'][$idCaixa];
                            $content[$idColumna]['caixes'][$nouId]['nomCaixa'] = $nouNom;
                            unset($content[$idColumna]['caixes'][$idCaixa]); //Eliminem la caixa amb l'índex antic
                            uasort($content[$idColumna]['caixes'], 'ordenaCaixes');//Reordenem l'array de caixetes
                        }
                    }
                }
                break;
                 
            case 'moureCaixaColumna':  //Moure les caixes d'una columna a una altra
                if(isset($_POST['valor']) && is_array($_POST['valor']) && isset($idCaixa)){

                    $nouIndexCaixa = $_POST['valor'][0];
                    $nouIdColumna = str_replace('columna', '', $_POST['valor'][1]);

                    //Movem les caixetes implicades en el canvi d'ordre
                    if(isset($content[$idColumna]['caixes'])){
                        $ordreOriginal = $content[$idColumna]['caixes'][$idCaixa]['ordreCaixa'];

                        //Movem l'ordre de les caixes en la columna original
                        foreach ($content[$idColumna]['caixes'] as $indexCaixa => $dadesCaixa){
                            $ordre = $dadesCaixa['ordreCaixa'];
                            if($ordre >= 0 && $dadesCaixa['idCaixa'] != $idCaixa){
                                if($ordre > $ordreOriginal){
                                    $content[$idColumna]['caixes'][$indexCaixa]['ordreCaixa'] = intval($ordre) - 1;
                                }
                            }
                        }

                        if(is_array($content[$nouIdColumna]['caixes'])){
                            //Movem l'ordre de les caixes en la columna final
                            foreach ($content[$nouIdColumna]['caixes'] as $indexCaixa => $dadesCaixa){
                                $ordre = $dadesCaixa['ordreCaixa'];
                                if($ordre >= 0 && $dadesCaixa['idCaixa'] != $idCaixa){
                                    if($ordre >= $nouIndexCaixa){
                                        $content[$nouIdColumna]['caixes'][$indexCaixa]['ordreCaixa'] = intval($ordre) + 1;
                                    }
                                }
                            }
                        }
                        //Movem la caixa a la seva nova posició i reordrenem els arrays de les dues columnes afectades
                        $content[$nouIdColumna]['caixes'][$idCaixa] = $content[$idColumna]['caixes'][$idCaixa];
                        $content[$nouIdColumna]['caixes'][$idCaixa]['ordreCaixa'] = intval($nouIndexCaixa);
                        unset($content[$idColumna]['caixes'][$idCaixa]);
                        if(empty($content[$idColumna]['caixes'])){
                            unset($content[$idColumna]); //En cas que no quedi cap caixa a la columna, l'esborrem de l'array
                        } else {
                            uasort($content[$idColumna]['caixes'], 'ordenaCaixes');//Reordenem l'array de caixetes original
                        }
                    }
                    uasort($content[$nouIdColumna]['caixes'], 'ordenaCaixes');//Reordenem l'array de caixetes final
                }
                break;

            case 'moureCaixa': //Moure les caixes dins la mateixa columna
                if(isset($_POST['valor']) && isset($idCaixa)){
                    $ordreFinal = intval($_POST['valor']);
                    $ordreOriginal = $content[$idColumna]['caixes'][$idCaixa]['ordreCaixa'];
                    //Movem les caixetes implicades en el canvi d'ordre
                    foreach ($content[$idColumna]['caixes'] as $indexCaixa => $dadesCaixa){
                        $ordre = $dadesCaixa['ordreCaixa'];
                        if($dadesCaixa['idCaixa'] != $idCaixa){
                            if($ordreFinal < $ordreOriginal){
                                if($ordre >= $ordreFinal && $ordre<= $ordreOriginal){
                                    $content[$idColumna]['caixes'][$indexCaixa]['ordreCaixa'] = intval($ordre) + 1;
                                }     
                            } else {
                                if($ordre >= $ordreOriginal && $ordre <= $ordreFinal){
                                    $content[$idColumna]['caixes'][$indexCaixa]['ordreCaixa'] = intval($ordre) - 1;   
                                }
                            }
                        }
                    }
                    $content[$idColumna]['caixes'][$idCaixa]['ordreCaixa'] = intval($ordreFinal);
                    uasort($content[$idColumna]['caixes'], 'ordenaCaixes'); //Reordenem l'array de caixetes
                }
                break;

            case 'eliminaCaixa':
                if(isset($idCaixa) && isset($idColumna)){
                    $ordreOriginal = $content[$idColumna]['caixes'][$idCaixa]['ordreCaixa'];
                    unset($content[$idColumna]['caixes'][$idCaixa]);
                    if(empty($content[$idColumna]['caixes'])){
                        unset($content[$idColumna]);
                    } else {
                        //Reassignem l'ordre de les caixes restants de la mateixa columna
                        foreach($content[$idColumna]['caixes'] as $indexCaixa => $dadesCaixa){
                            if($dadesCaixa['ordreCaixa'] >= $ordreOriginal){
                                $content[$idColumna]['caixes'][$indexCaixa]['ordreCaixa'] = intval($content[$idColumna]['caixes'][$indexCaixa]['ordreCaixa']) - 1;
                            }
                        }
                        uasort($content[$idColumna]['caixes'], 'ordenaCaixes'); //Reordenem l'array de caixetes
                    }
                }
                break;

            case 'destacarCaixa':
                if(isset($_POST['valor']) && isset($idCaixa)){
                    $mode = $_POST['valor'] == 'highlighted' ? 1 : 0;
                    $content[$idColumna]['caixes'][$idCaixa]['estilCaixa'] = $mode;
                }
                break;

            case 'destacarNoticia':
                if(isset($_POST['valor']) && isset($idCaixa) && isset($idNoticia)){
                    $mode = $_POST['valor'] == 'highlighted' ? 1 : 0;
                    $content[$idColumna]['caixes'][$idCaixa]['items'][$idNoticia]['estil'] = $mode;
                }
                break;

            case 'moureNoticia': //Només permetem moure notícies dins la mateixa caixa
                if(isset($idCaixa) && isset($idColumna) && isset($idNoticia)){
                    if(isset($content[$idColumna]['caixes'][$idCaixa]['items'][$idNoticia])){
                        $ordreOriginal = $content[$idColumna]['caixes'][$idCaixa]['items'][$idNoticia]['ordre'];
                        $ordreFinal = $_POST['valor'];
                        //Movem la resta de noticies implicades en el canvi d'ordre
                        foreach ($content[$idColumna]['caixes'][$idCaixa]['items'] as $indexNoticia => $dadesNoticia){
                            $ordre = intval($dadesNoticia['ordre']);
                            if($ordreFinal < $ordreOriginal){
                                if($dadesNoticia['id'] != $idNoticia){
                                    if($ordre >= $ordreFinal && $ordre < $ordreOriginal){
                                        $content[$idColumna]['caixes'][$idCaixa]['items'][$indexNoticia]['ordre'] = $ordre + 1;
                                    }
                                }
                            } else {
                                if($ordre > 0 && $dadesNoticia['id'] != $idNoticia){
                                    if($ordre >= $ordreOriginal && $ordre <= $ordreFinal){
                                        $content[$idColumna]['caixes'][$idCaixa]['items'][$indexNoticia]['ordre'] = $ordre - 1;
                                    }
                                }
                            }
                        }
                        $content[$idColumna]['caixes'][$idCaixa]['items'][$idNoticia]['ordre'] = intval($ordreFinal);
                        uasort($content[$idColumna]['caixes'][$idCaixa]['items'],'ordenaNoticies');
                    }
                }
                break;

            case 'deleteNoticia':
                if(isset($idCaixa) && isset($idColumna) && isset($idNoticia)){
                    $ordreEliminat = $content[$idColumna]['caixes'][$idCaixa]['items'][$idNoticia]['ordre'];
                    //Movem la resta de noticies a la seva nova posició
                    foreach ($content[$idColumna]['caixes'][$idCaixa]['items'] as $indexNoticia => $dadesNoticia){
                        $ordre = intval($dadesNoticia['ordre']);
                        if($ordre > $ordreEliminat){
                            if($dadesNoticia['id'] != $idNoticia){
                                $content[$idColumna]['caixes'][$idCaixa]['items'][$indexNoticia]['ordre'] = $ordre - 1;
                            }
                        }
                    }
                    unset($content[$idColumna]['caixes'][$idCaixa]['items'][$idNoticia]);
                    if(empty($content[$idColumna]['caixes'][$idCaixa]['items'])){
                        unset($content[$idColumna]['caixes'][$idCaixa]);
                    }
                    uasort($content[$idColumna]['caixes'][$idCaixa]['items'],'ordenaNoticies');
                }
                break;

            case 'afegirNoticiaCaixa':
                //Es fa directament des d'edita.php al rebre per post nousItemsCaixa
                break;
        }
        $content = serialize($content);
        $sqlUpdate = "UPDATE " . TAULA_NEWSLETTERS . " SET CONTENT = '" . $content . "' WHERE IdCam = " . $idCam;
        db_query($sqlUpdate);
    }

}
if(isset($_POST['publicar'])){
    /* Nou sistema de generació a partir de plantilla */
    include_once $CONFIG_NLADMINPATHBASE . '/campanyes/generar_butlleti.php';
    $generat = generarButlleti($IdCam);
    header('Location:' . $CONFIG_NLADMINURLBASE . '/campanyes/pas2c.php?IdCam=' . $idCam);
    exit();
}