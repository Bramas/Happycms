<?php

echo $this->element('admin_create_form_item');

echo $this->Form->input('online',array('type'=>'checkbox','label'=>'Site en ligne','class'=>'onlineCheckbox'));
echo $this->Form->input('offline-message',array('label'=>'Message affiché (dans le cas où le site n\'est pas en ligne)'));

echo $this->Form->input('title',array('label'=>'Titre'));

echo $this->Form->input('description',array('label'=>'Desciption'));

echo $this->Form->input('meta-tag',array('label'=>'Mots clefs'));

$options = $this->requestAction('/admin/menus/options_list');

echo $this->Form->input('default_menu_id',array(
	'label'=>'Page d\'accueil : ',
	'type'=>'select',
	'options'=>$options
));

echo $this->Form->input('contactEmail',array('label'=>'Email de contact :'));

echo $this->element('admin_end_form_item');

?>

<script type="text/javascript">
	
	$(function(){
		
		function onlineCheckboxChange(t,duree)
		{
			if($(t).is(':checked'))
			{
				$(t).parent().next().hide(duree);
			}
			else
			{
				$(t).parent().next().show(duree);
			}
		}
		$('.onlineCheckbox').change(function(){
			onlineCheckboxChange(this,'slow');
			
		});
		onlineCheckboxChange('.onlineCheckbox',0);

	});

</script>