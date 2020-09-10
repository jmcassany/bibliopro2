// registrar l'acció
FCKCommands.RegisterCommand(
	'Antaviana',
	new FCKDialogCommand(
		'Antaviana',
		'Blocs predefinits',
		FCKPlugins.Items['antaviana'].Path + 'antaviana.html', 300, 400 )
	);

// afegir el botto
var oAntavianaItem = new FCKToolbarButton( 'Antaviana', 'Blocs predefinits') ;
oAntavianaItem.IconPath = FCKPlugins.Items['antaviana'].Path + 'houdini_editora.gif' ;

FCKToolbarItems.RegisterItem( 'Antaviana', oAntavianaItem ) ;
