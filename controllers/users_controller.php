<?php
class UsersController extends AppController
{
    
    var $uses = array('User');
    
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
        if($this->data)
        {
            if($this->Auth->login($this->data))
            {
                if($this->online)
                {
                    $this->redirect('/admin/');
                }
                else
                {
                    $this->redirect('/');
                }
            }
        }
        $this->params['action'] = 'admin_login';
        
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
        
        if(empty($this->data))
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
            'id'=>$this->Auth->user('id'),
            'password'=>$this->Auth->password($this->data['User']['password'])
        )));
        
        if($r)
        {
            if($this->data['User']['newpassword']===$this->data['User']['newpassword2'])
            {
                $this->data['User']['password'] = $this->Auth->password($this->data['User']['newpassword2']);
                $this->data['User']['id'] = $this->Auth->user('id');
                $this->User->save($this->data);
                $this->Session->setFlash('Mot de passe modifié');
                
            }
            else{
                $this->Session->setFlash("Le mot de passe de vérification n'est pas le même que le nouveau mot de passe");
                
            }
            
        }
        else{
            $this->Session->setFlash('Mauvais mot de passe');
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
        if($this->Auth->login($this->data))
        {
            if($this->data['User']['newpassword'] == $this->data['User']['newpassword2'])
            {
                $this->User->save(array(
                    'User'=>array(
                        'id'=>$this->Auth->user('id'),
                        'password'=>$this->Auth->password($this->data['User']['newpassword'])
                    )
                ));
            }
        }
    }*/
}
?>