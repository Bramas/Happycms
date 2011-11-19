<?php

$happy->item_edit_shared();

    $form->create('Category');
    
    echo $form->input('id',array('label'=>'','type'=>'hidden'));
    echo $form->input('extension',array('label'=>'','type'=>'hidden','value'=>$CategoryExtension));
    echo $form->input('parent_id',array('label'=>'Catégorie parent','type'=>'select','options'=>$options));
    
    $form->end();


$happy->end();


echo $this->element('admin_create_form_item');

echo $form->input('title');


echo $this->element('admin_end_form_item');