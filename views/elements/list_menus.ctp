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

if(empty($parent_id))
{
    $parent_id=0;
}
if(empty($HpOverwriteMenus))
{
    $menus = $this->requestAction('/menus/list_menus/'.$parent_id);
}
else
{
    $menus = $HpOverwriteMenus;
}
//debug($parent_id);
//debug($menus);
echo '<ul>';
foreach($menus as $menu)
{
    if(empty($menu['Content']['published']))
    {
        continue;
    }
    $url='#';
    if($menu['Menu']['extension']!='menus' || $menu['Menu']['view']!='sub_menu')
    {
        $url = array(
            'controller'=>$menu['Extension']['controller'],
            'action'=>$menu['Menu']['view'] ,
            'slug'=> $menu['Content']['alias'],
            'default'=>$menu['Menu']['id']==Configure::read('Config.Content.default_menu_id'));
        
    }
    
    $class=(in_array($menu['Menu']['id'],$menuPathArray)?'current ':'');

    $class.=(empty($menu['Content']['class'])?'':$menu['Content']['class']).' ';

    echo '<li class="'.trim($class).'">'.
    $html->link($menu['Content']['title'], $url);


    if($menu['children'] && $limit!=0)
    {
        echo $this->element('list_menus',array(
            'HpOverwriteMenus'=>$menu['children'],
            'limit'=>$limit));
    }

    echo '</li>';
}
echo '</ul>';
    
