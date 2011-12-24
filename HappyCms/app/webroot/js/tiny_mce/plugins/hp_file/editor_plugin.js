(function(){

		tinymce.create('tinymce.plugins.hp_file',{
		
		init : function(ed , url){
			
			ed.addCommand('open_file',function(){
				
				var el = ed.selection.getNode();
				var url = ed.settings.image_explorer;


				ed.windowManager.open({
					file : url, 
					id 	 : 'hp_file',
					width: 619,
					height: 550,
					inline: true,
					title : 'Insérer un fichier'
				},{
					plugin_url : url
				});

			});

			ed.addButton('hp_file',{
				title 	: 'Insérer une fichier',
				cmd 	: 'open_file',
				image : url + '/img/icon.gif',
				label : 'Insérer une fichier'
			})

		}

	});

	tinymce.PluginManager.add('hp_file',tinymce.plugins.hp_file);

})(); 