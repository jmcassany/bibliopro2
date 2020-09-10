<?php

require ('../../config_admin.inc');
accessGroupPermCheck('users_edit');

include_once("grups.php");
//include_once('categories/funcions.inc');


//COMPROVEM SI TE ACCES A AQUEST MODUL
//include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL


// --------------------
// PARAMETERS DEFAULT
// --------------------

if (empty($ID)) {
  htmlPageBasicError(t("errordbcardscodi"));
}

if (empty($LANG)) { $LANG=$DEFAULT_LANG; }
if (empty($ECLASS)) { $ECLASS=$DEFAULT_ECLASS; }

// ------------------
// CARDS INSTANTATION
// ------------------

$dbCards = new dbCards($CARDS_TABLE);
if (!$dbCards->Ok) {
  htmlPageBasicError(t("errordbcards"));
}

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

      if ($type=='CHAR' || $type=='TEXT')
      { $data[$name]= trim($$name); }

      if ($type=='FLAG')
      {
        $data[$name]='';
        for ($i=0; $i<strlen($$name); $i++)
        {
          if (isset(${$name.'_'.$i}))
          { $data[$name].='1'; }
          else
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

$avui = date('Y-m-d H:i:s', time());
$data['MODIFICAT']=$avui;
$data['USUARIMODI']=accessGetLogin();
// actualitzem les dades

$dbCards->updateCard( $ID, $data );
if (!$dbCards->Ok) {
  htmlPageError(t("errordbcardsupdate"));
}

  // -----------
  // REDIRECTION
  // -----------

    header("Location: index.php");


?>