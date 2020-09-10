<?php

/*
 Estils aplicables a la pàgina:
 .cerca-capcelera (p)
 .cerca_noresult (p)
 .cerca_suggeriment (ul)
 .cerca-categoria-element (h4)
 .cerca-element (div)
 .cerca-titol-element (h3)
 .cerca-ressaltat (span)
 .cerca-peu (div)
 .cerca-anterior (span)
 .cerca-seguent (span)
 */

// mida màxima del text llarg a mostrar
$TEXTL_MAX_LEN = 200;
// número màxim d'elements per pàgina
$MAX_ELEM_PAGE = 12;

require_once(dirname(__FILE__)."/config.php");
require_once ("database/database.inc");
require_once ("funcions_base.inc");
require_once ("formatting.php");

db_connect($db_url_web);

// obtenir paràmetres de la cerca
// text
if (isset($_POST['text-cerca'])) { $cerca = $_POST['text-cerca']; }
else if (isset($_GET['text-cerca'])) { $cerca = $_GET['text-cerca']; }
else { $cerca = ''; }
// idCuest
if (isset($_POST['ID_CUEST'])) { $idCuest = $_POST['ID_CUEST']; }
else if (isset($_GET['ID_CUEST'])) { $idCuest = $_GET['ID_CUEST']; }
else { $idCuest = ''; }
// tipus contingut
if (isset($_POST['CONTENIDO'])) { $content = $_POST['CONTENIDO']; }
else if (isset($_GET['CONTENIDO'])) { $content = $_GET['CONTENIDO']; }
else { $content = ''; }
// enfermetat
if (isset($_POST['ENFERMEDAD'])) { $illness = $_POST['ENFERMEDAD']; }
else if (isset($_GET['ENFERMEDAD'])) { $illness = $_GET['ENFERMEDAD']; }
else { $illness = ''; }
// mida
if (isset($_POST['MEDIDA'])) { $concept = $_POST['MEDIDA']; }
else if (isset($_GET['MEDIDA'])) { $concept = $_GET['MEDIDA']; }
else { $concept = ''; }
// edat
if (isset($_POST['EDAD'])) { $age = $_POST['EDAD']; }
else if (isset($_GET['EDAD'])) { $age = $_GET['EDAD']; }
else { $age = ''; }
// població
if (isset($_POST['POBLACION'])) { $population = $_POST['POBLACION']; }
else if (isset($_GET['POBLACION'])) { $population = $_GET['POBLACION']; }
else { $population = ''; }
// idioma
if (isset($_POST['IDIOMA'])) { $language = $_POST['IDIOMA']; }
else if (isset($_GET['IDIOMA'])) { $language = $_GET['IDIOMA']; }
else { $language = ''; }
if (isset($_POST['PAIS'])) { $country = $_POST['PAIS']; }
else if (isset($_GET['PAIS'])) { $country = $_GET['PAIS']; }
else { $country = ''; }
// obtenir pàgina
if (isset($_POST['pag'])) { $pag = $_POST['pag']; }
else if (isset($_GET['pag'])) { $pag = $_GET['pag']; }
else { $pag = 1; }

$urlParams = 'text-cerca='.htmlspecialchars(urlencode($cerca)).'&amp;ID_CUEST='.$idCuest.'&amp;CONTENIDO='.$content.'&amp;ENFERMEDAD='.$illness.'&amp;MEDIDA='.$concept.'&amp;EDAD='.$age.'&amp;POBLACION='.$population.'&amp;IDIOMA='.$language;
$nOrdre = (isset($_GET['orden']) and $_GET['orden'] == 'asc') ? 'desc' : 'asc';

$numdecaracters = strlen($cerca);
$cercaText = $cerca;
$cerca = str_replace(' + ',' ',$cerca);
$cerca = str_replace(' - ',' ',$cerca);

// comparacions ordenació
function cmp($a, $b)
{
    if ($a[0] == $b[0]) { return 0; }
    return ($a[0] < $b[0]) ? -1 : 1;
}
function cmpAutor($a, $b)
{
    return cmpString($a, $b, 2);
}
function cmpSiglas($a, $b)
{
    return cmpString($a, $b, 3);
}
function cmpTitulo($a, $b)
{
    return cmpString($a, $b, 4);
}
function cmpIdioma($a, $b)
{
    return cmpString($a, $b, 5);
}
function cmpPais($a, $b)
{
    return cmpString($a, $b, 6);
}
function cmpString($a, $b, $index)
{
    return strcasecmp(sanitize_title($a[$index]), sanitize_title($b[$index]));
}

