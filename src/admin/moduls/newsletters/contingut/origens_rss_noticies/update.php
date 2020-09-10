<?php
include_once '../../selconfig.php';
include_once 'config.php';
 
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
if (empty($ID))     { echo "<B>Error: No se ha recibido el codigo de card.</B><br>\n"; exit; }
 
if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
if (empty($CLASS))      { $CLASS=$DEFAULT_CLASS; }
 
 
// ------------------
// CARDS INSTANTATION
// ------------------
$dbCards = new dbCards($CARDS_TABLE);
if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }
 
 
// -------------
// DATA UPDATING
// -------------
 
// DATA PREPARATION
unset($data);
// Passem llista als camps i mirem quins em rebut per POST METHOD
foreach ($CARDS_FIELDS as $name=>$field)
{
    list ($scope, $type, $style) = $field;
    if (isset($_POST[$name]) || isset($_POST[$name.'_DAY']))
    {
        if ($type=='NUMBER' || $type=='ITEM' )
        { $data[$name]=(int)trim($$name); }
        if ($type=='CHAR' || $type=='TEXT' || $type=='LIST')
        { $data[$name]= trim($$name); }
        if ($type=='FLAG')
        {
            $data[$name]='';
            for ($i=0; $i<strlen($$name); $i++)
            {
                if (isset(${$name.'_'.$i}))
                { $data[$name].='1'; }                else
                { $data[$name].='0'; }
            }
        }
        if ($type=='DATE')
        {
            $year  = trim(${$name.'_YEAR'});
            $month = trim(${$name.'_MONTH'});
            $day   = trim(${$name.'_DAY'});
            $hour  = trim(${$name.'_HOUR'});
            $min   = trim(${$name.'_MIN'});
            $sec   = trim(${$name.'_SEC'});
            $data[$name]="$year-$month-$day $hour:$min:$sec";
        }
    } // end if
} // end foreach
 
 
// actualitzem les dades
$dbCards->updateCard( $ID, $data );
if (!$dbCards->Ok) { echo "<B>Error: No se ha podido actualizar el registro.</B><br>".$Cards->Error."\n"; exit; }
 
 
// -----------
// REDIRECTION
// -----------
// Return URL
//   eval("\$url= \"$CARDS_URLUPDATE\";");
header("Location: index.php");
 
?>
