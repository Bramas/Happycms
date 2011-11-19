<?php

class ConfigurationsController extends AppController
{
    
    
    var $Hforce_all_languages=true;
    
    function admin_params_edit()
    {
        
    }
    
    function get()
    {
       // $this->Extension->Behaviors->attach('Content');
        $c = $this->Extension->find('first',array('conditions'=>array(
                                                                 'controller'=>'configurations',
                                                                 'Content.language_id'=>Configure::read('Config.id_language'))));
        
        
        $c['Content'] = json_decode($c['Content']['params'],true);
      
       // debug($c);
        if(!empty($this->params['requested']))
        {
            return $c;
        }
        exit();
    }
}
    