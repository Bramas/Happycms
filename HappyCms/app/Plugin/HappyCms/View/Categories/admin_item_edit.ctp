<?php

$happy->item_edit_shared();

    $this->Form->create('Category');
    
    echo $this->Form->input('id',array('label'=>'','type'=>'hidden'));
    echo $this->Form->input('extension',array('label'=>'','type'=>'hidden','value'=>$CategoryExtension));
    echo $this->Form->input('parent_id',array('label'=>'Catégorie parent','type'=>'select','options'=>$options));
    
    $this->Form->end();


$happy->end();


echo $this->element('admin_create_form_item');

echo $this->Form->input('title');


echo $this->element('admin_end_form_item');