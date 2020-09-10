<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('contingut.php');

	if (empty($_POST['VALOR'])) {
	  htmlPageBasicError('No s\'ha indicat cap valor');
	}

	// --------------------
	// PARAMETERS DEFAULT
	// --------------------
	if (empty($ID))     { echo "<B>Error: No se ha recibido el codigo de card.</B><br>\n"; exit; }

	if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
	if (empty($ECLASS))      { $ECLASS=$DEFAULT_ECLASS; }

	// ------------------
	// CARDS INSTANTATION
	// ------------------
	$dbCards = new dbCards($CARDS_TABLE);
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }

	// -------------
	// DATA UPDATING
	// -------------
	// DATA PREPARATION
	unset($data);

	$avui = date('Y-m-d H:i:s', time());
	$data['MODIFICAT']=$avui;

	$_POST['USUARIMODI'] = $_POST['USUARI'];

	// Passem llista als camps i mirem quins em rebut per POST METHOD
	foreach ($CARDS_FIELDS as $name=>$field)
	{
	  list ($scope, $type, $style) = $field;

	  if (isset($_POST[$name]) || isset($_POST[$name.'_DAY']))
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
	$dbCards->updateCard( $ID, $data );
	if (!$dbCards->Ok) { echo "<B>Error: No se ha podido actualizar el registro.</B><br>".$Cards->Error."\n"; exit; }

	// -----------
	// REDIRECTION
	// -----------
	// Return URL

	//insertar registre d'accions
	register_add("Mida de qüestionaris actualitzada", "$VALOR");
	//fi

	goto_url('index.php');

?>
