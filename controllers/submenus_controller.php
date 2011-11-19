<?php

class SubmenusController extends AppController
{
	function admin_sub_menu_edit($params)
    {
    	$menu = $this->getItem($params);
		if(empty($menu['Content']))
		{
			if(empty($this->data['Menu']['id']))
			{
				exit('error');
			}
			$item_id = $this->createItem();
        	$page = $this->Menu->save(array('Menu'=>array('id'=>$this->data['Menu']['id'],
                                                              'params'=>$item_id)));
    		$this->data = $this->getItem($item_id);
		}
		else
		{
			$this->data = $menu;
		}
		
		
    }
    function admin_sub_menu_new($menu_id)
    {
		$item_id = $this->createItem();
        $page = $this->Menu->save(array('Menu'=>array('id'=>$menu_id,
                                                              'params'=>$item_id)));
    }

}