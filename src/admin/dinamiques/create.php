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


require ('../config_admin.inc');
accessGroupPermCheck('dinamic_create');

include_once("dinamiques.php");
include_once('categories/funcions.inc');

//COMPROVEM SI TE ACCES A AQUEST MODUL//////////////////////////////////
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL///////////////////7



// --------------------
// PARAMETERS DEFAULT
// --------------------


   if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
   if (empty($ECLASS))      { $ECLASS=$DEFAULT_ECLASS; }

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
   $START_TIME =  (empty($START_TIME)) ? '01/01/0001 '.$START_TIME_HOUR.':'.$START_TIME_MIN.':'.$START_TIME_SEC : $START_TIME.' '.$START_TIME_HOUR.':'.$START_TIME_MIN.':'.$START_TIME_SEC;

   if (empty($END_TIME_SEC))       { $END_TIME_SEC        = 59; } // $START_TIME_SEC + 0; }
   if (empty($END_TIME_MIN))       { $END_TIME_MIN        = 59; } // $START_TIME_MIN + 0; }
   if (empty($END_TIME_HOUR))      { $END_TIME_HOUR       = 23; } // $START_TIME_HOUR + 0; }
   $END_TIME = (empty($END_TIME)) ? '01/01/0001 '.$END_TIME_HOUR.':'.$END_TIME_MIN.':'.$END_TIME_SEC : $END_TIME.' '.$END_TIME_HOUR.':'.$END_TIME_MIN.':'.$END_TIME_SEC;

   if (empty($CALENDAR_START_TIME_SEC))     { $CALENDAR_START_TIME_SEC      = 00; }
   if (empty($CALENDAR_START_TIME_MIN))     { $CALENDAR_START_TIME_MIN      = 00; }
   if (empty($CALENDAR_START_TIME_HOUR))    { $CALENDAR_START_TIME_HOUR     = 00; }
   $CALENDAR_START_TIME = (empty($CALENDAR_START_TIME)) ? TOOLS_TimestampToDate($timestamp,'ESP').' '.$CALENDAR_START_TIME_HOUR.':'.$CALENDAR_START_TIME_MIN.':'.$CALENDAR_START_TIME_SEC :  $CALENDAR_START_TIME.' '.$CALENDAR_START_TIME_HOUR.':'.$CALENDAR_START_TIME_MIN.':'.$CALENDAR_START_TIME_SEC;

   if (empty($CALENDAR_END_TIME_SEC))       { $CALENDAR_END_TIME_SEC        = 59; }
   if (empty($CALENDAR_END_TIME_MIN))       { $CALENDAR_END_TIME_MIN        = 59; }
   if (empty($CALENDAR_END_TIME_HOUR))      { $CALENDAR_END_TIME_HOUR       = 23; }
   $CALENDAR_END_TIME = (empty($CALENDAR_END_TIME)) ? TOOLS_TimestampToDate($timestamp,'ESP').' '.$CALENDAR_END_TIME_HOUR.':'.$CALENDAR_END_TIME_MIN.':'.$CALENDAR_END_TIME_SEC : $CALENDAR_END_TIME.' '.$CALENDAR_END_TIME_HOUR.':'.$CALENDAR_END_TIME_MIN.':'.$CALENDAR_END_TIME_SEC;

//MIRO L´ultim ordre entrat
$result=db_query("select MAX(ORDRE) as ORDRE from $TAULA");
$totalresultats=db_num_rows($result);
$row2 = db_fetch_array($result);
if ($totalresultats>0){
  $ORDRE=$row2['ORDRE']+1;
}
else{
  $ORDRE=1;
}

// ------------------
// CARDS INSTANTATION
// ------------------

$dbCards = new dbCards($CARDS_TABLE);
if (!$dbCards->Ok) {
  htmlPageBasicError(t("errordbcards"));
}

// --------------------
// DATA PREPARATION
// --------------------

   unset($data);

   $data['ECLASS']      = (int)trim($ECLASS);
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


   $data['START_TIME'] = ereg_replace("([0-9]{2})\/([0-9]{2})\/([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2})","\\3-\\2-\\1 \\4:\\5:\\6",$START_TIME);
   $data['END_TIME'] = ereg_replace("([0-9]{2})\/([0-9]{2})\/([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2})","\\3-\\2-\\1 \\4:\\5:\\6",$END_TIME);
   $data['CALENDAR_START_TIME'] = ereg_replace("([0-9]{2})\/([0-9]{2})\/([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2})","\\3-\\2-\\1 \\4:\\5:\\6",$CALENDAR_START_TIME);
   $data['CALENDAR_END_TIME'] = ereg_replace("([0-9]{2})\/([0-9]{2})\/([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2})","\\3-\\2-\\1 \\4:\\5:\\6",$CALENDAR_END_TIME);

   $data['ORDRE'] = $ORDRE;

   // Omplim els camps CUSTOM
   foreach ($CARDS_FIELDS as $name=>$field)
   {
     list ($scope, $type, $style) = $field;
     if ($scope=='CUSTOM' && (isset($_POST[$name]) || isset($_POST[$name.'_DAY'])))
     {
         if ($type=='NUMBER' || $type=='ITEM')
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

         if ($type=='DATE' )
         {
           $year=trim(${$name.'_YEAR'});
           $month=trim(${$name.'_MONTH'});
           $day=trim(${$name.'_DAY'});
           $hour=trim(${$name.'_HOUR'});
           $min=trim(${$name.'_MIN'});
           $sec=trim(${$name.'_SEC'});
           $data[$name]= "$year-$month-$day $hour:$min:$sec";
         }

     } // end if
   } // end foreach

