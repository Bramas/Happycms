<?php

echo $html->link('Nouvelle Actualité',array('controller'=>'contents','action'=>'item_edit',$ExtensionName));

echo $this->element('happy/admin_table',array('alias'=>'Post',
                                               'columns'=>array(
                                                                      'title'=>'Titre'
                                                                      )));