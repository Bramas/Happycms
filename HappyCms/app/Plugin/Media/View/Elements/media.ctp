<?php
if(empty($options['label']))
{
    $options['label']=$name;
}


$lang = $this->Form->langField;
$input = $this->Form->input($name,array('type'=>'hidden'));
$this->Form->input($name,array('type'=>'text'));

$default = empty($this->request->data[$this->request->data['Happy']['model_name']][$lang][$name])?0:$this->request->data[$this->request->data['Happy']['model_name']][$lang][$name];

echo '<div class="media" id="'.$this->Form->domId().'Container">';
echo $input;


echo $this->element('displayFile',array('plugin'=>'media','id'=>$default));
echo $this->element('linkToExplorer',array('plugin'=>'media','id'=>$default,'domId'=>$this->Form->domId()));
?>

</div>