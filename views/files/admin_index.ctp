<?php
	while (false !== ($entry = $Dir->read())) {
		   

		   	if(is_dir(ROOT.DS.$BaseDir.'/'.$entry))
		   	{
		   		echo $this->Html->link($entry,array('controller'=>'files','action'=>'index','admin'=>true,$BaseDir.'/'.$entry))."<br>";
		   	}
		   	elseif(file_exists(ROOT.DS.$BaseDir.'/'.$entry))
		   	{
		   		echo $this->Html->link($entry,array('controller'=>'files','action'=>'edit','admin'=>true,$BaseDir.'/'.$entry))."<br>";
		   	}

	}





	$Dir->close();