<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title>Houdini Instal·lació ...</title>
<link rel="stylesheet" href="install.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<div class="border">
<h2 >Houdini&nbsp; |&nbsp; Instal·lació</h2>
<h3>Copyright &#169; 2004 - Can Antaviana</h3>
</div>
<!-- <?php
/*
-->
<h1 id="phperror">El seu servidor no és capaç de gestionar fitxers php.
Comproveu el correcte funcionament del servidor avanç de continuar</h1>
<!-- */
?> -->
<?php

define('VERSIOPHP','4.2.0');
define('VERSIOMYSQL','4.3');
define('VERSIOPG','7.4');
define('VERSIOASPELL','0.50.3');
define('VERSIOGD','2.0');



$PATHLIB = dirname(dirname(dirname(__FILE__))).'/lib';

$include_path = ini_get('include_path');
if (substr(PHP_OS, 0, 3) == 'WIN') {
	ini_set('include_path', $include_path.';'.$PATHLIB);
} else {
	ini_set('include_path', $include_path.':'.$PATHLIB);
}

require_once('configdb.php');


///configuracio mysql servidor
include('formatting.php');
include('../config.php');
include_once ("database/database.inc");

$num_passos = 4;
$error = 0;

if (!isset($_POST['page'])) {
    $page = 1;
}
else {
  $page = $_POST['page'];
}
if ($page > $num_passos) {
  $page = 1;
}

$titols = array(
1=>'Benvingut a l\'instalació del Gestor de Continguts Houdini.',
2=>'Comprovació de la connexió amb la base de dades.',
3=>'Instalació taules base de dades.',
4=>'Finalització de la instalació'
);

function pas1() {
  global $db_url, $ldap_active;
  global $error;
  global $CONFIG_TITOLGRAFIC, $CONFIG_PATHADMIN;
  echo 'PHP està funcionant....<br /><br />';

  echo '<h4>PHP</h4>';
  echo 'Versió: '.phpversion().'<br />';
  if (version_compare(VERSIOPHP, phpversion(), ">")) {
     echo '<div class="error">La versió de php ha de ser superior a '.VERSIOPHP.'</div>';
     $error = 1;
  }
  else {
    echo '<span class="green">Versió correcte</span><br />';
  }

  echo '<br />';

  if (substr($db_url, 0, strpos($db_url, '://')) == 'mysql') {
    echo '<h4>Mysql</h4>';
    echo 'Versió programa: ';
    system('mysql --version', $retval);
    if ($retval) {
      echo '<span class="error">No es pot comprovar si el programa està instal·lat</span>';
    }
    echo '<br />';
    echo 'Recomenat >= '.VERSIOMYSQL.'<br />';

    if (!function_exists('mysql_connect')) {
      echo '<div class="error">El php no pot utilitzar funcions mysql, comprova que tingui l\'extenció estigui instalada</div>';
      $error = 1;
    }
    else {
      echo '<span class="green">Extenció activada</span><br />';
    }
    echo '<br />';
  }

  if (substr($db_url, 0, strpos($db_url, '://')) == 'pgsql') {
    echo '<h4>Postgres</h4>';
    echo 'Versió programa: ';
    system('psql --version', $retval);
    if ($retval) {
      echo '<span class="error">No es pot comprovar si el probrama està instal·lat</span>';
    }
    echo '<br />';
    echo 'Recomenat >= '.VERSIOPG.'<br />';

    if (!function_exists('pg_connect')) {
      echo '<div class="error">El php no pot utilitzar funcions postgres, comprova que tingui l\'extenció estigui instalada</div>';
      $error = 1;
    }
    else {
      echo '<span class="green">Extenció activada</span><br />';
    }
    echo '<br />';
  }

  if ($ldap_active) {
    echo '<h4>Ldap</h4>';
    if (!function_exists('ldap_connect')) {
      echo '<div class="error">El php no pot utilitzar funcions ldap, comprova que tingui l\'extenció estigui instalada</div>';
      $error = 1;
    }
    else {
      echo '<span class="green">Extenció activada</span><br />';
    }
    echo '<br />';
    echo '<h4>mhash</h4>';
    if (!function_exists('mhash')) {
      echo '<div class="error">El php no pot utilitzar funcions mhash necessaria per ldap, comprova que tingui l\'extenció estigui instalada</div>';
      $error = 1;
    }
    else {
      echo '<span class="green">Extenció activada</span><br />';
    }
    echo '<br />';

  }





  echo '<h4>Aspell (optatiu)</h4>';
  echo 'Versió programa: ';
  system('aspell --version', $retval);
  if ($retval) {
    echo '<span class="error">No es pot comprovar si el probrama està instal·lat</span>';
  }
  echo '<br />';
  echo 'Recomenat >= '.VERSIOASPELL;
  echo '<br /><br />';


  if (file_exists($CONFIG_PATHADMIN.'/moduls/view-rss')) {
    echo '<h4>Iconv (optatiu)</h4>';
    if (!function_exists('iconv')) {
      echo '<div class="error">El php no pot utilitzar la funció de conversió de caracters</div>';
    }
    else {
      echo '<span class="green">Extenció activada</span><br />';
    }
    echo '<br /><br />';
  }

  if (file_exists('../moduls/view-rss')) {
    echo '<h4>Iconv (optatiu)</h4>';
    if (!function_exists('iconv')) {
      echo '<div class="error">No podreu llegir fonts rss amb codificacions diferents dels de la vostra web</div>';
    }
    else {
      echo '<span class="green">Podreu llegir fonts rss amb codificacions diferents dels de la vostra web</span><br />';
    }
    echo '<br /><br />';
  }


  echo '<h4>GD (optatiu)</h4>';
  if (!function_exists('gd_info')) {
      echo '<div class="error">No podreu redimensionar les imatges</div>';
  }
  else {
    $gd = gd_info();
    echo 'Versió: '.$gd['GD Version'].'<br />';
    echo 'Recomenat >= '.VERSIOGD.'<br />';
    echo '<span class="green">Podreu redimensionar les imatges</span><br />';
    if ($CONFIG_TITOLGRAFIC=='1') {
      echo 'Suport de Freetype: ';
      if (!$gd['FreeType Support']) {
        echo '<span class="error">desactivat (no podeu utilitzar titol gràfic)</span><br />';
      }
      else {
        echo '<span class="green">Activat</span><br />';
      }
    }

  }
  echo '<br /><br />';


  echo 'Ruta: '.$_SERVER['SCRIPT_FILENAME'].'<br />';
  if (!$error) {
    echo 'Pot continuar....';
  }
}

