<?php
include_once '../../selconfig.php';
include 'config.php';
$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

if($_POST['CAP'] == '' || $_POST['SKIN'] == '' || $_POST['idCam'] == ''){
    if($_POST['idCam'] != ''){
        if($_POST['CAP'] == '' && $_POST['SKIN'] == ''){
            header('Location:nou.php?IdCam=' . $_POST['idCam'] . '&error=3');
            exit;
        }
        if($_POST['CAP'] == ''){
            header('Location:nou.php?IdCam=' . $_POST['idCam'] . '&error=2&skin=' . $_POST['SKIN']);
            exit;
        }
        if($_POST['SKIN'] == ''){
            header('Location:nou.php?IdCam=' . $_POST['idCam'] . '&error=1&cap=' . $_POST['CAP']);
            exit;
        }
    } else {
        htmlNewsletterError('Els paràmetres introduïts no són correctes');
        exit;
    }
}
//miro IDNL de l'últim newsletter ja existent...
$result = mysql_query("select MAX(IDNL) from " . TAULA_NEWSLETTERS);
$num_rows = mysql_num_rows($result);
if ($num_rows != 0) {
    $row = mysql_fetch_array($result);
    $IDNL = $row[0]+1;
}
else {
    $IDNL = '1';
}

// --------------------
// PARAMETERS DEFAULT
// --------------------
if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
if (empty($CLASS))      { $CLASS=$DEFAULT_CLASS; }
if (empty($SKIN))       { $SKIN=$DEFAULT_SKIN; }
if (empty($CATEGORY1))  { $CATEGORY1=$DEFAULT_CATEGORY1; }
if (empty($CATEGORY2))  { $CATEGORY2=$DEFAULT_CATEGORY2; }
if (empty($STATUS))     { $STATUS=$DEFAULT_STATUS; }
if (empty($VISIBILITY)) { $VISIBILITY=$DEFAULT_VISIBILITY; }

$timestamp = TOOLS_GetTimestamp();

if (empty($CREATION_SEC))  { $CREATION_SEC   = TOOLS_TimestampToSec($timestamp); }
if (empty($CREATION_MIN))  { $CREATION_MIN   = TOOLS_TimestampToMin($timestamp); }
if (empty($CREATION_HOUR)) { $CREATION_HOUR  = TOOLS_TimestampToHour($timestamp); }
if (empty($CREATION_DAY))  { $CREATION_DAY   = TOOLS_TimestampToDay($timestamp); }
if (empty($CREATION_MONTH)){ $CREATION_MONTH = TOOLS_TimestampToMonth($timestamp); }
if (empty($CREATION_YEAR)) { $CREATION_YEAR  = TOOLS_TimestampToYear($timestamp); }

if (empty($START_SEC))     { $START_SEC      = 00; } // $CREATION_SEC + 0; }
if (empty($START_MIN))     { $START_MIN      = 00; } // $CREATION_MIN + 0; }
if (empty($START_HOUR))    { $START_HOUR     = 00; } // $CREATION_HOUR + 0; }
if (empty($START_DAY))     { $START_DAY      = $CREATION_DAY + 0; }
if (empty($START_MONTH))   { $START_MONTH    = $CREATION_MONTH + 0; }
if (empty($START_YEAR))    { $START_YEAR     = $CREATION_YEAR + 0; }

if (empty($END_SEC))       { $END_SEC        = 59; } // $START_SEC + 0; }
if (empty($END_MIN))       { $END_MIN        = 59; } // $START_MIN + 0; }
if (empty($END_HOUR))      { $END_HOUR       = 23; } // $START_HOUR + 0; }
if (empty($END_DAY))       { $END_DAY        = $START_DAY + 0; }
if (empty($END_MONTH))     { $END_MONTH      = $START_MONTH + 0; }
if (empty($END_YEAR))      { $END_YEAR       = $START_YEAR + 1; }

if (empty($TOTALVIEWS))    { $TOTALVIEWS  = 0; }
if (empty($TOTALVOTES))    { $TOTALVOTES  = 0; }
if (empty($TOTALSCORE))    { $TOTALSCORE  = 0; }
if (empty($TOTALPOINTS))   { $TOTALPOINTS = 0; }

