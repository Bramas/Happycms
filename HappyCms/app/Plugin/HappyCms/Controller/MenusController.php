<?php
class MenusController extends AppController
{
    //var $helpers = array('Html','Layout');
    var $uses = array('HappyCms.Menu','HappyCms.Extension');
    
    var $Hmodel_name = '_Menu';
    /** var uses when we automatically create a new element
     *
     */
    
    var $default_params = array('eng'=>array('title'=>'[Title]'),
						'fre'=>array('title'=>'[Titre]'));
    
    function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allowedActions = array('getTree');
	
	}
    
    /*
    function view($id=-1)
    {
        $r = $this->Page->findById($id);
        
        if(empty($r))
        {
            $r = $this->redirect(array('controller' => 'home', 'action' => 'index'));        
        }
        $this->set('contents',$this->Content->find('all'));
        
        $this->set('page',$r['Page']);
        
       $this->pageTitle = $r['Page']['title'];
       
        
    }
    

    
    
   function admin_index() {
		$this->request->data = $this->Menu->generatetreelist(null, null, null, '|_');
		debug ($this->request->data); die;       
	}
    
    function display($key='home')
    {
        
        $r = $this->Page->find('first',array('conditions'=>array('alias'=>$key)));
        
        $this->set($r);
    }*/
    function admin_sub_menu_edit($params)
    {
    	$this->request->data = $this->request->data = $this->getItem($this->request->data['Menu']['item_id']);
		
    }
    function admin_sub_menu_new($menu_id)
    {
		
    }
    function admin_top_menu_edit($menu_id)
    {
	
    }
    function admin_top_menu_new($menu_id)
    {
	
	$this->redirect(array('action'=>'top_menu_edit',$menu_id));
    }

    function admin_to_trash($item_id,$lang=null)
    {
    	if($lang===null)
    	{
    		$lang=Configure::read('Config.languages');
    	}
    	$ajax = !empty($this->request->data['ajax']);


	$menu = $this->Menu->find('first',array(
	    'conditions'=>array(
		'Menu.item_id'=>$item_id
	    )
	));

	parent::admin_to_trash_($item_id,$lang);
		
	$r = $this->Content->find('count',array('conditions'=>array('Content.item_id'=>$item_id,
					'extension'=>$this->getExtensionName())));
	
	if($r)
	{
		if(!$ajax)
		{
			$this->redirect('/admin/');
		}
	    return true;
	}
	
	$children = $this->Menu->children($menu['Menu']['id']);
	$items = $this->getItem($menu['Menu']['item_id']);
	if(empty($children) && empty($items['_Menu']['id']))
	{
		$this->Menu->recover();
	    $this->Menu->delete($menu['Menu']['id']);

	    $controllerName = ucfirst($menu['Menu']['extension']).'Controller';
        App::uses($controllerName,$this->extensionPlugin($menu['Menu']['extension']).'Controller');
        if(method_exists($controllerName, 'admin_'.$menu['Menu']['view'].'_delete'))
        {
        	$viewParams = $this->requestAction('/admin/'.$menu['Menu']['extension'].
			     '/'.$menu['Menu']['view'].'_delete'.'/'.
			      $menu['Menu']['params']);
        }


	    if($ajax)
	    	echo 'DELETED';
	}

	if(!$ajax)
	{
		$this->redirect('/admin/');
	}
	exit();
    }
    /*function admin_to_trash($id=null)
    {
        if(!$id) exit();
        $children = $this->Menu->children($id);
	if(!empty($children))
	{
	    $this->Session->setFlash("La page ne peut pas être supprimée (elle contient d'autres pages)");
	    $this->redirect(array('action'=>'index', 'admin'=>true));
	    exit();
	}
	$menu = $this->Menu->findById($id);
	
	$this->deleteItem($menu['Menu']['item_id']);
	
        $this->Menu->delete($id);
        $this->Session->setFlash("La page a bien été supprimée");
        $this->redirect(array('action'=>'index', 'admin'=>true));
	exit();
	
    }*/
    function admin_moveup($id=null)
    {
        if(!$id) exit();
	 //$this->Menu->recover();
        $this->Menu->moveUp($id);
        $this->Session->setFlash("La page a bien été modifiée");
        $this->redirect(array('action'=>'index', 'admin'=>true));
	
    }
    function admin_movedown($id=null)
    {
        if(!$id) exit();
	
        $this->Menu->moveDown($id);
        $this->Session->setFlash("La page a bien été modifiée");
        $this->redirect(array('action'=>'index', 'admin'=>true));
	
    }
    function admin_add_new($parent_id,$move)
    {
    	
    	$item_id=$this->createItem();
	    
	    $this->request->data['Menu']['item_id']=$item_id;
	    
	    $this->Menu->id=null;
	    $this->Menu->save(array('Menu'=>array('parent_id'=>$parent_id,'item_id'=>$item_id)));
	   
	    //$this->Menu->recover();
	    
	    if($move>0)
	    {
			for($i=0;$i<$move;$i++)
			{
			     $this->Menu->moveUp();//$this->request->data['Menu']['id']);
			}
	    }
	    if($move<0)
	    {
			for($i=0;$i<-$move;$i++)
			{
			     $this->Menu->moveDown();//$this->request->data['Menu']['id']);
			}
		}
		$this->redirect(array(
			'controller'=>'menus',
			'action'=>'empty_module',
			'admin'=>true,
			$this->Menu->id
			));
		exit(debug($this->Menu->data));
    }
    function admin_move()
    {
       
	if(!$this->request->data) { echo '{"result":false}'; exit(); }
        
	if(empty($this->request->data['Menu']['id']))
	{
	    $item_id=$this->createItem();
	    
	    $this->request->data['Menu']['item_id']=$item_id;
	    
	    $this->Menu->id=null;
	    $this->Menu->save(array('Menu'=>array('parent_id'=>$this->request->data['Menu']['parent_id'],'item_id'=>$item_id)));
	   
	    
	    if($this->request->data['Move']>0)
	    {
		for($i=0;$i<$this->request->data['Move'];$i++)
		{
		     $this->Menu->moveUp($this->Menu->id,1);//$this->request->data['Menu']['id']);
		}
	    }
	    if($this->request->data['Move']<0)
	    {
		for($i=0;$i<-$this->request->data['Move'];$i++)
		{
		     $this->Menu->moveDown($this->Menu->id,1);//$this->request->data['Menu']['id']);
		}
		}
	    
	    echo '{"result":true,"new":true}';
	    exit();
	}
    
    
    
	if($this->Menu->save($this->request->data))
	{
		//$this->Menu->id = $this->request->data['Menu']['id'];
	    
	    if($this->request->data['Move']>0)
	    {
			for($i=0;$i<$this->request->data['Move'];$i++)
			{
			     $this->Menu->moveUp($this->Menu->id,1);//$this->request->data['Menu']['id']);
			}
	    }
	    if($this->request->data['Move']<0)
	    {
			for($i=0;$i<-$this->request->data['Move'];$i++)
			{
			     $this->Menu->moveDown($this->Menu->id,1);//$this->request->data['Menu']['id']);
			}
	    }
	    //$this->Menu->recover();
	    echo '{"result":true}';
	    exit();
	}
	
	echo '{"result":false}';
	exit();
    }
    
    
    function admin_save()
    {
	
		parent::admin_save();

		$this->redirect(array('action'=>'index', 'admin'=>true));
	/*if(!$this->request->data) exit();
        $this->Menu->save($this->request->data);
        $this->Session->setFlash("La page a bien été enregistrée");
        $this->redirect(array('action'=>'index', 'admin'=>true));*/
    }
    
    function admin_index($id=null)
    {
    }
    
    
    function admin_empty_module($id=0)
    {
		if(!$id) exit();
		
		
		$extensions = Configure::read('Extensions');
		foreach($extensions as $controller=>$def)
		{
		   
			foreach($def['views'] as $view=>$view_label)
			{
				if(empty($options[$view_label['optgroup']]))
				{
					$options[$view_label['optgroup']]=array();
				}

			    $options[$view_label['optgroup']][$controller.':'.$view]=$view_label['name'];
			}
			
	    
		}
		
		//debug($options);

		$this->set('extensions',$options);
		$this->set('id',$id);
	
    }
    
    function admin_affect_module()
    {
		if(!$this->request->data) exit('empty data');
	
		list($ext,$view) = explode(':',$this->request->data['Menu']['extension'],2);
		$this->request->data['Menu']['extension']=$ext;
		$this->request->data['Menu']['view']=$view;
	
        $this->Menu->save($this->request->data);
        $this->request->data = $this->Menu->findById($this->Menu->id);

        $controllerName = ucfirst($this->request->data['Menu']['extension']).'Controller';
        App::uses($controllerName,$this->extensionPlugin($this->request->data['Menu']['extension']).'Controller');
        

        if(method_exists($controllerName, 'admin_'.$this->request->data['Menu']['view'].'_new'))
        {
        	$viewParams = $this->requestAction('/admin/'.$this->request->data['Menu']['extension'].
			     '/'.$this->request->data['Menu']['view'].'_new'.'/'.
			      $this->request->data['Menu']['id']);


			if(!empty($viewParams))
			{
				$this->Menu->save(array('Menu'=>array('id'=>$this->request->data['Menu']['id'],
	                                                              'params'=>$viewParams)));
			}
        }

		
	
        $this->redirect(array('controller'=>'contents','action'=>'item_edit','menus', $this->request->data['Menu']['item_id']));
        exit();
    }
    
    function index($id=null)
    {
	//debug($this);
	
        $r = $this->Menu->findByDefault(1);
        //$r = $this->Menu->generatetreelist();
	$this->redirect(array('controller'=>$r['Extension']['controller'],
			      'action'=>$r['Extension']['action'],
			      $r['Menu']['params']
			));
	exit();
    }
    
    function admin_edit($id=null) {
	
	if($id)
        {
	    $menu = $this->Menu->findById($id);
	    $this->request->data = $this->getItem($menu['Menu']['item_id']);
        }
	
	
	
	$out=$this->requestAction('/admin/contents/load_form/'.$menu['Menu']['extension'].'/'.$menu['Menu']['view'].'_edit');
	
	$this->set('controller_output', $out);
	
	}
    function admin_item_edit($item_id)
    {
	$menu = $this->Menu->find('first',array('conditions'=>array('Menu.item_id'=>$this->request->data[$this->Hmodel_name]['id'])));

	$out=$this->requestAction('/admin/contents/load_form/'.$menu['Menu']['extension'].'/'.$menu['Menu']['view'].'_edit/'.$menu['Menu']['params'],
				 array('named'=>array('lang_form'=>$this->_requestedLanguage,
                                                                     'first_call'=>false,
                                                                     'data'=>$menu)));
	
	if(!is_array($out))
	{
		$out = array('output'=>$out);
	}
	$this->set('controller_output', $out);
	$this->set('SubExtensionName', $menu['Menu']['extension']);
    }
    
    function list_menus($parent_id)
    {
    	if(empty($parent_id))
    	{
    		$parent_id=2;//'IS NULL';
    	}

         //$this->Menu->Behaviors->attach('Content');
         
         //$menus = $this->Menu->find('threaded',array('conditions'=>array('parent_id'=>$parent_id)));

     	$parent = $this->Menu->find('first', array('conditions' => array('Menu.id' => $parent_id)));
	   	$menus = $this->Menu->find('threaded', array(
		    'conditions' => array(
		        'Menu.lft >' => $parent['Menu']['lft'], 
		        'Menu.rght <' => $parent['Menu']['rght']
		    ),
		    'order'=>'Menu.lft'
	   	));
	   	//debug($menus);
	   	//exit();
        
        return $menus;
    }
    function admin_options_list($parent_id='IS NULL')
    {
       	//$this->Menu->Behaviors->attach('Content');

        $list = $this->Menu->generateTreeList ();//null, 'Menu.id', 'Menu.item_id',  '_', null);
        
        //debug($list);
       $keys=array();
       foreach($list as $key=>&$l)
        {
            preg_match('/(_*)([^_]{1}.*)/',$l,$matches);
            if(empty($matches[1]) || empty($matches[2]))
            {
                continue;
            }
            $keys[]=$matches[2];
            $l = array('prefix'=>$matches[1],
                       'id'=>$matches[2]
                      );
        }
        //debug($keys);
       $content = $this->Content->find('list',array('conditions'=>array(
            'Content.extension'=>'menus',
            'Content.item_id' => $keys,
            'Content.language_id'=>Configure::read('Config.id_language')
        ),'fields' => array('Content.item_id', 'Content.params')
            ));
       //debug($content);
        foreach($list as $key=>&$l)
        {
            if(empty($l))
            {
                $list[$key]="Menu racine";
            }
            elseif(!empty($content[$l['id']]))
            {
                $temp = json_decode($content[$l['id']],true);
                
                $l = $l['prefix'].$temp['title'];
            }
            else{
                unset($list[$key]);
            }
            
            
        }
        
        return $list;
    }

    function admin_togglePublished()
    {
    	if(empty($this->request->data['_Menu']['language']) || empty($this->request->data['_Menu']['id']))
    	{
    		
    		exit('empty data');
    	}
    	$this->_requestedLanguage = $this->request->data['_Menu']['language'];
    	$item = $this->getItem($this->request->data['_Menu']['id']);

    	$item['_Menu'][$this->_requestedLanguage]['published']=empty($item['_Menu'][$this->_requestedLanguage]['published'])?'1':'0';
    	$this->Content->saveItem(array('Content'=>current($item)));


    	exit();
    	

    }

  /*  function admin_afterParamsSave($lang,$data)
    {
    	if(empty($data['Contet'][$lang]['default_menu_id']))
    	{
    		return;
    	}
    	$menu_id = (int)$data['Contet'][$lang]['default_menu_id'];
    	$this->Menu->updateAll(array('Menu'=>array('default'=>0)));
    	$this->Menu->save(array('Menu'=>array(
	    	'id'=>$menu_id,
	    	'default'=>1
	    	)));
    }*/
}
?>