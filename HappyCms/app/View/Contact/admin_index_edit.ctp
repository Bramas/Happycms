<?php

echo $this->element('admin_create_form_item');
echo '<h3>Texte affiché au dessus du formulaire de contact</h3>';
echo $this->Form->textarea('text');
echo $this->element('happy/fields/googlemaps',array('name'=>'googlemaps'));


?>