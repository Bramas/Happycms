<?php
echo $this->element('admin_create_form_item',array('file'=>true,'model'=>'Post'));




echo $this->Form->input('title',array('label'=>'Nom :','type'=>'text'));


echo $this->Form->input('text',array('label'=>'Texte :','type'=>'textarea'));



echo $this->element('admin_end_form_item');