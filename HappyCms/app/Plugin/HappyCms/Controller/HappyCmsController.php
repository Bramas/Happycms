<?php

//App::uses('HappyCmsAppController','HappyCms.Controller');

class HappyCmsController extends Controller
{
    var $components = array('Auth' => array(
        'loginAction' => array(
            'controller' => 'users',
            'action' => 'login',
            'plugin' => 'HappyCms'
        ),
        'loginRedirect' => array(
            'controller' => 'users',
            'action' => 'login',
            'plugin' => 'HappyCms'
        ),
        'authError' => 'Vous n\'êtes pas autorisé à voir cette page',
        'authenticate' => array(
            'Form' => array(
                'fields' => array("username"=>"username", "password" => "password"),
                'userModel' => 'HappyCms.User'
            )
        )
    ),"Session");
    var $uses = array('HappyCms.Menu','HappyCms.User','HappyCms.Extension','HappyCms.Content');
    var $helpers = array('Html','Form',"Session",'Happy');
    
    var $Hmodel_name = 'Content';
     
    var $Hforce_all_languages=false;
    
    var $online = false;
    var $is_linksite = false;
    var $_requestedLanguage=null;
    /** Constructor Hack for default model use
     *
     */

    
    function beforeFilter(){
    	//if($this->request->data)
    	//exit();
    	
    	//App::import('Model','Happycms.Menu');
    	//$menu = new Menu()

	/**
	 *
	 *	Token
	 *
	 *	*/
	 
	if($this->Session->read('User.token')==false)
	{
	    $this->Session->write('User.token', uniqid().'t'.(time()%rand()-(time()%17)*rand()));
	}
	
	/**
         *      Languages
         *
         *
         *      */
        $id_languages = Configure::read('Config.id_languages');
        
    
        if($this->Session->read('User.language'))
	{
	    Configure::write('Config.language',$this->Session->read('User.language'));
	    Configure::write('Config.id_language',$id_languages[$this->Session->read('User.language')]);
	}
	
	if(isset($this->request->params['language']))
	{
	    Configure::write('Config.language',$this->request->params['language']);
	    Configure::write('Config.id_language',$id_languages[$this->request->params['language']]);
	    $this->Session->write('User.language',$this->request->params['language']);
	}
	$lang_id=Configure::read('Config.id_language');
        //debug(Configure::read('Config.language'));
        /**
	 *
	 * Site Config
	 * */
	
	
	$this->online = Configure::read('Config.Content.online');
	
        
        /**
         *      Auth
         *
         *
         *      */
	
		$this->Auth->authorize = array('Controller');
                //Configure::write('debug','2');
		   // debug($this->request->data);
		   
	   /* if($this->request->params['controller']=='users' && $this->request->params['action'] == 'login' && $this->Auth->user())
	    {
			$this->redirect('/');
	    }
	    else{
		//debug($this->request->params['url']['url']=='fre/users/login');
	    }
*/
	    /*if(!empty($this->request->data))
	    {
		    $copyData = $this->request->data;
		}
	    if(!empty($this->request->data['User']['password']))
	    {
			$this->request->data['User']['password']=$this->Auth->password($this->request->data['User']['password']);
	    }*/

        /*if(isset($this->Auth))
        {
		    if(!empty($this->request->data['User']['username']) && !empty($this->request->data['User']['password']) && !$this->Auth->user())
		    {
		    	//debug($this->request->data);

				if(!$this->Auth->login())
				{

				    //exit('wrong login/passoword');
				}
				else{
					//$this->$copyData
					//if(!$this->request->data)
					//else
					{
					    if($this->Session->read('Auth.redirect'))
						{
							
							$this->redirect('http://'.$_SERVER["HTTP_HOST"].$this->Session->read('Auth.redirect'));
						}
						else
						{
							$this->redirect('/');
						}

				    	exit('connected');
					}
				}
		    }
		    //$this->Auth->authorize = 'controller';

            $this->Auth->userModel="User";
            $this->Auth->fields=array("username"=>"username", "password" => "password");
            $this->set($this->Auth->user());
        }
        */
        /*if(!isset($this->request->params['prefix']) || $this->request->params['prefix']!= 'admin' )
        {
	    
		    if(!($this->request->params['controller']=='users' && $this->request->params['action'] == 'login') && !$this->online && !$this->Auth->user())
		    {
				$this->Auth->deny();
		    }
		    else{
			//echo 'allow '.$this->request->params['url']['url'];
			$this->Auth->allow();
		    }
        }*/
        /**
        *
		*		custom ACL
		*
		*
        */

        if(!$this->Auth->loggedIn())
	    {
	    	$User = $this->User->findByUsername('default');
	    	$User = array_merge($User['User'],array(
                    'Group.rules'=>$User['Group']['rules'],
                    'Group.id'=>$User['Group']['id']
                    ));

            $this->Auth->login($User);
	    }
        
        $this->set('User',$this->Auth->user());

        




        
        /**
         *      Layout & menu
         *
         *
         *      */
	//debug($this);

	if(!empty($this->request->params['slug']) && $this->request->params['slug']!='default')
	{
		App::uses('Sanitize', 'Utility');
	     $menu = $this->Content->find('first',array(
						    'conditions'=>array('Content.extension=\'menus\'',
									    'Content.language_id='.Configure::read('Config.id_language'),
									    'Content.params LIKE (\'%"alias":"'.Sanitize::escape($this->request->params['slug']).'"%\')'))); 
	   if(!empty($menu))
	   {
		$menu=json_decode($menu['Content']['params'],true);
		$this->set("title_for_layout",$menu['title']);
	   }
	   // $this->set("title_for_layout",$this->request->params['slug']);
	}

        //debug($this);
	
        $extension_menu='menus';
        if (isset($this->request->params['admin'])) {
                        // Set the default layout
            $this->layout = '../../Plugin/HappyCms/View/Layouts/admin_default';
                
			$ContentTablesLang=array();
			
			foreach(Configure::read('Config.id_languages') as $lang=>$lang_id)
			{
			    $ContentTablesLang[]=array( 
								'table' => $this->Content->tablePrefix.$this->Content->table, 
								'alias' => 'Content__'.$lang, 
								'type' => 'left', 
								'foreignKey' => false, 
								'conditions'=> array(
								    'Content__'.$lang.'.item_id = Menu.item_id AND Content__'.$lang.'.extension=\''.$extension_menu.'\' '.
								    'AND Content__'.$lang.'.language_id='.$lang_id
								) 
							    );
			}
	                $r = $this->Menu->find(
					       'threaded',
					       array(
						    'order'=>'lft',
						    'fields'=>'*',
						    'joins'=>$ContentTablesLang
						)
					);
			$r = $this->Content->filterResults($r);
	                //$r = $this->Menu->generatetreelist();
	                $this->set('menus',$r);

			//debug($r);
                
        } else {
            
                $this->layout = '../../Plugin/HappyCms/View/Layouts/default';
                
               
                $menuPath = $this->Menu->getPath(Configure::read('Menu.id'));
                
                $this->set('menuPath',$menuPath);
	    
        }
        

        
        /**
         *      Extension Manager
         *
         *
         *      */
	if(Configure::read('debug')>1)
	{
	    /*$extensions=Configure::read('Config.extensions');
	    foreach(Configure::read('Config.id_extensions') as $controllerName => $id)
	    {
		$tempExtension = $this->Extension->find('first',array('conditions'=>array('id'=>$id),
											'recursive'=>0));
		
		
		
		
		if($tempExtension===false)// if the module doesn't exit, we create it
		{
		    $this->Extension->save(array(
					     'Extension'=>array(
						'id'=>$id,
						'name'=>$extensions[$controllerName]['name'],
						'controller'=>$controllerName,
						'action'=>$extensions[$controllerName]['views'][0],
					    )))	;
		}
		elseif($tempExtension['Extension']['controller']!=$controllerName)// if it exits but don't match the configuration we display an error
		{
		    $this->cakeError('happycms_error',array('Wrong name : '.$tempExtension['Extension']['controller'].' != '.$controllerName));
		    //throw new Exception('Wrong name : '.$tempExtension['Extension']['controller'].' != '.$controllerName);
		}
	    }*/
	}
	
	/** load the extension info and params
	*/
	$this->Extension->load($this->getExtensionName());
	$this->set('ExtensionName',$this->getExtensionName());

	
    }

