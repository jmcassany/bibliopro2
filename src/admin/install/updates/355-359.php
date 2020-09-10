<?php

require ('../../config_admin.inc');



/*arreglar taula idiomes de carpetes*/
db_query('rename table CARPETES_IDIOMES to CARPETES_IDIOMES_355;');
db_query("
CREATE TABLE CARPETES_IDIOMES (
  ID int(11) NOT NULL,
  IDIOMA char(2) NOT NULL,
  TITOL char(150) NOT NULL default '',
  PRIMARY KEY (ID, IDIOMA)
) TYPE=MyISAM;
");
$result = db_query('select * from CARPETES_IDIOMES_355');
while ($row = db_fetch_array($result)) {
  if ($row['TITOL'] != '') {
    db_query("insert into CARPETES_IDIOMES set ID=%d, IDIOMA='%s', TITOL='%s'", $row['CARPETA'], $row['IDIOMA'], $row['TITOL']);
  }
}

echo '<h2>fet, esborra la taula CARPETES_IDIOMES_355</h2>';



/*canvia el nom a les taules d'editores dinamiques*/
	$result = db_query("select ID, RUTA, NOMCARPETA from CARPETES Where CATEGORY1='1' ORDER BY DESCRIPCIO ASC");

	while ($value = db_fetch_array($result)) {
		$nomtaula = str_replace("/", "$", $value['RUTA']);
		$nomtaula = $value['NOMCARPETA'] . "$" . $nomtaula;
		db_query("rename table " . $nomtaula . " to editora_".$value['ID']);
		echo '<p class="message">moguda taula ' . $nomtaula . ' a la editora_'.$value['ID'] . '</p>';
	}
	$result = db_query("show tables;");

	echo '<p class="warning">s\'han trobat les següents taules dinamiques a convertir:';
	echo '<ul>';
	while ($row = db_fetch_array($result)) {
		$taula = array_shift($row);

		if (ereg('.*\$home$', $taula)) {
			echo '<li>S\'ha trobat la taula ' . $taula . ' no convertida</li>';
		}
	}
	echo '</ul>';
	echo 'Comprova que la conversió ha estat correcte</p>';


	/*canviar ruta de pagines i formularis, menus, plantilles i carpetes
	per id de carpeta*/
	echo '<p class="message">canviant les rutes de les taules per identificadors</p>';
	db_query("alter table ESTATICA add column PARE integer NOT NULL");
	db_query("alter table ESTATICA drop index NOMPAG");
	db_query("alter table ESTATICA add index NOMPAG (NOMPAG,PARE)");
	db_query("alter table FORMULARIS add column PARE integer NOT NULL");
	db_query("alter table FORMULARIS drop index NOMFORMULARI");
	db_query("alter table FORMULARIS add index NOMFORMULARI (NOMFORMULARI,PARE)");
	db_query("alter table CARPETES add column PARE integer default NULL");
	db_query("alter table CARPETES drop index NOMCARPETA");
	db_query("alter table CARPETES add index NOMCARPETA (NOMCARPETA,PARE)");
	db_query("alter table MENUS add column PARE integer NOT NULL");
	db_query("alter table PLANTILLA add column PARE integer NOT NULL");


	$result = db_query("select ID, NOMCARPETA, RUTA from CARPETES Where CATEGORY1='0' ORDER BY DESCRIPCIO ASC");

	while ($value = db_fetch_array($result)) {
		db_query("update ESTATICA set PARE=" . $value['ID'] . " where RUTA='" . $value['RUTA'].'/'.$value['NOMCARPETA'] . "'");
		db_query("update FORMULARIS set PARE=" . $value['ID'] . " where MODUL='" . $value['RUTA'].'/'.$value['NOMCARPETA'] . "'");
		db_query("update MENUS set PARE=" . $value['ID'] . " where MODUL='" . $value['RUTA'].'/'.$value['NOMCARPETA'] . "'");
		db_query("update PLANTILLA set PARE=" . $value['ID'] . " where MODUL='" . $value['RUTA'].'/'.$value['NOMCARPETA'] . "'");
		db_query("update CARPETES set PARE=" . $value['ID'] . " where RUTA='" . $value['RUTA'].'/'.$value['NOMCARPETA'] . "'");
	}
	/*posar les carpetes sense pare com a carpeta inici*/
	$resut = db_query("select * from CARPETES where PARE is null AND NOMCARPETA='home'");
	if (db_num_rows($resut) > 0) {
		db_query("update CARPETES set NOMCARPETA='' where PARE is null AND NOMCARPETA='home'");
	} else {
		db_query("insert into CARPETES set NOMCARPETA='', CATEGORY1=0, DESCRIPCIO='Home'");
	}
	$result = db_query("select ID from CARPETES where PARE is null AND NOMCARPETA=''");
	$row = db_fetch_array($result);
	db_query("update CARPETES set PARE='".$row['ID']."' where RUTA='home'");

	db_query("update CARPETES set CARPETAINICI=1 where PARE is null");
	$result = db_query("select * from ESTATICA where PARE is null");

	while ($row = db_fetch_array($result)) {
		echo '<p class="error">la pagina ' . $row['NOMPAG'] . ' no te pare</p>';
	}
	$result = db_query("select * from FORMULARIS where PARE is null");

	while ($row = db_fetch_array($result)) {
		echo '<p class="error">el formulari ' . $row['NOMFORMULARI'] . ' no te pare</p>';
	}
	$result = db_query("select * from MENUS where PARE is null");

	while ($row = db_fetch_array($result)) {
		echo '<p class="error">el menu ' . $row['NOM'] . ' no te pare</p>';
	}
	$result = db_query("select * from PLANTILLA where PARE is null");

	while ($row = db_fetch_array($result)) {
		echo '<p class="error">la plantilla ' . $row['NOM'] . ' no te pare</p>';
	}
	$result = db_query("select * from CARPETES where PARE is null");

	while ($row = db_fetch_array($result)) {
		echo '<p class="error">la carpeta ' . $row['NOMCARPETA'] . ' no te pare</p>';
	}
	echo '<p class="warning">Comprova que la conversió ha estat correcte</p>';
	echo '<p class="warning">Elimina la columna RUTA de la taula estatica, la columna MODUL de la taula formularis,
	 la columna MODUL de la taula menus, la columna MODUL de la taula plantilles,
	 i la columna RUTA de la taula carpetes</p>';

?>
