<?php
if(empty($label))
{
    $label=$name;
}
if(empty($model))
{
	if(!empty($this->request->data['Happy']) && !empty($this->request->data['Happy']['model_name']))
	{
		$model = $this->request->data['Happy']['model_name'];
	}
	else
	{
		$model='';
	}
}

$lang = $this->Form->langField;
$input = $this->Form->input($name.'.',array('type'=>'hidden'));
$this->Form->input($name,array('type'=>'text'));

$default = empty($this->request->data[$this->request->data['Happy']['model_name']][$lang][$name])?0:$this->request->data[$this->request->data['Happy']['model_name']][$lang][$name];

echo '<div class="media" id="'.$this->Form->domId().'Container">';
echo '<label for="'.$this->Form->domId().'">'.$label.'</label>';
//echo $input;



if(isset($this->request->data[$model][$lang][$name]) && is_array($this->request->data[$model][$lang][$name]))
{
	$idx=0;
	foreach($this->request->data[$model][$lang][$name] as $img)
	{
		echo '<input name="data['.$model.']['.$lang.']['.$name.'][]" uid="'.$name.'-'.$lang.'-'.($idx++).'" type="hidden" value="'.$img.'" />';
	}

}	
echo '<input class="empty" name="data['.$model.']['.$lang.']['.$name.'][]" type="hidden" />';


echo '<div class="filesImagesContainter">';

echo '<div class="item empty">'.$this->Html->image('/files/uploads/'.$ExtensionName.'/',
array('class'=>'empty')
)
.'<div class="actions"><span class="delete">X</span></div></div>';
$checkList='0';
if(isset($this->request->data[$model][$lang][$name]) && is_array($this->request->data[$model][$lang][$name]))
{

	$idx=0;
$checkList='';
	foreach($this->request->data[$model][$lang][$name] as $img)
	{
		$checkList.=','.$img;
		echo '<div uid="'.$name.'-'.$lang.'-'.($idx++).'" class="item" title="'.$img.'">'.$this->element('displayFile',array('plugin'=>'media','url'=>$img,'title'=>$img)).'<div class="actions"><span class="delete">X</span></div></div>';
	}
	$checkList=substr($checkList, 1);

}	

echo '<div class="clear"></div></div>';









//echo $this->element('displayFile',array('plugin'=>'media','id'=>$default));
echo $this->element('linkToExplorer',array('label'=>'Ajouter une image','plugin'=>'media','checkList'=>$checkList,'multiple'=>true,'id'=>$default,'domId'=>$this->Form->domId()));
?>

</div>