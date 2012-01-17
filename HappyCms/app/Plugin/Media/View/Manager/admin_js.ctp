
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
		contextId = contextId?contextId:'null';
		$(this).after('<iframe src="<?php 
			echo $this->Html->url('/media/manager/index/',true); ?>'+contextExtension+'/'+contextId+'/'+domId+'" frameBorder="0" width="560" height="575">');         

		return false;
		
	})

	$(document).bind('onFileChosen',function(event,name,url,id,domId)
	{
		$('#'+domId+'Container img').attr('src',url+'_<?php echo Configure::read('Media.formats.formThumb'); ?>').show();
		$('#'+domId+'Container input').val(id);
		$('#'+domId+'Container iframe').hide();
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
		d.find('.image img').attr('src',url+d.find('.image img').attr('src'));
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
