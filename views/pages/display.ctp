<?php echo $this->element('headPage'); ?>


<div id="Page">

    <div id="column-left">
	    <div id="menuCat">
	    	<?php echo $this->element('list_menus',array('parent_id'=>Configure::read('Menu.parent_id'))); ?>
	    </div>
	    <div id="rechercher"><?php echo $this->element('searchBox'); ?></div>
		<?php echo $this->element('accesRapide'); ?>
        <?php echo $this->element('agenda'); ?>

    </div>  
    <div id="rightPage">
    <h1 class="mainTitle"><?php echo Configure::read('Menu.Content.title'); ?></h1>

    <?php
    if(!empty($item->empty)):
    
        echo( __("Cette page n'existe pas dans cette langue."));
        
    else:
        echo($item['text']);
       
        endif
    
    ?>

    </div>
</div>