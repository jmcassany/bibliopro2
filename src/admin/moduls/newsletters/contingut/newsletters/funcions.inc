<?php

//gestio caixes admin
function getDadesBloc($array, $id, $idCam, $model, $bloc){
    global $MODELS;

    $result_final = '';
    $resultat = array();
    $items = array();

    if($idCam != ''){

        /* Obtenim les dades de la campanya i el butlletí */
        $queryButlleti = db_query('SELECT * FROM newsletter_newsletter WHERE IdCam = ' . $idCam);
        $dadesButlleti = db_fetch_array($queryButlleti);

        $queryCampanya = db_query('SELECT * FROM newsletter_campanyes WHERE IdCam = ' . $idCam);
        $dadesCampanya = db_fetch_array($queryCampanya);


        if($dadesButlleti && $dadesCampanya){
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

            $avui = strftime($MODELS[$modelButlleti]['format_data']);
            $data = array();

            $contingutNewsletter = unserialize($dadesButlleti['CONTENT']);

            if(is_array($contingutNewsletter)){
                //Desenrollem les notícies guardades serialitzades per mostrar-les
                foreach($contingutNewsletter as $indexCaixa => $dadesBloc){
                    if($indexCaixa == $bloc){
                        foreach ($dadesBloc['caixes'] as $idCaixa => $caixa){
                            $tipusCaixa = $caixa['tipusCaixa'];
                            $caixa['estilCaixa'] = $MODELS[$modelButlleti]['destacats'] == true ? ($caixa['estilCaixa'] == 1 ? 'highlighted' : '') : '';
                            $caixa['modeCaixa'] = $MODELS[$modelButlleti]['filescolumnes'] == true ? ($caixa['modeCaixa'] == 1 ? 'double' : 'normal') : 'normal';
                            switch($tipusCaixa){
                                case 'noticies':

                                    $arrayId = array();
                                    $ordres = array();
                                    foreach ($caixa['items'] as $registre){
                                        $arrayId[] = $registre['id'];
                                        $ordres[$registre['id']] = $registre['ordre'];
                                        $estils[$registre['id']] = $MODELS[$modelButlleti]['destacats'] == true ? $registre['estil'] == 1 ? 'highlighted' : '' : '';
                                    }
                                    $strId = implode("','",$arrayId);
                                    $strIdOrder = implode(",",$arrayId);
                                    
                                    $result = db_query("SELECT * FROM " . TAULA_NOTICIESNEWSLETTER ." WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')");
                                    $items = '';
                                    while($row = db_fetch_array($result)){
                                        $items .= maquetacioItemsNoticies($model, $indexCaixa, $caixa['nomCaixa'], $tipusCaixa, $ordres[$row['ID']], $caixa['estilCaixa'], $estils[$row['ID']], $dadesButlleti['ID'], $row);
                                    }
                                    $resultat[] = maquetacioCategoria($items, $indexCaixa, $caixa['nomCaixa'], $caixa['tipusCaixa'], $caixa['estilCaixa'], $caixa['modeCaixa'], $idCam);
                                    break;
                                case 'caixes':

                                    $arrayId = array();
                                    $ordres = array();
                                    foreach ($caixa['items'] as $registre){
                                        $arrayId[] = $registre['id'];
                                        $ordres[$registre['id']] = $registre['ordre'];
                                        $estils[$registre['id']] = $MODELS[$modelButlleti]['destacats'] == true ? $registre['estil'] == 1 ? 'highlighted' : '' : '';
                                    }
                                    $strId = implode("','",$arrayId);
                                    $strIdOrder = implode(",", $arrayId);
                                    
                                    $result = db_query("SELECT * FROM " . TAULA_CAIXETES ." WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')");
                                    $items = '';
                                    while($row = db_fetch_array($result)){
                                        $items .= maquetacioItemsCaixes($model, $indexCaixa, $caixa['nomCaixa'], $tipusCaixa, $ordres[$row['ID']], $caixa['estilCaixa'], $caixa['modeCaixa'], $estils[$row['ID']],$row['ID'], $row);
                                    }
                                    $resultat[] = maquetacioCategoria($items, $indexCaixa, $caixa['nomCaixa'], $caixa['tipusCaixa'], $caixa['estilCaixa'], $caixa['modeCaixa'], $idCam);
                                    break;

                                case 'galeries':
                                    $arrayId = array();
                                    $ordres = array();
                                    foreach ($caixa['items'] as $registre){
                                        $arrayId[] = $registre['id'];
                                        $ordres[$registre['id']] = $registre['ordre'];
                                        $estils[$registre['id']] = $MODELS[$modelButlleti]['destacats'] == true ? $registre['estil'] == 1 ? 'highlighted' : '' : '';
                                    }
                                    $strId = implode("','",$arrayId);
                                    $strIdOrder = implode(",",$arrayId);
                                    
                                    $result = db_query("SELECT * FROM " . TAULA_BANNERS ." WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')");
                                    $items = '';
                                    while($row = db_fetch_array($result)){
                                        $items .= maquetacioItemsGaleries($model, $indexCaixa, $caixa['nomCaixa'], $tipusCaixa, $ordres[$row['ID']], $caixa['estilCaixa'], $caixa['modeCaixa'], $estils[$row['ID']], $row['ID'], $dadesButlleti['ID'], '', $row);
                                    }
                                    $resultat[] = maquetacioCategoria($items, $indexCaixa, $caixa['nomCaixa'], $caixa['tipusCaixa'],$caixa['estilCaixa'],$caixa['modeCaixa'], $idCam);
                                    break;

                                case 'rss':
                                    $arrayId = array();
                                    $ordres = array();
                                    foreach ($caixa['items'] as $registre){
                                        $arrayId[] = $registre['id'];
                                        $ordres[$registre['id']] = $registre['ordre'];
                                        $estils[$registre['id']] = $MODELS[$modelButlleti]['destacats'] == true ? $registre['estil'] == 1 ? 'highlighted' : '' : '';
                                    }
                                    $strId = implode("','",$arrayId);
                                    $strIdOrder = implode(",",$arrayId);
                                    
                                    $result = db_query("SELECT * FROM " . TAULA_REGISTRES_RSS ." WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')");
                                    $items = '';
                                    while($row = db_fetch_array($result)){
                                        $items .= maquetacioItemsRSS($model, $indexCaixa, $caixa['nomCaixa'], $tipusCaixa, $ordres[$row['ID']], $caixa['estilCaixa'], $estils[$row['ID']], $caixa['modeCaixa'], $row['ID'], $row);
                                    }
                                    $resultat[] = maquetacioCategoria($items, $indexCaixa, $caixa['nomCaixa'], $caixa['tipusCaixa'], '','', $idCam);
                                    break;

                                case 'blog':
                                    $arrayId = array();
                                    $ordres = array();
                                    foreach ($caixa['items'] as $registre){
                                        $arrayId[] = $registre['id'];
                                        $ordres[$registre['id']] = $registre['ordre'];
                                        $estils[$registre['id']] = $MODELS[$modelButlleti]['destacats'] == true ? $registre['estil'] == 1 ? 'highlighted' : '' : '';
                                    }
                                    $strId = implode("','",$arrayId);
                                    $strIdOrder = implode(",",$arrayId);
                                    
                                    $link = connexio_blog();
                                    $result = mysql_query("SELECT * FROM " . TAULA_BLOCS ." WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')") or die('Error en la connexió al bloc');
                                    $items = '';
                                    while($row = mysql_fetch_array($result)){
                                        $items .= maquetacioItemsBlog($model, $indexCaixa, $caixa['nomCaixa'], $tipusCaixa, $ordres[$row['ID']], $caixa['estilCaixa'], $estils[$row['ID']], $dadesButlleti['ID'], $row);
                                    }
                                    $resultat[] = maquetacioCategoria($items, $indexCaixa, $caixa['nomCaixa'], $caixa['tipusCaixa'], $caixa['estilCaixa'], $caixa['modeCaixa'], $idCam);
                                    break;

                                case 'noticies-houdini':
                                    $arrayId = array();
                                    $ordres = array();
                                    $editora = $caixa['idEditora'];
                                    foreach ($caixa['items'] as $registre){
                                        $arrayId[] = $registre['id'];
                                        $ordres[$registre['id']] = $registre['ordre'];
                                        $estils[$registre['id']] = $MODELS[$modelButlleti]['destacats'] == true ? $registre['estil'] == 1 ? 'highlighted' : '' : '';
                                    }
                                    $strId = implode("','",$arrayId);
                                    $strIdOrder = implode(",",$arrayId);
                                    $pathEditora = folderPath($editora);
                                    
                                    $link = connexio_houdini();
                                    $result = mysql_query("SELECT * FROM editora_" . $editora ." WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')", $link) or die('Error en la consulta a la taula de notícies houdini');
                                    $items = '';
                                    while($row = mysql_fetch_array($result)){
                                        $items .= maquetacioItemsNotHoudini($model, $indexCaixa, $caixa['nomCaixa'], $tipusCaixa, $ordres[$row['ID']], $caixa['estilCaixa'], $caixa['modeCaixa'], $estils[$row['ID']], $row['ID'], $dadesButlleti['ID'], $row, $pathEditora);
                                    }
                                    $resultat[] = maquetacioCategoria($items, $indexCaixa, $caixa['nomCaixa'], $caixa['tipusCaixa'], $caixa['estilCaixa'], $caixa['modeCaixa'], $idCam);
                                    break;

                                case 'agenda-houdini':
                                    $arrayId = array();
                                    $ordres = array();
                                    $editora = $caixa['idEditora'];
                                    foreach ($caixa['items'] as $registre){
                                        $arrayId[] = $registre['id'];
                                        $ordres[$registre['id']] = $registre['ordre'];
                                        $estils[$registre['id']] = $MODELS[$modelButlleti]['destacats'] == true ? $registre['estil'] == 1 ? 'highlighted' : '' : '';
                                    }
                                    $strId = implode("','",$arrayId);
                                    $strIdOrder = implode(",", $arrayId);
                                    $pathEditora = folderPath($editora);
                                    
                                    $link = connexio_houdini();
                                    $result = mysql_query("SELECT * FROM editora_" . $editora ." WHERE (STATUS=1) AND ID IN('" . $strId . "') ORDER BY FIND_IN_SET(ID, '" . $strIdOrder ."')", $link) or die('Error en la consulta a la taula d\'agenda houdini');
                                    $items = '';
                                    while($row = mysql_fetch_array($result)){
                                        $items .= maquetacioItemsAgendaHoudini($model, $indexCaixa, $caixa['nomCaixa'], $tipusCaixa, $ordres[$row['ID']], $caixa['estilCaixa'], $caixa['modeCaixa'], $estils[$row['ID']], $row['ID'], $dadesButlleti['ID'], $row, $pathEditora);
                                    }
                                    $resultat[] = maquetacioCategoria($items, $indexCaixa, $caixa['nomCaixa'], $caixa['tipusCaixa'], $caixa['estilCaixa'], $caixa['modeCaixa'], $idCam);
                                    break;
                            }
                        }
                    }
                }
            }
        }
    }
    foreach($resultat as $valor)
    {
        $result_final .= $valor;
    }

    return $result_final;
}
function maquetacioItemsNoticies($model, $columna, $nomCaixa, $tipusCaixa, $ordre, $estilLlistat, $estilElement, $id_newsletter, $registre)
{
    global $CONFIG_URLUPLOADIM_NL, $MODELS;

    $parametres = '<input type="hidden" name="newsletter['.htmlspecialchars($model).']['.htmlspecialchars($columna).']['.htmlspecialchars($nomCaixa).']['.htmlspecialchars($tipusCaixa).'][]['.htmlspecialchars($estilCaixa).']['.htmlspecialchars($estilLlistat).']['.htmlspecialchars($estilElement).']" value="'.htmlspecialchars($id_registre).'" />';

    if ($registre['LINK'] != '') {
        $titol_noticia_nl = '<a href="'.$registre['LINK'].'">'.$registre['TITOL'].'</a>';
    } else {
        $titol_noticia_nl = $registre['TITOL'];
    }

    $imatge = '';
    if ($registre['IMATGE1'] != '') {
        $imatge = '<img src="'.$CONFIG_URLUPLOADIM_NL . 'p' . $registre['IMATGE1'].'" alt="' . $registre['TITOL'] . '" class="left" />';
    }

    $data = strftime($MODELS[$model]['format_data'], strtotime($registre['CREATION']));

    return '<li id="not_reg' . $registre['ID'] . '" class="box removable stylable clearfix '.$estilElement.'">
			'.$parametres.'
			<div class="spacer clearfix">
				'.$imatge.'
				<h4>'.$titol_noticia_nl.'</h4>
				<p>'.$data.'</p>
				'.$registre['RESUM'].'
			</div>
		</li>';
}

