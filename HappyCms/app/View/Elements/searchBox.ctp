<?php
$class=isset($class)?$class:'';
echo $this->Form->create('Content',array('action'=>'search','class'=>$class));

echo $this->Form->input('input',array('label'=>false,'id'=>'SearchInput','placeholder'=>'Rechercher'));

echo $this->Form->end();
/* 'value'=>'Rechercher',
?>
<script type="text/javascript">
	
	$(function(){
		$('#SearchInput').focus(function()
		{
			if($(this).val()=='Rechercher')
			{
				$(this).val('');
			}
		});
		$('#SearchInput').blur(function()
		{
			if($(this).val()=='')
			{
				$(this).val('Rechercher');
			}
		});
	});

</script>
<?php */