// ------------------
// CARDS INSTANTATION
// ------------------
$dbCards = new dbCards($CARDS_TABLE);
if (!$dbCards->Ok) { htmlNewsletterError($messages["error2"]); exit; }

// --------------------
// DATA PREPARATION
// --------------------
unset($data);

$data['CLASS']      = (int)trim($CLASS);
$data['SKIN']       = (int)trim($SKIN);
$data['CATEGORY1']  = (int)trim($CATEGORY1);
$data['CATEGORY2']  = (int)trim($CATEGORY2);
$data['STATUS']     = (int)trim($STATUS);
$data['VISIBILITY'] = (int)trim($VISIBILITY);

$CREATION_YEAR  = (int)trim($CREATION_YEAR);
$CREATION_MONTH = (int)trim($CREATION_MONTH);
$CREATION_DAY   = (int)trim($CREATION_DAY);
$CREATION_HOUR  = (int)trim($CREATION_HOUR);
$CREATION_MIN   = (int)trim($CREATION_MIN);
$CREATION_SEC   = (int)trim($CREATION_SEC);
$data['CREATION'] = "$CREATION_YEAR-$CREATION_MONTH-$CREATION_DAY $CREATION_HOUR:$CREATION_MIN:$CREATION_SEC";

$START_YEAR  = (int)trim($START_YEAR);
$START_MONTH = (int)trim($START_MONTH);
$START_DAY   = (int)trim($START_DAY);
$START_HOUR  = (int)trim($START_HOUR);
$START_MIN   = (int)trim($START_MIN);
$START_SEC   = (int)trim($START_SEC);
$data['START'] = "$START_YEAR-$START_MONTH-$START_DAY $START_HOUR:$START_MIN:$START_SEC";

$END_YEAR  = (int)trim($END_YEAR);
$END_MONTH = (int)trim($END_MONTH);
$END_DAY   = (int)trim($END_DAY);
$END_HOUR  = (int)trim($END_HOUR);
$END_MIN   = (int)trim($END_MIN);
$END_SEC   = (int)trim($END_SEC);
$data['END'] = "$END_YEAR-$END_MONTH-$END_DAY $END_HOUR:$END_MIN:$END_SEC";

$data['TOTALVIEWS']  = (int)trim($TOTALVIEWS);
$data['TOTALVOTES']  = (int)trim($TOTALVOTES);
$data['TOTALSCORE']  = (int)trim($TOTALSCORE);
$data['TOTALPOINTS'] = (int)trim($TOTALPOINTS);

// Omplim els camps CUSTOM
foreach ($CARDS_FIELDS as $name=>$field) {

    list ($scope, $type, $style) = $field;
    if ($scope=='CUSTOM') {

        if ($type=='NUMBER' || $type=='ITEM' ) { $data[$name]=(int)trim($$name); }

        if ($type=='CHAR' || $type=='TEXT' || $type=='LIST') { $data[$name]= trim($$name); }

        if ($type=='FLAG') {
            $data[$name]='';
            for ($i=0; $i<strlen($$name); $i++) {
                if (isset(${$name.'_'.$i})) { $data[$name].='1'; }
                else { $data[$name].='0'; }
            }
        }

        if ($type=='DATE') {
            $year=trim(${$name.'_YEAR'});
            $month=trim(${$name.'_MONTH'});
            $day=trim(${$name.'_DAY'});
            $hour=trim(${$name.'_HOUR'});
            $min=trim(${$name.'_MIN'});
            $sec=trim(${$name.'_SEC'});
            $data[$name]="$year-$month-$day hour:min:sec";
        }

    } // end if

} // end foreach

// --------------
// DATA INSERTION
// --------------

// Insertar nou newsletter
$id = $dbCards->newCard($data);
if (!$dbCards->Ok) { htmlNewsletterError($messages["error4"]); exit;  }

// -----------
// REDIRECTION
// -----------
//agafo l'ID del newsletter creat...
$result = db_query("select MAX(ID) as IDNL from " . TAULA_NEWSLETTERS);
$row = db_fetch_array($result);
$id = $row['IDNL'];
header("Location: edita.php?ID=".$id."&IdCam=".$IdCam);

?>