<?php
include_once '../../selconfig.php';
include_once 'config.php';

require_once ($CONFIG_PATHBASE."/lib/lastRSS.inc");

if (!getenv('testserver')) {
    setlocale(LC_ALL, 'ca_ES.UTF-8');
}
else{
    setlocale(LC_ALL, 'ca_ES.UTF-8');
}


$idCam = null;
$columna = false;
$nomCaixa = false;
$tipusCaixa = false;
$indexCaixa = false;
$modeCaixa = 0;
$estilsLlistat = 0;
$origen = '';

if(isset($_POST['idCam'])){
    $idCam =  $_POST['idCam'];
} elseif(isset($_GET['idCam'])){
    $idCam =  $_GET['idCam'];
}

if(isset($_POST['columna'])){
    $columna =  $_POST['columna'];
} elseif(isset($_GET['columna'])){
    $columna =  $_GET['columna'];
}

if(isset($_POST['nomCaixa'])){
    $nomCaixa =  $_POST['nomCaixa'];
} elseif(isset($_GET['nomCaixa'])){
    $nomCaixa =  $_GET['nomCaixa'];
}

if(isset($_POST['tipusCaixa'])){
    $tipusCaixa =  $_POST['tipusCaixa'];
} elseif(isset($_GET['tipusCaixa'])){
    $tipusCaixa =  $_GET['tipusCaixa'];
}

if(isset($_POST['modeCaixa'])){
    $modeCaixa =  $_POST['modeCaixa'];
} elseif(isset($_GET['modeCaixa'])){
    $modeCaixa =  $_GET['modeCaixa'];
}

if(isset($_POST['indexCaixa'])){
    $indexCaixa =  $_POST['indexCaixa'];
} elseif(isset($_GET['indexCaixa'])){
    $indexCaixa =  $_GET['indexCaixa'];
}

if(isset($_POST['estilsLlistat'])){
    $estilsLlistat =  $_POST['estilsLlistat'];
} elseif(isset($_GET['estilsLlistat'])){
    $estilsLlistat =  $_GET['estilsLlistat'];
}

// determinem la columna on va, el nom, el tipus de la caixa i el tipus de llistat a la que s'estan afegint items
$selectedItems = isset($_POST['selectedItems']) ? $_POST['selectedItems'] : (isset($_GET['selectedItems']) ? $_GET['selectedItems'] : array());

//model x filtrar les noticies
$sql_model = "SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE IdCam='" . $idCam . "'";
$result_model = db_query($sql_model);

$row_model = db_fetch_array($result_model);
$model = $row_model['SKIN'];
$contingut = unserialize($row_model['CONTENT']);

if(isset($contingut[$columna]['caixes'][sanitize_title($nomCaixa)])){
    $selItems = array();
    if(is_array($contingut[$columna]['caixes'][sanitize_title($nomCaixa)]['items'])){
        foreach ($contingut[$columna]['caixes'][sanitize_title($nomCaixa)]['items'] as $item){
            $selItems[] = $item['id'];
        }
    }
    $tipusCaixa = $contingut[$columna]['caixes'][sanitize_title($nomCaixa)]['tipusCaixa'];
    $origen = $contingut[$columna]['caixes'][sanitize_title($nomCaixa)]['idEditora'];
} else {
    $selItems = array();
    //gestio origens
    $tall = explode("_", $tipusCaixa);
    $origen = '';
    if ($tall[1] != '') {
        $tipusCaixa = $tall[0];
        $origen = $tall[1];
    }
}




