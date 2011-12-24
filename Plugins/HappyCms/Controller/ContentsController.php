<?php

class ContentsController extends AppController
{
    
    var $user = array();
    var $helpers = array('Html');
    
    
 
    
    function index()
    {
        
    }
    function home($params)
    {
        $item = $this->Content->item(1,(int)$params);
        $this->set('item',$item['Content']);
       
    }
    function admin_home_edit($params,$menu_id)
    {
        $this->request->data = $this->Content->item(1,$params,true);
        $this->request->data['Menu']['can_appear'] = $menu_id;
       $this->helpers[] = 'Tinymce';
        //debug( $item['Content']['params']);
    }
    function admin_display_new($params)
    {
       
        /*$mod = $this->Module->findById(1);
        $mod_params=json_decode($mod['Module']['params'],true);
        $id = (int)$mod_params['current_id'];
        $mod_params['current_id']=$id+1;
        $mod['Module']['params']=json_encode($mod_params);
        $this->Module->save($mod);
        
        
        $this->Content->id=null;
        $page = $this->Content->save(array('Content'=>array('module_id'=>1,
                                                              'lang_id'=>2,
                                                              'item_id'=>$id)));
        $this->Content->id=null;
        $page = $this->Content->save(array('Content'=>array('module_id'=>1,
                                                              'lang_id'=>1,
                                                              'item_id'=>$id)));
        
        $page = $this->Menu->save(array('Menu'=>array('id'=>(int)$params,
                                                              'params'=>$id)));
       
        
       */
        $this->redirect(array('action'=>'home_edit', $id));
    }

