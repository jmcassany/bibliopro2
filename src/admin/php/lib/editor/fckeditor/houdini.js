FCKConfig.ToolbarSets["Antavianabasic"] = [
	['Source','Bold','Italic','-','Paste','PasteText','PasteWord','-','Link','Unlink','SpellCheck','FitWindow','ShowBlocks']
] ;
FCKConfig.ToolbarSets["AntavianaNL"] = [
	['Source','Bold','Italic','-','Paste','PasteText','PasteWord','-','Link','Unlink','SpellCheck','FitWindow','ShowBlocks']
] ;
FCKConfig.ToolbarSets["Antaviana"] = [
	['Source','-','Preview'/*,'Templates'*/],
	['Cut','Copy','Paste','PasteText','PasteWord','SpellCheck'],
	['SelectAll','RemoveFormat'],
	['Bold','Italic'],
	['OrderedList','UnorderedList','-','Outdent','Indent','Blockquote'],
	['Image','Link','Unlink','Anchor'],
	['Table'],
	['SpecialChar','Antaviana'],
	[/*'Style',*/'FontFormat','FitWindow','ShowBlocks']
];


FCKConfig.Plugins.Add( 'antaviana') ;
FCKConfig.Plugins.Add( 'class') ;
FCKConfig.Plugins.Add( 'spell') ;
FCKConfig.Plugins.Add( 'image') ;
FCKConfig.Plugins.Add( 'link') ;
FCKConfig.Plugins.Add( 'table') ;
