<?php
if(preg_match('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/',$filename))
{
	echo $html->link(	
					preg_replace('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/','$1',$filename).'/ << Retour'
,					array(
'controller'=>'files',
'action'=>'index',
'admin'=>true,
preg_replace('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/','$1',$filename)));
}
else
{
	echo $html->link(	
					'<< Retour'
,					array(
'controller'=>'files',
'action'=>'index',
'admin'=>true,
));
}


 
echo $form->create('File',array('action'=>'save'));
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
echo $form->input('filename',array('type'=>'hidden','value'=>$filename));
echo $form->end('Save');
?>