    function isAuthorized($user) {
        
	    		
        if($this->request->params['controller']=='users' && $this->request->params['action'] == 'login')
        {
        	return true;
        }
       

        if($this->Auth->user('Group.id')==1)
        {
        	$this->is_linksite = true;
            Configure::write('debug','2');
            $this->set('is_linksite',true);
        }

	    $allowed = $this->requestAllowed($this->request->params['controller'],$this->request->params['action'],$this->online,$this->Auth->user());
	    
	    	//debug($this->Auth);
	    	//exit();

	    if($allowed)
	    {
	    	return true;
	    }
	    // I dont know why but this isn't done automaticaly ??
	    $this->Session->write('HappyCms.loginRedirect','/'.$this->request->url);
        $this->redirect(array_merge($this->Auth->loginAction,array('admin'=>null)));
        exit();
        return false;
    }

    public function check_token($token = null)
    {
    	if(empty($token))
    	{
    		$token = empty($this->request->data['_token'])?'':$this->request->data['_token'];
    	}
    	if(empty($token) && !empty($this->request->params['named']['_token']))
    	{
    		$token = $this->request->params['named']['_token'];
    	}
		if($token!=$this->Session->read('User.token'))
		{
		    exit('Wrong token, please retry.');
		}
    }
    function admin_save_()
    {
	
	$ret=array();
        if($this->request->data)
        {
	        $this->check_token();
	    
	    
            $delete = empty($this->request->data['Delete'])?array():$this->request->data['Delete'];
            unset($this->request->data['Delete']);
            
            foreach($this->request->data as $modelName=>$data)
            {
                if(!empty($data['_extension']))
                {
				    if(isset($this->request->data[$modelName.'-Category']))
				    {
					$cat = $this->request->data[$modelName.'-Category'];
				    }
				    else
				    {
					$cat=NULL;
				    }
		    
                    $ret[$modelName] = $this->Content->saveItem(array('Content'=>$this->request->data[$modelName],
								      'Category'=>$cat
					));
		    		$ret[$modelName]  = current($ret[$modelName] );
		    
                }
            }
            
            
            
            
            if(!empty($delete))
            {
                foreach($delete as $extension => $files)
                {
                	foreach($files as $file)
	                {
		                $this->unlink($extension,$file);
			        }
                }
            }
        }
        //debug($this->request->data);
        //exit();
        //$this->Session->setFlash("Données sauvegardées",'flash_success');
        return $ret;
        //$this->redirect($_SERVER['HTTP_REFERER']);
    }
    function admin_save()
    {
    	$this->admin_save_();

    	$this->Session->setFlash("Données sauvegardées",'flash_success');
        if(empty($this->request->data['_redirect']) || $this->request->data['_redirect']=='default')
		{
			$this->redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			$this->redirect(array('action'=>'index', 'admin'=>true));
		}
        exit();
    }
    
    
    