switch($tipusCaixa) {
    case 'noticies':
        $result = db_query("SELECT * FROM " . TAULA_NOTICIESNEWSLETTER . " WHERE (STATUS=1) ORDER BY CREATION DESC");
        $strSelected = implode("','", $selItems);
        $sqlAltres = "SELECT * FROM " . TAULA_NOTICIESNEWSLETTER . " WHERE (STATUS=1) AND ID NOT IN ('" . $strSelected . "') ORDER BY CREATION DESC LIMIT 0,15";
        $resultAltres = db_query($sqlAltres);
        break;
    case 'galeries':
        $result = db_query("SELECT * FROM " . TAULA_BANNERS . " WHERE (STATUS=1) ORDER BY CREATION DESC");
        $strSelected = implode("','", $selItems);
        $sqlAltres = "SELECT * FROM " . TAULA_BANNERS . " WHERE (STATUS=1) AND ID NOT IN ('" . $strSelected . "') ORDER BY CREATION DESC LIMIT 0,15";
        $resultAltres = db_query($sqlAltres);
        break;
    case 'caixes':
        $result = db_queryd("SELECT * FROM " . TAULA_CAIXETES . " WHERE (STATUS=1) ORDER BY CREATION DESC");
        $strSelected = implode(',', $selItems);
        $sqlAltres = "SELECT * FROM " . TAULA_CAIXETES . " WHERE (STATUS=1) AND ID NOT IN ('" . $strSelected . "') ORDER BY CREATION DESC LIMIT 0,15";
        $resultAltres = db_query($sqlAltres);
        break;
    case 'rss':
        $sql = "SELECT * FROM " . TAULA_RSS . " WHERE ID=" . $origen;
        $result = db_query($sql);
        $row = db_fetch_array($result);

        $noticiesRSS[] = array();

        // Try to load and parse RSS file
        $url = $row['LINK1'];
        $maxim = $row['MAX_ITEMS'];
        $item_RSS = 0;

        $rss = new lastRSS;
        $rss->items_limit = $maxim;
        $rss->CDATA = 'content';
        $rss->cp = 'utf-8';
        $rss->stripHTML = False;

        //$rss->data = $rss->fetch_url($url);	//cURL

        //if ($rs = $rss->get($url)) {	// A PAIR NO FUNCIONA... UTILITZAR cURL!!!!!!
        if ($rs = $rss->ParseCurl($url)) {	//cURL

            $trad = get_html_translation_table(HTML_SPECIALCHARS);
            $trad = array_flip($trad);
            $rs['title'] = strtr($rs['title'],$trad);

            foreach($rs['items'] as $item) {

                $item['title'] = strtr($item['title'],$trad);
                $item['description'] = strtr($item['description'],$trad);
                
                $noticiesRSS[$item_RSS]['RSS_TITLE'] = str_replace('"','&quot;',$item['title']);
                $noticiesRSS[$item_RSS]['RSS_ITEM_ID'] = $item_RSS;
                $noticiesRSS[$item_RSS]['RSS_DESCRIPTION'] = '';
                $noticiesRSS[$item_RSS]['RSS_PUBDATE'] = '';
                $noticiesRSS[$item_RSS]['RSS_LINK'] = '';
                if (!empty($item['description'])) {
                    $noticiesRSS[$item_RSS]['RSS_DESCRIPTION'] = $item['description'];
                }
                if (!empty($item['pubDate'])) {
                    $noticiesRSS[$item_RSS]['RSS_PUBDATE'] = $item['pubDate'];
                }
                if (!empty($item['link'])) {
                    $noticiesRSS[$item_RSS]['RSS_LINK'] = $item['link'];
                }

                $item_RSS++;
                
            }
        }
        else {
            echo "Error: It's not possible to reach RSS file...\n";
        }

        break;

    case 'blog':
        //connexió bloc
        $link = connexio_blog();
        $sql = 'select ID, post_title, post_date, post_content from wp_posts where post_status = "publish" and post_type = "post"  ORDER BY post_date DESC LIMIT 0,15';
        $result = mysql_query($sql, $link) or die('error select blog');
        $strSelected = implode(',', $selItems);
        $sqlAltres = 'select ID, post_title, post_date, post_content from wp_posts WHERE post_status = "publish" and post_type = "post" AND ID NOT IN ("' . $strSelected . '") ORDER BY CREATION DESC LIMIT 0,15';
        $resultAltres = mysql_query($sqlAltres, $link);
        break;

    case 'noticies-houdini':
    case 'noticies-houdini-es':
    case 'agenda-houdini':
    case 'agenda-houdini-es':
        //connexió houdini
        //$link = connexio_houdini();
        $sql = 'SELECT * FROM editora_' . $origen . ' WHERE STATUS=1 ORDER BY CREATION DESC LIMIT 0,15';
        $result = db_query($sql) or die('error select agenda-es houdini');
        $strSelected = implode('","', $selItems);
        $sqlAltres = 'SELECT * FROM editora_' . $origen . ' WHERE STATUS=1 AND ID NOT IN ("' . $strSelected . '") ORDER BY CREATION DESC LIMIT 0,15';
        $resultAltres = db_query($sqlAltres);
        break;
}




//Items a mostrar al desplegable

if(!isset($_POST['novaCaixa']) || $_POST['novaCaixa'] == 0){
    $result = $resultAltres;
} else {
    $result = $result;
}

