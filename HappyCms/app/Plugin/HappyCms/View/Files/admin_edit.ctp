<?php
if(preg_match('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/',$filename))
{
	echo $this->Html->link(	
					preg_replace('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/','$1',$filename).'/ << Retour'
,					array(
'controller'=>'files',
'action'=>'index',
'admin'=>true,
preg_replace('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/','$1',$filename)));
}
else
{
	echo $this->Html->link(	
					'<< Retour'
,					array(
'controller'=>'files',
'action'=>'index',
'admin'=>true,
));
}


 
echo $this->Form->create('File',array('action'=>'save'));
?>
<textarea name="data[File][content]" rows="30" class="no-editor" style="font-size: 12px;">
<?php
	foreach($File as $line)
	{
	    echo($line);
	}

?>
</textarea>
<?php 
echo $this->Form->input('filename',array('type'=>'hidden','value'=>$filename));
echo $this->Form->end('Save');
?>