/*
 MAQUETACIO EDITORA BANNERS ADMIN
 *********************************/
function maquetacioItemsGaleries($model, $columna, $nomCaixa, $tipusCaixa, $ordre, $estilCaixa, $estilLlistat, $estilElement, $id_registre, $id_newsletter, $bloc, $registre)
{
    global $CONFIG_URLBASE, $CONFIG_URLUPLOADBANNER;

    if ($bloc == 1) {
        $aire = 'hspace="10"';
        $salt = '';
    }
    elseif ($bloc == 2) {
        $aire = 'vspace="10"';
        $salt = '<br />';
    }

    $banner = ($registre['IMATGE'] != '') ? '<a href="'.$CONFIG_URLBASE.'/view-banner.php?ID='.$id_newsletter.'&amp;idbanner='.$id.'&amp;urlbanner='.$registre['LINK'].'" rel="external"><img src="' . $CONFIG_URLUPLOADBANNER . $registre['IMATGE'].'" alt="' . $registre['TITOL'] . '" border="0" '.$aire.' /></a>'.$salt : '';

    $parametres = '<input type="hidden" name="newsletter['.htmlspecialchars($model).']['.htmlspecialchars($columna).']['.htmlspecialchars($nomCaixa).']['.htmlspecialchars($tipusCaixa).'][]['.htmlspecialchars($estilCaixa).']['.htmlspecialchars($estilLlistat).']['.htmlspecialchars($estilElement).']" value="'.htmlspecialchars($id_registre).'" />';
    return '<li id="gal_reg' . $id_registre . '"  class="box removable  '.$estilElement.'">
			'.$parametres.'
			<div class="spacer clearfix">
				'.$banner.'
			</div>
		</li>';
}

