<?php
echo $this->element('admin_create_form_item',array('model'=>'Page'));

echo $this->Form->input('intro',array('label'=>'Introduction : '));
echo $this->Form->textarea('text');


echo $this->element('admin_end_form_item');
?>