tinyMCEPopup.requireLangPack();

var ImagesDialog = 
{
	init : function(ed) 
	{
		tinyMCEPopup.resizeToInnerSize();
	},

	insert : function(file, title, width, height) 
	{
		var ed = tinyMCEPopup.editor, dom = ed.dom;

		tinyMCEPopup.execCommand('mceInsertContent', false, dom.createHTML('img', {
			src : file,
			alt : title,
			title : title,
			width : width,
			height : height,
			border : 0
		}));

		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(ImagesDialog.init, ImagesDialog);