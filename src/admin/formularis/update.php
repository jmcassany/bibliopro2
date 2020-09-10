<?php
// ============================================================================
// ============================================================================
// CARDS ADMIN: UPDATE.PHP
// - Updates a card in database cards
// by Asterisc.web
// Version: beta 1.0
// Start: May 2002 - Last: June 2002
// ============================================================================
// ============================================================================

require ('../config_admin.inc');
accessGroupPermCheck('form_edit');

include_once("formularis.php");

// --------------------
// PARAMETERS DEFAULT
// --------------------

   if (empty($ID))     {
     htmlPageError(t("errordbcardscodi"));
   }

   if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
   if (empty($ECLASS))      { $ECLASS=$DEFAULT_ECLASS; }

// ------------------
// CARDS INSTANTATION
// ------------------

   $dbCards = new dbCards($CARDS_TABLE);
   if (!$dbCards->Ok) {
     htmlPageBasicError(t("errordbcards"));
   }



   $actualcard = $dbCards->readCard($ID);

// -------------
// DATA UPDATING
// -------------

   $_POST['DESCRIPCIO'] = htmlFilter($_POST['DESCRIPCIO']);
   $DESCRIPCIO = htmlFilter($DESCRIPCIO);


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

   $data['NOMFORMULARI'] = normalizeFile($data['NOMFORMULARI']);

   // actualitzem les dades
   $dbCards->updateCard( $ID, $data );
   if (!$dbCards->Ok) {
     htmlPageError(t("errordbcardsupdate"));
   }

	/*eliminar formulari vell*/
   if ($actualcard['PARE'] != $data['PARE']) {
		delete_page($data['NOMFORMULARI'], $actualcard['PARE']);
	}

   // -----------
   // REDIRECTION
   // -----------

   // Return URL

   //insertar registre d'accions
   register_add(t("form")." ".t("update"), "$NOMFORMULARI ($TITOLFORMULARI)");
   //fi


   goto_url('index.php');

?>
