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
        $this->request->data = $this->Post->find('all',array('order'=>'Post.created desc'));
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
        $posts = $this->Post->find('all',array('order'=>'Post.created desc','limit'=>$start.','.$limit));
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
        //debug($this->Post->find('first',array('conditions'=>array('Post.id'=>$id),'recursive'=>2)));
        //debug($this->Post->Comment->belongsTo);
        //debug($this->Post->hasMany);
        //exit(debug($this->Post->getLastQuery()));

        $post = $this->Post->find('first',array('conditions'=>array('Post.id'=>$id),'recursive'=>2));
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
    public function addComment()
    {
        if($this->request->is('post'))
        {
            if($this->Auth->user('real'))
            {
                $this->request->data['Comment']['fre']['user_id'] = $this->Auth->user('id');
                $this->Post->Comment->save($this->request->data);
                exit('{"result":true}');
            }
            else
            {
                exit('{"result":false}');   
            }
            
        }
        else
        {
            exit('{"result":false}');   
        }
    }
    public function rss()
    {
        $this->layout = 'empty';
        $this->set('Posts',$this->getList(0,10));
    }
    public function admin_comments_delete($id)
    {
        $this->check_token();
        $this->Post->Comment->delete($id);
        $this->redirect($_SERVER['HTTP_REFERER']);
        exit();
    }
   
}

?>