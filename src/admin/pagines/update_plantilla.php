<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_edit');
$carpeta = $_POST['PARE'];
include_once("estatiques.php");

   if (!isset($_POST['PLANTILLA']) || $_POST['PLANTILLA'] == ''){
     htmlPageError(t("staticpageerrornotemplate"));
   }

   $PLANTILLAID=$_POST['PLANTILLA'];
   $_POST['PLANTILLAID'] = $_POST['PLANTILLA'];
   $ID=$_POST['ID'];
   $USUARIMODI=$_POST['USUARIMODI'];
// ============================================================================
// ============================================================================
// CARDS ADMIN: UPDATE.PHP
// - Updates a card in database cards
// by Asterisc.web
// Version: beta 1.0
// Start: May 2002 - Last: June 2002
// ============================================================================
// ============================================================================

   include("check_moduls.php");

// --------------------
// PARAMETERS DEFAULT
// --------------------

   if (empty($ID))     {
     htmlPageBasicError(t("errordbcardscodi"));
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

   // actualitzem les dades
   //$arrayBuscados = array('\"');
   //$arrayReemplazar = array("&quot;");
   //$data  = str_replace($arrayBuscados, $arrayReemplazar, $data);
   $dbCards->updateCard( $ID, $data );
   if (!$dbCards->Ok) {
     htmlPageError(t("errordbcardsupdate"));
   }

   // -----------
   // REDIRECTION
   // -----------

  //insertar registre d'accions
   $result=db_query("select NOMPAG from ESTATICA where ID='$ID'");
   $row = db_fetch_array($result);
   db_free_result($result);
   register_add(t("staticpagesregistrytemplatechanged"), $row['NOMPAG']);


?>
<html>
<head>
<?php echo htmlMetas() ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="1" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;padding:20px;">
	<tr>
		<td class="text" align="center">

				<table cellpadding="0" cellspacing="0" border="0" style="padding:5px;border-bottom:solid #FF6600 2px;" width="500">

						<td   valign="top" ><img src="../comu/icon_ok.gif" alt="Ok" width="25" height="25" border="0"></td>
						<td class="text11"  valign="top" ><b><?php echo t("staticpagestemplatechanged") ?>.</b></td>

					</table>
					 <br><br>
			<a href="edita.php?ID=<?php echo $ID; ?>&carpeta=<?php echo $PARE; ?>" class="botonavegacio"><?php echo t("modify")." ".t("page"); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?carpeta=<?php echo $PARE; ?>" class="botonavegacio"><?php echo t("backtolist"); ?></a>
</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
