<?php

require ('../../config_admin.inc');
accessGroupPermCheck('boxes');

require('caixetes.php');

include('variables.php');

if (empty($_POST['NOM'])) {
  htmlPageBasicError(t('bannerserror2'));
}

$log = '';
if(isset($_FILES['img'])) {
/*pujar imatge*/
  $log = 1;
  if($_FILES['img']['name'] != '') {
    $IMATGE = $_FILES['img']['name'];
    $log = upload('img', $CONFIG_PATHBOX.'/img', $UPLOAD_imgsize, $UPLOAD_imgtype);
    if ($log == 4 && $_FILES['img']['type'] != 'application/x-shockwave-flash') {
      $mides=getimagesize($CONFIG_PATHBOX.'/img/'.$_FILES['img']['name']);
      $WIDTH = $mides[0];
    }

  }
}

if(isset($_FILES['img1'])) { 	
/*pujar imatge alternativa per al flash*/
  $log = 1;
  if($_FILES['img1']['name'] != '') {
    $IMATGE_ALTERNATIVA = $_FILES['img1']['name'];
    $log = upload('img1', $CONFIG_PATHBOX.'/img', $UPLOAD_imgsize, $UPLOAD_imgtype);
  }
}

// --------------------
// PARAMETERS DEFAULT
// --------------------

   if (empty($ID))     { echo "<B>Error: No se ha recibido el codigo de card.</B><br>\n"; exit; }

   if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
   if (empty($ECLASS))      { $ECLASS=$DEFAULT_ECLASS; }

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

   $avui = date('Y-m-d H:i:s', time());
   $data['MODIFICAT']=$avui;

   $data['WIDTH'] = $WIDTH;

   $_POST['USUARIMODI'] = $_POST['USUARI'];

if ($TIPO == 2 || $TIPO == 3) {
  $_POST['TEXT'] = htmlFilter($_POST['TEXT']);
  $TEXT = htmlFilter($TEXT);
}


   // Passem llista als camps i mirem quins em rebut per POST METHOD
   foreach ($CARDS_FIELDS as $name=>$field)
   {
     list ($scope, $type, $style) = $field;

     if (isset($_POST[$name]) || isset($_POST[$name.'_DAY']))
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
if (!empty($IMATGE)) {
   $data['IMATGE']=$IMATGE;
}
if (!empty($IMATGE_ALTERNATIVA)) {
   $data['IMATGE_ALTERNATIVA']=$IMATGE_ALTERNATIVA;
}
   $data['NOM'] = normalizeFile($data['NOM']);
   // actualitzem les dades
   $dbCards->updateCard( $ID, $data );
   if (!$dbCards->Ok) { echo "<B>Error: No se ha podido actualizar el registro.</B><br>".$Cards->Error."\n"; exit; }

   // -----------
   // REDIRECTION
   // -----------

   // Return URL

     //insertar registre d'accions
     register_add("Caixeta actualitzada", "$NOM ($DESCRIPCIO)");
   //fi


   goto_url('preview.php?ID='.$ID.'&log='.$log);

?>
