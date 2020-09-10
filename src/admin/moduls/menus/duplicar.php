<?php

require ('../../config_admin.inc');
accessGroupPermCheck('menu_create');

include_once("menus.php");



  if (isset($_GET['ID'])) {
    $ID=$_GET['ID'];
  }
  if(isset($_POST['ID'])){
    $ID=$_POST['ID'];
    $NOM=$_POST['NOM'];
  }

  $result1 = @db_query("select * from MENUS where ID = '$ID'");

  if (db_num_rows($result1) == 0) {
    htmlPageError(t("errordbcardscodinotfound"));
  }
  $row = db_fetch_array($result1);

  if(!isset($NOM)){
    $NOM="copia_".$row['NOM'];
  }

  foreach($row as $key => $value) {
    $row[$key] = addslashes($value);
  }

  $data = date('Y-m-d H:i:s', time());

  $sql = "INSERT INTO MENUS
  (ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS,
  VISIBILITY, CREATION, USUARICREAR, USUARIMODI, IDIOMA, NOM, DESCRIPCIO,
  PARE, PLANTILLA, TIPO, DESPLEGABLE,
  ESTIL, ACCESSUBCARP)

  VALUES
  (".$row['ECLASS'].", ".$row['SKIN'].", ".$row['CATEGORY1'].", ".$row['CATEGORY2'].", ".$row['STATUS'].",
  ".$row['VISIBILITY'].", '$data', '".accessGetLogin()."', '', '".$row['IDIOMA']."', '$NOM', 'copia de ".$row['DESCRIPCIO']."',
  '".$row['PARE']."', '', '".$row['TIPO']."','".$row['DESPLEGABLE']."',
  '".$row['ESTIL']."',
  '".$row['ACCESSUBCARP']."');";
  $result = @db_query($sql);



  if($result) {
    //insertar registre d'accions
    register_add(t("menuregistryduplicated"), $NOM);
    //fi
    $result=@db_query("select MAX(ID) as ID from MENUS");
    $row = db_fetch_array($result);
    $ultimcreat=$row['ID'];

    $result2 = @db_query("SELECT * FROM MENUITEMS WHERE MENU='$ID'");

    while($row2 = db_fetch_array($result2)) {
      $sql2 = "INSERT INTO MENUITEMS
           (TEXT, LINKPAGE, FINESTRA, ORDRE, MENU,`SEPARATOR`,CSSCLASS,DIRECTORI)
           VALUES
           ('".addslashes($row2['TEXT'])."', '".addslashes($row2['LINKPAGE'])."', '".$row2['FINESTRA']."', '".$row2['ORDRE']."', '$ultimcreat', '".$row2['SEPARATOR']."', '".addslashes($row2['CSSCLASS'])."', '".$row2['DIRECTORI']."');";
      @db_query($sql2);

      $result=@db_query("select MAX(ID) as ID from MENUITEMS");
      $row = db_fetch_array($result);
      $ultimelementcreat=$row['ID'];


      if ($row2['IMATGE'] != null && $row2['IMATGE'] != '') {
        $extensio = explode (".", $row2['IMATGE']);
        $destName = 'menu_'.$ultimelementcreat.'.'.$extensio['1'];
        @copy($CONFIG_PATHMENU.'/img/'.$row2['IMATGE'], $CONFIG_PATHMENU.'/img/'.$destName);

        $sql2 = "update MENUITEMS set IMATGE='".addslashes($destName)."' where ID=".$ultimelementcreat;
        @db_query($sql2);
      }



      $result3 = @db_query("SELECT * FROM MENUITEMSSUB WHERE MENUITEM='".$row2['ID']."'");

      while($row3 = db_fetch_array($result3)) {
        $sql3 = "INSERT INTO MENUITEMSSUB
             (TEXT, LINKPAGE, FINESTRA, ORDRE, MENUITEM, `SEPARATOR`,CSSCLASS)
             VALUES
             ('".addslashes($row3['TEXT'])."', '".addslashes($row3['LINKPAGE'])."', '".$row3['FINESTRA']."', '".$row3['ORDRE']."', '$ultimelementcreat', '".$row3['SEPARATOR']."', '".addslashes($row3['CSSCLASS'])."');";
        @db_query($sql3);
      }


    }


/*Donar permissos als administradors*/
  if ($CONFIG_MENUACCES) {
    addPerm($ultimcreat.'_menu');
  }
    goto_url('edita.php?ID='.$ultimcreat);
  }
  else {
    echo db_error();
    echo ("<a href='javascript:history.back()'>".t("back")."</a>");
  }

?>
