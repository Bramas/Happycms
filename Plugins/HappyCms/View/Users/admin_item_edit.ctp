<?php

//echo $this->element('admin_create_form_item');
$this->Form->create('User', array('autocomplete'=>"off"));
echo $this->Form->input('username',array('label'=>'Identifiant :'));

echo $this->Form->input('newpassword1',array('label'=>'Mot de passe :','type'=>'password','value'=>'','autocomplete' => "off"));
echo $this->Form->input('newpassword2',array('label'=>'Confirmation du mot de passe :','type'=>'password'));

echo $this->Form->input('group_id',array('label'=>'Groupe : ','options'=>array($groupsList)));
echo $this->Form->input('rules',array('label'=>'Règle de sécurité : ','type'=>'text'));

echo $this->Form->input('id',array('type'=>'hidden'));


//echo $this->element('admin_end_form_item');


?>