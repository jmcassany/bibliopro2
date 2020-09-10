// registrar l'acció
FCKCommands.RegisterCommand(
	'Link',
	new FCKDialogCommand(
		'Link',
		FCKLang.DlgLnkWindowTitle,
		FCKPlugins.Items['link'].Path + 'fck_link.html', 400, 300)
	);
