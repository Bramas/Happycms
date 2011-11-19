<div id="headPage">
    <div id="banniere"><div id="titreCat"></div></div>
    <div id="menuImage"><?php

    $thumb = false;
    if(!empty($menuPath))
    {
    	foreach($menuPath as $menuPathItem)
		{
			if(!empty($menuPathItem['Content']['thumb']))
			{
				$thumb = $menuPathItem['Content']['thumb'];
			}
		}

		if(!empty($thumb))
		{
			echo $html->image('/files/uploads/menus/'.$thumb.'_105x105');
		}
    }

     
     

      ?></div>
    <?php echo $this->element('breadcrumbs'); ?>
</div>