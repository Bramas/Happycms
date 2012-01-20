<?php

echo $this->Html->link('Nouvelle Galerie',array('controller'=>'contents','action'=>'item_edit',$ExtensionName));

echo $this->element('happy/admin_table',array('alias'=>'Gallery',
                                               'columns'=>array(
                                                                      'title'=>'Titre'
                                                                      )));