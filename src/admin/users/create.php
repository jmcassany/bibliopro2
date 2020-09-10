<?php
// ============================================================================
// ============================================================================
// USERS ADMIN: INSERT.PHP
// - Creates a new record in database users
// by Asterisc.web
// Version: beta 1.0
// Start: May 2002 - Last: June 2002
// ============================================================================
// ============================================================================

require ('../config_admin.inc');
accessGroupPermCheck('users_create');

    // default expiration
    $USERS_EXPIRATIONDAYS = '0';
    $USERS_EXPIRATIONMONTHS = '0';
    $USERS_EXPIRATIONYEARS = '1';


// ------------------
// USERS INSTANTATION
// ------------------

   $Users = new dbUsers();
   if (!$Users->Ok) {
     htmlPageBasicError(t("errordbusers"));
   }

// --------------------
// PARAMETERS FILTERING
// --------------------

   $now = TOOLS_GetTimestamp();

   if (empty($EXP_DAY))  { $EXP_DAY  = $USERS_EXPIRATIONDAYS   + TOOLS_TimestampToDay($now); }
   if ($EXP_DAY>30) { $EXP_DAY=1; $USERS_EXPIRATIONMONTHS=$USERS_EXPIRATIONMONTHS+1; }
   if ($USERS_EXPIRATIONMONTHS>12) { $USERS_EXPIRATIONMONTHS=0; $USERS_EXPIRATIONYEARS=$USERS_EXPIRATIONYEARS+1; }

   if (empty($EXP_MONTH)){ $EXP_MONTH= $USERS_EXPIRATIONMONTHS + TOOLS_TimestampToMonth($now); }
   if ($EXP_MONTH>12)    { $EXP_MONTH=1; $USERS_EXPIRATIONYEARS=$USERS_EXPIRATIONYEARS+1; }

   if (empty($EXP_YEAR)) { $EXP_YEAR = $USERS_EXPIRATIONYEARS  + TOOLS_TimestampToYear($now); }

   // El login eliminem els espais i posem les inicials en majúscula
   $LOGIN = $Users->normalize($LOGIN);

   if ($ldap_active) {
     $PASSWD = '';
     $PASSWD_BIS = '';

     $EMAIL = '';
     $REALNAME = '';
     $TELEPHONE = '';
   }
   else {
     $PASSWD = trim($PASSWD);
     $PASSWD_BIS = trim($PASSWD_BIS);

     $EMAIL = trim($EMAIL);
     // Comprovar que te format d'email 'bla@bla...'
     if (!eregi("([a-z0-9\-\_\.]+)@([a-z0-9\-\_\.]+)",$EMAIL)) {
       $EMAIL = '';
     }

     $REALNAME = trim($REALNAME);
     $TELEPHONE = trim($TELEPHONE);
   }


   $USERLEVEL = (int)trim($USERLEVEL);
   $STATUS = (int)trim($STATUS);
   $EXP_DAY = (int)trim($EXP_DAY);
   $EXP_MONTH = (int)trim($EXP_MONTH);
   $EXP_YEAR = (int)trim($EXP_YEAR);
   $EXPIRATION = "$EXP_YEAR-$EXP_MONTH-$EXP_DAY 00:00:00";

   $COMMENTS = '';
   if (isset($_POST['COMMENTS'])) {
     $COMMENTS = implode(',',$_POST['COMMENTS']);
   }

   // Comprovar que te format d'email 'bla@bla...'
   if (!eregi("([a-z0-9\-\_\.]+)@([a-z0-9\-\_\.]+)",$EMAIL))
   { $EMAIL = ''; }

   // Comprovar login
   if (strlen($LOGIN)<3)
   {
     htmlPageError(t("errorusersnomusuaritamany"));
   }

   if ($Users->existsLogin($LOGIN))
   {
     htmlPageError(t("errorloginutilitzat"),array('javascript:history.back();', 'edita.php?LOGIN='.$LOGIN), array(t('back'), t('edit').' '.t('user').' '.$LOGIN));
   }
   if (!$ldap_active) {
     // Comprovar password
     if (($PASSWD!=$PASSWD_BIS))
     {
       htmlPageError(t("errorusersclausdif"));
     }
     if ((strlen($PASSWD)<2))   {
       htmlPageError(t("errorusersclaustamany"));
     }
   }


// --------------
// DATA INSERTION
// --------------

   //encriptar password
   $PASSWD=$CONFIG_ENCRIPTAR($PASSWD);
   // Insertar nou user
   $Users->newUser($LOGIN, $PASSWD, $USERLEVEL, $STATUS, $EXPIRATION, $EMAIL, $REALNAME, $TELEPHONE, $COMMENTS);


	// grups upload
	$GRUP_UPLOAD = '';
   	for ($i_=0;$i_<count($GRUP);$i_++)
	{
		if($i_ == 0)
			$GRUP_UPLOAD = $GRUP[$i_];
		else
			$GRUP_UPLOAD .= ', '.$GRUP[$i_];
	}
	$GRUP = $GRUP_UPLOAD;
   	db_query("insert USERS_GRUPS_UPLOAD (USERLOGIN, ID_GRUP) values ('".$LOGIN."', '".$GRUP."')");


//insertar registre d'accions
register_add(t("userregistrycreate"), $LOGIN);
//fi

// -----------
// REDIRECTION
// -----------

    // Redirection to Index
    goto_url('index.php');

?>
