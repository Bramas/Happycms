<?php

echo $form->create('Menu',array('action'=>'affect_module'));

echo $form->input('extension',array('type'=>'select','options'=>$extensions));
echo $form->input('id',array('type'=>'hidden','value'=>$id));

echo $form->end('Enregistrer');
?>