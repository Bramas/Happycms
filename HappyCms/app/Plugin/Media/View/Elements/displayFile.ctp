<?php
$url=false;
if(!empty($id))
{
	$url = $this->requestAction('/media/manager/id2url/'.$id);
	
}

if(!empty($url))
{
	echo $this->Html->image($url.'_'.Configure::read('Media.formats.formThumb'));
}
else
{
	echo $this->Html->image('empty',array('style'=>'display:none'));
}


?>