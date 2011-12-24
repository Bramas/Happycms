<?php
if(empty($default))
{
	$default = 0;
}
if(empty($domId))
{
	$domId = '0';
}
echo $this->Html->link('Choisir un autre fichier','#',array('class'=>'media-link-to-explorer','dom_id'=>$domId,'media_id'=>$default,'contextExtension'=>$ExtensionName));

$contextId = empty($contextId) ?  'null':$contextId ;

?>
<script type="text/javascript">
$(function(){
	

})
</script>