/*
 MAQUETACIO EDITORA DE CAIXES ADMIN
 ***********************************/
function maquetacioItemsCaixes($model, $columna, $nomCaixa, $tipusCaixa, $ordre, $estilCaixa, $estilLlistat, $estilElement, $id_registre, $registre)
{
    global $CONFIG_estilsElement;

    $parametres = '<input type="hidden" name="newsletter['.htmlspecialchars($model).']['.htmlspecialchars($columna).']['.htmlspecialchars($nomCaixa).']['.htmlspecialchars($tipusCaixa).'][]['.htmlspecialchars($estilCaixa).']['.htmlspecialchars($estilLlistat).']['.htmlspecialchars($estilElement).']" value="'.htmlspecialchars($id_registre).'" />';
    //return '<li class="box removable">
    return '<li id="box_reg' . $id_registre . '" class="box removable stylable clearfix '.$estilElement.'">
			'.$parametres.'
			<div class="spacer clearfix">
				'.$registre['TEXT'].'
			</div>
		</li>';
}

/*
 MAQUETACIO EDITORA DE RSS ADMIN
 ***********************************/
function maquetacioItemsRSS($model, $columna, $nomCaixa, $tipusCaixa, $ordre, $estilCaixa, $estilLlistat, $estilElement, $id_registre, $registre)
{
    $parametres = '<input type="hidden" name="newsletter['.htmlspecialchars($model).']['.htmlspecialchars($columna).']['.htmlspecialchars($nomCaixa).']['.htmlspecialchars($tipusCaixa).'][]['.htmlspecialchars($estilCaixa).']['.htmlspecialchars($estilLlistat).']['.htmlspecialchars($estilElement).']" value="'.htmlspecialchars($id_registre).'" />';

    //ORIGEN RSS
    $registre['origen'] = ($registre['LINK1'] != '') ? '<a href="'.$registre['LINK1'].'" rel="external" style="color: '.$color_titol.'; text-decoration:none;">'.$registre['TITOL'].'</a>' : '';


    return '<li id="rss_reg' . $id_registre . '"  class="box removable stylable '.$estilElement.'">
			'.$parametres.'
			<div class="spacer clearfix">
				<h4>'.$registre['origen'].'</h4>
				'. $registre['RESUM'].'
			</div>
		</li>';
}

