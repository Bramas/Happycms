(function(){
	
	tinymce.create('tinymce.plugins.hp_image',{
		
		init : function(ed , url){
			
			ed.addCommand('open_image',function(){
				
				var el = ed.selection.getNode();
				var url = ed.settings.image_explorer;
				if(el.nodeName == 'IMG'){
					url = ed.settings.image_edit; 
					url += '?src='+ed.dom.getAttrib(el,'src')+'&alt='+ed.dom.getAttrib(el,'alt')+'&style='+ed.dom.getAttrib(el,'style');
				}
				else
				{
					url += '?filter=Image'
				}

				ed.windowManager.open({
					file : url, 
					id 	 : 'hp_image',
					width: 619,
					height: 550,
					inline: true,
					title : 'Insérer une image'
				},{
					plugin_url : url
				});

			});

			ed.addButton('hp_image',{
				title 	: 'Insérer une image',
				cmd 	: 'open_image',
				image : url + '/img/icon.gif',
				label : 'Insérer une image'
			})

		}

	});

	tinymce.PluginManager.add('hp_image',tinymce.plugins.hp_image);



})(); 