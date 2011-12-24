<?php
echo '<h2>Utilisateurs</h2>';
echo $this->Html->link('Nouvel Utilisateur',array('controller'=>'contents','action'=>'item_edit',$ExtensionName));

echo $this->element('happy/admin_table',array('alias'=>'User',
                                               'columns'=>array(
                                                                      'username'=>'Identifiant'
                                                                      )));
echo '<h2>Groupes</h2>';
$this->request->data = $Groups;
echo $this->element('happy/admin_table',array('alias'=>'Group',
												'editUrl'=>'/admin/users/group_edit/',
                                               'columns'=>array(
                                                                      'name'=>'Nom'
                                                                      )));

?>