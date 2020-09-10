<?php
  require_once ('config_admin.inc');


  /*obte els parametres*/

    $url = '';
    if (!empty($_POST['url'])) {
      $url = $_POST['url'];
    }
    else if (!empty($_GET['url'])) {
      $url = $_GET['url'];
    }

    $action = '';
    if (!empty($_POST['action'])) {
      $action = $_POST['action'];
    }
    else if (!empty($_GET['action'])) {
      $action = $_GET['action'];
    }

    /*sortir de sistema*/
    if ($action == 'logout') {
        /*insertar registre d'accions*/
        register_add(t('registrylogout'), accessGetLogin());
        accessLogout();
        htmlPageLogin(0,'');
    }

    /*cap acció, mostrar fromulari d'entrada*/
    if ($action != t('loginbutton').' »') {
        htmlPageLogin(0, $url);
    }

    /*no hi ha login o password, mostrar formulari*/
    if ((empty($_POST['LOGIN'])) || (empty($_POST['PASSWD'])) ) {
        htmlPageLogin(1, $url);
    }

    $LOGIN = $_POST['LOGIN'];
    $PASSWD = $_POST['PASSWD'];


    /*començar validació*/
    $Users = new dbUsers();
    if (!$Users->Ok) {
      htmlPageBasicError(t('errordbusers'));
    }

    /*obtenir les dades de l'usuari*/
    $user = $Users->readUser($LOGIN);
    if (!$user) {
        /*usuari no existeix*/
        /*insertar registre d'accions*/
        register_add(t('registryloginnotexist'), $LOGIN);
        htmlPageLogin(1, $url);
    }
    if ($ldap_active) {
      $value = $user['LOGIN'];
    }
    else {
      $value = $LOGIN;
    }

    if (!$Users->validateUser($value, $PASSWD)) {
        /*usuari no existeix*/
        /*insertar registre d'accions*/
        register_add(t('registryloginnotexist'), $LOGIN);
        htmlPageLogin(1, $url);
    }

    $group = strip_tags($user['USERLEVEL']);
//    $PASSWDOK = strip_tags($user['PASSWD']);
    $STATUS = strip_tags($user['STATUS']);
    $EXPIRATION = strip_tags($user['EXPIRATION']);
    $LOGIN = strip_tags($user['LOGIN']);
    $EMAIL = strip_tags($user['EMAIL']);
    $REALNAME = strip_tags($user['REALNAME']);
    /* Si està inactiu el fem fora, si està actiu o en espera pot entrar. */
    if ($STATUS=='1') {
        accessLogout(); // per si un cas no era ell
        /*insertar registre d'accions*/
        register_add(t('registryloginerrorstatus'), $LOGIN);

        htmlPageLogin(1, $url);
    }
    /* Si està caducat el fem fora */
    $limit=TOOLS_TimestampToInt($EXPIRATION);
    $now=TOOLS_TimestampToInt(TOOLS_GetTimestamp());
    if ($limit!=0 && $now>$limit) {
        accessLogout(); // per si un cas no era ell
        /*insertar registre d'accions*/
        register_add(t('registryloginerrorexpired'), $LOGIN);

        htmlPageLogin(1, $url);
    }
    /* es valida l'usuari */

    accessLogin($group, $LOGIN);
    accessSetValue('USER_EMAIL', $EMAIL);
    accessSetValue('USER_NAME', $REALNAME);

    //insertar registre d'accions
    register_add(t('registrylogin'), $LOGIN);
    //fi

    if (!empty($url)) {
      goto_url($url);
        exit;
    }
    goto_url('index.php');
?>
