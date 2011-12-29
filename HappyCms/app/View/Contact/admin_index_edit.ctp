<?php

echo $this->element('admin_create_form_item',array('model'=>'Contact'));
echo '<h3>Texte affiché au dessus du formulaire de contact</h3>';
echo $this->Form->textarea('text');
//debug($this->request->data);
echo $this->element('happy/fields/googlemaps',array('name'=>'googlemaps'));


?>