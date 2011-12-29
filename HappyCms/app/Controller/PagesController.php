<?php

class PagesController extends AppController
{
    
   var $uses =  array('Page');
    var $helpers = array('Html');
    
    
    function admin_display_edit($params)
    {
        
        $this->request->data = $this->Page->findById($params);
        
        
        $this->helpers[] = 'Tinymce';
        //exit();
    }
    function admin_display_new($menu_id)
    {
        $item_id = $this->createItem();
        return $item_id;
    }
    function admin_display_delete($params)
    {
        return parent::admin_delete_($params);
        
    }
    

    function display($id=0)
    {
        
        if(!Configure::read('Menu.id'))
        {
            $this->cakeError('error404');
            exit();
        }
        $r = $this->Page->findById($id);
        $this->set('item',$r['Page']);
    }

    function searchResult($result)
    {
        
        App::import('Model','Menu');

        $Menu = new Menu();
        $Menu->Behaviors->attach('Content');
        $menu = $Menu->find('first',array(
            'conditions'=>array(
                'Menu.extension'=>'pages',
                'Menu.params'=>$result['id'])
            )
        );
        if(empty($menu['Content']['alias']))
        {
            return false;
        }


        return array(
            'url'=>array(
                'controller'=>$menu['Menu']['extension'],
                'action'=>$menu['Menu']['view'],
                'slug'=>$menu['Content']['alias']
                ),
            'title'=>$menu['Content']['title'],
            'content'=>$result['text']
            );
    }
}

?>