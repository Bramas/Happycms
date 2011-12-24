<?php

echo $this->element('admin_create_form_item');


$options = $this->requestAction('/menus/options_list');

echo $this->Form->input('default_menu_id',array(
	'label'=>'Lien',
	'type'=>'select',
	'options'=>$options
));



