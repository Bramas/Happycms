<?php


?>
<div id="filesList">
	<?php foreach ($medias as $k => $v): $v = current($v); ?>
	<div class="media" media_id="<?php echo $v['id']; ?>" title="<?php echo $v['name']; ?>" media_url="<?php echo $v['url']; ?>">
		<div class="image"><img src="<?php 
		
		//echo $v['url'];
		
		 ?>_<?php echo Configure::read('Media.formats.browserThumb'); ?>" ></div>
		<div class="filename"><?php echo $v['name']; ?></div>
		<div class="actions" style="display:none">
			<div class="action delete">
				X
			</div>
		</div>
	</div>
	<?php endforeach ?>

	<div class="clear"></div>
</div>


<div class="clear"></div>
<div id="filter">
	<?php 
		echo $this->Form->create('Media');

		$mediaExtensions = Configure::read('Media.Extensions');
		$options = array();
		$options['All']='Tout les fichier';
		foreach(array_keys($mediaExtensions) as $e)
		{
			//debug($e);
			$options[$e] = $e;
		}
		echo $this->Form->input('filter',array('label'=>'Type de fichier : ','options'=>
		//array('All'=>'Tout les fichier','Image'=>'Image','Archive'=>'Archive')
		$options
		));

		echo $this->Form->end();
		?>

</div>
<div id="uploader">
	<h3>Ajouter un fichier</h3>

<iframe  frameborder="0" width="310" height="100" src="<?php echo $this->Html->url(array('plugin'=>'media','controller'=>'manager','action'=>'upload_form','admin'=>true,$contextExtension,$contextId,'testDomId')); ?>" scrolling="no"></iframe>

</div>

<?php 
if($domId == 'tinyMce')
{
	echo $this->Html->script('tiny_mce/tiny_mce_popup.js');
}
 ?>

<script type="text/javascript">
$(function(){
	
	$(document).bind('MediaFileUploaded',function(event,name,url,id)
	{
		/*var imageExtension = <?php echo json_encode(Configure::read('Media.Extensions.Image')); ?>;

		var ext = url.split('.');
		ext = ext.slice(-1);
		
		function contains(v,a)
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
		if(contains(ext,imageExtension))
		{

		}
		else
		{

		}*/

		var newItem = $('<div class="media" media_id="'+id+'" title="'+name+'" media_url="'+url+'">'+
		'<div class="image"><img src="_<?php echo Configure::read('Media.formats.browserThumb'); ?>" ></div>'+
		'<div class="filename">'+name+'</div><div class="actions" style="display:none">'+
	'<div class="action delete">X</div></div></div>');
		
		HAttachAnIcon(newItem);

		var clear = $('#filesList .clear').detach();
		$('#filesList').append(newItem);
		$('#filesList').append(clear);
		
	});

	$('#filesList .media').live('click',function(){
		var id = $(this).attr('media_id');
		var name = $(this).attr('title');
		var url = $(this).attr('media_url');
		var type = $(this).attr('media_type');

		if('<?php echo $domId; ?>'=='tinyMce')
		{
			if(type=='Image')
			{
				window.location.href='<?php echo $this->Html->url(array(
					'plugin'=>'media',
					'controller'=>'manager',
					'action'=>'tiny_show',
					'admin'=>true

				),true) ?>/'+id;
			}
			else
			{
				var win = window.dialogArugments || opener || parent || top;
				win.send_to_editor('<a href="'+url+'" alt="'+name+'">'+name+'</a>');
				tinyMCEPopup.close();
			}
			
		}
		else
		{
			var win = window.dialogArugments || opener || parent || top;
			try{
				win.onFileChosen(name,url,id,'<?php echo $domId; ?>');
			}
			catch(e)
			{
				alert(e);
				
			}
		}
		


	});
	$('.media').live('mouseover',function(){
		$(this).find('.actions').show();
	});
	$('.media').live('mouseout',function(){
		$(this).find('.actions').hide();
	});

	$('.actions .action.delete').live('click',function(){
		var media_id = $(this).parent().parent().attr('media_id');
		var d = $(this).parent().parent();

		d.animate({ opacity: 0.35 },300);

		$.ajax({
			url:'<?php echo $this->Html->url(array(
					'plugin'=>'media',
					'controller'=>'manager',
					'action'=>'delete',
					'admin'=>true,
				)); ?>/'+media_id,
			type:'POST',
			data:{ "data[ajax]":1 },
			context:d,
			dataType:'json',
			success:function(d){
				if(!d.result)
				{
					
				}
				this.fadeOut('fast').hide();

			}

		})

		return false;
	});


	function filterFiles()
	{
		var type = $('#MediaFilter').val();

		if(type && type!='All')
		{
			$('#filesList .media').hide();
			$('#filesList .media[media_type="'+type+'"]').show();
		}
		else
		{
			$('#filesList .media').show();
		}
		
	}

	$('#MediaFilter').change(filterFiles);

	filterFiles();
});

</script>