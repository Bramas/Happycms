<?php
if(empty($multiple))
{
	$multiple = false;
}
if(empty($default))
{
	$default = 0;
}
if(empty($domId))
{
	$domId = '0';
}
if(empty($label))
{
	$label = 'Choisir un autre fichier';
}
if(empty($checkList))
{
	$checkList = '0';
}
echo $this->Html->link($label,'#',array('class'=>'media-link-to-explorer','checkList'=>$checkList,'dom_id'=>$domId,'multiple'=>$multiple?'1':'0','media_id'=>$default,'contextExtension'=>$ExtensionName));

$contextId = empty($contextId) ?  'null':$contextId ;

?>
<script type="text/javascript">
$(function(){
	

})
</script>