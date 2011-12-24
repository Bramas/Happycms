<?php
session_start();

//include_once('../../../../../../../config/config.inc.php');
//include_once('../../../../../../../init.php');

class tinyimages 
{
	var $mydir = '../../../../../../../';
	var $mydir2 = '../../../../../img/upload';
	var $folder = '../../../../../img/upload';
	var $folder2 = 'img/upload';
	var $thumbs = '';
	var $originales = '';
	
	function __construct() 
	{
		
		 
		define('DIR', '');
		define('base_dir',str_replace('ajax.php',"",$_SERVER['PHP_SELF']).$this->folder);
		
		$this->restrict = $this->folder;
		$this->folder = $this->folder;
		$this->addressBar();
		$this->mainField();
	}
	
	private function leftPanel() 
	{
		
		$ret = array();
		if ($handle = opendir ( DIR.$this->folder )) 
		{
			while (false !== ($file = readdir ( $handle ))) 
			{
				echo DIR.$this->folder.'-';
				if (is_dir(DIR.$this->folder.'/'.$file) && $file != '.') 
				{
					$ret[] = array(
						'path' 	=> $file,
						'name'	=> $file
					);
				}
			}
			closedir ($handle);
		}
		
		// Obtient une liste de colonnes
		foreach ($ret as $key => $row) 
		{
		    $titres[$key]  = $row['name'];
		    $reste[$key] = $row;
		}

		// Trie les données par volume décroissant, edition croissant
		// Ajoute $data en tant que dernier paramètre, pour trier par la clé commune
		// array_multisort($titres, SORT_ASC, $ret);
		
		if(count($ret) > 0) 
		{
			$return = '';
			foreach ($ret as $val) 
			{
				if(//$val['path'] == $this->thumbs || $val['path'] == $this->orignales ||
				   $val['path'] == '.') continue;
				if($val['path'] == '..') 
				{
					$act = '';
					if($this->folder == $this->restrict) continue;
					$path = substr($this->folder,0,strrpos($this->folder,'/'));
					if($path == '') continue;
				}
				else 
				{ 
					$path = $this->folder.'/'.$val['path']; $act = 'onclick="activateDir(this, \''.$path.'\'); return false;"';
				}
				$return .= '<div class="folder"><a href="#" '.$act.' ondblclick="changeFolder(\''.$path.'\'); return false;">'.$val['name'].'</a></div>';
			}
			
			$name = '';
			return $return;
		}
	}
	
	private function addressBar() 
	{
		$way = explode('/', $this->folder);

		$way = array_filter($way);
		$ret = $link  = $link2 = '';
		foreach ($way as $val) 
		{
			if($val != '..') 
			{
				$link = $link.'/'.$val;
				$ret .= '<a href="#">'.$val.'</a>';
				$link2 .= $val;
			}
		}
		return '<img src="images/folder.gif" width="16" height="16" />'.$ret;
	}
	
