<?php
if(empty($label))
{
    $label=$name;
}


$lang = $this->Form->langField;
$input = $this->Form->input($name.'.id',array('type'=>'hidden','class'=>'id'));
$inputUrl = $this->Form->input($name.'.url',array('type'=>'hidden','class'=>'url'));
$this->Form->input($name,array('type'=>'text'));

$default = empty($this->request->data[$this->request->data['Happy']['model_name']][$lang][$name])?0:$this->request->data[$this->request->data['Happy']['model_name']][$lang][$name];

echo '<div class="media" id="'.$this->Form->domId().'Container">';
echo '<label for="'.$this->Form->domId().'">'.$label.'</label>';
echo $input;
echo $inputUrl;
echo $this->element('displayFile',array('plugin'=>'media','url'=>$default['url']));
echo $this->element('linkToExplorer',array('plugin'=>'media','checkList'=>$default['url'],'id'=>$default['id'],'domId'=>$this->Form->domId()));
?>

</div>