// nombre de vegades que es troba una paraula
function str_incounter($match, $string)
{

    $count_match = 0;
    $resultats = array();

    $string = strtolower($string);
    $match = strtolower($match);
    /*aparicions del text complert*/
    if (preg_match('/^"(.*)"$/', $match, $trosos)) {
        $count_match += @substr_count ($string, $trosos[1]);
    }
    else {
        /*aparicions dels trossos de text*/
        $trosos = explode(' ', $match);
        foreach ($trosos as $value) {
            if (preg_match('/^\+(.*)$/', $value, $trosos2)) {
                $count_match += @substr_count ($string, $trosos2[1]);
            }
            else if (preg_match('/^-(.*)$/', $value, $trosos2)) {
                $count_match -= @substr_count ($string, $trosos2[1]);
            }
            else {
                $count_match += @substr_count ($string, $value);
            }
        }
    }
    return $count_match;

}

// paràmetres de la consulta
$where = $fieldsSorting = $fieldsOrderBy = '';
if (!empty($idCuest)) { $where .= "AND ID_CUEST = '" . mysql_real_escape_string($idCuest) . "'"; }
if (!empty($content)) { $where .= "AND CONTENIDO LIKE '%\"" . mysql_real_escape_string($content) . "\"%'"; }
if (!empty($illness)) { $where .= "AND ENFERMEDAD LIKE '%\"" . mysql_real_escape_string($illness) . "\"%'"; }
if (!empty($concept)) { $where .= "AND MEDIDA LIKE '%\"" . mysql_real_escape_string($concept) . "\"%'"; }
if (!empty($age)) { $where .= "AND EDAD LIKE '%\"" . mysql_real_escape_string($age) . "\"%'"; }
if (!empty($population)) { $where .= "AND POBLACION LIKE '%\"" . mysql_real_escape_string($population) . "\"%'"; }
if (!empty($language)) { $where .= "AND (
        IDIOMA_ORIGINAL = '" . mysql_real_escape_string($language) . "' OR
        IDIOMA_CAST = '" . mysql_real_escape_string($language) . "'
    )"; }
if (!empty($country)) { $where .= "AND (
        PAIS_CAST = '" . mysql_real_escape_string($country) . "' OR
        PAIS = '" . mysql_real_escape_string($country) . "'
    )"; }
