<?php 
$class = '';
if(!empty($bodyClass))
{
	$class.=$bodyClass.' ';
}
if(!empty($menuPath))
	foreach($menuPath as $menuPathItem)
	{
		$class.=empty($menuPathItem['Content']['class'])?'':$menuPathItem['Content']['class'].' ';
	}

//$class = Configure::read('Menu.Content.class');


echo '<body class="'.trim($class).'">';