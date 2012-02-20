<?php

	echo $this->element('admin_create_form_item',array('model'=>'Home'));

	echo $this->Form->input('une',array('label'=>'Que mettre en Une du site : ','options'=>array('news'=>'Dernière news','custom'=>'Texte et image aux choix')));

	echo $this->Form->input('title',array('label'=>'Titre d\'intro :'));
	echo $this->Form->input('text',array('label'=>'Texte d\'intro :','type'=>'textarea','class'=>'noeditor'));
	echo $this->element('happy/fields/file',array('name'=>'img','label'=>'Image d\'intro :'));
	
	$options = $this->requestAction('/admin/menus/options_list');

	echo $this->Form->input('menu_id',array(
		'label'=>'Liens "en savoir plus" : ',
		'type'=>'select',
		'options'=>$options
	));

	echo $this->element('admin_end_form_item');

	?>
	<script type="text/javascript">
	$(function(){
		
		function changeCustomField(duree){

			if($('#HomeFreUne').val()=='custom')
			{
				$('#HomeFreMenuId').parent().slideDown(duree);
				$('#HomeFreText').parent().slideDown(duree);
				$('#HomeFreTitle').parent().slideDown(duree);
				$('#HomeFreImgDelete').next().css('height','120px');
			}
			else
			{
				$('#HomeFreMenuId').parent().slideUp(duree);
				$('#HomeFreText').parent().slideUp(duree);
				$('#HomeFreTitle').parent().slideUp(duree);
				$('#HomeFreImgDelete').next().css('height','1px');
			}

		}
		$('#HomeFreUne').change(function(){ changeCustomField('slow') })
		changeCustomField(0);

	})
	</script>