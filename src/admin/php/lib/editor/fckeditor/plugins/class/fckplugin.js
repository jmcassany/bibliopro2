// registrar l'acció
FCKCommands.RegisterCommand(
	'PClass',
	new FCKDialogCommand(
		'PClass',
		'Afegir classe',
		FCKPlugins.Items['class'].Path + 'fck_class.html?tag=P', 300, 400 )
	);
FCKCommands.RegisterCommand(
	'H3Class',
	new FCKDialogCommand(
		'H3Class',
		'Afegir classe',
		FCKPlugins.Items['class'].Path + 'fck_class.html?tag=H3', 300, 400 )
	);
FCKCommands.RegisterCommand(
	'H4Class',
	new FCKDialogCommand(
		'H4Class',
		'Afegir classe',
		FCKPlugins.Items['class'].Path + 'fck_class.html?tag=H4', 300, 400 )
	);
FCKCommands.RegisterCommand(
	'H5Class',
	new FCKDialogCommand(
		'H5Class',
		'Afegir classe',
		FCKPlugins.Items['class'].Path + 'fck_class.html?tag=H5', 300, 400 )
	);
FCKCommands.RegisterCommand(
	'H6Class',
	new FCKDialogCommand(
		'H6Class',
		'Afegir classe',
		FCKPlugins.Items['class'].Path + 'fck_class.html?tag=H6', 300, 400 )
	);
FCKCommands.RegisterCommand(
	'LIClass',
	new FCKDialogCommand(
		'LIClass',
		'Afegir classe',
		FCKPlugins.Items['class'].Path + 'fck_class.html?tag=LI', 300, 400 )
	);
FCKCommands.RegisterCommand(
	'BulletedList',
	new FCKDialogCommand(
		'BulletedList',
		'Afegir classe',
		FCKPlugins.Items['class'].Path + 'fck_class.html?tag=UL', 300, 400 )
	);
FCKCommands.RegisterCommand(
	'NumberedList',
	new FCKDialogCommand(
		'NumberedList',
		'Afegir classe',
		FCKPlugins.Items['class'].Path + 'fck_class.html?tag=OL', 300, 400 )
	);



FCK.ContextMenu.RegisterListener({
	AddItems : function( menu, tag, tagName ) {
		// under what circumstances do we display this option
		if (tagName == 'P' || FCKSelection.HasAncestorNode( 'P' )) {
			// afegir separador
			menu.AddSeparator() ;
			// entrada
			menu.AddItem( 'PClass', 'Afegir classe') ;
		} else if (tagName == 'H3' || FCKSelection.HasAncestorNode( 'H3' )) {
			// afegir separador
			menu.AddSeparator() ;
			// entrada
			menu.AddItem( 'H3Class', 'Afegir classe') ;
		} else if (tagName == 'H4' || FCKSelection.HasAncestorNode( 'H4' )) {
			// afegir separador
			menu.AddSeparator() ;
			// entrada
			menu.AddItem( 'H4Class', 'Afegir classe') ;
		} else if (tagName == 'H5' || FCKSelection.HasAncestorNode( 'H5' )) {
			// afegir separador
			menu.AddSeparator() ;
			// entrada
			menu.AddItem( 'H5Class', 'Afegir classe') ;
		} else if (tagName == 'H6' || FCKSelection.HasAncestorNode( 'H6' )) {
			// afegir separador
			menu.AddSeparator() ;
			// entrada
			menu.AddItem( 'H6Class', 'Afegir classe') ;
		}else if (tagName == 'LI' || FCKSelection.HasAncestorNode( 'LI' )) {
			// afegir separador
			menu.AddSeparator() ;
			// entrada
			menu.AddItem( 'LIClass', 'Afegir classe') ;
		}
	}
});