    protected function unlink($extension,$file)
    {
        if(file_exists('../webroot/files/uploads/'.$extension.'/'.$file))
        {
            $check = $this->Content->find('count',array('conditions'=>array('Content.params LIKE(\'%":"'.$file.'"%\')',
                                                                      'extension'=>$extension)));
            
            if(empty($check))
            {
                unlink('../webroot/files/uploads/'.$extension.'/'.$file);
            }
        }
    }
    
    
    protected function getExtensionName()
    {
	$id_extensions = Configure::read('Config.id_extensions');
	$name = strtolower(substr(get_class($this),0,-10));
	return $name;
    }
    
    function getItem($id,$assoc=true)
    {
	if(!empty($this->_requestedLanguage))
	{
	    $lang = $this->_requestedLanguage;
	}
	else
	{
	    $lang = NULL;
	}
	$item = $this->Content->item($this->getExtensionName(),$id,array(
									'assoc'=>$assoc,
									'lang'=>$lang));

	if(empty($item['Content']))
	{
		$item=array('Content'=>false);
	}

	return array($this->Hmodel_name=>$item['Content']);
    }
    function getItems($assoc=true,$options=array())
    {
	if(!empty($this->_requestedLanguage) )
	{
	    $lang = $this->_requestedLanguage;
	}
	else{
	    $lang=null;
	}
	
	return $this->Content->items($this->getExtensionName(),$lang,$assoc,$options);
    }
    protected function saveItem($item)
    {
		if(empty($item['Content']))
		{
		    $data=array('Content'=>$item);
		}
		else{
		    $data=$item;
		}
		$data['Content']['extension']=$this->getExtensionName();
		
		if(empty($data['Content']['language_id']))
		{
		    $data['Content']['language_id']=Configure::read('Config.id_language');
		}
		return $this->Content->save($data);
	}
	protected function createItem($params=null)
	    {
		if($params===null)
		{
		    if(!empty($this->default_params))
		    {
			$params=$this->default_params;
		    }
		    else
		    {
			$params=array();
		    }
		}
        $item_id = $this->Extension->getNextId();
        
		foreach(Configure::read('Config.id_languages') as $lang=>$lang_id)
		{
		    if(isset($params[$lang]))
		    {
			$tempParams = $params[$lang];
		    }
		    else
		    {
			$tempParams = $params;
		    }
		    $tempParams = json_encode($tempParams);
		    $this->saveItem(array(
					    'id'=>null,
					    'language_id'=>$lang_id,
					    'item_id'=>$item_id,
					    'params'=>$tempParams
				      ));
		}
	return $item_id;
    }
    
