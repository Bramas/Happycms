<?php 
echo $this->element('admin_create_form_item',array('file'=>true));

echo $this->element('happy/fields/file',array(
                                              'filters'=>array('Images'=>'jpg,png,gif'),
                                              'name'=>'thumb',
                                              'options'=>array('label'=>'Image du menu :')));
echo $this->element('admin_end_form_item');