    function admin_files($extension,$filter=null)
    {
        App::import('Helper','Html');
        $html = new HtmlHelper();
        
        if ($handle = opendir('../webroot/files/uploads/'.$extension.'/')) {    
            while (false !== ($file = readdir($handle))) {
                if($file != "." && $file!="..")
                {
                    echo '<div class="item">'.
                    $this->Html->image($this->Html->url('/files/uploads/'.$extension.'/'.$file,true),array('height'=>60)).
                    '<span class="title">'.$file.
                    '</span></div>';
                }
            }
        }
        exit();
    }
    function admin_item_add_form($extension,$lang,$item_id=null)
    {
       
            App::import('Controller',ucfirst($extension));
            $controllerName = ucfirst($extension).'Controller';
            $controller = new $controllerName();
            $modelName = $controller->Hmodel_name;
       
        $item=array($modelName=>array('id'=>$item_id),
                        'Language'=>array('code'=>$lang));
         
        
        $output=$this->requestAction('/admin/contents/load_form/'.$extension.'/item_edit/'.$item_id,
                                                array('named'=>array('lang_form'=>$lang,
                                                                     'first_call'=>false,
                                                                     'data'=>$item)));
        if(!empty($this->params['requested']))
        {
            return $output;
        }
        echo $output['output'];
        exit();
        
    }
    function admin_item_edit($extension,$item_id=null)
    {
        

        $allowed = $this->requestAllowed('contents',$extension.'_edit',$this->online,$this->Auth->user('Group.rules'));
        $allowed = $this->requestAllowed('contents',$extension.'_edit',$this->online,$this->Auth->user('rules'),$allowed);


        if(!$allowed)
        {
            $this->Session->setFlash('Vous n\'êtes pas autorisé à voir cette page','flash_warning');
            $this->redirect('/admin/');
            exit();
        }


        if(!empty($_GET['ajax']))
        {
            $this->layout='ajax';
        }
        
        $this->helpers[]='Tinymce';
        $items = $this->Content->find('all',array('conditions'=>array(
                                                             'Content.item_id'=>$item_id,
                                                             'extension'=>$extension
                                                             )));
      //  $this->Extension->load($extension);
        // debug($this->Extension->HcontrollerName);
         //debug($this->Extension->HcontrollerName);

        //debug(
              //);
            $total_output=array();
            $languages = Configure::read('Config.languages');
            $form_languages=array();
            $output['formOptions']=array();
            
            $controllerName = ucfirst($extension).'Controller';
            
            
            App::uses($controllerName,$this->extensionPlugin($extension).'Controller');

            $controller = new $controllerName();
            $modelName = $controller->Hmodel_name;
            $this->set('modelName',$modelName);
            $force_all_languages= $controller->Hforce_all_languages;
            
              $items2=$this->Content->item($extension,$item_id,array('lang'=>Configure::read('Config.languages'),
                  ));
                   //debug($items2);    
              if(!empty($items2['Content'])  &&$modelName!='Content')
              {
                $items2[$modelName]=$items2['Content'];
                unset($items2['Content']);
              }
              
            $this->request->data['Happy']['force_all_languages']=$controller->Hforce_all_languages;

       // foreach($items as $item)
        
        foreach(Configure::read('Config.id_languages') as $lang=>$lang_id)
        {
            //$lang = $item['Language']['code'];
            
            if(!isset($items2[$modelName][$lang]))
            {
                continue;
            }
            
            
            $form_languages[$lang]=Configure::read('Config.name_languages.'.$lang);//$item['Language']['name'];
             /*
            $params = json_decode($item['Content']['params'],true);
           $content = array_merge((array)$params,array(
                                           'id'=>$item['Content']['item_id'],
                                           '_extension'=>$item['Content']['extension'],
                                           $lang=>$params));*/
            $items2['Language'] = array('code'=>$lang,'id'=>$lang_id);
            
            $items2[$modelName] =array_merge($items2[$modelName],$items2[$modelName][$lang]);
        
            $output=$this->requestAction('/admin/contents/load_form/'.$extension.'/item_edit/'.$items2[$modelName]['id'],
                                                array('named'=>array('lang_form'=>$lang,
                                                                     'data'=>$items2)));

            if(!is_array($output))
            {
                $output = array('output'=>$output);
            }
            $total_output[$lang]=$output['output'];
        }
        
        if($force_all_languages)
        {
            $this->request->params['requested']=1;
           foreach($languages as $lang)
           {
                if(!isset($total_output[$lang]))
                {
                    $output = $this->admin_item_add_form($extension,$lang,$item_id);
                    $form_languages[$lang]=Configure::read('Config.name_languages.'.$lang);
                    $total_output[$lang] = $output['output'];
                }
           }
        }
        elseif(empty($items))
        {
            $this->request->params['requested']=1;
            $lang = Configure::read('Config.language');
            $output = $this->admin_item_add_form($extension,$lang,$item_id);
            $form_languages[$lang]=Configure::read('Config.name_languages.'.$lang);
            $total_output[$lang] = $output['output'];
        }
        $shared_output = empty($output['shared_output'])?'':$output['shared_output'];
        $this->set('shared_output',$shared_output);
        $this->set('ExtensionName',$extension);
	$this->set('item_id', $item_id);
	$this->set('form_languages', $form_languages);
	$this->set('force_all_languages', $force_all_languages);
	$this->set('formOptions', empty($output['formOptions'])?array():$output['formOptions']);
	$this->set('controller_output', $total_output);

        
        
    }
    function admin_upload()
    {

/**
 * upload.php
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

// HTTP headers for no cache etc
$contentType ='';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
$DS='/';
$extension = isset($_REQUEST["extension"]) ? $_REQUEST["extension"]  : '';
$lang = isset($_REQUEST["lang"]) ? $_REQUEST["lang"]  : '';
$fieldName = isset($_REQUEST["fieldname"]) ? $_REQUEST["fieldname"]  : '';
$contentId = isset($_REQUEST["contentid"]) ? $_REQUEST["contentid"]  : 0;

$targetDir = '../webroot/files' . $DS . 'uploads' . $DS . $extension ;

//$cleanupTargetDir = false; // Remove old files
//$maxFileAge = 60 * 60; // Temp file age in seconds

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Get parameters
$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

// Clean the fileName for security reasons
$fileName = preg_replace('/[^\w\._]+/', '', $fileName);

// Make sure the fileName is unique but only if chunking is disabled
if ($chunks < 2 && file_exists($targetDir . $DS . $fileName)) {
	$ext = strrpos($fileName, '.');
	$fileName_a = substr($fileName, 0, $ext);
	$fileName_b = substr($fileName, $ext);

	$count = 1;
	while (file_exists($targetDir . $DS . $fileName_a . '_' . $count . $fileName_b))
		$count++;

	$fileName = $fileName_a . '_' . $count . $fileName_b;
}

// Create target dir
if (!file_exists($targetDir))
	@mkdir($targetDir);

// Remove old temp files
/* this doesn't really work by now
	
if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
	while (($file = readdir($dir)) !== false) {
		$filePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		// Remove temp files if they are older than the max age
		if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
			@unlink($filePath);
	}

	closedir($dir);
} else
	die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
*/

// Look for the content type header

if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
	$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

if (isset($_SERVER["CONTENT_TYPE"]))
	$contentType = $_SERVER["CONTENT_TYPE"];

// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
if (strpos($contentType, "multipart") !== false) {
	if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
		// Open temp file
		$out = fopen($targetDir . $DS . $fileName, $chunk == 0 ? "wb" : "ab");
		if ($out) {
			// Read binary input stream and append it to temp file
			$in = fopen($_FILES['file']['tmp_name'], "rb");

			if ($in) {
				while ($buff = fread($in, 4096))
					fwrite($out, $buff);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			fclose($in);
			fclose($out);
			@unlink($_FILES['file']['tmp_name']);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
} else {
	// Open temp file
	$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
	if ($out) {
		// Read binary input stream and append it to temp file
		$in = fopen("php://input", "rb");

		if ($in) {
			while ($buff = fread($in, 4096))
				fwrite($out, $buff);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

		fclose($in);
		fclose($out);
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

/*
if(($result = $this->Content->upload($extension,$lang,$contentId,$fieldName,$fileName))!==true)
{
    $this->unlink($extension,$result);
}*/

// Return JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id","realName":"'.$fileName.'"}');


    }
    
    
    
    function admin_load_form($extension=NULL,$view=NULL,$params=NULL)
    {
        
        if(!isset($extension,$view) || empty($this->params['requested']))
        {
            return array('output'=>'FALSE',
                         'error'=>array('$requested'=>$this->params['requested'],
                                        '$view'=>isset($view),
                                        '$extension'=>isset($extension)
                                        )
                         );
        }
        
        
	
    $controllerName = ucfirst($extension).'Controller';
	App::uses($controllerName,$this->extensionPlugin($extension).'Controller');
    
	$controller = new $controllerName();
	$prefix = empty($this->request->params['prefix'])?'':$this->request->params['prefix'].'_';
	$controller->base = $this->base;
	$controller->here = $this->here;
	$controller->webroot = $this->webroot;
	$controller->request = $this->request;
	$controller->action                     = $prefix.$view;
    $controller->request->params['action']  = $prefix.$view;
    $controller->request->params['plugin'] = '';
    if(($temp = $this->extensionPlugin($extension)))
    {
        $controller->request->params['plugin'] = substr($temp,0,strlen($temp)-1);
        $controller->plugin = $controller->request->params['plugin'];
    }
    $controller->request->params['controller']  = $extension;
    $controller->request->params['pass']  = array(0=>$params);
	$controller->passedArgs=array(0=>$params);
    $controller->constructClasses( );
    $controller->startupProcess(  );
    $controller->response = $this->response;
        
	
	if(isset($this->request->params['named']['data']))
    {
        $controller->request->data= $this->request->params['named']['data'];
    }
    
    if(!empty($this->request->params['named']['lang_form']))
    {
        $controller->_requestedLanguage=$this->request->params['named']['lang_form'];
        
    }
    else{
        $controller->_requestedLanguage=Configure::read('Config.language');
    }
    
    if(method_exists($controller, $controller->action))
    {
       $output = call_user_func_array(array(&$controller,$controller->action),$controller->passedArgs);

        $controller->request->data['Happy'] = $this->request->params['named'];
        
        $controller->set('HpLangForm',$controller->_requestedLanguage);
        
        $itemExtension = $this->Extension->find('first',array('conditions'=>array(
                                                                 'controller'=>$extension,
                                                                 'Content.language_id'=>Configure::read('Config.id_languages.'.$controller->_requestedLanguage))));
        
        //debug($itemExtension);
        
        $itemExtension['Content'] = json_decode($itemExtension['Content']['params'],true);
        
        $controller->request->data['Happy']['Extension']=$itemExtension;
        $controller->request->data['Happy']['model_name'] = empty($this->request->params['named']['model_name'])?$controller->Hmodel_name:$this->request->params['named']['model_name'];

        
	    if(isset($this->request->params['named']['data']))
        {
            $controller->request->data= array_merge((array)$this->request->params['named']['data'],(array)$controller->request->data);
        }
        
        $controller->request->data['Happy']['force_all_languages']=$controller->Hforce_all_languages;
        
    	if ($controller->autoRender) {

    		$controller->response = $controller->render($controller->request->params['action'],'happy/controller_edit');
            
            
    	} elseif (empty($controller->output)) {
    		$controller->output = $output;
    	}
    }
    else
    {
        $controller->output=__('Aucune option pour cette page.',true);
    }
	$controller->shutdownProcess();

        
        
    if(empty($controller->request->data['Happy']['output']))
    {
        $controller->request->data['Happy']['output']=array();
    }
    $view = ClassRegistry::getObject('view');
    if(empty($view->request->data['Happy']['output']))
    {
        $view->request->data['Happy']['output']=array();
    }
    $controller->response->body(array_merge((array)$view->request->data['Happy']['output'], array('output'=>$controller->response->body())));
            return $controller->response->body()
            ;
	//    $this->request->data = $this->requestAction('/admin/home/index_edit/12');
	
        
    }

    function search()
    {

        if(empty($this->request->data['Content']['input']))
        {
            $this->redirect('/');
            exit();
        }
        App::uses('Sanitize', 'Utility');
        $searchTerm = htmlentities($this->request->data['Content']['input']);
        $results = $this->Content->find('all',array('conditions'=>array("MATCH(params) AGAINST ('".utf8_decode(Sanitize::escape(htmlentities($this->request->data['Content']['input'], ENT_NOQUOTES, "UTF-8")))."')")));
       // debug(htmlentities($this->request->data['Content']['input'], ENT_NOQUOTES, "UTF-8"));
        ///exit();
        //debug($results);
        $searchResults=array();

        foreach($results as $result)
        {
            $controllerName = ucfirst($result['Extension']['controller']).'Controller';
            App::uses($controllerName,$this->extensionPlugin($result['Extension']['controller']).'Controller');
            if(class_exists($controllerName))
            {
                $controller = new $controllerName();

                if(method_exists($controller,'searchResult'))
                {
                    $content = json_decode($result['Content']['params'],true);
                    $content['id'] = $result['Content']['item_id'];
                    $content['published'] = $result['Content']['published'];
                    $content['created'] = $result['Content']['created'];
                    if( ( $t = $controller->searchResult($content) ) !== false)
                    {
                        $t['content']=strip_tags($t['content']);
                        preg_match('/'.$this->request->data['Content']['input'].'/',$t['content'], $matches, PREG_OFFSET_CAPTURE);

                        if(empty($matches[0]))
                        {
                            continue;
                        }

                        $t['content'] = substr($t['content'], max($matches[0][1]-100,0),strlen($this->request->data['Content']['input'])-max($matches[0][1]-100,0)+$matches[0][1]+100);

                        //debug(array(
                        //    max($matches[0][1]-100,0),
                        //strlen($this->request->data['Content']['input'])-max($matches[0][1]-100,0)+$matches[0][1]+100));

                        $t['content'] = '...'.preg_replace('/('.$this->request->data['Content']['input'].')/','<span class="ResultTermMatch">$1</span>',$t['content']).'...';
                        
                        $searchResults[]=$t;
                    }
                }
            }
            else
            { 
                $this->log('class does not exist : '.$controllerName.'<br/>');
            }
        }

        $this->set('searchTerm',$searchTerm);
        $this->set('bodyClass','search');
        $this->set('searchResults',$searchResults);


        //debug($searchResults);
    }
    
}

?>