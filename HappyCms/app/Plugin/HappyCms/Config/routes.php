<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
require_once ROOT.DS.APP_DIR.'/Plugin/HappyCms/Config/RouteClass.php';

        Router::connectNamed(array('slug'));


    if(Configure::read('Config.multilanguage'))
    {    
	    Router::connect('/admin/:language/:controller/:action/*', array('admin'=>true,'plugin'=>'HappyCms'),array('language'=>'[a-z]{3}'));
		Router::connect('/admin/:language/:controller/', array('admin'=>true,'plugin'=>'HappyCms'),array('language'=>'[a-z]{3}'));
	}

  /** HappyCms routes */
	foreach(Configure::read('HappyCms.ControllersNeedRoutes') as $controllerNeedRoutes)
  {
    // Admin
    Router::connect('/admin/'.$controllerNeedRoutes.'/:action/*', array('controller'=>$controllerNeedRoutes,'action'=>'index','admin'=>true,'plugin'=>'HappyCms'));
    Router::connect('/admin/'.$controllerNeedRoutes.'/*', array('controller'=>$controllerNeedRoutes,'action'=>'index','admin'=>true,'plugin'=>'HappyCms'));
    if(Configure::read('Config.multilanguage'))
    {  
        Router::connect('/admin/:language/'.$controllerNeedRoutes.'/:action/*', array('controller'=>$controllerNeedRoutes,'action'=>'index','admin'=>true,'plugin'=>'HappyCms'),array('language'=>'[a-z]{3}'));
        Router::connect('/admin/:language/'.$controllerNeedRoutes.'/*', array('controller'=>$controllerNeedRoutes,'action'=>'index','admin'=>true,'plugin'=>'HappyCms'),array('language'=>'[a-z]{3}'));
    }
    // Other
    Router::connect('/'.$controllerNeedRoutes.'/:action/*', array('controller'=>$controllerNeedRoutes,'action'=>'index','plugin'=>'HappyCms'));
    Router::connect('/'.$controllerNeedRoutes.'/*', array('controller'=>$controllerNeedRoutes,'action'=>'index','plugin'=>'HappyCms'));

    if(Configure::read('Config.multilanguage'))
    {  
        Router::connect('/:language/'.$controllerNeedRoutes.'/:action/*', array('controller'=>$controllerNeedRoutes,'action'=>'index','admin'=>false,'plugin'=>'HappyCms'),array('language'=>'[a-z]{3}'));
        Router::connect('/:language/'.$controllerNeedRoutes.'/*', array('controller'=>$controllerNeedRoutes,'action'=>'index','admin'=>false,'plugin'=>'HappyCms'),array('language'=>'[a-z]{3}'));
    }
  }


/** Default admin routes */

  Router::connect('/admin/', array('controller' => 'menus', 'action' => 'index', 'admin'=>true,'plugin'=>'HappyCms'));
  Router::connect('/admin', array('controller' => 'menus', 'action' => 'index', 'admin'=>true,'plugin'=>'HappyCms'));

/** Other admin routes */
  Router::connect('/admin/:controller/:action/*', array('action'=>'index','admin'=>true));
	Router::connect('/admin/:controller/', array('admin'=>true));
      
    if(Configure::read('Config.multilanguage'))
    {
      	Router::connect('/admin/:language/', array('admin'=>true),array('language'=>'[a-z]{3}'));
		    Router::connect('/admin/:language', array('controller' => 'menus', 'action' => 'index', 'admin'=>true),array('language'=>'[a-z]{3}'));
    }


  Router::connect('/HappyCms/:controller/:action/*', array('action'=>'index','plugin'=>'HappyCms'));

  if(Configure::read('Config.multilanguage'))
  {
        Router::connect('/:language/HappyCms/:controller/:action/*', 
                array('action'=>'index','plugin'=>'HappyCms'),
                array('language'=>'[a-z]{3}'));
  }


  
  /** Default root */

	Router::connect('/', array('controller' => '', 'action' => '' ,'slug'=> 'default' ),array(
                                                                                       'routeClass' => 'HappyRoute'));
    if(Configure::read('Config.multilanguage'))
    {                                                                                  
		Router::connect('/:language', array('controller' => '', 'action' => ''  , 'slug'=> 'default' ),array('language'=>'[a-z]{3}',
                                                                                                'routeClass' => 'HappyRoute'
                                                                                                ));
    }
        
  /* Media Routes */
  Router::connect('/media/:controller/:action/*', array('plugin'=>'media','controller' => 'manager', 'action' => 'index', 'admin'=>true));
  Router::connect('/media/:controller/:action', array('plugin'=>'media','controller' => 'manager', 'action' => 'index', 'admin'=>true));
  
  if(Configure::read('Config.multilanguage'))
  {
    Router::connect('/:language/media/:controller/:action/*', array('plugin'=>'media','controller' => 'manager', 'action' => 'index', 'admin'=>true),array('language'=>'[a-z]{3}'));
    Router::connect('/:language/media/:controller/:action', array('plugin'=>'media','controller' => 'manager', 'action' => 'index', 'admin'=>true),array('language'=>'[a-z]{3}'));
  }
  

  
/** Front-End slugged Root 
 *
 */
 	if(Configure::read('Config.multilanguage'))
  {
		  Router::connect('/:language/:slug', array(
                                              'controller' => '', 'action' => ''
                                              ),array('language'=>'[a-z]{3}','routeClass' => 'HappyRoute'));
  }

	Router::connect('/:slug', array(
                                    'controller' => '', 'action' => ''
                                    ),array('routeClass' => 'HappyRoute'));
        
 /**
 *    Some custom routes
 */       
          Router::connect('/article/*',array('controller' => 'posts', 'action' => 'view'));
    
    
        
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */

	
  if(Configure::read('Config.multilanguage'))
  {    
    Router::connect('/:language/:controller/:action/*',array(),array('language'=>'[a-z]{3}','routeClass' => 'HappyRoute'));
		Router::connect('/:language/:controller/*',array(),array('language'=>'[a-z]{3}','routeClass' => 'HappyRoute'));
		Router::connect('/:language/*',array(),array('language'=>'[a-z]{3}','routeClass' => 'HappyRoute'));
	}
		Router::connect('/:controller/:action/*',array(),array('routeClass' => 'HappyRoute'));
		Router::connect('/:controller/*',array(),array('routeClass' => 'HappyRoute'));
		Router::connect('/*',array(),array('routeClass' => 'HappyRoute'));
        
        
