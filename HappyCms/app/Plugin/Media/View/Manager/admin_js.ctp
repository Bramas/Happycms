
function onFileUploaded(name,url,id,domId)
{
	$(document).trigger('MediaFileUploaded',[name,url,id,domId]);
}	
function onFileChosen(name,url,id,domId)
{
	$(document).trigger('onFileChosen',[name,url,id,domId]);
}
$(function(){
	

	$('.media-link-to-explorer').click(function(){
		
        var defaultId = $(this).attr('media_id');
        var contextExtension = $(this).attr('contextExtension');
        var domId = $(this).attr('dom_id');
        var contextId = $(this).attr('contextId');
        var multiple = $(this).attr('multiple')==undefined?'0':'1';
        var checkList = $(this).attr('checkList');
		contextId = contextId?contextId:'null';
		/*$(this).after('<iframe src="<?php 
			echo $this->Html->url('/media/manager/index/',true); ?>'+contextExtension+'/'+contextId+
			'/'+domId+'" frameBorder="0" width="560" height="575">');  */
			if($('#iframe-'+domId).length)
			{
				$('#iframe-'+domId).dialog('open').css('height','575px').css('width','680px');;
			}   
			else
			{
				$('<iframe id="iframe-'+domId+'" src="<?php 
				echo $this->Html->url('/media/manager/index/',true); ?>'+contextExtension+'/'+contextId+
				'/'+domId+'/'+multiple+'?checkList='+checkList+'" frameBorder="0" style="height: 100%;margin-left: -15px;width: 100%;">').dialog(
					{
						modal:true,
						autoOpen: false,
						width:650,
						height:610
					}).dialog( "open" ).load(function()
						{
							$(this).css('height','575px').css('width','680px');
						}
					); 
			}
			

		return false;
		
	})
	function randomString(string_length) {
		   var text = "";
		    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		    for( var i=0; i < string_length; i++ )
		        text += possible.charAt(Math.floor(Math.random() * possible.length));

		    return text;

		};
	$(document).bind('onFileChosen',function(event,name,url,id,domId)
	{
		var r = randomString(10);
		if($('#'+domId+'Container .media-link-to-explorer').attr('multiple'))
		{
			$('#'+domId+'Container input.empty').clone().val(url).removeClass('empty').attr('uid',r).appendTo('#'+domId+'Container');
			var temp = $('#'+domId+'Container .filesImagesContainter .empty').clone();
			temp.removeClass('empty').appendTo('#'+domId+'Container .filesImagesContainter');
			temp.attr('uid',r);
			temp.attr('title',name);
			temp=temp.find('img').first();
			temp.removeClass('empty');
			temp.attr('title',name).attr('src','<?php echo $this->Html->url('/',true); ?>'+url+'_<?php echo Configure::read('Media.formats.formThumb'); ?>');
			$('#'+domId+'Container .filesImagesContainter .clear').remove();
			$('#'+domId+'Container .filesImagesContainter').append('<div class="clear"></div>');
		}
		else
		{
			$('#'+domId+'Container img').attr('src','<?php echo $this->Html->url('/',true); ?>'+url+'_<?php echo Configure::read('Media.formats.formThumb'); ?>').show();
			$('#'+domId+'Container input').val(url);
			$('#iframe-'+domId).dialog('close');
		}

	});



	$('#filesList .media').each(function()
	{
		HAttachAnIcon($(this));
	});

	
});
function arrayContains(v,a)
{
	for(var idx=0;idx<a.length;idx++)
	{
		if(a[idx] == v)
		{
			return true;
		}
	}
	return false;
}
function HAttachAnIcon(d)
{
	var typeExtension = <?php echo json_encode(Configure::read('Media.Extensions')); ?>;
	var thumbExtension = <?php echo json_encode(Configure::read('Media.ThumbExtensions')); ?>;
	var baseExtUrl = '<?php echo $this->Html->url('/media/ext/'); ?>'
	var url = d.attr('media_url');
	var ext = url.split('.');
		ext = ext.slice(-1);
	var type = 'default';

	for(var o in typeExtension)
	{
		if(arrayContains(ext,typeExtension[o]))
		{
			type=o;
			break;
		}	
	}
	d.attr('media_type',type);
	if(type=='Image')
	{
		d.find('.image img').attr('src','<?php echo $this->Html->url('/',true); ?>'+url+d.find('.image img').attr('src'));
	}
	else
	{
		/*if($.inArray(type,thumbExtension)>-1)
		{
			d.find('.image img').attr('src',thumbExtension[$.inArray(type,thumbExtension)]);
		}*/
		//else
		{
			d.find('.image img').attr('src',baseExtUrl+type+'.png'+d.find('.image img').attr('src'));
		}
		
	}
}
