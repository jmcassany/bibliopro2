<?php

// $Id: chmod.php 148 2008-03-26 20:01:18Z cbrianso $
$dirs = array(
    'gif',
    'pdf',
    'arxius',
    'imatges'
    );
$basepath = dirname(__FILE__);

function searchFiles($path = '', $exclude = array()) {
    global $basepath;
    $realPath = $basepath . '/' . $path;
    $current_dir = opendir($realPath);

    while ($entryname = readdir($current_dir)) {

        if ($entryname == '.' || $entryname == '..' || $entryname == '.svn' || in_array($entryname, $exclude)) {
            continue;
        } elseif (is_dir($realPath . '/' . $entryname)) {
            echo $realPath . '/' . $entryname . '<br>';
            var_dump(chmod($realPath . '/' . $entryname, 0777));
            searchFiles($path . '/' . $entryname, $exclude);
        } else {
            echo $realPath . '/' . $entryname . '<br>';
            var_dump(chmod($realPath . '/' . $entryname, 0666));
        }
    }
    closedir($current_dir);

    return;
}

foreach($dirs as $dir) {
    searchFiles('upload/' . $dir, array(
        '.htaccess'
    ));

    //  echo $basepath.'/upload/'.$dir.'<br>';

}

/* vim: set fenc=utf-8 et ts=4 sw=4 autoindent smartindent : */
?>
