<?php

	$listFolders = array();
	$listFiles = array();

	while (false !== ($entry = $Dir->read())) {
		   
		    if($entry!='.')
		    {
			   	if(is_dir(ROOT.DS.$BaseDir.'/'.$entry))
			   	{
					$listFolders[$entry]=$this->Html->link($entry,array('controller'=>'files','action'=>'index','admin'=>true,$BaseDir.'/'.$entry));
			   		
			   	}
			   	elseif(file_exists(ROOT.DS.$BaseDir.'/'.$entry))
			   	{
			   		$listFiles[$entry]=$this->Html->link($entry,array('controller'=>'files','action'=>'edit','admin'=>true,$BaseDir.'/'.$entry));
			   	}
		    }
		   	

	}

	sort($listFolders);
	sort($listFiles);
	foreach($listFolders as $folder)
	{
		echo '<div class="folder">';
		echo $folder;
		echo '</div>';
	}
	foreach($listFiles as $file)
	{
		echo '<div class="file">';
		echo $file;
		echo '</div>';
	}






	$Dir->close();