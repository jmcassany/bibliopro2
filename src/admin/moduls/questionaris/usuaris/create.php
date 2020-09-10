<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('usuaris.php');

	// si existeix un usuari amb el mateix email no el creem
	$result=db_query("select * from $CARDS_TABLE where EMAIL = '$EMAIL'");
	$trobats = db_num_rows($result);

	if($trobats > 0){
		htmlPageBasicError('Ja existeix un usuari amb el correu indicat.');
	}
	else if (empty($_POST['EMAIL'])) {
		htmlPageBasicError('No s\'ha indicat cap correu electrònic per a l\'usuari');
	}

	// --------------------
	// PARAMETERS DEFAULT
	// --------------------
	if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
	if (empty($ECLASS))      { $ECLASS=$DEFAULT_ECLASS; }

	if (empty($SKIN))       { $SKIN=$DEFAULT_SKIN; }
	if (empty($CATEGORY1))  { $CATEGORY1=$DEFAULT_CATEGORY1; }
	if (empty($CATEGORY2))  { $CATEGORY2=$DEFAULT_CATEGORY2; }
	if (empty($STATUS))     { $STATUS=$DEFAULT_STATUS; }
	if (empty($VISIBILITY)) { $VISIBILITY=$DEFAULT_VISIBILITY; }

	// ------------------
	// CARDS INSTANTATION
	// ------------------
	$dbCards = new dbCards($CARDS_TABLE);
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }

	// --------------------
	// DATA PREPARATION
	// --------------------
	unset($data);

	$data['ECLASS']      = (int)trim($ECLASS);
	$data['SKIN']       = (int)trim($SKIN);
	$data['STATUS']     = (int)trim($STATUS);

	$data['CREATION'] = date('Y-m-d H:i:s', time());
	$_POST['USUARICREAR'] = $_POST['USUARI'];
	$_POST['USUARIMODI'] = $_POST['USUARI'];
	$MODIFICAT = $data['CREATION'];

	// Omplim els camps CUSTOM
	foreach ($CARDS_FIELDS as $name=>$field)
	{
	  list ($scope, $type, $style) = $field;
	  if ($scope=='CUSTOM' && (isset($_POST[$name]) || isset($_POST[$name.'_DAY'])))
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

			if ($type=='DATE') {
				$year=trim(${$name.'_YEAR'});
				$month=trim(${$name.'_MONTH'});
				$day=trim(${$name.'_DAY'});
				$hour=trim(${$name.'_HOUR'});
				$min=trim(${$name.'_MIN'});
				$sec=trim(${$name.'_SEC'});
				$data[$name]="$year-$month-$day hour:min:sec";
			}
	  } // end if
	} // end foreach

	// --------------
	// DATA INSERTION
	// --------------
	$data['MODIFICAT'] = $data['CREATION'];

	if (isset($_POST['NEWSLETTER'])) { $data['NEWSLETTER'] = 1; }
	else { $data['NEWSLETTER'] = 0; }

	$id = $dbCards->newCard($data);
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear nueva ficha.</B><br>\n"; exit; }

	// IMPORTANT: AQUÍ CALDRIA AFEGIR L'USUARI A LA TAULA D'USUARI DEL HOUDINI


	// -----------
	// REDIRECTION
	// -----------
	// Return URL

	//insertar registre d'accions
	register_add("Usuari de qüestionaris creat", "$EMAIL");
	//fi

	// tornem al llistat d'usuaris
	goto_url('index.php');

?>