if (!empty($cerca)) {

    $cercap = str_replace(array(' ',','),' +', $cerca);
    $cercap = '+' . $cercap;
    $where .= "AND (
            MATCH (
                NOM_ORIGINAL,
                NOM_CAST,
                SIGLAS,
                PALABRAS_CLAVE,
                AUTORES_ORIGINAL_NOMBRES,
                AUTORES_CAST_NOMBRES,
                REFERENCIA_ORIGINAL,
                REFERENCIA_CAST,
                CORRESPONDENCIA_ORIGINAL,
                CORRESPONDENCIA_CAST,
                COPYRIGHT_ORIGINAL,
                COPYRIGHT_CAST,
                OTROS_ORIGINAL,
                OTROS_CAST,
                NUMERO_ITEMS,
                DIMENSIONES
            )
            AGAINST ('" . mysql_real_escape_string($cercap) . "' IN BOOLEAN MODE)
            OR (
                NOM_ORIGINAL LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR NOM_CAST LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR SIGLAS LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR PALABRAS_CLAVE LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR AUTORES_ORIGINAL_NOMBRES LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR AUTORES_CAST_NOMBRES LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR REFERENCIA_ORIGINAL LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR REFERENCIA_CAST LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR CORRESPONDENCIA_ORIGINAL LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR CORRESPONDENCIA_CAST LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR COPYRIGHT_ORIGINAL LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR COPYRIGHT_CAST LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR OTROS_ORIGINAL LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR OTROS_CAST LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR NUMERO_ITEMS LIKE '%" . mysql_real_escape_string($cerca) . "%'
                OR DIMENSIONES LIKE '%" . mysql_real_escape_string($cerca) . "%'
            )
        )";
    $fieldsSorting .= ",
            MATCH (NOM_ORIGINAL) AGAINST ('" . mysql_real_escape_string($cercap) . "' IN BOOLEAN MODE) AS nomOriginalSort,
            MATCH (NOM_CAST) AGAINST ('" . mysql_real_escape_string($cercap) . "' IN BOOLEAN MODE) AS nomCastSort,
            MATCH (SIGLAS) AGAINST ('" . mysql_real_escape_string($cercap) . "' IN BOOLEAN MODE) AS siglasSort,
            MATCH (PALABRAS_CLAVE) AGAINST ('" . mysql_real_escape_string($cercap) . "' IN BOOLEAN MODE) AS keywordsSort,
            NOM_ORIGINAL LIKE '%" . mysql_real_escape_string($cerca) . "%' AS nomOriginalSortLike,
            NOM_CAST LIKE '%" . mysql_real_escape_string($cerca) . "%' AS nomCastSortLike,
            SIGLAS LIKE '%" . mysql_real_escape_string($cerca) . "%' AS siglasSortLike,
            PALABRAS_CLAVE LIKE '%" . mysql_real_escape_string($cerca) . "%' AS keywordsSortLike
        ";
    if(strlen($cerca) <= 3){
        $fieldsOrderBy .= "ORDER BY  siglasSort DESC, siglasSortLike DESC, nomCastSort DESC, nomOriginalSort DESC,  keywordsSort DESC,  nomOriginalSortLike DESC, nomCastSortLike DESC, keywordsSortLike DESC";
    } else {
        $fieldsOrderBy .= "ORDER BY  nomCastSort DESC, nomOriginalSort DESC, keywordsSort DESC, siglasSort DESC, siglasSortLike DESC, nomOriginalSortLike DESC, nomCastSortLike DESC, keywordsSortLike DESC";
    }
}
else {
    $fieldsOrderBy .= "ORDER BY SIGLAS ASC";
}
// si no s'ha aplicat cap filtre, mostrem només mares
if (empty($where)) {
    $where = 'AND VERSION = 1';
}