function getOrigenRSS($id_registre)
{
    $link = connexio_newsletter();
    $result = mysql_query("select * from newsletter_rss where ID=".$id_registre, $link);
    $row = mysql_fetch_array($result);
    desconnexio($result, $link);
    return $row['ORIGEN_RSS'];
}

/*
 MAQUETACIO EDITORA DE BLOG ADMIN
 ***********************************/
function maquetacioItemsBlog($model, $columna, $nomCaixa, $tipusCaixa, $ordre, $estilCaixa, $estilLlistat, $estilElement, $id_registre, $registre)
{

    $parametres = '<input type="hidden" name="newsletter['.htmlspecialchars($model).']['.htmlspecialchars($columna).']['.htmlspecialchars($nomCaixa).']['.htmlspecialchars($tipusCaixa).'][]['.htmlspecialchars($estilCaixa).']['.htmlspecialchars($estilLlistat).']['.htmlspecialchars($estilElement).']" value="'.htmlspecialchars($id_registre).'" />';

    $imatge = $registre['IMG'] != '' ? '<img src="' . $CONFIG_URLUPLOADIM . $registre['IMG'] . '" style="width:159px" class="left"/>' : '';

    return '<li id="bloc_reg' . $id_registre . '"  class="box removable stylable clearfix '.$estilElement.'">
			'.$parametres.'
			<div class="spacer clearfix">
				'.$imatge.'
				<p>'.$registre['DATA_POST'].'</p>
				<h4><a href="'.$info_registre['guid'].'" rel="external">'.$registre['TITOL'].'</a></h4>
				<p>'.$registre['RESUM_MOSTRAR'].'</p>
			</div>
		</li>';
}

