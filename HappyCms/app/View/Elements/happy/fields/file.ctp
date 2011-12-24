<?php

if(empty($options['label']))
{
    $options['label']=$name;
}


if(empty($this->fileFormLoaded)) {

    trigger_error ("The form is not enable for file, please pass 'file'=>true to the element that create the form.", E_USER_WARNING );
}
else {

if(!isset($options['label']))
{
    $options['label']=$name;
}

$lang = $this->Form->langField;
echo $this->Form->input($name,array('type'=>'hidden'));

echo '<input name="data[Delete]['.$ExtensionName.'][]" type="hidden" id="'.$this->Form->domId().'Delete" />';

$default = empty($this->request->data[$this->request->data['Happy']['model_name']][$lang][$name])?'':$this->request->data[$this->request->data['Happy']['model_name']][$lang][$name];
?>

<iframe width="700" src="<?php echo $this->Html->url('/admin/files/upload_form/'.$ExtensionName.'/'.$name.'/'.$this->Form->domId().'/'.$lang.'/'.$default,true); ?>" frameborder="0"></iframe>

<?php 
/*
<iframe width="700" src="<?php echo $this->Html->url('/js/plupload/examples/custom.html',true); ?>" frameborder="0"></iframe>
*/
 
}
?>