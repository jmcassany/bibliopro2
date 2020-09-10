<?php
if (!function_exists('filtreQuote')){
    function filtreQuote($value) {
      return str_replace('"', '&quot;', $value);
    }
}

if(!function_exists('_t')){
    function _t($string){
        return t($string);
    }
}

if(!function_exists('t')){
    function t($string){
        return _t($string);
    }
}

function htmlNewsletterError($missatge)
{
    global $CONFIG_NLADMINPATHBASE;
    include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
    echo '<div id="contenidor" class="crear lliurament">
            <div id="contingut">
                <h2>Error!</h2>
                <p>' . $missatge . '</p>
                <p><a href="javascript:history.back()">Tornar</a></p>
            </div>
          </div>';
    include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');    
}
function origensRSS()
{
    $origen[] = array();
    $i = 0;

    $result = db_query("select * from " . TAULA_RSS . " WHERE STATUS=1");
    while ($row = db_fetch_array($result)) {

        $origen[$i]['nom'] = $row['TITOL'] . ' (RSS)';
        $origen[$i]['valor'] = 'rss';
        $origen[$i]['id'] = $row['ID'];

        $i++;
    }

    return $origen;
}

function setCurrent($apartat){
    global  $curbutlletins,$curcontingut,$cursubscriptors,$curinformes,$curconfig;

    $curbutlletins = '';
    $curcontingut = '';
    $cursubscriptors = '';
    $curinformes = '';
    $curconfig = '';
    switch ($apartat){
        case 'butlletins':
            $curbutlletins = 'class="current"';
            break;
        case 'contingut':
            $curcontingut = 'class="current"';
            break;
        case 'subscriptors':
            $cursubscriptors = 'class="current"';
            break;
        case 'informes':
            $curinformes = 'class="current"';
            break;
        case 'configuracio':
            $curconfig = 'class="current"';
    }
}

function setJsVars(){
    global $CONFIG_estilsLlistat, $CONFIG_estilsCaixa, $CONFIG_estilsElement, $IdCam, $MODELS, $elementsCaixa,$elementsCaixa2,$estilsCaixa, $estilsCaixa2, $elementsLlistat, $elementsLlistat2, $estilsLlistat, $estilsLlistat2, $elementsElement, $elementsElement2, $estilsElement, $estilsElement2;
    $sql_model = "SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE IdCam=".$IdCam;
    $result_model = db_query($sql_model);
    $row_model = db_fetch_array($result_model);
    $model = $row_model['SKIN'];
    if($MODELS[$model]['destacats']){
        $estilsCaixa = "\tvar boxClasses = { ";
        $estilsCaixa2 = "\tvar sortedBoxClasses = [";
        if(is_array($CONFIG_estilsCaixa)){
            foreach ($CONFIG_estilsCaixa as $key => $value) {
                $elementsCaixa .= $elementsCaixa != '' ? "," : "";
                $elementsCaixa .= $value['nom'] . ": '" . $value['valor'] . "'";
                $elementsCaixa2 .= $elementsCaixa2 != '' ? ',' : '';
                $elementsCaixa2 .= "'" . $value['nom'] . "'";
            }
        }
        $estilsCaixa .= $elementsCaixa . "};\n";
        $estilsCaixa2 .= $elementsCaixa2 . "];\n";
    } else {
        $elementsCaixa = '';
        $elementsCaixa2 = '';
        $estilsCaixa = "\tvar boxClasses = null;";
        $estilsCaixa2 = "\tvar sortedBoxClasses = null;";
    }

    if($MODELS[$model]['filescolumnes']){
        $estilsLlistat = "\tvar listingClasses = { ";
        $estilsLlistat2 = "\tvar sortedListingClasses = [";
        if(is_array($CONFIG_estilsLlistat)){
            foreach ($CONFIG_estilsLlistat as $key => $value) {
                $elementsLlistat .= $elementsLlistat != '' ? "," : "";
                $elementsLlistat .= $value['nom'] .": '" . $value['valor'] . "'";
                $elementsLlistat2 .= $elementsLlistat2 != '' ? ',' : '';
                $elementsLlistat2 .= "'" . $value['nom'] . "'";
            }
        }
        $estilsLlistat .= $elementsLlistat . "};\n";
        $estilsLlistat2 .= $elementsLlistat2 . "];\n";
    } else {
        $elementsLlistat = '';
        $elementsLlistat2 = '';
        $estilsLlistat = "\tvar listingClasses = null;";
        $estilsLlistat2 = "\tvar sortedListingClasses = null;";
    }


    if($MODELS[$model]['destacats']){
        $estilsElement = "\tvar elementClasses = { ";
        $estilsElement2 = "\tvar sortedElementClasses = [";
        if(is_array($CONFIG_estilsElement)){
            foreach ($CONFIG_estilsElement as $key => $value) {
                $elementsElement .= $elementsElement != '' ? ',' : '';
                $elementsElement .= $value['nom'].": '".$value['valor']."'";
                $elementsElement2 .= $elementsElement2 != '' ? ',' : '';
                $elementsElement2 .= "'" . $value['nom'] . "'";
            }
        }
        $estilsElement .= $elementsElement . "};\n";
        $estilsElement2 .= $elementsElement2 . "];\n";
    } else {
        $elementsElement = '';
        $elementsElement2 = '';
        $estilsElement = "\tvar elementClasses = null;";
        $estilsElement2 = "\tvar sortedElementClasses = null;";
    }
}