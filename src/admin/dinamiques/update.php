<?php

require ('../config_admin.inc');
accessGroupPermCheck('dinamic_edit');

include_once("dinamiques.php");
include_once('categories/funcions.inc');


//COMPROVEM SI TE ACCES A AQUEST MODUL
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL


// --------------------
// PARAMETERS DEFAULT
// --------------------


if (empty($ID)) {
  htmlPageBasicError(t("errordbcardscodi"));
}

if (empty($LANG)) { $LANG=$DEFAULT_LANG; }
if (empty($ECLASS)) { $ECLASS=$DEFAULT_ECLASS; }

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

// actualitzem les dates
$data['URL_TITOL'] = sanitize_title($data['TITOL']);
$data['START_TIME'] = ereg_replace("([0-9]{2})\/([0-9]{2})\/([0-9]{4})","\\3-\\2-\\1 $START_TIME_HOUR:$START_TIME_MIN:$START_TIME_SEC", $START_TIME);
$data['END_TIME'] = ereg_replace("([0-9]{2})\/([0-9]{2})\/([0-9]{4})","\\3-\\2-\\1 $END_TIME_HOUR:$END_TIME_MIN:$END_TIME_SEC", $END_TIME);
$data['CALENDAR_START_TIME'] = ereg_replace("([0-9]{2})\/([0-9]{2})\/([0-9]{4})","\\3-\\2-\\1 $CALENDAR_START_TIME_HOUR:$CALENDAR_START_TIME_MIN:$CALENDAR_START_TIME_SEC", $CALENDAR_START_TIME);
$data['CALENDAR_END_TIME'] = ereg_replace("([0-9]{2})\/([0-9]{2})\/([0-9]{4})","\\3-\\2-\\1 $CALENDAR_END_TIME_HOUR:$CALENDAR_END_TIME_MIN:$CALENDAR_END_TIME_SEC", $CALENDAR_END_TIME);

$avui = date('Y-m-d H:i:s', time());
$data['MODIFICAT']=$avui;
$data['USUARIMODI']=accessGetLogin();
// actualitzem les dades
$dbCards->updateCard( $ID, $data );
if (!$dbCards->Ok) {
  htmlPageError(t("errordbcardsupdate"));
}

$_POST['RESUM'] = editor_filter($_POST['RESUM']);
$_POST['RESUM'] = htmlFilter($_POST['RESUM']);
db_update_text($TAULA, 'RESUM', $_POST['RESUM'], 'ID = '.$ID);
$_POST['DESCRIPCIO'] = editor_filter($_POST['DESCRIPCIO']);
$_POST['DESCRIPCIO'] = htmlFilter($_POST['DESCRIPCIO']);
db_update_text($TAULA, 'DESCRIPCIO', $_POST['DESCRIPCIO'], 'ID = '.$ID);
$_POST['DESCRIPCIO2'] = editor_filter($_POST['DESCRIPCIO2']);
$_POST['DESCRIPCIO2'] = htmlFilter($_POST['DESCRIPCIO2']);
db_update_text($TAULA, 'DESCRIPCIO2', $_POST['DESCRIPCIO2'], 'ID = '.$ID);

  // -----------
  // REDIRECTION
  // -----------

//// Inserta al registre d'accions
register_add(t("dinamicsregistrymodify")." $nomcarpeta", $TITOL);
// fi inserta

/*pujar fitxer*/
$log2 = 0;
  for ($i = 1; $i <=3; $i++) {
	  if($_FILES['file'.$i]['name'] != '') {


			$nom_fitxer = normalizeFileAndExtension($_FILES['file'.$i]['name']);
			$extensio = explode (".", $nom_fitxer);
			$destName = $extensio['0'].'_'.$TAULA.'_'.$ID.'_'.$i.'.'.$extensio['1'];
			$destName = strtr($destName, '$', '_');

			// pugem el fitxer, i si tot va bé esborrem l'arxiu antic i actualitzem la taula
			$log2 = upload('file'.$i, $CONFIG_PATHUPLOADAD, $UPLOAD_filesize, $UPLOAD_filetype, $destName);
			if($log2 == 4) {

				// esborrem arxiu antic
				$old_query = db_query("SELECT ADJUNT$i FROM $TAULA WHERE ID='$ID'");
				$old_row = db_fetch_array($old_query);
				if(file_exists($CONFIG_PATHUPLOADAD.'/'.$old_row['ADJUNT'.$i])) unlink($CONFIG_PATHUPLOADAD.'/'.$old_row['ADJUNT'.$i]);

				// actualitzem taula
				db_query("UPDATE $TAULA SET ADJUNT$i='$destName' WHERE ID='$ID'");

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


			if($log == 4) {

				// esborrem imatges antigues, en cas de ser-hi
				$old_query = db_query("SELECT IMATGE$i FROM $TAULA WHERE ID='$ID'");
				$old_row = db_fetch_array($old_query);
				if ($old_row['IMATGE'.$i] != $destName) {
					//si s'ha canviat el nom de la imatge, esborrar les velles
					foreach ($imageSizes as $value) {
						$prefix = '';
						if (isset($value['prefix'])) {
							$prefix = trim($value['prefix']);
						}
						if(file_exists($CONFIG_PATHUPLOADIM.'/'.$prefix.$old_row['IMATGE'.$i])) {
							unlink($CONFIG_PATHUPLOADIM.'/'.$prefix.$old_row['IMATGE'.$i]);
						}
					}
				}
				// actualitzem taula
				db_query("UPDATE $TAULA SET IMATGE$i='$destName' WHERE ID='$ID'");

			}



  }
}


$filename="preview".$tipuseditora.".php";
if (file_exists($filename)) {
  goto_url('preview'.$tipuseditora.'.php?ID='.$ID.'&log='.$log.'&log2='.$log2.'&DIN='.$DIN.'&PAGE='.$pagina);
}
else{
  goto_url('preview.php?ID='.$ID.'&log='.$log.'&log2='.$log2.'&DIN='.$DIN.'&PAGE='.$pagina);
}

?>