    protected function deleteItem($item_id)
    {
	$this->Content->deleteAll(array(
							    'extension'=>$this->getExtensionName(),
							    'Content.item_id'=>$item_id
							    ));
    }
    function getViews($controller)
    {
	$controllerInfo=Configure::read('Extensions.'.$controller);
	
	if(empty($controllerInfo))
	{
	    return array();
	}
	if(empty($controllerInfo['views']))
	{
	    return array('index'=>$controllerInfo['name']);
	}
	return $controllerInfo['views'];
    }
    function admin_delete($item_id,$lang=null)
    {

    	$this->admin_to_trash_($item_id,$lang=null);
    	$this->redirect($_SERVER['HTTP_REFERER']);
    	exit();
    }
    function admin_to_trash($item_id,$lang=null)
    {

    	$this->admin_to_trash_($item_id,$lang=null);
    	$this->redirect($_SERVER['HTTP_REFERER']);
    	exit();
    }
    function admin_delete_($item_id,$lang=null)
    {

    	$this->admin_to_trash_($item_id,$lang=null);
    }
    function admin_to_trash_($item_id,$lang=null)
    {
    	
		if($this->Hforce_all_languages)
		{
		    return false;
		}
		if($lang===null)
		{
			$lang = Configure::read('Config.language');
		}
		$this->Content->deleteAll(array('Content.item_id'=>$item_id,
						'Content.extension'=>$this->getExtensionName(),
						'Language.code'=>$lang));
		
	    return true;
    }
    
    function admin_params_edit()
    {
	
    }

    function requestAllowed($object, $property, $online, $rules, $default = false)
	{
	    // The default value to return if no rule matching $object/$property can be found
	    
	    $rules = array($rules['Group.rules'],$rules['rules']);

	    $allowed = $default;

	    foreach($rules as $rule)
	    {
		    // This Regex converts a string of rules like "objectA:actionA,objectB:actionB,..." into the array $matches.
		    preg_match_all('/([^:,]+):([^,:]+)/is', $rule, $matches, PREG_SET_ORDER);
		    foreach ($matches as $match)
		    {
		        list($rawMatch, $allowedObject, $allowedProperty) = $match;
		       
		        $allowedObject = str_replace('*', '.*', $allowedObject);
		        $allowedProperty = str_replace('*', '.*', $allowedProperty);
		       
		       	if (substr($allowedObject, 0, 8)=='Offline|' && !$online)
		        {
		            $allowedObject = substr($allowedObject, 8);
		        }
		        elseif(substr($allowedObject, 0, 8)=='Offline|')
		        {
		        	continue;
		        }

		        if (substr($allowedObject, 0, 1)=='!')
		        {
		            $allowedObject = substr($allowedObject, 1);
		            $negativeCondition = true;
		        }
		        else
		        {
		        	$negativeCondition = false;
		        }
		            
		       
		        if (preg_match('/^'.$allowedObject.'$/i', $object) &&
		            preg_match('/^'.$allowedProperty.'$/i', $property))
		        {
		            if ($negativeCondition)
		                $allowed = false;
		            else
		                $allowed = true;
		        }
		    }        
		}
	    return $allowed;
	}
	function extensionPlugin($extension)
	{
		
		
		if(in_array(strtolower($extension), Configure::read('HappyCms.ControllersNeedRoutes')))
		{
			return 'HappyCms.';
		}
		return null;
	}
    
}
?>