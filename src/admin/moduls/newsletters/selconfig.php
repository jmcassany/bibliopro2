<?php
$pathBase = $_SERVER['DOCUMENT_ROOT'];

if(file_exists($pathBase . '/admin/config_admin.php')){
    //Houdini3
    require_once $pathBase . '/admin/config_admin.php';
    accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes
    require_once $pathBase . '/admin/moduls/newsletters/configv3.inc';
    $LOGIN = accessGetLogin();
} else {
    //Houdini2
    require_once $pathBase . '/admin/config_admin.inc';
    accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes
    require_once $pathBase . '/admin/moduls/newsletters/config.inc';
    $LOGIN = accessGetLogin();
}
?>