function pas2() {
  global $db_url, $ldap_active, $ldap_server, $ldap_user, $ldap_password;
  global $error;
  // Data base connection
  $result = db_connect($db_url);

  if (!$result)
  {
    echo '<div class="error">
    No es pot establir la conexió amb la teva base de dades.<br />
    Comprova les dades del fitxer de configuració, i<br />
    comprova si la base de dades està creada.<br />
    Corregeix les dades, torna a pujar l\'arxiu i inicia de nou la instalació</div>';
    $error = 1;
  }
  else {
    echo '
    <div><span class="green">Bé.</span>&nbsp;&nbsp;S\'ha establert amb éxit la conexió amb el vostre servidor....</div>
    ';
  }
  db_close();

  if($ldap_active) {
    $ldap_error= true;
    $ldap_conn = @ldap_connect ($ldap_server);
    if ($ldap_conn) {
      if (@ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3 )) {
        if (isset($ldap_user) && isset($ldap_password)) {
          if (@ldap_bind ($ldap_conn, $ldap_user, $ldap_password)) {
            $ldap_error= false;
          }
        }
        else {
          if (@ldap_bind ($ldap_conn)) {
            $ldap_error= false;
          }
        }
      }
    }
    if ($ldap_error) {
      echo '<div class="error">
      No es pot establir la conexió amb el servidor ldap.<br />
      Comprova les dades del fitxer de configuració<br />
      Corregeix les dades, torna a pujar l\'arxiu i inicia de nou la instalació</div>';
      $error = 1;
    }
    else
    {
      echo '
    <div><span class="green">Bé.</span>&nbsp;&nbsp;S\'ha establert amb éxit la conexió amb el vostre servidor ldap....</div>
    ';
    }


  }

}

function pas3() {
  global $db_url;
  $result = db_connect($db_url);

  $filename = 'database_'.substr($db_url, 0, strpos($db_url, '://')).'.sql';
  $file = @fopen($filename,'r');
  if (!$file) {
    echo '<div class="error">No s\'ha trobat el fitxer de creació de la base de dades seleccionada<br />
    Comprova que el teu tipus de base de dades està soportat</div>';
    $error = 1;
    return;
  }
  $query = fread($file, filesize($filename));
  fclose($file);

  if (substr($db_url, 0, strpos($db_url, '://')) == 'mysql') {

    $trossos = explode(';', $query);
    foreach($trossos as $value) {
      $value = chop($value);
      if (!empty($value)) {
        db_query($value);
      }
    }

  }
  else {
    db_query($query);
  }

  if (db_error() == '') {
    echo 'Les taules de la base de dades han estat creades correctament';
  }
  else {
    $error = 1;
    echo 'No s\'han pogut crear les taules de la base de dades, comprova que el fitxer amb la definició són correctes<br />';
    echo db_error();

  }
  db_close();
}

function pas4() {
  echo '
<div class="green">Bé!</div>
<div>
<b>Houdini s\'ha instalat correctament</b>
<hr size="1" color="#cccccc">
<strong>IMPORTANT: eliminar la carpeta install.</strong>
</div>
';

}

?>
<div class="dgrey">
<?php
for ($i=1; $i<=$num_passos; $i++) {
  if ($page == $i) {
    echo '<span class="red">PAS '.$i.'</span>';
  }
  else {
    echo 'PAS '.$i;
  }
  echo '&nbsp;&nbsp;';
}
?>
</div>

<h4><?php echo $titols[$page] ?></h4>
<form action="install.php" method="post">
<div>

<?php

$function = 'pas'.$page;
$function();

?>

</div>
<?php
if (!$error && $page < $num_passos) {
?>
<div>
<input type="hidden" name="page" value="<?php echo $page+1; ?>" />
<br />
<input type="submit" value="Pas <?php echo $page+1; ?> &gt;&gt;" />
</div>
<?php }
else if ($page == $num_passos) {
?>
<a id="check_perm" style="display:block;width:200px;margin-top:10px;" href="check_perm.php">Comprovar permissos</a>
<?php
}
?>
</form>


</body>
</html>
