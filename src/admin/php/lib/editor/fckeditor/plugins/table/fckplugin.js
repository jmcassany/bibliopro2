// registrar l'acció
FCKCommands.RegisterCommand(
	'Table',
	new FCKDialogCommand(
		'Table',
		FCKLang.DlgTableTitle,
		FCKPlugins.Items['table'].Path + 'fck_table.html', 480, 250 )
	);

FCKCommands.RegisterCommand(
	'TableProp',
	new FCKDialogCommand(
		'TableProp',
		FCKLang.DlgTableTitle,
		FCKPlugins.Items['table'].Path + 'fck_table.html?Parent', 480, 250 )
	);

FCKCommands.RegisterCommand(
	'TableCellProp',
	new FCKDialogCommand(
		'TableCellProp',
		FCKLang.DlgCellTitle,
		FCKPlugins.Items['table'].Path + 'fck_tablecell.html', 550, 240 )
	);
