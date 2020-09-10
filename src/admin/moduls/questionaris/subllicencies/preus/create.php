<?php

	require ('../../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('preus.php');

	// si no s'indica el qüestionari per als descarregables, mostrem error
	if (empty($_POST['ID_SUBLICENCIA'])) {
		htmlPageBasicError('No s\'ha indicat cap subllicència per a gestionar-ne els preus.');
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

	$id = $dbCards->newCard($data);
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear nueva ficha.</B><br>\n"; exit; }

	// -----------
	// REDIRECTION
	// -----------
	// Return URL

	//insertar registre d'accions
	register_add("Preu de subllicència de qüestionaris creat", "$_POST[ID_SUBLICENCIA]");
	//fi

	// tornem al llistat d'autors
	goto_url('index.php?ID_SUBLICENCIA=' . $_POST['ID_SUBLICENCIA']);

?>
