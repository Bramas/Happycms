<?php
$options = empty($options)?array():$options;

$model = $this->data['Happy']['model_name'] ;
$this->happy_temp_model_name=$model;

$form->create($model.'-Category');



//$options = array_merge(array(),(array)$options);
if(empty($ExtensionName) && !empty($this->data['Happy']['ExtensionName']))
{
    $ExtensionName = $this->data['Happy']['ExtensionName'];
}
$threaded = $this->requestAction('/admin/categories/threaded/'.$ExtensionName.'/'.$this->data['Happy']['lang_form']);
echo '<div class="happy-category"><div class="category-'.$threaded[0]['Category']['id'].'">';

$this->happy_category_form=true;


if(empty($threaded))
{
    echo "Il n'y a aucune catégorie de crée<br/>";
}


echo  $this->element('happy/fields/category/node',array('nodes'=>$threaded[0]['children']));
echo  $this->element('happy/fields/category/node');


echo  $html->link('Creer une nouvelle catégorie',array(
                                                       'controller'=>'category',
                                                       'action'=>'add',
                                                       $ExtensionName),
                    array('class'=>'create-category'));



$form->end();

$form->create($model);
//echo $form->input('category',$options);

?></div></div>

<script type="text/javascript">
	

	$(function(){

		function docheck()
		{
			var d = $(this).parent().parent().parent().children('input:checkbox');
			if(d.is(':checked') || d.length<1)
			{
				return;
			}
			$('body').append('dochecked parent '+d.length+'<br>');
			d.attr('checked','checked');
			docheck.apply(d);

		}
		function uncheck()
		{
			var d = $(this).parent().children('ul').children('li').children('input:checkbox');
			if(!d.is(':checked') || d.length<1)
			{
				return;
			}
			$('body').append('unchecked children<br>');
			d.attr('checked','');
			uncheck.apply(d);
		}

		$('.happy-category input').live('change',function(){
			
			if($(this).is(':checked'))
			{
				docheck.apply(this);
			}
			else
			{
				uncheck.apply(this);
			}
		});

	})
</script>