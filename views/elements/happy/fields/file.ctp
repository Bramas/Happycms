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

$lang = $form->langField;
echo $form->input($name,array('type'=>'hidden'));

echo '<input name="data[Delete]['.$ExtensionName.'][]" type="hidden" id="'.$form->domId().'Delete" />';

$default = empty($this->data[$this->data['Happy']['model_name']][$lang][$name])?'':$this->data[$this->data['Happy']['model_name']][$lang][$name];
?>

<iframe width="700" src="<?php echo $html->url('/admin/files/upload_form/'.$ExtensionName.'/'.$name.'/'.$form->domId().'/'.$lang.'/'.$default,true); ?>" frameborder="0"></iframe>

<?php 
/*
<iframe width="700" src="<?php echo $html->url('/js/plupload/examples/custom.html',true); ?>" frameborder="0"></iframe>
*/
 
}
?>