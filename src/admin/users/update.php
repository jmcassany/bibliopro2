<?php
// ============================================================================
// ============================================================================
// USERS ADMIN: UPDATE.PHP
// - Updates and deletes a user in database users
// by Asterisc.web
// Version: beta 1.0
// Start: May 2002 - Last: June 2002
// ============================================================================
// ============================================================================


require ('../config_admin.inc');
accessGroupPermCheck('users_edit');

// ------------------
// FORUM INSTANTATION
// ------------------

   $Users = new dbUsers();
   if (!$Users->Ok) {
     htmlPageBasicError(t("errordbusers"));
   }

// --------------------
// PARAMETERS FILTERING
// --------------------

   if (!isset($_POST['LOGIN_ORIG'])) {
     htmlPageError(t("erroruserscodi"));
   }

   $LOGIN_ORIG = $Users->normalize($_POST['LOGIN_ORIG']);
   $LOGIN = $Users->normalize($_POST['LOGIN']);

   // El login eliminem els espais i posem les inicials en majúscula

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
   //inserta moduls

   $COMMENTS = '';
   if (isset($_POST['COMMENTS'])) {
     $COMMENTS = implode(',',$_POST['COMMENTS']);
   }



// -------------
// DATA UPDATING
// -------------

        // Comprovar login
        if (strlen($LOGIN)<3) {
          htmlPageError(t("errorusersnomusuaritamany"));
        }

        if ($LOGIN != $LOGIN_ORIG) {
          // echo "<h1>*$ocupat*</h1>";
          if ($Users->existsLogin($LOGIN))
          {
            htmlPageError(t("errorloginutilitzat"));
		  }
		  else {
            $Users->updateUserLogin($LOGIN_ORIG, $LOGIN);
            $LOGIN = $LOGIN_ORIG;
          }
        }

        if (!$ldap_active) {
          // Comprovar password
          if ($PASSWD!=$PASSWD_BIS)
          {
            htmlPageError(t("errorusersclausdif"));
          }
		  if ($PASSWD!="" && (strlen($PASSWD)<3))
          {
            htmlPageError(t("errorusersclaustamany"));
		  }

		  // Si el password no coincideix, el fem fora
		  //encriptar password

		  if ($PASSWD!="")$PASSWD=$CONFIG_ENCRIPTAR($PASSWD);
        }

        // en aquest cas actualitzem les dades
        $Users->updateUser($LOGIN, $PASSWD, $USERLEVEL, $STATUS, $EXPIRATION, $EMAIL, $REALNAME, $TELEPHONE, $COMMENTS);
        if (!$Users->Ok) {
          htmlPageError(t("errorusersgeneral").$Users->Error);
		}

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

		db_query("delete from USERS_GRUPS_UPLOAD where USERLOGIN='".$LOGIN."'");
		db_query("insert USERS_GRUPS_UPLOAD (USERLOGIN, ID_GRUP) values ('".$LOGIN."', '".$GRUP."')");


   //insertar registre d'accions
   register_add(t("userregistryupdate"), $LOGIN);
   //fi

// -----------
// REDIRECTION
// -----------

    // Redirection to Index

    goto_url('index.php');

?>
