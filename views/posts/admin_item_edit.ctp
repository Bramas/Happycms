<?php
echo $this->element('admin_create_form_item',array('file'=>true));




echo $form->input('title',array('label'=>'Nom :','type'=>'text'));


echo $form->input('text',array('label'=>'Texte :','type'=>'textarea'));



echo $this->element('admin_end_form_item');