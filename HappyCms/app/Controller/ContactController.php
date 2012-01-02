<?php

class ContactController extends AppController
{
    
   var $uses =  array('Contact','HappyCms.Content');
    var $helpers = array('Html');
    var $components = array("Email");
    
    
    function admin_index_edit()
    {
        
        $this->request->data = $this->Contact->findById(1);
        
        
        $this->helpers[] = 'Tinymce';
        //exit();
    }
    function admin_index_new($menu_id)
    {
        $item = $this->Contact->findById(1);
        if(empty($item)) //if its the first time
        {
            $item_id = $this->createItem();
        }
       
        
    }
    
    function index()
    {

        if(!Configure::read('Menu.id'))
        {
            $this->cakeError('error404');
            exit();
        }

        $r = $this->Contact->findById(1);
     // debug($r);
        $this->set($r);
        
        
         if($this->request->data)
        {
            $this->Contact->set($this->request->data);
            //exit(debug($this->request->data));
            if($this->Contact->validates())
            {
                App::uses('CakeEmail', 'Network/Email');
                $email = new CakeEmail('and1');
                $email->to(Configure::read('Config.Content.contactEmail'))
                    ->from($this->request->data["Contact"]["email"])
                    ->subject("Formulaire de contact du site : ".Configure::read('Config.Content.title'))
                    ->send('Message de : '.htmlentities($this->request->data["Contact"]["nom"].' <'.$this->request->data["Contact"]["email"].'>').'<br/><br/>'.nl2br(htmlentities($this->request->data["Contact"]["message"])));
                $this->Session->setFlash("Votre Message a bien été envoyé");
                $this->redirect('/');   
               /* 
                  $this->Email->smtpOptions = array(
        'port'=>'465', 
        'timeout'=>'30',
        'host' => 'ssl://auth.smtp.1and1.fr',
        'username'=>'contact@ocal-billom.fr',
        'password'=>'MAIL@ocal123'
            );
             $this->Email->delivery = 'smtp';
             //$this->Email->delivery = 'mail';
    
                // echo 'AAA;'.$r['Content']['text'];
                //debug($r['Content']['text']);
                $this->Email->to = "contact@linksite.fr";
                $this->Email->from = $this->request->data["Contact"]["email"];
                $this->Email->subject = "Formulaire de contact du site www.pcm-ensemblier.com : ";
                $this->Email->replyTo = $this->request->data["Contact"]["email"];
                if($this->Email->send("Message de ".$this->request->data["Contact"]["nom"]."\n\n".$this->request->data["Contact"]["message"]))
                {
                    $this->Session->setFlash("Votre Message a bien été envoyé");
                }
                else{
                    $this->Session->setFlash("Votre Message n'a pas été envoyé");
                }
                $this->redirect('/');
                */
            }
            else
            {
                //$this->Session->setFlash("Formulaire mal rempli",array('controller' => 'contact', 'action' => 'index'));
            }
        }
        
    }
}

?>