	private function mainField() 
	{
		
		global $_POST;
		
		$uri = $_POST['uri'];
		$uri = str_replace("//", "/", $uri);
		$uri = $uri.'/';
		$uri2 = substr($uri, 25);  
		
		
		$myfolder = ($_POST['uri'] == '') ? $this->folder : $uri;
		$myfolder2 = ($_POST['uri'] == '') ? $this->folder2 : $uri2;
		
		$ret = array();
		if ($handle = opendir ( DIR.$myfolder )) 
		{
			while (false !== ($file = readdir ( $handle ))) 
			{
				if (is_file(DIR.$myfolder.'/'.$file) && $file != 'Thumbs.db') 
				{
					list($width, $height, $type, $attr) = getimagesize(DIR.$myfolder.'/'.$file);
					
					$size = number_format((filesize(DIR.$myfolder.'/'.$file)/1024),2,',',' ').' KB';
					
					$ret[] = array(
						'src'		=> base_dir.$myfolder2.$file,//base_dir.$myfolder2.$file,
						'orig'		=> base_dir.$myfolder2.$file,
						'attr'		=> $attr,
						'path'		=> $myfolder2.$file,
						'name'	=> $file,
						'width'	=> $width,
						'height'	=> $height,
						'size'		=> $size,
						'base' => base_dir
					);
				}
			}
			closedir ($handle);
		}
		
		// Obtient une liste de colonnes
		foreach ($ret as $key => $row) 
		{
		    $titres[$key]  = $row['name'];
		    $reste[$key] = $row;
		}

		if(count($ret) > 0) 
		{
			$return = $name = '';
			foreach ($ret as $val)
			{
				$addOrig = '<a href="#" title="Ins&eacute;rer l\'image " onclick="addImage(this,\''.$val['orig'].'\','.$val['width'].', '.$val['height'].'); return false;" alt=" ">Ins&eacute;rer l\' image</a>';
				$return .= '<div class="item" ondblclick="addImage(this,\''.$val['base'].$val['path'].'\','.$val['width'].', '.$val['height'].');" onclick="activateItem(this,\''.$val['path'].'\');"><img src="'.$val['src'].'" width="'.$val['width'].'" height="'.$val['height'].'" title="'.$val['name'].'"  alt=" " /><div class="labels">'.$addOrig.'</div><div class="labels">'.$val['name'].'</div><div class="labels">'.$val['width'].'x'.$val['height'].'</div><div class="labels">'.$val['size'].'</div></div>';
			}

			return $return.'<div style="clear:both;"></div>';
		}
	}
	
	function ajaxChangeDir($input) 
	{
		
		
		
		$our_folder = $this->folder;
		
		if($input['uri'] != '') 
		{
			$this->folder = $input['uri'];
			
			$realpath1 = realpath(DIR.$our_folder);
			$realpath2 = realpath(DIR.$input['uri']);
			
			$strlen1 = strlen($realpath1);
			$strlen2 = strlen($realpath2);
		}

		return array(
			'leftpanel'		=> $this->leftPanel(),
			'addressbar'	=> $this->addressBar(),
			'mainfield'		=> $this->mainField(),
			'uri'			=> $this->folder
		);
	}
	
	
	
	function ajaxDelDir($input) 
	{
		if ($handle = opendir ( DIR.$input['dir'] )) 
		{
			while (false !== ($file = readdir ( $handle ))) 
			{
				if (is_file(DIR.$input['dir'].'/'.$file)) 
				{
					unlink(DIR.$input['dir'].'/'.$file);
				}
			}
			closedir ($handle);
		}
		
		
		if(!rmdir(DIR.$input['dir']))
		{
			return array('error'=>'Error delete a folder, perhaps it has not deleted directories!');
		} 
		else return array();
	}
	
	
	function ajaxDelFile($input) 
	{
		$error = array();
		$input['src'] = array_filter($input['src']);
		$input['src'] = array_unique($input['src']);
			
		foreach ($input['src'] as $key=>$val) 
		{
			$uri = str_replace("//", "/", $input['src'][$key]);
			if(is_file(DIR.$this->mydir2.$uri))
			{
				unlink(DIR.$this->mydir2.$uri);
				
			} 
			else 
			{	
				if(is_file(DIR.$this->mydir2.$uri) && $key != '$family')
				{
					$error[] = 'Fichier '.DIR.$this->mydir2.$uri.' non trouve! '.DIR.$this->mydir2.$uri;
				}
				else{
					//$error[] = 'Fichier '.DIR.$this->mydir2.$uri.' non trouve! '.DIR.$this->mydir2.$uri;
				}
			}
		}
		
		if(count($error) > 0) 
		{
			return array('error'=>implode(', ',$error));
		}
		else 
		{
			return array();
		}
	}
	
	function ajaxMakeFolder($input) 
	{
		if(trim($input['name']) == '') return array('error' => 'Not a name');
		
		//return array('error' => DIR.$this->mydir2.'/'.$input['name'].'  '.is_dir(DIR.$this->mydir2.'/'.$input['name']));
		if(is_dir(DIR.$this->mydir2.'/'.$input['name']) || mkdir(DIR.$this->mydir2.'/'.$input['name']))
		{
			return array(); 
		}
		else 
		{
			array('error' => 'Unable to create a folder');
		}
	}
}

?>