// escriure capçalera
function escriu_capcelera(
$num_resultats,
$cerca,
$idCuest,
$content,
$illness,
$concept,
$age,
$population,
$language,
$inici = 0,
$fi = 0
)
{

    global $text_resultats, $text_total, $text_utilitzant, $urlParams, $nOrdre, $where;
    global $taula_contingut, $taula_malalties, $taula_mesures, $taula_poblacio, $taula_edats, $taula_idiomes;

    if (!isset($text_resultats) || $text_resultats == '') {
        $text_resultats = 'Mostrando resultados';
    }
    if (!isset($text_total) || $text_total == '') {
        $text_total = 'de un total de';
    }
    if (!isset($text_utilitzant) || $text_utilitzant == '') {
        $text_utilitzant = 'cuestionarios con los siguientes criterios';
    }

    // passem tipus contingut a string
    if (!empty($content)) {
        $q = db_query ("SELECT VALOR FROM `$taula_contingut` WHERE ID= '" . mysql_real_escape_string($content) . "'");
        $r = db_fetch_array($q);
        $content = $r['VALOR'];
    }
    // passem malaltia a string
    if (!empty($illness)) {
        $q = db_query ("SELECT VALOR FROM `$taula_malalties` WHERE ID= '" . mysql_real_escape_string($illness) . "'");
        $r = db_fetch_array($q);
        $illness = $r['VALOR'];
    }
    // passem mesura a string
    if (!empty($concept)) {
        $q = db_query ("SELECT VALOR FROM `$taula_mesures` WHERE ID= '" . mysql_real_escape_string($concept) . "'");
        $r = db_fetch_array($q);
        $concept = $r['VALOR'];
    }
    // passem població a string
    if (!empty($population)) {
        $q = db_query ("SELECT VALOR FROM `$taula_poblacio` WHERE ID= '" . mysql_real_escape_string($population) . "'");
        $r = db_fetch_array($q);
        $population = $r['VALOR'];
    }
    // passem edat a string
    if (!empty($age)) {
        $q = db_query("SELECT VALOR FROM `$taula_edats` WHERE ID= '" . mysql_real_escape_string($age) . "'");
        $r = db_fetch_array($q);
        $age = $r['VALOR'];
    }
    // passem idioma a string
    if (!empty($language)) {
        $q = db_query ("SELECT IDIOMA FROM `$taula_idiomes` WHERE ID= '" . mysql_real_escape_string($language) . "'");
        $r = db_fetch_array($q);
        $language = $r['IDIOMA'];
    }

    // detectem ordenació actual
    $ac = $sc = $tc = $ic = $pc = '';
    if (isset($_GET['ordenar']) and isset($_GET['orden'])) {
        if ($_GET['orden'] == 'asc') {
            if ($_GET['ordenar'] == 'autor') $ac = ' sortDown';
            if ($_GET['ordenar'] == 'siglas') $sc = ' sortDown';
            if ($_GET['ordenar'] == 'titulo') $tc = ' sortDown';
            if ($_GET['ordenar'] == 'idioma') $ic = ' sortDown';
            if ($_GET['ordenar'] == 'pais') $pc = ' sortDown';
        }
        else {
            if ($_GET['ordenar'] == 'autor') $ac = ' sortUp';
            if ($_GET['ordenar'] == 'siglas') $sc = ' sortUp';
            if ($_GET['ordenar'] == 'titulo') $tc = ' sortUp';
            if ($_GET['ordenar'] == 'idioma') $ic = ' sortUp';
            if ($_GET['ordenar'] == 'pais') $pc = ' sortUp';
        }
    }

    if ($num_resultats > 0) {
        $html = '
                <div class="broken border clearfix">
                    <p>' . $text_resultats . ' <strong>' . ($inici+1) . ' a ' . $fi . '</strong> ' . $text_total . ' <strong>' . $num_resultats . '</strong> '.$text_utilitzant.':</p>
                    <p>
                        ' . (!empty($cercaText ) ? '&bull; Palabras: <strong>"' . htmlspecialchars($cercaText ) .'"</strong> &nbsp; ' : '') . '
                        ' . (!empty($idCuest) ? '&bull; Número de cuestionario: <strong>"' . htmlspecialchars($idCuest) .'"</strong> &nbsp; ' : '') . '
                        ' . (!empty($content) ? '&bull; Contenido: <strong>"' . htmlspecialchars($content) .'"</strong> &nbsp; ' : '') . '
                        ' . (!empty($illness) ? '&bull; Enfermedad: <strong>"' . htmlspecialchars($illness) .'"</strong> &nbsp; ' : '') . '
                        ' . (!empty($concept) ? '&bull; Concepto: <strong>"' . htmlspecialchars($concept) .'"</strong> &nbsp; ' : '') . '
                        ' . (!empty($age) ? '&bull; Edad: <strong>"' . htmlspecialchars($age) .'"</strong> &nbsp; ' : '') . '
                        ' . (!empty($population) ? '&bull; Género: <strong>"' . htmlspecialchars($population) .'"</strong> &nbsp; ' : '') . '
                        ' . (!empty($language) ? '&bull; Idioma: <strong>"' . htmlspecialchars($language) .'"</strong> &nbsp;' : '') . '
                    </p>
                </div>
                <table summary="Resultados de la búsqueda de cuestionarios" id="sortable">
                    <thead>
                        <tr>
                            <th class="sortable' . $ac . '">
                                <a href="'.$_SERVER['PHP_SELF'].'?'.$urlParams.'&amp;ordenar=autor&amp;orden='.$nOrdre.'">
                                    <span>Autor / adaptación</span>
                                </a>
                            </th>
                            <th class="sortable' . $sc . '">
                                <a href="'.$_SERVER['PHP_SELF'].'?'.$urlParams.'&amp;ordenar=siglas&amp;orden='.$nOrdre.'">
                                    <span>Siglas</span>
                                </a>
                            </th>
                            <th class="sortable' . $tc . '">
                                <a href="'.$_SERVER['PHP_SELF'].'?'.$urlParams.'&amp;ordenar=titulo&amp;orden='.$nOrdre.'">
                                    <span>Título</span>
                                </a>
                            </th>
                            <th class="sortable' . $pc . '">
                                <a href="'.$_SERVER['PHP_SELF'].'?'.$urlParams.'&amp;ordenar=pais&amp;orden='.$nOrdre.'">
                                    <span>País</span>
                                </a>
                            </th>
                            ';
        if ($where == 'AND VERSION = 1') {
            $html .= '
                            <th>+ Versiones</th>';
        }
        else {
            /*$html .= '
                            <th class="sortable' . $pc . '">
                                <a href="'.$_SERVER['PHP_SELF'].'?'.$urlParams.'&amp;ordenar=pais&amp;orden='.$nOrdre.'">
                                    <span>País</span>
                                </a>
                            </th>';*/
        }
        $html .= '
                        </tr>
                    </thead>
                    <tbody>';
        return $html;
    }
    else {
        return;
    }

}