$i=0;
if($tipusCaixa == 'noticies' ||  $tipusCaixa == 'galeries' || $tipusCaixa == 'caixes' ){
    if($result){
        while($row = db_fetch_array($result)){
            preg_match("@([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})@", $row['CREATION'], $regs_data);
            $timestamp_creacio = mktime($regs_data[4], $regs_data[5], $regs_data[6], $regs_data[2], $regs_data[3], $regs_data[1]);
            $datahora = (preg_match("@^[aeiou]@", strftime("%B", $timestamp_creacio))) ? strftime("%e d'%B de %Y", $timestamp_creacio) : strftime("%e de %B de %Y", $timestamp_creacio);
            $items .= '<label for="nousItemsCaixa_'.$i.'" class="checkbox"><input type="checkbox" id="nousItemsCaixa_'.$i.'" name="nousItemsCaixa['.$i.']" value="'.htmlspecialchars($row['ID']).'" />'.htmlspecialchars($row['TITOL']).' ('.$datahora.')</label>';
            $i++;
        }
    }
} elseif($tipusCaixa != 'blog' && $tipusCaixa != 'rss') {
    if($result){
        while($row = db_fetch_array($result)){
            preg_match("@([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})@", $row['CREATION'], $regs_data);
            $timestamp_creacio = mktime($regs_data[4], $regs_data[5], $regs_data[6], $regs_data[2], $regs_data[3], $regs_data[1]);
            $datahora = (preg_match("@^[aeiou]@", strftime("%B", $timestamp_creacio))) ? strftime("%e d'%B de %Y", $timestamp_creacio) : strftime("%e de %B de %Y", $timestamp_creacio);
            $items .= '<label for="nousItemsCaixa_'.$i.'" class="checkbox"><input type="checkbox" id="nousItemsCaixa_'.$i.'" name="nousItemsCaixa['.$i.']" value="'.htmlspecialchars($row['ID']).'" />'.htmlspecialchars($row['TITOL']).' ('.$datahora.')</label>';
            $i++;
        }
    }

} elseif ($tipusCaixa == 'blog') {
    //$row['post_title'] = retornaContentIdioma($row['post_title'], 'ca');
    if ($row['post_title'] != '') $items .= '<label for="nousItemsCaixa_'.$i.'" class="checkbox"><input type="checkbox" id="nousItemsCaixa_'.$i.'" name="nousItemsCaixa['.$i.']" value="'.htmlspecialchars($row['ID']).'" />'.htmlspecialchars($row['post_title']).'</label>';
    mysql_close($link);
} elseif ($tipusCaixa == 'rss') {

    $i = 0;
    $items = '';

    foreach ($noticiesRSS as $key => $value) {

        // comprovem si ja esta insertat per no duplicar-lo
        $result_rss = db_query("SELECT * FROM " . TAULA_REGISTRES_RSS . " WHERE ORIGEN_RSS = " . $origen . " AND TITOL LIKE '" . html_entity_decode($value['RSS_TITLE']) . "'");
        if (db_num_rows($result_rss) == 0 ) {
            //MIRO ultim ID entrat
            $result = db_query("select MAX(ID) as ID from" . TAULA_REGISTRES_RSS);
            $totalresultats = db_num_rows($result);
            if ($totalresultats>0){
                $row2 = db_num_rows($result);
                $ID = $row2['ID']+1;
            }else{
                $ID = 1;
            }
        }
        else {
            $row_rss = db_fetch_array($result_rss);
            $ID = $row_rss['ID'];
        }

        if (is_array($selectedItems) and array_search($ID, $selectedItems) !== false) {
            continue;
        }
        else {

            $items .= '<label for="nousItemsCaixa_'.$i.'" class="checkbox"><input type="checkbox" id="nousItemsCaixa_'.$i.'" name="nousItemsCaixa['.$i.']" value="'.$ID.'" />'.htmlspecialchars($value['RSS_TITLE']).'</label>';

            //Formategem les imatges per tal de no trencar amb l'estructura definida pel model
            $value['RSS_DESCRIPTION'] = str_replace('<img ','<img class="left" style="width:' . $MODELS[$model]['width_imatges_llistat'] . '"',$value['RSS_DESCRIPTION']);
            $value['RSS_DESCRIPTION']= preg_replace('@width="[0-9]*"@', '' , $value['RSS_DESCRIPTION']);
            $value['RSS_DESCRIPTION']= preg_replace('@height="[0-9]*"@', '' , $value['RSS_DESCRIPTION']);
                        
            if ( db_num_rows($result_rss) == 0 ) {
                if (($timestamp = strtotime($value['RSS_PUBDATE'])) === -1) {
                    $data_publicacio = date('Y-m-d H:i:s A', time());
                } else {
                    $data_publicacio = date('Y-m-d H:i:s A',$timestamp);
                }
                
                //Adaptem les imatges a la mida del butlletí
                $sql_insert_rss = "INSERT INTO " . TAULA_REGISTRES_RSS . " (ECLASS, STATUS, CATEGORY2 ,SKIN, VISIBILITY, CREATION, TITOL, RESUM, LINK1, ORIGEN_RSS, AUTOR ) VALUES (1, 1, 1, 0, 1, '".$data_publicacio."', '".addslashes(html_entity_decode($value['RSS_TITLE']))."', '".addslashes($value['RSS_DESCRIPTION'])."', '".$value['RSS_LINK']."', '".$origen."','".$id."' )";
                $result_insert_rss = db_query($sql_insert_rss);
            } else {
                $sql_insert_rss = "UPDATE " . TAULA_REGISTRES_RSS . " SET TITOL = '".addslashes(html_entity_decode($value['RSS_TITLE']))."', RESUM='".addslashes($value['RSS_DESCRIPTION'])."',LINK1='".$value['RSS_LINK']."',ORIGEN_RSS='".$origen."' WHERE ORIGEN_RSS='" . $origen . "' AND ID='" . $ID . "'";
                $result_insert_rss = db_query($sql_insert_rss);
            }
        }

        $i++;
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca" lang="ca">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>Afegir ítems a la caixa - Can Antaviana</title>
<meta name="description"
	content="Demostració del sistema de caixes configurables" />
<meta name="keywords"
	content="caixes, configurables, mòbils, antaviana, javascript, jquery" />
<link rel="shortcut icon" href="media/css/img/favicon.ico"
	type="image/x-icon" />

<link rel="stylesheet" href="media/css/popup.css" type="text/css"
	media="screen" />
<link rel="stylesheet" href="media/css/print.css" type="text/css"
	media="print" />

<script type="text/javascript" src="../../media/js/jquery.js"></script>

<script type="text/javascript">
			$(document).ready(function() {

				$('#popupForm').attr('target', '_parent');
				$('#popupForm').submit(function() {

					// En cas d'estar creant una caixa, si no s'ha seleccionat cap entrada avisem l'usuari que no es crearà
					if ($(this).find('input[name=novaCaixa]').length > 0) {

						if ($(this).find('input[type=checkbox]:checked').length == 0) {

							alert ("S'ha de seleccionar com a mínim una entrada per a poder crear una caixa nova.");
							return false; // esborrar aquesta línia si es vol que l'usuari vegi l'avís pero que permeti no crear la caixa (el popup es tanca després de l'avís)

						}

					}

				});

			});
		</script>

</head>

<body id="popup">

    <form method="post" action="edita.php?IdCam=<?php echo htmlspecialchars($idCam); ?>" id="newItemsForm">
        <?php
        // si estem creant una caixa nova, avisem
        if (isset($_POST['novaCaixa'])) {
        ?>
            <input type="hidden" name="novaCaixa" value="1" />
        <?php
        } else {
        ?>
            <input type="hidden" name="nousElements" value="1" />
        <?php
        }
        $tipusCaixaFinal = $origen != '' ? $tipusCaixa.'_'.$origen : $tipusCaixa;
        ?>
            <input type="hidden" name="idCam" value="<?php echo $idCam; ?>" />
            <input type="hidden" name="columna" value="<?php echo htmlspecialchars($columna); ?>" />
            <input type="hidden" name="nomCaixa" value="<?php echo htmlspecialchars($nomCaixa); ?>" />
            <input type="hidden" name="tipusCaixa" value="<?php echo $tipusCaixaFinal; ?>" />
            <input type="hidden" name="estilsCaixa" value="<?php echo htmlspecialchars($estilsCaixa); ?>" />
            <input type="hidden" name="estilsLlistat" value="<?php echo htmlspecialchars($estilsLlistat); ?>" />
        <?php
        if (is_array($selectedItems) and count($selectedItems) > 0) {
            foreach ($selectedItems as $selectedItem) {
        ?>
            <input type="hidden" name="selectedItems[]"	value="<?php echo htmlspecialchars($selectedItem); ?>" />
        <?php
        
            }
        }
        
        if (!empty($items)) {
        
        ?>
            <fieldset><legend>Tria les entrades per a la caixa:</legend> <?php echo $items; ?>
        </fieldset>
        <div>
            <input type="submit" name="newItems" value="Aplicar els canvis" class="applyChanges" />
        </div>
        <?php
        } else {
        ?>
        <p class="info"><strong>No hi ha cap entrada disponible per aquesta caixa</strong></p>
        <?php
        }
        ?>
    </form>
</body>

</html>
