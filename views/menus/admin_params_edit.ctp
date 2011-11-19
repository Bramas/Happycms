<?php

echo $this->element('admin_create_form_item');


$options = $this->requestAction('/menus/options_list');

echo $form->input('default_menu_id',array(
	'label'=>'Lien',
	'type'=>'select',
	'options'=>$options
));



