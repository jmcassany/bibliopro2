<?php
include_once '../../selconfig.php';
include_once 'config.php';

$ID = $_POST['ID'];
$CONFIRM = $_POST['CONFIRM'];

accessCheckLevel(2, $CONFIG_PRE_NOMCARPETA.'/admin/');
function accessCheckLevel($level,$url){
    global $level_user;

    $level_user = $_SESSION['access']['level'];

    if($level_user >= $level){
        return true;
    }else{
        header("Location: $url");
        exit;
    }
}

// --------------------
// PARAMETERS DEFAULT
// --------------------

if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
if (empty($CLASS))      { $CLASS=$DEFAULT_CLASS; }

if (empty($CONFIRM)) { echo "<B>Error: No s'ha rebut el codi de confirmació.</B><br><br><a href=\"javascript:history.back();\">Tornar</a>\n"; exit; }

// ------------------
// CARDS INSTANTATION
// ------------------

$dbCards = new dbCards($CARDS_TABLE);
if (!$dbCards->Ok) { echo "<B>Error: No s'ha pogut crear dbCards.</B><br><br><a href=\"javascript:history.back();\">Tornar</a>\n"; exit; }

// ----------------
// CARDS DELETION
// ----------------

if ($CONFIRM!='TRUE')
{ echo "<B>Incorrecte:Per a poder borrar s'ha d'activar la confirmació</B><br><a href=\"javascript:history.back();\">Tornar</a>\n";  exit; }
else
{
    // fem un loop per les variables POST per detectar les CHECK_?
    while ( list($key, $value)=each($_POST) )
    {
        if (strpos($key,'CHECK_')===false)
        {   // no fem res
        }
        else
        {   // esborrem el thread N del forum F
            $n=substr($key,6,4);

            $dbCards->deleteCard($n);
            //echo ("El registre $n ha estat borrat.<br>");
        }
    } // end while
     
} // end else

// -----------
// REDIRECTION
// -----------

// Return URL
//eval("\$url= \"$CARDS_URLDELETE\";");
echo header("Location:index.php");

?>