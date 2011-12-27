<?php
class UsersController extends AppController
{
    var $components = array('Session');
    
    function login($login_page=false)
    {

        $this->Session->write('User.token',0);
        if($login_page || $this->online)
        {
            $this->layout='login';
        }
        else
        {
            $this->layout='offline';
        }
        if($this->request->is('post'))
        {
            if($this->Auth->login())
            {
                $User = $this->User->findById($this->Auth->user('id'));
                $User = array_merge($User['User'],array(
                    'Group.rules'=>$User['Group']['rules'],
                    'Group.id'=>$User['Group']['id']
                    ));
                $this->Auth->login($User);
                if(!$this->online)
                {
                    $this->Session->write('HappyCms.loginRedirect','');
                    $this->redirect('/');
                    exit();
                }
                if($this->Session->read('HappyCms.loginRedirect'))
                {
                    $temp = $this->Session->read('HappyCms.loginRedirect');
                    $this->Session->write('HappyCms.loginRedirect','');
                    $this->redirect($temp);
                    exit();
                }
                $this->redirect('/');
                //$this->redirect($this->Auth->redirect());
                exit();
                /*
                if($this->online)
                {
                    $this->redirect('/admin/');
                }
                else
                {
                    $this->redirect('/');
                }*/
            }
        }
        
    }
    function admin_login()
    {
        $this->Session->write('User.token',0);
        $this->redirect(array(
            'action' =>'login',
            'admin'  =>false));
        exit();
        //$this->layout = 'admin_login';
    }
    function admin_logout()
    {
        $this->Session->write('User.token',0);
        $this->Auth->logout();
        $this->redirect('/');
        exit();
    }
    function admin_modify_password()
    {
        
        if(empty($this->request->data))
        {
                    $this->Session->setFlash('Erreur');
                    $this->redirect(array(
                        'controller' =>'home',
                        'action'     =>'index',
                        'admin'      =>true
                    ));
                    exit();
        }
        $this->check_token();
        
        $r = $this->User->find('count',array('conditions'=>array(
            'User.id'=>$this->Auth->user('id'),
            'password'=>$this->Auth->password($this->request->data['User']['password'])
        )));
        
        if($r)
        {
            if($this->request->data['User']['newpassword']===$this->request->data['User']['newpassword2'])
            {
                $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['newpassword2']);
                $this->request->data['User']['id'] = $this->Auth->user('id');
                $this->User->save($this->request->data);
                $this->Session->setFlash('Mot de passe modifié');
                
            }
            else{
                $this->Session->setFlash("Le mot de passe de vérification n'est pas le même que le nouveau mot de passe",'flash_error');
                
            }
            
        }
        else{
            $this->Session->setFlash('Mauvais mot de passe','flash_success');
        }
                $this->redirect(array('controller'=>'users','action'=>'edit','admin'=>true));
        exit();
    }
    
    function admin_edit()
    {
        
    }
   /* function admin_modify_password()
    {
        $this->Auth->logout();
        if($this->Auth->login($this->request->data))
        {
            if($this->request->data['User']['newpassword'] == $this->request->data['User']['newpassword2'])
            {
                $this->User->save(array(
                    'User'=>array(
                        'id'=>$this->Auth->user('id'),
                        'password'=>$this->Auth->password($this->request->data['User']['newpassword'])
                    )
                ));
            }
        }
    }*/
    function admin_index()
    {
        $this->request->data = $this->User->find('all');

        $groups = $this->User->Group->find('all');
        $this->set('Groups',$groups);
    }

    function admin_item_edit($item_id)
    {
        $this->request->data = $this->User->findById($item_id);

        $options = $this->User->Group->find('list');
        $this->set('groupsList',$options);

    }

    function admin_group_edit($item_id)
    {
        $this->request->data = $this->User->Group->findById($item_id);
    }
    function admin_group_save()
    {
        if(empty($this->request->data))
        {
            $this->redirect('/admin/');
            exit();
        }
        $this->User->Group->save($this->request->data,array(),array('name','rules'));
        $this->Session->setFlash('Modifications sauvegardés','flash_success');
        $this->redirect('/admin/users/index');
        exit();
    }
    function admin_save()
    {
        if(empty($this->request->data))
        {
            $this->redirect('/admin/');
            exit();
        }
        if(isset($this->request->data['User']['password']))
        {
            unset($this->request->data['User']['password']);
        }
        if(!empty($this->request->data['User']['newpassword1']) && $this->request->data['User']['newpassword1']===$this->request->data['User']['newpassword2'])
        {
            $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['newpassword1']);
        }

        $this->User->save($this->request->data,array(),array('username','password','group_id'));
        $this->Session->setFlash('Modifications sauvegardés','flash_success');
        $this->redirect('/admin/users/index');
        exit();
    }
}
?>