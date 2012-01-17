<?php

if(empty($options['label']))
{
    $options['label']=$name;
}


/*if(empty($this->fileFormLoaded)) {

    trigger_error ("The form is not enable for file, please pass 'file'=>true to the element that create the form.", E_USER_WARNING );
}
else */{

if(!isset($options['label']))
{
    $options['label']=$name;
}

$lang = empty($this->Form->langField)?Configure::read('Config.language'):$this->Form->langField;

echo $this->Form->input($name,array('type'=>'hidden'));

echo '<input name="data[Delete]['.$ExtensionName.'][]" type="hidden" id="'.$this->Form->domId().'Delete" />';

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


$default = empty($this->request->data[$model][$lang][$name])?(empty($this->request->data[$model][$name])?'':$this->request->data[$model][$name]):$this->request->data[$model][$lang][$name];
?>

<iframe width="700" src="<?php echo $this->Html->url('/admin/files/upload_form/'.$ExtensionName.'/'.$name.'/'.$this->Form->domId().'/'.$lang.'/'.$default,true); ?>" frameborder="0"></iframe>

<?php 
/*
<iframe width="700" src="<?php echo $this->Html->url('/js/plupload/examples/custom.html',true); ?>" frameborder="0"></iframe>
*/
 
}
?>