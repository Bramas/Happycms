<?php

class RealisationsController extends AppController
{
    
   var $uses =  array();
    var $helpers = array('Html');
    function index()
    {
        $this->set('Realisations',$this->getItems());
    }
    
    function admin_index_new($menu_id)
    {
        
    }
    function admin_index_edit()
    {
         $this->set('page_intro',null);//$this->Extension->read('page_intro'));
        $this->data=$this->getItems();
    }
    
    function admin_item_edit($id=null) {
    
    }
    function admin_save() {
    parent::admin_save();
    
        $this->redirect($_SERVER['HTTP_REFERER']);
    exit();
    }
    
    function admin_to_trash($item_id,$lang=null)
    {
         $this->Content->deleteAll(array('Content.item_id'=>$item_id,
					'extension'=>$this->getExtensionName()));
         exit();
    }
    function realisation($item_id)
    {
        
        //$this->layout = 'empty';
        $this->set($this->getItem($item_id));

    }

}
?>