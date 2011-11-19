<?php
/** upload a file
 *  the form must be created with the element admin_create_form_item with 'file'=>true
 *
 *@param string $name the fieldName
 *@param string $options['label'] the label
 *@param array $filters title=>extensions use to filter the files
 *
 *@example echo $this->element('happy/fields/file',array(
 *						      'filters'=>array(	'Images'=>'jpg,png,gif',
 *						      				'Zip files'=>'zip'),
 *						      'name'=>'img1',
 *						      'options'=>array('label'=>'Image :')));
 *
 * 
 *
 **/



if(empty($this->fileFormLoaded)) {

    trigger_error ("The form is not enable for file, please pass 'file'=>true to the element that create the form.", E_USER_WARNING );
}
else {

if(empty($options['label']))
{
    $options['label']=$name;
}

$lang = $form->langField;
echo '<input name="data[Delete]['.$ExtensionName.']['.$name.'-'.$lang.']" type="hidden" id="input-delete-file-'.$name.'-'.$lang.'" />';
echo $form->input($name,array('type'=>'hidden','id'=>'input-file-'.$name.'-'.$lang));

?>
<div class="input file">
<label><?php echo $options['label']; ?></label>
<div id="file-<?php echo $name.'-'.$lang ?>">
<div  class="a pickfiles"><?php echo $html->image('/img/boxupload32.png'); ?><a id="file-<?php echo $name.'-'.$lang ?>-pickfiles" >A partir de mon ordinateur</a></div>
<div  class="a distantfiled"><?php echo $html->image('/img/Slideshow.png'); ?><a  id="file-<?php echo $name.'-'.$lang ?>-distantfiled" >Images existantes</a></div>
<div class="image"></div>
<div class="wait">Chargement...</div>
<div class="actions"><span class="action delete">delete</span></div>
<div class="clear"></div>
</div>
</div>
<?php if(empty($this->data['Content']['id']))
{
    $this->data['Content']['id'] = null ;
} ?>



<script type="text/javascript">
// Custom example logic




/*
$(function() {



    var filters=[<?php
    if(isset($filters))
    {
	$f='';
    foreach($filters as $title=>$ext)
    {
	$f .= ',{title : "'.$title.'", extensions : "'.$ext.'"}
	';
    }
    echo substr($f,1);
    }
    ?>];
    var fileName = <?php 
    $modelName = $this->data['Happy']['model_name'];
    echo empty($this->data[$modelName][$lang][$name])?'null':"'".$this->data[$modelName][$lang][$name]."'"; ?>;
    var file = new fileField(<?php echo "'".$ExtensionName."','".$name."','".$lang."','".$this->data[$modelName]['id']."'"; ?>,fileName,filters);
    
    $('#file-<?php echo $name.'-'.$lang ?> .plupload').mouseover(function(){
	$(this).parent().find('div.a').first().mouseover();
    });
    $('#file-<?php echo $name.'-'.$lang ?> .plupload').mouseout(function(){
	$(this).parent().find('div.a').first().mouseout();
    });
    $('div.a').mouseover(function(){
	$(this).addClass('hover');
    });
    $('div.a').mouseout(function(){
	$(this).removeClass('hover');
    });
    
});*/
</script>




<?php



}
?>