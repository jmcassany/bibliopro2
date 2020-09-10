<?php

	require ('../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('questionaris.php');

	$result1 = db_query("select * from `$CARDS_TABLE` where ID = '$ID' LIMIT 1");
	$row = db_fetch_array($result1);

	// comprovem quina és la última versió del qüestionari
	$latestVersionQuery = db_query("
		select VERSION
		from `$CARDS_TABLE`
		where ID_CUEST = '$row[ID_CUEST]'
		order by VERSION desc
	");
	$latestVersionRow = db_fetch_array($latestVersionQuery);

	foreach($row as $key => $value) {
		$row[$key] = addslashes($value);
	}

	$sql = "INSERT INTO `$CARDS_TABLE` (
		ECLASS,
		STATUS,
		CREATION,
		USUARICREAR,
		ID_CUEST,
		VERSION,
		IDENTIFICADO,
		DISPONIBLE,
		EVALUADO,
		NOM_ORIGINAL,
		NOM_CAST,
		SIGLAS,
		CONTENIDO,
		ENFERMEDAD,
		POBLACION,
		EDAD,
		MEDIDA,
		REFERENCIA_ORIGINAL,
		REFERENCIA_CAST,
		CORRESPONDENCIA_ORIGINAL,
		CORRESPONDENCIA_CAST,
		COPYRIGHT_ORIGINAL,
		COPYRIGHT_CAST,
		OTROS_ORIGINAL,
		OTROS_CAST,
		NUMERO_ITEMS,
		DIMENSIONES,
		PALABRAS_CLAVE,
		EMAIL_CONTACTO_ORIGINAL,
		EMAIL_CONTACTO_CAST,
		IDIOMA_ORIGINAL,
		IDIOMA_CAST,
		PAIS,
		IDAUTORES_ORIGINAL,
		IDAUTORES_CAST,
		AUTORES_EXTRA_ORIGINAL,
		AUTORES_EXTRA_CAST
	)
	VALUES (
		'$row[ECLASS]',
		'$row[STATUS]',
		SYSDATE(),
		'".accessGetLogin()."',
		'$row[ID_CUEST]',
		'" . ($latestVersionRow['VERSION'] + 1) . "',
		'$row[IDENTIFICADO]',
		'$row[DISPONIBLE]',
		'$row[EVALUADO]',
		'" . $row['NOM_ORIGINAL'] . "',
		'" . $row['NOM_CAST'] . "',
		'" . $row['SIGLAS'] . "',
		'" . $row['CONTENIDO'] . "',
		'" . $row['ENFERMEDAD'] . "',
		'" . $row['POBLACION'] . "',
		'" . $row['EDAD'] . "',
		'" . $row['MEDIDA'] . "',
		'" . $row['REFERENCIA_ORIGINAL'] . "',
		'" . $row['REFERENCIA_CAST'] . "',
		'" . $row['CORRESPONDENCIA_ORIGINAL'] . "',
		'" . $row['CORRESPONDENCIA_CAST'] . "',
		'" . $row['COPYRIGHT_ORIGINAL'] . "',
		'" . $row['COPYRIGHT_CAST'] . "',
		'" . $row['OTROS_ORIGINAL'] . "',
		'" . $row['OTROS_CAST'] . "',
		'" . $row['NUMERO_ITEMS'] . "',
		'" . $row['DIMENSIONES'] . "',
		'" . $row['PALABRAS_CLAVE'] . "',
		'" . $row['EMAIL_CONTACTO_ORIGINAL'] . "',
		'" . $row['EMAIL_CONTACTO_CAST'] . "',
		'" . $row['IDIOMA_ORIGINAL'] . "',
		'" . $row['IDIOMA_CAST'] . "',
		'" . $row['PAIS'] . "',
		'" . $row['IDAUTORES_ORIGINAL'] . "',
		'" . $row['IDAUTORES_CAST'] . "',
		'" . $row['AUTORES_EXTRA_ORIGINAL'] . "',
		'" . $row['AUTORES_EXTRA_CAST'] . "'
	)";

	$result = db_query($sql);

	if($result) {
		goto_url('versions.php?ID_CUEST='.$row['ID_CUEST']);
	}
	else {
	  echo db_error();
	  echo ("<a href='javascript:history.back()'>Tornar</a>");
	}

?>
