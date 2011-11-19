<?php

class PostsController extends AppController
{
    var $uses = array('Post');
    var $Hmodel_name = 'Post';

    function admin_item_edit()
    {

    }
    
    function admin_menu_index()
    {
        $this->data = $this->Post->find('all');
    }
    function admin_save()
    {
        parent::admin_save();
        $this->redirect('/admin/posts/menu_index/');
    }

    function getList($start=0,$limit=2)
    {
        
        $posts = $this->Post->find('all',array('limit'=>$start.','.$limit));
        


        return $posts;
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
        $post = $this->getItem($id);
        $this->set($post);
        $this->set('bodyClass','actualite');
        $this->set('breadcrumps',$post['Content']['title']);
        $this->set('currentItemId',$post['Content']['id']);
    }


}

?>