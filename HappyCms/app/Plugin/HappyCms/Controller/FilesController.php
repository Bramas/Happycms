<?php

class FilesController extends AppController
{
    var $uses =  array('Category');
    
    var $Hforce_all_languages=true;
    
    function admin_index()
    {
    	$args = func_get_args();
    	$folder = implode('/',$args);
    	if(is_dir(ROOT.DS.$folder))
    	{
	    	$d = dir(ROOT.DS.$folder);
	    	
			$this->set('BaseDir',$folder);
			$this->set('Dir',$d);
    	}
    	else
    	{
    		exit($folder.' is not a directory');
    	}
		
    }
    function admin_edit()
    {
    	$args = func_get_args();
    	$filename = implode('/',$args);
    	if(file_exists(ROOT.DS.$filename))
    	{
	    	$lines = file(ROOT.DS.$filename);

			$this->set('File',$lines);
			$this->set('filename',$filename);

    	}
    	else
    	{
    		exit($filename.' is not a file');
    	}
    }
    function admin_save()
    {
    	$args = func_get_args();
    	$filename = implode('/',$args);
    	if($this->request->data)
    	{
    		
    		$filename = $this->request->data['File']['filename'];

    		if(file_exists(ROOT.DS.$filename))
    		{
              if(!is_dir(ROOT.DS.'files_backup'))
              {
                  mkdir(ROOT.DS.'files_backup');
              }
              if(!is_dir(ROOT.DS.'files_backup'.DS.'new'))
              {
                  mkdir(ROOT.DS.'files_backup'.DS.'new');
              }
              if(!is_dir(ROOT.DS.'files_backup'.DS.'old'))
              {
                  mkdir(ROOT.DS.'files_backup'.DS.'old');
              }
    			//BACKUP THE FILE

    			//copy(ROOT.DS.$filename,ROOT.DS.'trash'.DS.time().'-'.preg_replace('/^.*\/([^\/]*\.[a-zA-Z]{2,3})$/','$1',$filename));
    			copy(ROOT.DS.$filename,ROOT.DS.'files_backup'.DS.'old'.DS.time().'-'.preg_replace('/\//','-',$filename));

    			// THE SAVE

    			$handle=fopen(ROOT.DS.$filename, "w");
    			fwrite($handle, $this->request->data['File']['content']); 
    			fclose($handle);

                copy(ROOT.DS.$filename,ROOT.DS.'files_backup'.DS.'new'.DS.time().'-'.preg_replace('/\//','-',$filename));

    		}

    		$this->redirect('/admin/files/edit/'.$filename);
    	}
    	$this->redirect('/admin/files/');

    	exit();
    }
    function admin_upload_form($extension,$name,$domId,$lang=null,$default='')
    {
        if(empty($lang))
        {
            $lang=Configure::read('Config.language');
        }
        if(empty($lang) || empty($extension) || empty($name) || empty($domId))
        {
            exit('erreur');
        }
        $mulpiple = false;
        if($default == 'multiple')
        {
            $default='';
            $mulpiple=true;
        }
        $this->set('multiple',$mulpiple);
        $this->set('name',$name);
        $this->set('extension',$extension);
        $this->set('lang',$lang);
        $this->set('domId',$domId);
        $this->set('default',$default);
        $this->layout = 'empty';

    }
}