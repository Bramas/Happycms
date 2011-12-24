<?php
$options = empty($options)?array():$options;

$model = $this->request->data['Happy']['model_name'] ;
$this->happy_temp_model_name=$model;

$this->Form->create($model.'-Category');



//$options = array_merge(array(),(array)$options);
if(empty($ExtensionName) && !empty($this->request->data['Happy']['ExtensionName']))
{
    $ExtensionName = $this->request->data['Happy']['ExtensionName'];
}
$threaded = $this->requestAction('/admin/categories/threaded/'.$ExtensionName.'/'.$this->request->data['Happy']['lang_form']);
echo '<div class="happy-category"><div class="category-'.$threaded[0]['Category']['id'].'">';

$this->happy_category_form=true;


if(empty($threaded))
{
    echo "Il n'y a aucune catégorie de crée<br/>";
}


echo  $this->element('happy/fields/category/node',array('nodes'=>$threaded[0]['children']));
echo  $this->element('happy/fields/category/node');


echo  $this->Html->link('Creer une nouvelle catégorie',array(
                                                       'controller'=>'category',
                                                       'action'=>'add',
                                                       $ExtensionName),
                    array('class'=>'create-category'));



$this->Form->end();

$this->Form->create($model);
//echo $this->Form->input('category',$options);

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