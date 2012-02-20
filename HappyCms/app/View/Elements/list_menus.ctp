<?php
$menuPathArray=array();
if(!empty($menuPath))
    foreach($menuPath as $menuPathItem)
    {
        $menuPathArray[]=$menuPathItem['Menu']['id'];
    }

if(empty($limit))
{
    $limit=0;
}
$limit--;

if(empty($class))
{
    $class='nav';
}

if(empty($parent_id))
{
    $parent_id=0;
}
if(empty($HpOverwriteMenus))
{
    $menus = $this->requestAction(array(
        'plugin'=>'HappyCms', 
        'controller'=>'menus', 
        'action'=>'list_menus',
        'admin'=>false,
        $parent_id));
}
else
{
    $menus = $HpOverwriteMenus;
}
//debug($parent_id);
//debug($menus);
//exit();
echo '<ul class="'.$class.'">';
foreach($menus as $menu)
{
    if(empty($menu['Menu']['published']))
    {
        continue;
    }
    $url='#';
    if($menu['Menu']['extension']!='menus' || $menu['Menu']['view']!='sub_menu')
    {
        $url = array(
            'controller'=>$menu['Extension']['controller'],
            'action'=>$menu['Menu']['view'] ,
            'slug'=> $menu['Menu']['alias'],
            'default'=>$menu['Menu']['id']==Configure::read('Config.Content.default_menu_id'));
        
    }

    $class=(in_array($menu['Menu']['id'],$menuPathArray)?'active ':'');

    $class.=(empty($menu['Menu']['class'])?'':$menu['Menu']['class']).' ';

    $hasChildren = $menu['children'] && $limit!=0;

    if($hasChildren)
    {
        $class.='dropdown ';
    }

    echo '<li class="'.trim($class).'">'.
    $this->Html->link($menu['Menu']['title'], $url,
            array('title'=>$menu['Menu']['title'],'class'=>($hasChildren?'dropdown-toggle':'')));


    if($hasChildren)
    {
        echo $this->element('list_menus',array(
            'HpOverwriteMenus'=>$menu['children'],
            'limit'=>$limit,
            'class'=>'dropdown-menu'
            ));
    }

    echo '</li>';
}
echo '</ul>';
    
