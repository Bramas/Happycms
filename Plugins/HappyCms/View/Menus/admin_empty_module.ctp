<?php

echo $this->Form->create('Menu',array('action'=>'affect_module','url'=>'/admin/menus/affect_module'));

echo $this->Form->input('extension',array('type'=>'select','options'=>$extensions));
echo $this->Form->input('id',array('type'=>'hidden','value'=>$id));

echo $this->Form->end('Enregistrer');
?>