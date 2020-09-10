<?php

require ('../config_admin.inc');
accessGroupPermCheck('template_create');
include_once("plantilles.php");


 $ID=$_GET['ID'];



 $result=db_query("select * from PLANTILLA where ID = '$ID'");
 $row = db_fetch_array($result);
 $DESCRIPCIO="copia de ".$row['DESCRIPCIO'];

 $data = date('Y-m-d H:i:s', time());
 $result = db_query ('INSERT INTO PLANTILLA
  (
	 ECLASS,	 SKIN,
	 CATEGORY1,	 CATEGORY2,
	 STATUS,	 VISIBILITY,
	 CREATION,	 START_TIME,
	 END_TIME,	 NOM,
	 DESCRIPCIO,	 TEXTCURT,
	 TEXTLLARG,	 IMATGES,
	 ADJUNTS,	 PARE,
	 IDIOMA
  )
  VALUES
  (
	 '.$row['ECLASS'].',	 '.$row['SKIN'].',
	 '.$row['CATEGORY1'].',	 '.$row['CATEGORY2'].',
	 '.$row['STATUS'].',	 '.$row['VISIBILITY'].',
	 \''.$data.'\',	 \''.$row['START_TIME'].'\',
	 \''.$row['END_TIME'].'\',	 \''.$row['NOM'].'\',
	 \''.$DESCRIPCIO.'\',	 \''.$row['TEXTCURT'].'\',
	 \''.$row['TEXTLLARG'].'\',	 \''.$row['IMATGES'].'\',
	 \''.$row['ADJUNTS'].'\',	 \''.$row['PARE'].'\',
	 \''.$row['IDIOMA'].'\'
  )');

 if ($result) {
   $result=db_query("select MAX(ID) AS ID from PLANTILLA");
   $row = db_fetch_array($result);
   $maxid = $row['ID'];
   $result=db_query("select * from PLANTILLA_DESC where PLANTILLA = '$ID'");
   $row = db_fetch_array($result);
   $result = db_query ('INSERT INTO PLANTILLA_DESC
   (
	 PLANTILLA,
	 TEXTC1,	 TEXTC2,	 TEXTC3,	 TEXTC4,
	 TEXTC5,	 TEXTC6,	 TEXTC7,	 TEXTC8,
	 TEXTC9,	 TEXTC10,	 TEXTC11,	 TEXTC12,
	 TEXTC13,	 TEXTC14,	 TEXTC15,	 TEXTC16,
	 TEXTC17,	 TEXTC18,	 TEXTC19,	 TEXTC20,
	 TEXTC21,	 TEXTC22,	 TEXTC23,	 TEXTC24,
	 TEXTC25,	 TEXTC26,	 TEXTC27,	 TEXTC28,
	 TEXTC29,	 TEXTC30,	 TEXTC31,	 TEXTC32,
	 TEXTC33,	 TEXTC34,	 TEXTC35,	 TEXTC36,
	 TEXTC37,	 TEXTC38,	 TEXTC39,	 TEXTC40,
	 TEXTC41,	 TEXTC42,	 TEXTC43,	 TEXTC44,
	 TEXTC45,
     TEXTL1,	 TEXTL2,     TEXTL3,	 TEXTL4,
     TEXTL5,	 TEXTL6,     TEXTL7,	 TEXTL8,
     TEXTL9,	 TEXTL10,     IMATGE1,	 IMATGE2,
     IMATGE3,	 IMATGE4,     IMATGE5,	 IMATGE6,
     IMATGE7,	 IMATGE8,     IMATGE9,	 IMATGE10,
     IMATGE11,	 IMATGE12,     IMATGE13,	 IMATGE14,
     IMATGE15,	 IMATGE16,     IMATGE17,	 IMATGE18,
     IMATGE19,	 IMATGE20,     IMATGE21,	 IMATGE22,
     IMATGE23,	 IMATGE24,     IMATGE25,
	 ADJUNT1,	 ADJUNT2,	 ADJUNT3,	 ADJUNT4,
	 ADJUNT5,	 ADJUNT6,	 ADJUNT7,	 ADJUNT8,
	 ADJUNT9,	 ADJUNT10,
	 ALT1,	 ALT2,	 ALT3,	 ALT4,
	 ALT5,	 ALT6,	 ALT7,	 ALT8,
	 ALT9,	 ALT10
   )
   VALUES
   (
	 '.$maxid.',
	 \''.$row['TEXTC1'].'\',	 \''.$row['TEXTC2'].'\',
	 \''.$row['TEXTC3'].'\',	 \''.$row['TEXTC4'].'\',
	 \''.$row['TEXTC5'].'\',	 \''.$row['TEXTC6'].'\',
	 \''.$row['TEXTC7'].'\',	 \''.$row['TEXTC8'].'\',
	 \''.$row['TEXTC9'].'\',	 \''.$row['TEXTC10'].'\',
	 \''.$row['TEXTC11'].'\',	 \''.$row['TEXTC12'].'\',
	 \''.$row['TEXTC13'].'\',	 \''.$row['TEXTC14'].'\',
	 \''.$row['TEXTC15'].'\',	 \''.$row['TEXTC16'].'\',
	 \''.$row['TEXTC17'].'\',	 \''.$row['TEXTC18'].'\',
	 \''.$row['TEXTC19'].'\',	 \''.$row['TEXTC20'].'\',
	 \''.$row['TEXTC21'].'\',	 \''.$row['TEXTC22'].'\',
	 \''.$row['TEXTC23'].'\',	 \''.$row['TEXTC24'].'\',
	 \''.$row['TEXTC25'].'\',	 \''.$row['TEXTC26'].'\',
	 \''.$row['TEXTC27'].'\',	 \''.$row['TEXTC28'].'\',
	 \''.$row['TEXTC29'].'\',	 \''.$row['TEXTC30'].'\',
	 \''.$row['TEXTC31'].'\',	 \''.$row['TEXTC32'].'\',
	 \''.$row['TEXTC33'].'\',	 \''.$row['TEXTC34'].'\',
	 \''.$row['TEXTC35'].'\',	 \''.$row['TEXTC36'].'\',
	 \''.$row['TEXTC37'].'\',	 \''.$row['TEXTC38'].'\',
	 \''.$row['TEXTC39'].'\',	 \''.$row['TEXTC40'].'\',
	 \''.$row['TEXTC41'].'\',	 \''.$row['TEXTC42'].'\',
	 \''.$row['TEXTC43'].'\',	 \''.$row['TEXTC44'].'\',
	 \''.$row['TEXTC45'].'\',	 \''.$row['TEXTL1'].'\',
	 \''.$row['TEXTL2'].'\',	 \''.$row['TEXTL3'].'\',
	 \''.$row['TEXTL4'].'\',	 \''.$row['TEXTL5'].'\',
	 \''.$row['TEXTL6'].'\',	 \''.$row['TEXTL7'].'\',
	 \''.$row['TEXTL8'].'\',	 \''.$row['TEXTL9'].'\',
	 \''.$row['TEXTL10'].'\',	 \''.$row['IMATGE1'].'\',
	 \''.$row['IMATGE2'].'\',	 \''.$row['IMATGE3'].'\',
	 \''.$row['IMATGE4'].'\',	 \''.$row['IMATGE5'].'\',
	 \''.$row['IMATGE6'].'\',	 \''.$row['IMATGE7'].'\',
	 \''.$row['IMATGE8'].'\',	 \''.$row['IMATGE9'].'\',
	 \''.$row['IMATGE10'].'\',	 \''.$row['IMATGE11'].'\',
	 \''.$row['IMATGE12'].'\',	 \''.$row['IMATGE13'].'\',
	 \''.$row['IMATGE14'].'\',	 \''.$row['IMATGE15'].'\',
	 \''.$row['IMATGE16'].'\',	 \''.$row['IMATGE17'].'\',
	 \''.$row['IMATGE18'].'\',	 \''.$row['IMATGE19'].'\',
	 \''.$row['IMATGE20'].'\',	 \''.$row['IMATGE21'].'\',
	 \''.$row['IMATGE22'].'\',	 \''.$row['IMATGE23'].'\',
	 \''.$row['IMATGE24'].'\',	 \''.$row['IMATGE25'].'\',
	 \''.$row['ADJUNT1'].'\',	 \''.$row['ADJUNT2'].'\',
	 \''.$row['ADJUNT3'].'\',	 \''.$row['ADJUNT4'].'\',
	 \''.$row['ADJUNT5'].'\',	 \''.$row['ADJUNT6'].'\',
	 \''.$row['ADJUNT7'].'\',	 \''.$row['ADJUNT8'].'\',
	 \''.$row['ADJUNT9'].'\',	 \''.$row['ADJUNT10'].'\',
	 \''.$row['ALT1'].'\',	 \''.$row['ALT2'].'\',
	 \''.$row['ALT3'].'\',	 \''.$row['ALT4'].'\',
	 \''.$row['ALT5'].'\',	 \''.$row['ALT6'].'\',
	 \''.$row['ALT7'].'\',	 \''.$row['ALT8'].'\',
	 \''.$row['ALT9'].'\',	 \''.$row['ALT10'].'\'
   )');
   if($result) {
   	//insertar registre d'accions
    register_add(t("dinamicsregistryduplicate"), $TAULA);
	//fi

    goto_url('index.php?TAULA='.$TAULA);
   }

 }
 echo db_error();
 echo ("<a href='javascript:history.back()'>".t('back')."</a>");




?>
