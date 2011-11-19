<?php

echo $form->create('Content',array('action'=>'search'));

echo $form->input('input',array('label'=>false,'value'=>'Rechercher','id'=>'SearchInput'));

echo $form->end('Rechercher');

?>
<script type="text/javascript">
	
	$(function(){
		$('#SearchInput').focus(function()
		{
			if($(this).val()=='Rechercher')
			{
				$(this).val('');
			}
		});
		$('#SearchInput').blur(function()
		{
			if($(this).val()=='')
			{
				$(this).val('Rechercher');
			}
		});
	});

</script>