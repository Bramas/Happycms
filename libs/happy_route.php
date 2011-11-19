<?php
class HappyRoute extends CakeRoute {
 
    function parse($url) {
        
        $params = parent::parse($url);
       //debug($params);
        //exit();
        
        if (empty($params['slug'])) {
            return $params;
        }
        /*if($params['slug']=='admin')
        {
            $params['admin']=true;
            return $params;
        }*/
        
        App::import('Model','Menu');
        App::import('Model','Content');
        App::import('Model','Extension');
        $Extension = new Extension();
        $Content = new Content();
        $Menu = new Menu();
        if($params['slug']=='default')
        {
            $menu_id = Configure::read('Config.Content.default_menu_id');
            if(empty($menu_id))
            {
                exit('Veuillez configurer la page d\'accueil du site');
            }
            $menu = $Menu->find('first',array('fields'=>'*',
                                                    'joins'=>array(
						    array( 
							'table' => $Content->tablePrefix.$Content->table, 
							'alias' => 'Content', 
							'type' => 'left', 
							'foreignKey' => false, 
							'conditions'=> array('Content.item_id = Menu.item_id'))),
						    'conditions'=>array('Content.extension=\'menus\'',
									    'Content.language_id='.Configure::read('Config.id_language'),
									    'Menu.id = '.$menu_id
                                        //,'Content.params LIKE (\'%"published":"1"%\')'
                                        ) 
	    ));
                    //debug($menu);
        }
        else
        {
            $menu = $Menu->find('first',array('fields'=>'*',
                                                    'joins'=>array(
						    array( 
							'table' => $Content->tablePrefix.$Content->table, 
							'alias' => 'Content', 
							'type' => 'left', 
							'foreignKey' => false, 
							'conditions'=> array('Content.item_id = Menu.item_id'))),
						    'conditions'=>array('Content.extension=\'menus\'',
									  //  'Content.language_id='.Configure::read('Config.id_language'),
									    'Content.params LIKE (\'%"alias":"'.mysql_real_escape_string($params['slug']).'"%\')
                                        AND Content.params LIKE (\'%"published":"1"%\')
                                        ') 
	    ));
        }
        
        //debug($menu);
        //exit();
        if(empty($params['_args_']))
        {
            $params['_args_']='';
        }
        
	   if(empty($menu))
        {
            //debug($params['_args_']);
             ///   debug(strpos($params['_args_'],'ist')===false?'r':'y');
            $params['controller']=$params['slug'];
            if(strpos($params['_args_'],'/')!==false)
            {
                list($action,$args) = explode('/',$params['_args_'],2);
            }
            else{
                $action=$params['_args_'];
                $args='';
            }
            
            $params['_args_']=$args;
            $params['action']=$action;
            return $params;
        }
        
        if($menu['Menu']['extension'] == 'links')
        {
            if(!is_numeric($menu['Menu']['params']))
            {
                header('Location:'.$menu['Menu']['params']);
            }
            else{
                 $menu = $Menu->find('first',array(
                                                   'fields'=>'*',
                                                   'conditions'=>array(
                                                        'id'=>$menu['Menu']['params']
                                                   )
                                                    
                                            ));
            }
            if(empty($menu))
            {
                exit('Error, please contact the administrator');
            }
        }
        
        
        
        $menu['Menu']['Content'] = json_decode($menu['Content']['params'],true);
        Configure::write('Menu',$menu['Menu']);
        $params['controller'] = $menu['Menu']['extension'];
        $params['action'] = $menu['Menu']['view'];
        if(!empty($menu['Menu']['params']))
        {
             $params['_args_'] = $menu['Menu']['params'].'/'.$params['_args_'];
        }
        
        //debug($params);
        //exit();
        return $params;
    }
    
    function match($url)
    {
        if(isset($url['default']))
        {
            if($url['default'])
            { 
                return '/'.(Configure::read('Config.multilanguage')?Configure::read('Config.language'):'');
            }
            unset($url['default']);
        }
        
        if(!empty($url['slug']))
        {
            $url['controller']='';
            $url['action']='';
            //return $url['slug'];
           $url=array(
                'slug'=>$url['slug'],
                'controller'=>'',
                'action'=>''
                );
        }
        
       //debug($url);
        $url = parent::match($url);
        //debug($url);
       
        return $url;
    }
 
}