// registrar l'acció
FCKCommands.RegisterCommand(
	'SpellCheck',
	new FCKDialogCommand(
		'SpellCheck',
		'Spell Check',
		FCKPlugins.Items['spell'].Path + 'fck_spellerpages.html', 440, 480 )
	);
