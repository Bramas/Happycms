<?php

echo $this->element('admin_create_form_item');

echo $form->input('online',array('type'=>'checkbox','label'=>'Site en ligne','class'=>'onlineCheckbox'));
echo $form->input('offline-message',array('label'=>'Message affiché (dans le cas où le site n\'est pas en ligne)'));

echo $form->input('title',array('label'=>'Titre'));

echo $form->input('description',array('label'=>'Desciption'));

echo $form->input('meta-tag',array('label'=>'Mots clefs'));

$options = $this->requestAction('/menus/options_list');

echo $form->input('default_menu_id',array(
	'label'=>'Page d\'accueil : ',
	'type'=>'select',
	'options'=>$options
));

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