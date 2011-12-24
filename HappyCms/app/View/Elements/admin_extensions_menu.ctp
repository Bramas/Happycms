<ul id="extensions-menu">
<?php

	foreach(Configure::read('Extensions') as $extensionName => $extension)
	{
		if(!empty($extension['menu']))
		{
			if(!empty($extension['menu']['title']))
			{

				echo '<li>'.$this->Html->link($extension['menu']['title'],array('controller'=>$extensionName,'action'=>'menu_index','admin'=>true)).
				'</li>';
			}
		}
	}
	?>
</ul>