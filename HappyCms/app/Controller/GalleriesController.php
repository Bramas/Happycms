<?php

class GalleriesController extends AppController
{
    
    function admin_menu_index()
    {
    	 $this->request->data = $this->Gallery->find('all',array('order'=>'Gallery.created desc'));
    }
    function admin_item_edit($id)
    {
    	$this->request->data =  $this->Gallery->findById($id);
    }
    function getList($start=0,$limit=2)
    {
        $Gallery = $this->Gallery->find('all',array('order'=>'Gallery.created desc','limit'=>$start.','.$limit));
        return $Gallery;
    }
    function index()
    {
    	$this->set('Galleries',$this->getList(0,20));
    }
    function view($slug)
    {
        if(is_numeric($slug))
        {
            $id = $slug;
        }
        elseif(strpos($slug,'-')!==false)
        {
            list($id,$slug) = explode('-',$slug);
        }
        else
        {
            exit('Contactez l\'administrateur');
        }
        //debug($this->Post->find('first',array('conditions'=>array('Post.id'=>$id),'recursive'=>2)));
        //debug($this->Post->Comment->belongsTo);
        //debug($this->Post->hasMany);
        //exit(debug($this->Post->getLastQuery()));

        $Gallery = $this->Gallery->find('first',array('conditions'=>array('Gallery.id'=>$id)));//,'recursive'=>2));
        $this->set($Gallery);
    }
}
    
    
 