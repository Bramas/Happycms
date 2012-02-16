<?php
echo $this->element('admin_create_form_item',array('file'=>true,'model'=>'Gallery'));




echo $this->Form->input('title',array('label'=>'Nom :','type'=>'text'));

echo $this->element('gallery',array('label'=>'Images :','name'=>'img'),array('plugin'=>'media'));
echo $this->element('media',array('label'=>'Image :','name'=>'img2'),array('plugin'=>'media'));

echo $this->Form->input('text',array('label'=>'Description :','type'=>'textarea'));



echo $this->element('admin_end_form_item');