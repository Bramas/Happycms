<?php

class SubmenusController extends AppController
{
	function admin_sub_menu_edit($params)
    {
    	$menu = $this->getItem($params);
		if(empty($menu['Content']))
		{
			if(empty($this->request->data['Menu']['id']))
			{
				exit('error');
			}
			$item_id = $this->createItem();
        	$page = $this->Menu->save(array('Menu'=>array('id'=>$this->request->data['Menu']['id'],
                                                              'params'=>$item_id)));
    		$this->request->data = $this->getItem($item_id);
		}
		else
		{
			$this->request->data = $menu;
		}
		
		
    }
    function admin_sub_menu_new($menu_id)
    {
		$item_id = $this->createItem();
        $page = $this->Menu->save(array('Menu'=>array('id'=>$menu_id,
                                                              'params'=>$item_id)));
    }

}