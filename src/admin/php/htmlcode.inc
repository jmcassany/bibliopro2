<?php


/*retorna el codi de la part superior de
la pàgina de l'administrador*/
function htmlHeader() {
  global $CONFIG_URLADMIN, $CONFIG_URLBASE, $CONFIG_PATHADMIN;

  $content = '
<!-- CAPÇELERA -->
<table cellpadding="0" cellspacing="0" class="capadmin" summary="capÃ§elera">
  <tr>
    <td rowspan="2" class="logo">
      <img src="'.$CONFIG_URLADMIN.'/comu/logo.gif" alt="" />
    </td>
    <td class="info">
      <img src="'.$CONFIG_URLADMIN.'/comu/icon_user_blanc.gif" alt="Usuari" border="0" align="absmiddle" />'.accessGetLogin().'
    </td>
    <td class="info" style="text-align: right">
      <a href="'.$CONFIG_URLBASE.'" class="blanc10" target="_blank">'.t('headgoweb').'</a>
      &nbsp;|&nbsp;
      <a href="'.$CONFIG_URLADMIN.'/login.php?action=logout" class="blanc10" title="'.t('headcontent').'">'.t('logout').'<img src="'.$CONFIG_URLADMIN.'/comu/icon_tanca.gif" alt="'.t('headlogout').'" border="0" align="absmiddle" /></a>
    </td>
  </tr>
  <tr>
    <td class="links" colspan="2">
      <a href="'.$CONFIG_URLADMIN.'/index.php" class="negre10b" title="'.t('headcontent').'"><img src="'.$CONFIG_URLADMIN.'/comu/icon_continguts.gif" alt="'.t('headcontent').'" align="absmiddle" />'.t('headcontent').'</a>
';

  if (accessGroupPerm('users_read')) {
    $content .= '
      <a href="'.$CONFIG_URLADMIN.'/users/index.php" class="negre10b" title="'.t('headusers').'"><img src="'.$CONFIG_URLADMIN.'/comu/icon_gestio_usu.gif" alt="'.t('headusers').'" align="absmiddle" />'.t('headusers').'</a>
';
  }

  if (accessGroupPerm('folder_read')) {
    $content .= '
      <a href="'.$CONFIG_URLADMIN.'/carpetes/index.php" class="negre10b" title="'.t('headdir').'"><img src="'.$CONFIG_URLADMIN.'/comu/icon_carpeta.gif"  alt="'.t('headdir').'" align="absmiddle" />'.t('headdir').'</a>
';
  }

  if (accessGroupPerm('template_read')) {
    $content .= '
      <a href="'.$CONFIG_URLADMIN.'/plantilles/index.php" class="negre10b" title="'.t('headtemplate').'"><img src="'.$CONFIG_URLADMIN.'/comu/icon_gest_plantilles.gif"  alt="'.t('headtemplate').'"  align="absmiddle" />'.t('headtemplate').'</a>
';
  }

  if (accessGroupPerm('menu_read') && file_exists($CONFIG_PATHADMIN.'/moduls/menus')) {
    $content .= '
      <a href="'.$CONFIG_URLADMIN.'/moduls/menus/index.php" class="negre10b"  title="'.t('headmenu').'" ><img src="'.$CONFIG_URLADMIN.'/comu/icon_menus.gif" alt="'.t('headmenu').'" align="absmiddle" />'.t('headmenu').'</a>
';
  }

  if (accessGroupPerm('form_read')) {
    $content .= '
      <a href="'.$CONFIG_URLADMIN.'/formularis/index.php" class="negre10b" title="'.t('headform').'"><img src="'.$CONFIG_URLADMIN.'/comu/icon_formularis.gif" alt="'.t('headform').'" align="absmiddle" />'.t('headform').'</a>
';
  }

  $content .= '
      <a href="'.$CONFIG_URLADMIN.'/utilitats/index.php" class="negre10b"><img src="'.$CONFIG_URLADMIN.'/comu/icon_utilitats.gif" alt="'.t('utils').'" align="absmiddle" />'.t('utils').'</a>
    </td>
  </tr>
</table>
<!-- /CAPÇELERA -->
';
  return $content;
}