// --------------
// DATA INSERTION
// --------------
$data['URL_TITOL'] = sanitize_title($data['TITOL']);

$data['MODIFICAT'] = $data['CREATION'];
   // Insertar nou user
   $id = $dbCards->newCard($data);
   if (!$dbCards->Ok) {
     htmlPageBasicError(t("errordbcardsnew"));
   }
   $_POST['RESUM'] = editor_filter($_POST['RESUM']);
   $_POST['RESUM'] = htmlFilter($_POST['RESUM']);
   db_update_text($TAULA, 'RESUM', $_POST['RESUM'], 'ID = '.$id);
   $_POST['DESCRIPCIO'] = editor_filter($_POST['DESCRIPCIO']);
   $_POST['DESCRIPCIO'] = htmlFilter($_POST['DESCRIPCIO']);
   db_update_text($TAULA, 'DESCRIPCIO', $_POST['DESCRIPCIO'], 'ID = '.$id);
   $_POST['DESCRIPCIO2'] = editor_filter($_POST['DESCRIPCIO2']);
   $_POST['DESCRIPCIO2'] = htmlFilter($_POST['DESCRIPCIO2']);
   db_update_text($TAULA, 'DESCRIPCIO2', $_POST['DESCRIPCIO2'], 'ID = '.$id);


//insertar inici descripcioms

 //fi
// -----------
// REDIRECTION
// -----------



//insertar registre d'accions
register_add(t("dinamicsregistrycreate")." $nomcarpeta", "ID: $id");
//fi

////////// miro ID q acabo d'entrar i pujo imatge o adjunt

$ID=$id;

if($result) {

  /*pujar fitxer*/
  $log2 = 0;
  for ($i = 1; $i <=3; $i++) {
	  if($_FILES['file'.$i]['name'] != '') {
	  	$nom_fitxer = normalizeFileAndExtension($_FILES['file'.$i]['name']);
	    $extensio = explode (".", $nom_fitxer);
		$destName = $extensio['0'].'_'.$TAULA.'_'.$ID.'_'.$i.'.'.$extensio['1'];
	    $destName = strtr($destName, '$', '_');
	    $log2 = upload('file'.$i, $CONFIG_PATHUPLOADAD, $UPLOAD_filesize, $UPLOAD_filetype, $destName);
	    if ($log2 == 4) {
	      db_query('update '.$TAULA.' set ADJUNT'.$i.' = \''.$destName.'\' where ID = '.$ID);
	    }
	  }
  }
  /*pujar imatge*/

  /*busca el format de les imatges que es guardaran*/
  $imageSizes = $dinamiques_imageSizes;
  if (isset($tipusdinamiques[$tipuseditora]['imageSizes'])) {
    $imageSizes = $tipusdinamiques[$tipuseditora]['imageSizes'];
  }
  $log = 0;
  for ($i = 1; $i <=3; $i++) {
    if($_FILES['img'.$i]['name'] != '') {
      $nom_fitxer = normalizeFileAndExtension($_FILES['img'.$i]['name']);
      $extensio = explode (".", $nom_fitxer);
      $destName = $extensio['0'].'_'.$TAULA.'_'.$ID.'_'.$i.'.'.$extensio['1'];
      $destName = strtr($destName, '$', '_');


		// pugem les imatges, si no dóna error esborrem les imatges antigues i actualitzem la taula
		foreach ($imageSizes as $value) {
			$size = 0;
			if (isset($value['size'])) {
				$size = $value['size'];
			}
			$prefix = '';
			if (isset($value['prefix'])) {
				$prefix = trim($value['prefix']);
			}
			$log = upload('img'.$i, $CONFIG_PATHUPLOADIM, $UPLOAD_imgsize, $UPLOAD_imgtype, $prefix.$destName, $size);
		}


      if ($log == 4) {
        db_query('update '.$TAULA.' set IMATGE'.$i.' = \''.$destName.'\' where ID = '.$ID);
      }
    }
  }

  $filename="preview".$tipuseditora.".php";
  if (file_exists($filename)) {
    goto_url('preview'.$tipuseditora.'.php?ID='.$ID.'&log='.$log.'&log2='.$log2.'&DIN='.$DIN);
  }else{
    goto_url('preview.php?ID='.$ID.'&log='.$log.'&log2='.$log2.'&DIN='.$DIN);
  }
}
else {
  echo ("<a href='javascript:history.back()'>".t("back")."</a>");
  echo db_error();
}



?>
