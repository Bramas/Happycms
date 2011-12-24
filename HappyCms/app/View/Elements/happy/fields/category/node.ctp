<?php
if(!isset($nodes))
{
    echo '<li id="empty-category" style="display:none">'.
    $this->Form->checkbox('empty-category',array('label'=>'','checked'=>false))
    .'<span class="title"></span>'
   . '<span class="actions"><span class="action edit">'.
     $this->Html->link('edit','#',array('class'=>'edit-category','item_id'=>'empty-category')).
    '</span><span class="action delete">'.
    $this->Html->link('X',array('controller'=>'categories','action'=>'to_trash','admin'=>true,'empty-category',$ExtensionName)).
    '</span></span>'
    
    ;
    echo '<ul></ul>';
    
    echo '</li>';
    
}
else{

//debug($this->request->data[$this->request->data['Happy']['model_name'] .'-Category'][$this->request->data['Happy']['lang_form']]);
echo '<ul>';
foreach($nodes as $node)
{
    $default = empty($this->request->data[$this->request->data['Happy']['model_name'] .'-Category'][$this->request->data['Happy']['lang_form']][$node['Category']['id']])?false:$this->request->data[$this->request->data['Happy']['model_name'] .'-Category'][$this->request->data['Happy']['lang_form']][$node['Category']['id']];
    //debug($this->request->data[$this->request->data['Happy']['model_name'] .'-Category'][$this->request->data['Happy']['lang_form']]);
    $params = json_decode($node['Content']['params'],true);
    echo '<li class="category-'.$node['Category']['id'].'">'.
    $this->Form->checkbox($node['Category']['id'],array('label'=>'','checked'=>$default)).
    '<span class="title">'.$params['title'].'</span>'.
    '<span class="actions"><span class="action edit">'.
     $this->Html->link('edit','#',array('class'=>'edit-category','item_id'=>$node['Category']['item_id'])).
    '</span><span class="action delete">'.
    $this->Html->link('X',array('controller'=>'categories','action'=>'to_trash','admin'=>true,$node['Category']['item_id'],$ExtensionName)).
   '</span></span>'
    ;
    if(!empty($node['children']))
    {
        echo  $this->element('happy/fields/category/node',array('nodes'=>$node['children']));
    }
    else{
        echo '<ul></ul>';
    }
    echo '</li>';
}
echo '</ul>';

}