/*retorna el codi de la part inferior de
la pàgina de l'administrador*/
function htmlFoot() {
  global $CONFIG_URLABSADMIN;
  $content = '
<table class="peuadmin" cellpadding="0" cellspacing="0" summary="peu pÃ gina">
  <tr>
    <td class="top">
      <a href="#top"><img src="'.$CONFIG_URLABSADMIN.'/comu/pujar_houdini.gif" alt="'.t('totop').'" /></a>
    </td>
    <td class="credits">
      <a href="http://houdini.antaviana.net/" target="_blank"><img src="'.$CONFIG_URLABSADMIN.'/comu/peu_houdini.gif" alt="Houdini" /></a>
      '.t('foodproduct').'
      <a href="http://www.antaviana.net" target="_blank"><img src="'.$CONFIG_URLABSADMIN.'/comu/peu_antaviana.gif" alt="Can Antaviana" /></a>
      &copy; 2003-'.date('Y').'
    </td>
  </tr>
</table>
';
  return $content;
}



function htmlPageBasicError($error) {
  global $CONFIG_URLADMIN;

  $content = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
'.htmlMetas().'
</head>
<body style="background-color:#ffffff">
  <table cellpadding="0" cellspacing="0" border="0" style="border:solid #F66013 5px;padding:20px;width:350px;text-align:center">
    <tr>
      <td style="width:19px;vertical-align:top">
        <img src="'.$CONFIG_URLADMIN.'/comu/houdini_alerta.gif" width="19" height="31" alt="Alerta" border="0" />
      </td>
      <td class="grana" style="padding-left:10px;vertical-align:top">
';
  $content .= $error;
  $content .= '
<br /><br /><a href="javascript:history.back();" >
'.t('back').'
  </a>
     </td>
    </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" style="width:350px;text-align:center" >
    <tr>
      <td align="center" style="padding:5px;">
        <a href="http://houdini.antaviana.net/" target="_blank">
        <img src="'.$CONFIG_URLADMIN.'/comu/peu_houdini.gif" width="36" height="11" alt="Houdini" border="0">
        </a>
      </td>
    </tr>
  </table>
</body>
</html>
';

  echo $content;
  exit;
}

function htmlPageError($error, $url = array(), $nomLink = array()) {
  global $CONFIG_URLADMIN;

  $content = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
'.htmlMetas().'
</head>

<body style="background-color:#ffffff;padding:0px;margin:0px">

'.htmlHeader().'

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" style="width:760px;border:solid #0E449A 5px;margin:10px;padding:20px;">
  <tr>
    <td class="text" align="center">
<!-- PART CENTRAL DADES-->
      <table width="350" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td width="19" valign="top"><img src="'.$CONFIG_URLADMIN.'/comu/houdini_alerta.gif" width="19" height="31" alt="Error" border="0"></td>
          <td class="grana" style="padding-left:10px;" valign="top">
';

  $content .= $error;

  if(count($url) == 0) {
    $content .= '<br><br><a href="javascript:history.back();" ><b>'.t('back').'</b></a>';
  }
  else {
    foreach ($url as $key => $value) {
      if (!isset($nomLink[$key]) || $nomLink[$key] == '') {
        $nomLink[$key] = t('back').' '.t('to').' '.t('home');
      }
      $content .= '<br><br><a href="'.$value.'" ><b>'.$nomLink[$key].'</b></a>';
    }
  }

  $content .= '
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
'.htmlFoot().'
</body>
</html>
';

  echo $content;
  exit;
}

function filtreQuote($value) {
  return str_replace('"', '&quot;', $value);
}

