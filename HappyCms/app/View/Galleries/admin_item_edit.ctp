<?php
echo $this->element('admin_create_form_item',array('file'=>true,'model'=>'Gallery'));




echo $this->Form->input('title',array('label'=>'Nom :','type'=>'text'));

echo $this->element('happy/fields/files',array('label'=>'Image :','name'=>'img'));

echo $this->Form->input('text',array('label'=>'Description :','type'=>'textarea'));



echo $this->element('admin_end_form_item');