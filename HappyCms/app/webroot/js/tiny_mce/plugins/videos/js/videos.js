$(function() {
	var url;

	if (url = tinyMCEPopup.getParam("media_external_list_url"))
		document.write('<script language="javascript" type="text/javascript" src="' + tinyMCEPopup.editor.documentBaseURI.toAbsolute(url) + '"></script>');

	var VideoDialog = {
		init : function() {
                    tinyMCEPopup.resizeToInnerSize();
		},

                extract : function()
                {
                    var text = $('#inputVideo').val();
                    var reg = /^[a-zA-Z0-9]+$/;
                    if(reg.test(text))
                    {
                        return(text);
                    }
                    reg = /youtube\.|youtu.be/;
                    if(reg.test(text))
                    {
                        reg=/watch\?v=([a-zA-Z0-9]+)$/;
                        if(reg.test(text))
                        {
                            var matches = text.match(reg);
                            if(matches[1])
                            {
                                return(matches[1]);
                            }
                        }
                        reg=/youtu.be\/([a-zA-Z0-9]+)$/;
                        if(reg.test(text))
                        {
                            var matches = text.match(reg);
                                    
                            if(matches[1])
                            {
                                return(matches[1]);
                            }
                        }
                    }
                    reg=/embed\/([a-zA-Z0-9]+)"/;
                    if(reg.test(text))
                    {
                        var matches = text.match(reg);
                        
                        if(matches[1])
                        {
                            return(matches[1]);
                        }
                    }
                },

		insert : function(embed) {
                    
                    if(embed)
                    {
                        tinyMCEPopup.execCommand('mceInsertContent', false, $('#inputVideoEmbed').val());
                    }
                    else
                    {
                        tinyMCEPopup.execCommand('mceInsertContent', false, '<iframe width="560" height="345" src="http://www.youtube.com/embed/'+this.extract()+'" frameborder="0" allowfullscreen></iframe>');
                    }
                    tinyMCEPopup.close();
                }
        };

        
	tinyMCEPopup.onInit.add(function() {
		VideoDialog.init();
	});
        $('#submit').click(function(){
                VideoDialog.insert();

        });
        $('#submitEmbed').click(function(){
                VideoDialog.insert(true);

        });
    $('#mainForm').submit(function(){
        
        VideoDialog.insert();
        
        return false;
    })
});