// text quan no hi ha resultats
function no_result($cerca)
{

    if (function_exists('text_no_result')) {
        ob_start();
        text_no_result();
        $text_no_result = ob_get_contents();
        ob_end_clean();
        if ($text_no_result != '') {
            return $text_no_result;
        }
    }
    return '
            <p class="cerca_noresult"><strong>No se ha encontrado ningún cuestionario que coincida con los criterios de búsqueda introducidos.</strong></p>
            <p>Por favor asegúrese que:</p>
            <ul class="cerca_suggeriment">
                <li>la búsqueda continene al menos 3 carácteres.</li>
                <li>ha escrito correctamente los términos que quería buscar.</li>
                <li>lo intenta otra búsqueda utilitzando términos similares.</li>
            </ul>
    ';

}

// mostra element individual de la cerca
function element_cerca($ID, $ID_CUEST, $NOM_CAST, $SIGLES, $AUTORS_ORIGINAL, $IDIOMA_CAST, $PAIS, $link)
{

    global $CONFIG_NOMCARPETA, $taula_descarregables, $taula_questionaris, $dTypes, $where;

    if (empty($AUTORS_ORIGINAL)) { $AUTORS_ORIGINAL = 'No indicado'; }
    if (empty($IDIOMA_CAST)) { $IDIOMA_CAST = 'No indicado'; }
    if (empty($PAIS)) { $PAIS = 'No indicado'; }

    // mirem de quins descarregables disposa
    $dQ = db_query ("
            SELECT TIPO
            FROM `$taula_descarregables`
            WHERE ID_CUEST='$ID' AND VISIBLE = 1
            ORDER BY TIPO ASC
        ");
    if (db_num_rows($dQ) > 0) {
        $descarregables = array();
        while ($dR = db_fetch_array($dQ)) {
            // si és 'Otros' no hi ha icona
            if ($dR['TIPO'] != 8) {
                $descarregables[] = $dR['TIPO'];
            }
        }
    }
    else { $descarregables = false; }

    $elementHTML = '
                        <tr>
                            <td>' . htmlspecialchars($AUTORS_ORIGINAL) . '</td>
                            <td><a href="' . $link . '">' . htmlspecialchars($SIGLES). '</a></td>
                            <td>';
    if ($descarregables) {
        $elementHTML .= '
                                <ul class="options">';
        foreach ($descarregables as $tipo) {
            $elementHTML .= '<li><img src="' . $CONFIG_NOMCARPETA . '/media/img/bt_dl_' . $tipo . '.png" alt="' . $dTypes[$tipo] . '" /></li>';
        }
        $elementHTML .= '</ul>';
    }
    $elementHTML .= '
                                <a href="' . $link . '">' . htmlspecialchars($NOM_CAST) . '</a>
                            </td>';
    // si s'estan mostrant tots, indiquem si té més versions o no
    if ($where == 'AND VERSION = 1') {
        $ovQuery = db_query("
                SELECT ID
                FROM `$taula_questionaris`
                WHERE
                    ID_CUEST = '$ID_CUEST'
            ");
        if (db_num_rows($ovQuery) > 1) {
            $otherVersions = '<a href="buscar.html?ID_CUEST=' . htmlspecialchars($ID_CUEST) . '">Ver</a>';
        }
        else {
            $otherVersions = '-';
        }
        $elementHTML .= '
                            <td>' . $otherVersions . '</td>';
    }
    else {
        $elementHTML .= '
                            <td>' . htmlspecialchars($PAIS) . '</td>';
    }
    $elementHTML .= '
                        </tr>';

    return $elementHTML;

}

// codi útil vvv
$dirs = array();

$result = db_query("
        SELECT
            ID,
            ID_CUEST,
            NOM_CAST,
            NOM_ORIGINAL,
            IDAUTORES_CAST,
            SIGLAS,
            IDIOMA_CAST,
            IDIOMA_ORIGINAL,
            PAIS,
            CONTENIDO,
            ENFERMEDAD,
            POBLACION,
            EDAD,
            MEDIDA
            $fieldsSorting
        FROM `$taula_questionaris`
        WHERE
            ECLASS = 1
            AND STATUS = 1
            $where
            $fieldsOrderBy
    "); // l'ordre s'altera posteriorment
            $resultats = db_num_rows($result);

            /* tractar cada coincidencia */
            while($row = db_fetch_array($result)) {
                // si s'ha indicat algun text, cercar coincidències
                if (!empty($cerca)) {
                    $total = str_incounter($cerca, strip_tags($row['NOM_ORIGINAL']));
                    $total += str_incounter($cerca, strip_tags($row['NOM_CAST']));
                    $total += str_incounter($cerca, strip_tags($row['SIGLAS']));
                }
                else {
                    $total = 1;
                    if (!empty($content)) {
                        if (strpos($row['CONTENIDO'], '"' . $content . '"' ) !== false) { $total++; }
                    }
                    if (!empty($illness)) {
                        if (strpos($row['ENFERMEDAD'], '"' . $illness . '"' ) !== false) { $total++; }
                    }
                    if (!empty($concept)) {
                        if (strpos($row['MEDIDA'], '"' . $concept . '"' ) !== false) { $total++; }
                    }
                    if (!empty($age)) {
                        if (strpos($row['EDAD'], '"' . $age . '"' ) !== false) { $total++; }
                    }
                    if (!empty($population)) {
                        if (strpos($row['POBLACION'], '"' . $population . '"' ) !== false) { $total++; }
                    }
                    if (!empty($language)) {
                        if ($row['IDIOMA_CAST'] == $language) { $total++; }
                        if ($row['IDIOMA_ORIGINAL'] == $language) { $total++; }
                    }
                }

                // obtenim string autors adaptació
                $authors = unserialize($row['IDAUTORES_CAST']);
                if (is_array($authors) and count($authors) > 0) {
                    $authorsWhere = array();
                    foreach ($authors as $authorID) { $authorsWhere[] = "ID = $authorID"; }
                    $authorsQuery = db_query ("
                SELECT NOM
                FROM `$taula_autors`
                WHERE " . implode(' OR ', $authorsWhere) . "
            ");
                    $authorsArray = array();
                    while ($authorRow = db_fetch_array($authorsQuery)) {
                        $authorsArray[] = $authorRow['NOM'];
                    }
                }
                else {
                    $authorsArray = array('Información en proceso de búsqueda');
                }

                if(empty($authorsArray)){
                    $authorsArray = array('Información en proceso de búsqueda');
                }
                //$authorsString = implode(', ', $authorsArray);
                //Només el primer autor
                $authorsString = $authorsArray[0];

                // obtenim strings idioma original i pais
                $langCountryQuery = db_query("
            SELECT
                `$taula_idiomes`.IDIOMA AS IDIOMA,
                `$taula_paisos`.PAIS AS PAIS
            FROM `$taula_idiomes`, `$taula_paisos`
            WHERE
                `$taula_idiomes`.ID = $row[IDIOMA_CAST]
                AND `$taula_paisos`.ID = $row[PAIS]
        ");
                $langCountryRow = db_fetch_array($langCountryQuery);

				//Valors per defecte
				$titol = trim($row['NOM_CAST']) == '' ? trim($row['NOM_ORIGINAL']) : trim($row['NOM_CAST']);
				$idioma = $langCountryRow['IDIOMA'] == 0 ? 'Castellano (España)' : $langCountryRow['IDIOMA'];
				$pais = is_null($langCountryRow['PAIS']) ? 'España' : $langCountryRow['PAIS'];

				$titolurl=$CONFIG_NOMCARPETA . '/buscador/' . $row['ID'] . '/' . sanitize_title($titol);

				$file = element_cerca(
                $row['ID'],
                $row['ID_CUEST'],
                $titol,
                $row['SIGLAS'],
                $authorsString,
                $idioma,
                $pais,
                /*$CONFIG_NOMCARPETA . '/buscador/ver.html?ID=' . $row['ID']*/
                $titolurl
                );

                $dirs[] = array(
                $total,
                $file,
                $authorsString,
                $row['SIGLAS'],
                $row['NOM_CAST'],
                $langCountryRow['IDIOMA'],
                $langCountryRow['PAIS']
                );

            }

            if (count($dirs) == 0) {
                echo escriu_capcelera(
                0,
                $cerca,
                $idCuest,
                $content,
                $illness,
                $concept,
                $age,
                $population,
                $language
                );
                echo no_result($cerca);
                return;
            }

            // ordenar resultats
            $ordenar = isset($_GET['ordenar']) ? $_GET['ordenar'] : '';
            // per autor
            if ($ordenar == 'autor') {
                usort($dirs, 'cmpAutor');
            }
            // per sigles
            elseif ($ordenar == 'siglas') {
                usort($dirs, 'cmpSiglas');
            }
            // per títol
            elseif ($ordenar == 'titulo') {
                usort($dirs, 'cmpTitulo');
            }
            // per idioma
            elseif ($ordenar == 'idioma') {
                usort($dirs, 'cmpIdioma');
            }
            // per pais
            elseif ($ordenar == 'pais') {
                usort($dirs, 'cmpPais');
            }
            // segons cerca (per defecte)
            else {
                // sql query managed
            }
            if (isset($_GET['orden']) and $_GET['orden'] == 'desc') {
                $dirs = array_reverse($dirs);
                $orden = 'desc';
            }
            else {
                $orden = 'asc';
            }

            $num_resultats = count($dirs);
            $numpages = (int)ceil($num_resultats / $MAX_ELEM_PAGE);
            $inici = ($pag - 1) * $MAX_ELEM_PAGE;
            $fi = $inici + $MAX_ELEM_PAGE;
            if ($fi > $num_resultats) {
                $fi = $inici + ($num_resultats % $MAX_ELEM_PAGE);
            }

            // capçalera
            $resultat = escriu_capcelera(
            $num_resultats,
            $cerca,
            $idCuest,
            $content,
            $illness,
            $concept,
            $age,
            $population,
            $language,
            $inici,
            $fi
            );

            // cos
            for($i = $inici; $i < $fi; $i++) {
                $resultat .= $dirs[$i][1];
            }

            if (!isset($text_anterior) || $text_anterior == '') {
                $text_anterior = 'Anterior';
            }
            $anterior = '&nbsp;';
            if ($pag > 1) {
                $anterior = '<a href="'.$_SERVER['PHP_SELF'].'?'.$urlParams.'&amp;ordenar='.$ordenar.'&amp;orden='.$orden.'&amp;pag='.($pag-1).'">'.$text_anterior.'</a>';
            }

            if (!isset($text_seguent) || $text_seguent == '') {
                $text_seguent = 'Siguiente';
            }
            $seguent = '&nbsp;';
            if ($pag < $numpages) {
                $seguent = '<a href="'.$_SERVER['PHP_SELF'].'?'.$urlParams.'&amp;ordenar='.$ordenar.'&amp;orden='.$orden.'&amp;pag='.($pag+1).'">'.$text_seguent.'</a>';
            }
            $links = array();
            for($i = 1; $i <= $numpages; $i++) {
                if ($i == $pag) {
                    $links[] = '<li class="current"><a href="'.$_SERVER['PHP_SELF'].'?'.$urlParams.'&amp;ordenar='.$ordenar.'&amp;orden='.$orden.'&amp;pag='.$i.'"><strong>'.$i.'</strong></a></li>';
                }
                else {
                    $links[] = '<li><a href="'.$_SERVER['PHP_SELF'].'?'.$urlParams.'&amp;ordenar='.$ordenar.'&amp;orden='.$orden.'&amp;pag='.$i.'">'.$i.'</a></li>';
                }
            }
            $llista_pag = implode('', $links);

            // peu
            $resultat .= '
                    </tbody>
                </table>

                <div class="pager clearfix">
                    <span class="next">'.$seguent.'</span>
                    <span class="previous">'.$anterior.'</span>
                    <ul>'.$llista_pag.'</ul>
                </div>';

            echo $resultat;

            ?>