/*
 MAQUETACIO EDITORA DE NOTICIES HOUDINI ADMIN
 *******************************************/
function maquetacioItemsNotHoudini($model, $columna, $nomCaixa, $tipusCaixa, $ordre, $estilCaixa, $estilLlistat, $estilElement, $id_registre, $id_newsletter, $registre, $pathEditora)
{
    global $CONFIG_URLBASE, $CONFIG_URLUPLOADIM, $CONFIG_estilsElement;

    $parametres = '<input type="hidden" name="newsletter['.htmlspecialchars($model).']['.htmlspecialchars($columna).']['.htmlspecialchars($nomCaixa).']['.htmlspecialchars($tipusCaixa).'][]['.htmlspecialchars($estilCaixa).']['.htmlspecialchars($estilLlistat).']['.htmlspecialchars($estilElement).']" value="'.htmlspecialchars($id_registre).'" />';

    $imatge = $registre['IMATGE1'] != '' ? '<img src="' . $CONFIG_URLUPLOADIM . $registre['IMATGE1'] . '" style="width: 159px;" class="left"/>' : '';
    return '<li id="noth_reg' . $id_registre . '" class="box removable stylable clearfix '.$estilElement.'">
			'.$parametres.'
			<div class="spacer clearfix">
				'. $imatge .'
				<h4><a href="'.$CONFIG_URLBASE . $pathEditora . '/' . $registre['ID'] . '/' . $registre['URL_TITOL'].'" rel="external">'.$registre['TITOL'].'</a></h4>
				<p>'.$registre['RESUM'].'</p>
			</div>
		</li>';
}


/*
 MAQUETACIO EDITORA DE AGENDA HOUDINI ADMIN
 *******************************************/
function maquetacioItemsAgendaHoudini($model, $columna, $nomCaixa, $tipusCaixa, $ordre, $estilCaixa, $estilLlistat, $estilElement, $id_registre, $id_newsletter, $registre, $pathEditora)
{
    global $CONFIG_URLBASE , $CONFIG_URLUPLOADIM; 
    $parametres = '<input type="hidden" name="newsletter['.htmlspecialchars($model).']['.htmlspecialchars($columna).']['.htmlspecialchars($nomCaixa).']['.htmlspecialchars($tipusCaixa).'][]['.htmlspecialchars($estilCaixa).']['.htmlspecialchars($estilLlistat).']['.htmlspecialchars($estilElement).']" value="'.htmlspecialchars($id_registre).'" />';
    
    $registre['ORIGEN'] = '<h4><a href="'.$CONFIG_URLBASE . $pathEditora . $registre['ID'] . '/' . $registre['URL_TITOL'] . '" rel="external" style="text-decoration:none;">'.$registre['TITOL'].'</a></h4>';
    $imatge = $registre['IMATGE1'] != '' ? '<img src="' . $CONFIG_URLUPLOADIM . $registre['IMATGE1'] . '" style="width: 159px;" class="left"/>' : '';
    
    return '<li id="ageh_reg' . $id_registre . '"  class="box removable stylable  '.$estilElement.'">
			'.$parametres.'
			<div class="spacer clearfix">
			    ' . $imatge . '
				'.$registre['ORIGEN'].'
				'.$registre['RESUM'].'
			</div>
		</li>';
}

function maquetacioCategoria($items, $columna, $nomCaixa, $tipusCaixa, $estilLlistat, $modeLlistat, $id_campanya)
{
    return '<li class="box collapsible removable renamable clearfix">
			<div class="heading clearfix">
				<ul class="box-controls"><li class="add"><a class="addEntries" href="afegir-items.php?id='.$id_campanya.'&amp;tipusCaixa='.$tipusCaixa.'" title="Afegir més elements">Afegeix més elements</a></li></ul>
				<h3>' . htmlspecialchars($nomCaixa) . '</h3>
			</div>
			<!-- /heading -->
			<div class="content">
				<ul class="listing clearfix draggable not-connected stylable news ' . $estilLlistat . ' ' . $modeLlistat . '">
					'.$items.'
				</ul>
				<!-- /listing -->
			</div>
			<!-- /content -->
		</li>
		<!-- /box -->';
}

?>