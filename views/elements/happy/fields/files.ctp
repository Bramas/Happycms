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

//echo $form->input($name,array('type'=>'hidden'));

	$form->input($name,array('type'=>'hidden'));

echo '<div id="'.$form->domId().'">';

if(isset($this->data[$this->data['Happy']['model_name']][$lang][$name]) && is_array($this->data[$this->data['Happy']['model_name']][$lang][$name]))
{
	$idx=0;
	foreach($this->data[$this->data['Happy']['model_name']][$lang][$name] as $img)
	{
		echo '<input name="data['.$this->data['Happy']['model_name'].']['.$lang.']['.$name.'][]" uid="'.$name.'-'.$lang.'-'.($idx++).'" type="hidden" value="'.$img.'" />';
	}

}	
echo '<input class="empty" name="data['.$this->data['Happy']['model_name'].']['.$lang.']['.$name.'][]" type="hidden" />';
echo "</div>";

echo '<div class="filesImagesContainter" domid="'.$form->domId().'" extension="'.$ExtensionName.'" id="'.$form->domId().'Img">';

echo '<div class="item empty">'.$html->image('/files/uploads/'.$ExtensionName.'/',
array('class'=>'empty')
)
.'<div class="actions"><span class="delete">X</span></div></div>';

if(isset($this->data[$this->data['Happy']['model_name']][$lang][$name]) && is_array($this->data[$this->data['Happy']['model_name']][$lang][$name]))
{

	$idx=0;
	foreach($this->data[$this->data['Happy']['model_name']][$lang][$name] as $img)
	{
		echo '<div uid="'.$name.'-'.$lang.'-'.($idx++).'" class="item" title="'.$img.'">'.$html->image('/files/uploads/'.$ExtensionName.'/'.$img,array('title'=>$img)).'<div class="actions"><span class="delete">X</span></div></div>';
	}

}	

echo '<div class="clear"></div></div>';

?>

<iframe width="700" src="<?php echo $html->url('/admin/files/upload_form/'.$ExtensionName.'/'.$name.'/'.$form->domId().'/'.$lang.'/multiple',true); ?>" frameborder="0"></iframe>

<?php
}
?>

<script type="text/javascript">
	
	$(function(){
		


	})

</script>