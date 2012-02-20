<?php

class ManagerController extends MediaAppController
{
		//public $components = array('Img');
		public $uses = array('Media'); 
		public $helpers = array('Form'); 

		public function beforeFilter(){
			parent::beforeFilter(); 
			$this->layout = 'modal';
		}
		function admin_delete($id)
		{
			$ajax = empty($this->request->data['ajax'])?false:true;
			
			$this->Media->id = $id;
			$file = $this->Media->field('url');

			$file = preg_replace('/^.*(\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+.[a-zA-Z0-9]{1,7})$/','../webroot$1',$file);
			unlink($file);

			$file = preg_replace('/\/[^\/]+(\/[^\/]+\/[^\/]+\/[^\/]+)(\.[a-zA-Z0-9]{1,7})$/','/thumbs$1_*$2',$file);


			foreach(glob($file) as $v){
				unlink($v);
			}

			$this->Media->delete($id);

			if($ajax)
			{
				exit('{"result":true}');
			}

			//$this->Session->setFlash("L'image a bien été supprimée","notif");
			//$this->redirect($this->referer());
			exit();

			

		}
		function admin_index($contextExtension,$contextId,$domId='tinyMce',$multiple=0){
		$checkList =array();
		if(!empty($_GET['checkList']))
		{
			if(strpos($_GET['checkList'],',')!==false)
			{
				$checkList = explode(',',$_GET['checkList']);
			}
			else{
				$checkList = array($_GET['checkList']);
			}
		}
		$this->set('checkList',$checkList);

		$contextIdCondition = true;
		if($contextId==='null') 
		{
			$contextId = 0;
			$contextIdCondition = false;
		}
		$conditions = array(
			'context_extension'=>$contextExtension,
			'context_id'=>($contextIdCondition?$contextId:false)
		);
		if(!empty($_GET['all']))
		{
			$conditions = array();
		}
		$d = array(); 
		$d['medias'] = $this->Media->find('all',array(
			'conditions' => $conditions
		));
		$d['formats'] = Configure::read('Media.formats');
		$d['contextExtension'] = $contextExtension;
		$d['contextId'] = $contextId;

        $get = $this->params['url'];
        if(!empty($get['filter']))
        {
			$this->request->data['Media']['filter'] = urldecode($get['filter']); 
        }

		$this->set($d);
        $this->set('domId',$domId);
        $this->set('multiple',$multiple);

	}

	function admin_tiny_show($id=null,$format = ''){
		$d = array();
		if($this->request->data){
			$this->set($this->request->data['Media']);
			$this->layout = false;
			$this->render('tinymce'); 
			return; 
		}
		if($id){
			$this->Media->id = $id;  
			$media = $this->Media->read();
			if(empty($media))
			{
				$this->Session->setFlash("L'id n'existe pas","flash_error",array('type'=>'error'));
				$this->redirect($_SERVER['HTTP_REFERER']);
				exit();
			}
			//$format
			$media = current($media);
			$d['src'] = $media['url']; 
			$d['alt'] = $media['name'];  
			$d['style'] = 'float: left;';   
			$d['format'] = '150x0';  
		}else{
			$d = $this->params['url'];
			$d['src'] = urldecode($d['src']); 

			if(preg_match('/_[0-9]+x[0-9]+$/', $d['src']))
			{
				$temp = explode('_',$d['src']);
				$d['format'] = end($temp);
				$d['src'] = preg_replace('/(.*)_[0-9]+x[0-9]+$/','$1', $d['src']);
			}
			

			$d['alt'] = urldecode($d['alt']); 
			$d['style'] = urldecode($d['style']);
		}
		$this->set($d);
	}



	function admin_upload_form($contextExtension,$contextId,$domId)
    {
    	if(empty($contextId))
    	{
    		$contextId = 0;
    	}
        if(empty($contextExtension) || empty($domId))
        {
            exit('erreur');
        }
        $mulpiple = false;

		$filesNumberLimit = -1;

        $this->set('filesNumberLimit',$filesNumberLimit);
        $this->set('contextExtension',$contextExtension);
        $this->set('contextId',$contextId);
        $this->set('domId',$domId);
        $this->layout = 'empty';

    }

    function admin_upload()
    {
    	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		// Settings
		//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		$DS='/';
		$contextExtension = isset($_REQUEST["contextExtension"]) ? $_REQUEST["contextExtension"]  : '';
		$contextId = isset($_REQUEST["contextId"]) ? $_REQUEST["contextId"]  : '';


		$targetDir = '../webroot/media/'.date('Y');
		if(!file_exists($targetDir))
			mkdir($targetDir,0777);
		$targetDir .= DS.date('m');
		if(!file_exists($targetDir))
			mkdir($targetDir,0777);

		$linkDir='/media/'.date('Y').'/'.date('m');
		

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Get parameters
$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

$realName = preg_replace('/[^\w\.\-]+/', ' ', $fileName);


if(($currentname = $this->Session->read('Media.currentUploadedFile.'.$realName)))
{
	$fileName = $currentname;
}
else
{
	$fileName = preg_replace('/^(.*)\.([a-z]{1,4})$/',uniqid('').'_'.substr(microtime(),-5).'.$2',$fileName);
	$this->Session->write('Media.currentUploadedFile.'.$realName,$fileName);
}


// Clean the fileName for security reasons

/*
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
*/
$id = 0;
$url = $linkDir.'/'.$fileName;
//$url = Router::url($url,true);
if (!$chunks || $chunk == $chunks - 1) { // last chunk
	$this->Session->write('Media.currentUploadedFile.'.$realName,false);
	$this->Media->save(
			array(
			'Media'=>array(
				'name'=>$realName,
				'url'=>$url,
				'context_extension'=>$contextExtension,
				'context_id'=>$contextId
				)
				
			)
		);
		$id = $this->Media->id;
}
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



// Return JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null ,"url":"'.$url.'","realName":"'.$realName.'","id":"'.$id.'"}');


    }

    function admin_js()
    {
    	header("Content-type: application/javascript");
    	$this->layout = false;
    }

    function admin_id2url($id)
    {
    	if(empty($id))
    	{
    		return false;
    	}
    	$r = $this->Media->findById($id);
    	if(!empty($r))
    	{
    		return $r['Media']['url'];
    	}
    	return false;
    }
}