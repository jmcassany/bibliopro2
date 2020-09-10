<?php
require_once ($CONFIG_PATHBASE . '/lib/aw/awtemplate.php');
if(file_exists($CONFIG_PATHBASE . '/lib/funcions_cat.inc')){
    require_once ($CONFIG_PATHBASE . '/lib/funcions_cat.inc');
} else {
    require_once ($CONFIG_PATHBASE . '/lib/funcions_cat.php');
}
function generarButlleti($idCam, $idioma = 'ca', $idLlista = ''){
    global $CONFIG_URLUPLOADAD_NL, $CONFIG_PATHUPLOADAD_NL, $CONFIG_editoresNL, $MODELS, $pathBase, $CONFIG_URLUPLOADCAPS, $CONFIG_URLUPLOADIM, $CONFIG_URLUPLOADIM_NL, $CONFIG_URLUPLOADBANNER, $CONFIG_NOMCARPETA, $CONFIG_URLBASE, $CONFIG_PATHBASE, $messages, $CONFIG_NOMCARPETA_HOUDINI, $CONFIG_URLBASE_HOUDINI, $CONFIG_PATHMEDIA, $CONFIG_URLSITE;
    $generat = false;
    $content = '';

    if($idCam != ''){
         
        /* Obtenim les dades de la campanya i el butlletí */
        $queryButlleti = db_query('SELECT * FROM ' . TAULA_NEWSLETTERS . ' WHERE IdCam = ' . $idCam);
        $dadesButlleti = db_fetch_array($queryButlleti);

        $queryCampanya = db_query('SELECT * FROM ' . TAULA_CAMPANYES . ' WHERE IdCam = ' . $idCam);
        $dadesCampanya = db_fetch_array($queryCampanya);

        if($dadesButlleti['CAP'] != '' && in_array($dadesCampanya['tipus'],array(3,4))){
            $queryCapçalera = db_query('SELECT * FROM ' . TAULA_CAPÇALERES . ' WHERE ID = ' . $dadesButlleti['CAP']);
            $dadesCapçalera = db_fetch_array($queryCapçalera);
        } else {
            $dadesCapçalera = null;
        }

        /*Reiniciem les dades de la informació sobre clics per aquest butlletí */

        $queryDeleteClicsNoticies = db_query('DELETE FROM ' . TAULA_NLTONOTICIES . ' WHERE ID_NL = "' . $dadesButlleti['ID'] . '" AND LINKS = 0');
        $queryDeleteClicsBanners = db_query('DELETE FROM ' . TAULA_NLTOBANNERS . ' WHERE ID_NL = "' . $dadesButlleti['ID'] . '" AND LINKS = 0');

        if($dadesCampanya && $dadesButlleti){

            if(in_array($dadesCampanya['tipus'],array(3,4))){
                //Generat a partir d'un model de butlletí concret
                $modelButlleti = $dadesButlleti['SKIN'];
                /* Definició de plantilles */
                $fileModel = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/index.tpl';
                $noticiesNewslettersModel = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/noticies_newsletters.tpl';
                $noticiesNewslettersModel_columnes = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/noticies_newsletters_columnes.tpl';
                $agendaModel = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/agenda.tpl';
                $agendaModel_columnes = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/agenda_columnes.tpl';
                $noticiesModel = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/noticies.tpl';
                $noticiesModel_columnes = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/noticies_columnes.tpl';
                $bannersModel = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/banners.tpl';
                $bannersModel_columnes = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/banners_columnes.tpl';
                $caixetesModel = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/caixetes.tpl';
                $caixetesModel_columnes = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/caixetes_columnes.tpl';
                $rssModel = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/rss.tpl';
                $rssModel_columnes = $pathBase . '/public/media/plantilles/model' . $modelButlleti . '/rss_columnes.tpl';


                if(is_file($fileModel) && !is_dir($fileModel)){
                    $Tpl = new awTemplate('|');
                    $Tpl->scanFile($fileModel);
                    if (!$Tpl->Ok) {
                        return false;
                    }
                    $plantilla = file_get_contents($fileModel);

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

                    $avui = strftime($MODELS[$modelButlleti]['format_data']);
                    $imatgeCapçalera = 'src="' . $CONFIG_URLUPLOADCAPS . $dadesCapçalera['IMATGE'] . '" alt="' . $dadesCampanya['titol'] . '"';
                    $data = array();

                    ;

                    /* Assignació de les variables de la plantilla */
                    $data['CAPÇALERA'] = $imatgeCapçalera;
                    $data['TITOL_BUTLLETI'] = $dadesCampanya['titol'];
                    $data['DESCRIPCIO_BUTLLETI'] = $dadesCampanya['subject'];
                    $data['IDNL'] = $dadesCampanya['IDNL'];
                    $data['DATA'] = ucfirst($avui);
                    $data['CONFIG_URLMODEL'] = $CONFIG_URLBASE . '/media/plantilles/model' . $modelButlleti . '/';
                    $data['URL_ALTA'] = $CONFIG_URLBASE . '/altres.php?opcio=alta&amp;idCam=' . $idCam;
                    //$data['URL_BAIXA'] = '#';
                    $data['URL_AMIC'] = $CONFIG_URLBASE . '/altres.php?opcio=amic&amp;idCam=' . $idCam;;
                    $data['URL_LEGAL'] = $CONFIG_URLBASE . '/altres.php?opcio=legal&amp;idCam=' . $idCam;
                    $data['URL_ANTERIORS'] = $CONFIG_URLBASE . '/altres.php?opcio=anteriors&amp;idCam=' . $idCam;
                    $data['LECTURA'] = '<img alt="." src="' . $CONFIG_URLBASE . '/control.php?id=[[codi]]" style="display:none;" />';
                    $data['ANY'] = date('Y');
                    
                    $contingutNewsletter = unserialize($dadesButlleti['CONTENT']);

                    $content .= $Tpl->mergeBlock('HEAD', $data);
                    if(is_array($contingutNewsletter)){
                        //Desenrollem les notícies guardades serialitzades per mostrar-les
                        foreach($contingutNewsletter as $indexCaixa => $dadesBloc){

                            foreach ($dadesBloc['caixes'] as $caixa){
                                $tipusCaixa = $caixa['tipusCaixa'];
                                $tall = explode("_", $tipusCaixa);
                                if ($tall[1] != '') {
                                    $tipusCaixa = $tall[0];
                                }

                                $modeCaixa = $caixa['modeCaixa'];
                                $separador = $modeCaixa == 1 ? '</tr><tr>' : '';

                                $regData['TITOL_CAIXETA'] = $caixa['nomCaixa'];
                                $regData['CONFIG_URLMODEL'] = $data['CONFIG_URLMODEL'];
                                if($regData['TITOL_CAIXETA'] != ''){
                                    switch($tipusCaixa) {
                                        default:
                                        case 'noticies': {
                                            /* Agafem el template per les notícies procedents del newsletter en vertical o horitzontal */
                                            $templateBloc = $modeCaixa == 1 ? $noticiesNewslettersModel_columnes : $noticiesNewslettersModel;
                                            $TplContingut = new awTemplate('|');
                                            $TplContingut->scanFile($templateBloc);

                                            if (!$TplContingut->Ok) {
                                                return false;
                                            }
                                            if($regData['TITOL_CAIXETA'] != ''){
                                                $subContent = $TplContingut->mergeBlock('HEAD', $regData);

                                                $arrayId = array();
                                                if(is_array($caixa['items'])){
                                                    foreach ($caixa['items'] as $registre){
                                                        $arrayId[] = $registre['id'];
                                                    }
                                                }
                                                $strId = implode("','",$arrayId);
                                                $strIdOrder = implode(",", $arrayId);

                                                $result = db_query("SELECT * FROM " . TAULA_NOTICIESNEWSLETTER ." WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')");
                                                $posicio = 1; //Per les columnnes, imparell esquerra, parell dreta
                                                while($row = db_fetch_array($result)){
                                                    $estilCaixa = $caixa['items'][$row['ID']]['estil'];
                                                    $regData['ESTILS_TD_DESTACAT'] = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_td_destacat'] : '';
                                                    $regData['ESTILS_TITOL_DESTACAT'] = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_titol_destacat'] : '';
                                                    $estilsImatge = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_imatge_destacada'] : '';

                                                    $bloc = 0;
                                                    $categoria = getInfoCategoria($row['CATEGORY1']);
                                                    $regData['TITOL_REGISTRE'] = $row['TITOL'];
                                                    $regData['RESUM_REGISTRE'] = $row['RESUM'];
                                                    $regData['DATA_REGISTRE'] = strftime($MODELS[$modelButlleti]['format_data'], strtotime($row['CREATION']));
                                                    $regData['IMATGE_REGISTRE'] = '';
                                                    if($row['IMATGE1'] != ''){
                                                        $bloc = 1;
                                                        $regData['IMATGE_REGISTRE'] = '<img style="float:left; padding: 20px 10px 10px 0; width:' . $MODELS[$modelButlleti]['width_imatges_llistat'] . '; ' . $estilsImatge . '" src="' . $CONFIG_URLUPLOADIM_NL . $MODELS[$modelButlleti]['prefix_imatges_llistat'] . $row['IMATGE1'] . '" alt="' . $row['TITOL'] . '" />';
                                                    }
                                                    $regData['RELACIONATS_REGISTRE'] = '';
                                                    for($i=1;$i<5;$i++){
                                                        $filename = $CONFIG_PATHUPLOADAD_NL . $row['ADJUNT' . $i];
                                                        $filenameurl = $CONFIG_URLUPLOADAD_NL . $row['ADJUNT' . $i];
                                                         
                                                        if( $row['ADJUNT' . $i] != '' && file_exists($filename)){
                                                            $row['TITOL_ADJUNT' . $i] = $row['NOMAD' . $i] == '' ? $messages['adjunt'] . $i : $row['NOMAD' . $i];
                                                            $regData['RELACIONATS_REGISTRE'] .= '<li><a href="' . $filenameurl . '">' . $row['TITOL_ADJUNT' . $i] . '</a></li>';
                                                        }
                                                    }
                                                    if($regData['RELACIONATS_REGISTRE'] != ''){
                                                        $regData['RELACIONATS_REGISTRE'] = '<ul id="docs">' . $regData['RELACIONATS_REGISTRE'] . '</ul>';
                                                    }
                                                    $regData['ENLLAÇ_REGISTRE'] = $CONFIG_URLBASE . '/altres.php?opcio=detall&amp;idCam=' . $idCam . '&amp;idNot=' . $row['ID'];
                                                    $regData['LLEGIR_MES'] = $messages['llegirmes'];
                                                    $regData['SEPARADOR'] = ($posicio % 2 == 0) ? $separador : '';
                                                    $posicio++;

                                                    $subContent .= $TplContingut->mergeBlock('ROW' . $bloc, $regData);

                                                    if(db_num_rows(db_query('SELECT * FROM ' . TAULA_NLTONOTICIES . ' WHERE ID_NNL =' . $row['ID'] . ' AND ID_NL = ' . $dadesButlleti['ID'] . ' AND LINKS != 0')) == 0){
                                                        $sqlInsertNoticies = db_query('INSERT INTO ' . TAULA_NLTONOTICIES . " (ID_NNL, ID_NL) VALUES ('" . $row['ID'] . "','" . $dadesButlleti['ID'] . "')");
                                                    }
                                                }
                                            }
                                            break;
                                        }
                                        case 'noticies-houdini':{

                                            /* Agafem el template per les notícies procedents del newsletter en vertical o horitzontal */
                                            $templateBloc = $modeCaixa == 1 ? $noticiesNewslettersModel_columnes : $noticiesNewslettersModel;

                                            $TplContingut = new awTemplate('|');
                                            $TplContingut->scanFile($templateBloc);

                                            if (!$TplContingut->Ok) {
                                                return false;
                                            }
                                            $subContent = $TplContingut->mergeBlock('HEAD', $regData);

                                            $arrayId = array();
                                            foreach ($caixa['items'] as $registre){
                                                $arrayId[] = $registre['id'];
                                            }
                                            $strId = implode("','",$arrayId);
                                            $strIdOrder = implode(",", $arrayId);
                                            $ID_CARPETA = $caixa['idEditora'];
                                            $pathEditora = folderPath($ID_CARPETA) . '/';
                                            $link = connexio_houdini();
                                            $result = mysql_query("SELECT * FROM editora_" . $caixa['idEditora'] ." WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')", $link) or die('Error en la connexió a la taula de notícies de houdini');
                                            $i = 0;
                                            while($row = mysql_fetch_array($result)){

                                                $estilCaixa = $caixa['items'][$row['ID']]['estil'];
                                                $regData['ESTILS_TD_DESTACAT'] = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_td_destacat'] : '';
                                                $regData['ESTILS_TITOL_DESTACAT'] = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_titol_destacat'] : '';
                                                $estilsImatge = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_imatge_destacada'] : '';

                                                $bloc = 0;
                                                $categoria = getInfoCategoria($row['CATEGORY1']);
                                                $regData['CATEGORIA_REGISTRE'] = $categoria['TITOL'];
                                                $regData['TITOL_REGISTRE'] = $row['TITOL'];
                                                $regData['RESUM_REGISTRE'] = $row['RESUM'];
                                                $regData['DATA_REGISTRE'] = strftime($MODELS[$modelButlleti]['format_data'], strtotime($row['CREATION']));
                                                $regData['IMATGE_REGISTRE'] = '';
                                                if($row['IMATGE1'] != ''){
                                                    $bloc = 1;
                                                    $regData['IMATGE_REGISTRE'] = '<img style="float:left; padding: 20px 10px 10px 0; width:' . $MODELS[$modelButlleti]['width_imatges_llistat'] . '; ' . $estilsImatge . '" src="' . $CONFIG_URLUPLOADIM . $row['IMATGE1'] . '" alt="' . $row['TITOL'] . '" />';
                                                }
                                                $regData['ENLLAÇ_REGISTRE'] = $CONFIG_URLSITE . '/' . $pathEditora . $row['ID'] . '/' . $row['URL_TITOL'];
                                                $regData['LLEGIR_MES'] = $messages['llegirmes'];
                                                $regData['SEPARADOR'] = ($i % 2) ? $separador : '';

                                                $i++;
                                                $subContent .= $TplContingut->mergeBlock('ROW' . $bloc, $regData);
                                            }
                                            break;
                                        }
                                        case 'agenda-houdini':{
                                            /* Agafem el template per les notícies procedents del newsletter en vertical o horitzontal */
                                            $templateBloc = $modeCaixa == 1 ? $agendaModel_columnes : $agendaModel;
                                            $TplContingut = new awTemplate('|');
                                            $TplContingut->scanFile($templateBloc);

                                            if (!$TplContingut->Ok) {
                                                return false;
                                            }
                                            $subContent = $TplContingut->mergeBlock('HEAD', $regData);

                                            $arrayId = array();
                                            foreach ($caixa['items'] as $registre){
                                                $arrayId[] = $registre['id'];
                                            }
                                            $strId = implode("','",$arrayId);
                                            $strIdOrder = implode(",", $arrayId);
                                            $ID_CARPETA = $caixa['idEditora'];
                                            $pathEditora = folderPath($ID_CARPETA) . '/';
                                            $link = connexio_houdini();
                                            $result = mysql_query("SELECT * FROM editora_" . $caixa['idEditora'] ." WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')", $link) or die('Error en la connexió a la taula d\'agenda de houdini');
                                            $i = 0;
                                            while($row = mysql_fetch_array($result)){
                                                $estilCaixa = $caixa['items'][$row['ID']]['estil'];
                                                $regData['ESTILS_TD_DESTACAT'] = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_td_destacat'] : '';
                                                $regData['ESTILS_TITOL_DESTACAT'] = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_titol_destacat'] : '';
                                                $estilsImatge = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_imatge_destacada'] : '';

                                                $bloc = 0;
                                                $categoria = getInfoCategoria($row['CATEGORY1']);
                                                $regData['CATEGORIA_REGISTRE'] = $categoria['TITOL'];
                                                $regData['TITOL_REGISTRE'] = $row['TITOL'];
                                                $regData['RESUM_REGISTRE'] = $row['RESUM'];
                                                $regData['DATA_REGISTRE'] = strftime($MODELS[$modelButlleti]['format_data'], strtotime($row['DATA']));
                                                $regData['IMATGE_REGISTRE'] = '';
                                                if($row['IMATGE1'] != ''){
                                                    $bloc = 1;
                                                    $regData['IMATGE_REGISTRE'] = '<img style="float:left; padding: 20px 10px 10px 0; width:' . $MODELS[$modelButlleti]['width_imatges_llistat'] . '; ' . $estilsImatge . '" src="' . $CONFIG_URLUPLOADIM . $row['IMATGE1'] . '" alt="' . $row['TITOL'] . '" />';
                                                }
                                                $regData['ENLLAÇ_REGISTRE'] = $CONFIG_URLSITE . '/' . $pathEditora . $row['ID'] . '/' . $row['URL_TITOL'];
                                                $regData['LLEGIR_MES'] = $messages['llegirmes'];
                                                $regData['SEPARADOR'] = ($i % 2) ? $separador : '';

                                                $i++;
                                                $subContent .= $TplContingut->mergeBlock('ROW' . $bloc, $regData);
                                            }
                                            break;
                                        }
                                        case 'galeries':{

                                            $templateBloc = $modeCaixa == 1 ? $bannersModel_columnes : $bannersModel;
                                            
                                            $TplContingut = new awTemplate('|');
                                            $TplContingut->scanFile($templateBloc);
                                            if (!$TplContingut->Ok) {
                                                return false;
                                            }

                                            $subContent = $TplContingut->mergeBlock('HEAD', $regData);

                                            $arrayId = array();
                                            foreach ($caixa['items'] as $registre){
                                                $arrayId[] = $registre['id'];
                                            }
                                            $strId = implode("','",$arrayId);
                                            $strIdOrder = implode(",", $arrayId);

                                            $result = db_query("SELECT * FROM " . TAULA_BANNERS . " WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')");

                                            while($row = db_fetch_array($result)){
                                                $regData['IMATGE_REGISTRE'] = $row['IMATGE'];
                                                $regData['TITOL_REGISTRE'] = $row['TITOL'];
                                                $regData['ENLLAÇ_REGISTRE'] = $CONFIG_URLBASE . '/altres.php?opcio=banner&amp;idCam=' . $idCam . '&amp;idBan=' . $row['ID'];
                                                $regData['CONFIG_URLUPLOADSBANNER'] = $CONFIG_URLUPLOADBANNER;
                                                $subContent .= $TplContingut->mergeBlock('ROW0', $regData);

                                                if(db_num_rows(db_query('SELECT * FROM ' . TAULA_NLTOBANNERS . ' WHERE ID_BAN =' . $row['ID'] . ' AND ID_NL = ' . $dadesButlleti['ID'] . ' AND LINKS != 0')) == 0){
                                                    $sqlInsertBanners = db_query('INSERT INTO ' . TAULA_NLTOBANNERS . " (ID_BAN, ID_NL) VALUES ('" . $row['ID'] . "','" . $dadesButlleti['ID'] . "')");
                                                }
                                            }
                                            break;
                                        }
                                        case 'caixes':{
                                            $templateBloc = $modeCaixa == 1 ? $caixetesModel_columnes : $caixetesModel;
                                            $TplContingut = new awTemplate('|');
                                            $TplContingut->scanFile($templateBloc);
                                            if (!$TplContingut->Ok) {
                                                return false;
                                            }

                                             
                                            $subContent = $TplContingut->mergeBlock('HEAD', $regData);

                                            $arrayId = array();
                                            $destacats = array();
                                            foreach ($caixa['items'] as $registre){
                                                $arrayId[] = $registre['id'];
                                                $destacats[$registre['id']] = $registre['estil'];
                                            }
                                            $strId = implode("','",$arrayId);
                                            $strIdOrder = implode(",", $arrayId);

                                            $result = db_query("SELECT * FROM " . TAULA_CAIXETES . " WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')");
                                            $i = 0;
                                            while($row = db_fetch_array($result)){
                                                $estilCaixa = $caixa['items'][$row['ID']]['estil'];
                                                $regData['ESTILS_TD_DESTACAT'] = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_td_destacat'] : '';
                                                $regData['ESTILS_TITOL_DESTACAT'] = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_titol_destacat'] : '';
                                                $regData['COLOR'] = $destacats[$row['ID']] == '1' ? 'rgb(253, 209, 161)' : '';
                                                $regData['TANCAMENT'] = $destacats[$row['ID']] == '1' ? '<img alt="" src="' . $CONFIG_URLBASE . '/media/comu/baix_final_form.gif" />' : '';
                                                $regData['TITOL_REGISTRE'] = $row['TITOL'];
                                                $regData['TEXT_REGISTRE'] = $row['TEXT'];
                                                $regData['SEPARADOR'] = ($i % 2) ? $separador : '';
                                                $i++;
                                                $subContent .= $TplContingut->mergeBlock('ROW0', $regData);
                                            }
                                            break;
                                        }
                                        case 'rss': {
                                            /* Agafem el template per les notícies procedents del newsletter en vertical o horitzontal */
                                            $templateBloc = $modeCaixa == 1 ? $rssModel_columnes : $rssModel;
                                            $TplContingut = new awTemplate('|');
                                            $TplContingut->scanFile($templateBloc);

                                            if (!$TplContingut->Ok) {
                                                return false;
                                            }
                                            $subContent = $TplContingut->mergeBlock('HEAD', $regData);

                                            $arrayId = array();
                                            if(is_array($caixa['items'])){
                                                foreach ($caixa['items'] as $registre){
                                                    $arrayId[] = $registre['id'];
                                                }
                                            }
                                            $strId = implode("','",$arrayId);
                                            $strIdOrder = implode(",", $arrayId);

                                            $result = db_query("SELECT * FROM " . TAULA_REGISTRES_RSS ." WHERE ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')");
                                            $posicio = 1; //Per les columnnes, imparell esquerra, parell dreta
                                            while($row = db_fetch_array($result)){
                                                $estilCaixa = $caixa['items'][$row['ID']]['estil'];
                                                $regData['ESTILS_TD_DESTACAT'] = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_td_destacat'] : '';
                                                $regData['ESTILS_TITOL_DESTACAT'] = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_titol_destacat'] : '';
                                                $estilsImatge = $estilCaixa == 1 ? $MODELS[$modelButlleti]['estils_imatge_destacada'] : '';
                                                
                                                $bloc = 0;
                                                $categoria = getInfoCategoria($row['CATEGORY1']);
                                                $regData['TITOL_REGISTRE'] = $row['TITOL'];
                                                $regData['RESUM_REGISTRE'] = $row['RESUM'];
                                                $regData['ENLLAÇ_REGISTRE'] = $row['LINK1'];
                                                $regData['LLEGIR_MES'] = $messages['llegirmes'];
                                                $regData['SEPARADOR'] = ($posicio % 2 == 0) ? $separador : '';

                                                $posicio++;

                                                $subContent .= $TplContingut->mergeBlock('ROW' . $bloc, $regData);
                                            }
                                            break;
                                        }

                                    }
                                    $subContent .= $TplContingut->mergeBlock('FOOT', $regData);
                                    $data['CONTINGUT'] = $subContent;

                                    $content.= $Tpl->mergeBlock('BLOC' . $indexCaixa, $data);
                                }
                            }
                            $num = $Tpl->getBlockNumber('BLOC' . $indexCaixa) + 1;
                            $name = $Tpl->getBlockName($num);
                            if(preg_match('@UNK@', $name)){
                                $content.= $Tpl->mergeBlock($name,$data); //Mostra les part entremig de dos blocs
                            }
                        }
                    }

                    $content .= $Tpl->mergeBlock('FOOT', $data);

                    /* Generem el fitxer final */
                    $targetfilename = $pathBase .'/public/butlletins/butlleti' . $dadesButlleti['ID'] . '.html';
                     

                    /*crear fitxer amb la pagina*/
                    $tempfile = fopen($targetfilename, 'w');
                    if (!$tempfile) {
                        return(_t("staticpageerrornoopen")); //impossible obrir la plantilla
                        exit;
                    }
                    fwrite($tempfile, $content);
                    fclose($tempfile);
                    chmod($targetfilename, 0777);
                    $generat = true;
                }

            } else if($dadesCampanya['tipus'] == "1" || $dadesCampanya['tipus'] == "2"){
                //Generat a partir de l'html incrustat o d'un fitxer
                $content = $dadesButlleti['CONTENT'];
                $data = array();
                $data['URL_ALTA'] = $CONFIG_URLBASE . '/altres.php?opcio=alta&amp;idCam=' . $idCam;
                //$data['URL_BAIXA'] = '#';
                $data['URL_AMIC'] = $CONFIG_URLBASE . '/altres.php?opcio=amic&amp;idCam=' . $idCam;;
                $data['URL_LEGAL'] = $CONFIG_URLBASE . '/altres.php?opcio=legal&amp;idCam=' . $idCam;
                $data['URL_ANTERIORS'] = $CONFIG_URLBASE . '/altres.php?opcio=anteriors&amp;idCam=' . $idCam;
                $variables = array('|URL_ALTA|','|URL_AMIC|','|URL_LEGAL|','|URL_ANTERIORS|');
                $content = str_replace($data,$variables,$content);

                $targetfilename = $pathBase .'/public/butlletins/butlleti' . $dadesButlleti['ID'] . '.html';
                $tempfile = fopen($targetfilename, 'w');
                if (!$tempfile) {
                    return(_t("staticpageerrornoopen")); //impossible obrir la plantilla
                    exit;
                }
                fwrite($tempfile, $content);
                fclose($tempfile);
                chmod($targetfilename, 0777);
                $generat = true;
            }
        }
        return $generat;
    }
}
?>