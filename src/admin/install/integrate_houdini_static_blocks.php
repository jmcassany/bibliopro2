<?php

/*
Plugin Name: Integració blocks statics de Houdini
Plugin URI: http://wordpress.org/#
Description: Utilització de blocs statics de Houdini en el Wordpress
Author: Can Antaviana
Author: Xavi Solsona
Version: 1.5
Author URI: http://www.antaviana.cat
*/
define('HODINI_WP_FOLDER_INSTALATION', 'club/bloc');
define('HOUDINI_PATHBASE', substr(__FILE__, 0, -strlen(HODINI_WP_FOLDER_INSTALATION . '/wp-content/plugins/integrate_houdini_static_blocks.php')));
include HOUDINI_PATHBASE . 'config.php';
include HOUDINI_PATHBASE . 'admin/moduls/block/funcions.inc';
define('HOUDINI_PATH_STATIC_BLOCKS', $CONFIG_PATHBASE . '/admin/plantilles-web/block/');
define('HOUDINI_CONFIG_NOMCARPETA', $CONFIG_NOMCARPETA);
define('HOUDINI_CONFIG_SITENAME', 'Probike');
define('HOUDINI_CONFIG_URLBASE', 'http://www.probike.es');
define('HOUDINI_CONFIG_METAS_DESCRIPTION', '');
define('HOUDINI_CONFIG_METAS_KEYWORDS', '');
$array_menus = array(
    'MENUESQUERRA' => 'club',
    'MENUDRETA' => '',
    'MENUSUPERIOR' => ''
);
$situacio = '<a href="' . HOUDINI_CONFIG_NOMCARPETA . '/index.html" title="Portada">Portada</a> > <a href="' . HOUDINI_CONFIG_NOMCARPETA . '/club/index.html" title="Club">Club</a> > ';

function phpEval($html) {
    ob_start();
    eval(' ?>' . $html . '<?php ');
    $code = ob_get_contents();
    ob_end_clean();

    return $code;
}

function wp_houdini_static_block($block) {
    global $array_menus;
    $contingut = file_get_contents(HOUDINI_PATH_STATIC_BLOCKS . $block . '.html');

    // reemplacem blocks
    $contingut = block_pages($contingut);

    // reemplacem rutes
    $contingut = str_replace('|CONFIG_NOMCARPETA|', HOUDINI_CONFIG_NOMCARPETA, $contingut);
    $contingut = str_replace('|CONFIG_SITENAME|', HOUDINI_CONFIG_SITENAME, $contingut);
    $contingut = str_replace('|CONFIG_URLBASE|', HOUDINI_CONFIG_URLBASE, $contingut);
    $contingut = str_replace('|CONFIG_PATHBASE|', HOUDINI_CONFIG_PATHBASE, $contingut);

    // reemplacem metas
    $title = wp_title('', false);
    $title = $title != '' ? $title . ' | ' : '';
    $contingut = str_replace('|METAS_TITLE|', $title . get_bloginfo('name', 'display') . ' | ', $contingut);
    $contingut = str_replace('|METAS_DESCRIPTION|', HOUDINI_CONFIG_METAS_DESCRIPTION, $contingut);
    $contingut = str_replace('|METAS_KEYWORDS|', HOUDINI_CONFIG_METAS_KEYWORDS, $contingut);

    // reemplacem menus

    foreach($array_menus as $key => $nom_menu) {

        if ($nom_menu != '') {
            $contingut_menu = file_get_contents(HOUDINI_PATHBASE . 'media/menus/' . $nom_menu . '.inc');
            $contingut = str_replace('|' . $key . '|', $contingut_menu, $contingut);
        }
    }

    // reemplacem situacio
    $contingut = str_replace('|SITUACIO|', wp_houdini_situacio(false) , $contingut);
    $contingut = phpEval($contingut);
    echo $contingut;
}

function wp_houdini_situacio($display = true) {
    global $situacio;
    $contingut = $situacio . get_bloginfo('name', 'display');

    if ($display) {
        echo $contingut;
    } else {

        return $contingut;
    }
}
?>
