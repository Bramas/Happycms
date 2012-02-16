
<?php

echo $this->Form->create('Menu',array('action'=>'affect_module','url'=>'/admin/menus/affect_module'));
echo '<div class="masonry">';
echo $this->Form->input('extension',array('type'=>'hidden'));//,'options'=>$extensions));
foreach($extensions as $group=>$extension)
{

	echo '<div class="extension-group"><h3>'.$group.'</h3>';
	foreach($extension as $val => $item)
	{
		echo '<div class="extension-item" value="'.$val.'"><div class="icon">'.$this->Html->image($item['mainIcon']).'</div><div class="name">'.$item['name'].'</div></div>';
	}
	echo '</div>';
}
echo '</div>';
echo $this->Form->input('id',array('type'=>'hidden','value'=>$id));

echo $this->Form->end('Enregistrer');
echo $this->Html->script('/HappyCms/js/jquery.masonry.min');
?>

<script type="text/javascript">
$(function(){
	$('#MenuAffectModuleForm .extension-item').click(function(){
		$('#MenuExtension').val($(this).attr('value'));
		$('#MenuAffectModuleForm').submit();
	});


	$('#MenuAffectModuleForm .masonry').masonry({
	  	itemSelector: '.extension-group'
	});
});
</script>