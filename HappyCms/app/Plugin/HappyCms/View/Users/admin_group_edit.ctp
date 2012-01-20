<?php

//echo $this->element('admin_create_form_item');
echo $this->Form->create('Group', array('autocomplete'=>"off",'url'=>'/admin/users/group_save'));
echo $this->Form->input('name',array('label'=>'Nom :'));

echo $this->Form->input('rules',array('label'=>'Règle de sécurité : ','type'=>'text'));

echo $this->Form->input('id',array('type'=>'hidden'));


echo $this->Form->end('Enregistrer');


?>