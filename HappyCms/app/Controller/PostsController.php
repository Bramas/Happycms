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
        $this->request->data = $this->Post->find('all');
    }
    function admin_save()
    {
        parent::admin_save_();
        $this->Session->setFlash("Données sauvegardées",'flash_success');
        $this->redirect('/admin/posts/menu_index/');
        exit();
    }

    function getList($start=0,$limit=2)
    {
        $posts = $this->Post->find('all',array('limit'=>$start.','.$limit));
        return $posts;
    }
    function getMain()
    {
        $posts = $this->Post->find('all',array('limit'=>'0,1'));
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
        $post = $this->Post->findById($id);
        $this->set($post);
        $this->set('bodyClass','actualite');
        Configure::write('Menu.Content.title',$post['Post']['title']);
        $this->set('breadcrumps',$post['Post']['title']);
        $this->set('currentItemId',$post['Post']['id']);
    }
    function index()
    {
        $this->set('Posts',$this->getList(0,10));
    }

    function searchResult($result)
    {
        if(empty($result['published']))
        {
            return false;
        }
        App::uses('Inflector','Utility');

        return array(
            'url'=>array(
                'controller'=>'posts',
                'action'=>'view',
                $result['id'].'-'.Inflector::slug($result['id'],'-')
                ),
            'title'=>$result['title'],
            'content'=>$result['text']
            );
    }

}

?>