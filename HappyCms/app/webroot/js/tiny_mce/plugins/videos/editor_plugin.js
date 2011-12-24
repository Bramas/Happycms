/**
 * @author Antonov Andrey http://dustweb.ru/
 * @copyright Copyright ? 2008-2009, Antonov A Andrey, All rights reserved.
 */

(function() {
	// Load plugin specific language pack
	//tinymce.PluginManager.requireLangPack('example');
	tinymce.create('tinymce.plugins.VideosPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceVideos', function() {
				ed.windowManager.open({
					file : url + '/videos.html',
					width : 350 + parseInt(ed.getLang('images.delta_width', 0)),
					height : 250 + parseInt(ed.getLang('images.delta_height', 0)),
					inline: true,
					popup_css : false
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('videos', {
				title : 'Ajouter une vidéo',
				cmd : 'mceVideos',
				image : url + '/video.gif',
				label : 'Ajouter une vidéo'
			});
		},

		getInfo : function() {
			return {
				longname : 'Videos',
				author : 'Quentin BRAMAS',
				authorurl : 'http://www.bramas.fr',
				infourl : 'http://www.bramas.fr',
				version : '1.0'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('videos', tinymce.plugins.VideosPlugin);
})();