<?php 
echo $this->Html->script('/HappyCms/js/edit_area/edit_area_full'); 
echo $this->Html->script('/HappyCms/js/edit_area/reg_syntax/php'); 
echo $this->Html->script('/HappyCms/js/edit_area/reg_syntax/html'); 
echo $this->Html->script('/HappyCms/js/edit_area/reg_syntax/css'); 
echo $this->Html->script('/HappyCms/js/edit_area/reg_syntax/langs/fr.js'); 


?>
<script language="javascript" type="text/javascript">
editAreaLoader.init({
	id : "fileEdit"		// textarea id
	,syntax: "<?php echo str_replace('ctp','php',preg_replace('/^.*\.([a-zA-Z0-9]{1,5})$/','$1',$filename)) ?>"			// syntax to be uses for highgliting
	,start_highlight: true		// to display with highlight mode on start-up
});
</script>
<?php
if(preg_match('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/',$filename))
{
	echo $this->Html->link(	
					preg_replace('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/','$1',$filename).'/ << Retour'
,'/admin/files/index/'.
preg_replace('/^(.*)\/[^\/]*\.[a-zA-Z]{2,3}$/','$1',$filename));
}
else
{
	echo $this->Html->link(	
					'<< Retour'
,'/admin/files/index'
);
}


 
echo $this->Form->create('File',array('action'=>'save','url'=>'/admin/files/save/'));
?>
<textarea id="fileEdit" name="data[File][content]" rows="30" class="no-editor" style="font-size: 12px;">
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