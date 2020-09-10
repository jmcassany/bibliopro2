<?php
// ============================================================================
// ============================================================================
// CARDS ADMIN: CREATE.PHP
// - Creates a new record in database cards
// by Asterisc.web
// Version: beta 1.0
// Start: May 2002 - Last: June 2002
// ============================================================================
// ============================================================================

require ('../../config_admin.inc');
accessGroupPermCheck('composition');

require('compositions.php');


$result=db_query("select * from BANNERS where NOM = '$NOM'");
$trobats = db_num_rows($result);

if($trobats > 0){
  htmlPageBasicError(t('bannersgrouperror1'));
}
else if (empty($_POST['NOM'])) {
  htmlPageBasicError(t('bannersgrouperror2'));
}


// --------------------
// PARAMETERS DEFAULT
// --------------------

   if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
   if (empty($ECLASS))      { $ECLASS=$DEFAULT_ECLASS; }

   if (empty($SKIN))       { $SKIN=$DEFAULT_SKIN; }
   if (empty($CATEGORY1))  { $CATEGORY1=$DEFAULT_CATEGORY1; }
   if (empty($CATEGORY2))  { $CATEGORY2=$DEFAULT_CATEGORY2; }
   if (empty($STATUS))     { $STATUS=$DEFAULT_STATUS; }
   if (empty($VISIBILITY)) { $VISIBILITY=$DEFAULT_VISIBILITY; }

   $timestamp=TOOLS_GetTimestamp();

   if (empty($CREATION_SEC))  { $CREATION_SEC   = TOOLS_TimestampToSec($timestamp); }
   if (empty($CREATION_MIN))  { $CREATION_MIN   = TOOLS_TimestampToMin($timestamp); }
   if (empty($CREATION_HOUR)) { $CREATION_HOUR  = TOOLS_TimestampToHour($timestamp); }
   if (empty($CREATION_DAY))  { $CREATION_DAY   = TOOLS_TimestampToDay($timestamp); }
   if (empty($CREATION_MONTH)){ $CREATION_MONTH = TOOLS_TimestampToMonth($timestamp); }
   if (empty($CREATION_YEAR)) { $CREATION_YEAR  = TOOLS_TimestampToYear($timestamp); }

   if (empty($START_TIME_SEC))     { $START_TIME_SEC      = 00; } // $CREATION_SEC + 0; }
   if (empty($START_TIME_MIN))     { $START_TIME_MIN      = 00; } // $CREATION_MIN + 0; }
   if (empty($START_TIME_HOUR))    { $START_TIME_HOUR     = 00; } // $CREATION_HOUR + 0; }
   if (empty($START_TIME_DAY))     { $START_TIME_DAY      = $CREATION_DAY + 0; }
   if (empty($START_TIME_MONTH))   { $START_TIME_MONTH    = $CREATION_MONTH + 0; }
   if (empty($START_TIME_YEAR))    { $START_TIME_YEAR     = $CREATION_YEAR + 0; }

   if (empty($END_TIME_SEC))       { $END_TIME_SEC        = 59; } // $START_TIME_SEC + 0; }
   if (empty($END_TIME_MIN))       { $END_TIME_MIN        = 59; } // $START_TIME_MIN + 0; }
   if (empty($END_TIME_HOUR))      { $END_TIME_HOUR       = 23; } // $START_TIME_HOUR + 0; }
   if (empty($END_TIME_DAY))       { $END_TIME_DAY        = $START_TIME_DAY + 0; }
   if (empty($END_TIME_MONTH))     { $END_TIME_MONTH      = $START_TIME_MONTH + 0; }
   if (empty($END_TIME_YEAR))      { $END_TIME_YEAR       = $START_TIME_YEAR + 1; }

   if (empty($TOTALVIEWS))    { $TOTALVIEWS  = 0; }
   if (empty($TOTALVOTES))    { $TOTALVOTES  = 0; }
   if (empty($TOTALSCORE))    { $TOTALSCORE  = 0; }
   if (empty($TOTALPOINTS))   { $TOTALPOINTS = 0; }

// ------------------
// CARDS INSTANTATION
// ------------------

   $dbCards = new dbCards($CARDS_TABLE);
   if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }

// --------------------
// DATA PREPARATION
// --------------------

   unset($data);

   $data['ECLASS']      = (int)trim($ECLASS);
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

   $START_TIME_YEAR  = (int)trim($START_TIME_YEAR);
   $START_TIME_MONTH = (int)trim($START_TIME_MONTH);
   $START_TIME_DAY   = (int)trim($START_TIME_DAY);
   $START_TIME_HOUR  = (int)trim($START_TIME_HOUR);
   $START_TIME_MIN   = (int)trim($START_TIME_MIN);
   $START_TIME_SEC   = (int)trim($START_TIME_SEC);
   $data['START_TIME'] = "$START_TIME_YEAR-$START_TIME_MONTH-$START_TIME_DAY $START_TIME_HOUR:$START_TIME_MIN:$START_TIME_SEC";

   $END_TIME_YEAR  = (int)trim($END_TIME_YEAR);
   $END_TIME_MONTH = (int)trim($END_TIME_MONTH);
   $END_TIME_DAY   = (int)trim($END_TIME_DAY);
   $END_TIME_HOUR  = (int)trim($END_TIME_HOUR);
   $END_TIME_MIN   = (int)trim($END_TIME_MIN);
   $END_TIME_SEC   = (int)trim($END_TIME_SEC);
   $data['END_TIME'] = "$END_TIME_YEAR-$END_TIME_MONTH-$END_TIME_DAY $END_TIME_HOUR:$END_TIME_MIN:$END_TIME_SEC";

   $data['TOTALVIEWS']  = (int)trim($TOTALVIEWS);
   $data['TOTALVOTES']  = (int)trim($TOTALVOTES);
   $data['TOTALSCORE']  = (int)trim($TOTALSCORE);
   $data['TOTALPOINTS'] = (int)trim($TOTALPOINTS);

$_POST['USUARICREAR'] = $_POST['USUARI'];
$_POST['USUARIMODI'] = $_POST['USUARI'];
$MODIFICAT = $data['CREATION'];


   // Omplim els camps CUSTOM
   foreach ($CARDS_FIELDS as $name=>$field)
   {
     list ($scope, $type, $style) = $field;
     if ($scope=='CUSTOM' && (isset($_POST[$name]) || isset($_POST[$name.'_DAY'])))
     {
         if ($type=='NUMBER' || $type=='ITEM' )
         { $data[$name]=(int)trim($$name); }

         if ($type=='CHAR' || $type=='TEXT')
         { $data[$name]= trim($_POST[$name]); }

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
   $data['NOM'] = normalizeFile($data['NOM']);

   // Insertar nou user
   $id = $dbCards->newCard($data);
   if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear nueva ficha.</B><br>\n"; exit; }

// -----------
// REDIRECTION
// -----------

    // Return URL

	  //insertar registre d'accions
	  register_add("Banner creat", "$NOM($DESCRIPCIO)");
   //fi
	goto_url('selec_caixetes.php?ID='.$id.'&TIPO='.$TIPO.'&CAIXETES='.$CAIXETES);
?>
