<?php echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';

function addUrl($nodes,$Html)
{
	

	foreach($nodes as $menu)
	{
		$menu=$menu['Menu'];
		?>

		<url> 
		    <loc><?php echo $Html->url(array(
			    'controller'=>$menu['extension'],
			    'action'=>$menu['view'],
			    'slug'=>$menu['alias'],
			    $menu['params']
			    ),true); ?></loc> 
			    <lastmod><?php echo preg_replace('/( .*)/','',$menu['created']); ?></lastmod>
		</url>

	<?php

		if(!empty($menu['children']))
		{
			addUrl($menu['children'],$Html);
		}
	}

}

addUrl($Menus,$this->Html);

?></urlset>