/*retorna el codi de la capcelera html*/
function htmlMetas() {
  global $CONFIG_URLADMIN;
  $content = '
<title>Houdini v2.0</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<link rel="STYLESHEET" type="text/css" href="'.$CONFIG_URLADMIN.'/css/estils.css" />
<link rel="shortcut icon" href="'.$CONFIG_URLADMIN.'/comu/favicon.ico" type="text/icon" />
<meta name="lang" content="'.get_lang().'" />

<meta name="author" content="Can Antaviana SL. www.antaviana.com" />

<script type="text/javascript" src="'.$CONFIG_URLADMIN.'/js/basic-tools.js"></script>

<script type="text/javascript" src="'.$CONFIG_URLADMIN.'/js/jquery.pack.js"></script>

<style type="text/css">@import url('.$CONFIG_URLADMIN.'/js/jscalendar/calendar.css);</style>
<script type="text/javascript" src="'.$CONFIG_URLADMIN.'/js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="'.$CONFIG_URLADMIN.'/js/jscalendar/lang/calendar-ca.js"></script>
<script type="text/javascript" src="'.$CONFIG_URLADMIN.'/js/jscalendar/calendar-setup.js"></script>

';
  return $content;
}

function htmlPageLogin ($error, $url) {
  global $CONFIG_SITENAME, $CONFIG_URLADMIN;

  $content = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
'.htmlMetas().'
</head>
<body>

<table cellpadding="0" cellspacing="0" style="border:5px solid #F66013;width:760px">
    <tr>
        <td class="grisportada9" style="padding:20px;border-right:solid #F66013 1px;width:130px;vertical-align:top">
            <img src="'.$CONFIG_URLADMIN.'/comu/logo_houdini_psw.gif" alt="Houdini" />
            <br /><br />
            '.t('loginhoudini').'
        </td>
        <td style="padding:20px;vertical-align:top;width:630px">
            <img src="'.$CONFIG_URLADMIN.'/comu/logo.gif" alt="'.$CONFIG_SITENAME.'" />
            <div style="padding-top:10px;padding-bottom:10px;" class="blau11b">
                <img src="'.$CONFIG_URLADMIN.'/comu/kland_log.gif" alt="" align="absmiddle" />
                '.t('logintitle').'
            </div>

<form action="login.php" method="post">
            <table cellpadding="0" cellspacing="0" style="border:solid #CCCCCC 2px;">
                <tr>
                    <td colspan="2" class="text10" style="padding-top:20px;padding-bottom:10px;padding-left:20px;">
                        <span style="color:#FF9900">&#149;</span>
                      ';
  if ($error) {
    $content .= '
                        <span style="color:#990000;font-weight:bold;">'.t('loginerror').'</span><br />
                        &nbsp;
';
  }

  $content .= '
                      '.t('loginmessage').'
                    </td>

                </tr>
                <tr>
                    <td class="grisportada10" style="padding-bottom:10px;padding-left:20px;" valign="top">
                        <img src="'.$CONFIG_URLADMIN.'/comu/icon_user.gif" alt="Usuari" style="border:0;" align="absmiddle" />'.t('loginuser').'<br />
                        <input type="text" name="LOGIN" size="15" maxlength="15" class="formulari" style="width:150px" />
                    </td>
                    <td class="grisportada10"  style="padding-bottom:10px;padding-left:10px;padding-right:20px;" valign="top">
                        <img src="'.$CONFIG_URLADMIN.'/comu/icon_clau.gif" alt="Clau"  style="border:0;margin-bottom:3px;" align="absmiddle" />'.t('loginkey').'<br />
                        <input type="password" name="PASSWD" size="15" maxlength="15" class="formulari" style="width:150px" /></td>
                </tr>
                <tr>
                    <td colspan="2" class="text10" style="padding-bottom:20px;padding-left:20px;">
                        <input type="hidden" name="url" id="url" value="'.$url.'" />
                        <input type="submit" name="action" id="action" value="'.t('loginbutton').' »" class="botoportada" />
                    </td>
                </tr>
            </table>
</form>

        </td>
    </tr>
</table>
'.htmlFoot().'

</body>
</html>
';

  echo $content;
  exit;
}

?>
